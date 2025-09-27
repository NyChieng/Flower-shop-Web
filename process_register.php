<?php
// COS30020/process_register.php — Task 10
// Validates input, writes to xampp/data/User/user.txt, shows errors or redirects to login

session_start();

// -------- Storage helpers (xampp/data/User/user.txt) --------
function rf_user_file(): string {
  // parent of htdocs (e.g., C:\xampp or /opt/lampp)
  $xamppRoot = dirname($_SERVER['DOCUMENT_ROOT']);
  return rtrim($xamppRoot, '/\\') . '/data/User/user.txt';
}
function rf_ensure_store(): void {
  $file = rf_user_file();
  $dir  = dirname($file);
  if (!is_dir($dir)) { mkdir($dir, 0777, true); }
  if (!file_exists($file)) { touch($file); }
}

// -------- Validation helpers --------
function clean($s){ return trim($s ?? ''); }
function valid_name($s){ return (bool)preg_match('/^[A-Za-z ]+$/', $s); }
function valid_email($s){ return (bool)filter_var($s, FILTER_VALIDATE_EMAIL); }
function valid_password($s){
  return strlen($s) >= 8 && preg_match('/\d/', $s) && preg_match('/[^A-Za-z0-9]/', $s);
}
function email_exists($email): bool {
  $file = rf_user_file();
  if (!file_exists($file)) return false;
  $fp = fopen($file, 'r');
  if (!$fp) return false;
  $exists = false;
  while (($line = fgets($fp)) !== false) {
    if (preg_match('/\bEmail:([^|]+)/', $line, $m)) {
      if (strcasecmp(trim($m[1]), $email) === 0) { $exists = true; break; }
    }
  }
  fclose($fp);
  return $exists;
}

// -------- Only accept POST from registration.php --------
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: registration.php'); exit;
}

// -------- Collect inputs --------
$first   = clean($_POST['first_name'] ?? '');
$last    = clean($_POST['last_name'] ?? '');
$dob     = clean($_POST['dob'] ?? '');
$gender  = clean($_POST['gender'] ?? 'Female');
$email   = clean($_POST['email'] ?? '');
$town    = clean($_POST['hometown'] ?? '');
$pass    = clean($_POST['password'] ?? '');
$confirm = clean($_POST['confirm_password'] ?? '');

// -------- Validate --------
$errors = [];
if ($first===''||$last===''||$dob===''||$gender===''||$email===''||$town===''||$pass===''||$confirm==='') {
  $errors[] = 'All fields are mandatory.';
}
if ($first && !valid_name($first))   $errors[] = 'First name should contain alphabets and spaces only.';
if ($last  && !valid_name($last))    $errors[] = 'Last name should contain alphabets and spaces only.';
if ($email && !valid_email($email))  $errors[] = 'Email format is invalid.';
if ($pass  && !valid_password($pass))$errors[] = 'Password must have at least 8 characters, with at least 1 number and 1 symbol.';
if ($pass !== $confirm)              $errors[] = 'Confirm password must be the same as password.';

// -------- Uniqueness (email) --------
rf_ensure_store();
if ($email && email_exists($email)) {
  $errors[] = 'There is an existing account.';
}

// -------- On error: render a page with Bootstrap styling (no write) --------
if (!empty($errors)) {
  ?>
  <!doctype html>
  <html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registration — Errors</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style/style.css">
  </head>
  <body>
    <?php if (file_exists(__DIR__.'/nav.php')) include __DIR__.'/nav.php'; ?>

    <main class="py-5">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-7">
            <div class="card border-0 shadow-sm">
              <div class="card-body p-4 p-md-5">
                <h1 class="h4 mb-3">Registration Form</h1>

                <div class="alert alert-danger mb-4">
                  <strong>We couldn’t submit your form.</strong>
                  <ul class="mb-0">
                    <?php foreach ($errors as $e): ?>
                      <li><?php echo htmlspecialchars($e, ENT_QUOTES); ?></li>
                    <?php endforeach; ?>
                  </ul>
                </div>

                <!-- Re-show the form values so user can fix them quickly -->
                <form action="process_register.php" method="post" novalidate>
                  <div class="row g-3">
                    <div class="col-md-6">
                      <label class="form-label">First Name</label>
                      <input type="text" class="form-control" name="first_name" value="<?php echo htmlspecialchars($first); ?>">
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Last Name</label>
                      <input type="text" class="form-control" name="last_name" value="<?php echo htmlspecialchars($last); ?>">
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Date of Birth</label>
                      <input type="date" class="form-control" name="dob" value="<?php echo htmlspecialchars($dob); ?>">
                    </div>
                    <div class="col-md-6">
                      <span class="form-label d-block">Gender</span>
                      <div class="d-flex gap-4 pt-1">
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="gender" id="gF" value="Female" <?php echo ($gender==='Female'?'checked':''); ?>>
                          <label class="form-check-label" for="gF">Female</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="gender" id="gM" value="Male" <?php echo ($gender==='Male'?'checked':''); ?>>
                          <label class="form-check-label" for="gM">Male</label>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Email (Text input)</label>
                      <input type="text" class="form-control" name="email" value="<?php echo htmlspecialchars($email); ?>">
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Hometown</label>
                      <input type="text" class="form-control" name="hometown" value="<?php echo htmlspecialchars($town); ?>">
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Password (Text input)</label>
                      <input type="text" class="form-control" name="password" value="<?php echo htmlspecialchars($pass); ?>">
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Confirm Password (Text input)</label>
                      <input type="text" class="form-control" name="confirm_password" value="<?php echo htmlspecialchars($confirm); ?>">
                    </div>
                  </div>

                  <div class="d-flex gap-2 pt-4">
                    <button type="submit" name="submit" class="btn btn-dark">Submit Form</button>
                    <button type="reset" class="btn btn-outline-dark">Reset Form</button>
                    <a href="login.php" class="btn btn-secondary">Back to Login</a>
                  </div>
                </form>

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

// -------- Save to TXT (exact format + newline) --------
$dob_fmt = preg_match('/^\d{4}-\d{2}-\d{2}$/', $dob) ? date('d-m-Y', strtotime($dob)) : $dob;
$line = 'First Name:'.$first
      . '|Last Name:'.$last
      . '|DOB:'.$dob_fmt
      . '|Gender:'.$gender
      . '|Email:'.$email
      . '|Hometown:'.$town
      . '|Password:'.$pass;

file_put_contents(rf_user_file(), $line . PHP_EOL, FILE_APPEND);

// -------- Success: redirect to Login --------
header('Location: login.php?registered=1');
exit;
