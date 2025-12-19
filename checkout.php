<?php
session_start();
require_once "discount.php";

$username = $_SESSION["username"] ?? "guest";

$ordersFile = "orders.json";
$data = json_decode(file_get_contents($ordersFile), true);

// Count previous orders of this user
$userOrders = array_filter(
    $data["orders"],
    fn($order) => $order["username"] === $username
);


$orderCount = count($userOrders) + 1;

// TEMP subtotal (until cart is integrated)
$subtotal = 120;

// Decide discount percent FIRST
if (!empty($_SESSION["lucky_discount"])) {
    $discountPercent = 20;               // force 20%
    unset($_SESSION["lucky_discount"]);  // one-time use
} else {
    $discountPercent = calculateDiscountPercent($orderCount);
}

// NOW calculate discount amounts
$discountData = applyDiscount($subtotal, $discountPercent);


// Create new order
$newOrder = [
    "orderId" => "ORD" . str_pad($orderCount, 3, "0", STR_PAD_LEFT),
    "username" => $username,
    "subtotal" => $subtotal,
    "discountPercent" => $discountPercent,
    "discountAmount" => $discountData["discountAmount"],
    "totalPrice" => $discountData["finalPrice"],
    "createdAt" => date("Y-m-d")
];

// Save order
$data["orders"][] = $newOrder;
file_put_contents($ordersFile, json_encode($data, JSON_PRETTY_PRINT));


?>
<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
</head>
<body>

<h2>Order Summary</h2>

<p>Subtotal: $<?= number_format($subtotal, 2) ?></p>
<p>Discount: <?= $discountPercent ?>%</p>
<p><strong>Total: $<?= number_format($discountData["finalPrice"], 2) ?></strong></p>

</body>
</html>
