<?php

namespace App\Http\Controllers\Web;

use App\Events\MessageSent;
use App\Events\MessagesRead;
use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use App\Notifications\NewChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MessagingController extends Controller
{
    public function heartbeat(Request $request)
    {
        $request->user()->update(['last_seen_at' => now()]);

        return response()->json(['ok' => true]);
    }

    /**
     * Sert une pièce jointe depuis le disque local (storage/app/public) après contrôle d’accès.
     */
    public function showAttachment(Request $request, Message $message)
    {
        $user = $request->user();
        abort_unless($message->attachment_path, 404);

        $conversation = $message->conversation;
        abort_unless($conversation && $conversation->involvesUser($user->id), 403);

        $disk = Storage::disk('public');
        abort_unless($disk->exists($message->attachment_path), 404);

        $mimeRaw = $disk->mimeType($message->attachment_path);
        $mime = is_string($mimeRaw) ? $mimeRaw : 'application/octet-stream';
        abort_unless(str_starts_with($mime, 'image/'), 404);

        $fullPath = $disk->path($message->attachment_path);
        abort_unless(is_file($fullPath), 404);

        return response()->file($fullPath, [
            'Content-Type' => $mime,
            'Cache-Control' => 'private, max-age=86400',
        ]);
    }

    public function unreadCount(Request $request)
    {
        $uid = $request->user()->id;
        $unread = Message::query()
            ->whereHas('conversation', fn ($q) => $q->forUser($uid))
            ->where('sender_id', '!=', $uid)
            ->whereNull('read_at')
            ->count();

        return response()->json(['unread' => $unread]);
    }

    public function buyerIndex(Request $request)
    {
        $user = $request->user();
        abort_unless($user->isClient(), 403);

        $conversations = Conversation::query()
            ->forUser($user->id)
            ->with(['buyer:id,nom,last_seen_at', 'seller:id,nom,last_seen_at', 'latestMessage'])
            ->withCount(['messages as unread_count' => function ($q) use ($user) {
                $q->where('sender_id', '!=', $user->id)->whereNull('read_at');
            }])
            ->orderByDesc('last_message_at')
            ->orderByDesc('updated_at')
            ->get();

        return view('buyer.messages.index', compact('conversations'));
    }

    public function buyerShow(Request $request, Conversation $conversation)
    {
        $user = $request->user();
        abort_unless($user->isClient(), 403);
        abort_unless($conversation->involvesUser($user->id), 403);

        $conversation->load(['buyer:id,nom,last_seen_at', 'seller:id,nom,last_seen_at']);
        $messages = $conversation->messages()->with('sender:id,nom')->orderBy('created_at')->get();
        $other = $conversation->otherParty($user);
        abort_unless($other, 404);

        $conversations = Conversation::query()
            ->forUser($user->id)
            ->with(['latestMessage'])
            ->withCount(['messages as unread_count' => function ($q) use ($user) {
                $q->where('sender_id', '!=', $user->id)->whereNull('read_at');
            }])
            ->orderByDesc('last_message_at')
            ->orderByDesc('updated_at')
            ->get();

        return view('buyer.messages.show', compact('conversation', 'messages', 'other', 'conversations'));
    }

    public function buyerStart(Request $request, User $seller)
    {
        $buyer = $request->user();
        abort_unless($buyer->isClient(), 403);

        if (! $seller->isVendeur()) {
            abort(404);
        }

        if (! $seller->estVendeurValide()) {
            return redirect()
                ->back()
                ->with('error', 'Ce vendeur doit avoir un compte validé avant de pouvoir recevoir des messages.');
        }

        if ($seller->sellerSubscriptionLocked()) {
            return redirect()
                ->back()
                ->with('error', 'Ce vendeur ne peut pas recevoir de messages pour le moment. Réessayez après renouvellement de son abonnement.');
        }

        abort_if($seller->id === $buyer->id, 403);

        $conversation = Conversation::firstOrCreate(
            [
                'buyer_id' => $buyer->id,
                'seller_id' => $seller->id,
            ],
            ['last_message_at' => null]
        );

        return redirect()->route('buyer.messages.show', $conversation);
    }

    public function sellerIndex(Request $request)
    {
        $user = $request->user();
        abort_unless($user->isVendeur(), 403);

        $conversations = Conversation::query()
            ->forUser($user->id)
            ->with(['buyer:id,nom,last_seen_at', 'seller:id,nom,last_seen_at', 'latestMessage'])
            ->withCount(['messages as unread_count' => function ($q) use ($user) {
                $q->where('sender_id', '!=', $user->id)->whereNull('read_at');
            }])
            ->orderByDesc('last_message_at')
            ->orderByDesc('updated_at')
            ->get();

        $boutique = $user->boutique;
        $vendeurProfil = $user->vendeurProfil;

        return view('seller.messages.index', compact('conversations', 'boutique', 'vendeurProfil'));
    }

    public function sellerShow(Request $request, Conversation $conversation)
    {
        $user = $request->user();
        abort_unless($user->isVendeur(), 403);
        abort_unless($conversation->involvesUser($user->id), 403);

        $conversation->load(['buyer:id,nom,last_seen_at', 'seller:id,nom,last_seen_at']);
        $messages = $conversation->messages()->with('sender:id,nom')->orderBy('created_at')->get();
        $other = $conversation->otherParty($user);
        abort_unless($other, 404);
        $vendeurProfil = $user->vendeurProfil;
        $boutique = $user->boutique;

        $conversations = Conversation::query()
            ->forUser($user->id)
            ->with(['latestMessage'])
            ->withCount(['messages as unread_count' => function ($q) use ($user) {
                $q->where('sender_id', '!=', $user->id)->whereNull('read_at');
            }])
            ->orderByDesc('last_message_at')
            ->orderByDesc('updated_at')
            ->get();

        return view('seller.messages.show', compact('conversation', 'messages', 'other', 'vendeurProfil', 'boutique', 'conversations'));
    }

    public function storeMessage(Request $request, Conversation $conversation)
    {
        $user = $request->user();
        abort_unless($conversation->involvesUser($user->id), 403);

        $validated = $request->validate([
            'body' => ['nullable', 'string', 'max:5000'],
            'attachment' => [
                'nullable',
                'file',
                'image',
                'mimes:jpeg,jpg,png,gif,webp',
                'max:10240', // ko — 10 Mo
            ],
        ]);

        if (empty($validated['body']) && ! $request->hasFile('attachment')) {
            return back()->with('error', 'Écrivez un message ou joignez une image.');
        }

        if ($user->isVendeur() && $user->sellerSubscriptionLocked()) {
            return redirect()
                ->route('vendeur.abonnement.index')
                ->with('error', 'Abonnement requis pour envoyer des messages.');
        }

        $path = null;
        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('message-attachments', 'public');
        }

        $message = $conversation->messages()->create([
            'sender_id' => $user->id,
            'body' => $validated['body'] ?? null,
            'attachment_path' => $path,
        ]);

        $conversation->update(['last_message_at' => $message->created_at]);

        $recipient = $conversation->otherParty($user);
        if ($recipient) {
            $recipient->notify(new NewChatMessage($message->load('sender'), $conversation));
        }

        event(new MessageSent($message->fresh(['sender'])));

        if ($request->wantsJson()) {
            return response()->json([
                'message' => [
                    'id' => $message->id,
                    'conversation_id' => $message->conversation_id,
                    'sender_id' => $message->sender_id,
                    'body' => $message->body,
                    'attachment_url' => $message->attachmentUrl(),
                    'read_at' => null,
                    'created_at' => $message->created_at->toIso8601String(),
                ],
            ]);
        }

        return back();
    }

    public function markRead(Request $request, Conversation $conversation)
    {
        $user = $request->user();
        abort_unless($conversation->involvesUser($user->id), 403);

        $ids = $conversation->messages()
            ->where('sender_id', '!=', $user->id)
            ->whereNull('read_at')
            ->pluck('id')
            ->all();

        if ($ids !== []) {
            $conversation->messages()->whereIn('id', $ids)->update(['read_at' => now()]);
            event(new MessagesRead($conversation->id, $user->id, $ids));
        }

        return response()->json(['ok' => true, 'marked' => count($ids)]);
    }
}
