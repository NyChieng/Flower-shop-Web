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

// Handle approve/reject actions
if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $id = intval($_GET['id']);
    
    if ($action === 'approve' || $action === 'reject') {
        $newStatus = $action === 'approve' ? 'approved' : 'rejected';
        
        try {
            $conn = getDBConnection();
            $stmt = $conn->prepare("UPDATE workshop_table SET status = ? WHERE id = ?");
            $stmt->bind_param("si", $newStatus, $id);
            
            if ($stmt->execute()) {
                $message = 'Workshop registration ' . $newStatus . ' successfully.';
                $messageType = 'success';
            } else {
                $message = 'Failed to update status.';
                $messageType = 'danger';
            }
            
            $stmt->close();
            $conn->close();
        } catch (Exception $e) {
            $message = 'Error: ' . $e->getMessage();
            $messageType = 'danger';
        }
    } elseif ($action === 'delete') {
        try {
            $conn = getDBConnection();
            $stmt = $conn->prepare("DELETE FROM workshop_table WHERE id = ?");
            $stmt->bind_param("i", $id);
            
            if ($stmt->execute()) {
                $message = 'Workshop registration deleted successfully.';
                $messageType = 'success';
            } else {
                $message = 'Failed to delete registration.';
                $messageType = 'danger';
            }
            
            $stmt->close();
            $conn->close();
        } catch (Exception $e) {
            $message = 'Error: ' . $e->getMessage();
            $messageType = 'danger';
        }
    }
}

