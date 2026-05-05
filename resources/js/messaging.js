import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

function initEcho() {
    const key = import.meta.env.VITE_REVERB_APP_KEY;
    if (!key || typeof window === 'undefined' || window.Echo) {
        return window.Echo ?? null;
    }

    window.Pusher = Pusher;

    const scheme = import.meta.env.VITE_REVERB_SCHEME ?? 'http';
    const forceTLS = scheme === 'https';
    const port = Number(import.meta.env.VITE_REVERB_PORT ?? 8080);

    window.Echo = new Echo({
        broadcaster: 'reverb',
        key,
        wsHost: import.meta.env.VITE_REVERB_HOST ?? window.location.hostname,
        wsPort: forceTLS ? 443 : port,
        wssPort: forceTLS ? 443 : port,
        forceTLS,
        enabledTransports: ['ws', 'wss'],
        authEndpoint: '/broadcasting/auth',
        auth: {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ?? '',
            },
        },
    });

    return window.Echo;
}

function startHeartbeat() {
    const url = document.querySelector('meta[name="messaging-heartbeat-url"]')?.getAttribute('content');
    if (!url) {
        return;
    }

    const ping = () => {
        window.axios?.post(url).catch(() => {});
    };
    ping();
    setInterval(ping, 25000);
}

function updateUnreadBadge() {
    const el = document.querySelector('[data-messaging-unread-badge]');
    if (!el) {
        return;
    }

    const countUrl = document.querySelector('meta[name="messaging-unread-url"]')?.getAttribute('content');
    if (!countUrl || !window.axios) {
        return;
    }

    window.axios.get(countUrl).then((res) => {
        const n = res.data?.unread ?? 0;
        el.textContent = n > 99 ? '99+' : String(n);
        el.style.display = n > 0 ? 'inline-flex' : 'none';
    }).catch(() => {});
}

function enhanceMessagingAttachment(img) {
    if (!img || img.dataset.nxMessagingMediaDone === '1') {
        return;
    }
    const media = img.closest('.msg-media');
    if (!media) {
        return;
    }
    img.dataset.nxMessagingMediaDone = '1';
    const reveal = () => {
        if (media.classList.contains('msg-media--error')) {
            return;
        }
        img.classList.add('msg-attachment--loaded');
        media.classList.remove('msg-media--waiting');
    };

    const tryReveal = () => img.naturalWidth > 0 && (reveal(), true);

    if (tryReveal()) {
        return;
    }

    media.classList.add('msg-media--waiting');

    img.addEventListener('load', () => reveal(), { once: true });
    img.addEventListener(
        'error',
        () => {
            media.classList.remove('msg-media--waiting');
            media.classList.add('msg-media--error');
        },
        { once: true },
    );

    const tick = () => tryReveal();
    requestAnimationFrame(() => {
        tick();
        requestAnimationFrame(tick);
    });
    window.setTimeout(tick, 50);
    window.setTimeout(tick, 250);

    if (typeof img.decode === 'function') {
        img.decode().then(() => tick()).catch(() => {});
    }

    window.setTimeout(() => {
        if (media.classList.contains('msg-media--waiting')) {
            reveal();
        }
    }, 600);
}

function initMessagingAttachments(container) {
    if (!container) {
        return;
    }
    container.querySelectorAll('.msg-media .msg-attachment').forEach(enhanceMessagingAttachment);
}

function initChatPage() {
    const cfg = window.NEXSHOP_MESSAGING;
    if (!cfg || !cfg.conversationId) {
        return;
    }

    const echo = initEcho();
    if (!echo) {
        return;
    }

    const box = document.getElementById('chat-messages');
    const form = document.getElementById('chat-form');
    const input = document.getElementById('chat-input');
    const onlineDot = document.getElementById('chat-online-status');
    const typingHint = document.getElementById('chat-typing');

    const markRead = () => {
        if (cfg.markReadUrl && window.axios) {
            window.axios.post(cfg.markReadUrl).then(() => updateUnreadBadge()).catch(() => {});
        }
    };
    markRead();

    initMessagingAttachments(box);

    const channel = echo.private(`conversation.${cfg.conversationId}`);

    channel.listen('.message.sent', (e) => {
        if (!box || !e.message) {
            return;
        }
        const m = e.message;
        if (document.getElementById(`msg-${m.id}`)) {
            return;
        }
        const mine = Number(m.sender_id) === Number(cfg.currentUserId);
        appendMessage(box, m, mine);
        markRead();
        if (document.hidden && 'Notification' in window && Notification.permission === 'granted') {
            new Notification(m.sender_name || 'Nouveau message', {
                body: m.body || (m.attachment_url ? 'Image' : ''),
            });
        }
    });

    channel.listen('.messages.read', (e) => {
        if (!e.message_ids || !Array.isArray(e.message_ids)) {
            return;
        }
        e.message_ids.forEach((id) => {
            const row = document.querySelector(`#msg-${id} .msg-read`);
            if (row) {
                row.innerHTML = '<i class="fa-solid fa-check-double" style="color:#87cff8"></i>';
            }
        });
    });

    if (input) {
        let typingTimer;
        input.addEventListener('input', () => {
            clearTimeout(typingTimer);
            channel.whisper('typing', { name: cfg.currentUserName });
            typingTimer = setTimeout(() => {}, 2000);
        });
    }

    channel.listenForWhisper('typing', (e) => {
        if (typingHint && e.name) {
            typingHint.textContent = `${e.name} est en train d'écrire…`;
            typingHint.style.display = 'block';
            clearTimeout(typingHint._t);
            typingHint._t = setTimeout(() => {
                typingHint.style.display = 'none';
            }, 2000);
        }
    });

    echo.join('online')
        .here((users) => {
            const on = users.some((u) => Number(u.id) === Number(cfg.otherUserId));
            if (onlineDot) {
                onlineDot.classList.toggle('is-online', on);
            }
        })
        .joining((user) => {
            if (Number(user.id) === Number(cfg.otherUserId) && onlineDot) {
                onlineDot.classList.add('is-online');
            }
        })
        .leaving((user) => {
            if (Number(user.id) === Number(cfg.otherUserId) && onlineDot) {
                onlineDot.classList.remove('is-online');
            }
        });

    if (form) {
        initAttachmentPreview(form);
        form.addEventListener('submit', () => {
            setTimeout(() => updateUnreadBadge(), 500);
        });
    }
}

