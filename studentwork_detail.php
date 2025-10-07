<?php
require_once __DIR__ . '/auth.php';
startSessionIfNeeded();
$id = $_GET['id'] ?? '';
requireLogin('studentwork_detail.php?id=' . urlencode($id));
$works = require __DIR__ . '/data/studentworks.php';

$record = null;
foreach ($works as $item) {
    if ($item['id'] === $id) {
        $record = $item;
        break;
    }
}

if (!$record) {
    http_response_code(404);
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>Root Flowers - Student Work Detail</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />
  <link rel="stylesheet" href="./style/style.css" />
</head>
<body class="rf-page">
  <?php include __DIR__ . '/nav.php'; ?>

  <main class="rf-main">
    <section class="rf-section" aria-labelledby="work-detail">
      <header class="rf-section-header">
        <h1 id="work-detail" class="rf-section-title">
          <?php echo $record ? htmlspecialchars($record['title']) : 'Work not found'; ?>
        </h1>
        <p class="rf-section-text">
          <?php if ($record): ?>
            A closer look at <?php echo htmlspecialchars($record['student']); ?>'s submission for the <?php echo htmlspecialchars($record['workshop']); ?> workshop.
          <?php else: ?>
            The requested student work could not be located.
          <?php endif; ?>
        </p>
      </header>
    </section>

    <?php if ($record): ?>
      <article class="rf-section rf-detail" aria-label="Student work details">
        <div class="rf-card">
          <div class="rf-card-body">
            <div class="rf-card-media">
              <img src="<?php echo htmlspecialchars($record['media']); ?>" alt="<?php echo htmlspecialchars($record['title']); ?>" />
            </div>
            <div class="rf-detail-meta">
              <span class="rf-tag">Captured <?php echo htmlspecialchars(date('d M Y', strtotime($record['captured_at']))); ?></span>
              <span class="rf-dot"></span>
              <span><?php echo htmlspecialchars($record['workshop']); ?></span>
            </div>
            <p class="rf-card-text"><?php echo htmlspecialchars($record['description']); ?></p>
            <p class="rf-card-text"><strong>Student:</strong> <?php echo htmlspecialchars($record['student']); ?></p>
          </div>
        </div>
        <div class="rf-detail-actions">
          <a class="rf-button rf-button-outline" href="studentworks.php">Back to gallery</a>
          <a class="rf-button" href="workshops.php">View upcoming workshops</a>
        </div>
      </article>
    <?php else: ?>
      <section class="rf-section">
        <p class="rf-card-text">Return to the <a href="studentworks.php">student works gallery</a> to browse available submissions.</p>
      </section>
    <?php endif; ?>
  </main>
  <?php include __DIR__ . '/footer.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
