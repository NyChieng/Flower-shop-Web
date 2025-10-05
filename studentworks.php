<?php
require_once __DIR__ . '/auth.php';
require_login();
$firstName = $_SESSION['first_name'] ?? ($_SESSION['user_name'] ?? 'Friend');
$works = require __DIR__ . '/data/studentworks.php';

usort($works, static function (array $a, array $b): int {
    return strcmp($b['captured_at'], $a['captured_at']);
});
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>Root Flowers &middot; Student Works</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />
  <link rel="stylesheet" href="./style/style.css" />
</head>
<body class="rf-page">
    <?php include __DIR__ . '/nav.php'; ?>

  <main class="rf-main">
    <section class="rf-section" aria-labelledby="gallery-title">
      <header class="rf-section-header">
        <h1 id="gallery-title" class="rf-section-title">Student works showcase</h1>
        <p class="rf-section-text">Hi <?php echo htmlspecialchars($firstName); ?>, here are the latest submissions from our workshops. Select any card to view full details (Task&nbsp;6).</p>
      </header>
    </section>

    <section class="rf-section" aria-label="Student works grid">
      <div class="rf-grid">
        <?php foreach ($works as $work): ?>
          <a class="rf-card" href="studentwork_detail.php?id=<?php echo urlencode($work['id']); ?>">
            <div class="rf-card-body">
              <div class="rf-card-top">
                <span class="rf-card-icon" data-icon="S"></span>
                <span class="rf-card-label">Workshop showcase</span>
              </div>
              <div class="rf-card-media">
                <img src="<?php echo htmlspecialchars($work['media']); ?>" alt="<?php echo htmlspecialchars($work['title']); ?>" />
              </div>
              <h2 class="rf-card-title"><?php echo htmlspecialchars($work['title']); ?></h2>
              <p class="rf-card-text">Created by <?php echo htmlspecialchars($work['student']); ?> during the <?php echo htmlspecialchars($work['workshop']); ?>.</p>
              <div class="rf-card-meta">
                <span class="rf-tag">Posted <?php echo htmlspecialchars(date('M d', strtotime($work['captured_at']))); ?></span>
                <span class="rf-dot"></span>
                <span>Tap to view details</span>
              </div>
            </div>
          </a>
        <?php endforeach; ?>
      </div>
    </section>
  </main>

  <footer class="rf-footer">
    <p>&copy; <?php echo date('Y'); ?> Root Flowers &middot; <a href="main_menu.php">Back to main menu</a></p>
  </footer>
</body>
</html>



