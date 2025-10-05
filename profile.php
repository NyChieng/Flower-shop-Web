<?php
require_once __DIR__ . '/auth.php';
require_login();
$profile = [
    'name' => 'Your Name',
    'student_id' => 'S1234567',
    'email' => '1234567@student.swin.edu.my',
];

$baseImage = 'img/profile.jpg';
$imagePath = __DIR__ . '/' . $baseImage;
$imageSrc = file_exists($imagePath) ? $baseImage : 'img/login.png';
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>Root Flowers &middot; Profile</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />
  <link rel="stylesheet" href="./style/style.css" />
</head>
<body class="rf-page">
    <?php include __DIR__ . '/nav.php'; ?>

  <main class="rf-main">
    <section class="rf-section" aria-labelledby="profile-title">
      <header class="rf-section-header">
        <h1 id="profile-title" class="rf-section-title">Student profile</h1>
        <p class="rf-section-text">Update the details below with your real information and a personal photo to satisfy Task&nbsp;7.</p>
      </header>
    </section>

    <section class="rf-section rf-profile" aria-label="Profile information">
      <div class="rf-card rf-profile-card">
        <div class="rf-card-body">
          <div class="rf-profile-media">
            <img src="<?php echo htmlspecialchars($imageSrc); ?>" alt="Student portrait" />
            <?php if ($imageSrc !== $baseImage): ?>
              <p class="rf-card-text rf-profile-note">Add your real portrait to <code>img/profile.jpg</code> to replace this placeholder.</p>
            <?php endif; ?>
          </div>
          <ul class="rf-profile-list">
            <li><strong>Name:</strong> <?php echo htmlspecialchars($profile['name']); ?></li>
            <li><strong>Student ID:</strong> <?php echo htmlspecialchars($profile['student_id']); ?></li>
            <li><strong>Student email:</strong> <?php echo htmlspecialchars($profile['email']); ?></li>
          </ul>
          <blockquote class="rf-profile-declaration">
            “I declare that this assignment is my individual work. I have not work collaboratively nor have I copied from any other student's work or from any other source. I have not engaged another party to complete this assignment. I am aware of the University’s policy with regards to plagiarism. I have not allowed, and will not allow, anyone to copy my work with the intention of passing it off as his or her own work.”
          </blockquote>
          <div class="rf-detail-actions">
            <a class="rf-button rf-button-outline" href="index.php">Return to home</a>
            <a class="rf-button" href="about.php">Read about the project</a>
          </div>
        </div>
      </div>
    </section>
  </main>

  <footer class="rf-footer">
    <p>&copy; <?php echo date('Y'); ?> Root Flowers &middot; <a href="main_menu.php">Back to main menu</a></p>
  </footer>
</body>
</html>



