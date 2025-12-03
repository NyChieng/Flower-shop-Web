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
            SELECT w.id, w.Name, w.Email, w.Workshop_Name, w.Skill_Level, w.Workshop_Date, w.status,
                   u.first_name, u.last_name
            FROM workshop_table w
            LEFT JOIN user_table u ON w.Email = u.email
            ORDER BY w.id DESC
        ");
        
        // Set headers for Excel download
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="workshop_registrations_' . date('Y-m-d') . '.xls"');
        header('Cache-Control: max-age=0');
        
        // Output Excel content
        echo "<table border='1'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>ID</th>";
        echo "<th>Participant Name</th>";
        echo "<th>Email</th>";
        echo "<th>Workshop Name</th>";
        echo "<th>Skill Level</th>";
        echo "<th>Workshop Date</th>";
        echo "<th>Status</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['id']) . "</td>";
            echo "<td>" . htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Email']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Workshop_Name']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Skill_Level']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Workshop_Date']) . "</td>";
            echo "<td>" . htmlspecialchars(ucfirst($row['status'])) . "</td>";
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

        <!-- Statistics Cards -->
        <div class="row g-3 mb-4">
          <div class="col-md-3">
            <div class="card text-center border-warning shadow-sm">
              <div class="card-body">
                <i class="bi bi-hourglass-split text-warning display-6"></i>
                <h3 class="mt-2 mb-0"><?php echo count(array_filter($registrations, fn($r) => $r['status'] === 'pending')); ?></h3>
                <p class="text-muted small mb-0">Pending</p>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card text-center border-success shadow-sm">
              <div class="card-body">
                <i class="bi bi-check-circle text-success display-6"></i>
                <h3 class="mt-2 mb-0"><?php echo count(array_filter($registrations, fn($r) => $r['status'] === 'approved')); ?></h3>
                <p class="text-muted small mb-0">Approved</p>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card text-center border-danger shadow-sm">
              <div class="card-body">
                <i class="bi bi-x-circle text-danger display-6"></i>
                <h3 class="mt-2 mb-0"><?php echo count(array_filter($registrations, fn($r) => $r['status'] === 'rejected')); ?></h3>
                <p class="text-muted small mb-0">Rejected</p>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card text-center border-primary shadow-sm">
              <div class="card-body">
                <i class="bi bi-people text-primary display-6"></i>
                <h3 class="mt-2 mb-0"><?php echo count($registrations); ?></h3>
                <p class="text-muted small mb-0">Total</p>
              </div>
            </div>
          </div>
        </div>

        <div class="card shadow-sm">
          <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="bi bi-calendar-check me-2"></i>Workshop Registrations</h5>
            <a href="?export=excel" class="btn btn-light btn-sm">
              <i class="bi bi-file-earmark-spreadsheet me-1"></i>Export to Excel
            </a>
          </div>
          <div class="card-body">
          <?php if (empty($registrations)): ?>
            <div class="text-center py-5">
              <i class="bi bi-calendar-x display-1 text-muted mb-3"></i>
              <p class="text-muted fs-5">No workshop registrations found.</p>
            </div>
          <?php else: ?>
            <div class="table-responsive">
              <table class="table table-hover align-middle">
                <thead class="table-light">
                  <tr>
                    <th style="width: 5%;">ID</th>
                    <th style="width: 15%;">Participant</th>
                    <th style="width: 15%;">Email</th>
                    <th style="width: 12%;">Date</th>
                    <th style="width: 10%;">Time</th>
                    <th style="width: 13%;">Contact</th>
                    <th style="width: 10%;">Status</th>
                    <th style="width: 20%;">Actions</th>
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
                        <div class="d-flex gap-1 flex-nowrap" style="min-width: 200px;">
                        <?php if ($reg['status'] === 'pending'): ?>
                          <button class="btn btn-success btn-sm" 
                                  data-bs-toggle="modal" 
                                  data-bs-target="#confirmModal"
                                  data-action="approve"
                                  data-id="<?php echo $reg['id']; ?>"
                                  data-name="<?php echo htmlspecialchars($reg['first_name'] . ' ' . $reg['last_name']); ?>"
                                  title="Approve registration">
                            <i class="bi bi-check-circle"></i> Approve
                          </button>
                          <button class="btn btn-danger btn-sm" 
                                  data-bs-toggle="modal" 
                                  data-bs-target="#confirmModal"
                                  data-action="reject"
                                  data-id="<?php echo $reg['id']; ?>"
                                  data-name="<?php echo htmlspecialchars($reg['first_name'] . ' ' . $reg['last_name']); ?>"
                                  title="Reject registration">
                            <i class="bi bi-x-circle"></i> Reject
                          </button>
                        <?php elseif ($reg['status'] === 'approved'): ?>
                          <button class="btn btn-danger btn-sm" 
                                  data-bs-toggle="modal" 
                                  data-bs-target="#confirmModal"
                                  data-action="reject"
                                  data-id="<?php echo $reg['id']; ?>"
                                  data-name="<?php echo htmlspecialchars($reg['first_name'] . ' ' . $reg['last_name']); ?>"
                                  title="Reject registration">
                            <i class="bi bi-x-circle"></i> Reject
                          </button>
                        <?php else: ?>
                          <button class="btn btn-success btn-sm" 
                                  data-bs-toggle="modal" 
                                  data-bs-target="#confirmModal"
                                  data-action="approve"
                                  data-id="<?php echo $reg['id']; ?>"
                                  data-name="<?php echo htmlspecialchars($reg['first_name'] . ' ' . $reg['last_name']); ?>"
                                  title="Approve registration">
                            <i class="bi bi-check-circle"></i> Approve
                          </button>
                        <?php endif; ?>
                        
                        <button class="btn btn-outline-secondary btn-sm" 
                                data-bs-toggle="modal" 
                                data-bs-target="#confirmModal"
                                data-action="delete"
                                data-id="<?php echo $reg['id']; ?>"
                                data-name="<?php echo htmlspecialchars($reg['first_name'] . ' ' . $reg['last_name']); ?>"
                                title="Delete registration">
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
