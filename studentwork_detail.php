<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
$id = $_GET['id'] ?? '';
if (empty($_SESSION['user_email'])) {
    $_SESSION['flash'] = 'Please login to continue.';
    $target = 'studentwork_detail.php';
    if ($id !== '') {
        $target .= '?id=' . urlencode($id);
    }
    header('Location: login.php?redirect=' . urlencode($target));
    exit;
}

// Simple static student works data (same as studentworks.php)
$works = [
    [
        'id' => '1',
        'title' => 'Romantic Rose Bouquet',
        'student' => 'Sarah Chen',
        'workshop' => 'Hand-tied Bouquet Masterclass',
        'date' => 'March 2024',
        'captured_at' => '2024-03-15',
        'image' => 'img/products/product_2.jpg',
        'description' => 'A stunning hand-tied bouquet featuring deep red roses and gerberas with elegant wrapping. This piece demonstrates advanced techniques in color coordination, stem placement, and professional wrapping methods learned during the masterclass.'
    ],
    [
        'id' => '2',
        'title' => 'Garden Fresh Arrangement',
        'student' => 'Emily Wong',
        'workshop' => 'Modern Tablescapes Intensive',
        'date' => 'February 2024',
        'captured_at' => '2024-02-20',
        'image' => 'img/products/product_4.jpg',
        'description' => 'Beautiful blue hydrangeas mixed with daisies and roses creating a garden-fresh look. This arrangement showcases the principles of modern tablescape design with emphasis on natural, organic composition.'
    ],
    [
        'id' => '3',
        'title' => 'Pastel Dream',
        'student' => 'Jessica Tan',
        'workshop' => 'Hand-tied Bouquet Masterclass',
        'date' => 'March 2024',
        'captured_at' => '2024-03-10',
        'image' => 'img/products/product_1.jpg',
        'description' => 'Soft yellow gerberas combined with lilac roses and chamomile for a cheerful display. The pastel color palette creates a gentle, romantic atmosphere perfect for spring celebrations.'
    ],
    [
        'id' => '4',
        'title' => 'Elegant White & Black',
        'student' => 'Michael Lee',
        'workshop' => 'Modern Tablescapes Intensive',
        'date' => 'January 2024',
        'captured_at' => '2024-01-25',
        'image' => 'img/products/product_12.jpg',
        'description' => 'Sophisticated monochrome arrangement with white gerberas and roses in sleek black wrap. This piece demonstrates mastery of minimalist design principles and the power of contrast in floral arrangements.'
    ],
    [
        'id' => '5',
        'title' => 'Vibrant Summer Mix',
        'student' => 'Amanda Lim',
        'workshop' => 'Hand-tied Bouquet Masterclass',
        'date' => 'February 2024',
        'captured_at' => '2024-02-14',
        'image' => 'img/products/product_8.jpg',
        'description' => 'Bright pink gerberas and carnations with leafy accents bringing summer energy. The vibrant colors and playful composition reflect the joy and warmth of summer celebrations.'
    ],
    [
        'id' => '6',
        'title' => 'Classic Snow & Ruby',
        'student' => 'David Chong',
        'workshop' => 'Modern Tablescapes Intensive',
        'date' => 'January 2024',
        'captured_at' => '2024-01-18',
        'image' => 'img/products/product_3.jpg',
        'description' => 'Timeless combination of baby\'s breath and ruby red roses creating romantic elegance. This classic pairing demonstrates the enduring beauty of traditional floral design principles.'
    ],
];

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
  <meta name="author" content="Neng Yi Chieng" />
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
      <article class="rf-section student-detail-section" aria-label="Student work details">
        <div class="student-detail-container">
          <div class="student-detail-hero">
            <div class="student-detail-image-main">
              <img src="<?php echo htmlspecialchars($record['image']); ?>" 
                   alt="<?php echo htmlspecialchars($record['title']); ?>" 
                   class="detail-hero-image" />
              <div class="detail-image-badges">
                <span class="detail-badge badge-featured">
                  <i class="bi bi-star-fill"></i> Featured Work
                </span>
              </div>
            </div>
          </div>
          
          <div class="student-detail-content">
            <div class="detail-header">
              <div class="detail-header-main">
                <h2 class="detail-project-title"><?php echo htmlspecialchars($record['title']); ?></h2>
                <div class="detail-badges-row">
                  <span class="detail-info-badge">
                    <i class="bi bi-calendar3"></i>
                    <?php echo htmlspecialchars(date('F d, Y', strtotime($record['captured_at']))); ?>
                  </span>
                  <span class="detail-info-badge badge-workshop">
                    <i class="bi bi-mortarboard-fill"></i>
                    <?php echo htmlspecialchars($record['workshop']); ?>
                  </span>
                </div>
              </div>
              
              <div class="detail-student-card">
                <div class="student-avatar">
                  <i class="bi bi-person-circle"></i>
                </div>
                <div class="student-info">
                  <span class="student-label">Created by</span>
                  <span class="student-name"><?php echo htmlspecialchars($record['student']); ?></span>
                </div>
              </div>
            </div>
            
            <div class="detail-description-section">
              <h3 class="description-title">
                <i class="bi bi-bookmark-fill"></i> Project Description
              </h3>
              <p class="detail-description-text"><?php echo nl2br(htmlspecialchars($record['description'])); ?></p>
            </div>
            
            <div class="detail-actions-row">
              <a class="btn btn-outline-danger btn-lg detail-action-btn" href="studentworks.php">
                <i class="bi bi-arrow-left me-2"></i>Back to Gallery
              </a>
              <a class="btn btn-danger btn-lg detail-action-btn" href="workshops.php">
                <i class="bi bi-calendar-check me-2"></i>Join a Workshop
              </a>
            </div>
          </div>
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
