<?php
session_start();

$username = $_SESSION["username"] ?? "guest";
$ordersFile = "orders.json";

if (!file_exists($ordersFile)) {
    $orders = [];
} else {
    $data = json_decode(file_get_contents($ordersFile), true);
    $orders = $data["orders"] ?? [];
}

// Filter only this user's orders
$userOrders = array_filter(
    $orders,
    fn($order) => $order["username"] === $username
);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Order History</title>
</head>
<body>

<h2>Your Order History</h2>

<?php if (empty($userOrders)): ?>
    <p>You have not placed any orders yet.</p>
<?php else: ?>
    <table border="1" cellpadding="8">
        <tr>
            <th>Order ID</th>
            <th>Date</th>
            <th>Subtotal</th>
            <th>Discount</th>
            <th>Total</th>
        </tr>

        <?php foreach ($userOrders as $order): ?>
            <tr>
                <td><?= htmlspecialchars($order["orderId"]) ?></td>
                <td><?= htmlspecialchars($order["createdAt"]) ?></td>
                <td>$<?= number_format($order["subtotal"], 2) ?></td>
                <td><?= $order["discountPercent"] ?>%</td>
                <td><strong>$<?= number_format($order["totalPrice"], 2) ?></strong></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

</body>
</html>
