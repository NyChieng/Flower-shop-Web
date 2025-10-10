<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$loggedIn  = !empty($_SESSION['user_email']);
$firstName = trim($_SESSION['first_name'] ?? ($_SESSION['user_name'] ?? ''));
if ($firstName === '') {
    $firstName = 'there';
}

// Featured products with proper names
$photos = [
    ['src' => 'img/products/product_1.jpg', 'name' => 'Pastel Sunrise', 'desc' => 'Soft yellow gerbera, lilac rose & chamomile'],
    ['src' => 'img/products/product_2.jpg', 'name' => 'Crimson Serenade', 'desc' => 'Bold red gerbera & roses with deep accents'],
    ['src' => 'img/products/product_3.jpg', 'name' => 'Snow & Ruby', 'desc' => 'Baby\'s breath cloud with ruby roses'],
    ['src' => 'img/products/product_4.jpg', 'name' => 'Meadow Cloud', 'desc' => 'Blue hydrangea mix with daisies & roses'],
    ['src' => 'img/products/product_5.jpg', 'name' => 'Aqua Bloom', 'desc' => 'Pastel pink roses with blue hydrangea'],
    ['src' => 'img/products/product_6.jpg', 'name' => 'Scarlet Muse', 'desc' => 'Compact red mix with calla & gerbera'],
    ['src' => 'img/products/product_7.jpg', 'name' => 'Blush & Daisy', 'desc' => 'Blush roses with daisies in sky wrap'],
    ['src' => 'img/products/product_8.jpg', 'name' => 'Peachy Cheer', 'desc' => 'Pink gerbera & carnations with leafy pops'],
    ['src' => 'img/products/product_9.jpg', 'name' => 'Petal Whisper', 'desc' => 'Pastel pinks with gerbera, roses & daisies'],
];

