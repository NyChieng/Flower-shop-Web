<?php
// process_register.php — validates, writes to xampp/data/User/user.txt, redirects or shows errors
session_start();

/* ---- Where to store the TXT (xampp/data/User/user.txt) ---- */
function user_file_path(): string {
  // parent of htdocs (C:\xampp on Windows; /opt/lampp on Linux)
  $root = dirname($_SERVER['DOCUMENT_ROOT']);
  return rtrim($root, '/\\') . '/data/User/user.txt';
}
function ensure_user_store(): void {
  $file = user_file_path();
  $dir  = dirname($file);
  if (!is_dir($dir)) { mkdir($dir, 0777, true); } // auto-create /data/User
  if (!file_exists($file)) { touch($file); }      // auto-create user.txt
}

/* ---- Validation helpers ---- */
function clean($s){ return trim($s ?? ''); }
function valid_name($s){ return (bool)preg_match('/^[A-Za-z ]+$/', $s); }
function valid_email($s){ return (bool)filter_var($s, FILTER_VALIDATE_EMAIL); }
function valid_password($s){
  return strlen($s) >= 8 && preg_match('/\d/',$s) && preg_match('/[^A-Za-z0-9]/',$s);
}
function email_exists($email): bool {
  $file = user_file_path();
  if (!file_exists($file)) return false;
  $fh = fopen($file, 'r'); if(!$fh) return false;
  $exists = false;
  while (($line = fgets($fh)) !== false) {
    if (preg_match('/\bEmail:([^|]+)/', $line, $m)) {
      if (strcasecmp(trim($m[1]), $email) === 0) { $exists = true; break; }
    }
  }
  fclose($fh);
  return $exists;
}

/* ---- POST only ---- */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: registration.php'); exit;
}

/* ---- Collect fields ---- */
$first   = clean($_POST['first_name'] ?? '');
$last    = clean($_POST['last_name'] ?? '');
$dob     = clean($_POST['dob'] ?? '');
$gender  = clean($_POST['gender'] ?? 'Female');
$email   = clean($_POST['email'] ?? '');
$town    = clean($_POST['hometown'] ?? '');
$pass    = clean($_POST['password'] ?? '');
$confirm = clean($_POST['confirm_password'] ?? '');

/* ---- Validate ---- */
$errors = [];
if ($first===''||$last===''||$dob===''||$gender===''||$email===''||$town===''||$pass===''||$confirm==='') {
  $errors[]='All fields are mandatory.';
}
if ($first && !valid_name($first))    $errors[]='First name should contain alphabets and spaces only.';
if ($last  && !valid_name($last))     $errors[]='Last name should contain alphabets and spaces only.';
if ($email && !valid_email($email))   $errors[]='Email format is invalid.';
if ($pass  && !valid_password($pass)) $errors[]='Password must have at least 8 characters, with at least 1 number and 1 symbol.';
if ($pass !== $confirm)               $errors[]='Confirm password must be the same as password.';

/* ---- Ensure store & uniqueness ---- */
ensure_user_store();
if ($email && email_exists($email)) {
  $errors[]='There is an existing account.';
}

/* ---- If errors: show them (Bootstrap) ---- */
if ($errors) {
  ?>
  <!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Registration — Errors</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="style/style.css" />
  </head>
  <body>
    <?php if (file_exists(__DIR__.'/nav.php')) include __DIR__.'/nav.php'; ?>

    <header class="page-header">
      <div class="container">
        <h1>Registration Form</h1>
        <p>Please fix the errors below and submit again.</p>
      </div>
    </header>

    <main class="py-5">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-8">
            <div class="card register-card">
              <div class="card-body">
                <div class="alert alert-danger">
                  <strong>We couldn’t submit your form.</strong>
                  <ul class="mb-0">
                    <?php foreach ($errors as $e): ?>
                      <li><?= htmlspecialchars($e, ENT_QUOTES) ?></li>
                    <?php endforeach; ?>
                  </ul>
                </div>

                <a class="btn btn-dark" href="registration.php">Back to Registration</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>

    <?php if (file_exists(__DIR__.'/footer.php')) include __DIR__.'/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
  </html>
  <?php
  exit;
}

/* ---- Save to TXT (exact format) ---- */
$dob_fmt = preg_match('/^\d{4}-\d{2}-\d{2}$/',$dob) ? date('d-m-Y', strtotime($dob)) : $dob;

$record = 'First Name:'.$first
        . '|Last Name:'.$last
        . '|DOB:'.$dob_fmt
        . '|Gender:'.$gender
        . '|Email:'.$email
        . '|Hometown:'.$town
        . '|Password:'.$pass;

file_put_contents(user_file_path(), $record.PHP_EOL, FILE_APPEND);

/* ---- Success: redirect to login ---- */
header('Location: login.php?registered=1');
exit;
