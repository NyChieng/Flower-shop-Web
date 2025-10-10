<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$isLoggedIn = !empty($_SESSION['user_email']);
$navLinks = [
    ['label' => 'Products',      'href' => 'products.php',     'requiresLogin' => true],
    ['label' => 'Workshops',     'href' => 'workshops.php',    'requiresLogin' => true],
    ['label' => 'Student Works', 'href' => 'studentworks.php', 'requiresLogin' => true],
];
?>
<nav class="navbar navbar-expand-lg navbar-light navbar-floral shadow-sm sticky-top" aria-label="Root Flowers navigation">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center gap-2 brand-logo-link" href="index.php" title="Return to Home">
      <img src="img/logo_1.jpg" alt="Root Flowers logo" class="brand-logo" />
      <span class="brand-text">
        <i class="bi bi-flower1 me-1 flower-icon"></i>Root Flowers
      </span>
    </a>

    <button class="navbar-toggler floral-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#rfNav"
            aria-controls="rfNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="rfNav">
      <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
        <?php foreach ($navLinks as $link):
          $locked = $link['requiresLogin'] && !$isLoggedIn;
          $target = $link['href'];
          $href   = $locked ? 'login.php?redirect=' . urlencode($target) : $target;
          $icon = '';
          switch($link['label']) {
            case 'Products': $icon = 'shop'; break;
            case 'Workshops': $icon = 'calendar-event'; break;
            case 'Student Works': $icon = 'images'; break;
          }
        ?>
          <li class="nav-item">
            <a class="nav-link<?php echo $locked ? ' text-muted' : ''; ?>" href="<?php echo htmlspecialchars($href); ?>"<?php echo $locked ? ' aria-disabled="true"' : ''; ?>>
              <?php if ($icon): ?><i class="bi bi-<?php echo $icon; ?> me-1"></i><?php endif; ?>
              <?php echo htmlspecialchars($link['label']); ?><?php echo $locked ? ' <i class="bi bi-lock-fill"></i>' : ''; ?>
            </a>
          </li>
        <?php endforeach; ?>

        <li class="nav-divider d-none d-lg-block" role="separator" aria-hidden="true"></li>

        <li class="nav-item ms-lg-1 d-flex gap-2 flex-wrap">
          <?php if ($isLoggedIn): ?>
            <a class="btn btn-outline-dark btn-sm" href="update_profile.php">
              <i class="bi bi-pencil-square me-1"></i>Edit Profile
            </a>
            <a class="btn btn-danger btn-sm" href="logout.php">
              <i class="bi bi-box-arrow-right me-1"></i>Logout
            </a>
          <?php else: ?>
            <a class="btn btn-outline-dark btn-sm" href="login.php">
              <i class="bi bi-box-arrow-in-right me-1"></i>Login
            </a>
            <a class="btn btn-dark btn-sm" href="registration.php">
              <i class="bi bi-person-plus me-1"></i>Register
            </a>
          <?php endif; ?>
        </li>
      </ul>
    </div>
  </div>
</nav>

