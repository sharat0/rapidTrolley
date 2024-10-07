<?php
include('./essentials/_config.php');

// Read the JSON file
$jsonData = file_get_contents('products.json');

// Decode JSON into PHP array
$products = json_decode($jsonData, true);

if ($products && isset($products['products'])) {
    // Insert each product into the database
    foreach ($products['products'] as $product) {
        // Safely handle missing keys by using a default value
        $name = isset($product['name']) ? $conn->real_escape_string($product['name']) : '';
        $description = isset($product['description']) ? $conn->real_escape_string($product['description']) : '';
        $price = isset($product['price']) ? $conn->real_escape_string($product['price']) : 0;
        $stock_quantity = isset($product['stock_quantity']) ? $conn->real_escape_string($product['stock_quantity']) : 0;
        $image_url = isset($product['image_url']) ? $conn->real_escape_string($product['image_url']) : '';
        $category = isset($product['category']) ? $conn->real_escape_string($product['category']) : '';
        $created_at = isset($product['created_at']) ? $conn->real_escape_string($product['created_at']) : date('Y-m-d');
        $category_id = isset($product['category_id']) ? $conn->real_escape_string($product['category_id']) : 0;

        // Insert query
        $query = "INSERT INTO products (name, description, price, stock_quantity, image_url, category, created_at, category_id) 
                  VALUES ('$name', '$description', $price, $stock_quantity, '$image_url', '$category', '$created_at', $category_id)";

        if ($conn->query($query) === TRUE) {
            echo "Product '$name' inserted successfully.<br>";
        } else {
            echo "Error: " . $query . "<br>" . $conn->error;
        }
    }
} else {
    echo "Error: Invalid JSON data.";
}
?>
