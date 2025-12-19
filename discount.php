<?php

function calculateDiscountPercent(int $orderCount): int {
    if ($orderCount % 20 === 0) {
        return 20;
    }
    if ($orderCount % 10 === 0) {
        return 10;
    }
    return 0;
}

function applyDiscount(float $subtotal, int $discountPercent): array {
    $discountAmount = ($discountPercent / 100) * $subtotal;
    $finalPrice = $subtotal - $discountAmount;

    return [
        "discountAmount" => round($discountAmount, 2),
        "finalPrice" => round($finalPrice, 2)
    ];
}
