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
          <i class="bi bi-info-circle-fill text-danger me-2"></i>About This Assignment
        </h1>
        <p class="rf-section-text lead">Root Flowers - A modern flower shop web application with MySQL database and admin features</p>
      </header>
    </section>

    <section class="rf-section" aria-labelledby="assignment-questions">
      <div class="rf-card">
        <div class="rf-card-body">
          <div class="d-flex align-items-center gap-2 mb-4">
            <i class="bi bi-list-check text-danger" style="font-size: 2rem;"></i>
            <h2 id="assignment-questions" class="rf-card-title mb-0">What I Completed</h2>
          </div>
          
          <div class="mb-4">
            <h4 class="text-primary"><i class="bi bi-check-circle me-2"></i>All Core Requirements</h4>
            <ul class="rf-bullet-list">
              <li>✅ Complete database migration from text files to MySQL</li>
              <li>✅ User registration and login with password hashing</li>
              <li>✅ Admin portal for managing users, workshops, and student works</li>
              <li>✅ Profile update with image and resume upload</li>
              <li>✅ Flower identification system with search functionality</li>
              <li>✅ All 5 database tables properly created with relationships</li>
            </ul>
          </div>

          <div class="mb-4">
            <h4 class="text-primary"><i class="bi bi-exclamation-triangle me-2"></i>Challenges I Faced</h4>
            <ul class="rf-bullet-list">
              <li>🔧 Setting up foreign key constraints between tables</li>
              <li>🔧 Managing file uploads with proper validation (5MB images, 7MB PDFs)</li>
              <li>🔧 Creating separate navigation for admin vs regular users</li>
              <li>🔧 Implementing approve/reject status system with proper button states</li>
            </ul>
          </div>

          <div class="mb-4">
            <h4 class="text-primary"><i class="bi bi-star me-2"></i>Extra Features Added</h4>
            <ul class="rf-bullet-list">
              <li>⭐ Modern UI with Bootstrap 5.3.3 and custom animations</li>
              <li>⭐ Dark-themed admin portal with glassmorphism design</li>
              <li>⭐ Responsive design that works on mobile, tablet, and desktop</li>
              <li>⭐ Dynamic navigation that changes based on user role (admin/user)</li>
              <li>⭐ Profile image preview and gender-based default avatars</li>
            </ul>
          </div>
        </div>
      </div>
    </section>

    <section class="rf-section" aria-labelledby="system-details">
      <div class="rf-card">
        <div class="rf-card-body">
          <div class="d-flex align-items-center gap-2 mb-3">
            <i class="bi bi-gear-fill text-danger" style="font-size: 2rem;"></i>
            <h2 id="system-details" class="rf-card-title mb-0">Technologies Used</h2>
          </div>
          <div class="row g-3">
            <div class="col-md-6">
              <ul class="rf-bullet-list">
                <li><strong><i class="bi bi-code-slash me-2"></i>Backend:</strong> PHP <?php echo htmlspecialchars(PHP_VERSION); ?></li>
                <li><strong><i class="bi bi-database me-2"></i>Database:</strong> MySQL (RootFlower)</li>
                <li><strong><i class="bi bi-shield-check me-2"></i>Security:</strong> Password hashing, SQL prepared statements</li>
              </ul>
            </div>
            <div class="col-md-6">
              <ul class="rf-bullet-list">
                <li><strong><i class="bi bi-palette me-2"></i>Frontend:</strong> Bootstrap 5.3.3 + Custom CSS</li>
                <li><strong><i class="bi bi-file-earmark-code me-2"></i>Icons:</strong> Bootstrap Icons 1.13.1</li>
                <li><strong><i class="bi bi-person-badge me-2"></i>Users:</strong> Admin and Regular User roles</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="rf-section" aria-labelledby="tasks-completed">
      <div class="rf-card">
        <div class="rf-card-body">
          <div class="d-flex align-items-center gap-2 mb-3">
            <i class="bi bi-check-circle-fill text-success" style="font-size: 2rem;"></i>
            <h2 id="tasks-completed" class="rf-card-title mb-0">Website Features</h2>
          </div>
          <div class="row g-3">
            <div class="col-md-6">
              <h5 class="text-primary"><i class="bi bi-person me-2"></i>User Features</h5>
              <ul class="rf-bullet-list">
                <li>Register and login securely</li>
                <li>Update profile with photo and resume</li>
                <li>Browse products and workshops</li>
                <li>Search for flower information</li>
                <li>View student work gallery</li>
              </ul>
              
              <h5 class="text-primary mt-4"><i class="bi bi-database me-2"></i>Database</h5>
              <ul class="rf-bullet-list">
                <li>user_table - User profiles</li>
                <li>account_table - Login credentials</li>
                <li>flower_table - Flower information</li>
                <li>workshop_table - Workshop registrations</li>
                <li>studentwork_table - Student submissions</li>
              </ul>
            </div>
            <div class="col-md-6">
              <h5 class="text-primary"><i class="bi bi-shield-lock me-2"></i>Admin Features</h5>
              <ul class="rf-bullet-list">
                <li>Manage user accounts (add/edit/delete)</li>
                <li>Approve/reject workshop registrations</li>
                <li>Approve/reject student work submissions</li>
                <li>Manage flower database entries</li>
                <li>View statistics and reports</li>
              </ul>
              
              <h5 class="text-primary mt-4"><i class="bi bi-palette me-2"></i>Design</h5>
              <ul class="rf-bullet-list">
                <li>Clean, modern interface</li>
                <li>Responsive for all screen sizes</li>
                <li>Easy navigation</li>
                <li>Smooth animations</li>
                <li>Professional flower theme</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="rf-section" aria-labelledby="video-presentation">
      <div class="rf-card" style="background: linear-gradient(135deg, #ffe5e5, #fff5f5);">
        <div class="rf-card-body">
          <div class="d-flex align-items-center gap-2 mb-3">
            <i class="bi bi-play-circle-fill text-danger" style="font-size: 2rem;"></i>
            <h2 id="video-presentation" class="rf-card-title mb-0">Video Presentation</h2>
          </div>
          <div class="text-center">
            <p class="mb-3">Watch the video presentation demonstrating the features and functionality of this assignment.</p>
            <a href="https://youtu.be/2qI93aep1Hk" target="_blank" rel="noopener noreferrer" class="btn btn-danger btn-lg">
              <i class="bi bi-play-circle me-2"></i>Watch Video Presentation
            </a>
          </div>
        </div>
      </div>
    </section>

    <section class="rf-section" aria-labelledby="resources">
      <div class="rf-card" style="background: linear-gradient(135deg, #fff9f6, #ffffff);">
        <div class="rf-card-body">
          <div class="d-flex align-items-center gap-2 mb-3">
            <i class="bi bi-link-45deg text-danger" style="font-size: 2rem;"></i>
            <h2 id="resources" class="rf-card-title mb-0">Quick Links</h2>
          </div>
          <div class="row g-3">
            <div class="col-md-3">
              <a href="index.php" class="btn btn-dark w-100">
                <i class="bi bi-house me-2"></i>Home
              </a>
            </div>
            <div class="col-md-3">
              <a href="profile.php" class="btn btn-outline-dark w-100">
                <i class="bi bi-person-circle me-2"></i>Student Profile
              </a>
            </div>
            <div class="col-md-3">
              <a href="main_menu.php" class="btn btn-primary w-100">
                <i class="bi bi-grid me-2"></i>Main Menu
              </a>
            </div>
            <div class="col-md-3">
              <a href="flower.php" class="btn btn-success w-100">
                <i class="bi bi-flower1 me-2"></i>Flower Search
              </a>
            </div>
          </div>
          <div class="mt-4 p-3 bg-white rounded border text-center">
            <p class="mb-0 text-muted">🌸 Created by Neng Yi Chieng | Student ID: 104386364 | December 2025</p>
          </div>
        </div>
      </div>
    </section>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
