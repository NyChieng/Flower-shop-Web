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
          <i class="bi bi-info-circle-fill text-danger me-2"></i>Assignment 2 Report
        </h1>
        <p class="rf-section-text lead">Root Flowers - A comprehensive flower shop web application with MySQL database integration and admin functionality</p>
      </header>
    </section>

    <section class="rf-section" aria-labelledby="assignment-questions">
      <div class="rf-card">
        <div class="rf-card-body">
          <div class="d-flex align-items-center gap-2 mb-4">
            <i class="bi bi-question-circle-fill text-danger" style="font-size: 2rem;"></i>
            <h2 id="assignment-questions" class="rf-card-title mb-0">Assignment Reflection</h2>
          </div>
          
          <div class="mb-4">
            <h4 class="text-primary"><i class="bi bi-check-circle me-2"></i>What tasks have you not attempted or not completed?</h4>
            <ul class="rf-bullet-list">
              <li>All core tasks have been completed including database integration, user authentication, admin portal, and flower identification system</li>
              <li>All required tables (user_table, account_table, flower_table, workshop_table, studentwork_table) have been implemented</li>
              <li>Admin functionality for managing users, student works, and workshop registrations is fully functional</li>
            </ul>
          </div>

          <div class="mb-4">
            <h4 class="text-primary"><i class="bi bi-exclamation-triangle me-2"></i>Which parts did you have trouble with?</h4>
            <ul class="rf-bullet-list">
              <li>Implementing cascading deletes between user_table and account_table using foreign key constraints</li>
              <li>Handling file uploads for profile images while maintaining proper file size validation (5MB limit)</li>
              <li>Managing session states for admin vs regular users and proper redirection logic</li>
              <li>Implementing the approve/reject status management with proper button state controls</li>
            </ul>
          </div>

          <div class="mb-4">
            <h4 class="text-primary"><i class="bi bi-lightbulb me-2"></i>What would you like to do better next time?</h4>
            <ul class="rf-bullet-list">
              <li>Implement more robust error handling with try-catch blocks throughout the application</li>
              <li>Add input sanitization and prepared statements more consistently to prevent SQL injection</li>
              <li>Create a more modular code structure with separate files for database functions</li>
              <li>Implement pagination for admin management pages when dealing with large datasets</li>
              <li>Add email notifications for workshop registration approvals/rejections</li>
              <li>Enhance the UI with more interactive elements and AJAX for dynamic updates</li>
            </ul>
          </div>

          <div class="mb-4">
            <h4 class="text-primary"><i class="bi bi-star me-2"></i>What extension features/extra challenges have you done, or attempted, when creating the site?</h4>
            <ul class="rf-bullet-list">
              <li><strong>Flower Identification System:</strong> Created a search-based flower database with PDF descriptions (Task 5.1)</li>
              <li><strong>Admin Portal Design:</strong> Implemented a custom dark-themed admin interface with glassmorphism effects</li>
              <li><strong>Password Hashing:</strong> Used PHP's password_hash() and password_verify() for secure password storage</li>
              <li><strong>Profile Image Upload:</strong> Implemented file upload functionality with validation for profile customization</li>
              <li><strong>Status Management:</strong> Dynamic button states based on approval status (pending/approved/rejected)</li>
              <li><strong>Responsive Design:</strong> Fully responsive layout using Bootstrap 5.3.3 with custom CSS enhancements</li>
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
            <h2 id="system-details" class="rf-card-title mb-0">Technical Implementation</h2>
          </div>
          <ul class="rf-bullet-list">
            <li><strong><i class="bi bi-code-slash me-2"></i>PHP version:</strong> <?php echo htmlspecialchars(PHP_VERSION); ?></li>
            <li><strong><i class="bi bi-database me-2"></i>Database:</strong> MySQL (RootFlower database with 5 tables)</li>
            <li><strong><i class="bi bi-palette me-2"></i>Front-end Framework:</strong> Bootstrap 5.3.3 with custom CSS3 animations</li>
            <li><strong><i class="bi bi-file-earmark-code me-2"></i>Icons Library:</strong> Bootstrap Icons 1.13.1</li>
            <li><strong><i class="bi bi-shield-check me-2"></i>Security:</strong> Password hashing, prepared statements, session management</li>
            <li><strong><i class="bi bi-person-badge me-2"></i>User Types:</strong> Regular users and admin with different access levels</li>
          </ul>
        </div>
      </div>
    </section>

    <section class="rf-section" aria-labelledby="tasks-completed">
      <div class="rf-card">
        <div class="rf-card-body">
          <div class="d-flex align-items-center gap-2 mb-3">
            <i class="bi bi-check-circle-fill text-success" style="font-size: 2rem;"></i>
            <h2 id="tasks-completed" class="rf-card-title mb-0">Pages Implemented - Assignment 2</h2>
          </div>
          <div class="row g-3">
            <div class="col-md-6">
              <h5 class="text-primary">Database & Authentication</h5>
              <ul class="rf-bullet-list">
                <li><i class="bi bi-check2 text-success me-2"></i><strong>main.php:</strong> Database connection and table creation</li>
                <li><i class="bi bi-check2 text-success me-2"></i><strong>Registration:</strong> Save to MySQL with password hashing</li>
                <li><i class="bi bi-check2 text-success me-2"></i><strong>Login:</strong> Validate against database, admin/user routing</li>
                <li><i class="bi bi-check2 text-success me-2"></i><strong>Profile Page:</strong> Display user data from database</li>
                <li><i class="bi bi-check2 text-success me-2"></i><strong>Update Profile:</strong> Edit user info with file uploads</li>
              </ul>
              
              <h5 class="text-primary mt-4">User Features</h5>
              <ul class="rf-bullet-list">
                <li><i class="bi bi-check2 text-success me-2"></i><strong>Main Menu:</strong> Navigation for regular users</li>
                <li><i class="bi bi-check2 text-success me-2"></i><strong>Products:</strong> Browse flower products</li>
                <li><i class="bi bi-check2 text-success me-2"></i><strong>Workshops:</strong> View workshop information</li>
                <li><i class="bi bi-check2 text-success me-2"></i><strong>Student Works:</strong> Gallery of submissions</li>
              </ul>
            </div>
            <div class="col-md-6">
              <h5 class="text-primary">Admin Portal</h5>
              <ul class="rf-bullet-list">
                <li><i class="bi bi-check2 text-success me-2"></i><strong>Admin Main Menu:</strong> Dark-themed admin dashboard</li>
                <li><i class="bi bi-check2 text-success me-2"></i><strong>Manage Accounts:</strong> Add, edit, delete users</li>
                <li><i class="bi bi-check2 text-success me-2"></i><strong>Manage Student Works:</strong> Approve/reject submissions</li>
                <li><i class="bi bi-check2 text-success me-2"></i><strong>Manage Workshop Reg:</strong> Approve/reject registrations</li>
              </ul>
              
              <h5 class="text-primary mt-4">Extension Features</h5>
              <ul class="rf-bullet-list">
                <li><i class="bi bi-check2 text-success me-2"></i><strong>Flower Identification:</strong> Search flowers by name</li>
                <li><i class="bi bi-check2 text-success me-2"></i><strong>About Page:</strong> Assignment report and reflections</li>
              </ul>
              
              <h5 class="text-primary mt-4">Database Tables</h5>
              <ul class="rf-bullet-list">
                <li><i class="bi bi-database me-2"></i>user_table (with profile images)</li>
                <li><i class="bi bi-database me-2"></i>account_table (with foreign key)</li>
                <li><i class="bi bi-database me-2"></i>flower_table</li>
                <li><i class="bi bi-database me-2"></i>workshop_table</li>
                <li><i class="bi bi-database me-2"></i>studentwork_table</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="rf-section" aria-labelledby="resources">
      <div class="rf-card" style="background: linear-gradient(135deg, #fff9f6, #ffffff);">
        <div class="rf-card-body">
          <div class="d-flex align-items-center gap-2 mb-3">
            <i class="bi bi-link-45deg text-danger" style="font-size: 2rem;"></i>
            <h2 id="resources" class="rf-card-title mb-0">Links & Navigation</h2>
          </div>
          <div class="row g-3">
            <div class="col-md-4">
              <a href="index.php" class="btn btn-dark w-100">
                <i class="bi bi-house me-2"></i>Homepage
              </a>
            </div>
            <div class="col-md-4">
              <a href="flower.php" class="btn btn-primary w-100">
                <i class="bi bi-flower1 me-2"></i>Flower Identification
              </a>
            </div>
            <div class="col-md-4">
              <a href="profile.php" class="btn btn-outline-dark w-100">
                <i class="bi bi-person-circle me-2"></i>Profile
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
