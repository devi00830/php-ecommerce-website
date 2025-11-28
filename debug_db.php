<?php
include 'includes/db.php';

// Check table structure
try {
    $stmt = $conn->query("DESC products");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "=== PRODUCTS TABLE SCHEMA ===\n";
    echo json_encode($columns, JSON_PRETTY_PRINT);
    echo "\n\n";
    
    // Get all products
    $stmt = $conn->query("SELECT * FROM products");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "=== ALL PRODUCTS ===\n";
    echo "Count: " . count($products) . "\n";
    echo json_encode($products, JSON_PRETTY_PRINT);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
