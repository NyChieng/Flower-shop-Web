<?php
// index.php — Task 1: Intro + random product photos + 3 buttons + footer
if (session_status() === PHP_SESSION_NONE) { session_start(); }

// --- Discover product images (max 6, random order) ---
$imgDir  = __DIR__ . '/img/products';
$webDir  = 'img/products';
$allowed = ['jpg','jpeg','png','webp'];
$photos  = [];

if (is_dir($imgDir)) {
    foreach (scandir($imgDir) as $f) {
        $ext = strtolower(pathinfo($f, PATHINFO_EXTENSION));
        if (in_array($ext, $allowed)) {
            $name = pathinfo($f, PATHINFO_FILENAME);
            $photos[] = [
                'src'  => $webDir . '/' . rawurlencode($f),
                'name' => ucwords(str_replace(['-','_'],' ', $name)),
            ];
        }
    }
}
if (!empty($photos)) {
    shuffle($photos);
    $photos = array_slice($photos, 0, 6);
}
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style/style.css">
  </head>
  <body>

    <!-- HERO with background image -->
    <header class="hero hero-with-image py-5">
      <div class="hero-overlay"></div>
      <div class="container position-relative">
        <div class="row">
          <div class="col-lg-7">
            <div class="glass p-4 p-md-5 rounded-4">
              <h1 class="display-5 brand-mark mb-3">Root Flowers</h1>
              <p class="lead mb-4">
                Root Flowers is a cozy florist in Kuching. We craft warm bouquets, bespoke
                arrangements, and run friendly floral workshops for the community.
              </p>
              <!-- Three buttons -->
              <div class="cta-row">
                <a class="btn btn-dark btn-lg btn-cta" href="main_menu.php">🌸 Main Menu</a>
                <a class="btn btn-outline-dark btn-lg" href="login.php">Login</a>
                <a class="btn btn-outline-secondary btn-lg" href="registration.php">Register</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </header>

    <!-- PRODUCT GRID -->
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
                <?php if ($p['src']): ?>
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
                  <h3 class="h6 card-title mb-0 text-truncate"
                      title="<?php echo htmlspecialchars($p['name']); ?>">
                    <?php echo htmlspecialchars($p['name']); ?>
                  </h3>
                </div>
              </article>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </main>

    <?php include __DIR__ . '/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
