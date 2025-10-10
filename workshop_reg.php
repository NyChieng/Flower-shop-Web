<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (empty($_SESSION['user_email'])) {
    $_SESSION['flash'] = 'Please login to continue.';
    header('Location: login.php?redirect=' . urlencode('workshop_reg.php'));
    exit;
}

function ensureDir(string $directory): void
{
    if ($directory === '' || is_dir($directory)) {
        return;
    }
    mkdir($directory, 0775, true);
}

function appendLine(string $filePath, string $line): void
{
    ensureDir(dirname($filePath));
    $handle = fopen($filePath, 'a');
    if ($handle === false) {
        throw new RuntimeException('Unable to open file for writing: ' . $filePath);
    }

    try {
        if (!flock($handle, LOCK_EX)) {
            throw new RuntimeException('Unable to obtain file lock: ' . $filePath);
        }
        fwrite($handle, $line . PHP_EOL);
        fflush($handle);
        flock($handle, LOCK_UN);
    } finally {
        fclose($handle);
    }
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

function readDelimitedRecords(string $filePath, string $pairDelimiter = '|'): array
{
    $records = [];
    foreach (readLines($filePath) as $line) {
        if (trim($line) === '') {
            continue;
        }
        $records[] = parseDelimitedRecord($line, $pairDelimiter);
    }

    return $records;
}

function findRecordByField(string $filePath, string $field, string $value, bool $caseInsensitive = true): ?array
{
    if (!file_exists($filePath)) {
        return null;
    }

    foreach (readDelimitedRecords($filePath) as $record) {
        if (!array_key_exists($field, $record)) {
            continue;
        }

        $storedValue = $record[$field];
        if ($caseInsensitive) {
            if (strcasecmp($storedValue, $value) === 0) {
                return $record;
            }
        } elseif ($storedValue === $value) {
            return $record;
        }
    }

    return null;
}

function req($value): bool
{
    return isset($value) && trim($value) !== '';
}

function alphaSpace(string $value): bool
{
    return (bool)preg_match('/^[a-zA-Z ]+$/', $value);
}

function validEmailFormat(string $email): bool
{
    return (bool)filter_var($email, FILTER_VALIDATE_EMAIL);
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

function workshopRegistrationPath(): string
{
    return userDataDirectory() . DIRECTORY_SEPARATOR . 'workshop_reg.txt';
}

$currentUserEmail = $_SESSION['user_email'] ?? '';
$userFile = userDataPath();
$workshopFile = workshopRegistrationPath();
$currentUserRecord = $currentUserEmail !== '' ? findRecordByField($userFile, 'Email', $currentUserEmail) : null;

$sessionValues = $_SESSION['workshop_reg_values'] ?? null;
$sessionErrors = $_SESSION['workshop_reg_errors'] ?? [];
$hadPostBack = $sessionValues !== null;

$storedValues = $sessionValues ?? [
    'first_name'        => '',
    'last_name'         => '',
    'contact_number'    => '',
    'email'             => '',
    'workshop_datetime' => '',
    'workshop_title'    => '',
];
$errors = $sessionErrors;
unset($_SESSION['workshop_reg_values'], $_SESSION['workshop_reg_errors']);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['title']) && $storedValues['workshop_title'] === '') {
        $storedValues['workshop_title'] = trim($_GET['title']);
    }
    if (isset($_GET['datetime']) && $storedValues['workshop_datetime'] === '') {
        $storedValues['workshop_datetime'] = trim($_GET['datetime']);
    }
    if (isset($_GET['email']) && $storedValues['email'] === '' && validEmailFormat(trim($_GET['email']))) {
        $storedValues['email'] = trim($_GET['email']);
    }
}

if (!$hadPostBack && $currentUserRecord) {
    $storedValues['first_name'] = $storedValues['first_name'] ?: ($currentUserRecord['First Name'] ?? '');
    $storedValues['last_name'] = $storedValues['last_name'] ?: ($currentUserRecord['Last Name'] ?? '');
    $storedValues['email'] = $currentUserRecord['Email'] ?? $storedValues['email'];
}

