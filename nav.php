<?php
// nav.php — shared top navigation; blocks features if not logged in
if (session_status() === PHP_SESSION_NONE) { session_start(); }
$isLoggedIn = !empty($_SESSION['user_email']);
?>
<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom sticky-top">
  <div class="container">
    <a class="navbar-brand fw-bold" href="index.php">🌷 Root Flowers</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#rfNav" aria-controls="rfNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="rfNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <!-- Features only accessible when logged in -->
        <li class="nav-item">
          <a class="nav-link<?php echo $isLoggedIn ? '' : ' disabled'; ?>"
             href="main_menu.php"
             <?php if (!$isLoggedIn) echo 'tabindex="-1" aria-disabled="true" data-require-login="1"'; ?>>
            Menu
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link<?php echo $isLoggedIn ? '' : ' disabled'; ?>"
             href="products.php"
             <?php if (!$isLoggedIn) echo 'tabindex="-1" aria-disabled="true" data-require-login="1"'; ?>>
            Products
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link<?php echo $isLoggedIn ? '' : ' disabled'; ?>"
             href="workshops.php"
             <?php if (!$isLoggedIn) echo 'tabindex="-1" aria-disabled="true" data-require-login="1"'; ?>>
            Workshops
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link<?php echo $isLoggedIn ? '' : ' disabled'; ?>"
             href="studentworks.php"
             <?php if (!$isLoggedIn) echo 'tabindex="-1" aria-disabled="true" data-require-login="1"'; ?>>
            Student Works
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link<?php echo $isLoggedIn ? '' : ' disabled'; ?>"
             href="profile.php"
             <?php if (!$isLoggedIn) echo 'tabindex="-1" aria-disabled="true" data-require-login="1"'; ?>>
            Profile
          </a>
        </li>
      </ul>

      <!-- quick search only for index grid (harmless if empty) -->
      <form class="d-flex me-3" role="search" onsubmit="return false;">
        <input id="q" class="form-control" type="search" placeholder="Search bouquets…" aria-label="Search">
      </form>

      <div class="d-flex align-items-center gap-2">
        <?php if ($isLoggedIn): ?>
          <a class="btn btn-outline-secondary" href="logout.php">Logout</a>
        <?php else: ?>
          <a class="btn btn-outline-secondary" href="login.php">Login</a>
          <a class="btn btn-dark" href="registration.php">Register</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>
