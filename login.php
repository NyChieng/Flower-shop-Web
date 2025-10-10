<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

function user_file_path(): string
{
    $xamppRoot = dirname(__DIR__, 3);
    $userDir = $xamppRoot . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'User';
    if (!is_dir($userDir)) {
        mkdir($userDir, 0775, true);
    }
    return $userDir . DIRECTORY_SEPARATOR . 'user.txt';
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

function loginUser(string $email): void
{
    session_regenerate_id(true);
    $_SESSION['user_email'] = $email;
}

function sanitize_redirect(string $target): string
{
    if ($target === '') {
        return 'main_menu.php';
    }
    if (preg_match('/^(?:[a-z][a-z0-9+.-]*:|\/\/)/i', $target)) {
        return 'main_menu.php';
    }
    return ltrim($target, '/');
}

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$redirect = sanitize_redirect($_GET['redirect'] ?? ($_POST['redirect'] ?? 'main_menu.php'));
$email = trim($_POST['email'] ?? '');
$login_error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = trim($_POST['password'] ?? '');

    if ($email === '' || $password === '') {
        $login_error = 'Please enter both email and password.';
    } else {
        $file = user_file_path();
        if (file_exists($file) && ($fh = fopen($file, 'r'))) {
            $ok = false;
            $user = [];
            while (($line = fgets($fh)) !== false) {
                $fields = parseDelimitedRecord($line);
                if (isset($fields['Email'], $fields['Password'])
                    && strcasecmp($fields['Email'], $email) === 0
                    && $fields['Password'] === $password) {
                    $ok = true;
                    $user = $fields;
                    break;
                }
            }
            fclose($fh);

            if ($ok) {
                loginUser($user['Email']);
                $_SESSION['user_name']  = trim(($user['First Name'] ?? '') . ' ' . ($user['Last Name'] ?? ''));
                $_SESSION['first_name'] = $user['First Name'] ?? null;
                $_SESSION['last_name']  = $user['Last Name'] ?? null;

                header('Location: ' . $redirect);
                exit;
            }

            $login_error = 'Invalid email or password.';
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
  <meta name="author" content="Neng Yi Chieng" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Root Flowers - Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="style/style.css" />
</head>
<body class="layout-page">

  <header class="py-3 border-bottom bg-white shadow-sm">
    <div class="container">
      <a class="d-flex align-items-center gap-2 text-decoration-none" href="index.php">
        <img src="img/logo_1.jpg" alt="Root Flowers logo" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;" />
        <span class="fw-bold fs-5">
          <i class="bi bi-flower1 me-1 text-danger"></i>Root Flowers
        </span>
      </a>
    </div>
  </header>

  <header class="page-header">
    <div class="container">
      <h1>Login</h1>
      <p><?php echo isset($_GET['registered']) ? 'Account created. Please login.' : 'Enter your email and password.'; ?></p>
    </div>
  </header>

  <main class="content-grow py-5">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6 col-xl-5">
          <div class="card auth-card">
            <div class="card-body p-4 p-md-5">
              <?php if ($flash): ?>
                <div class="alert alert-info mb-4"><?php echo htmlspecialchars($flash, ENT_QUOTES); ?></div>
              <?php endif; ?>
              <?php if ($login_error): ?>
                <div class="alert alert-danger mb-4"><?php echo htmlspecialchars($login_error, ENT_QUOTES); ?></div>
              <?php endif; ?>

              <form action="login.php" method="post" novalidate>
                <input type="hidden" name="redirect" value="<?php echo htmlspecialchars($redirect, ENT_QUOTES); ?>" />
                <div class="mb-3">
                  <label class="form-label" for="email">Email address</label>
                  <input class="form-control" type="email" id="email" name="email" required value="<?php echo htmlspecialchars($email, ENT_QUOTES); ?>">
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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

