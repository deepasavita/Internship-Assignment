<?php
require_once 'database.php';
require_once 'functions.php';

$error = '';
$success = '';

// Fetch categories for dropdown
$categories = getCategories($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $price = trim($_POST['price']);
    $category = trim($_POST['category']);

    // Validation
    if (empty($name) || empty($price) || empty($category)) {
        $error = 'All fields are required!';
    } elseif (!is_numeric($price) || $price <= 0) {
        $error = 'Price must be a valid number greater than 0!';
    } elseif (!in_array($category, $categories)) {
        $error = 'Invalid category selected!';
    } else {
        if (addProduct($pdo, $name, $price, $category)) {
            // Redirect to avoid resubmission (PRG pattern)
            header("Location: add_product.php?success=1");
            exit;
        } else {
            $error = 'Error adding product (maybe duplicate name?)';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Add New Product</h1>
        
        <?php if (isset($_GET['success'])): ?>
            <div class="alert success">✅ Product added successfully!</div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="alert error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" class="product-form">
            <div class="form-group">
                <label for="name">Product Name:</label>
                <input type="text" id="name" name="name" 
                       value="<?= isset($name) ? htmlspecialchars($name) : '' ?>" 
                       required>
            </div>
            
            <div class="form-group">
                <label for="price">Price (₹):</label>
                <input type="number" id="price" step="0.01" min="0.01" 
                       name="price" 
                       value="<?= isset($price) ? htmlspecialchars($price) : '' ?>" 
                       required>
            </div>
            
            <div class="form-group">
                <label for="category">Category:</label>
                <select id="category" name="category" required>
                    <option value="">-- Select Category --</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= htmlspecialchars($cat) ?>" 
                            <?= (isset($category) && $category === $cat) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cat) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <button type="submit">Add Product</button>
        </form>
        
        <a href="index.php" class="back-button">← Back to Catalog</a>
    </div>
</body>
</html>
