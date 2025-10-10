<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$storedValues = $_SESSION['register_values'] ?? [
    'first_name'       => '',
    'last_name'        => '',
    'dob'              => '',
    'gender'           => 'Female',
    'email'            => '',
    'hometown'         => '',
];
$errors = $_SESSION['register_errors'] ?? [];
unset($_SESSION['register_values'], $_SESSION['register_errors']);

function old(string $key, array $values): string
{
    return htmlspecialchars($values[$key] ?? '', ENT_QUOTES);
}

function fieldErrors(string $key, array $errors): array
{
    return $errors[$key] ?? [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="author" content="Neng Yi Chieng" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Root Flowers - Registration</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="style/style.css" />
</head>
<body>

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
      <h1>Registration Form</h1>
      <p>Please fill in all fields. Email &amp; passwords are <strong>text</strong> inputs as required.</p>
    </div>
  </header>

  <main class="py-5">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="card register-card">
            <div class="card-body">

              <?php if (!empty($errors)): ?>
                <div class="alert alert-danger" role="alert">
                  We couldn't submit your form. Please fix the highlighted fields below.
                </div>
              <?php endif; ?>

              <?php $proc = rtrim(dirname($_SERVER['REQUEST_URI']), '/\\') . '/process_register.php'; ?>
              <form action="<?php echo $proc; ?>" method="post" novalidate>
                <div class="row g-4">

                  <div class="col-md-6">
                    <label for="first_name" class="form-label">First Name</label>
                    <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo old('first_name', $storedValues); ?>" required>
                    <?php foreach (fieldErrors('first_name', $errors) as $msg): ?>
                      <small class="text-danger d-block"><?php echo htmlspecialchars($msg, ENT_QUOTES); ?></small>
                    <?php endforeach; ?>
                  </div>

                  <div class="col-md-6">
                    <label for="last_name" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo old('last_name', $storedValues); ?>" required>
                    <?php foreach (fieldErrors('last_name', $errors) as $msg): ?>
                      <small class="text-danger d-block"><?php echo htmlspecialchars($msg, ENT_QUOTES); ?></small>
                    <?php endforeach; ?>
                  </div>

                  <div class="col-md-6">
                    <label for="dob" class="form-label">Date of Birth</label>
                    <input type="date" class="form-control" id="dob" name="dob" value="<?php echo old('dob', $storedValues); ?>" required>
                    <?php foreach (fieldErrors('dob', $errors) as $msg): ?>
                      <small class="text-danger d-block"><?php echo htmlspecialchars($msg, ENT_QUOTES); ?></small>
                    <?php endforeach; ?>
                  </div>

                  <div class="col-md-6">
                    <label for="gender" class="form-label">Gender</label>
                    <select class="form-select" id="gender" name="gender" required>
                      <option value="Female" <?php echo ($storedValues['gender'] ?? 'Female') === 'Female' ? 'selected' : ''; ?>>Female</option>
                      <option value="Male" <?php echo ($storedValues['gender'] ?? 'Female') === 'Male' ? 'selected' : ''; ?>>Male</option>
                    </select>
                    <?php foreach (fieldErrors('gender', $errors) as $msg): ?>
                      <small class="text-danger d-block"><?php echo htmlspecialchars($msg, ENT_QUOTES); ?></small>
                    <?php endforeach; ?>
                  </div>

                  <div class="col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo old('email', $storedValues); ?>" required>
                    <?php foreach (fieldErrors('email', $errors) as $msg): ?>
                      <small class="text-danger d-block"><?php echo htmlspecialchars($msg, ENT_QUOTES); ?></small>
                    <?php endforeach; ?>
                  </div>

                  <div class="col-md-6">
                    <label for="hometown" class="form-label">Hometown</label>
                    <input type="text" class="form-control" id="hometown" name="hometown" value="<?php echo old('hometown', $storedValues); ?>" required>
                    <?php foreach (fieldErrors('hometown', $errors) as $msg): ?>
                      <small class="text-danger d-block"><?php echo htmlspecialchars($msg, ENT_QUOTES); ?></small>
                    <?php endforeach; ?>
                  </div>

                  <div class="col-md-6">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                      <input type="password" class="form-control" id="password" name="password" required>
                      <button class="btn btn-outline-secondary toggle-password" type="button" data-target="password" aria-label="Toggle password visibility">
                        <i class="bi bi-eye"></i>
                      </button>
                    </div>
                    <?php foreach (fieldErrors('password', $errors) as $msg): ?>
                      <small class="text-danger d-block"><?php echo htmlspecialchars($msg, ENT_QUOTES); ?></small>
                    <?php endforeach; ?>
                  </div>

                  <div class="col-md-6">
                    <label for="confirm_password" class="form-label">Confirm Password</label>
                    <div class="input-group">
                      <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                      <button class="btn btn-outline-secondary toggle-password" type="button" data-target="confirm_password" aria-label="Toggle confirm password visibility">
                        <i class="bi bi-eye"></i>
                      </button>
                    </div>
                    <?php foreach (fieldErrors('confirm_password', $errors) as $msg): ?>
                      <small class="text-danger d-block"><?php echo htmlspecialchars($msg, ENT_QUOTES); ?></small>
                    <?php endforeach; ?>
                  </div>
                </div>

                <div class="d-flex flex-wrap gap-2 pt-4">
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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.querySelectorAll('.toggle-password').forEach(function (button) {
      button.addEventListener('click', function () {
        var targetId = this.getAttribute('data-target');
        var input = document.getElementById(targetId);
        if (!input) {
          return;
        }
        var isPassword = input.getAttribute('type') === 'password';
        input.setAttribute('type', isPassword ? 'text' : 'password');
        this.querySelector('i').classList.toggle('bi-eye');
        this.querySelector('i').classList.toggle('bi-eye-slash');
        this.setAttribute('aria-label', isPassword ? 'Hide password' : 'Show password');
      });
    });
  </script>
</body>
</html>
