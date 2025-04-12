<?php
include_once "../../init.php";
include DB_ROOT . 'database.php';

enable_protected_route();

$auth_user = get_auth_user();
$cart_items = $connection->find("cart", ["user_id" => $auth_user["id"]]);

$subtotal = 0;
$delivery_charge = 0;

foreach ($cart_items as $item) {
    $product = $connection->findOne("products", ["id" => $item["product_id"]]);
    if (!$product) continue;
    $total_price = $product["price"] * $item["quantity"];
    $subtotal += $total_price;
}

if ($subtotal < 500) $delivery_charge = 40;
$total = $subtotal + $delivery_charge;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $cart_id = parse_input($_POST["cart_id"]);
    $quantity = parse_input($_POST["quantity"]);

    if ($quantity == 0) {
        $connection->delete("cart", $cart_id);
    } else if ($quantity > 5) {
        show_alert("You can't add more than 5 items");
    } else {
        $connection->update("cart", $cart_id, ["quantity" => $quantity]);
    }
    redirect("cart");
}
?>

<?php include_once '../../includes/header.php' ?>
<?php include_once '../../includes/nav.php' ?>

<div class="container py-5">
    <h2 class="mb-4 section-title fw-bold">Your Shopping Cart</h2>

    <?php if (empty($cart_items)): ?>
        <div class="text-center py-5">
            <h3 class="text-muted">Your cart is empty.</h3>
            <a href="<?= ROOT ?>" class="btn btn-outline-primary mt-3">Continue Shopping</a>
        </div>
    <?php else: ?>

        <div class="row">
            <div class="col-md-8">
                <div class="cart-items">
                    <?php foreach ($cart_items as $item) :
                        $product = $connection->findOne("products", ["id" => $item["product_id"]]);
                        $total_price = $product["price"] * $item["quantity"];
                    ?>
                        <div class="card mb-3 shadow-sm border-0">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <img src="<?= ASSETS_PATH . 'images/' . $product['image'] ?>"
                                        class="cart-img me-3 rounded"
                                        alt="<?= $product["name"] ?>"
                                        width="80" height="80"
                                        style="object-fit: cover;">
                                    <div>
                                        <h6 class="fw-bold mb-1"><?= $product["name"] ?></h6>
                                        <p class="text-muted small mb-0">₹<?= $total_price; ?></p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <form method="POST" class="m-0">
                                        <input type="hidden" name="cart_id" value="<?= $item["id"] ?>">
                                        <input type="hidden" name="quantity" value="<?= $item["quantity"] - 1 ?>">
                                        <button class="btn btn-sm border quantity-btn d-flex align-items-center justify-content-center"
                                            style="width: 32px; height: 32px;">
                                            <i class="bi bi-dash-lg"></i>
                                        </button>
                                    </form>
                                    <input type="text" class="form-control form-control-sm text-center mx-2 my-0"
                                        value="<?= $item["quantity"] ?>" disabled
                                        style="width: 40px; height: 32px; padding: 0;">
                                    <form method="POST" class="m-0">
                                        <input type="hidden" name="cart_id" value="<?= $item["id"] ?>">
                                        <input type="hidden" name="quantity" value="<?= $item["quantity"] + 1 ?>">
                                        <button class="btn btn-sm border quantity-btn d-flex align-items-center justify-content-center"
                                            style="width: 32px; height: 32px;">
                                            <i class="bi bi-plus-lg"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

            </div>

            <div class="col-md-4">
                <div class="p-4 bg-light rounded shadow-sm sticky-top order-summary" style="top: 80px;">
                    <h5 class="fw-bold">Order Summary</h5>
                    <p class="d-flex justify-content-between">
                        <span>Subtotal:</span>
                        <strong>₹<?= $subtotal ?></strong>
                    </p>
                    <p class="d-flex justify-content-between">
                        <span>Shipping:</span>
                        <strong><?= $delivery_charge === 0 ? "Free" : "₹$delivery_charge" ?></strong>
                    </p>
                    <hr>
                    <p class="d-flex justify-content-between">
                        <span><strong>Total:</strong></span>
                        <strong>₹<?= $total ?></strong>
                    </p>
                    <a class="btn btn-primary w-100 " href="<?= ROOT . 'checkout' ?>">Proceed to Checkout</a>
                </div>
            </div>
        </div>

    <?php endif; ?>
</div>

<?php include_once '../../includes/footer.php' ?>