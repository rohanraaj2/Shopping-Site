<?php
session_start();
require_once "discount.php";

// Check if user is authenticated
if (!isset($_SESSION["username"]) || empty($_SESSION["username"])) {
    // Redirect to login page with return URL
    header("Location: login.php?redirect=checkout.php");
    exit();
}

// Check if cart is empty
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header("Location: shoppingCart.php");
    exit();
}

$username = $_SESSION["username"];
$cart = $_SESSION['cart'];

// Calculate cart totals
$subtotal = 0;
foreach ($cart as $item) {
    $subtotal += $item['price'] * $item['quantity'];
}

$taxRate = 0.10; // 10% tax
$taxAmount = $subtotal * $taxRate;

$ordersFile = "orders.json";
$data = json_decode(file_get_contents($ordersFile), true);

// Count previous orders of this user
$userOrders = array_filter(
    $data["orders"],
    fn($order) => $order["username"] === $username
);

$orderCount = count($userOrders) + 1;

// Decide discount percent
if (!empty($_SESSION["lucky_discount"])) {
    $discountPercent = 20;
    unset($_SESSION["lucky_discount"]);
} else {
    $discountPercent = calculateDiscountPercent($orderCount);
}

// Calculate discount
$discountData = applyDiscount($subtotal, $discountPercent);
$subtotalAfterDiscount = $discountData["finalPrice"];
$total = $subtotalAfterDiscount + $taxAmount;

// Handle order placement
$orderPlaced = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_order'])) {
    // Create new order with cart items
    $newOrder = [
        "orderId" => "ORD" . str_pad($orderCount, 3, "0", STR_PAD_LEFT),
        "username" => $username,
        "items" => $cart,
        "subtotal" => $subtotal,
        "discountPercent" => $discountPercent,
        "discountAmount" => $discountData["discountAmount"],
        "taxAmount" => $taxAmount,
        "totalPrice" => $total,
        "createdAt" => date("Y-m-d H:i:s")
    ];
    
    // Save order
    $data["orders"][] = $newOrder;
    file_put_contents($ordersFile, json_encode($data, JSON_PRETTY_PRINT));
    
    // Clear cart
    $_SESSION['cart'] = [];
    $orderPlaced = true;
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
    <link rel="stylesheet" type="text/css" href="mystyle.css">
    <style>
        .checkout-container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .checkout-header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 2px solid #738174;
        }
        
        .order-items {
            margin: 20px 0;
        }
        
        .order-item {
            display: flex;
            justify-content: space-between;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        
        .order-summary {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
        }
        
        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            font-size: 16px;
        }
        
        .summary-total {
            font-size: 20px;
            font-weight: bold;
            color: #738174;
            border-top: 2px solid #738174;
            padding-top: 10px;
            margin-top: 10px;
        }
        
        .place-order-btn {
            width: 100%;
            background-color: #28a745;
            color: white;
            border: none;
            padding: 15px;
            font-size: 18px;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 20px;
        }
        
        .place-order-btn:hover {
            background-color: #218838;
        }
        
        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            margin: 20px 0;
        }
        
        .back-btn {
            background-color: #738174;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <p align="right">
        <button id="toggleDarkMode">Dark Mode</button>
        <button id="returnHome">Home</button>
    </p>
    <?php include 'cartIcon.php'; ?>
    
    <div class="checkout-container">
        <div class="checkout-header">
            <h1>Checkout</h1>
            <p>Review your order and complete purchase</p>
        </div>
        
        <?php if ($orderPlaced): ?>
            <div class="success-message">
                <h2>✓ Order Placed Successfully!</h2>
                <p>Thank you for your purchase, <?php echo htmlspecialchars($username); ?>!</p>
                <p>Your order has been confirmed and will be processed shortly.</p>
                <a href="index.php" class="back-btn">Continue Shopping</a>
                <a href="orderHistory.php" class="back-btn">View Order History</a>
            </div>
        <?php else: ?>
            <div class="order-items">
                <h3>Order Items:</h3>
                <?php foreach ($cart as $item): ?>
                    <div class="order-item">
                        <span><?php echo htmlspecialchars($item['productName']); ?> (x<?php echo $item['quantity']; ?>)</span>
                        <span>$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="order-summary">
                <h3>Order Summary:</h3>
                <div class="summary-row">
                    <strong>Subtotal:</strong>
                    <span>$<?php echo number_format($subtotal, 2); ?></span>
                </div>
                <?php if ($discountPercent > 0): ?>
                <div class="summary-row">
                    <strong>Discount (<?php echo $discountPercent; ?>%):</strong>
                    <span>-$<?php echo number_format($discountData["discountAmount"], 2); ?></span>
                </div>
                <div class="summary-row">
                    <strong>Subtotal after discount:</strong>
                    <span>$<?php echo number_format($subtotalAfterDiscount, 2); ?></span>
                </div>
                <?php endif; ?>
                <div class="summary-row">
                    <strong>Tax (10%):</strong>
                    <span>$<?php echo number_format($taxAmount, 2); ?></span>
                </div>
                <div class="summary-row summary-total">
                    <strong>Total:</strong>
                    <span>$<?php echo number_format($total, 2); ?></span>
                </div>
            </div>
            
            <form method="POST">
                <button type="submit" name="place_order" class="place-order-btn">
                    Place Order
                </button>
            </form>
            
            <div style="text-align: center; margin-top: 15px;">
                <a href="shoppingCart.php" class="back-btn">Back to Cart</a>
            </div>
        <?php endif; ?>
    </div>
    
    <script src="script.js"></script>
</body>
</html>
