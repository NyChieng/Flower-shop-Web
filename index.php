<?php
// index.php — public home page (features blocked unless logged in)
if (session_status() === PHP_SESSION_NONE) { session_start(); }
$isLoggedIn = !empty($_SESSION['user_email']);

// Discover product photos (randomize)
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
                'src'   => $webDir . '/' . rawurlencode($f),
                'name'  => ucwords(str_replace(['-','_'],' ', $name)),
            ];
        }
    }
}
if (empty($photos)) {
    for ($i=1; $i<=8; $i++) {
        $photos[] = ['src'=>"https://picsum.photos/seed/flowers$i/600/600",'name'=>"Bouquet $i"];
    }
}
shuffle($photos);
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

  <header class="hero py-5">
    <div class="container">
      <div class="row align-items-center g-4">
        <div class="col-lg-6">
          <span class="badge badge-soft rounded-pill px-3 py-2 mb-3">Kuching • Sarawak</span>
          <h1 class="display-5 brand-mark">Root Flowers</h1>
          <p class="lead">
            Warm bouquets and bespoke arrangements—made with care for birthdays, proposals,
            and every little celebration in between.
          </p>

          <!-- EXACTLY 3 buttons required by the brief -->
          <div class="cta-row">
            <a class="btn btn-dark" href="main_menu.php" data-require-login="1">🌸 Main Menu</a>
            <a class="btn btn-outline-dark" href="login.php">Login</a>
            <a class="btn btn-outline-secondary" href="registration.php">Register</a>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="alert alert-warning border-0" role="alert">
            Tip: Use the search box (top-right) to filter bouquets by name.
          </div>
        </div>
      </div>
    </div>
  </header>

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
          <div class="col-6 col-md-4 col-lg-3 product" data-name="<?php echo htmlspecialchars($p['name']); ?>">
            <div class="card photo-card h-100">
              <img src="<?php echo htmlspecialchars($p['src']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($p['name']); ?>">
              <div class="card-body d-flex flex-column">
                <h3 class="h6 card-title mb-0"><?php echo htmlspecialchars($p['name']); ?></h3>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <div class="divider my-5"></div>

      <div class="row g-4 align-items-center">
        <div class="col-lg-7">
          <h2 class="h5 mb-2">Workshops with heart</h2>
          <p class="mb-0">
            Learn to hand-tie, style, and care for your blooms. Cozy small classes, friendly instructors,
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
    // expose login state to JS
    const IS_LOGGED_IN = <?php echo $isLoggedIn ? 'true' : 'false'; ?>;

    // Client-side guard: any link with data-require-login will be blocked if not logged in
    document.querySelectorAll('[data-require-login]').forEach(a => {
      a.addEventListener('click', (e) => {
        if (!IS_LOGGED_IN) {
          e.preventDefault();
          const goto = a.getAttribute('href') || 'main_menu.php';
          // redirect to login with a next param so we can bounce back post-login
          window.location.href = 'login.php?next=' + encodeURIComponent(goto);
        }
      });
    });

    // Search filter on home grid (bonus UX)
    const q = document.getElementById('q');
    if (q) {
      q.addEventListener('input', function(){
        const term = this.value.toLowerCase();
        document.querySelectorAll('.product').forEach(card => {
          const name = (card.getAttribute('data-name') || '').toLowerCase();
          card.style.display = name.includes(term) ? '' : 'none';
        });
      });
    }
  </script>
</body>
</html>