// Get all workshop registrations
$registrations = [];
try {
    $conn = getDBConnection();
    $result = $conn->query("SELECT * FROM workshop_table ORDER BY status DESC, date DESC, id DESC");
    
    while ($row = $result->fetch_assoc()) {
        $registrations[] = $row;
    }
    
    $conn->close();
} catch (Exception $e) {
    $message = 'Error loading registrations: ' . $e->getMessage();
    $messageType = 'danger';
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Manage Workshop Registrations - Root Flowers Admin</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="style/style.css">
  <style>
    .status-pending { background-color: #fff3cd; }
    .status-approved { background-color: #d1e7dd; }
    .status-rejected { background-color: #f8d7da; }
  </style>
</head>
<body class="rf-page">
  <?php include __DIR__ . '/nav.php'; ?>

  <main class="rf-main" id="main-content">
    <!-- Page Header -->
    <section class="rf-section" aria-labelledby="page-title">
      <header class="rf-section-header">
        <h1 id="page-title" class="rf-section-title">
          <i class="bi bi-calendar-check me-2"></i>Manage Workshop Registrations
        </h1>
        <p class="rf-section-text">
          Review and manage all workshop registration requests from users.
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

        <div class="card shadow-sm">
          <div class="card-header bg-success text-white">
            <h5 class="mb-0"><i class="bi bi-calendar-check me-2"></i>Workshop Registrations</h5>
          </div>
          <div class="card-body">
          <?php if (empty($registrations)): ?>
            <p class="text-center text-muted">No workshop registrations found.</p>
          <?php else: ?>
            <div class="table-responsive">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Participant Name</th>
                    <th>Email</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Contact Number</th>
                    <th>Status</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($registrations as $reg): ?>
                    <tr class="status-<?php echo htmlspecialchars($reg['status']); ?>">
                      <td><?php echo htmlspecialchars($reg['id']); ?></td>
                      <td><?php echo htmlspecialchars($reg['first_name'] . ' ' . $reg['last_name']); ?></td>
                      <td><?php echo htmlspecialchars($reg['email']); ?></td>
                      <td><?php echo $reg['date'] ? htmlspecialchars(date('d M Y', strtotime($reg['date']))) : 'N/A'; ?></td>
                      <td><?php echo $reg['time'] ? htmlspecialchars(date('h:i A', strtotime($reg['time']))) : 'N/A'; ?></td>
                      <td><?php echo htmlspecialchars($reg['contact_number'] ?? 'N/A'); ?></td>
                      <td>
                        <span class="badge bg-<?php 
                          echo $reg['status'] === 'approved' ? 'success' : 
                               ($reg['status'] === 'rejected' ? 'danger' : 'warning'); 
                        ?>">
                          <?php echo ucfirst(htmlspecialchars($reg['status'])); ?>
                        </span>
                      </td>
                      <td>
                        <?php if ($reg['status'] === 'pending'): ?>
                          <button class="btn btn-sm btn-success" 
                                  data-bs-toggle="modal" 
                                  data-bs-target="#confirmModal"
                                  data-action="approve"
                                  data-id="<?php echo $reg['id']; ?>"
                                  data-name="<?php echo htmlspecialchars($reg['first_name'] . ' ' . $reg['last_name']); ?>">
                            <i class="bi bi-check-circle"></i> Approve
                          </button>
                          <button class="btn btn-sm btn-danger" 
                                  data-bs-toggle="modal" 
                                  data-bs-target="#confirmModal"
                                  data-action="reject"
                                  data-id="<?php echo $reg['id']; ?>"
                                  data-name="<?php echo htmlspecialchars($reg['first_name'] . ' ' . $reg['last_name']); ?>">
                            <i class="bi bi-x-circle"></i> Reject
                          </button>
                        <?php elseif ($reg['status'] === 'approved'): ?>
                          <button class="btn btn-sm btn-danger" 
                                  data-bs-toggle="modal" 
                                  data-bs-target="#confirmModal"
                                  data-action="reject"
                                  data-id="<?php echo $reg['id']; ?>"
                                  data-name="<?php echo htmlspecialchars($reg['first_name'] . ' ' . $reg['last_name']); ?>">
                            <i class="bi bi-x-circle"></i> Reject
                          </button>
                        <?php else: ?>
                          <button class="btn btn-sm btn-success" 
                                  data-bs-toggle="modal" 
                                  data-bs-target="#confirmModal"
                                  data-action="approve"
                                  data-id="<?php echo $reg['id']; ?>"
                                  data-name="<?php echo htmlspecialchars($reg['first_name'] . ' ' . $reg['last_name']); ?>">
                            <i class="bi bi-check-circle"></i> Approve
                          </button>
                        <?php endif; ?>
                        
                        <button class="btn btn-sm btn-secondary" 
                                data-bs-toggle="modal" 
                                data-bs-target="#confirmModal"
                                data-action="delete"
                                data-id="<?php echo $reg['id']; ?>"
                                data-name="<?php echo htmlspecialchars($reg['first_name'] . ' ' . $reg['last_name']); ?>">
                          <i class="bi bi-trash"></i> Delete
                        </button>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          <?php endif; ?>
        </div>
      </div>
      </div>
    </section>
  </main>

  <!-- Confirmation Modal -->
  <div class="modal fade" id="confirmModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="confirmModalTitle">Confirm Action</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body" id="confirmModalBody">
          Are you sure?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <a href="#" id="confirmButton" class="btn btn-primary">Confirm</a>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var confirmModal = document.getElementById('confirmModal');
      
      confirmModal.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget;
        var action = button.getAttribute('data-action');
        var id = button.getAttribute('data-id');
        var name = button.getAttribute('data-name');
        
        var modalTitle = confirmModal.querySelector('#confirmModalTitle');
        var modalBody = confirmModal.querySelector('#confirmModalBody');
        var confirmButton = confirmModal.querySelector('#confirmButton');
        
        if (action === 'approve') {
          modalTitle.textContent = 'Approve Workshop Registration';
          modalBody.textContent = 'Are you sure you want to approve the registration from ' + name + '?';
          confirmButton.className = 'btn btn-success';
          confirmButton.textContent = 'Approve';
        } else if (action === 'reject') {
          modalTitle.textContent = 'Reject Workshop Registration';
          modalBody.textContent = 'Are you sure you want to reject the registration from ' + name + '?';
          confirmButton.className = 'btn btn-danger';
          confirmButton.textContent = 'Reject';
        } else if (action === 'delete') {
          modalTitle.textContent = 'Delete Workshop Registration';
          modalBody.textContent = 'Are you sure you want to delete the registration from ' + name + '? This action cannot be undone.';
          confirmButton.className = 'btn btn-secondary';
          confirmButton.textContent = 'Delete';
        }
        
        confirmButton.href = '?action=' + action + '&id=' + id;
      });
    });
  </script>

  <?php include __DIR__ . '/footer.php'; ?>
</body>
</html>
