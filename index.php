<?php require_once 'includes/header.php';
require_once 'includes/Database.php';
require_once 'includes/Order.php';
require_once 'includes/Customer.php';

$database = new Database();
$db = $database->getConnection();

$order = new Order($db);
$customer = new Customer($db);

$total_orders = $order->count();
$total_sales = $order->totalSales();
$customers_stmt = $customer->readAll();
$total_customers = $customers_stmt->rowCount();

$recent_orders = $order->readAllWithRelations();
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4">
    <h1 class="h2 fw-bold">Dashboard</h1>
</div>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="text-muted">Total Orders</h5>
                <h2 class="fw-bold"><?php echo $total_orders; ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="text-muted">Total Customers</h5>
                <h2 class="fw-bold"><?php echo $total_customers; ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="text-muted">Total Sales</h5>
                <h2 class="fw-bold">$<?php echo number_format($total_sales, 2); ?></h2>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header bg-white">
        <h5 class="mb-0">Recent Orders</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Customer</th>
                        <th>Product</th>
                        <th>Amount</th>
                        <th>Created By</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $recent_orders->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr>
                        <td>#<?php echo $row['id']; ?></td>
                        <td><?php echo $row['customer_name']; ?></td>
                        <td><?php echo $row['product_name']; ?></td>
                        <td>$<?php echo number_format($row['amount'], 2); ?></td>
                        <td><?php echo $row['created_by']; ?></td>
                        <td>
                            <span class="badge status-<?php echo $row['status']; ?>">
                                <?php echo ucfirst($row['status']); ?>
                            </span>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>