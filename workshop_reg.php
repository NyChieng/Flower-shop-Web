<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/validate.php';
require_once __DIR__ . '/files.php';

startSessionIfNeeded();
requireLogin('workshop_reg.php');

$storedValues = $_SESSION['workshop_reg_values'] ?? [
    'first_name'        => '',
    'last_name'         => '',
    'contact_number'    => '',
    'email'             => '',
    'workshop_datetime' => '',
    'workshop_title'    => '',
];
$errors = $_SESSION['workshop_reg_errors'] ?? [];
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

function oldValue(string $key, array $values): string
{
    return htmlspecialchars($values[$key] ?? '', ENT_QUOTES);
}

function fieldErrorLines(string $key, array $errors): array
{
    return $errors[$key] ?? [];
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

    if (!empty($errs)) {
        $_SESSION['workshop_reg_errors'] = $errs;
        $_SESSION['workshop_reg_values'] = $values;
        header('Location: workshop_reg.php');
        exit;
    }

    $filePath = __DIR__ . '/data/User/workshop_reg.txt';

    $dtFormatted = $values['workshop_datetime'];
    if (preg_match('/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}$/', $values['workshop_datetime'])) {
        $dtFormatted = date('d-m-Y H:i', strtotime($values['workshop_datetime']));
    }

    $record = 'First Name:' . $values['first_name']
            . '|Last Name:' . $values['last_name']
            . '|Contact:' . $values['contact_number']
            . '|Email:' . $values['email']
            . '|Workshop DateTime:' . $dtFormatted
            . '|Workshop Title:' . $values['workshop_title'];

    appendLine($filePath, $record);

    $_SESSION['flash'] = 'Workshop registration saved. We will be in touch!';
    header('Location: workshops.php');
    exit;
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
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
              <label class="form-label" for="email">Email (Text input)</label>
              <input class="form-control" type="text" id="email" name="email" value="<?php echo oldValue('email', $storedValues); ?>" required>
              <?php foreach (fieldErrorLines('email', $errors) as $msg): ?>
                <small class="text-danger d-block"><?php echo htmlspecialchars($msg, ENT_QUOTES); ?></small>
              <?php endforeach; ?>
            </div>
            <div class="col-md-6">
              <label class="form-label" for="workshop_datetime">Workshop Date &amp; Time</label>
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
