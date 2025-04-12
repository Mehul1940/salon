

<?php

include_once '../../../init.php';
include_once DB_ROOT . 'database.php';

enable_protected_route();
$auth_user = get_auth_user();



$quantity = 1;
$product_id = parse_input($_GET["product_id"]);


$cart_item = $connection->findOne("cart", ["product_id" => $product_id, "user_id" => $auth_user["id"]]);

$new_item = [
    "product_id" => $product_id,
    "user_id" => $auth_user["id"],
    "quantity" => $quantity
];

if (empty($cart_item)) {
    $connection->save("cart", $new_item);
    redirect("cart", "Item added to cart");
} else {
    redirect("", "Item already in cart");
}