function initAttachmentPreview(form) {
    const preview = document.getElementById('nx-chat-attach-preview');
    const fileInput = form.querySelector('input[type="file"][name="attachment"]');
    if (!preview || !fileInput) {
        return;
    }

    let objectUrl = null;

    const clear = () => {
        if (objectUrl) {
            URL.revokeObjectURL(objectUrl);
            objectUrl = null;
        }
        preview.innerHTML = '';
        preview.hidden = true;
        fileInput.value = '';
    };

    fileInput.addEventListener('change', () => {
        if (objectUrl) {
            URL.revokeObjectURL(objectUrl);
            objectUrl = null;
        }
        preview.innerHTML = '';
        preview.hidden = true;

        const f = fileInput.files?.[0];
        if (!f) {
            return;
        }
        if (!f.type.startsWith('image/')) {
            window.alert?.('Choisissez une image (JPEG, PNG, GIF ou WebP).');
            fileInput.value = '';
            return;
        }
        const maxBytes = 10 * 1024 * 1024;
        if (f.size > maxBytes) {
            window.alert?.('Image trop volumineuse (maximum 10 Mo).');
            fileInput.value = '';
            return;
        }
        objectUrl = URL.createObjectURL(f);
        preview.hidden = false;

        const img = document.createElement('img');
        img.src = objectUrl;
        img.alt = '';

        const meta = document.createElement('span');
        meta.className = 'nx-chat-attach-meta';
        meta.textContent = f.name;

        const btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'nx-chat-attach-remove';
        btn.textContent = 'Retirer';
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            clear();
        });

        preview.appendChild(img);
        preview.appendChild(meta);
        preview.appendChild(btn);
    });

    form.addEventListener('submit', () => {
        if (!objectUrl) {
            return;
        }
        setTimeout(() => {
            URL.revokeObjectURL(objectUrl);
            objectUrl = null;
        }, 100);
    });
}

function appendMessage(box, m, mine) {
    const wrap = document.createElement('div');
    wrap.id = `msg-${m.id}`;
    wrap.className = `msg-row ${mine ? 'msg-mine' : 'msg-theirs'}`;

    const bubble = document.createElement('div');
    bubble.className = 'msg-bubble';

    const hasBody = !!(m.body && String(m.body).trim());
    const hasAtt = !!m.attachment_url;
    const timeStr = new Date(m.created_at).toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' });

    if (hasAtt && !hasBody) {
        bubble.classList.add('msg-bubble--media-only');
    } else if (hasAtt && hasBody) {
        bubble.classList.add('msg-bubble--caption-media');
    }

    if (hasBody) {
        const p = document.createElement('p');
        p.textContent = m.body;
        bubble.appendChild(p);
    }

    if (hasAtt) {
        const media = document.createElement('a');
        media.href = m.attachment_url;
        media.target = '_blank';
        media.rel = 'noopener noreferrer';
        media.className = `msg-media${hasBody ? ' msg-media--bare' : ''}`;
        media.title = 'Ouvrir l’image en grand';

        const img = document.createElement('img');
        img.src = m.attachment_url;
        img.alt = '';
        img.className = 'msg-attachment';
        img.decoding = 'async';
        img.loading = 'eager';
        if ('fetchPriority' in img) {
            img.fetchPriority = 'high';
        }
        media.appendChild(img);

        if (!hasBody) {
            const overlayMeta = document.createElement('div');
            overlayMeta.className = 'msg-media-meta';
            const overlayTime = document.createElement('span');
            overlayTime.className = 'msg-time';
            overlayTime.textContent = timeStr;
            overlayMeta.appendChild(overlayTime);
            if (mine) {
                const read = document.createElement('span');
                read.className = 'msg-read';
                read.innerHTML = '<i class="fa-solid fa-check"></i>';
                overlayMeta.appendChild(read);
            }
            media.appendChild(overlayMeta);
        }

        bubble.appendChild(media);
        enhanceMessagingAttachment(img);
    }

    if (!hasAtt || hasBody) {
        const meta = document.createElement('div');
        meta.className = 'msg-meta';
        const time = document.createElement('span');
        time.className = 'msg-time';
        time.textContent = timeStr;
        meta.appendChild(time);
        if (mine) {
            const read = document.createElement('span');
            read.className = 'msg-read';
            read.innerHTML = '<i class="fa-solid fa-check"></i>';
            meta.appendChild(read);
        }
        bubble.appendChild(meta);
    }

    wrap.appendChild(bubble);
    box.appendChild(wrap);
    box.scrollTop = box.scrollHeight;
}

if (typeof document !== 'undefined') {
    document.addEventListener('DOMContentLoaded', () => {
        initEcho();
        startHeartbeat();
        updateUnreadBadge();
        setInterval(updateUnreadBadge, 60000);
        initChatPage();
    });
}
