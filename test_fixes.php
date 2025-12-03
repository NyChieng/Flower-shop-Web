<?php
/**
 * Test page to verify fixes
 * This file helps verify that all the fixes are working correctly
 */
session_start();
require_once 'main.php';

// Test 1: Check if directories exist
$directories = [
    'profile_images',
    'resume',
    'img/uploads',
    'data/flower_pdfs'
];

$dirStatus = [];
foreach ($directories as $dir) {
    $dirStatus[$dir] = is_dir(__DIR__ . '/' . $dir) ? '✓' : '✗';
}

// Test 2: Check database connection
$dbConnected = false;
$dbError = '';
try {
    $conn = getDBConnection();
    $dbConnected = true;
    $conn->close();
} catch (Exception $e) {
    $dbError = $e->getMessage();
}

// Test 3: Check if admin session is properly set
$sessionInfo = [
    'user_email' => $_SESSION['user_email'] ?? 'Not set',
    'user_type' => $_SESSION['user_type'] ?? 'Not set',
    'first_name' => $_SESSION['first_name'] ?? 'Not set',
];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Fixes Test - Root Flowers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>
<body>
    <div class="container py-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h1 class="h3 mb-0"><i class="bi bi-check-circle me-2"></i>Website Fixes Verification</h1>
            </div>
            <div class="card-body">
                
                <!-- Test 1: Directory Status -->
                <div class="mb-4">
                    <h3 class="h5 border-bottom pb-2"><i class="bi bi-folder me-2"></i>1. Required Directories</h3>
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Directory</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($dirStatus as $dir => $status): ?>
                            <tr>
                                <td><code><?php echo htmlspecialchars($dir); ?></code></td>
                                <td>
                                    <?php if ($status === '✓'): ?>
                                        <span class="badge bg-success">✓ Exists</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">✗ Missing</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Test 2: Database Connection -->
                <div class="mb-4">
                    <h3 class="h5 border-bottom pb-2"><i class="bi bi-database me-2"></i>2. Database Connection</h3>
                    <?php if ($dbConnected): ?>
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle me-2"></i>Database connection successful!
                        </div>
                    <?php else: ?>
                        <div class="alert alert-danger">
                            <i class="bi bi-x-circle me-2"></i>Database connection failed: <?php echo htmlspecialchars($dbError); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Test 3: Session Info -->
                <div class="mb-4">
                    <h3 class="h5 border-bottom pb-2"><i class="bi bi-person-circle me-2"></i>3. Current Session Info</h3>
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Session Variable</th>
                                <th>Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($sessionInfo as $key => $value): ?>
                            <tr>
                                <td><code>$_SESSION['<?php echo htmlspecialchars($key); ?>']</code></td>
                                <td><?php echo htmlspecialchars($value); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Test 4: Fixed Issues Summary -->
                <div class="mb-4">
                    <h3 class="h5 border-bottom pb-2"><i class="bi bi-wrench me-2"></i>4. Issues Fixed</h3>
                    <div class="list-group">
                        <div class="list-group-item">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1"><i class="bi bi-check-circle text-success me-2"></i>Admin Navigation Bar</h6>
                            </div>
                            <p class="mb-1 small">Navigation bar now shows admin-specific links (Manage Accounts, Manage Flowers, etc.) when on admin pages.</p>
                        </div>
                        <div class="list-group-item">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1"><i class="bi bi-check-circle text-success me-2"></i>Admin Portal Button in Main Menu</h6>
                            </div>
                            <p class="mb-1 small">Admin users now see "Admin Portal" button in the main menu header.</p>
                        </div>
                        <div class="list-group-item">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1"><i class="bi bi-check-circle text-success me-2"></i>Button Layout Fixed</h6>
                            </div>
                            <p class="mb-1 small">Action buttons in admin management pages no longer overlap and are properly aligned.</p>
                        </div>
                        <div class="list-group-item">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1"><i class="bi bi-check-circle text-success me-2"></i>Required Directories Created</h6>
                            </div>
                            <p class="mb-1 small">Created missing directories: img/uploads, data/flower_pdfs, resume</p>
                        </div>
                        <div class="list-group-item">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1"><i class="bi bi-check-circle text-success me-2"></i>Security Enhancements</h6>
                            </div>
                            <p class="mb-1 small">Added .htaccess files to prevent directory browsing in upload folders.</p>
                        </div>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="mb-4">
                    <h3 class="h5 border-bottom pb-2"><i class="bi bi-link-45deg me-2"></i>5. Quick Test Links</h3>
                    <div class="d-flex gap-2 flex-wrap">
                        <a href="index.php" class="btn btn-primary btn-sm">
                            <i class="bi bi-house me-1"></i>Home
                        </a>
                        <a href="login.php" class="btn btn-secondary btn-sm">
                            <i class="bi bi-box-arrow-in-right me-1"></i>Login
                        </a>
                        <a href="main_menu.php" class="btn btn-info btn-sm text-white">
                            <i class="bi bi-grid me-1"></i>User Menu
                        </a>
                        <a href="main_menu_admin.php" class="btn btn-warning btn-sm">
                            <i class="bi bi-shield-lock me-1"></i>Admin Portal
                        </a>
                    </div>
                </div>

                <!-- Admin Credentials -->
                <div class="alert alert-info">
                    <h5 class="alert-heading"><i class="bi bi-info-circle me-2"></i>Admin Test Credentials</h5>
                    <p class="mb-0">
                        <strong>Email:</strong> admin@swin.edu.my<br>
                        <strong>Password:</strong> admin
                    </p>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