function oldValue(string $key, array $values): string
{
    return htmlspecialchars($values[$key] ?? '', ENT_QUOTES);
}

function fieldErrorLines(string $key, array $errors): array
{
    return $errors[$key] ?? [];
}

function normaliseWorkshopDateTimeForComparison(string $value): ?string
{
    $value = trim($value);
    if ($value === '') {
        return null;
    }

    $formats = ['Y-m-d\\TH:i', 'Y-m-d H:i', 'd-m-Y H:i', 'd/m/Y H:i'];
    foreach ($formats as $format) {
        $dt = DateTime::createFromFormat($format, $value);
        if ($dt instanceof DateTime) {
            return $dt->format('Y-m-d H:i');
        }
    }

    $timestamp = strtotime($value);
    return $timestamp ? date('Y-m-d H:i', $timestamp) : null;
}

function formatWorkshopDateTimeForStorage(string $value): string
{
    $normalised = normaliseWorkshopDateTimeForComparison($value);
    if ($normalised === null) {
        return $value;
    }

    $dt = DateTime::createFromFormat('Y-m-d H:i', $normalised);
    return $dt ? $dt->format('d-m-Y H:i') : $value;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $values = [
        'first_name'        => trim($_POST['first_name'] ?? ''),
        'last_name'         => trim($_POST['last_name'] ?? ''),
        'contact_number'    => trim($_POST['contact_number'] ?? ''),
        'email'             => trim($_POST['email'] ?? ''),
        'workshop_datetime' => trim($_POST['workshop_datetime'] ?? ''),
        'workshop_title'    => trim($_POST['workshop_title'] ?? ''),
    ];

    $errs = [];
    $addError = function (string $key, string $message) use (&$errs) {
        $errs[$key][] = $message;
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

    if (!req($values['contact_number'])) {
        $addError('contact_number', 'Contact number is required.');
    } elseif (!preg_match('/^[0-9+\-() ]+$/', $values['contact_number'])) {
        $addError('contact_number', 'Contact number may only contain digits and + - ( ) spaces.');
    }

    if (!req($values['email'])) {
        $addError('email', 'Email is required.');
    } elseif (!validEmailFormat($values['email'])) {
        $addError('email', 'Invalid email format.');
    }

    if (!req($values['workshop_datetime'])) {
        $addError('workshop_datetime', 'Workshop date and time is required.');
    }

    if (!req($values['workshop_title'])) {
        $addError('workshop_title', 'Workshop title is required.');
    }

    if (empty($errs)) {
        $targetDate = normaliseWorkshopDateTimeForComparison($values['workshop_datetime']);
        foreach (readDelimitedRecords($workshopFile) as $record) {
            if (!isset($record['Email']) || strcasecmp($record['Email'], $values['email']) !== 0) {
                continue;
            }

            $matchesTitle = isset($record['Workshop Title']) && strcasecmp($record['Workshop Title'], $values['workshop_title']) === 0;
            $existingDate = normaliseWorkshopDateTimeForComparison($record['Workshop DateTime'] ?? '');
            $matchesDate = $targetDate !== null && $existingDate !== null && $existingDate === $targetDate;

            if ($matchesTitle || $matchesDate) {
                $addError('email', 'This email already has a registration for the selected workshop.');
                break;
            }
        }
    }

    if (!empty($errs)) {
        $_SESSION['workshop_reg_errors'] = $errs;
        $_SESSION['workshop_reg_values'] = $values;
        header('Location: workshop_reg.php');
        exit;
    }

    $dtFormatted = formatWorkshopDateTimeForStorage($values['workshop_datetime']);

    $record = 'First Name:' . $values['first_name']
            . '|Last Name:' . $values['last_name']
            . '|Contact:' . $values['contact_number']
            . '|Email:' . $values['email']
            . '|Workshop DateTime:' . $dtFormatted
            . '|Workshop Title:' . $values['workshop_title'];

    appendLine($workshopFile, $record);

    $_SESSION['flash'] = 'Workshop registration saved. We will be in touch!';
    header('Location: workshops.php');
    exit;
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="author" content="Neng Yi Chieng" />
  <title>Root Flowers - Workshop Registration</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />
  <link rel="stylesheet" href="./style/style.css" />
</head>
<body class="rf-page">
  <?php include __DIR__ . '/nav.php'; ?>

  <main class="rf-main">
    <section class="rf-section" aria-labelledby="workshop-reg">
      <header class="rf-section-header">
        <h1 id="workshop-reg" class="rf-section-title">Workshop registration</h1>
        <p class="rf-section-text">Complete the form below to reserve a seat at your chosen Root Flowers workshop.</p>
      </header>
    </section>

    <form class="rf-section" method="post" action="workshop_reg.php" novalidate>
      <div class="rf-card">
        <div class="rf-card-body">
          <div class="row g-4">
            <div class="col-md-6">
              <label class="form-label" for="first_name">First Name</label>
              <input class="form-control" type="text" id="first_name" name="first_name" value="<?php echo oldValue('first_name', $storedValues); ?>" required>
              <?php foreach (fieldErrorLines('first_name', $errors) as $msg): ?>
                <small class="text-danger d-block"><?php echo htmlspecialchars($msg, ENT_QUOTES); ?></small>
              <?php endforeach; ?>
            </div>
            <div class="col-md-6">
              <label class="form-label" for="last_name">Last Name</label>
              <input class="form-control" type="text" id="last_name" name="last_name" value="<?php echo oldValue('last_name', $storedValues); ?>" required>
              <?php foreach (fieldErrorLines('last_name', $errors) as $msg): ?>
                <small class="text-danger d-block"><?php echo htmlspecialchars($msg, ENT_QUOTES); ?></small>
              <?php endforeach; ?>
            </div>
            <div class="col-md-6">
              <label class="form-label" for="contact_number">Contact Number</label>
              <input class="form-control" type="text" id="contact_number" name="contact_number" value="<?php echo oldValue('contact_number', $storedValues); ?>" required>
              <?php foreach (fieldErrorLines('contact_number', $errors) as $msg): ?>
                <small class="text-danger d-block"><?php echo htmlspecialchars($msg, ENT_QUOTES); ?></small>
              <?php endforeach; ?>
            </div>
            <div class="col-md-6">
              <label class="form-label" for="email">Email</label>
              <input class="form-control" type="text" id="email" name="email" value="<?php echo oldValue('email', $storedValues); ?>" required>
              <?php foreach (fieldErrorLines('email', $errors) as $msg): ?>
                <small class="text-danger d-block"><?php echo htmlspecialchars($msg, ENT_QUOTES); ?></small>
              <?php endforeach; ?>
            </div>
            <div class="col-md-6">
              <label class="form-label" for="workshop_datetime">Workshop Date and Time</label>
              <input class="form-control" type="datetime-local" id="workshop_datetime" name="workshop_datetime" value="<?php echo oldValue('workshop_datetime', $storedValues); ?>" required>
              <?php foreach (fieldErrorLines('workshop_datetime', $errors) as $msg): ?>
                <small class="text-danger d-block"><?php echo htmlspecialchars($msg, ENT_QUOTES); ?></small>
              <?php endforeach; ?>
            </div>
            <div class="col-md-6">
              <label class="form-label" for="workshop_title">Workshop Title</label>
              <input class="form-control" type="text" id="workshop_title" name="workshop_title" value="<?php echo oldValue('workshop_title', $storedValues); ?>" required>
              <?php foreach (fieldErrorLines('workshop_title', $errors) as $msg): ?>
                <small class="text-danger d-block"><?php echo htmlspecialchars($msg, ENT_QUOTES); ?></small>
              <?php endforeach; ?>
            </div>
          </div>
          <div class="d-flex flex-wrap gap-2 mt-4">
            <button type="submit" class="btn btn-dark">Submit Registration</button>
            <button type="reset" class="btn btn-outline-dark">Reset Form</button>
            <a class="btn btn-secondary" href="workshops.php">Back to workshops</a>
          </div>
        </div>
      </div>
    </form>
  </main>

  <?php include __DIR__ . '/footer.php'; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
