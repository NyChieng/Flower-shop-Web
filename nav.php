<?php
// nav.php — elegant brand navbar with login-gated links
if (session_status() === PHP_SESSION_NONE) { session_start(); }
$isLoggedIn = !empty($_SESSION['user_email']);
?>
<nav class="navbar navbar-expand-lg navbar-floral shadow-sm sticky-top" aria-label="Main navigation">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center gap-2" href="index.php">
      <img src="img/logo_1.jpg" alt="Root Flowers logo" class="brand-logo" />
      <span class="brand-text">Root Flowers</span>
    </a>

    <button class="navbar-toggler floral-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#rfNav" aria-controls="rfNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="rfNav">
      <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
        <li class="nav-item">
          <a class="nav-link<?php echo $isLoggedIn ? '' : ' disabled'; ?>"
             href="main_menu.php" <?php if (!$isLoggedIn) echo 'data-require-login="1"'; ?>>Menu</a>
        </li>
        <li class="nav-item">
          <a class="nav-link<?php echo $isLoggedIn ? '' : ' disabled'; ?>"
             href="products.php" <?php if (!$isLoggedIn) echo 'data-require-login="1"'; ?>>Products</a>
        </li>
        <li class="nav-item">
          <a class="nav-link<?php echo $isLoggedIn ? '' : ' disabled'; ?>"
             href="workshops.php" <?php if (!$isLoggedIn) echo 'data-require-login="1"'; ?>>Workshops</a>
        </li>
        <li class="nav-item">
          <a class="nav-link<?php echo $isLoggedIn ? '' : ' disabled'; ?>"
             href="studentworks.php" <?php if (!$isLoggedIn) echo 'data-require-login="1"'; ?>>Student Works</a>
        </li>

        <li class="nav-divider d-none d-lg-block" role="separator" aria-hidden="true"></li>

        <li class="nav-item ms-lg-1">
          <?php if ($isLoggedIn): ?>
            <a class="btn btn-outline-dark btn-sm" href="logout.php" aria-label="Logout">Logout</a>
          <?php else: ?>
            <a class="btn btn-outline-dark btn-sm" href="login.php" aria-label="Login">Login</a>
            <a class="btn btn-dark btn-sm ms-1" href="registration.php" aria-label="Register">Register</a>
          <?php endif; ?>
        </li>
      </ul>
    </div>
  </div>
</nav>
