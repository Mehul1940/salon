<?php
include_once "../../init.php";
include DB_ROOT . 'database.php';

enable_protected_route();

$auth_user = get_auth_user();
$address = $connection->findOne("addresses", ["user_id" => $auth_user["id"]]);
$cart_items = $connection->find("cart", ["user_id" => $auth_user["id"]]);

// Check if the user has an active membership
$membership = $connection->findOne("membership", [
    "user_id" => $auth_user["id"],
    "status" => "approved"
]);

$discount_percentage = 0;

// If membership is active, fetch the discount details
if ($membership) {
    $membership_plan = $connection->findOne("membership_plans", ["id" => $membership["plan_id"]]);
    if ($membership_plan) {
        $discount_percentage = $membership_plan["order_discount"]; // Discount percentage from the membership plan
    }
}

$subtotal = 0;
$discount_amount = 0;

foreach ($cart_items as $item) {
    $product = $connection->findOne("products", ["id" => $item["product_id"]]);
    if (!$product) continue;

    // Calculate the discounted price
    $original_price = $product["price"];
    $discounted_price = $original_price;

    if ($discount_percentage > 0) {
        $discounted_price = $original_price - ($original_price * ($discount_percentage / 100));
    }

    $subtotal += $discounted_price * $item["quantity"];
    $discount_amount += ($original_price - $discounted_price) * $item["quantity"];
}

$delivery_charge = $subtotal < 500 ? 40 : 0;
$total = $subtotal + $delivery_charge;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (empty($address)) {
        show_alert("Please enter your address first");
    }

    if (!empty($address)) {
        $order_data = [
            "user_id" => $auth_user["id"],
            "total_amount" => $total,
        ];

        $new_order_id = $connection->save("orders", $order_data);

        if ($new_order_id) {
            foreach ($cart_items as $item) {
                $product = $connection->findById("products", $item["product_id"]);

                // Apply discount when saving order items
                $original_price = $product["price"];
                $discounted_price = $original_price;

                if ($discount_percentage > 0) {
                    $discounted_price = $original_price - ($original_price * ($discount_percentage / 100));
                }

                $order_item_data = [
                    "order_id" => $new_order_id,
                    "product_id" => $item["product_id"],
                    "quantity" => $item["quantity"],
                    "price" => $discounted_price,
                    "subtotal" => $item["quantity"] * $discounted_price
                ];

                $connection->save("order_items", $order_item_data);
                $connection->delete("cart", $item["id"]);
            }

            $connection->save("payments", [
                "user_id" => $auth_user["id"],
                "order_id" => $new_order_id,
                "amount" => $total,
                "payment_method" => "cash"
            ]);

            redirect("profile/orders");
        }
    }
}
?>

<?php include_once '../../includes/header.php' ?>
<?php include_once '../../includes/nav.php' ?>

<div class="container py-5">
    <div class="row">
        <div class="col-md-8">
            <div class="p-4 rounded border">
                <h4>Billing Details</h4>
                <form method="POST" id="checkoutForm">
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" class="form-control" value="<?= $auth_user["name"] ?? "" ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="text" class="form-control" value="<?= $auth_user["phone"] ?? "" ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" class="form-control" value="<?= $auth_user["email"] ?? "" ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Shipping Address</label>
                        <?php if (empty($address)): ?>
                            <a href="<?= ROOT . 'profile/address' ?>" class="text-primary d-block">Add address</a>
                        <?php else: ?>
                            <p class="my-0 fw-bold"> <?= $address["address_line1"]; ?> </p>
                            <p class="my-0 text-muted"> <?= $address["city"] . ", " . $address["state"] . " - " . $address["pin_code"]; ?> </p>
                            <a href="<?= ROOT . 'profile/address' ?>" class="text-primary d-block">Change address</a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-4">
            <div class="p-4 bg-light rounded shadow-sm">
                <h4>Order Summary</h4>
                <p class="d-flex justify-content-between">
                    <span>Subtotal:</span>
                    <strong>₹<?= number_format($subtotal + $discount_amount, 2) ?></strong>
                </p>
                <?php if ($discount_percentage > 0): ?>
                    <p class="d-flex justify-content-between text-success">
                        <span>Membership Discount (<?= $discount_percentage ?>%):</span>
                        <strong>- ₹<?= number_format($discount_amount, 2) ?></strong>
                    </p>
                <?php endif; ?>
                <p class="d-flex justify-content-between">
                    <span>Shipping:</span>
                    <strong><?= $delivery_charge === 0 ? "Free" : "₹" . number_format($delivery_charge, 2) ?></strong>
                </p>
                <hr>
                <p class="d-flex justify-content-between">
                    <strong>Total:</strong>
                    <strong>₹<?= number_format($total, 2) ?></strong>
                </p>
                <h5 class="mt-4">Payment Method</h5>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="paymentMethod" id="cod" checked>
                    <label class="form-check-label" for="cod">Cash on Delivery</label>
                </div>
                <button class="btn btn-primary w-100 mt-4" id="submit">Place Order</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelector("#submit").addEventListener("click", () => {
        document.querySelector("#checkoutForm").submit();
    });
</script>

<?php include_once '../../includes/footer.php' ?>