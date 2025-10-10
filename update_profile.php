<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (empty($_SESSION['user_email'])) {
    $_SESSION['flash'] = 'Please login to continue.';
    header('Location: login.php?redirect=' . urlencode('update_profile.php'));
    exit;
}

function ensureDir(string $directory): void
{
    if ($directory === '' || is_dir($directory)) {
        return;
    }
    mkdir($directory, 0775, true);
}

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

function alphaSpace(string $value): bool
{
    return (bool)preg_match('/^[a-zA-Z ]+$/', $value);
}

function validEmailFormat(string $email): bool
{
    return (bool)filter_var($email, FILTER_VALIDATE_EMAIL);
}

function req($value): bool
{
    return isset($value) && trim($value) !== '';
}

function userDataDirectory(): string
{
    $xamppRoot = dirname(__DIR__, 3);
    $directory = $xamppRoot . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'User';
    if (!is_dir($directory)) {
        mkdir($directory, 0775, true);
    }
    return $directory;
}

function userDataPath(): string
{
    return userDataDirectory() . DIRECTORY_SEPARATOR . 'user.txt';
}

$userFile = userDataPath();
$currentEmail = $_SESSION['user_email'] ?? null;
$originalRecord = null;
$originalLineIndex = null;

$lines = readLines($userFile);
foreach ($lines as $index => $line) {
    $record = parseDelimitedRecord($line);
    if (isset($record['Email']) && strcasecmp($record['Email'], $currentEmail) === 0) {
        $originalRecord = $record;
        $originalLineIndex = $index;
        break;
    }
}

if (!$originalRecord) {
    $errorMessage = 'Unable to locate your profile record.';
}

function formatDateForInput(?string $dob): string
{
    if (!$dob) {
        return '';
    }
    if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $dob)) {
        return $dob;
    }
    $parts = explode('-', $dob);
    if (count($parts) === 3) {
        return sprintf('%04d-%02d-%02d', (int)$parts[2], (int)$parts[1], (int)$parts[0]);
    }
    return '';
}

function old(string $key, array $values): string
{
    return htmlspecialchars($values[$key] ?? '', ENT_QUOTES);
}

function fieldErrors(string $key, array $errors): array
{
    return $errors[$key] ?? [];
}

function profileImagePath(?string $gender): string
{
    $map = [
        'male' => 'profile_images/boys.jpg',
        'female' => 'profile_images/girl.png',
    ];

    $candidate = $map[strtolower($gender ?? 'female')] ?? $map['female'];
    $absolute = __DIR__ . '/' . $candidate;

    return file_exists($absolute) ? $candidate : 'img/login.png';
}

$values = [
    'first_name' => $originalRecord['First Name'] ?? '',
    'last_name'  => $originalRecord['Last Name'] ?? '',
    'dob'        => formatDateForInput($originalRecord['DOB'] ?? ''),
    'gender'     => $originalRecord['Gender'] ?? 'Female',
    'email'      => $originalRecord['Email'] ?? '',
    'hometown'   => $originalRecord['Hometown'] ?? '',
];

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $originalRecord) {
    $values['first_name'] = trim($_POST['first_name'] ?? '');
    $values['last_name']  = trim($_POST['last_name'] ?? '');
    $values['dob']        = trim($_POST['dob'] ?? '');
    $values['gender']     = $_POST['gender'] ?? 'Female';
    $values['email']      = trim($_POST['email'] ?? '');
    $values['hometown']   = trim($_POST['hometown'] ?? '');

    $addError = function(string $key, string $message) use (&$errors) {
        $errors[$key][] = $message;
    };

    if (!req($values['first_name'])) {
        $addError('first_name', 'First name is required.');
    } elseif (!alphaSpace($values['first_name'])) {
        $addError('first_name', 'Only letters and white space allowed.');
    }

    if (!req($values['last_name'])) {
        $addError('last_name', 'Last name is required.');
    } elseif (!alphaSpace($values['last_name'])) {
        $addError('last_name', 'Only letters and white space allowed.');
    }

    if (!req($values['dob'])) {
        $addError('dob', 'Date of birth is required.');
    }

    if (!req($values['gender'])) {
        $addError('gender', 'Please choose a gender.');
    }

    if (!req($values['email'])) {
        $addError('email', 'Email is required.');
    } elseif (!validEmailFormat($values['email'])) {
        $addError('email', 'Invalid email format.');
    }

    if (!req($values['hometown'])) {
        $addError('hometown', 'Hometown is required.');
    }

    if (strcasecmp($values['email'], $originalRecord['Email']) !== 0) {
        foreach ($lines as $line) {
            $record = parseDelimitedRecord($line);
            if (!array_key_exists('Email', $record)) {
                continue;
            }
            if (strcasecmp($record['Email'], $values['email']) === 0) {
                $addError('email', 'Another account already uses this email.');
                break;
            }
        }
    }

    if (!$errors) {
        $dobFormatted = $values['dob'];
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $values['dob'])) {
            $dobFormatted = date('d-m-Y', strtotime($values['dob']));
        }

        $updatedLine = 'First Name:' . $values['first_name']
                     . '|Last Name:' . $values['last_name']
                     . '|DOB:' . $dobFormatted
                     . '|Gender:' . $values['gender']
                     . '|Email:' . $values['email']
                     . '|Hometown:' . $values['hometown']
                     . '|Password:' . ($originalRecord['Password'] ?? '');

        $lines[$originalLineIndex] = $updatedLine;
        file_put_contents($userFile, implode(PHP_EOL, $lines) . PHP_EOL);

        // Update session variables
        $_SESSION['user_email'] = $values['email'];
        $_SESSION['first_name'] = $values['first_name'];
        $_SESSION['user_name']  = trim($values['first_name'] . ' ' . $values['last_name']);

        // Redirect to refresh the page and show updated data
        header('Location: update_profile.php?success=1');
        exit;
    }
}

