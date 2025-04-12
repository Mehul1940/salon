<?php
include_once '../../../../init.php';
include DB_ROOT . 'database.php';
enable_admin_route();

$order_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!$order_id) redirect("");

$order = $connection->findById("orders", $order_id);
if (!$order) redirect("");

$customer = $connection->findById("users", $order["user_id"]);
$order_items = $connection->find("order_items", ["order_id" => $order["id"]]);



$status_classes = [
    "pending" => "bg-secondary",
    "processing" => "bg-info",
    "shipped" => "bg-primary",
    "completed" => "bg-success",
    "cancelled" => "bg-danger"
];

$status_options = ["pending", "processing", "completed", "cancelled"];
$status_badge = $status_classes[$order["status"]] ?? "bg-secondary";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $new_status = parse_input($_POST["status"]) ?? $order["status"];
    var_dump($new_status);
    $connection->update("orders", $order_id, ["status" => $new_status],);
    $payment = $connection->findOne("payments", ["order_id" => $order_id]);
    $connection->update("payments", $payment["id"], ["status" => "completed"]);
    redirect("admin/orders/view?id=" . $order_id);
}

$address = $connection->findOne("addresses", ["user_id" => $order["user_id"]])

?>

<?php include_once '../../../../includes/header.php'; ?>

<div class="d-flex">
    <?php
    $active = "orders";
    include_once '../../../../includes/admin-sidebar.php';
    ?>

    <div class="container-fluid px-4 py-4">
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="section-title"><i class="bi bi-receipt-cutoff"></i> Order Details</h2>
            <a href="<?= ROOT . 'admin/orders' ?>" class="btn btn-outline-primary">
                <i class="bi bi-arrow-left"></i> Back to Orders
            </a>
        </div>

        <div class="row">
            <!-- Order Information -->
            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white">
                        <h5 class="my-0 py-2">Order Information</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Order ID:</strong> #<?= $order['id']; ?></p>
                        <p><strong>Customer Name:</strong> <?= $customer ? $customer['name'] : 'N/A'; ?></p>
                        <p><strong>Order Date:</strong> <?= date('d M Y, h:i A', strtotime($order['created_at'])); ?></p>
                        <p><strong>Total Amount:</strong> <span class="text-success fw-bold">₹<?= number_format($order['total_amount'], 2); ?></span></p>
                        <p><strong>Status:</strong>
                            <span class="badge text-uppercase <?= $status_badge; ?> px-3 py-2"><?= ucfirst($order['status']); ?></span>
                        </p>

                        <strong>Address:</strong>
                        <p class="mb-1"><?= $address["address_line1"]; ?></p>
                        <p class="mb-3"><?= $address["city"] . ", " . $address["state"] . " - " . $address["pin_code"]; ?></p>

                        <!-- Status Update Form -->
                        <form method="POST" class="mt-3">
                            <label for="status" class="form-label">Change Status:</label>
                            <div class="input-group">
                                <select name="status" id="status" class="form-select">
                                    <?php foreach ($status_options as $status): ?>
                                        <option value="<?= $status; ?>" <?= $order["status"] === $status ? "selected" : ""; ?>>
                                            <?= ucfirst($status); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle"></i> Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="my-0 text-white py-2">Order Items</h5>
                    </div>
                    <div class="card-body">
                        <?php if (count($order_items) > 0): ?>
                            <table class="table table-striped">
                                <thead class="table-light">
                                    <tr>
                                        <th>Product</th>
                                        <th>Image</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($order_items as $item):
                                        $product = $connection->findById("products", $item["product_id"]);
                                    ?>
                                        <tr>
                                            <td><?= $product ? $product['name'] : 'N/A'; ?></td>
                                            <td><img src="<?= ASSETS_PATH . 'images/' . $product['image'] ?>" alt="Product Image" class="img-thumbnail" width="80"></td>
                                            <td><?= $item['quantity']; ?></td>
                                            <td>₹<?= number_format($item['price'], 2); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <p class="text-muted">No items found in this order.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Print Receipt -->
        <div class="mt-4 text-center">
            <button id="print-btn" class="fw-semibold btn btn-outline-dark">
                <i class="bi bi-printer"></i> Print Receipt
            </button>
        </div>

        <!-- Hidden Receipt Content -->
        <div id="receipt-content" class="d-none">
            <div class="container border rounded p-4 shadow-sm bg-white">
                <h2 class="text-center text-primary fw-bold">Order Receipt</h2>
                <hr>
                <div class="row mb-3">
                    <div class="col-6">
                        <p><strong>Order ID:</strong> #<?= $order['id']; ?></p>
                        <p><strong>Customer:</strong> <?= $customer ? $customer['name'] : 'N/A'; ?></p>
                        <p><strong>Order Date:</strong> <?= date('d M Y, h:i A', strtotime($order['created_at'])); ?></p>
                    </div>
                    <div class="col-6 text-end">
                        <p><strong>Total Amount:</strong> <span class="text-success">₹<?= number_format($order['total_amount'], 2); ?></span></p>
                        <p><strong>Status:</strong> <span class="text-uppercase badge <?= $status_badge; ?>"><?= ucfirst($order['status']); ?></span></p>
                    </div>
                </div>

                <hr>
                <h5 class="text-secondary">Items Ordered</h5>
                <table class="table table-bordered mt-2">
                    <thead class="table-light">
                        <tr>
                            <th>Product</th>
                            <th>Image</th>
                            <th>Quantity</th>
                            <th>Price (₹)</th>
                            <th>Subtotal (₹)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($order_items as $item):
                            $product = $connection->findById("products", $item["product_id"]);
                            $subtotal = $item['quantity'] * $item['price'];
                        ?>
                            <tr>
                                <td><?= $product ? $product['name'] : 'N/A'; ?></td>
                                <td><img src="<?= ASSETS_PATH . 'images/' . $product['image'] ?>" alt="Product Image" class="img-thumbnail" width="80"></td>
                                <td class="text-center"><?= $item['quantity']; ?></td>
                                <td class="text-end"><?= number_format($item['price'], 2); ?></td>
                                <td class="text-end"><?= number_format($subtotal, 2); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <div class="text-end mt-3">
                    <h5 class="fw-bold">Total: ₹<?= number_format($order['total_amount'], 2); ?></h5>
                </div>

                <hr>
                <p class="text-center text-muted small">Thank you for shopping with us!</p>
            </div>
        </div>

    </div>
</div>

<!-- Print Script -->
<script>
    document.getElementById("print-btn").addEventListener("click", function() {
        var printWindow = window.open('', '_blank');
        var content = document.getElementById("receipt-content").innerHTML;
        printWindow.document.write('<html><head><title>Order Receipt</title>');
        printWindow.document.write('<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">');
        printWindow.document.write('</head><body class="container mt-4">');
        printWindow.document.write(content);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
    });
</script>

<?php include_once '../../../../includes/admin_footer.php'; ?>