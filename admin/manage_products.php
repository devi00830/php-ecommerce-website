<?php
// File: /mnt/data/manage_products.php
// Manage Products - improved version with safe image handling and sanitized output

include '../includes/db.php';
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch products
try {
    $stmt = $conn->query("SELECT * FROM products");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    // handle DB error gracefully
    $products = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fa;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 90%;
            max-width: 1100px;
            margin: 40px auto;
            padding: 24px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 18px;
        }
        th, td {
            padding: 12px 10px;
            text-align: left;
            border: 1px solid #e6e9ee;
            vertical-align: middle;
        }
        th {
            background-color: #28a745;
            color: white;
            font-weight: 600;
        }
        tr:nth-child(even) {
            background-color: #fbfcfd;
        }
        tr:hover {
            background-color: #f1f6f9;
        }

        /* Thumbnail sizing in table */
        td img {
            width: 60px;
            height: 60px;
            object-fit: contain;
            border-radius: 4px;
            display: block;
        }

        .actions a {
            margin: 0 6px;
            padding: 6px 10px;
            color: #007bff;
            text-decoration: none;
            border: 1px solid #007bff;
            border-radius: 4px;
            transition: background-color 0.18s, color 0.18s;
            font-size: 0.95em;
        }
        .actions a:hover {
            background-color: #007bff;
            color: white;
        }
        .btn-back {
            display: inline-block;
            width: auto;
            margin: 22px 0 0 0;
            padding: 10px 18px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            text-align: center;
            text-decoration: none;
        }
        .btn-back:hover {
            background-color: #0056b3;
        }
        /* Responsive adjustments */
        @media (max-width: 720px) {
            .container { padding: 12px; width: 96%; }
            table, thead, tbody, th, td, tr { display: block; }
            thead { display: none; }
            tr { margin-bottom: 12px; border: 1px solid #eee; border-radius: 6px; padding: 8px; }
            td { border: none; padding: 6px 8px; }
            td img { margin: 6px 0; }
            .actions { margin-top: 8px; }
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Manage Products</h2>

    <table>
        <thead>
            <tr>
                <th style="width: 60px;">ID</th>
                <th>Name</th>
                <th style="width: 110px;">Price</th>
                <th>Description</th>
                <th style="width: 80px;">Image</th>
                <th style="width: 160px;">Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php if (empty($products)) : ?>
            <tr>
                <td colspan="6" style="text-align:center; color:#666;">No products found.</td>
            </tr>
        <?php else: ?>
            <?php foreach ($products as $product) : ?>
                <tr>
                    <td><?= (int)($product['id'] ?? 0); ?></td>
                    <td><?= htmlspecialchars($product['name'] ?? ''); ?></td>
                    <td>$<?= number_format((float)($product['price'] ?? 0), 2); ?></td>
                    <td><?= nl2br(htmlspecialchars($product['description'] ?? '')); ?></td>

                    <?php
                    // Safe image handling with placeholder fallback
                    // Default placeholder paths (relative to this file)
                    $placeholderWeb = '../images/placeholder.png';
                    $placeholderFs  = __DIR__ . '/../images/product.png';

                    $imageFile = trim((string)($product['image'] ?? ''));

                    $webImagePath = $placeholderWeb;
                    $fsImagePath  = $placeholderFs;

                    if ($imageFile !== '') {
                        // Prevent directory traversal: use basename
                        $imageFileSanitized = basename($imageFile);
                        $candidateFs = __DIR__ . '/../images/' . $imageFileSanitized;
                        $candidateWeb = '../images/' . $imageFileSanitized;

                        if (file_exists($candidateFs) && is_file($candidateFs)) {
                            $fsImagePath  = $candidateFs;
                            $webImagePath = $candidateWeb;
                        }
                    }
                    ?>
                    <td>
                        <img src="<?= htmlspecialchars($webImagePath); ?>"
                             alt="<?= htmlspecialchars($product['name'] ?: 'Product'); ?>">
                    </td>

                    <td class="actions">
                        <a href="edit_product.php?id=<?= (int)($product['id'] ?? 0); ?>">Edit</a>
                        <a href="delete_product.php?id=<?= (int)($product['id'] ?? 0); ?>"
                           onclick="return confirm('Are you sure you want to delete this product?');">
                           Delete
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>

    <a href="dashboard.php" class="btn-back">Back to Dashboard</a>
</div>

</body>
</html>
