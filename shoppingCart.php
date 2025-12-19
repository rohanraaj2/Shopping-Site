<?php
session_start();

// Initialize cart if not exists
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$cart = $_SESSION['cart'];
$subtotal = 0;
$taxRate = 0.10; // 10% tax rate

// Calculate subtotal
foreach ($cart as $item) {
    $subtotal += $item['price'] * $item['quantity'];
}

$taxAmount = $subtotal * $taxRate;
$total = $subtotal + $taxAmount;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Shopping Cart</title>
    <link rel="stylesheet" type="text/css" href="mystyle.css">
    <style>
        .cart-container {
            max-width: 1000px;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .cart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #738174;
        }
        
        .cart-empty {
            text-align: center;
            padding: 50px;
            color: #666;
        }
        
        .cart-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        .cart-table th {
            background-color: #738174;
            color: white;
            padding: 12px;
            text-align: left;
        }
        
        .cart-table td {
            padding: 15px 12px;
            border-bottom: 1px solid #ddd;
        }
        
        .cart-item-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 5px;
        }
        
        .quantity-input {
            width: 60px;
            padding: 5px;
            text-align: center;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        
        .remove-btn {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 8px 15px;
            cursor: pointer;
            border-radius: 5px;
        }
        
        .remove-btn:hover {
            background-color: #c82333;
        }
        
        .cart-summary {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
            text-align: right;
        }
        
        .cart-summary-row {
            display: flex;
            justify-content: flex-end;
            padding: 8px 0;
            font-size: 16px;
        }
        
        .cart-summary-row strong {
            width: 150px;
            text-align: right;
        }
        
        .cart-summary-row span {
            width: 100px;
            text-align: right;
        }
        
        .cart-total {
            font-size: 20px;
            color: #738174;
            font-weight: bold;
            border-top: 2px solid #738174;
            padding-top: 10px;
            margin-top: 10px;
        }
        
        .cart-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        
        .checkout-btn {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 12px 30px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
        }
        
        .checkout-btn:hover {
            background-color: #218838;
        }
        
        .continue-shopping-btn {
            background-color: #738174;
            color: white;
            border: none;
            padding: 12px 30px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
        }
        
        .continue-shopping-btn:hover {
            background-color: #5a6a5d;
        }
    </style>
</head>
<body>
    <p align="right">
        <button id="toggleDarkMode">Dark Mode</button>
        <button id="returnHome">Home</button>
    </p>
    
    <div class="cart-container">
        <div class="cart-header">
            <h1>🛒 Shopping Cart</h1>
        </div>
        
        <?php if (empty($cart)): ?>
            <div class="cart-empty">
                <h2>Your cart is empty</h2>
                <p>Add some products to get started!</p>
                <button class="continue-shopping-btn" onclick="window.location.href='index.php'">Continue Shopping</button>
            </div>
        <?php else: ?>
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart as $productId => $item): ?>
                        <tr data-product-id="<?php echo htmlspecialchars($productId); ?>">
                            <td>
                                <?php if (!empty($item['image'])): ?>
                                    <img src="<?php echo htmlspecialchars($item['image']); ?>" 
                                         alt="<?php echo htmlspecialchars($item['productName']); ?>" 
                                         class="cart-item-image">
                                <?php else: ?>
                                    <img src="images/placeholder.jpg" 
                                         alt="No image" 
                                         class="cart-item-image">
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars($item['productName']); ?></td>
                            <td>$<?php echo number_format($item['price'], 2); ?></td>
                            <td>
                                <input type="number" 
                                       class="quantity-input" 
                                       value="<?php echo $item['quantity']; ?>" 
                                       min="1" 
                                       onchange="updateQuantity('<?php echo htmlspecialchars($productId); ?>', this.value)">
                            </td>
                            <td>$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                            <td>
                                <button class="remove-btn" 
                                        onclick="removeFromCart('<?php echo htmlspecialchars($productId); ?>')">
                                    Remove
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
            <div class="cart-summary">
                <div class="cart-summary-row">
                    <strong>Subtotal:</strong>
                    <span>$<?php echo number_format($subtotal, 2); ?></span>
                </div>
                <div class="cart-summary-row">
                    <strong>Tax (10%):</strong>
                    <span>$<?php echo number_format($taxAmount, 2); ?></span>
                </div>
                <div class="cart-summary-row cart-total">
                    <strong>Total:</strong>
                    <span>$<?php echo number_format($total, 2); ?></span>
                </div>
            </div>
            
            <div class="cart-actions">
                <button class="continue-shopping-btn" onclick="window.location.href='index.php'">
                    Continue Shopping
                </button>
                <button class="checkout-btn" onclick="proceedToCheckout()">
                    Proceed to Checkout
                </button>
            </div>
        <?php endif; ?>
    </div>
    
    <script src="script.js"></script>
    <script>
        function updateQuantity(productId, quantity) {
            fetch('cartHandler.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `action=update&productId=${encodeURIComponent(productId)}&quantity=${quantity}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload(); // Reload to update totals
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to update cart');
            });
        }
        
        function removeFromCart(productId) {
            if (confirm('Are you sure you want to remove this item?')) {
                fetch('cartHandler.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `action=remove&productId=${encodeURIComponent(productId)}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to remove item');
                });
            }
        }
        
        function proceedToCheckout() {
            // Check if user is logged in
            fetch('checkAuth.php')
                .then(response => response.json())
                .then(data => {
                    if (data.authenticated) {
                        window.location.href = 'checkout.php';
                    } else {
                        if (confirm('You must be logged in to checkout. Would you like to login now?')) {
                            window.location.href = 'login.php?redirect=shoppingCart.php';
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Fallback: just redirect to checkout and let it handle authentication
                    window.location.href = 'checkout.php';
                });
        }
    </script>
</body>
</html>
