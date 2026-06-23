<?php
require_once 'config.php';

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin-login.php');
    exit();
}

// Pagination settings
$limit = 10;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// Search functionality
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

$search_condition = '';
if (!empty($search)) {
    $search_condition = "WHERE 
        full_name LIKE '%$search%' OR 
        mobile_number LIKE '%$search%' OR 
        email LIKE '%$search%' OR 
        city LIKE '%$search%'";
}

$count_sql = "SELECT COUNT(*) as total FROM registrations $search_condition";
$count_result = mysqli_query($conn, $count_sql);
$total_records = mysqli_fetch_assoc($count_result)['total'];
$total_pages = ceil($total_records / $limit);

$sql = "SELECT * FROM registrations $search_condition ORDER BY created_at DESC LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $sql);

if (empty($search)) {
    $total_result = mysqli_query($conn, "SELECT COUNT(*) as total FROM registrations");
    $total = mysqli_fetch_assoc($total_result)['total'];

    $pending_result = mysqli_query($conn, "SELECT COUNT(*) as pending FROM registrations WHERE status = 'pending'");
    $pending = mysqli_fetch_assoc($pending_result)['pending'];

    $approved_result = mysqli_query($conn, "SELECT COUNT(*) as approved FROM registrations WHERE status = 'approved'");
    $approved = mysqli_fetch_assoc($approved_result)['approved'];
} else {
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
        <!-- Top Navigation -->
        <nav class="admin-nav">
            <div class="nav-brand">
                <button class="menu-toggle" onclick="toggleSidebar()" aria-label="Toggle Menu">
                    <i class="fas fa-bars"></i>
                </button>
                <span>Volunteers of Vitthal</span>
            </div>
            <div class="nav-right">
                <span class="admin-email"><i class="fas fa-user-circle"></i> <?php echo $_SESSION['admin_email']; ?></span>
                <a href="logout.php" class="btn-logout"><i class="fas fa-sign-out-alt"></i> <span class="logout-text">Logout</span></a>
            </div>
        </nav>

        <!-- Mobile Overlay -->
        <div class="sidebar-overlay" onclick="toggleSidebar()"></div>

        <div class="admin-layout">
            <!-- Sidebar -->
            <aside class="admin-sidebar" id="adminSidebar">
                <div class="sidebar-header">
                    <div class="sidebar-brand">Panchi</div>
                </div>
                <nav class="sidebar-nav">
                    <a href="admin-dashboard.php" class="sidebar-link active">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="admin-dashboard.php" class="sidebar-link">
                        <i class="fas fa-users"></i>
                        <span>Registrations</span>
                        <span class="badge"><?php echo $total; ?></span>
                    </a>
                    <a href="#" class="sidebar-link" onclick="toggleFilter()">
                        <i class="fas fa-filter"></i>
                        <span>Filter</span>
                        <i class="fas fa-chevron-down filter-arrow"></i>
                    </a>
                    <div class="sub-menu" id="filterMenu">
                        <a href="admin-dashboard.php?status=pending" class="sub-link">
                            <span class="dot pending-dot"></span> Pending
                        </a>
                        <a href="admin-dashboard.php?status=approved" class="sub-link">
                            <span class="dot approved-dot"></span> Approved
                        </a>
                        <a href="admin-dashboard.php?status=rejected" class="sub-link">
                            <span class="dot rejected-dot"></span> Rejected
                        </a>
                        <a href="admin-dashboard.php" class="sub-link">
                            <i class="fas fa-undo"></i> Reset
                        </a>
                    </div>
                    <a href="export.php" class="sidebar-link">
                        <i class="fas fa-file-export"></i>
                        <span>Export CSV</span>
                    </a>
                    <a href="logout.php" class="sidebar-link logout-link">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                </nav>
                <div class="sidebar-footer">
                    <small>Panchi v1.0</small>
                </div>
            </aside>

            <!-- Main Content -->
            <main class="admin-main">
                <!-- Stats Cards -->
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

                <!-- Table Section -->
                <div class="table-container">
                    <!-- Table Header -->
                    <div class="table-header">
                        <h2><i class="fas fa-list"></i> All Registrations</h2>
                        
                        <!-- Search Form -->
                        <form method="GET" action="" class="search-form">
                            <div class="search-wrapper">
                                <i class="fas fa-search search-icon"></i>
                                <input type="text" name="search" placeholder="Search by name, email, mobile..." value="<?php echo htmlspecialchars($search); ?>">
                                <button type="submit" class="btn-search">
                                    <i class="fas fa-search"></i> Search
                                </button>
                                <?php if (!empty($search)): ?>
                                    <a href="admin-dashboard.php" class="btn-clear">
                                        <i class="fas fa-times"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </form>
                    </div>

                    <!-- Responsive Table -->
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>#</th>
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
                                        <td data-label="#"><?php echo $serial++; ?></td>
                                        <td data-label="Name"><?php echo htmlspecialchars($row['full_name']); ?></td>
                                        <td data-label="Mobile"><?php echo $row['mobile_number']; ?></td>
                                        <td data-label="Email"><?php echo htmlspecialchars($row['email']); ?></td>
                                        <td data-label="City"><?php echo htmlspecialchars($row['city']); ?></td>
                                        <td data-label="Participants"><?php echo $row['participants']; ?></td>
                                        <td data-label="Status">
                                            <span class="status-badge status-<?php echo $row['status']; ?>">
                                                <?php echo ucfirst($row['status']); ?>
                                            </span>
                                        </td>
                                        <td data-label="Screenshot">
                                            <a href="<?php echo $row['payment_screenshot']; ?>" target="_blank" class="btn-view">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                        <td data-label="Actions">
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
                            <?php if ($page > 1): ?>
                                <a href="?page=<?php echo $page - 1; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>" class="page-link">
                                    <i class="fas fa-chevron-left"></i> Prev
                                </a>
                            <?php else: ?>
                                <span class="page-link disabled">
                                    <i class="fas fa-chevron-left"></i> Prev
                                </span>
                            <?php endif; ?>

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

                    <!-- Table Actions -->
                    <div class="table-actions">
                        <a href="export.php" class="btn-export">
                            <i class="fas fa-file-export"></i> Export CSV
                        </a>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        // ===== TOGGLE SIDEBAR =====
        function toggleSidebar() {
            const sidebar = document.getElementById('adminSidebar');
            const overlay = document.querySelector('.sidebar-overlay');
            sidebar.classList.toggle('open');
            overlay.classList.toggle('open');
            document.body.classList.toggle('sidebar-open');
        }

        // ===== TOGGLE FILTER SUB-MENU =====
        function toggleFilter() {
            const menu = document.getElementById('filterMenu');
            const arrow = document.querySelector('.filter-arrow');
            menu.classList.toggle('open');
            arrow.classList.toggle('rotate');
        }

        // ===== CLOSE SIDEBAR ON ESCAPE =====
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const sidebar = document.getElementById('adminSidebar');
                if (sidebar.classList.contains('open')) {
                    toggleSidebar();
                }
            }
        });

        // ===== CLOSE SIDEBAR ON RESIZE (Desktop) =====
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                const sidebar = document.getElementById('adminSidebar');
                const overlay = document.querySelector('.sidebar-overlay');
                sidebar.classList.remove('open');
                overlay.classList.remove('open');
                document.body.classList.remove('sidebar-open');
            }
        });

        // ===== COLLAPSIBLE TABLE ROWS ON MOBILE =====
        document.querySelectorAll('.table-responsive tbody tr').forEach(row => {
            row.addEventListener('click', function(e) {
                // Don't trigger if clicking on action buttons or links
                if (e.target.closest('.action-buttons') || e.target.closest('a') || e.target.closest('.btn-view')) {
                    return;
                }
                if (window.innerWidth <= 600) {
                    this.classList.toggle('expanded');
                }
            });
        });
    </script>
</body>
</html>