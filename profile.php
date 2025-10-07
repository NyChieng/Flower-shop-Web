<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/files.php';
startSessionIfNeeded();
requireLogin('profile.php');

$profile = [
    'name'       => 'Neng Yi Chieng',
    'student_id' => '104386364',
    'email'      => '104386364@student.swin.edu.my',
    'declaration'=> 'I declare that this assignment is my individual work. I have not worked collaboratively nor have I copied from any other student\'s work or from any other source. I have not engaged another party to complete this assignment. I am aware of the University\'s policy with regards to plagiarism. I have not allowed, and will not allow, anyone to copy my work with the intention of passing it off as his or her own work.',
];

function profileImagePath(?string $gender = null): string
{
    $map = [
        'male' => 'profile_images/boys.jpg',
        'female' => 'profile_images/girl.png',
    ];

    $candidate = $map[strtolower($gender ?? 'female')] ?? $map['female'];
    $absolute = __DIR__ . '/' . $candidate;

    return file_exists($absolute) ? $candidate : 'img/login.png';
}

function loadCurrentUserRecord(string $email, string $filePath): ?array
{
    if ($email === '') {
        return null;
    }

    return findRecordByField($filePath, 'Email', $email);
}

$userFile = __DIR__ . '/data/User/user.txt';
$currentUserEmail = currentUser() ?? '';
$currentUserRecord = loadCurrentUserRecord($currentUserEmail, $userFile);
$currentGender = $currentUserRecord['Gender'] ?? 'Female';
$customProfile = __DIR__ . '/img/profile.jpg';
$imageSrc = file_exists($customProfile) ? 'img/profile.jpg' : profileImagePath($currentGender);
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>Root Flowers - Profile</title>
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
        <p class="rf-section-text">Updated with verified student details for submission.</p>
      </header>
    </section>

    <section class="rf-section rf-profile" aria-label="Profile information">
      <div class="rf-card rf-profile-card">
        <div class="rf-card-body">
          <div class="rf-profile-media">
            <img src="<?php echo htmlspecialchars($imageSrc); ?>" alt="Student portrait" />
          </div>
          <ul class="rf-profile-list">
            <li><strong>Name:</strong> <?php echo htmlspecialchars($profile['name']); ?></li>
            <li><strong>Student ID:</strong> <?php echo htmlspecialchars($profile['student_id']); ?></li>
            <li><strong>Email:</strong> <a href="mailto:<?php echo htmlspecialchars($profile['email']); ?>"><?php echo htmlspecialchars($profile['email']); ?></a></li>
          </ul>
          <blockquote class="rf-profile-declaration">
            <?php echo htmlspecialchars($profile['declaration']); ?>
          </blockquote>
          <?php if ($currentUserRecord): ?>
            <div class="rf-profile-meta">
              <h2 class="h6 text-uppercase text-muted mb-2">Portal account</h2>
              <ul class="rf-profile-list">
                <li><strong>Account holder:</strong> <?php echo htmlspecialchars(trim(($currentUserRecord['First Name'] ?? '') . ' ' . ($currentUserRecord['Last Name'] ?? ''))); ?></li>
                <li><strong>Account email:</strong> <a href="mailto:<?php echo htmlspecialchars($currentUserRecord['Email'] ?? ''); ?>"><?php echo htmlspecialchars($currentUserRecord['Email'] ?? ''); ?></a></li>
                <?php if (!empty($currentUserRecord['Hometown'])): ?>
                  <li><strong>Hometown:</strong> <?php echo htmlspecialchars($currentUserRecord['Hometown']); ?></li>
                <?php endif; ?>
              </ul>
            </div>
          <?php endif; ?>
          <div class="rf-profile-actions">
            <a class="rf-button" href="index.php">Back to Home</a>
            <a class="rf-button rf-button-outline" href="about.php">About this Assignment</a>
          </div>
        </div>
      </div>
    </section>
  </main>

  <?php include __DIR__ . '/footer.php'; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
