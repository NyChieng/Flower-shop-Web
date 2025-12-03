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
            $stmt = $conn->prepare("UPDATE studentwork_table SET status = ? WHERE id = ?");
            $stmt->bind_param("si", $newStatus, $id);
            
            if ($stmt->execute()) {
                $message = 'Student work ' . $newStatus . ' successfully.';
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
            $stmt = $conn->prepare("DELETE FROM studentwork_table WHERE id = ?");
            $stmt->bind_param("i", $id);
            
            if ($stmt->execute()) {
                $message = 'Student work deleted successfully.';
                $messageType = 'success';
            } else {
                $message = 'Failed to delete student work.';
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

// Get all student works
$studentWorks = [];
try {
    $conn = getDBConnection();
    $result = $conn->query("SELECT * FROM studentwork_table ORDER BY status DESC, id DESC");
    
    while ($row = $result->fetch_assoc()) {
        $studentWorks[] = $row;
    }
    
    $conn->close();
} catch (Exception $e) {
    $message = 'Error loading student works: ' . $e->getMessage();
    $messageType = 'danger';
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Manage Student Works - Root Flowers Admin</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="style/style.css">
  <style>
    .status-pending { background-color: #fff3cd; }
    .status-approved { background-color: #d1e7dd; }
    .status-rejected { background-color: #f8d7da; }
    .workshop-image {
      width: 100px;
      height: 100px;
      object-fit: cover;
      border-radius: 5px;
    }
  </style>
</head>
<body class="rf-page">
  <?php include __DIR__ . '/nav.php'; ?>

  <main class="rf-main" id="main-content">
    <section class="rf-section" aria-labelledby="page-title">
      <header class="rf-section-header">
        <h1 id="page-title" class="rf-section-title">
          <i class="bi bi-images me-2"></i>Manage Student Works
        </h1>
        <p class="rf-section-text">
          Review and manage student workshop submissions from the community.
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
          <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="bi bi-images me-2"></i>Student Work Submissions</h5>
          </div>
        <div class="card-body">
          <?php if (empty($studentWorks)): ?>
            <div class="text-center py-5">
              <i class="bi bi-images display-1 text-muted mb-3"></i>
              <p class="text-muted fs-5">No student work submissions found.</p>
            </div>
          <?php else: ?>
            <div class="table-responsive">
              <table class="table table-hover align-middle">
                <thead class="table-light">
                  <tr>
                    <th style="width: 5%;">ID</th>
                    <th style="width: 12%;">Preview</th>
                    <th style="width: 18%;">Student</th>
                    <th style="width: 20%;">Email</th>
                    <th style="width: 15%;">Workshop</th>
                    <th style="width: 10%;">Status</th>
                    <th style="width: 20%;">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($studentWorks as $work): ?>
                    <tr class="status-<?php echo htmlspecialchars($work['status']); ?>">
                      <td><?php echo htmlspecialchars($work['id']); ?></td>
                      <td>
                        <?php if ($work['workshop_image'] && file_exists($work['workshop_image'])): ?>
                          <img src="<?php echo htmlspecialchars($work['workshop_image']); ?>" 
                               alt="Workshop" 
                               class="workshop-image">
                        <?php else: ?>
                          <span class="text-muted">No image</span>
                        <?php endif; ?>
                      </td>
                      <td><?php echo htmlspecialchars($work['first_name'] . ' ' . $work['last_name']); ?></td>
                      <td><?php echo htmlspecialchars($work['email']); ?></td>
                      <td><?php echo htmlspecialchars($work['workshop_title']); ?></td>
                      <td>
                        <span class="badge bg-<?php 
                          echo $work['status'] === 'approved' ? 'success' : 
                               ($work['status'] === 'rejected' ? 'danger' : 'warning'); 
                        ?>">
                          <?php echo ucfirst(htmlspecialchars($work['status'])); ?>
                        </span>
                      </td>
                      <td>
                        <div class="d-flex gap-1 flex-nowrap" style="min-width: 200px;">
                        <?php if ($work['status'] === 'pending'): ?>
                          <button class="btn btn-success btn-sm" 
                                  data-bs-toggle="modal" 
                                  data-bs-target="#confirmModal"
                                  data-action="approve"
                                  data-id="<?php echo $work['id']; ?>"
                                  data-name="<?php echo htmlspecialchars($work['first_name'] . ' ' . $work['last_name']); ?>"
                                  title="Approve submission">
                            <i class="bi bi-check-circle"></i> Approve
                          </button>
                          <button class="btn btn-danger btn-sm" 
                                  data-bs-toggle="modal" 
                                  data-bs-target="#confirmModal"
                                  data-action="reject"
                                  data-id="<?php echo $work['id']; ?>"
                                  data-name="<?php echo htmlspecialchars($work['first_name'] . ' ' . $work['last_name']); ?>"
                                  title="Reject submission">
                            <i class="bi bi-x-circle"></i> Reject
                          </button>
                        <?php elseif ($work['status'] === 'approved'): ?>
                          <button class="btn btn-danger btn-sm" 
                                  data-bs-toggle="modal" 
                                  data-bs-target="#confirmModal"
                                  data-action="reject"
                                  data-id="<?php echo $work['id']; ?>"
                                  data-name="<?php echo htmlspecialchars($work['first_name'] . ' ' . $work['last_name']); ?>"
                                  title="Reject submission">
                            <i class="bi bi-x-circle"></i> Reject
                          </button>
                        <?php else: ?>
                          <button class="btn btn-success btn-sm" 
                                  data-bs-toggle="modal" 
                                  data-bs-target="#confirmModal"
                                  data-action="approve"
                                  data-id="<?php echo $work['id']; ?>"
                                  data-name="<?php echo htmlspecialchars($work['first_name'] . ' ' . $work['last_name']); ?>"
                                  title="Approve submission">
                            <i class="bi bi-check-circle"></i> Approve
                          </button>
                        <?php endif; ?>
                          <button class="btn btn-outline-secondary btn-sm" 
                                  data-bs-toggle="modal" 
                                  data-bs-target="#confirmModal"
                                  data-action="delete"
                                  data-id="<?php echo $work['id']; ?>"
                                  data-name="<?php echo htmlspecialchars($work['first_name'] . ' ' . $work['last_name']); ?>"
                                  title="Delete submission">
                            <i class="bi bi-trash"></i> Delete
                          </button>
                        </div>
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
          modalTitle.textContent = 'Approve Student Work';
          modalBody.textContent = 'Are you sure you want to approve the work submitted by ' + name + '?';
          confirmButton.className = 'btn btn-success';
          confirmButton.textContent = 'Approve';
        } else if (action === 'reject') {
          modalTitle.textContent = 'Reject Student Work';
          modalBody.textContent = 'Are you sure you want to reject the work submitted by ' + name + '?';
          confirmButton.className = 'btn btn-danger';
          confirmButton.textContent = 'Reject';
        } else if (action === 'delete') {
          modalTitle.textContent = 'Delete Student Work';
          modalBody.textContent = 'Are you sure you want to delete the work submitted by ' + name + '? This action cannot be undone.';
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
