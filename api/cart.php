<?php
session_start();
date_default_timezone_set('Asia/Kolkata');
error_reporting(E_ALL);
ini_set('display_errors', 'On');

// Database credentials
$hostname = "localhost";
$database = "StoreCourier";
$username = "root";
$password = "root@123";

// Create connection using MySQLi
$conn = mysqli_connect($hostname, $username, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Set a default cart if it doesn't exist
if (!isset($_COOKIE['cart'])) {
    setcookie('cart', json_encode([]), time() + (86400 * 30), "/");
}

// Check if a POST request has been made
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $item = $_POST['item'] ?? '';

    // Retrieve the current cart from the cookie
    $cart = isset($_COOKIE['cart']) ? json_decode($_COOKIE['cart'], true) : [];

    if ($action === 'add') {
        // Add item to cart
        if (!in_array($item, $cart)) {
            $cart[] = $item; // Add item if it's not already in the cart
        }
    } elseif ($action === 'remove') {
        // Remove item from cart
        if (($key = array_search($item, $cart)) !== false) {
            unset($cart[$key]);
        }
    }

    // Update cart cookie
    setcookie('cart', json_encode(array_values($cart)), time() + (86400 * 30), "/");

    // Fetch product details for the current cart
    $productDetails = [];
    if (!empty($cart)) {
        // Prepare the SQL statement to fetch products
        $placeholders = implode(',', array_fill(0, count($cart), '?'));
        $stmt = $conn->prepare("SELECT * FROM products WHERE product_id IN ($placeholders)");

        // Bind the parameters
        $stmt->bind_param(str_repeat('i', count($cart)), ...$cart);

        // Execute the statement
        $stmt->execute();

        // Get the result
        $result = $stmt->get_result();
        $productDetails = $result->fetch_all(MYSQLI_ASSOC);
    }

    // Return the updated cart and product details as JSON
    echo json_encode(['cart' => $productDetails]);
    exit; // Exit after handling POST request
}

// If it's a GET request, retrieve the current cart
$cart = isset($_COOKIE['cart']) ? json_decode($_COOKIE['cart'], true) : [];
$productDetails = [];
if (!empty($cart)) {
    // Prepare the SQL statement to fetch products
    $placeholders = implode(',', array_fill(0, count($cart), '?'));
    $stmt = $conn->prepare("SELECT * FROM products WHERE product_id IN ($placeholders)");

    // Bind the parameters
    $stmt->bind_param(str_repeat('i', count($cart)), ...$cart);

    // Execute the statement
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();
    $productDetails = $result->fetch_all(MYSQLI_ASSOC);
}

echo json_encode(['cart' => $productDetails]);