// Randomize and show 3
shuffle($photos);
$photos = array_slice($photos, 0, 3);
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="author" content="Neng Yi Chieng">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Root Flowers - Home</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style/style.css">
  </head>
  <body>

    <header class="hero hero-with-image py-5 animate-hero">
      <div class="hero-overlay"></div>
      <div class="container position-relative">
        <div class="row">
          <div class="col-lg-7">
            <div class="glass p-4 p-md-5 rounded-4">
              <span class="badge text-bg-light text-uppercase mb-3">Root Flowers</span>
              <h1 class="display-5 brand-mark mb-3">
                <?php echo $loggedIn
                    ? 'Welcome back, ' . htmlspecialchars($firstName) . '!'
                    : 'Root Flowers'; ?>
              </h1>
              <p class="lead mb-4">
                <?php if ($loggedIn): ?>
                  Ready for your next workshop or bouquet? Explore our fresh collection of artisan arrangements, handcrafted with love from locally-sourced blooms.
                <?php else: ?>
                  Root Flowers is Kuching's premier artisan florist. We create stunning bouquets, bespoke floral arrangements, and inspiring workshops that bring the beauty of nature into your life.
                <?php endif; ?>
              </p>

              <div class="cta-row d-flex flex-wrap gap-3">
                <a class="btn btn-dark btn-lg btn-cta px-4" href="main_menu.php">
                  <i class="bi bi-flower1 me-2"></i><?php echo $loggedIn ? 'Open Main Menu' : 'Explore Our Collection'; ?>
                </a>
                <?php if ($loggedIn): ?>
                  <a class="btn btn-outline-secondary btn-lg" href="logout.php"><i class="bi bi-box-arrow-right me-2"></i>Logout</a>
                <?php else: ?>
                  <a class="btn btn-outline-dark btn-lg" href="login.php"><i class="bi bi-box-arrow-in-right me-2"></i>Login</a>
                  <a class="btn btn-outline-secondary btn-lg" href="registration.php"><i class="bi bi-person-plus me-2"></i>Register</a>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Scroll Down Indicator -->
        <div class="text-center mt-4">
          <a href="#main-content" class="scroll-indicator">
            <i class="bi bi-chevron-down"></i>
          </a>
        </div>
      </div>
    </header>

    <main class="py-5" id="main-content">
      <div class="container">
        <div class="section-head fade-in-section">
          <h2 class="h3 mb-0 fw-bold text-dark"><?php echo $loggedIn ? 'Featured Fresh Bouquets' : 'Our Signature Arrangements'; ?></h2>
          <div class="chips">
            <span class="chip"><i class="bi bi-flower2 me-1"></i>Hand-tied</span>
            <span class="chip"><i class="bi bi-clock me-1"></i>Same-day</span>
            <span class="chip"><i class="bi bi-geo-alt me-1"></i>Sarawak-grown</span>
          </div>
        </div>

        <div id="grid" class="row g-4 justify-content-center">
          <?php foreach ($photos as $p): ?>
            <div class="col-sm-6 col-md-4">
              <article class="card photo-card h-100 hover-lift">
                <?php if ($p['src']): ?>
                  <div class="img-wrap position-relative">
                    <img src="<?php echo htmlspecialchars($p['src']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($p['name']); ?>">
                    <div class="heart-icon" onclick="toggleHeart(this)" title="Add to favorites">
                      <i class="bi bi-heart"></i>
                    </div>
                  </div>
                <?php else: ?>
                  <div class="img-wrap placeholder-tile d-flex align-items-center justify-content-center">
                    <span class="placeholder-text">Image coming soon</span>
                  </div>
                <?php endif; ?>
                <div class="card-body">
                  <h3 class="h6 card-title mb-2 fw-bold" title="<?php echo htmlspecialchars($p['name']); ?>">
                    <?php echo htmlspecialchars($p['name']); ?>
                  </h3>
                  <p class="text-muted mb-0" style="font-size: 0.875rem;">
                    <?php echo htmlspecialchars($p['desc'] ?? 'Fresh & Beautiful'); ?>
                  </p>
                </div>
              </article>
            </div>
          <?php endforeach; ?>
        </div>

        <!-- Why Choose Us Section -->
        <div class="row mt-5 pt-4">
          <div class="col-12">
            <h2 class="h3 text-center mb-4 fw-bold text-dark fade-in-section">Why Choose Root Flowers?</h2>
          </div>
          <div class="col-md-4 mb-4">
            <div class="text-center feature-box">
              <div class="mb-3 feature-icon">
                <i class="bi bi-award-fill text-danger" style="font-size: 3rem;"></i>
              </div>
              <h3 class="h5 fw-bold">Premium Quality</h3>
              <p class="text-muted">Hand-selected fresh flowers from local Sarawak farms, ensuring the highest quality and freshness for every arrangement.</p>
            </div>
          </div>
          <div class="col-md-4 mb-4">
            <div class="text-center feature-box">
              <div class="mb-3 feature-icon">
                <i class="bi bi-truck text-danger" style="font-size: 3rem;"></i>
              </div>
              <h3 class="h5 fw-bold">Same-Day Delivery</h3>
              <p class="text-muted">Order before 2 PM and receive your beautiful bouquet the same day anywhere in Kuching. Perfect for last-minute surprises!</p>
            </div>
          </div>
          <div class="col-md-4 mb-4">
            <div class="text-center feature-box">
              <div class="mb-3 feature-icon">
                <i class="bi bi-palette-fill text-danger" style="font-size: 3rem;"></i>
              </div>
              <h3 class="h5 fw-bold">Custom Designs</h3>
              <p class="text-muted">Our expert florists work with you to create personalized arrangements that perfectly match your vision and occasion.</p>
            </div>
          </div>
        </div>
      </div>
    </main>

    <!-- Simple Footer - Integrated -->
    <footer class="bg-light border-top mt-5 py-5">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-md-4 text-center text-md-start mb-4 mb-md-0">
            <div class="d-flex align-items-center justify-content-center justify-content-md-start gap-2">
              <img src="img/logo_1.jpg" alt="Root Flowers" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;" />
              <span class="fw-bold fs-5">Root Flowers</span>
            </div>
            <p class="text-muted mt-2 mb-0 small">Handcrafted with <i class="bi bi-heart-fill text-danger"></i> in Kuching</p>
          </div>
          
          <div class="col-md-8">
            <div class="d-flex flex-wrap gap-3 justify-content-center justify-content-md-end">
              <a href="https://github.com/NyChieng/Flower-shop-Web" target="_blank" rel="noopener" 
                 class="btn btn-outline-dark btn-sm d-flex align-items-center gap-2 index-footer-btn">
                <i class="bi bi-github fs-5"></i>
                <span>GitHub</span>
              </a>
              <a href="profile.php" 
                 class="btn btn-outline-danger btn-sm d-flex align-items-center gap-2 index-footer-btn">
                <i class="bi bi-person-circle fs-5"></i>
                <span>Profile</span>
              </a>
              <a href="about.php" 
                 class="btn btn-outline-primary btn-sm d-flex align-items-center gap-2 index-footer-btn">
                <i class="bi bi-info-circle fs-5"></i>
                <span>About</span>
              </a>
            </div>
          </div>
        </div>
        
        <hr class="my-4" />
        
        <div class="text-center text-muted small">
          <span>&copy; <?php echo date('Y'); ?> Root Flowers. All rights reserved.</span>
        </div>
      </div>
    </footer>

    <!-- Back to Top Button -->
    <button class="back-to-top" id="backToTop" aria-label="Back to top" title="Back to top">
      <i class="bi bi-arrow-up"></i>
    </button>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
      // Smooth entrance animations
      document.addEventListener('DOMContentLoaded', function() {
        // Fade in elements on load
        const fadeElements = document.querySelectorAll('.photo-card, .btn, .glass');
        fadeElements.forEach((el, index) => {
          el.style.opacity = '0';
          el.style.transform = 'translateY(20px)';
          setTimeout(() => {
            el.style.transition = 'all 0.6s ease';
            el.style.opacity = '1';
            el.style.transform = 'translateY(0)';
          }, index * 100);
        });
      });

      // Smooth heart toggle with animation
      function toggleHeart(element) {
        element.classList.toggle('active');
        const icon = element.querySelector('i');
        
        // Add bounce animation
        element.style.transform = 'scale(1.3)';
        setTimeout(() => {
          element.style.transform = 'scale(1)';
        }, 200);
        
        if (element.classList.contains('active')) {
          icon.classList.remove('bi-heart');
          icon.classList.add('bi-heart-fill');
          element.style.color = '#dc3545';
        } else {
          icon.classList.remove('bi-heart-fill');
          icon.classList.add('bi-heart');
          element.style.color = '';
        }
      }

      // Smooth hover effect for product cards
      document.querySelectorAll('.photo-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
          this.style.transform = 'translateY(-10px) scale(1.03)';
          this.style.boxShadow = '0 15px 35px rgba(0,0,0,0.2)';
          this.style.transition = 'all 0.4s cubic-bezier(0.4, 0, 0.2, 1)';
        });
        
        card.addEventListener('mouseleave', function() {
          this.style.transform = 'translateY(0) scale(1)';
          this.style.boxShadow = '';
        });
      });

      // Smooth scroll with progress indicator
      let scrollProgress = 0;
      window.addEventListener('scroll', function() {
        const windowHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        scrollProgress = (window.scrollY / windowHeight) * 100;
        
        // Optional: Add a progress bar at the top
        if (!document.querySelector('.scroll-progress')) {
          const progressBar = document.createElement('div');
          progressBar.className = 'scroll-progress';
          progressBar.style.cssText = 'position:fixed;top:0;left:0;height:3px;background:linear-gradient(to right, #d95c7a, #ff8fa3);z-index:9999;transition:width 0.2s ease;';
          document.body.appendChild(progressBar);
        }
        document.querySelector('.scroll-progress').style.width = scrollProgress + '%';
      });

      // Smooth scroll for anchor links
      document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
          e.preventDefault();
          const target = document.querySelector(this.getAttribute('href'));
          if (target) {
            target.scrollIntoView({
              behavior: 'smooth',
              block: 'start'
            });
          }
        });
      });

      // Add ripple effect to buttons
      document.querySelectorAll('.btn').forEach(button => {
        button.addEventListener('click', function(e) {
          const ripple = document.createElement('span');
          const rect = this.getBoundingClientRect();
          const size = Math.max(rect.width, rect.height);
          const x = e.clientX - rect.left - size / 2;
          const y = e.clientY - rect.top - size / 2;
          
          ripple.style.cssText = `
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.6);
            width: ${size}px;
            height: ${size}px;
            left: ${x}px;
            top: ${y}px;
            pointer-events: none;
            animation: ripple-effect 0.6s ease-out;
          `;
          
          this.style.position = 'relative';
          this.style.overflow = 'hidden';
          this.appendChild(ripple);
          
          setTimeout(() => ripple.remove(), 600);
        });
      });

      // Add CSS for ripple animation
      const style = document.createElement('style');
      style.textContent = `
        @keyframes ripple-effect {
          from {
            transform: scale(0);
            opacity: 1;
          }
          to {
            transform: scale(2);
            opacity: 0;
          }
        }
      `;
      document.head.appendChild(style);

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

      // Smooth hover effect for footer buttons
      document.querySelectorAll('.index-footer-btn').forEach(btn => {
        btn.addEventListener('mouseenter', function() {
          this.style.transform = 'translateY(-2px)';
          this.style.transition = 'all 0.3s ease';
        });
        
        btn.addEventListener('mouseleave', function() {
          this.style.transform = 'translateY(0)';
        });
      });
    </script>
  </body>
</html>
