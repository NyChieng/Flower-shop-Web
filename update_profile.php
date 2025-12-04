<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once 'main.php';

if (empty($_SESSION['user_email'])) {
    $_SESSION['flash'] = 'Please login to continue.';
    header('Location: login.php?redirect=' . urlencode('update_profile.php'));
    exit;
}

function ensureDir(string $directory): void
{
    if ($directory === '' || is_dir($directory)) {
        return;
    }
    mkdir($directory, 0775, true);
}

function alphaSpace(string $value): bool
{
    return (bool)preg_match('/^[a-zA-Z ]+$/', $value);
}

function validEmailFormat(string $email): bool
{
    return (bool)filter_var($email, FILTER_VALIDATE_EMAIL);
}

function req($value): bool
{
    return isset($value) && trim($value) !== '';
}

$currentEmail = $_SESSION['user_email'] ?? null;
$originalRecord = null;
$errorMessage = '';

// Load user data from database
try {
    $conn = getDBConnection();
    $stmt = $conn->prepare("SELECT * FROM user_table WHERE email = ?");
    $stmt->bind_param("s", $currentEmail);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $originalRecord = $result->fetch_assoc();
    } else {
        $errorMessage = 'Unable to locate your profile record.';
    }
    
    $stmt->close();
    $conn->close();
} catch (Exception $e) {
    $errorMessage = 'Error loading profile data.';
}

function formatDateForInput(?string $dob): string
{
    if (!$dob) {
        return '';
    }
    if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $dob)) {
        return $dob;
    }
    $parts = explode('-', $dob);
    if (count($parts) === 3) {
        return sprintf('%04d-%02d-%02d', (int)$parts[2], (int)$parts[1], (int)$parts[0]);
    }
    return '';
}

function old(string $key, array $values): string
{
    return htmlspecialchars($values[$key] ?? '', ENT_QUOTES);
}

function fieldErrors(string $key, array $errors): array
{
    return $errors[$key] ?? [];
}

function profileImagePath(?string $gender, ?string $profileImage = null): string
{
    if ($profileImage && file_exists(__DIR__ . '/' . $profileImage)) {
        return $profileImage;
    }
    
    $map = [
        'male' => 'profile_images/boys.jpg',
        'female' => 'profile_images/girl.png',
    ];

    $candidate = $map[strtolower($gender ?? 'female')] ?? $map['female'];
    $absolute = __DIR__ . '/' . $candidate;

    return file_exists($absolute) ? $candidate : 'img/login.png';
}

