<?php
require_once __DIR__ . '/auth.php';
startSessionIfNeeded();

$isLoggedIn = currentUser() !== null;
$navLinks = [
    ['label' => 'Home',          'href' => 'index.php',        'requiresLogin' => false],
    ['label' => 'Main Menu',     'href' => 'main_menu.php',    'requiresLogin' => true],
    ['label' => 'Products',      'href' => 'products.php',     'requiresLogin' => true],
    ['label' => 'Workshops',     'href' => 'workshops.php',    'requiresLogin' => true],
    ['label' => 'Student Works', 'href' => 'studentworks.php', 'requiresLogin' => true],
    ['label' => 'Profile',       'href' => 'profile.php',      'requiresLogin' => true],
];
?>
<nav class="navbar navbar-expand-lg navbar-light navbar-floral shadow-sm" aria-label="Root Flowers navigation">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center gap-2" href="index.php">
      <img src="img/logo_1.jpg" alt="Root Flowers logo" class="brand-logo" />
      <span class="brand-text">Root Flowers</span>
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
        ?>
          <li class="nav-item">
            <a class="nav-link<?php echo $locked ? ' text-muted' : ''; ?>" href="<?php echo htmlspecialchars($href); ?>"<?php echo $locked ? ' aria-disabled="true"' : ''; ?>>
              <?php echo htmlspecialchars($link['label']); ?><?php echo $locked ? ' (login)' : ''; ?>
            </a>
          </li>
        <?php endforeach; ?>

        <li class="nav-divider d-none d-lg-block" role="separator" aria-hidden="true"></li>

        <li class="nav-item ms-lg-1 d-flex gap-2">
          <?php if ($isLoggedIn): ?>
            <a class="btn btn-outline-dark btn-sm" href="logout.php">Logout</a>
          <?php else: ?>
            <a class="btn btn-outline-dark btn-sm" href="login.php">Login</a>
            <a class="btn btn-dark btn-sm" href="registration.php">Register</a>
          <?php endif; ?>
        </li>
      </ul>
    </div>
  </div>
</nav>

