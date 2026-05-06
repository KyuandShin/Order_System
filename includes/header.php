<?php require_once __DIR__ . '/Auth.php';
Auth::protect();
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Order Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
<div class="sidebar">
    <div class="p-4">
        <h5 class="text-white mb-4 fw-bold">Order Management</h5>
    </div>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link <?php echo $current_page == 'index.php' ? 'active' : ''; ?>" href="index.php">
                Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo $current_page == 'customers.php' ? 'active' : ''; ?>" href="customers.php">
                Customers
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo $current_page == 'orders.php' ? 'active' : ''; ?>" href="orders.php">
                Orders
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo $current_page == 'reports.php' ? 'active' : ''; ?>" href="reports.php">
                Reports
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo $current_page == 'about.php' ? 'active' : ''; ?>" href="about.php">
                About Project
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo $current_page == 'developers.php' ? 'active' : ''; ?>" href="developers.php">
                Developers
            </a>
        </li>
    </ul>
    <div class="position-absolute bottom-0 w-100 p-4">
        <div class="d-flex align-items-center mb-3">
            <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center text-white me-3" style="width:40px;height:40px;">
                <?php echo strtoupper(substr(Auth::user()['name'], 0, 1)); ?>
            </div>
            <div>
                <div class="text-white small fw-bold"><?php echo Auth::user()['name']; ?></div>
                <div class="text-muted small"><?php echo Auth::user()['email']; ?></div>
            </div>
        </div>
        <a href="logout.php" class="btn btn-outline-light w-100 btn-sm">Logout</a>
    </div>
</div>

<div class="main-content">
    <div class="p-4">