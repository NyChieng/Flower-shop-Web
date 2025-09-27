<?php
// login.php — reads xampp/data/User/user.txt, authenticates, sets session, redirects
session_start();

function user_file_path(): string {
  $root = dirname($_SERVER['DOCUMENT_ROOT']);
  return rtrim($root, '/\\') . '/data/User/user.txt';
}

$login_error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = trim($_POST['email'] ?? '');
  $password = trim($_POST['password'] ?? '');

  if ($email === '' || $password === '') {
    $login_error = 'Please enter both email and password.';
  } else {
    $file = user_file_path();
    if (file_exists($file)) {
      $fh = fopen($file, 'r');
      if ($fh) {
        $ok = false; $user = [];
        while (($line = fgets($fh)) !== false) {
          $parts = array_map('trim', explode('|', $line));
          $fields = [];
          foreach ($parts as $p) {
            $kv = explode(':', $p, 2);
            if (count($kv) === 2) $fields[trim($kv[0])] = trim($kv[1]);
          }
          if (isset($fields['Email'], $fields['Password'])
              && strcasecmp($fields['Email'], $email) === 0
              && $fields['Password'] === $password) {
            $ok = true; $user = $fields; break;
          }
        }
        fclose($fh);

        if ($ok) {
          $_SESSION['user_email'] = $user['Email'];
          $_SESSION['user_name']  = trim(($user['First Name'] ?? '').' '.($user['Last Name'] ?? ''));
          header('Location: index.php'); // or main_menu.php
          exit;
        } else {
          $login_error = 'Invalid email or password.';
        }
      } else {
        $login_error = 'System error opening user store.';
      }
    } else {
      $login_error = 'No users registered yet.';
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login • Root Flowers</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="style/style.css" />
</head>
<body>
  <?php include __DIR__ . '/nav.php'; ?>

  <header class="page-header">
    <div class="container">
      <h1>Login</h1>
      <?php if (isset($_GET['registered'])): ?>
        <p>Account created. Please login.</p>
      <?php else: ?>
        <p>Enter your email and password.</p>
      <?php endif; ?>
    </div>
  </header>

  <main class="py-5">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
          <div class="card register-card">
            <div class="card-body">
              <?php if ($login_error): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($login_error, ENT_QUOTES) ?></div>
              <?php endif; ?>

              <form action="login.php" method="post" novalidate>
                <div class="mb-3">
                  <label class="form-label" for="email">Email address</label>
                  <input class="form-control" type="email" id="email" name="email" required>
                </div>
                <div class="mb-3">
                  <label class="form-label" for="password">Password</label>
                  <input class="form-control" type="password" id="password" name="password" required>
                </div>
                <div class="d-flex gap-2">
                  <button type="submit" class="btn btn-dark">Login</button>
                  <a href="registration.php" class="btn btn-outline-dark">Register</a>
                </div>
              </form>

            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <?php include __DIR__ . '/footer.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
