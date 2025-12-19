<?php
session_start();

// Check if user is authenticated
$authenticated = isset($_SESSION['username']) && !empty($_SESSION['username']);

header('Content-Type: application/json');
echo json_encode(['authenticated' => $authenticated]);
?>
