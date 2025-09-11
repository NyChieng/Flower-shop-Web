<?php // footer with WhatsApp + Instagram + improved layout ?>
<footer class="pt-5 pb-4 bg-light border-top">
  <div class="container">
    <div class="row g-4">
      <div class="col-md-6">
        <div class="d-flex align-items-center gap-2 mb-2">
          <img src="img/logo_1.jpg" alt="Root Flowers" class="brand-logo-sm" />
          <h5 class="fw-bold mb-0">Root Flowers</h5>
        </div>
        <p class="mb-3">
          A cozy florist in Kuching crafting heartfelt bouquets and bespoke arrangements for every occasion.
        </p>

        <div class="d-flex flex-wrap gap-2">
          <a class="btn btn-success" target="_blank" rel="noopener"
             href="https://api.whatsapp.com/send?phone=60143399709" aria-label="WhatsApp">
            💬 WhatsApp
          </a>
          <!-- TODO: replace with your actual handle -->
          <a class="btn btn-outline-dark" target="_blank" rel="noopener"
             href="https://instagram.com/rootflowers" aria-label="Instagram">
            📷 Instagram
          </a>
        </div>
      </div>

      <div class="col-md-3">
        <h6 class="fw-semibold mb-2">Visit Us</h6>
        <ul class="list-unstyled mb-0">
          <li>Kuching, Sarawak</li>
          <li>Mon–Sat: 10:00–19:00</li>
          <li>Sun: 11:00–17:00</li>
        </ul>
      </div>

      <div class="col-md-3">
        <h6 class="fw-semibold mb-2">Links</h6>
        <ul class="list-unstyled mb-0">
          <li><a class="link-secondary text-decoration-none" href="about.php">About</a></li>
          <li><a class="link-secondary text-decoration-none" href="index.php">Home</a></li>
        </ul>
      </div>
    </div>

    <hr class="my-4" />

    <div class="foot-bottom">
      <span>© <?php echo date('Y'); ?> Root Flowers. All rights reserved.</span>
      <div class="links">
        <a class="link-secondary text-decoration-none" href="privacy.php">Privacy</a>
        <a class="link-secondary text-decoration-none" href="terms.php">Terms</a>
      </div>
    </div>
  </div>
</footer>
