<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once 'main.php';

// Check if user is logged in and is admin
if (empty($_SESSION['user_email'])) {
    $_SESSION['flash'] = 'Please login to continue.';
    header('Location: login.php');
    exit;
}

if (($_SESSION['user_type'] ?? 'user') !== 'admin') {
    $_SESSION['flash'] = 'Access denied. Admin privileges required.';
    header('Location: main_menu.php');
    exit;
}

$message = '';
$messageType = 'success';

// Handle approve/reject actions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'], $_POST['flower_id'])) {
    $flowerId = (int)$_POST['flower_id'];
    $action = $_POST['action'];
    
    if ($action === 'approve') {
        try {
            $conn = getDBConnection();
            $stmt = $conn->prepare("UPDATE flower_table SET status = 'approved' WHERE id = ?");
            $stmt->bind_param("i", $flowerId);
            if ($stmt->execute()) {
                $message = 'Flower contribution approved successfully.';
            } else {
                $message = 'Failed to approve flower.';
                $messageType = 'danger';
            }
            $stmt->close();
            $conn->close();
        } catch (Exception $e) {
            $message = 'Error: ' . $e->getMessage();
            $messageType = 'danger';
        }
    } elseif ($action === 'reject') {
        try {
            $conn = getDBConnection();
            $stmt = $conn->prepare("UPDATE flower_table SET status = 'rejected' WHERE id = ?");
            $stmt->bind_param("i", $flowerId);
            if ($stmt->execute()) {
                $message = 'Flower contribution rejected.';
                $messageType = 'warning';
            } else {
                $message = 'Failed to reject flower.';
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
            $stmt = $conn->prepare("DELETE FROM flower_table WHERE id = ?");
            $stmt->bind_param("i", $flowerId);
            if ($stmt->execute()) {
                $message = 'Flower deleted successfully.';
            } else {
                $message = 'Failed to delete flower.';
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

// Fetch all flower contributions
$flowers = [];
try {
    $conn = getDBConnection();
    $result = $conn->query("SELECT f.*, u.first_name, u.last_name 
                            FROM flower_table f 
                            LEFT JOIN user_table u ON f.contributor_email = u.email 
                            ORDER BY f.contribution_date DESC");
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $flowers[] = $row;
        }
    }
    $conn->close();
} catch (Exception $e) {
    $message = 'Error loading flowers: ' . $e->getMessage();
    $messageType = 'danger';
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Manage Flower Contributions - Root Flowers Admin</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="style/style.css">
  <style>
    .status-pending { background-color: #fff3cd; }
    .status-approved { background-color: #d1e7dd; }
    .status-rejected { background-color: #f8d7da; }
    .flower-thumb {
      width: 80px;
      height: 80px;
      object-fit: cover;
      border-radius: 8px;
    }
  </style>
</head>
<body class="rf-page">
  <?php include __DIR__ . '/nav.php'; ?>

  <main class="rf-main" id="main-content">
    <section class="rf-section" aria-labelledby="page-title">
      <header class="rf-section-header">
        <h1 id="page-title" class="rf-section-title">
          <i class="bi bi-flower1 me-2"></i>Manage Flower Contributions
        </h1>
        <p class="rf-section-text">
          Review and approve community flower contributions to the database.
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
          <div class="card-header bg-warning text-dark">
            <h2 class="mb-0"><i class="bi bi-flower1 me-2"></i>Flower Contributions</h2>
          </div>
          <div class="card-body">
        <?php if (empty($flowers)): ?>
          <p class="text-muted text-center py-4">No flower contributions yet.</p>
        <?php else: ?>
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>Image</th>
                  <th>Scientific Name</th>
                  <th>Common Name</th>
                  <th>Contributor</th>
                  <th>Date</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($flowers as $flower): ?>
                  <tr class="status-<?php echo htmlspecialchars($flower['status']); ?>">
                    <td>
                      <?php if ($flower['Plant_image'] && file_exists($flower['Plant_image'])): ?>
                        <img src="<?php echo htmlspecialchars($flower['Plant_image']); ?>" class="flower-thumb" alt="Flower">
                      <?php else: ?>
                        <div class="flower-thumb bg-secondary d-flex align-items-center justify-content-center">
                          <i class="bi bi-flower1 text-white"></i>
                        </div>
                      <?php endif; ?>
                    </td>
                    <td><em><?php echo htmlspecialchars($flower['Scientific_Name']); ?></em></td>
                    <td><?php echo htmlspecialchars($flower['Common_Name']); ?></td>
                    <td>
                      <?php 
                      if ($flower['first_name'] && $flower['last_name']) {
                        echo htmlspecialchars($flower['first_name'] . ' ' . $flower['last_name']);
                      } else {
                        echo htmlspecialchars($flower['contributor_email'] ?? 'Unknown');
                      }
                      ?>
                    </td>
                    <td><?php echo $flower['contribution_date'] ? date('M d, Y', strtotime($flower['contribution_date'])) : 'N/A'; ?></td>
                    <td>
                      <span class="badge bg-<?php 
                        echo $flower['status'] === 'approved' ? 'success' : 
                            ($flower['status'] === 'rejected' ? 'danger' : 'warning'); 
                      ?>">
                        <?php echo ucfirst($flower['status']); ?>
                      </span>
                    </td>
                    <td>
                      <div class="btn-group btn-group-sm">
                        <?php if ($flower['status'] !== 'approved'): ?>
                          <form method="post" style="display:inline;">
                            <input type="hidden" name="flower_id" value="<?php echo $flower['id']; ?>">
                            <input type="hidden" name="action" value="approve">
                            <button type="submit" class="btn btn-success btn-sm" title="Approve">
                              <i class="bi bi-check-lg"></i>
                            </button>
                          </form>
                        <?php endif; ?>
                        
                        <?php if ($flower['status'] !== 'rejected'): ?>
                          <form method="post" style="display:inline;">
                            <input type="hidden" name="flower_id" value="<?php echo $flower['id']; ?>">
                            <input type="hidden" name="action" value="reject">
                            <button type="submit" class="btn btn-warning btn-sm" title="Reject">
                              <i class="bi bi-x-lg"></i>
                            </button>
                          </form>
                        <?php endif; ?>
                        
                        <form method="post" style="display:inline;" onsubmit="return confirm('Delete this flower permanently?');">
                          <input type="hidden" name="flower_id" value="<?php echo $flower['id']; ?>">
                          <input type="hidden" name="action" value="delete">
                          <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                            <i class="bi bi-trash"></i>
                          </button>
                        </form>
                        
                        <?php if ($flower['Description'] && file_exists($flower['Description'])): ?>
                          <a href="<?php echo htmlspecialchars($flower['Description']); ?>" 
                             class="btn btn-info btn-sm" 
                             target="_blank" 
                             title="View PDF">
                            <i class="bi bi-file-pdf"></i>
                          </a>
                        <?php endif; ?>
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

    <div class="mt-4">
      <h4>Statistics</h4>
      <div class="row g-3">
        <div class="col-md-3">
          <div class="card text-center border-warning">
            <div class="card-body">
              <h5 class="card-title">Pending</h5>
              <p class="display-6 text-warning">
                <?php echo count(array_filter($flowers, fn($f) => $f['status'] === 'pending')); ?>
              </p>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card text-center border-success">
            <div class="card-body">
              <h5 class="card-title">Approved</h5>
              <p class="display-6 text-success">
                <?php echo count(array_filter($flowers, fn($f) => $f['status'] === 'approved')); ?>
              </p>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card text-center border-danger">
            <div class="card-body">
              <h5 class="card-title">Rejected</h5>
              <p class="display-6 text-danger">
                <?php echo count(array_filter($flowers, fn($f) => $f['status'] === 'rejected')); ?>
              </p>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card text-center border-primary">
            <div class="card-body">
              <h5 class="card-title">Total</h5>
              <p class="display-6 text-primary">
                <?php echo count($flowers); ?>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
      </div>
    </section>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <?php include __DIR__ . '/footer.php'; ?>
</body>
</html>
