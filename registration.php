<?php
// COS30020/registration.php — Bootstrap + ./style/style.css
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Register • Root Flowers</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <!-- Your stylesheet (stored in ./style/) -->
  <link rel="stylesheet" href="style/style.css" />
</head>
<body>

  <?php include __DIR__ . '/nav.php'; ?>

  <!-- Slim page header (styled in style/style.css) -->
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
          <!-- Tidy Bootstrap card (styled via .register-card in style.css) -->
          <div class="card register-card">
            <div class="card-body">

              <!-- POST to Task 10 processor -->
              <?php 
                // Build a correct relative URL to process_register.php
                $proc = rtrim(dirname($_SERVER['REQUEST_URI']), '/\\') . '/process_register.php'; 
              ?>
              <form action="<?php echo $proc; ?>" method="post" novalidate>
                <div class="row g-4">

                  <!-- First / Last name (TEXT) -->
                  <div class="col-md-6">
                    <label for="first_name" class="form-label">First Name</label>
                    <input type="text" class="form-control" id="first_name" name="first_name" required>
                  </div>
                  <div class="col-md-6">
                    <label for="last_name" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="last_name" name="last_name" required>
                  </div>

                  <!-- Date of Birth (DATE) -->
                  <div class="col-md-6">
                    <label for="dob" class="form-label">Date of Birth</label>
                    <input type="date" class="form-control" id="dob" name="dob" required>
                  </div>

                  <!-- Gender (default Female) -->
                  <div class="col-md-6">
                    <span class="form-label d-block">Gender</span>
                    <div class="d-flex gap-4 pt-1">
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
                    <input type="text" class="form-control" id="email" name="email" required>
                  </div>

                  <!-- Hometown (TEXT) -->
                  <div class="col-md-6">
                    <label for="hometown" class="form-label">Hometown</label>
                    <input type="text" class="form-control" id="hometown" name="hometown" required>
                  </div>

                  <!-- Passwords (TEXT — per assignment) -->
                  <div class="col-md-6">
                    <label for="password" class="form-label">Password (Text input)</label>
                    <input type="text" class="form-control" id="password" name="password" required>
                  </div>
                  <div class="col-md-6">
                    <label for="confirm_password" class="form-label">Confirm Password (Text input)</label>
                    <input type="text" class="form-control" id="confirm_password" name="confirm_password" required>
                  </div>
                </div>

                <!-- Actions -->
                <div class="d-flex flex-wrap gap-2 pt-4">
                  <button type="submit" name="submit" class="btn btn-dark">Submit Form</button>
                  <button type="reset" class="btn btn-outline-dark">Reset Form</button>
                  <a href="login.php" class="btn btn-secondary">Back to Login</a>
                </div>
              </form>

            </div>
          </div>
          <!-- /card -->
        </div>
      </div>
    </div>
  </main>

  <?php include __DIR__ . '/footer.php'; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
