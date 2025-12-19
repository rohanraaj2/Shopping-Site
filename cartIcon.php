<?php
// Get cart count
$cartCount = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $cartCount += $item['quantity'];
    }
}
?>

<div class="cart-icon-container">
    <a href="shoppingCart.php" class="cart-link">
        <?php if ($cartCount > 0): ?>
            <span class="cart-icon-full">🛒</span>
            <span class="cart-badge"><?php echo $cartCount; ?></span>
        <?php else: ?>
            <span class="cart-icon-empty">🛒</span>
        <?php endif; ?>
    </a>
</div>
