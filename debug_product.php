<?php
include 'includes/db.php';

// Check all products
$stmt = $conn->query("SELECT * FROM products");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "Total Products: " . count($products) . "\n";
echo "\n=== PRODUCT 1 ===\n";
if (!empty($products)) {
    echo json_encode($products[0], JSON_PRETTY_PRINT);
} else {
    echo "No products found.";
}
?>
