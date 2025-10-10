<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (empty($_SESSION['user_email'])) {
    $_SESSION['flash'] = 'Please login to continue.';
    header('Location: login.php?redirect=' . urlencode('studentworks.php'));
    exit;
}
$firstName = $_SESSION['first_name'] ?? ($_SESSION['user_name'] ?? 'Friend');

// Simple static student works data
$works = [
    [
        'id' => '1',
        'title' => 'Romantic Rose Bouquet',
        'student' => 'Sarah Chen',
        'workshop' => 'Hand-tied Bouquet Masterclass',
        'date' => 'March 2024',
        'image' => 'img/products/product_2.jpg',
        'description' => 'A stunning hand-tied bouquet featuring deep red roses and gerberas with elegant wrapping.'
    ],
    [
        'id' => '2',
        'title' => 'Garden Fresh Arrangement',
        'student' => 'Emily Wong',
        'workshop' => 'Modern Tablescapes Intensive',
        'date' => 'February 2024',
        'image' => 'img/products/product_4.jpg',
        'description' => 'Beautiful blue hydrangeas mixed with daisies and roses creating a garden-fresh look.'
    ],
    [
        'id' => '3',
        'title' => 'Pastel Dream',
        'student' => 'Jessica Tan',
        'workshop' => 'Hand-tied Bouquet Masterclass',
        'date' => 'March 2024',
        'image' => 'img/products/product_1.jpg',
        'description' => 'Soft yellow gerberas combined with lilac roses and chamomile for a cheerful display.'
    ],
    [
        'id' => '4',
        'title' => 'Elegant White & Black',
        'student' => 'Michael Lee',
        'workshop' => 'Modern Tablescapes Intensive',
        'date' => 'January 2024',
        'image' => 'img/products/product_12.jpg',
        'description' => 'Sophisticated monochrome arrangement with white gerberas and roses in sleek black wrap.'
    ],
    [
        'id' => '5',
        'title' => 'Vibrant Summer Mix',
        'student' => 'Amanda Lim',
        'workshop' => 'Hand-tied Bouquet Masterclass',
        'date' => 'February 2024',
        'image' => 'img/products/product_8.jpg',
        'description' => 'Bright pink gerberas and carnations with leafy accents bringing summer energy.'
    ],
    [
        'id' => '6',
        'title' => 'Classic Snow & Ruby',
        'student' => 'David Chong',
        'workshop' => 'Modern Tablescapes Intensive',
        'date' => 'January 2024',
        'image' => 'img/products/product_3.jpg',
        'description' => 'Timeless combination of baby\'s breath and ruby red roses creating romantic elegance.'
    ],
];
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="author" content="Neng Yi Chieng" />
  <title>Root Flowers - Student Works</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />
  <link rel="stylesheet" href="./style/style.css" />
</head>
<body class="rf-page">
    <?php include __DIR__ . '/nav.php'; ?>

  <main class="rf-main">
    <div class="container py-5">
      <!-- Header -->
      <div class="text-center mb-5">
        <span class="badge bg-success-subtle text-success px-3 py-2 mb-3">
          <i class="bi bi-images me-2"></i>Student Gallery
        </span>
        <h1 class="display-5 fw-bold mb-3">Student Works Showcase</h1>
        <p class="lead text-muted">Explore beautiful creations from our talented workshop participants</p>
      </div>

      <!-- Cards Grid using Bootstrap -->
      <div class="row g-4">
        <?php foreach ($works as $index => $work): ?>
          <div class="col-md-6 col-lg-4">
            <a href="studentwork_detail.php?id=<?php echo urlencode($work['id']); ?>" class="text-decoration-none">
              <div class="card h-100 border-0 shadow-sm student-card-hover" style="transition: all 0.3s ease;">
                <img src="<?php echo htmlspecialchars($work['image']); ?>" 
                     class="card-img-top" 
                     alt="<?php echo htmlspecialchars($work['title']); ?>"
                     style="height: 280px; object-fit: cover;">
                <div class="card-body">
                  <div class="d-flex gap-2 mb-3">
                    <span class="badge bg-success-subtle text-success">
                      <i class="bi bi-star-fill me-1"></i>Featured
                    </span>
                    <span class="badge bg-secondary-subtle text-secondary">
                      <?php echo htmlspecialchars($work['date']); ?>
                    </span>
                  </div>
                  
                  <h3 class="h5 card-title fw-bold mb-2 text-dark"><?php echo htmlspecialchars($work['title']); ?></h3>
                  
                  <div class="mb-2">
                    <small class="text-muted">
                      <i class="bi bi-person-circle me-1"></i><?php echo htmlspecialchars($work['student']); ?>
                    </small>
                  </div>
                  <div class="mb-3">
                    <small class="text-muted">
                      <i class="bi bi-mortarboard-fill me-1"></i><?php echo htmlspecialchars($work['workshop']); ?>
                    </small>
                  </div>
                  
                  <p class="card-text text-muted small">
                    <?php echo htmlspecialchars(substr($work['description'], 0, 100) . '...'); ?>
                  </p>
                  
                  <div class="text-danger fw-semibold small">
                    View Details <i class="bi bi-arrow-right ms-1"></i>
                  </div>
                </div>
              </div>
            </a>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </main>
  <?php include __DIR__ . '/footer.php'; ?>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Smooth card animations and hover effects
    document.addEventListener('DOMContentLoaded', function() {
      const cards = document.querySelectorAll('.student-card-hover');
      
      // Entrance animation
      cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        
        setTimeout(() => {
          card.style.transition = 'all 0.6s ease';
          card.style.opacity = '1';
          card.style.transform = 'translateY(0)';
        }, index * 100);
      });

      // Smooth hover effect
      cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
          this.style.transform = 'translateY(-8px) scale(1.02)';
          this.style.boxShadow = '0 12px 24px rgba(0,0,0,0.15)';
        });
        
        card.addEventListener('mouseleave', function() {
          this.style.transform = 'translateY(0) scale(1)';
          this.style.boxShadow = '';
        });
      });
    });
  </script>
</body>
</html>