$values = [
    'first_name' => $originalRecord['first_name'] ?? '',
    'last_name'  => $originalRecord['last_name'] ?? '',
    'dob'        => formatDateForInput($originalRecord['dob'] ?? ''),
    'gender'     => $originalRecord['gender'] ?? 'Female',
    'email'      => $originalRecord['email'] ?? '',
    'hometown'   => $originalRecord['hometown'] ?? '',
];

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $originalRecord) {
    $values['first_name'] = trim($_POST['first_name'] ?? '');
    $values['last_name']  = trim($_POST['last_name'] ?? '');
    $values['dob']        = trim($_POST['dob'] ?? '');
    $values['gender']     = $_POST['gender'] ?? 'Female';
    $values['email']      = trim($_POST['email'] ?? '');
    $values['hometown']   = trim($_POST['hometown'] ?? '');

    $addError = function(string $key, string $message) use (&$errors) {
        $errors[$key][] = $message;
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

    if (!req($values['dob'])) {
        $addError('dob', 'Date of birth is required.');
    }

    if (!req($values['gender'])) {
        $addError('gender', 'Please choose a gender.');
    }

    if (!req($values['email'])) {
        $addError('email', 'Email is required.');
    } elseif (!validEmailFormat($values['email'])) {
        $addError('email', 'Invalid email format.');
    }

    if (!req($values['hometown'])) {
        $addError('hometown', 'Hometown is required.');
    }

    // Check if email changed and if new email already exists
    if (strcasecmp($values['email'], $originalRecord['email']) !== 0) {
        try {
            $conn = getDBConnection();
            $stmt = $conn->prepare("SELECT email FROM user_table WHERE email = ? AND email != ?");
            $stmt->bind_param("ss", $values['email'], $originalRecord['email']);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $addError('email', 'Another account already uses this email.');
            }
            $stmt->close();
            $conn->close();
        } catch (Exception $e) {
            $addError('email', 'Error checking email availability.');
        }
    }

    // Handle profile image upload
    $profileImagePath = $originalRecord['profile_image'];
    
    // Check if user uploaded a new image
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['profile_image']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        if (!in_array($ext, $allowed)) {
            $addError('profile_image', 'Only JPG, PNG, and GIF files are allowed.');
        } elseif ($_FILES['profile_image']['size'] > 5 * 1024 * 1024) { // 5MB limit
            $addError('profile_image', 'File size must not exceed 5MB.');
        } else {
            $uploadDir = __DIR__ . '/profile_images/';
            ensureDir($uploadDir);
            // Use user's first name for profile image
            $baseName = strtolower(str_replace(' ', '', $values['first_name']));
            $baseName = preg_replace('/[^a-z0-9]/', '', $baseName);
            if (empty($baseName)) {
                $baseName = 'user';
            }
            $newFilename = $baseName . '.' . $ext;
            $uploadPath = $uploadDir . $newFilename;
            
            // If file exists, add timestamp
            if (file_exists($uploadPath)) {
                $newFilename = $baseName . '_' . time() . '.' . $ext;
                $uploadPath = $uploadDir . $newFilename;
            }
            
            if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $uploadPath)) {
                $profileImagePath = 'profile_images/' . $newFilename;
            } else {
                $addError('profile_image', 'Failed to upload profile image.');
            }
        }
    } else {
        // No new image uploaded - check if we should use gender-based default
        // If current image is a default avatar, update it based on new gender
        $currentImage = $originalRecord['profile_image'] ?? '';
        $isDefaultImage = in_array($currentImage, ['profile_images/boys.jpg', 'profile_images/girl.png', '']) || empty($currentImage);
        
        if ($isDefaultImage) {
            // Use gender-based default avatar
            $profileImagePath = ($values['gender'] === 'Male') ? 'profile_images/boys.jpg' : 'profile_images/girl.png';
        }
        // Otherwise keep the existing custom uploaded image
    }

    // Handle resume upload (PDF, max 7MB)
    $resumePath = $originalRecord['resume'] ?? null;
    if (isset($_FILES['resume']) && $_FILES['resume']['error'] === UPLOAD_ERR_OK) {
        $filename = $_FILES['resume']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $fileType = $_FILES['resume']['type'];
        
        if ($ext !== 'pdf' || !in_array($fileType, ['application/pdf', 'application/x-pdf'])) {
            $addError('resume', 'Only PDF files are allowed for resume.');
        } elseif ($_FILES['resume']['size'] > 7 * 1024 * 1024) { // 7MB limit
            $addError('resume', 'Resume file size must not exceed 7MB.');
        } else {
            $uploadDir = __DIR__ . '/resume/';
            ensureDir($uploadDir);
            // Use user's name for resume
            $baseName = strtolower($values['first_name'] . '_' . $values['last_name']);
            $baseName = preg_replace('/[^a-z0-9_]/', '', $baseName);
            $newFilename = $baseName . '_resume.pdf';
            $uploadPath = $uploadDir . $newFilename;
            
            // If file exists, add timestamp
            if (file_exists($uploadPath)) {
                $newFilename = $baseName . '_resume_' . time() . '.pdf';
                $uploadPath = $uploadDir . $newFilename;
            }
            
            if (move_uploaded_file($_FILES['resume']['tmp_name'], $uploadPath)) {
                $resumePath = 'resume/' . $newFilename;
            } else {
                $addError('resume', 'Failed to upload resume.');
            }
        }
    }

    if (!$errors) {
        try {
            $conn = getDBConnection();
            $conn->begin_transaction();
            
            // Ensure resume path is properly handled
            if ($resumePath === null || $resumePath === '') {
                $resumePath = $originalRecord['resume'] ?? '';
            }
            
            // Check if resume column exists in user_table
            $columnsResult = $conn->query("SHOW COLUMNS FROM user_table LIKE 'resume'");
            $hasResumeColumn = ($columnsResult && $columnsResult->num_rows > 0);
            
            // Update user_table first (using original email)
            if ($hasResumeColumn) {
                $stmt = $conn->prepare("UPDATE user_table SET first_name = ?, last_name = ?, dob = ?, gender = ?, email = ?, hometown = ?, profile_image = ?, resume = ? WHERE email = ?");
                if (!$stmt) {
                    throw new Exception("Prepare failed: " . $conn->error);
                }
                $stmt->bind_param("sssssssss", $values['first_name'], $values['last_name'], $values['dob'], $values['gender'], $values['email'], $values['hometown'], $profileImagePath, $resumePath, $originalRecord['email']);
            } else {
                // Update without resume column
                $stmt = $conn->prepare("UPDATE user_table SET first_name = ?, last_name = ?, dob = ?, gender = ?, email = ?, hometown = ?, profile_image = ? WHERE email = ?");
                if (!$stmt) {
                    throw new Exception("Prepare failed: " . $conn->error);
                }
                $stmt->bind_param("ssssssss", $values['first_name'], $values['last_name'], $values['dob'], $values['gender'], $values['email'], $values['hometown'], $profileImagePath, $originalRecord['email']);
            }
            
            if (!$stmt->execute()) {
                throw new Exception("Execute failed: " . $stmt->error);
            }
            
            $stmt->close();
            
            // If email changed, update account_table too
            if (strcasecmp($values['email'], $originalRecord['email']) !== 0) {
                $stmt = $conn->prepare("UPDATE account_table SET email = ? WHERE email = ?");
                if (!$stmt) {
                    throw new Exception("Prepare account_table failed: " . $conn->error);
                }
                $stmt->bind_param("ss", $values['email'], $originalRecord['email']);
                if (!$stmt->execute()) {
                    throw new Exception("Execute account_table failed: " . $stmt->error);
                }
                $stmt->close();
            }
            
            $conn->commit();
            $conn->close();
            
            // Update session variables
            $_SESSION['user_email'] = $values['email'];
            $_SESSION['first_name'] = $values['first_name'];
            $_SESSION['last_name'] = $values['last_name'];
            $_SESSION['user_name']  = trim($values['first_name'] . ' ' . $values['last_name']);

            // Redirect to refresh the page and show updated data
            header('Location: update_profile.php?success=1');
            exit;
            
        } catch (Exception $e) {
            if (isset($conn) && $conn->connect_errno === 0) {
                $conn->rollback();
                $conn->close();
            }
            $addError('general', 'Failed to update profile: ' . $e->getMessage());
        }
    }
}

