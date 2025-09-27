<?php
// COS30020/registration.php — Task 9 form page (no inline CSS)
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Register • Root Flowers</title>

  <!-- Bootstrap (optional but you’re already using it) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Your site stylesheet -->
  <link rel="stylesheet" href="./style/style.css" />
</head>
<body class="rf-page rf-register-page">

  <?php include __DIR__ . '/nav.php'; ?>

  <!-- Hero/header area kept consistent with index.php via style.css -->
  <section class="rf-hero rf-hero--register">
    <div class="container">
      <div class="rf-hero__inner">
        <div class="rf-hero__brand">
          <div class="rf-hero__title">Root Flowers</div>
          <div class="rf-hero__subtitle">Create your account</div>
        </div>
      </div>
    </div>
  </section>

  <main class="rf-section rf-auth">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-xl-7 col-lg-8">
          <div class="card rf-card rf-auth__card">
            <div class="card-body rf-card__body">
              <h1 class="h4 rf-auth__title">Registration Form</h1>
              <p class="rf-text-muted mb-4">Please fill in all fields. Email & passwords are <strong>text</strong> inputs as required.</p>

              <!-- POST to Task 10 -->
              <form class="rf-form" action="process_register.php" method="post" novalidate>
                <div class="row g-3">
                  <!-- First / Last name (TEXT) -->
                  <div class="col-md-6">
                    <label for="first_name" class="form-label">First Name</label>
                    <input type="text" class="form-control rf-input" id="first_name" name="first_name" required>
                  </div>
                  <div class="col-md-6">
                    <label for="last_name" class="form-label">Last Name</label>
                    <input type="text" class="form-control rf-input" id="last_name" name="last_name" required>
                  </div>

                  <!-- Date of Birth (DATE) -->
                  <div class="col-md-6">
                    <label for="dob" class="form-label">Date of Birth</label>
                    <input type="date" class="form-control rf-input" id="dob" name="dob" required>
                  </div>

                  <!-- Gender (default Female) -->
                  <div class="col-md-6">
                    <span class="form-label d-block">Gender</span>
                    <div class="rf-radio-group">
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" id="gender_f" value="Female" checked>
                        <label class="form-check-label" for="gender_f">Female</label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" id="gender_m" value="Male">
                        <label class="form-check-label" for="gender_m">Male</label>
                      </div>
                    </div>
                  </div>

                  <!-- Email (TEXT — NOT input type="email") -->
                  <div class="col-md-6">
                    <label for="email" class="form-label">Email (Text input)</label>
                    <input type="text" class="form-control rf-input" id="email" name="email" required>
                  </div>

                  <!-- Hometown (TEXT) -->
                  <div class="col-md-6">
                    <label for="hometown" class="form-label">Hometown</label>
                    <input type="text" class="form-control rf-input" id="hometown" name="hometown" required>
                  </div>

                  <!-- Passwords (TEXT — per assignment) -->
                  <div class="col-md-6">
                    <label for="password" class="form-label">Password (Text input)</label>
                    <input type="text" class="form-control rf-input" id="password" name="password" required>
                  </div>
                  <div class="col-md-6">
                    <label for="confirm_password" class="form-label">Confirm Password (Text input)</label>
                    <input type="text" class="form-control rf-input" id="confirm_password" name="confirm_password" required>
                  </div>
                </div>

                <!-- Buttons -->
                <div class="rf-actions">
                  <button type="submit" name="submit" class="btn rf-btn-primary">Submit Form</button>
                  <button type="reset" class="btn rf-btn-outline">Reset Form</button>
                  <a href="login.php" class="btn rf-btn-secondary">Back to Login</a>
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


