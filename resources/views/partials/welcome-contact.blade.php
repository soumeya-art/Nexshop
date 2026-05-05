<section class="dm-info reveal" id="contact" style="background:var(--bg)">
  <div class="dm-info-sub">Nous contacter</div>
  <h2 class="dm-info-title"><i class="fa-solid fa-envelope"></i> Contact</h2>
  <div class="dm-contact-grid">
    <form class="dm-contact-form" id="contact-form" onsubmit="return handleContact(event)">
      <input type="text" name="nom" id="ct-nom" placeholder="Votre nom complet" required>
      <input type="email" name="email" id="ct-email" placeholder="Votre adresse email" required>
      <input type="text" name="sujet" id="ct-sujet" placeholder="Sujet">
      <textarea rows="5" name="message" id="ct-message" placeholder="Votre message…" required></textarea>
      <button type="submit" id="ct-btn"><i class="fa-solid fa-paper-plane"></i> Envoyer</button>
    </form>
    <div id="ct-success" style="display:none;background:rgba(34,197,94,.1);border:1px solid rgba(34,197,94,.3);border-radius:10px;padding:20px;color:#22c55e;font-size:14px;font-weight:600;align-items:center;gap:8px">
      <i class="fa-solid fa-circle-check" style="font-size:18px"></i> <span>Message envoyé ! Nous vous répondrons rapidement.</span>
    </div>
    <div class="dm-contact-info">
      <div class="dm-ci">
        <div class="dm-ci-ico"><i class="fa-solid fa-location-dot"></i></div>
        <div><strong>Adresse</strong>Djibouti-ville, République de Djibouti</div>
      </div>
      <div class="dm-ci">
        <div class="dm-ci-ico"><i class="fa-solid fa-phone"></i></div>
        <div><strong>Téléphone</strong>+253 77 44 78 73</div>
      </div>
      <div class="dm-ci">
        <div class="dm-ci-ico"><i class="fa-solid fa-envelope"></i></div>
        <div><strong>Email</strong>nexshop.dj@gmail.com</div>
      </div>
      <div class="dm-ci">
        <div class="dm-ci-ico"><i class="fa-solid fa-clock"></i></div>
        <div><strong>Horaires</strong>Samedi – Jeudi : 8h – 20h</div>
      </div>
      <div style="display:flex;gap:10px;margin-top:8px">
        <a href="#" class="dm-icon" style="width:38px;height:38px;border:1px solid var(--border);border-radius:10px"><i class="fa-brands fa-facebook-f"></i></a>
        <a href="#" class="dm-icon" style="width:38px;height:38px;border:1px solid var(--border);border-radius:10px"><i class="fa-brands fa-instagram"></i></a>
        <a href="#" class="dm-icon" style="width:38px;height:38px;border:1px solid var(--border);border-radius:10px"><i class="fa-brands fa-tiktok"></i></a>
        <a href="#" class="dm-icon" style="width:38px;height:38px;border:1px solid var(--border);border-radius:10px"><i class="fa-brands fa-whatsapp"></i></a>
      </div>
    </div>
  </div>
</section>
