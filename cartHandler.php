<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

session_start();

// Initialize cart if not exists
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle AJAX requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    error_log('Cart action: ' . $action);
    error_log('POST data: ' . print_r($_POST, true));
    
    switch ($action) {
        case 'add':
            addToCart($_POST);
            break;
        case 'update':
            updateCart($_POST);
            break;
        case 'remove':
            removeFromCart($_POST);
            break;
        case 'getCount':
            echo json_encode(['count' => getCartCount()]);
            break;
        case 'clear':
            clearCart();
            break;
    }
}

function addToCart($data) {
    $productId = $data['productId'] ?? '';
    $productName = $data['productName'] ?? '';
    $price = floatval($data['price'] ?? 0);
    $quantity = intval($data['quantity'] ?? 1);
    $category = $data['category'] ?? '';
    $image = $data['image'] ?? '';
    
    if (empty($productId)) {
        echo json_encode(['success' => false, 'message' => 'Invalid product']);
        return;
    }
    
    // Check if product already exists in cart
    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId]['quantity'] += $quantity;
    } else {
        $_SESSION['cart'][$productId] = [
            'productId' => $productId,
            'productName' => $productName,
            'price' => $price,
            'quantity' => $quantity,
            'category' => $category,
            'image' => $image
        ];
    }
    
    echo json_encode([
        'success' => true, 
        'message' => 'Product added to cart',
        'count' => getCartCount()
    ]);
}

function updateCart($data) {
    $productId = $data['productId'] ?? '';
    $quantity = intval($data['quantity'] ?? 0);
    
    if (isset($_SESSION['cart'][$productId])) {
        if ($quantity > 0) {
            $_SESSION['cart'][$productId]['quantity'] = $quantity;
            echo json_encode([
                'success' => true, 
                'message' => 'Cart updated',
                'count' => getCartCount()
            ]);
        } else {
            removeFromCart($data);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Product not found in cart']);
    }
}

function removeFromCart($data) {
    $productId = $data['productId'] ?? '';
    
    if (isset($_SESSION['cart'][$productId])) {
        unset($_SESSION['cart'][$productId]);
        echo json_encode([
            'success' => true, 
            'message' => 'Product removed from cart',
            'count' => getCartCount()
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Product not found in cart']);
    }
}

function clearCart() {
    $_SESSION['cart'] = [];
    echo json_encode([
        'success' => true, 
        'message' => 'Cart cleared',
        'count' => 0
    ]);
}

function getCartCount() {
    $count = 0;
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            $count += $item['quantity'];
        }
    }
    return $count;
}
?>
