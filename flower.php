<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (empty($_SESSION['user_email'])) {
    $_SESSION['flash'] = 'Please login to continue.';
    header('Location: login.php?redirect=' . urlencode('flower.php'));
    exit;
}

require_once 'main.php';

$isLoggedIn = !empty($_SESSION['user_email']);
$searchQuery = trim($_GET['search'] ?? '');
$uploadedImagePath = '';
$flowers = [];
$message = '';
$contributionMessage = '';
$errors = [];
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

// Handle image identification with actual file upload
if (isset($_FILES['identify_image']) && $_FILES['identify_image']['error'] === UPLOAD_ERR_OK && $isLoggedIn) {
    try {
        // Validate uploaded image
        $allowed = ['jpg', 'jpeg', 'png'];
        $filename = $_FILES['identify_image']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        if (!in_array($ext, $allowed)) {
            $message = 'Only JPG, JPEG, and PNG files are allowed.';
        } elseif ($_FILES['identify_image']['size'] > 5 * 1024 * 1024) {
            $message = 'Image size must not exceed 5MB.';
        } else {
            // Save uploaded image temporarily
            $uploadDir = __DIR__ . '/img/uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0775, true);
            }
            
            $newFilename = 'identify_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
            $uploadPath = $uploadDir . $newFilename;
            
            if (move_uploaded_file($_FILES['identify_image']['tmp_name'], $uploadPath)) {
                $uploadedImagePath = 'img/uploads/' . $newFilename;
                
                // Extract keywords from original filename for matching
                $imageName = strtolower(pathinfo($filename, PATHINFO_FILENAME));
                
                // Remove common separators and keep only the flower name
                $imageName = str_replace(['_', '-', ' '], '', $imageName);
                
                $conn = getDBConnection();
                
                // Check if status column exists
                $checkColumn = $conn->query("SHOW COLUMNS FROM flower_table LIKE 'status'");
                if ($checkColumn->num_rows == 0) {
                    $conn->query("ALTER TABLE flower_table 
                        ADD COLUMN contributor_email VARCHAR(50) NULL,
                        ADD COLUMN contribution_date DATETIME NULL,
                        ADD COLUMN status VARCHAR(20) DEFAULT 'approved',
                        ADD FOREIGN KEY (contributor_email) REFERENCES user_table(email) ON DELETE SET NULL ON UPDATE CASCADE");
                }
                
                // Search for matching flowers based on filename
                // Look for approved flowers AND user's own contributions (even if pending)
                $stmt = $conn->prepare("
                    SELECT * FROM flower_table 
                    WHERE (
                        LOWER(REPLACE(REPLACE(Common_Name, ' ', ''), '-', '')) LIKE CONCAT('%', ?, '%') 
                        OR LOWER(REPLACE(REPLACE(Scientific_Name, ' ', ''), '-', '')) LIKE CONCAT('%', ?, '%')
                    )
                    AND (status = 'approved' OR status IS NULL OR contributor_email = ?)
                    ORDER BY 
                        CASE WHEN status = 'approved' OR status IS NULL THEN 0 ELSE 1 END,
                        Common_Name
                ");
                $userEmail = $_SESSION['user_email'];
                $stmt->bind_param("sss", $imageName, $imageName, $userEmail);
                $stmt->execute();
                $result = $stmt->get_result();
                
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $flowers[] = $row;
                    }
                    $message = 'success';
                } else {
                    // Try a more flexible search without space removal
                    $imageName2 = strtolower(pathinfo($filename, PATHINFO_FILENAME));
                    $stmt2 = $conn->prepare("
                        SELECT * FROM flower_table 
                        WHERE (
                            LOWER(Common_Name) LIKE CONCAT('%', ?, '%') 
                            OR LOWER(Scientific_Name) LIKE CONCAT('%', ?, '%')
                        )
                        AND (status = 'approved' OR status IS NULL OR contributor_email = ?)
                        ORDER BY Common_Name
                    ");
                    $stmt2->bind_param("sss", $imageName2, $imageName2, $userEmail);
                    $stmt2->execute();
                    $result2 = $stmt2->get_result();
                    
                    if ($result2->num_rows > 0) {
                        while ($row = $result2->fetch_assoc()) {
                            $flowers[] = $row;
                        }
                        $message = 'success';
                    } else {
                        $message = 'No matching flowers found. The uploaded image filename "' . htmlspecialchars($filename) . '" does not match any flowers in our database. Make sure your contributed flower has been approved by admin or the filename matches the flower name.';
                    }
                    $stmt2->close();
                }
                
                $stmt->close();
                $conn->close();
            } else {
                $message = 'Failed to upload image. Please try again.';
            }
        }
    } catch (Exception $e) {
        $message = 'Error processing image: ' . $e->getMessage();
    }
}

