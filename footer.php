<?php // Footer with contact and navigation ?>
<footer class="pt-5 pb-4 bg-light border-top mt-auto">
  <div class="container">
    <div class="row g-4">
      <div class="col-md-6 col-lg-4">
        <div class="d-flex align-items-center gap-2 mb-3">
          <img src="img/logo_1.jpg" alt="Root Flowers" class="brand-logo-sm" />
          <h5 class="fw-bold mb-0"><i class="bi bi-flower1 me-1"></i>Root Flowers</h5>
        </div>
        <p class="mb-3 text-muted">
          A premium artisan florist in Kuching, specializing in handcrafted bouquets, bespoke floral arrangements, and inspiring workshops that celebrate the beauty of nature.
        </p>

        <div class="d-flex flex-wrap gap-2">
          <a class="btn btn-success btn-sm" target="_blank" rel="noopener"
             href="https://api.whatsapp.com/send?phone=60143399709" aria-label="WhatsApp">
            <i class="bi bi-whatsapp"></i> WhatsApp
          </a>
          <a class="btn btn-outline-dark btn-sm" target="_blank" rel="noopener"
             href="https://www.instagram.com/root.flowersss?igsh=Ym1yZ2Vqejd0Mzc3" aria-label="Instagram">
            <i class="bi bi-instagram"></i> Instagram
          </a>
        </div>
      </div>

      <div class="col-md-3 col-lg-3">
        <h6 class="fw-semibold mb-3"><i class="bi bi-geo-alt-fill me-2 text-danger"></i>Visit Us</h6>
        <ul class="list-unstyled mb-0 text-muted">
          <li class="mb-2"><i class="bi bi-shop me-2"></i>Kuching, Sarawak</li>
          <li class="mb-2"><i class="bi bi-clock me-2"></i>Mon&ndash;Sat: 10:00&ndash;19:00</li>
          <li class="mb-2"><i class="bi bi-clock me-2"></i>Sun: 11:00&ndash;17:00</li>
          <li class="mb-2"><i class="bi bi-telephone me-2"></i>+60 14-339 9709</li>
        </ul>
      </div>

      <div class="col-md-3 col-lg-2">
        <h6 class="fw-semibold mb-3"><i class="bi bi-link-45deg me-2 text-danger"></i>Quick Links</h6>
        <ul class="list-unstyled mb-0">
          <li class="mb-2"><a class="link-secondary text-decoration-none" href="index.php"><i class="bi bi-house me-2"></i>Home</a></li>
          <li class="mb-2"><a class="link-secondary text-decoration-none" href="main_menu.php"><i class="bi bi-grid me-2"></i>Main Menu</a></li>
          <li class="mb-2"><a class="link-secondary text-decoration-none" href="products.php"><i class="bi bi-shop me-2"></i>Products</a></li>
          <li class="mb-2"><a class="link-secondary text-decoration-none" href="studentworks.php"><i class="bi bi-images me-2"></i>Gallery</a></li>
          <li class="mb-2"><a class="link-secondary text-decoration-none" href="about.php"><i class="bi bi-info-circle me-2"></i>About</a></li>
        </ul>
      </div>

      <div class="col-md-12 col-lg-3">
        <h6 class="fw-semibold mb-3"><i class="bi bi-envelope me-2 text-danger"></i>Get in Touch</h6>
        <p class="text-muted mb-3" style="font-size: 0.9rem;">
          Have questions? We'd love to hear from you!
        </p>
        <div class="d-flex flex-column gap-2">
          <a class="btn btn-outline-dark btn-sm" href="mailto:rootflowers@example.com">
            <i class="bi bi-envelope me-2"></i>Email Us
          </a>
          <a class="btn btn-outline-dark btn-sm" href="workshop_reg.php">
            <i class="bi bi-calendar-plus me-2"></i>Register Workshop
          </a>
        </div>
      </div>
    </div>

    <hr class="my-4" />

    <div class="text-center">
      <span class="text-muted">
        <i class="bi bi-c-circle me-1"></i><?php echo date('Y'); ?> Root Flowers. All rights reserved. 
        <span class="d-none d-md-inline">| Handcrafted with <i class="bi bi-heart-fill text-danger"></i> in Kuching</span>
      </span>
    </div>
  </div>
</footer>

<!-- Back to Top Button -->
<button class="back-to-top" id="backToTop" aria-label="Back to top" title="Back to top">
  <i class="bi bi-arrow-up"></i>
</button>

<script>
// Back to top button functionality
const backToTopButton = document.getElementById('backToTop');

if (backToTopButton) {
  window.addEventListener('scroll', function() {
    if (window.pageYOffset > 300) {
      backToTopButton.classList.add('visible');
    } else {
      backToTopButton.classList.remove('visible');
    }
  });

  backToTopButton.addEventListener('click', function() {
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  });
}
</script>
