<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (empty($_SESSION['user_email'])) {
    $_SESSION['flash'] = 'Please login to continue.';
    header('Location: login.php?redirect=' . urlencode('main_menu.php'));
    exit;
}

$firstName = trim($_SESSION['first_name'] ?? ($_SESSION['user_name'] ?? 'Friend'));
if ($firstName === '') {
    $firstName = 'Friend';
}

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$portalCards = [
    [
        'icon' => 'bi-shop',
        'color' => 'danger',
        'title' => 'Products',
        'text'  => 'Browse our beautiful collection of handcrafted bouquets and arrangements.',
        'href'  => 'products.php',
        'cta'   => 'View Products',
        'disabled' => false,
    ],
    [
        'icon' => 'bi-calendar-event',
        'color' => 'primary',
        'title' => 'Workshops',
        'text'  => 'Join our hands-on floral design workshops and learn from the experts.',
        'href'  => 'workshops.php',
        'cta'   => 'View Workshops',
        'disabled' => false,
    ],
    [
        'icon' => 'bi-images',
        'color' => 'success',
        'title' => 'Student Gallery',
        'text'  => 'Get inspired by stunning creations from our workshop participants.',
        'href'  => 'studentworks.php',
        'cta'   => 'View Gallery',
        'disabled' => false,
    ],
    [
        'icon' => 'bi-camera',
        'color' => 'secondary',
        'title' => 'Flower Identifier',
        'text'  => 'Coming soon: Upload a photo to identify flower species instantly.',
        'href'  => '#',
        'cta'   => 'Coming Soon',
        'disabled' => true,
    ],
];
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="author" content="Neng Yi Chieng" />
  <title>Root Flowers - Main Menu</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />
  <link rel="stylesheet" href="./style/style.css" />
</head>
<body class="rf-page">
  <?php include __DIR__ . '/nav.php'; ?>

  <main class="rf-main" id="main-content">
    <div class="container py-5">
      <?php if ($flash): ?>
        <div class="alert alert-success alert-dismissible fade show" role="status">
          <?php echo htmlspecialchars($flash, ENT_QUOTES); ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?>

      <!-- Clean Hero Section -->
      <div class="text-center mb-5">
        <h1 class="display-5 fw-bold mb-2">Welcome, <?php echo htmlspecialchars($firstName, ENT_QUOTES); ?>!</h1>
        <p class="text-muted">Choose a section to explore</p>
      </div>

      <!-- Simplified Cards Grid -->
      <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
        <?php foreach ($portalCards as $index => $card):
          $disabled = !empty($card['disabled']);
          $href = $disabled ? '#' : $card['href'];
        ?>
          <div class="col">
            <?php if (!$disabled): ?>
              <a href="<?php echo htmlspecialchars($href, ENT_QUOTES); ?>" class="text-decoration-none">
            <?php endif; ?>
              <div class="card h-100 text-center border-2 main-menu-card <?php echo $disabled ? 'opacity-50' : ''; ?>" 
                   style="cursor: <?php echo $disabled ? 'not-allowed' : 'pointer'; ?>;">
                <div class="card-body d-flex flex-column align-items-center justify-content-center py-5">
                  <div class="mb-3">
                    <i class="bi <?php echo htmlspecialchars($card['icon'], ENT_QUOTES); ?> text-<?php echo $card['color']; ?>" 
                       style="font-size: 3.5rem;"></i>
                  </div>
                  <h3 class="h5 fw-bold mb-2"><?php echo htmlspecialchars($card['title'], ENT_QUOTES); ?></h3>
                  <p class="text-muted small mb-3"><?php echo htmlspecialchars($card['text'], ENT_QUOTES); ?></p>
                  <span class="badge bg-<?php echo $card['color']; ?>-subtle text-<?php echo $card['color']; ?> px-3 py-2">
                    <?php if ($disabled): ?>
                      <i class="bi bi-clock me-1"></i>
                    <?php endif; ?>
                    <?php echo htmlspecialchars($card['cta'], ENT_QUOTES); ?>
                  </span>
                </div>
              </div>
            <?php if (!$disabled): ?>
              </a>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </main>

    <?php include __DIR__ . '/footer.php'; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Simple hover effect for main menu cards
    document.querySelectorAll('.main-menu-card:not(.opacity-50)').forEach(card => {
      card.addEventListener('mouseenter', function() {
        this.style.transform = 'translateY(-8px)';
        this.style.boxShadow = '0 8px 20px rgba(0,0,0,0.12)';
        this.style.transition = 'all 0.3s ease';
      });
      
      card.addEventListener('mouseleave', function() {
        this.style.transform = 'translateY(0)';
        this.style.boxShadow = '';
      });
    });
  </script>
</body>
</html>

```
