<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once 'main.php';

// Check if user is logged in
if (empty($_SESSION['user_email'])) {
    $_SESSION['flash'] = 'Please login to view your profile.';
    header('Location: login.php?redirect=profile.php');
    exit;
}

$profile = [
    'name'       => 'Neng Yi Chieng',
    'student_id' => '104386364',
    'email'      => '104386364@student.swin.edu.my',
    'video_link' => 'https://www.youtube.com/watch?v=YOUR_VIDEO_ID', // Replace with your actual video link
    'declaration'=> 'I declare that this assignment is my individual work. I have not worked collaboratively nor have I copied from any other student\'s work or from any other source. I have not engaged another party to complete this assignment. I am aware of the University\'s policy with regards to plagiarism. I have not allowed, and will not allow, anyone to copy my work with the intention of passing it off as his or her own work.',
];

function profileImagePath(?string $gender = null, ?string $profileImage = null): string
{
    // Check if user has uploaded profile image
    if ($profileImage && file_exists(__DIR__ . '/' . $profileImage)) {
        return $profileImage;
    }
    
    $map = [
        'male' => 'profile_images/boys.jpg',
        'female' => 'profile_images/girl.png',
    ];

    $candidate = $map[strtolower($gender ?? 'female')] ?? $map['female'];
    $absolute = __DIR__ . '/' . $candidate;

    return file_exists($absolute) ? $candidate : 'img/login.png';
}

// Load user data from database
$currentUserEmail = $_SESSION['user_email'];
$currentUserRecord = null;

try {
    $conn = getDBConnection();
    $stmt = $conn->prepare("SELECT * FROM user_table WHERE email = ?");
    $stmt->bind_param("s", $currentUserEmail);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $currentUserRecord = $result->fetch_assoc();
    }
    
    $stmt->close();
    $conn->close();
} catch (Exception $e) {
    // Handle error
}

$currentGender = $currentUserRecord['gender'] ?? 'Female';
$currentProfileImage = $currentUserRecord['profile_image'] ?? null;
$imageSrc = profileImagePath($currentGender, $currentProfileImage);
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="author" content="Neng Yi Chieng" />
  <title>Root Flowers - Profile</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />
  <link rel="stylesheet" href="./style/style.css" />
</head>
<body class="rf-page">
  <header class="py-3 border-bottom bg-white shadow-sm">
    <div class="container d-flex justify-content-between align-items-center">
      <a class="d-flex align-items-center gap-2 text-decoration-none" href="index.php">
        <img src="img/logo_1.jpg" alt="Root Flowers logo" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;" />
        <span class="fw-bold fs-5">
          <i class="bi bi-flower1 me-1 text-danger"></i>Root Flowers
        </span>
      </a>
      <a class="btn btn-outline-dark btn-sm" href="index.php">
        <i class="bi bi-house me-2"></i>Home
      </a>
    </div>
  </header>

  <main class="rf-main">
    <section class="rf-section" aria-labelledby="profile-title">
      <header class="rf-section-header text-center">
        <h1 id="profile-title" class="rf-section-title display-5 mb-3">
          <i class="bi bi-person-circle text-danger me-2"></i>Student Profile
        </h1>
      </header>
    </section>

    <section class="rf-section rf-profile" aria-label="Profile information">
      <div class="rf-card rf-profile-card">
        <div class="rf-card-body">
          <div class="text-center mb-4">
            <div class="rf-profile-media">
              <img src="img/ny.jpg" alt="Neng Yi Chieng" />
            </div>
            <h2 class="h4 fw-bold text-dark mb-1">
              <?php echo htmlspecialchars($profile['name']); ?>
            </h2>
            <p class="text-muted mb-0">
              <i class="bi bi-envelope-fill me-1"></i>
              <?php echo htmlspecialchars($profile['email']); ?>
            </p>
          </div>

          <div class="profile-info-section mb-4">
            <h3 class="h6 text-uppercase text-muted mb-3">
              <i class="bi bi-person-badge me-2"></i>Student Information
            </h3>
            <ul class="rf-profile-list">
              <li><strong>Name:</strong> <?php echo htmlspecialchars($profile['name']); ?></li>
              <li><strong>Student ID:</strong> <?php echo htmlspecialchars($profile['student_id']); ?></li>
              <li><strong>Email:</strong> <a href="mailto:<?php echo htmlspecialchars($profile['email']); ?>"><?php echo htmlspecialchars($profile['email']); ?></a></li>
              <li><strong>Video Presentation:</strong> <a href="<?php echo htmlspecialchars($profile['video_link']); ?>" target="_blank" rel="noopener noreferrer"><i class="bi bi-play-circle me-1"></i>Watch Presentation</a></li>
            </ul>
          </div>

          <div class="profile-info-section mb-4">
            <h3 class="h6 text-uppercase text-muted mb-3">
              <i class="bi bi-file-text me-2"></i>Academic Declaration
            </h3>
          </div>

          <blockquote class="rf-profile-declaration">
            <i class="bi bi-shield-check text-success me-2"></i>
            <?php echo htmlspecialchars($profile['declaration']); ?>
          </blockquote>

          <div class="rf-profile-actions">
            <a class="rf-button" href="about.php">
              <i class="bi bi-info-circle me-2"></i>About Assignment
            </a>
            <a class="rf-button rf-button-outline" href="main_menu.php">
              <i class="bi bi-house me-2"></i>Main Menu
            </a>
          </div>
        </div>
      </div>
    </section>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
