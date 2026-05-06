<?php require_once 'includes/header.php';
require_once 'includes/Database.php';
require_once 'includes/Order.php';

$database = new Database();
$db = $database->getConnection();
$order = new Order($db);
$orders = $order->readAllWithRelations();
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4">
    <h1 class="h2 fw-bold">Transaction Reports</h1>
    <button onclick="window.print()" class="btn btn-outline-secondary">Print Report</button>
</div>

<div class="alert alert-info">
    This report uses <strong>JOIN SQL queries</strong> to combine data from 3 tables: orders, customers, and users.
    Shows full relationship: Which staff member created each order for which customer.
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Order ID</th>
                        <th>Customer Name</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Amount</th>
                        <th>Processed By (Staff)</th>
                        <th>Status</th>
                        <th>Date Created</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $orders->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr>
                        <td>#<?php echo $row['id']; ?></td>
                        <td><?php echo $row['customer_name']; ?></td>
                        <td><?php echo $row['product_name']; ?></td>
                        <td><?php echo $row['quantity']; ?></td>
                        <td>$<?php echo number_format($row['amount'], 2); ?></td>
                        <td><strong><?php echo $row['created_by']; ?></strong></td>
                        <td>
                            <span class="badge status-<?php echo $row['status']; ?>">
                                <?php echo ucfirst($row['status']); ?>
                            </span>
                        </td>
                        <td><?php echo date('M d, Y H:i', strtotime($row['created_at'])); ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<?php require_once 'includes/footer.php'; ?>