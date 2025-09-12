<?php
function getProducts($pdo, $category = null) {
    if ($category) {
        $sql = "SELECT * FROM products WHERE category = :category";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['category' => $category]);
    } else {
        $sql = "SELECT * FROM products";
        $stmt = $pdo->query($sql);
    }
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getCategories($pdo) {
    $sql = "SELECT DISTINCT category FROM products ORDER BY category";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

function addProduct($pdo, $name, $price, $category) {
    $sql = "INSERT INTO products (name, price, category) VALUES (:name, :price, :category)";
    $stmt = $pdo->prepare($sql);
    
    // Bind parameters
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':category', $category);
    
    return $stmt->execute();
}
?>
