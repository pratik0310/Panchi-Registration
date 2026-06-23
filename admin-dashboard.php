<?php
require_once 'config.php';

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin-login.php');
    exit();
}

// Pagination settings
$limit = 10; // Records per page
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// Search functionality
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

// Build search query
$search_condition = '';
if (!empty($search)) {
    $search_condition = "WHERE 
        full_name LIKE '%$search%' OR 
        mobile_number LIKE '%$search%' OR 
        email LIKE '%$search%' OR 
        city LIKE '%$search%'";
}

// Count total records for pagination
$count_sql = "SELECT COUNT(*) as total FROM registrations $search_condition";
$count_result = mysqli_query($conn, $count_sql);
$total_records = mysqli_fetch_assoc($count_result)['total'];
$total_pages = ceil($total_records / $limit);

// Fetch records with pagination
$sql = "SELECT * FROM registrations $search_condition ORDER BY created_at DESC LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $sql);

// Statistics (only for non-search view)
if (empty($search)) {
    $total_result = mysqli_query($conn, "SELECT COUNT(*) as total FROM registrations");
    $total = mysqli_fetch_assoc($total_result)['total'];

    $pending_result = mysqli_query($conn, "SELECT COUNT(*) as pending FROM registrations WHERE status = 'pending'");
    $pending = mysqli_fetch_assoc($pending_result)['pending'];

    $approved_result = mysqli_query($conn, "SELECT COUNT(*) as approved FROM registrations WHERE status = 'approved'");
    $approved = mysqli_fetch_assoc($approved_result)['approved'];
} else {
    // For search results, show filtered counts
    $total = $total_records;
    $pending_result = mysqli_query($conn, "SELECT COUNT(*) as pending FROM registrations $search_condition AND status = 'pending'");
    $pending = mysqli_fetch_assoc($pending_result)['pending'];
    
    $approved_result = mysqli_query($conn, "SELECT COUNT(*) as approved FROM registrations $search_condition AND status = 'approved'");
    $approved = mysqli_fetch_assoc($approved_result)['approved'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panchi - Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="admin-container">
        <nav class="admin-nav">
            <div class="nav-brand">
                <span></span> Volunteers of Vitthal
            </div>
            <div class="nav-right">
                <span>Welcome, <?php echo $_SESSION['admin_email']; ?></span>
                <a href="logout.php" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </nav>

        <div class="admin-stats">
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-users"></i></div>
                <div class="stat-info">
                    <h3><?php echo $total; ?></h3>
                    <p>Total Registrations</p>
                </div>
            </div>
            <div class="stat-card pending">
                <div class="stat-icon"><i class="fas fa-clock"></i></div>
                <div class="stat-info">
                    <h3><?php echo $pending; ?></h3>
                    <p>Pending</p>
                </div>
            </div>
            <div class="stat-card approved">
                <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
                <div class="stat-info">
                    <h3><?php echo $approved; ?></h3>
                    <p>Approved</p>
                </div>
            </div>
        </div>

        <div class="table-container">
            <div class="table-header">
                <h2><i class="fas fa-list"></i> All Registrations</h2>
                
                <!-- Search Form -->
                <form method="GET" action="" class="search-form">
                    <div class="search-wrapper">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" name="search" placeholder="Search by name, email, mobile, city..." value="<?php echo htmlspecialchars($search); ?>">
                        <button type="submit" class="btn-search">
                            <i class="fas fa-search"></i> Search
                        </button>
                        <?php if (!empty($search)): ?>
                            <a href="admin-dashboard.php" class="btn-clear">
                                <i class="fas fa-times"></i> Clear
                            </a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>

            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>sr.no</th>
                            <th>Name</th>
                            <th>Mobile</th>
                            <th>Email</th>
                            <th>City</th>
                            <th>Participants</th>
                            <th>Status</th>
                            <th>Screenshot</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($result) > 0): ?>
                            <?php 
                            $serial = $offset + 1;
                            while ($row = mysqli_fetch_assoc($result)): 
                            ?>
                            <tr>
                                <td><?php echo $serial++; ?></td>
                                <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                                <td><?php echo $row['mobile_number']; ?></td>
                                <td><?php echo htmlspecialchars($row['email']); ?></td>
                                <td><?php echo htmlspecialchars($row['city']); ?></td>
                                <td><?php echo $row['participants']; ?></td>
                                <td>
                                    <span class="status-badge status-<?php echo $row['status']; ?>">
                                        <?php echo ucfirst($row['status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="<?php echo $row['payment_screenshot']; ?>" target="_blank" class="btn-view">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="update-status.php?id=<?php echo $row['id']; ?>&status=approved" class="btn-approve" onclick="return confirm('Approve this registration?')">
                                            <i class="fas fa-check"></i>
                                        </a>
                                        <a href="update-status.php?id=<?php echo $row['id']; ?>&status=rejected" class="btn-reject" onclick="return confirm('Reject this registration?')">
                                            <i class="fas fa-times"></i>
                                        </a>
                                        <a href="view-details.php?id=<?php echo $row['id']; ?>" class="btn-details">
                                            <i class="fas fa-info-circle"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" style="text-align: center; padding: 40px; color: #999;">
                                    <i class="fas fa-inbox" style="font-size: 40px; display: block; margin-bottom: 10px;"></i>
                                    <?php if (!empty($search)): ?>
                                        No results found for "<?php echo htmlspecialchars($search); ?>"
                                    <?php else: ?>
                                        No registrations yet
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <?php if ($total_pages > 1): ?>
            <div class="pagination">
                <div class="pagination-info">
                    Showing <?php echo $offset + 1; ?> to <?php echo min($offset + $limit, $total_records); ?> of <?php echo $total_records; ?> entries
                </div>
                <div class="pagination-links">
                    <!-- Previous -->
                    <?php if ($page > 1): ?>
                        <a href="?page=<?php echo $page - 1; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>" class="page-link">
                            <i class="fas fa-chevron-left"></i> Prev
                        </a>
                    <?php else: ?>
                        <span class="page-link disabled">
                            <i class="fas fa-chevron-left"></i> Prev
                        </span>
                    <?php endif; ?>

                    <!-- Page Numbers -->
                    <?php
                    $start_page = max(1, $page - 2);
                    $end_page = min($total_pages, $page + 2);
                    
                    if ($start_page > 1) {
                        echo '<a href="?page=1' . (!empty($search) ? '&search=' . urlencode($search) : '') . '" class="page-link">1</a>';
                        if ($start_page > 2) {
                            echo '<span class="page-link dots">...</span>';
                        }
                    }
                    
                    for ($i = $start_page; $i <= $end_page; $i++) {
                        $active = $i == $page ? 'active' : '';
                        echo '<a href="?page=' . $i . (!empty($search) ? '&search=' . urlencode($search) : '') . '" class="page-link ' . $active . '">' . $i . '</a>';
                    }
                    
                    if ($end_page < $total_pages) {
                        if ($end_page < $total_pages - 1) {
                            echo '<span class="page-link dots">...</span>';
                        }
                        echo '<a href="?page=' . $total_pages . (!empty($search) ? '&search=' . urlencode($search) : '') . '" class="page-link">' . $total_pages . '</a>';
                    }
                    ?>

                    <!-- Next -->
                    <?php if ($page < $total_pages): ?>
                        <a href="?page=<?php echo $page + 1; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>" class="page-link">
                            Next <i class="fas fa-chevron-right"></i>
                        </a>
                    <?php else: ?>
                        <span class="page-link disabled">
                            Next <i class="fas fa-chevron-right"></i>
                        </span>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Export Button -->
            <div class="table-actions">
                <a href="export.php" class="btn-export">
                    <i class="fas fa-file-export"></i> Export CSV
                </a>
            </div>
        </div>
    </div>
</body>
</html>