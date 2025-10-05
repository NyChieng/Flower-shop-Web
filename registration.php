<?php
session_start();

$storedValues = $_SESSION['register_values'] ?? [
    'first_name'       => '',
    'last_name'        => '',
    'dob'              => '',
    'gender'           => 'Female',
    'email'            => '',
    'hometown'         => '',
    'password'         => '',
    'confirm_password' => '',
];
$errors = $_SESSION['register_errors'] ?? [];
unset($_SESSION['register_values'], $_SESSION['register_errors']);

function old(string $key, array $values): string
{
    return htmlspecialchars($values[$key] ?? '', ENT_QUOTES);
}

function errorList(string $key, array $errors): array
{
    return $errors[$key] ?? [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Register · Root Flowers</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="style/style.css" />
</head>
<body>

  <?php include __DIR__ . '/nav.php'; ?>

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
                  We couldn&rsquo;t submit your form. Please fix the highlighted fields below.
                </div>
              <?php endif; ?>

              <?php $proc = rtrim(dirname($_SERVER['REQUEST_URI']), '/\\') . '/process_register.php'; ?>
              <form action="<?php echo $proc; ?>" method="post" novalidate>
                <div class="row g-4">

                  <div class="col-md-6">
                    <label for="first_name" class="form-label">First Name</label>
                    <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo old('first_name', $storedValues); ?>" required>
                    <?php foreach (errorList('first_name', $errors) as $msg): ?>
                      <small class="text-danger d-block"><?php echo htmlspecialchars($msg, ENT_QUOTES); ?></small>
                    <?php endforeach; ?>
                  </div>

                  <div class="col-md-6">
                    <label for="last_name" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo old('last_name', $storedValues); ?>" required>
                    <?php foreach (errorList('last_name', $errors) as $msg): ?>
                      <small class="text-danger d-block"><?php echo htmlspecialchars($msg, ENT_QUOTES); ?></small>
                    <?php endforeach; ?>
                  </div>

                  <div class="col-md-6">
                    <label for="dob" class="form-label">Date of Birth</label>
                    <input type="date" class="form-control" id="dob" name="dob" value="<?php echo old('dob', $storedValues); ?>" required>
                    <?php foreach (errorList('dob', $errors) as $msg): ?>
                      <small class="text-danger d-block"><?php echo htmlspecialchars($msg, ENT_QUOTES); ?></small>
                    <?php endforeach; ?>
                  </div>

                  <div class="col-md-6">
                    <span class="form-label d-block">Gender</span>
                    <div class="d-flex gap-4 pt-1">
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" id="gender_f" value="Female" <?php echo ($storedValues['gender'] ?? 'Female') === 'Female' ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="gender_f">Female</label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" id="gender_m" value="Male" <?php echo ($storedValues['gender'] ?? 'Female') === 'Male' ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="gender_m">Male</label>
                      </div>
                    </div>
                    <?php foreach (errorList('gender', $errors) as $msg): ?>
                      <small class="text-danger d-block"><?php echo htmlspecialchars($msg, ENT_QUOTES); ?></small>
                    <?php endforeach; ?>
                  </div>

                  <div class="col-md-6">
                    <label for="email" class="form-label">Email (Text input)</label>
                    <input type="text" class="form-control" id="email" name="email" value="<?php echo old('email', $storedValues); ?>" required>
                    <?php foreach (errorList('email', $errors) as $msg): ?>
                      <small class="text-danger d-block"><?php echo htmlspecialchars($msg, ENT_QUOTES); ?></small>
                    <?php endforeach; ?>
                  </div>

                  <div class="col-md-6">
                    <label for="hometown" class="form-label">Hometown</label>
                    <input type="text" class="form-control" id="hometown" name="hometown" value="<?php echo old('hometown', $storedValues); ?>" required>
                    <?php foreach (errorList('hometown', $errors) as $msg): ?>
                      <small class="text-danger d-block"><?php echo htmlspecialchars($msg, ENT_QUOTES); ?></small>
                    <?php endforeach; ?>
                  </div>

                  <div class="col-md-6">
                    <label for="password" class="form-label">Password (Text input)</label>
                    <input type="text" class="form-control" id="password" name="password" required>
                    <?php foreach (errorList('password', $errors) as $msg): ?>
                      <small class="text-danger d-block"><?php echo htmlspecialchars($msg, ENT_QUOTES); ?></small>
                    <?php endforeach; ?>
                  </div>
                  <div class="col-md-6">
                    <label for="confirm_password" class="form-label">Confirm Password (Text input)</label>
                    <input type="text" class="form-control" id="confirm_password" name="confirm_password" required>
                    <?php foreach (errorList('confirm_password', $errors) as $msg): ?>
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

  <?php include __DIR__ . '/footer.php'; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
