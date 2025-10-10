<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// Profile page is now public - no login required

$profile = [
    'name'       => 'Neng Yi Chieng',
    'student_id' => '104386364',
    'email'      => '104386364@student.swin.edu.my',
    'declaration'=> 'I declare that this assignment is my individual work. I have not worked collaboratively nor have I copied from any other student\'s work or from any other source. I have not engaged another party to complete this assignment. I am aware of the University\'s policy with regards to plagiarism. I have not allowed, and will not allow, anyone to copy my work with the intention of passing it off as his or her own work.',
];

function readLines(string $filePath): array
{
    if (!file_exists($filePath)) {
        return [];
    }
    $lines = file($filePath, FILE_IGNORE_NEW_LINES);
    return $lines === false ? [] : $lines;
}

function parseDelimitedRecord(string $line, string $pairDelimiter = '|'): array
{
    $record = [];
    foreach (explode($pairDelimiter, $line) as $segment) {
        $segment = trim($segment);
        if ($segment === '') {
            continue;
        }

        [$key, $value] = array_pad(explode(':', $segment, 2), 2, '');
        $key = trim($key);
        if ($key === '') {
            continue;
        }
        $record[$key] = trim($value);
    }

    return $record;
}

function findRecordByField(string $filePath, string $field, string $value): ?array
{
    foreach (readLines($filePath) as $line) {
        $record = parseDelimitedRecord($line);
        if (!array_key_exists($field, $record)) {
            continue;
        }
        if (strcasecmp($record[$field], $value) === 0) {
            return $record;
        }
    }

    return null;
}

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

$userFile = (function (): string {
    $xamppRoot = dirname(__DIR__, 3);
    $directory = $xamppRoot . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'User';
    if (!is_dir($directory)) {
        mkdir($directory, 0775, true);
    }
    return $directory . DIRECTORY_SEPARATOR . 'user.txt';
})();
$currentUserEmail = $_SESSION['user_email'] ?? '';
$currentUserRecord = loadCurrentUserRecord($currentUserEmail, $userFile);
$currentGender = $currentUserRecord['Gender'] ?? 'Female';
$fallbackProfile = __DIR__ . '/img/ny.jpg';
$imageSrc = file_exists($fallbackProfile) ? 'img/ny.jpg' : 'img/login.png';
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
              <img src="<?php echo htmlspecialchars($imageSrc); ?>" alt="Student portrait" />
            </div>
            <h2 class="h4 fw-bold text-dark mb-1"><?php echo htmlspecialchars($profile['name']); ?></h2>
            <p class="text-muted mb-0">
              <i class="bi bi-patch-check-fill text-success me-1"></i>
              Student ID: <?php echo htmlspecialchars($profile['student_id']); ?>
            </p>
          </div>

          <div class="profile-info-section mb-4">
            <h3 class="h6 text-uppercase text-muted mb-3">
              <i class="bi bi-info-circle me-2"></i>Contact Information
            </h3>
            <ul class="rf-profile-list">
              <li><strong>Email:</strong> <a href="mailto:<?php echo htmlspecialchars($profile['email']); ?>"><?php echo htmlspecialchars($profile['email']); ?></a></li>
            </ul>
          </div>

          <blockquote class="rf-profile-declaration">
            <i class="bi bi-shield-check text-success me-2"></i>
            <?php echo htmlspecialchars($profile['declaration']); ?>
          </blockquote>

          <div class="rf-profile-actions">
            <a class="rf-button" href="index.php">
              <i class="bi bi-house me-2"></i>Back to Home
            </a>
            <a class="rf-button rf-button-outline" href="about.php">
              <i class="bi bi-info-circle me-2"></i>About Assignment
            </a>
          </div>
        </div>
      </div>
    </section>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