// Check if redirected after successful update
if (isset($_GET['success']) && $_GET['success'] == '1') {
    $success = true;
}

$customProfile = __DIR__ . '/img/profile.jpg';
$imageSrc = file_exists($customProfile) ? 'img/profile.jpg' : profileImagePath($values['gender'] ?? null);
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="author" content="Neng Yi Chieng" />
  <title>Root Flowers - Update Profile</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />
  <link rel="stylesheet" href="./style/style.css" />
</head>
<body class="rf-page">
  <?php include __DIR__ . '/nav.php'; ?>

  <main class="rf-main">
    <section class="rf-section" aria-labelledby="update-profile">
      <header class="rf-section-header">
        <h1 id="update-profile" class="rf-section-title">Update profile</h1>
        <p class="rf-section-text">Edit your details below. The avatar updates automatically based on the selected gender.</p>
      </header>
    </section>

    <?php if (isset($errorMessage)): ?>
      <div class="alert alert-danger" role="alert"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></div>
    <?php else: ?>
      <?php if ($success): ?>
        <div class="alert alert-success" role="alert">Profile updated successfully.</div>
      <?php endif; ?>

      <form class="rf-section rf-profile" method="post" action="update_profile.php" novalidate>
        <div class="rf-card rf-profile-card">
          <div class="rf-card-body">
            <div class="rf-profile-media">
              <img src="<?php echo htmlspecialchars($imageSrc); ?>" alt="Profile avatar" />
            </div>
            <div class="row g-4">
              <div class="col-md-6">
                <label class="form-label" for="first_name">First Name</label>
                <input class="form-control" type="text" id="first_name" name="first_name" value="<?php echo old('first_name', $values); ?>" required>
                <?php foreach (fieldErrors('first_name', $errors) as $msg): ?>
                  <small class="text-danger d-block"><?php echo htmlspecialchars($msg, ENT_QUOTES); ?></small>
                <?php endforeach; ?>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="last_name">Last Name</label>
                <input class="form-control" type="text" id="last_name" name="last_name" value="<?php echo old('last_name', $values); ?>" required>
                <?php foreach (fieldErrors('last_name', $errors) as $msg): ?>
                  <small class="text-danger d-block"><?php echo htmlspecialchars($msg, ENT_QUOTES); ?></small>
                <?php endforeach; ?>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="dob">Date of Birth</label>
                <input class="form-control" type="date" id="dob" name="dob" value="<?php echo old('dob', $values); ?>" required>
                <?php foreach (fieldErrors('dob', $errors) as $msg): ?>
                  <small class="text-danger d-block"><?php echo htmlspecialchars($msg, ENT_QUOTES); ?></small>
                <?php endforeach; ?>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="gender">Gender</label>
                <select class="form-select" id="gender" name="gender" required>
                  <option value="Female" <?php echo ($values['gender'] ?? 'Female') === 'Female' ? 'selected' : ''; ?>>Female</option>
                  <option value="Male" <?php echo ($values['gender'] ?? 'Female') === 'Male' ? 'selected' : ''; ?>>Male</option>
                </select>
                <?php foreach (fieldErrors('gender', $errors) as $msg): ?>
                  <small class="text-danger d-block"><?php echo htmlspecialchars($msg, ENT_QUOTES); ?></small>
                <?php endforeach; ?>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="email">Email</label>
                <input class="form-control" type="email" id="email" name="email" value="<?php echo old('email', $values); ?>" required>
                <?php foreach (fieldErrors('email', $errors) as $msg): ?>
                  <small class="text-danger d-block"><?php echo htmlspecialchars($msg, ENT_QUOTES); ?></small>
                <?php endforeach; ?>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="hometown">Hometown</label>
                <input class="form-control" type="text" id="hometown" name="hometown" value="<?php echo old('hometown', $values); ?>" required>
                <?php foreach (fieldErrors('hometown', $errors) as $msg): ?>
                  <small class="text-danger d-block"><?php echo htmlspecialchars($msg, ENT_QUOTES); ?></small>
                <?php endforeach; ?>
              </div>
            </div>
            <div class="rf-profile-actions mt-4">
              <button type="submit" class="rf-button">Update profile</button>
              <a class="rf-button rf-button-outline" href="main_menu.php">Cancel</a>
            </div>
          </div>
        </div>
      </form>
    <?php endif; ?>
  </main>

  <?php include __DIR__ . '/footer.php'; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
