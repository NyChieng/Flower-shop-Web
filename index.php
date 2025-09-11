<?php
// index.php — home; hero uses local main_background.jpg; no online fallbacks
if (session_status() === PHP_SESSION_NONE) { session_start(); }
$isLoggedIn = !empty($_SESSION['user_email']);

// discover up to 6 product images (no external replacements)
$imgDir  = __DIR__ . '/img/products';
$webDir  = 'img/products';
$allowed = ['jpg','jpeg','png','webp'];

$files = [];
if (is_dir($imgDir)) {
  foreach (scandir($imgDir) as $f) {
    $ext = strtolower(pathinfo($f, PATHINFO_EXTENSION));
    if (in_array($ext, $allowed)) { $files[] = $f; }
  }
}
sort($files, SORT_NATURAL);
$files = array_slice($files, 0, 6);

$photos = [];
foreach ($files as $f) {
  $name = pathinfo($f, PATHINFO_FILENAME);
  $photos[] = [
    'src'  => $webDir . '/' . rawurlencode($f),
    'name' => ucwords(str_replace(['-','_'], ' ', $name)),
  ];
}

// pad to exactly 6 with placeholders (no src)
while (count($photos) < 6) {
  $photos[] = ['src' => null, 'name' => 'Image coming soon'];
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Root Flowers — Home</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="style/style.css">
</head>
<body>

  <?php include __DIR__ . '/nav.php'; ?>

  <!-- HERO with your own background image -->
  <header class="hero hero-with-image py-5">
    <div class="hero-overlay"></div>
    <div class="container position-relative">
      <div class="row align-items-center">
        <div class="col-lg-7">
          <div class="glass p-4 p-md-5 rounded-4">
            <h1 class="display-5 brand-mark mb-3">Root Flowers</h1>
            <p class="lead mb-4">
              Crafting warm, memorable moments with Sarawak’s loveliest blooms — for birthdays,
              proposals, and everyday kindness.
            </p>
            <a class="btn btn-dark btn-lg btn-cta" href="main_menu.php" data-require-login="1">🌸 Main Menu</a>
          </div>
        </div>
      </div>
    </div>
  </header>

  <!-- PRODUCT GRID (exactly 6 tiles; placeholders if missing) -->
  <main class="py-5">
    <div class="container">
      <div class="section-head">
        <h2 class="h4 mb-0">Featured Bouquets</h2>
        <div class="chips">
          <span class="chip">Hand-tied</span>
          <span class="chip">Same-day</span>
          <span class="chip">Sarawak-grown</span>
        </div>
      </div>

      <div id="grid" class="row g-4">
        <?php foreach ($photos as $p): ?>
          <div class="col-6 col-md-4">
            <article class="card photo-card h-100 hover-lift">
              <?php if (!empty($p['src'])): ?>
                <div class="img-wrap">
                  <img src="<?php echo htmlspecialchars($p['src']); ?>" class="card-img-top"
                       alt="<?php echo htmlspecialchars($p['name']); ?>">
                </div>
              <?php else: ?>
                <div class="img-wrap placeholder-tile d-flex align-items-center justify-content-center">
                  <span class="placeholder-text">Image coming soon</span>
                </div>
              <?php endif; ?>
              <div class="card-body">
                <h3 class="h6 card-title mb-0 text-truncate" title="<?php echo htmlspecialchars($p['name']); ?>">
                  <?php echo htmlspecialchars($p['name']); ?>
                </h3>
              </div>
            </article>
          </div>
        <?php endforeach; ?>
      </div>

      <div class="divider my-5" role="separator" aria-hidden="true"></div>

      <div class="row g-4 align-items-center">
        <div class="col-lg-7">
          <h2 class="h5 mb-2">Workshops with heart</h2>
          <p class="mb-0">
            Learn to hand-tie, style, and care for your blooms. Small classes, friendly instructors,
            and tea on the side. Dates available after login from the main menu.
          </p>
        </div>
        <div class="col-lg-5 text-lg-end">
          <a class="btn btn-outline-dark" href="workshops.php" data-require-login="1">Explore Workshops →</a>
        </div>
      </div>
    </div>
  </main>

  <?php include __DIR__ . '/footer.php'; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // gate protected links
    const IS_LOGGED_IN = <?php echo $isLoggedIn ? 'true' : 'false'; ?>;
    document.querySelectorAll('[data-require-login]').forEach(el => {
      el.addEventListener('click', (e) => {
        if (!IS_LOGGED_IN) {
          e.preventDefault();
          const next = el.getAttribute('href') || 'main_menu.php';
          window.location.href = 'login.php?next=' + encodeURIComponent(next);
        }
      });
    });
  </script>
</body>
</html>
