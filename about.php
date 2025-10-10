<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="author" content="Neng Yi Chieng" />
  <title>Root Flowers - About Assignment</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />
  <link rel="stylesheet" href="./style/style.css" />
</head>
<body class="rf-page">
  <header class="py-3 border-bottom bg-white shadow-sm sticky-top">
    <div class="container d-flex justify-content-between align-items-center">
      <a class="brand-text fw-semibold text-decoration-none d-flex align-items-center gap-2" href="index.php">
        <i class="bi bi-flower1 text-danger" style="font-size: 1.5rem;"></i>
        <span>Root Flowers</span>
      </a>
      <a class="btn btn-outline-dark btn-sm" href="index.php">
        <i class="bi bi-house me-2"></i>Back to Home
      </a>
    </div>
  </header>

  <main class="rf-main">
    <section class="rf-section" aria-labelledby="about-assignment">
      <header class="rf-section-header text-center">
        <h1 id="about-assignment" class="rf-section-title display-5 mb-3">
          <i class="bi bi-info-circle-fill text-danger me-2"></i>About This Project
        </h1>
        <p class="rf-section-text lead">Root Flowers - A comprehensive flower shop web application showcasing modern web development practices with Bootstrap framework.</p>
      </header>
    </section>

    <section class="rf-section" aria-labelledby="system-details">
      <div class="rf-card">
        <div class="rf-card-body">
          <div class="d-flex align-items-center gap-2 mb-3">
            <i class="bi bi-gear-fill text-danger" style="font-size: 2rem;"></i>
            <h2 id="system-details" class="rf-card-title mb-0">Technical Implementation</h2>
          </div>
          <ul class="rf-bullet-list">
            <li><strong><i class="bi bi-code-slash me-2"></i>PHP version:</strong> <?php echo htmlspecialchars(PHP_VERSION); ?></li>
            <li><strong><i class="bi bi-palette me-2"></i>Front-end Framework:</strong> Bootstrap 5.3.3 with custom CSS3 animations</li>
            <li><strong><i class="bi bi-file-earmark-code me-2"></i>Icons Library:</strong> Bootstrap Icons 1.13.1</li>
            <li><strong><i class="bi bi-database me-2"></i>Data Storage:</strong> Plain text files under <code>data/</code> directory (users, workshop registrations, student showcase)</li>
            <li><strong><i class="bi bi-shield-check me-2"></i>Features:</strong> Session management, form validation, secure authentication, responsive design</li>
          </ul>
        </div>
      </div>
    </section>

    <section class="rf-section" aria-labelledby="tasks-completed">
      <div class="rf-card">
        <div class="rf-card-body">
          <div class="d-flex align-items-center gap-2 mb-3">
            <i class="bi bi-check-circle-fill text-success" style="font-size: 2rem;"></i>
            <h2 id="tasks-completed" class="rf-card-title mb-0">Features & Pages Implemented</h2>
          </div>
          <div class="row g-3">
            <div class="col-md-6">
              <ul class="rf-bullet-list">
                <li><i class="bi bi-check2 text-success me-2"></i><strong>Homepage:</strong> Hero section with dynamic greetings, featured bouquets gallery, and promotional content</li>
                <li><i class="bi bi-check2 text-success me-2"></i><strong>Main Menu:</strong> Gated navigation hub with quick action cards and logout functionality</li>
                <li><i class="bi bi-check2 text-success me-2"></i><strong>Products Catalog:</strong> Three categories (Bouquets, Event Styling, Plant Gifts) with 18 items total</li>
                <li><i class="bi bi-check2 text-success me-2"></i><strong>Workshops:</strong> Four comprehensive workshops with schedules, pricing, and registration links</li>
                <li><i class="bi bi-check2 text-success me-2"></i><strong>Student Gallery:</strong> Showcase of workshop participants' floral arrangements</li>
              </ul>
            </div>
            <div class="col-md-6">
              <ul class="rf-bullet-list">
                <li><i class="bi bi-check2 text-success me-2"></i><strong>Student Profile:</strong> Detailed profile page for Neng Yi Chieng with declaration</li>
                <li><i class="bi bi-check2 text-success me-2"></i><strong>Update Profile:</strong> Form for editing user information with validation</li>
                <li><i class="bi bi-check2 text-success me-2"></i><strong>Registration:</strong> New user signup with comprehensive validation and password confirmation</li>
                <li><i class="bi bi-check2 text-success me-2"></i><strong>Login System:</strong> Secure authentication with session management and redirects</li>
                <li><i class="bi bi-check2 text-success me-2"></i><strong>Workshop Registration:</strong> Enrollment form storing data to text files</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="rf-section" aria-labelledby="tasks-pending">
      <div class="rf-card" style="border-left: 4px solid #ffc107;">
        <div class="rf-card-body">
          <div class="d-flex align-items-center gap-2 mb-3">
            <i class="bi bi-clock-history text-warning" style="font-size: 2rem;"></i>
            <h2 id="tasks-pending" class="rf-card-title mb-0">Future Enhancements</h2>
          </div>
          <ul class="rf-bullet-list">
            <li><i class="bi bi-hourglass-split text-warning me-2"></i><strong>Assignment 2:</strong> E-commerce purchase flow with cart functionality</li>
            <li><i class="bi bi-hourglass-split text-warning me-2"></i><strong>File Uploads:</strong> Workshop participant photo submission system</li>
            <li><i class="bi bi-hourglass-split text-warning me-2"></i><strong>AI Integration:</strong> Flower species recognition and identification feature</li>
            <li><i class="bi bi-hourglass-split text-warning me-2"></i><strong>Database Migration:</strong> Transition from text files to MySQL database</li>
            <li><i class="bi bi-hourglass-split text-warning me-2"></i><strong>Video Presentation:</strong> Replace placeholder with final project demonstration</li>
          </ul>
        </div>
      </div>
    </section>

    <section class="rf-section" aria-labelledby="resources">
      <div class="rf-card" style="background: linear-gradient(135deg, #fff9f6, #ffffff);">
        <div class="rf-card-body">
          <div class="d-flex align-items-center gap-2 mb-3">
            <i class="bi bi-link-45deg text-danger" style="font-size: 2rem;"></i>
            <h2 id="resources" class="rf-card-title mb-0">Resources & Links</h2>
          </div>
          <div class="row g-3">
            <div class="col-md-6">
              <a href="https://youtu.be/replace-with-final-video" target="_blank" rel="noopener" class="btn btn-outline-dark w-100">
                <i class="bi bi-camera-video me-2"></i>Video Presentation
              </a>
            </div>
            <div class="col-md-6">
              <a href="index.php" class="btn btn-dark w-100">
                <i class="bi bi-house me-2"></i>Return to Homepage
              </a>
            </div>
          </div>
          <div class="mt-4 p-3 bg-white rounded border">
            <h6 class="fw-bold mb-2"><i class="bi bi-bookmark-star me-2"></i>Design Highlights:</h6>
            <ul class="mb-0" style="font-size: 0.9rem;">
              <li>🎨 Custom flower-themed color palette with soft pinks and elegant accents</li>
              <li>✨ Smooth CSS animations and hover effects for enhanced user experience</li>
              <li>📱 Fully responsive design using Bootstrap grid system</li>
              <li>♿ Accessible navigation with ARIA labels and semantic HTML</li>
              <li>🌸 Icon-rich interface using Bootstrap Icons library</li>
            </ul>
          </div>
        </div>
      </div>
    </section>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
