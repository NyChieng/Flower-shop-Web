<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once 'main.php';

// Check if user is logged in and is admin
if (empty($_SESSION['user_email']) || ($_SESSION['user_type'] ?? 'user') !== 'admin') {
    $_SESSION['flash'] = 'Access denied. Admin privileges required.';
    header('Location: login.php');
    exit;
}

$message = '';
$messageType = '';

// Handle Excel export
if (isset($_GET['export']) && $_GET['export'] === 'excel') {
    try {
        $conn = getDBConnection();
        $result = $conn->query("
            SELECT u.email, u.first_name, u.last_name, u.dob, u.gender, u.hometown, a.type
            FROM user_table u
            INNER JOIN account_table a ON u.email = a.email
            ORDER BY u.first_name, u.last_name
        ");
        
        // Set headers for Excel download
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="user_accounts_' . date('Y-m-d') . '.xls"');
        header('Cache-Control: max-age=0');
        
        // Output Excel content
        echo "<table border='1'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Email</th>";
        echo "<th>First Name</th>";
        echo "<th>Last Name</th>";
        echo "<th>Date of Birth</th>";
        echo "<th>Gender</th>";
        echo "<th>Hometown</th>";
        echo "<th>Account Type</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
            echo "<td>" . htmlspecialchars($row['first_name']) . "</td>";
            echo "<td>" . htmlspecialchars($row['last_name']) . "</td>";
            echo "<td>" . htmlspecialchars($row['dob'] ?? 'N/A') . "</td>";
            echo "<td>" . htmlspecialchars($row['gender']) . "</td>";
            echo "<td>" . htmlspecialchars($row['hometown']) . "</td>";
            echo "<td>" . htmlspecialchars(ucfirst($row['type'])) . "</td>";
            echo "</tr>";
        }
        
        echo "</tbody>";
        echo "</table>";
        
        $conn->close();
        exit;
    } catch (Exception $e) {
        $message = 'Export failed: ' . $e->getMessage();
        $messageType = 'danger';
    }
}

// Handle delete action
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['email'])) {
    $emailToDelete = $_GET['email'];
    
    // Prevent admin from deleting themselves
    if ($emailToDelete === $_SESSION['user_email']) {
        $message = 'You cannot delete your own account.';
        $messageType = 'danger';
    } else {
        try {
            $conn = getDBConnection();
            // Delete will cascade to account_table due to foreign key
            $stmt = $conn->prepare("DELETE FROM user_table WHERE email = ?");
            $stmt->bind_param("s", $emailToDelete);
            
            if ($stmt->execute()) {
                $message = 'User account deleted successfully.';
                $messageType = 'success';
            } else {
                $message = 'Failed to delete user account.';
                $messageType = 'danger';
            }
            
            $stmt->close();
            $conn->close();
        } catch (Exception $e) {
            $message = 'Error deleting account: ' . $e->getMessage();
            $messageType = 'danger';
        }
    }
}

// Handle add/edit actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $email = trim($_POST['email'] ?? '');
    $firstName = trim($_POST['first_name'] ?? '');
    $lastName = trim($_POST['last_name'] ?? '');
    $gender = $_POST['gender'] ?? 'Female';
    $userType = $_POST['user_type'] ?? 'user';
    $password = trim($_POST['password'] ?? '');
    
    if ($action === 'add') {
        // Add new user
        if ($email && $firstName && $lastName && $password) {
            try {
                $conn = getDBConnection();
                $conn->begin_transaction();
                
                // Insert into user_table
                $stmt = $conn->prepare("INSERT INTO user_table (email, first_name, last_name, dob, gender, hometown, profile_image) VALUES (?, ?, ?, NULL, ?, NULL, NULL)");
                $stmt->bind_param("ssss", $email, $firstName, $lastName, $gender);
                $stmt->execute();
                $stmt->close();
                
                // Insert into account_table
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("INSERT INTO account_table (email, password, type) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $email, $hashedPassword, $userType);
                $stmt->execute();
                $stmt->close();
                
                $conn->commit();
                $conn->close();
                
                $message = 'User account created successfully.';
                $messageType = 'success';
            } catch (Exception $e) {
                if (isset($conn)) {
                    $conn->rollback();
                    $conn->close();
                }
                $message = 'Error creating account: ' . $e->getMessage();
                $messageType = 'danger';
            }
        } else {
            $message = 'All fields are required.';
            $messageType = 'warning';
        }
    } elseif ($action === 'edit') {
        // Edit existing user
        $originalEmail = $_POST['original_email'] ?? '';
        
        if ($email && $firstName && $lastName) {
            try {
                $conn = getDBConnection();
                $conn->begin_transaction();
                
                // Update user_table
                $stmt = $conn->prepare("UPDATE user_table SET first_name = ?, last_name = ?, gender = ? WHERE email = ?");
                $stmt->bind_param("ssss", $firstName, $lastName, $gender, $originalEmail);
                $stmt->execute();
                $stmt->close();
                
                // Update account_table type
                $stmt = $conn->prepare("UPDATE account_table SET type = ? WHERE email = ?");
                $stmt->bind_param("ss", $userType, $originalEmail);
                $stmt->execute();
                $stmt->close();
                
                // Update password if provided
                if ($password) {
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $conn->prepare("UPDATE account_table SET password = ? WHERE email = ?");
                    $stmt->bind_param("ss", $hashedPassword, $originalEmail);
                    $stmt->execute();
                    $stmt->close();
                }
                
                $conn->commit();
                $conn->close();
                
                $message = 'User account updated successfully.';
                $messageType = 'success';
            } catch (Exception $e) {
                if (isset($conn)) {
                    $conn->rollback();
                    $conn->close();
                }
                $message = 'Error updating account: ' . $e->getMessage();
                $messageType = 'danger';
            }
        } else {
            $message = 'Email, first name, and last name are required.';
            $messageType = 'warning';
        }
    }
}

