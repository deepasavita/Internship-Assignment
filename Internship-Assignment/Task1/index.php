<?php
require_once 'database.php';
require_once 'functions.php';

$category_filter = $_GET['category'] ?? null;
$products = getProducts($pdo, $category_filter);
$categories = getCategories($pdo);

// Compact Indian currency formatting
function formatINR($num) {
    $num = number_format((float)$num, 2, '.', '');
    $parts = explode('.', $num);
    $int = $parts[0];
    $dec = $parts[1];
    $last3 = substr($int, -3);
    $rest = substr($int, 0, -3);
    if ($rest != '') {
        $rest = preg_replace('/\B(?=(\d{2})+(?!\d))/', ',', $rest) . ',';
    }
    return '₹' . $rest . $last3 . '.' . $dec;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Product Catalog</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Product Catalog</h1>

    <!-- Filter Form -->
    <form method="GET" class="filter-form">
        <select name="category" onchange="this.form.submit()">
            <option value="">All Categories</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= htmlspecialchars($cat) ?>" <?= $category_filter == $cat ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cat) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>

    <!-- Products Grid -->
    <div class="products-grid">
        <?php if ($products): ?>
            <?php foreach ($products as $product): ?>
                <div class="product-card">
                    <h3><?= htmlspecialchars($product['name']) ?></h3>
                    <p class="price"><?= formatINR($product['price']) ?></p>
                    <p class="category">Category: <?= htmlspecialchars($product['category']) ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="no-products">No products found.</p>
        <?php endif; ?>
    </div>

    <a href="add_product.php" class="add-button">+ Add New Product</a>
</div>
</body>
</html>
