<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$isLoggedIn = !empty($_SESSION['user_email']);
$isAdmin = ($_SESSION['user_type'] ?? 'user') === 'admin';

// Check if current page is an admin page
$currentPage = basename($_SERVER['PHP_SELF']);
$isAdminPage = in_array($currentPage, ['manage_accounts.php', 'manage_flowers.php', 'manage_studentwork.php', 'manage_workshop_reg.php', 'main_menu_admin.php']);

// Admin pages get different nav links
if ($isAdmin && $isAdminPage) {
    $navLinks = [
        ['label' => 'Manage Accounts',   'href' => 'manage_accounts.php',     'requiresLogin' => true],
        ['label' => 'Manage Flowers',    'href' => 'manage_flowers.php',      'requiresLogin' => true],
        ['label' => 'Manage Student Works', 'href' => 'manage_studentwork.php', 'requiresLogin' => true],
        ['label' => 'Manage Workshops',  'href' => 'manage_workshop_reg.php', 'requiresLogin' => true],
    ];
} else {
    $navLinks = [
        ['label' => 'Products',          'href' => 'products.php',     'requiresLogin' => true],
        ['label' => 'Workshops',         'href' => 'workshops.php',    'requiresLogin' => true],
        ['label' => 'Student Works',     'href' => 'studentworks.php', 'requiresLogin' => true],
        ['label' => 'Flower Identifier', 'href' => 'flower.php',       'requiresLogin' => true],
    ];
}
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
            case 'Flower Identifier': $icon = 'flower1'; break;
            case 'Manage Accounts': $icon = 'people'; break;
            case 'Manage Flowers': $icon = 'flower1'; break;
            case 'Manage Workshops': $icon = 'calendar-check'; break;
            case 'Manage Gallery': $icon = 'images'; break;
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
            <?php if ($isAdmin): ?>
              <?php if ($isAdminPage): ?>
                <a class="btn btn-outline-primary btn-sm" href="main_menu.php">
                  <i class="bi bi-house-door me-1"></i>User Portal
                </a>
              <?php else: ?>
                <a class="btn btn-primary btn-sm" href="main_menu_admin.php">
                  <i class="bi bi-shield-lock me-1"></i>Admin Portal
                </a>
              <?php endif; ?>
            <?php endif; ?>
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

