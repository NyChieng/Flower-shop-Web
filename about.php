<?php
require_once __DIR__ . '/auth.php';
startSessionIfNeeded();
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>Root Flowers - About</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />
  <link rel="stylesheet" href="./style/style.css" />
</head>
<body class="rf-page">
  <?php include __DIR__ . '/nav.php'; ?>

  <main class="rf-main">
    <section class="rf-section" aria-labelledby="about-assignment">
      <header class="rf-section-header">
        <h1 id="about-assignment" class="rf-section-title">About this assignment</h1>
        <p class="rf-section-text">Summary of the Root Flowers case study implementation for COS30020 Assignment&nbsp;1.</p>
      </header>
    </section>

    <section class="rf-section" aria-labelledby="system-details">
      <div class="rf-card">
        <div class="rf-card-body">
          <h2 id="system-details" class="rf-card-title">Implementation notes</h2>
          <ul class="rf-bullet-list">
            <li><strong>PHP version in use:</strong> <?php echo htmlspecialchars(PHP_VERSION); ?></li>
            <li><strong>Front-end stack:</strong> Bootstrap&nbsp;5.3.3, Bootstrap Icons&nbsp;1.13.1, custom CSS</li>
            <li><strong>Data storage:</strong> Plain text files under <code>data/</code> (users, workshop registrations, student showcase)</li>
          </ul>
        </div>
      </div>
    </section>

    <section class="rf-section" aria-labelledby="tasks-completed">
      <div class="rf-card">
        <div class="rf-card-body">
          <h2 id="tasks-completed" class="rf-card-title">Key features delivered</h2>
          <ul class="rf-bullet-list">
            <li>Home page with introduction, rotating gallery, and navigation buttons</li>
            <li>Main menu with gated links, logout, and quick actions</li>
            <li>Products catalogue: three categories with six items each</li>
            <li>Workshops listing with schedule, venue, pricing, and registration link</li>
            <li>Student works gallery pulling data from <code>data/studentworks.php</code></li>
            <li>Detailed student work view with metadata</li>
            <li>Student profile page for Neng Yi Chieng</li>
            <li>Update profile form writing back to <code>data/User/user.txt</code></li>
            <li>Registration form with validation and text input requirements</li>
            <li>Process registration handler with validation and duplicate email checks</li>
            <li>Workshop registration form storing to <code>data/User/workshop_reg.txt</code></li>
            <li>Login form with credential validation and redirects</li>
            <li>About page summary (this page)</li>
          </ul>
        </div>
      </div>
    </section>

    <section class="rf-section" aria-labelledby="tasks-pending">
      <div class="rf-card">
        <div class="rf-card-body">
          <h2 id="tasks-pending" class="rf-card-title">Planned enhancements</h2>
          <ul class="rf-bullet-list">
            <li>Assignment&nbsp;2 enhancements: purchase flow, workshop uploads, flower recognition feature</li>
            <li>Replace placeholder video link with final presentation URL</li>
          </ul>
        </div>
      </div>
    </section>

    <section class="rf-section" aria-labelledby="resources">
      <div class="rf-card">
        <div class="rf-card-body">
          <h2 id="resources" class="rf-card-title">Resources</h2>
          <ul class="rf-bullet-list">
            <li><a href="https://youtu.be/replace-with-final-video" target="_blank" rel="noopener">Video presentation (update with final link)</a></li>
            <li><a href="index.php">Return to Home page</a></li>
          </ul>
        </div>
      </div>
    </section>
  </main>

  <?php include __DIR__ . '/footer.php'; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
