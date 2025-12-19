<?php
session_start();

// Generate a random number: 1–4
$random = rand(1, 5);

// 1 in 4 chance
if ($random === 1) {
    $_SESSION["lucky_discount"] = true;
    $_SESSION["lucky_message"] = "🎉 Lucky you! Your next order will get 20% OFF.";
} else {
    $_SESSION["lucky_discount"] = false;
    $_SESSION["lucky_message"] = "❌ No luck this time. Try again later!";
}

// Redirect back (change if needed)
header("Location: index.php");
exit;