// Get all users
$users = [];
try {
    $conn = getDBConnection();
    $result = $conn->query("SELECT u.email, u.first_name, u.last_name, u.gender, a.type 
                           FROM user_table u 
                           INNER JOIN account_table a ON u.email = a.email 
                           ORDER BY u.first_name, u.last_name");
    
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
    
    $conn->close();
} catch (Exception $e) {
    $message = 'Error loading users: ' . $e->getMessage();
    $messageType = 'danger';
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Manage User Accounts - Root Flowers Admin</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="style/style.css">
</head>
<body class="rf-page">
  <?php include __DIR__ . '/nav.php'; ?>

  <main class="rf-main" id="main-content">
    <section class="rf-section" aria-labelledby="page-title">
      <header class="rf-section-header">
        <h1 id="page-title" class="rf-section-title">
          <i class="bi bi-people-fill me-2"></i>Manage User Accounts
        </h1>
        <p class="rf-section-text">
          Add, edit, or remove user accounts and manage user permissions.
        </p>
      </header>
    </section>

    <section class="rf-section">
      <div class="container">
        <?php if ($message): ?>
          <div class="alert alert-<?php echo $messageType; ?> alert-dismissible fade show">
            <?php echo htmlspecialchars($message); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        <?php endif; ?>

        <!-- Add New User Button -->
        <div class="d-flex justify-content-between align-items-center mb-4">
          <div>
            <button class="btn btn-primary btn-lg shadow-sm" data-bs-toggle="modal" data-bs-target="#addUserModal">
              <i class="bi bi-person-plus-fill me-2"></i>Add New User
            </button>
            <a href="?export=excel" class="btn btn-success btn-lg shadow-sm ms-2">
              <i class="bi bi-file-earmark-spreadsheet me-2"></i>Export to Excel
            </a>
          </div>
          <div class="text-end">
            <p class="mb-0 text-muted">Total Users: <strong><?php echo count($users); ?></strong></p>
            <small class="text-muted">Admins: <?php echo count(array_filter($users, fn($u) => $u['type'] === 'admin')); ?> | Regular: <?php echo count(array_filter($users, fn($u) => $u['type'] === 'user')); ?></small>
          </div>
        </div>      <!-- Users Table -->
      <div class="card shadow-sm">
        <div class="card-header bg-danger text-white">
          <h5 class="mb-0"><i class="bi bi-people me-2"></i>User Accounts</h5>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
              <thead class="table-light">
                <tr>
                  <th style="width: 25%;"><i class="bi bi-envelope me-2"></i>Email</th>
                  <th style="width: 20%;"><i class="bi bi-person me-2"></i>Name</th>
                  <th style="width: 12%;"><i class="bi bi-gender-ambiguous me-2"></i>Gender</th>
                  <th style="width: 15%;"><i class="bi bi-shield me-2"></i>Type</th>
                  <th style="width: 28%;"><i class="bi bi-tools me-2"></i>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php if (empty($users)): ?>
                  <tr>
                    <td colspan="5" class="text-center">No users found</td>
                  </tr>
                <?php else: ?>
                  <?php foreach ($users as $user): ?>
                    <tr>
                      <td><?php echo htmlspecialchars($user['email']); ?></td>
                      <td><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></td>
                      <td><?php echo htmlspecialchars($user['gender']); ?></td>
                      <td>
                        <span class="badge bg-<?php echo $user['type'] === 'admin' ? 'danger' : 'secondary'; ?>">
                          <?php echo htmlspecialchars($user['type']); ?>
                        </span>
                      </td>
                      <td>
                        <button class="btn btn-sm btn-warning" 
                                onclick="editUser('<?php echo htmlspecialchars($user['email']); ?>', 
                                                 '<?php echo htmlspecialchars($user['first_name']); ?>', 
                                                 '<?php echo htmlspecialchars($user['last_name']); ?>', 
                                                 '<?php echo htmlspecialchars($user['gender']); ?>', 
                                                 '<?php echo htmlspecialchars($user['type']); ?>')">
                          <i class="bi bi-pencil"></i> Edit
                        </button>
                        <?php if ($user['email'] !== $_SESSION['user_email']): ?>
                          <a href="?action=delete&email=<?php echo urlencode($user['email']); ?>" 
                             class="btn btn-sm btn-danger"
                             onclick="return confirm('Are you sure you want to delete this user? This action cannot be undone.')">
                            <i class="bi bi-trash"></i> Delete
                          </a>
                        <?php endif; ?>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      </div>
    </section>
  </main>

  <!-- Add User Modal -->
  <div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add New User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <form method="post">
          <div class="modal-body">
            <input type="hidden" name="action" value="add">
            <div class="mb-3">
              <label for="add_email" class="form-label">Email</label>
              <input type="email" class="form-control" id="add_email" name="email" required>
            </div>
            <div class="mb-3">
              <label for="add_first_name" class="form-label">First Name</label>
              <input type="text" class="form-control" id="add_first_name" name="first_name" required>
            </div>
            <div class="mb-3">
              <label for="add_last_name" class="form-label">Last Name</label>
              <input type="text" class="form-control" id="add_last_name" name="last_name" required>
            </div>
            <div class="mb-3">
              <label for="add_gender" class="form-label">Gender</label>
              <select class="form-select" id="add_gender" name="gender" required>
                <option value="Female">Female</option>
                <option value="Male">Male</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="add_user_type" class="form-label">User Type</label>
              <select class="form-select" id="add_user_type" name="user_type" required>
                <option value="user">User</option>
                <option value="admin">Admin</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="add_password" class="form-label">Password</label>
              <input type="password" class="form-control" id="add_password" name="password" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Add User</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Edit User Modal -->
  <div class="modal fade" id="editUserModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <form method="post">
          <div class="modal-body">
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="original_email" id="edit_original_email">
            <div class="mb-3">
              <label for="edit_email" class="form-label">Email</label>
              <input type="email" class="form-control" id="edit_email" name="email" readonly>
            </div>
            <div class="mb-3">
              <label for="edit_first_name" class="form-label">First Name</label>
              <input type="text" class="form-control" id="edit_first_name" name="first_name" required>
            </div>
            <div class="mb-3">
              <label for="edit_last_name" class="form-label">Last Name</label>
              <input type="text" class="form-control" id="edit_last_name" name="last_name" required>
            </div>
            <div class="mb-3">
              <label for="edit_gender" class="form-label">Gender</label>
              <select class="form-select" id="edit_gender" name="gender" required>
                <option value="Female">Female</option>
                <option value="Male">Male</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="edit_user_type" class="form-label">User Type</label>
              <select class="form-select" id="edit_user_type" name="user_type" required>
                <option value="user">User</option>
                <option value="admin">Admin</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="edit_password" class="form-label">New Password (leave empty to keep current)</label>
              <input type="password" class="form-control" id="edit_password" name="password">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-warning">Update User</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function editUser(email, firstName, lastName, gender, userType) {
      document.getElementById('edit_original_email').value = email;
      document.getElementById('edit_email').value = email;
      document.getElementById('edit_first_name').value = firstName;
      document.getElementById('edit_last_name').value = lastName;
      document.getElementById('edit_gender').value = gender;
      document.getElementById('edit_user_type').value = userType;
      document.getElementById('edit_password').value = '';
      
      var modal = new bootstrap.Modal(document.getElementById('editUserModal'));
      modal.show();
    }
  </script>

  <?php include __DIR__ . '/footer.php'; ?>
</body>
</html>
