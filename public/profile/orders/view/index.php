<?php
include_once '../../../../init.php';
include_once DB_ROOT . 'database.php';

$order_id = $_GET["id"] ?? null;
$auth_user = get_auth_user();

if (empty($order_id)) redirect("");

$order = $connection->findOne("orders", ["id" => $order_id, "user_id" => $auth_user["id"]]);
if (!$order) redirect("");

$order_items = $connection->find("order_items", ["order_id" => $order_id]);


$status_classes = [
    "pending" => "bg-secondary",
    "processing" => "bg-info",
    "shipped" => "bg-warning text-dark",
    "completed" => "bg-success",
    "cancelled" => "bg-danger"
];

$status_badge = $status_classes[$order["status"]] ?? "bg-secondary";
$show_cancel_button = !in_array($order["status"], ["completed", "cancelled"]);



if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["cancel_order"])) {
        $connection->update("orders", $order["id"], ["status" => "cancelled"]);
        show_alert("Order cancelled");
        redirect("profile/orders/view?id=" . $order["id"]);
    }
}

?>

<?php include_once "../../../../includes/header.php"; ?>
<?php include_once "../../../../includes/nav.php"; ?>

<div class="container py-5">
    <h2 class="mb-4 section-title">Order Details</h2>

    <div class="card p-4 border">
        <h5 class="mb-3">Order #<?= $order["id"]; ?></h5>
        <p><strong>Placed on:</strong> <?= date("F j, Y", strtotime($order["created_at"])); ?></p>
        <p><strong>Total Amount:</strong> ₹<?= $order["total_amount"]; ?></p>
        <p><strong>Status:</strong> <span class="badge text-uppercase <?= $status_badge; ?>"><?= ucfirst($order["status"]); ?></span></p>

        <h5 class="mb-3">Items</h5>
        <div class="order-items">
            <?php foreach ($order_items as $item) :
                $product = $connection->findOne("products", ["id" => $item["product_id"]]);
            ?>
                <div class="d-flex border-bottom pb-2 mb-2">
                    <img src="<?= ASSETS_PATH . 'images/' . $product["image"] ?>" class="order-img me-3" alt="<?= $product["name"] ?? 'Product'; ?>" width="100">
                    <div>
                        <h6><?= $product["name"]; ?></h6>
                        <p class="text-muted mb-1">Qty: <?= $item["quantity"]; ?></p>
                        <p class="text-muted">₹<?= $item["subtotal"]; ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="mt-4 d-flex justify-content-between">
            <?php if ($show_cancel_button) : ?>
                <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#cancelOrderModal">Cancel Order</button>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Cancel Order Modal -->
<div class="modal fade" id="cancelOrderModal" tabindex="-1" aria-labelledby="cancelOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cancelOrderModalLabel">Cancel Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to cancel this order?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <form method="POST">
                    <input type="submit" class="btn btn-danger" id="confirmCancelOrder" name="cancel_order" value="Confirm Cancel" />
                </form>
            </div>
        </div>
    </div>
</div>

<?php include_once "../../../../includes/footer.php"; ?>