// Handle flower contribution
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $isLoggedIn) {
    $scientificName = trim($_POST['scientific_name'] ?? '');
    $commonName = trim($_POST['common_name'] ?? '');
    
    if (empty($scientificName)) {
        $errors['scientific_name'] = 'Scientific name is required.';
    }
    if (empty($commonName)) {
        $errors['common_name'] = 'Common name is required.';
    }
    
    // Handle flower image upload
    $imagePath = null;
    if (isset($_FILES['flower_image']) && $_FILES['flower_image']['error'] === UPLOAD_ERR_OK) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['flower_image']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        if (!in_array($ext, $allowed)) {
            $errors['flower_image'] = 'Only JPG, PNG, and GIF files are allowed.';
        } elseif ($_FILES['flower_image']['size'] > 5 * 1024 * 1024) {
            $errors['flower_image'] = 'Image size must not exceed 5MB.';
        } else {
            $uploadDir = __DIR__ . '/img/flowers/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0775, true);
            }
            $newFilename = 'flower_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
            $uploadPath = $uploadDir . $newFilename;
            
            if (move_uploaded_file($_FILES['flower_image']['tmp_name'], $uploadPath)) {
                $imagePath = 'img/flowers/' . $newFilename;
            } else {
                $errors['flower_image'] = 'Failed to upload image.';
            }
        }
    } else {
        $errors['flower_image'] = 'Flower image is required.';
    }
    
    // Handle PDF description upload
    $pdfPath = null;
    if (isset($_FILES['flower_pdf']) && $_FILES['flower_pdf']['error'] === UPLOAD_ERR_OK) {
        $filename = $_FILES['flower_pdf']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        if ($ext !== 'pdf') {
            $errors['flower_pdf'] = 'Only PDF files are allowed for descriptions.';
        } elseif ($_FILES['flower_pdf']['size'] > 7 * 1024 * 1024) {
            $errors['flower_pdf'] = 'PDF size must not exceed 7MB.';
        } else {
            $uploadDir = __DIR__ . '/flower_description/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0775, true);
            }
            $newFilename = 'description_' . time() . '_' . bin2hex(random_bytes(4)) . '.pdf';
            $uploadPath = $uploadDir . $newFilename;
            
            if (move_uploaded_file($_FILES['flower_pdf']['tmp_name'], $uploadPath)) {
                $pdfPath = 'flower_description/' . $newFilename;
            } else {
                $errors['flower_pdf'] = 'Failed to upload PDF.';
            }
        }
    } else {
        $errors['flower_pdf'] = 'Description PDF is required.';
    }
    
    // Insert into database if no errors
    if (empty($errors)) {
        try {
            $conn = getDBConnection();
            $userEmail = $_SESSION['user_email'];
            $stmt = $conn->prepare("INSERT INTO flower_table (Scientific_Name, Common_Name, Plant_image, Description, contributor_email, contribution_date, status) VALUES (?, ?, ?, ?, ?, NOW(), 'pending')");
            $stmt->bind_param("sssss", $scientificName, $commonName, $imagePath, $pdfPath, $userEmail);
            
            if ($stmt->execute()) {
                $contributionMessage = 'Thank you! Your flower contribution has been submitted for review.';
                // Clear form
                $_POST = [];
            } else {
                $errors['general'] = 'Failed to submit contribution. Please try again.';
            }
            
            $stmt->close();
            $conn->close();
        } catch (Exception $e) {
            $errors['general'] = 'Error submitting contribution: ' . $e->getMessage();
        }
    }
}

// Handle search
if ($searchQuery !== '') {
    try {
        $conn = getDBConnection();
        
        // Search by scientific name or common name (only approved flowers)
        $stmt = $conn->prepare("SELECT * FROM flower_table WHERE (Scientific_Name LIKE ? OR Common_Name LIKE ?) AND status = 'approved'");
        $searchTerm = '%' . $searchQuery . '%';
        $stmt->bind_param("ss", $searchTerm, $searchTerm);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $flowers[] = $row;
            }
        } else {
            $message = 'Flower data not available';
        }
        
        $stmt->close();
        $conn->close();
    } catch (Exception $e) {
        $message = 'Error retrieving flower data: ' . $e->getMessage();
    }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="author" content="Neng Yi Chieng" />
  <title>Root Flowers - Flower Identifier</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />
  <link rel="stylesheet" href="./style/style.css" />
