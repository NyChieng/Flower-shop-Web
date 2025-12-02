<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once 'main.php';

// Check if user is logged in and is admin
if (empty($_SESSION['user_email'])) {
    $_SESSION['flash'] = 'Please login to continue.';
    header('Location: login.php');
    exit;
}

if (($_SESSION['user_type'] ?? 'user') !== 'admin') {
    $_SESSION['flash'] = 'Access denied. Admin privileges required.';
    header('Location: main_menu.php');
    exit;
}

$firstName = trim($_SESSION['first_name'] ?? 'Admin');
if ($firstName === '') {
    $firstName = 'Admin';
}

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$adminCards = [
    [
        'icon' => 'bi-people-fill',
        'color' => 'danger',
        'title' => 'Manage User Accounts',
        'text'  => 'Add, edit, or delete user accounts in the system.',
        'href'  => 'manage_accounts.php',
        'cta'   => 'Manage Accounts',
        'disabled' => false,
    ],
    [
        'icon' => 'bi-images',
        'color' => 'primary',
        'title' => 'Manage Student Works',
        'text'  => 'Review and approve or reject student work submissions.',
        'href'  => 'manage_studentwork.php',
        'cta'   => 'Review Submissions',
        'disabled' => false,
    ],
    [
        'icon' => 'bi-calendar-check',
        'color' => 'success',
        'title' => 'Manage Workshop Registrations',
        'text'  => 'Approve or reject workshop registration requests.',
        'href'  => 'manage_workshop_reg.php',
        'cta'   => 'Manage Registrations',
        'disabled' => false,
    ],
    [
        'icon' => 'bi-flower1',
        'color' => 'warning',
        'title' => 'Manage Flower Contributions',
        'text'  => 'Approve or reject user-contributed flower entries.',
        'href'  => 'manage_flowers.php',
        'cta'   => 'Manage Flowers',
        'disabled' => false,
    ],
];
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="author" content="Neng Yi Chieng" />
  <title>Root Flowers - Admin Portal</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />
  <link rel="stylesheet" href="./style/style.css" />
</head>
<body class="rf-page">
  <header class="py-3 border-bottom bg-white shadow-sm">
    <div class="container d-flex justify-content-between align-items-center">
      <a class="d-flex align-items-center gap-2 text-decoration-none" href="index.php">
        <img src="img/logo_1.jpg" alt="Root Flowers logo" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;" />
        <span class="fw-bold fs-5">
          <i class="bi bi-flower1 me-1 text-danger"></i>Root Flowers - Admin Portal
        </span>
      </a>
      <div class="d-flex gap-2">
        <a class="btn btn-outline-dark btn-sm" href="update_profile.php">
          <i class="bi bi-pencil me-2"></i>Edit Profile
        </a>
        <a class="btn btn-danger btn-sm" href="logout.php">
          <i class="bi bi-box-arrow-right me-2"></i>Logout
        </a>
      </div>
    </div>
  </header>

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
        <h1 class="display-5 fw-bold mb-2">
          <i class="bi bi-shield-check me-2 text-danger"></i>Welcome, <?php echo htmlspecialchars($firstName, ENT_QUOTES); ?>!
        </h1>
        <p class="text-muted">Admin Portal - Manage the Root Flowers system</p>
      </div>

      <!-- Simplified Cards Grid -->
      <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
        <?php foreach ($adminCards as $index => $card):
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
