<?php
require_once __DIR__ . '/auth.php';
startSessionIfNeeded();
$isLoggedIn = currentUser() !== null;
$firstName = $_SESSION['first_name'] ?? ($_SESSION['user_name'] ?? 'Friend');
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$heroHighlights = [
    ['value' => '24+', 'caption' => 'Fresh stems featured this month.'],
    ['value' => '6',   'caption' => 'Workshops running weekly.'],
    ['value' => 'A2',  'caption' => 'Flower ID feature in progress.'],
];

$portalCards = [
    [
        'label' => 'Catalog',
        'icon' => 'P',
        'title' => 'Products',
        'text'  => 'Explore bouquet categories, sample arrangements, and pricing notes.',
        'tag'   => 'Catalogue',
        'meta'  => 'Browse bouquets anytime',
        'href'  => 'products.php',
        'cta'   => 'Go to products',
    ],
    [
        'label' => 'Events',
        'icon' => 'W',
        'title' => 'Workshops',
        'text'  => 'Review workshop types, availability, venues, and logistics details.',
        'tag'   => 'Workshops',
        'meta'  => 'Hands-on sessions every month',
        'href'  => 'workshops.php',
        'cta'   => 'View workshops',
    ],
    [
        'label' => 'Profile',
        'icon' => 'U',
        'title' => 'Student profile',
        'text'  => 'Check your student declaration and update personal information.',
        'tag'   => 'Profile',
        'meta'  => 'Keeps your Swinburne details current',
        'href'  => 'update_profile.php',
        'cta'   => 'View profile',
    ],
    [
        'label' => 'Showcase',
        'icon' => 'S',
        'title' => 'Student works',
        'text'  => 'Celebrate achievements from our workshop students and gather inspiration.',
        'tag'   => 'Showcase',
        'meta'  => 'Gallery updates weekly',
        'href'  => 'studentworks.php',
        'cta'   => 'Browse student works',
    ],
    [
        'label' => 'Innovation',
        'icon' => 'AI',
        'title' => 'Flower name lookup',
        'text'  => 'Upload a bloom photo and let our Assignment 2 engine identify varieties and pricing.',
        'tag'   => 'Coming soon',
        'meta'  => 'Preview only',
        'href'  => '#',
        'cta'   => 'Coming soon',
        'disabled' => true,
    ],
];
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>Root Flowers - Main Menu</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />
  <link rel="stylesheet" href="./style/style.css" />
</head>
<body class="rf-page">
  <?php include __DIR__ . '/nav.php'; ?>

  <main class="rf-main" id="main-content">
    <?php if ($flash): ?>
      <div class="rf-alert" role="status"><?php echo htmlspecialchars($flash); ?></div>
    <?php endif; ?>

    <section class="rf-hero" aria-labelledby="portal-title">
      <div class="rf-hero-content">
        <span class="rf-pill">Root Flowers Portal</span>
        <h1 id="portal-title" class="rf-title"><?php echo $isLoggedIn ? "Welcome back, " . htmlspecialchars($firstName) : "Explore Root Flowers"; ?></h1>
        <p class="rf-subtitle">
          Manage products, plan workshops, celebrate student creations, and preview upcoming flower identification tools.
        </p>

        <div class="rf-hero-actions">
          <a class="rf-button" href="<?php echo $isLoggedIn ? 'products.php' : 'login.php?redirect=products.php'; ?>">Browse products</a>
          <a class="rf-button rf-button-outline" href="<?php echo $isLoggedIn ? 'workshops.php' : 'login.php?redirect=workshops.php'; ?>">Plan a workshop</a>
        </div>

        <?php if (!$isLoggedIn): ?>
          <p class="rf-card-text">Login or register to use the quick links below.</p>
        <?php endif; ?>
        <ul class="rf-hero-list">
          <li>Curated bouquets and seasonal bundles refreshed monthly.</li>
          <li>Hands-on workshop schedules with clear pricing.</li>
          <li>Student showcase area plus upcoming digital tools.</li>
        </ul>
      </div>

      <div class="rf-hero-visual" aria-hidden="true">
        <?php foreach ($heroHighlights as $highlight): ?>
          <div class="rf-hero-visual-card">
            <span class="rf-hero-stat"><?php echo htmlspecialchars($highlight['value']); ?></span>
            <p><?php echo htmlspecialchars($highlight['caption']); ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    </section>

    <section class="rf-section" aria-labelledby="quick-actions">
      <header class="rf-section-header">
        <h2 id="quick-actions" class="rf-section-title">Quick actions</h2>
        <p class="rf-section-text">Jump into the areas you need for Assignment&nbsp;1 &amp; 2 deliverables.</p>
      </header>

      <div class="rf-grid">
        <?php foreach ($portalCards as $card):
          $disabled = !empty($card['disabled']);
          $locked = !$disabled && !$isLoggedIn;
          $href = $disabled ? '#' : ($locked ? 'login.php?redirect=' . urlencode($card['href']) : $card['href']);
          $cta = $locked ? 'Login to view' : $card['cta'];
          $classes = 'rf-button rf-button-block' . ($disabled || $locked ? ' rf-button-disabled' : '');
        ?>
          <article class="rf-card<?php echo ($disabled ? ' rf-card-disabled' : ''); ?>">
            <div class="rf-card-body">
              <div class="rf-card-top">
                <span class="rf-card-icon" data-icon="<?php echo htmlspecialchars($card['icon']); ?>"></span>
                <span class="rf-card-label"><?php echo htmlspecialchars($card['label']); ?></span>
              </div>
              <h3 class="rf-card-title"><?php echo htmlspecialchars($card['title']); ?></h3>
              <p class="rf-card-text"><?php echo htmlspecialchars($card['text']); ?></p>
              <div class="rf-card-meta">
                <span class="rf-tag"><?php echo htmlspecialchars($card['tag']); ?></span>
                <span class="rf-dot"></span>
                <span><?php echo htmlspecialchars($card['meta']); ?></span>
              </div>
              <a class="<?php echo $classes; ?>" href="<?php echo htmlspecialchars($href); ?>"<?php echo ($disabled || $locked) ? ' aria-disabled="true"' : ''; ?>><?php echo htmlspecialchars($cta); ?></a>
            </div>
          </article>
        <?php endforeach; ?>
      </div>
    </section>

    <section class="rf-note-panel" aria-labelledby="next-steps">
      <div class="rf-note-box">
        <h2 id="next-steps">Next steps</h2>
        <p>Keep momentum by completing these quick checks whenever you land on the portal:</p>
        <ul>
          <li>Capture screenshots of every page for documentation.</li>
          <li>Confirm login protection triggers on private pages.</li>
          <li>Update workshop and product data as assignments evolve.</li>
        </ul>
      </div>

      <aside class="rf-note-support">
        <h3>Need a refresher?</h3>
        <p>Visit <a href="about.php">About this assignment</a> for implementation notes, rubric links, and submission tips.</p>
      </aside>
    </section>
  </main>

  <?php include __DIR__ . '/footer.php'; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