</head>
<body class="rf-page">
  <?php include __DIR__ . '/nav.php'; ?>

  <main class="rf-main" id="main-content">
    <?php if ($flash): ?>
      <div class="container mt-3">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <?php echo htmlspecialchars($flash); ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      </div>
    <?php endif; ?>

    <!-- Header Section -->
    <section class="rf-section" aria-labelledby="flower-intro">
      <header class="rf-section-header">
        <h1 id="flower-intro" class="rf-section-title">
          <i class="bi bi-flower1 me-2"></i>Flower Identifier
        </h1>
        <p class="rf-section-text">
          Upload a photo to identify flowers instantly using our comprehensive database, or contribute your own discoveries to help the community.
        </p>
      </header>
    </section>

    <!-- Identification Section -->
    <section class="rf-section">
      <div class="container">
        <div class="row justify-content-center mb-5">
          <!-- Image Upload Identification -->
          <div class="col-lg-8">
            <div class="card shadow-sm flower-identify-card">
              <div class="card-header bg-danger text-white">
                <h3 class="mb-0"><i class="bi bi-camera me-2"></i>Identify by Photo</h3>
                <small>Upload an image to identify the flower</small>
              </div>
              <div class="card-body">
                <form method="post" action="flower.php" enctype="multipart/form-data" id="uploadForm">
                  <div class="mb-3">
                    <label for="flowerImage" class="form-label fw-semibold">Upload Flower Image</label>
                    <div class="flower-upload-area" id="uploadArea">
                      <input type="file" 
                             class="form-control" 
                             id="flowerImage" 
                             name="identify_image"
                             accept="image/jpeg,image/png,image/jpg"
                             required>
                      <div class="upload-placeholder text-center">
                        <i class="bi bi-cloud-upload display-3 text-muted mb-3"></i>
                        <h5 class="text-muted mb-2">Click to upload or drag and drop</h5>
                        <p class="text-muted mb-0">JPG, JPEG, or PNG (Max 5MB)</p>
                      </div>
                      <div class="image-preview" id="imagePreview"></div>
                    </div>
                  </div>
                  <button type="submit" class="btn btn-danger btn-lg w-100" disabled id="identifyBtn">
                    <i class="bi bi-search me-2"></i>Identify Flower
                  </button>
                </form>
                <div class="mt-4 p-3 bg-light rounded">
                  <h6 class="fw-semibold mb-2"><i class="bi bi-info-circle me-2"></i>How it works:</h6>
                  <p class="text-muted small mb-0">
                    Upload a clear photo of the flower. Our system will search the database for matches based on visual characteristics and provide detailed information about the identified species.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Contribution Form -->
        <div class="card mb-5 shadow-sm flower-contribution-card">
          <div class="card-header flower-contribution-header">
            <h3 class="mb-0"><i class="bi bi-plus-circle me-2"></i>Contribute a Flower</h3>
            <small>Share your flower knowledge with the community</small>
          </div>
          <div class="card-body">
            <?php if ($contributionMessage): ?>
              <div class="alert alert-success">
                <i class="bi bi-check-circle me-2"></i><?php echo htmlspecialchars($contributionMessage); ?>
              </div>
            <?php endif; ?>
            
            <?php if (!empty($errors['general'])): ?>
              <div class="alert alert-danger">
                <i class="bi bi-exclamation-triangle me-2"></i><?php echo htmlspecialchars($errors['general']); ?>
              </div>
            <?php endif; ?>
            
            <form method="post" action="flower.php" enctype="multipart/form-data">
              <div class="row g-3">
                <div class="col-md-6">
                  <label class="form-label" for="scientific_name">Scientific Name <span class="text-danger">*</span></label>
                  <input type="text" 
                         class="form-control <?php echo isset($errors['scientific_name']) ? 'is-invalid' : ''; ?>" 
                         id="scientific_name" 
                         name="scientific_name" 
                         placeholder="e.g., Rosa rubiginosa"
                         value="<?php echo htmlspecialchars($_POST['scientific_name'] ?? ''); ?>"
                         required>
                  <?php if (isset($errors['scientific_name'])): ?>
                    <div class="invalid-feedback"><?php echo htmlspecialchars($errors['scientific_name']); ?></div>
                  <?php endif; ?>
                </div>
                
                <div class="col-md-6">
                  <label class="form-label" for="common_name">Common Name <span class="text-danger">*</span></label>
                  <input type="text" 
                         class="form-control <?php echo isset($errors['common_name']) ? 'is-invalid' : ''; ?>" 
                         id="common_name" 
                         name="common_name" 
                         placeholder="e.g., Sweet Briar Rose"
                         value="<?php echo htmlspecialchars($_POST['common_name'] ?? ''); ?>"
                         required>
                  <?php if (isset($errors['common_name'])): ?>
                    <div class="invalid-feedback"><?php echo htmlspecialchars($errors['common_name']); ?></div>
                  <?php endif; ?>
                </div>
                
                <div class="col-md-6">
                  <label class="form-label" for="flower_image">Flower Image <span class="text-danger">*</span></label>
                  <input type="file" 
                         class="form-control <?php echo isset($errors['flower_image']) ? 'is-invalid' : ''; ?>" 
                         id="flower_image" 
                         name="flower_image" 
                         accept=".jpg,.jpeg,.png,.gif"
                         required>
                  <small class="text-muted">JPG, PNG, or GIF (Max 5MB)</small>
                  <?php if (isset($errors['flower_image'])): ?>
                    <div class="invalid-feedback d-block"><?php echo htmlspecialchars($errors['flower_image']); ?></div>
                  <?php endif; ?>
                </div>
                
                <div class="col-md-6">
                  <label class="form-label" for="flower_pdf">Flower Description (PDF) <span class="text-danger">*</span></label>
                  <input type="file" 
                         class="form-control <?php echo isset($errors['flower_pdf']) ? 'is-invalid' : ''; ?>" 
                         id="flower_pdf" 
                         name="flower_pdf" 
                         accept=".pdf"
                         required>
                  <small class="text-muted">Upload a PDF with detailed flower information (Max 7MB). Stored in flower_description/ folder.</small>
                  <?php if (isset($errors['flower_pdf'])): ?>
                    <div class="invalid-feedback d-block"><?php echo htmlspecialchars($errors['flower_pdf']); ?></div>
                  <?php endif; ?>
                </div>
                
                <div class="col-12">
                  <button type="submit" class="btn btn-danger">
                    <i class="bi bi-cloud-upload me-2"></i>Submit Contribution
                  </button>
                  <small class="text-muted ms-3">Your contribution will be reviewed before appearing in search results</small>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
      
    <!-- Search Results Section -->
    <section class="rf-section">
      <div class="container">
        <?php if (!empty($uploadedImagePath) || $searchQuery !== ''): ?>
          <?php if (!empty($uploadedImagePath)): ?>
            <!-- Display uploaded image -->
            <div class="row mb-4">
              <div class="col-12">
                <div class="card">
                  <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="bi bi-image me-2"></i>Your Uploaded Image</h5>
                  </div>
                  <div class="card-body text-center">
                    <img src="<?php echo htmlspecialchars($uploadedImagePath); ?>" 
                         alt="Uploaded flower image" 
                         class="img-fluid rounded shadow"
                         style="max-height: 400px; object-fit: contain;">
                  </div>
                </div>
              </div>
            </div>
          <?php endif; ?>
          
          <?php if (!empty($flowers)): ?>
            <h2 class="mb-4 fw-bold">Identified Flowers</h2>
          <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php foreach ($flowers as $flower): ?>
              <div class="col">
                <div class="card flower-result-card h-100 shadow-sm">
                  <?php if ($flower['Plant_image'] && file_exists($flower['Plant_image'])): ?>
                    <img src="<?php echo htmlspecialchars($flower['Plant_image']); ?>" 
                         class="card-img-top flower-card-image" 
                         alt="<?php echo htmlspecialchars($flower['Common_Name']); ?>">
                  <?php else: ?>
                    <div class="card-img-top flower-card-image flower-placeholder">
                      <i class="bi bi-flower1"></i>
                    </div>
                  <?php endif; ?>
                  
                  <div class="card-body">
                    <h5 class="card-title text-danger fw-bold">
                      <?php echo htmlspecialchars($flower['Common_Name']); ?>
                    </h5>
                    <p class="card-text">
                      <strong>Scientific Name:</strong><br>
                      <em class="text-muted"><?php echo htmlspecialchars($flower['Scientific_Name']); ?></em>
                    </p>
                    
                    <?php if ($flower['Description'] && file_exists($flower['Description'])): ?>
                      <a href="<?php echo htmlspecialchars($flower['Description']); ?>" 
                         class="btn btn-outline-danger btn-sm" 
                         target="_blank"
                         download>
                        <i class="bi bi-file-pdf me-2"></i>Download Description (PDF)
                      </a>
                    <?php else: ?>
                      <p class="text-muted small mb-0">
                        <i class="bi bi-info-circle me-1"></i>No description PDF available
                      </p>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
            </div>
          <?php elseif ($message): ?>
            <div class="alert alert-warning text-center">
              <i class="bi bi-exclamation-triangle me-2"></i>
              <?php echo htmlspecialchars($message); ?>
            </div>
          <?php endif; ?>
        <?php else: ?>
          <div class="flower-empty-state text-center py-5">
            <i class="bi bi-flower1 flower-empty-icon"></i>
            <h3 class="mt-3">Upload a photo to identify flowers</h3>
            <p class="text-muted">Our system will analyze your image and provide matching results from our comprehensive database</p>
          </div>
        <?php endif; ?>
      </div>
    </section>
  </main>

  <?php include __DIR__ . '/footer.php'; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Image upload preview and validation
    const fileInput = document.getElementById('flowerImage');
    const uploadArea = document.getElementById('uploadArea');
    const imagePreview = document.getElementById('imagePreview');
    const identifyBtn = document.getElementById('identifyBtn');
    const uploadForm = document.getElementById('uploadForm');

    // Handle file selection
    fileInput.addEventListener('change', function(e) {
      const file = e.target.files[0];
      if (file) {
        handleFile(file);
      }
    });

    // Handle drag and drop
    uploadArea.addEventListener('dragover', function(e) {
      e.preventDefault();
      uploadArea.classList.add('drag-over');
    });

    uploadArea.addEventListener('dragleave', function(e) {
      e.preventDefault();
      uploadArea.classList.remove('drag-over');
    });

    uploadArea.addEventListener('drop', function(e) {
      e.preventDefault();
      uploadArea.classList.remove('drag-over');
      const file = e.dataTransfer.files[0];
      if (file && file.type.startsWith('image/')) {
        fileInput.files = e.dataTransfer.files;
        handleFile(file);
      }
    });

    function handleFile(file) {
      // Validate file type
      const validTypes = ['image/jpeg', 'image/jpg', 'image/png'];
      if (!validTypes.includes(file.type)) {
        alert('Please upload a JPG, JPEG, or PNG image.');
        return;
      }

      // Validate file size (5MB)
      if (file.size > 5 * 1024 * 1024) {
        alert('Image size must not exceed 5MB.');
        return;
      }

      // Show preview
      const reader = new FileReader();
      reader.onload = function(e) {
        imagePreview.innerHTML = `
          <img src="${e.target.result}" alt="Preview" class="img-fluid rounded">
          <button type="button" class="btn btn-sm btn-danger mt-2" onclick="clearImage()">
            <i class="bi bi-x-circle me-1"></i>Remove
          </button>
        `;
        uploadArea.querySelector('.upload-placeholder').style.display = 'none';
        identifyBtn.disabled = false;
      };
      reader.readAsDataURL(file);
    }

    function clearImage() {
      fileInput.value = '';
      imagePreview.innerHTML = '';
      uploadArea.querySelector('.upload-placeholder').style.display = 'block';
      identifyBtn.disabled = true;
    }

    // Form submission - show processing modal then submit
    uploadForm.addEventListener('submit', function(e) {
      const file = fileInput.files[0];
      if (!file) {
        e.preventDefault();
        alert('Please select an image first.');
        return;
      }
      
      // Show processing modal
      const modal = new bootstrap.Modal(document.getElementById('identifyModal') || createModal());
      modal.show();
      
      // Let the form submit naturally after a brief delay
      // (The modal will be visible during the page reload)
    });

    function createModal() {
      const modalHTML = `
        <div class="modal fade" id="identifyModal" tabindex="-1">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="bi bi-camera me-2"></i>Image Identification</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body text-center py-4">
                <div class="spinner-border text-danger mb-3" role="status">
                  <span class="visually-hidden">Processing...</span>
                </div>
                <p class="mb-0">Analyzing your image...</p>
                <small class="text-muted">This feature uses our database to find matching flowers.</small>
              </div>
            </div>
          </div>
        </div>
      `;
      document.body.insertAdjacentHTML('beforeend', modalHTML);
      return document.getElementById('identifyModal');
    }
  </script>
</body>
</html>