// Check if redirected after successful update
if (isset($_GET['success']) && $_GET['success'] == '1') {
    $success = true;
}

$imageSrc = profileImagePath($values['gender'] ?? null, $originalRecord['profile_image'] ?? null);
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="author" content="Neng Yi Chieng" />
  <title>Root Flowers - Update Profile</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />
  <link rel="stylesheet" href="./style/style.css" />
</head>
<body class="rf-page">
  <?php include __DIR__ . '/nav.php'; ?>

  <main class="rf-main">
    <section class="rf-section" aria-labelledby="update-profile">
      <header class="rf-section-header">
        <h1 id="update-profile" class="rf-section-title">Update profile</h1>
        <p class="rf-section-text">Edit your details below. The avatar updates automatically based on the selected gender.</p>
      </header>
    </section>

    <?php if (!empty($errorMessage)): ?>
      <div class="alert alert-danger" role="alert"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></div>
    <?php else: ?>
      <?php if ($success): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <i class="bi bi-check-circle me-2"></i>Profile updated successfully!
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      <?php endif; ?>

      <?php if (!empty($errors)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <i class="bi bi-exclamation-triangle me-2"></i>
          <strong>Please fix the following errors:</strong>
          <ul class="mb-0 mt-2">
            <?php foreach ($errors as $fieldErrors): ?>
              <?php foreach ($fieldErrors as $error): ?>
                <li><?php echo htmlspecialchars($error); ?></li>
              <?php endforeach; ?>
            <?php endforeach; ?>
          </ul>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      <?php endif; ?>

      <form class="rf-section rf-profile" method="post" action="update_profile.php" enctype="multipart/form-data" novalidate>
        <div class="rf-card rf-profile-card">
          <div class="rf-card-body">
            <div class="rf-profile-media">
              <img src="<?php echo htmlspecialchars($imageSrc); ?>" alt="Profile avatar" id="profilePreview" />
            </div>
            <div class="row g-4">
              <div class="col-md-6">
                <label class="form-label" for="first_name">First Name</label>
                <input class="form-control" type="text" id="first_name" name="first_name" value="<?php echo old('first_name', $values); ?>" required>
                <?php foreach (fieldErrors('first_name', $errors) as $msg): ?>
                  <small class="text-danger d-block"><?php echo htmlspecialchars($msg, ENT_QUOTES); ?></small>
                <?php endforeach; ?>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="last_name">Last Name</label>
                <input class="form-control" type="text" id="last_name" name="last_name" value="<?php echo old('last_name', $values); ?>" required>
                <?php foreach (fieldErrors('last_name', $errors) as $msg): ?>
                  <small class="text-danger d-block"><?php echo htmlspecialchars($msg, ENT_QUOTES); ?></small>
                <?php endforeach; ?>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="dob">Date of Birth</label>
                <input class="form-control" type="date" id="dob" name="dob" value="<?php echo old('dob', $values); ?>" required>
                <?php foreach (fieldErrors('dob', $errors) as $msg): ?>
                  <small class="text-danger d-block"><?php echo htmlspecialchars($msg, ENT_QUOTES); ?></small>
                <?php endforeach; ?>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="gender">Gender</label>
                <select class="form-select" id="gender" name="gender" required>
                  <option value="Female" <?php echo ($values['gender'] ?? 'Female') === 'Female' ? 'selected' : ''; ?>>Female</option>
                  <option value="Male" <?php echo ($values['gender'] ?? 'Female') === 'Male' ? 'selected' : ''; ?>>Male</option>
                </select>
                <?php foreach (fieldErrors('gender', $errors) as $msg): ?>
                  <small class="text-danger d-block"><?php echo htmlspecialchars($msg, ENT_QUOTES); ?></small>
                <?php endforeach; ?>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="email">Email</label>
                <input class="form-control" type="email" id="email" name="email" value="<?php echo old('email', $values); ?>" required>
                <?php foreach (fieldErrors('email', $errors) as $msg): ?>
                  <small class="text-danger d-block"><?php echo htmlspecialchars($msg, ENT_QUOTES); ?></small>
                <?php endforeach; ?>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="hometown">Hometown</label>
                <input class="form-control" type="text" id="hometown" name="hometown" value="<?php echo old('hometown', $values); ?>" required>
                <?php foreach (fieldErrors('hometown', $errors) as $msg): ?>
                  <small class="text-danger d-block"><?php echo htmlspecialchars($msg, ENT_QUOTES); ?></small>
                <?php endforeach; ?>
              </div>
              <div class="col-md-12">
                <label class="form-label" for="profile_image">Profile Image (JPG, PNG, GIF - Max 5MB)</label>
                <input class="form-control" type="file" id="profile_image" name="profile_image" accept=".jpg,.jpeg,.png,.gif">
                <small class="text-muted">Leave empty to keep current image</small>
                <?php foreach (fieldErrors('profile_image', $errors) as $msg): ?>
                  <small class="text-danger d-block"><?php echo htmlspecialchars($msg, ENT_QUOTES); ?></small>
                <?php endforeach; ?>
              </div>
              <div class="col-md-12">
                <label class="form-label" for="resume">Resume (PDF - Max 7MB)</label>
                <input class="form-control" type="file" id="resume" name="resume" accept=".pdf">
                <small class="text-muted">
                  <?php if (!empty($originalRecord['resume']) && file_exists(__DIR__ . '/' . $originalRecord['resume'])): ?>
                    Current: <a href="<?php echo htmlspecialchars($originalRecord['resume']); ?>" target="_blank">View Resume</a> | Upload new to replace
                  <?php else: ?>
                    No resume uploaded yet
                  <?php endif; ?>
                </small>
                <?php foreach (fieldErrors('resume', $errors) as $msg): ?>
                  <small class="text-danger d-block"><?php echo htmlspecialchars($msg, ENT_QUOTES); ?></small>
                <?php endforeach; ?>
              </div>
            </div>
            <div class="rf-profile-actions mt-4">
              <button type="submit" class="rf-button">Update profile</button>
              <a class="rf-button rf-button-outline" href="main_menu.php">Cancel</a>
            </div>
          </div>
        </div>
      </form>
    <?php endif; ?>
  </main>

  <?php include __DIR__ . '/footer.php'; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Profile image preview
    document.getElementById('profile_image')?.addEventListener('change', function(e) {
      const file = e.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function(event) {
          document.getElementById('profilePreview').src = event.target.result;
        };
        reader.readAsDataURL(file);
      }
    });

    // Gender-based avatar update (if no custom image uploaded)
    document.getElementById('gender')?.addEventListener('change', function(e) {
      const profileImageInput = document.getElementById('profile_image');
      const profilePreview = document.getElementById('profilePreview');
      
      // Only update if no file is selected
      if (!profileImageInput.files || profileImageInput.files.length === 0) {
        const gender = e.target.value.toLowerCase();
        const avatars = {
          'male': 'profile_images/boys.jpg',
          'female': 'profile_images/girl.png'
        };
        profilePreview.src = avatars[gender] || avatars['female'];
      }
    });
  </script>
</body>
</html>
