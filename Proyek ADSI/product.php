<?php
$products = [
    1 => ["name" => "Product 1", "price" => 10.00],
    2 => ["name" => "Product 2", "price" => 20.00],
    3 => ["name" => "Product 3", "price" => 30.00],
];

if (isset($_GET['id']) && isset($products[$_GET['id']])) {
    $product = $products[$_GET['id']];
} else {
    die("Product not found.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $product["name"]; ?> - Simple Shop</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1><?php echo $product["name"]; ?></h1>
    <p>Price: $<?php echo number_format($product["price"], 2); ?></p>
    <form action="cart.php" method="post">
        <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
        <input type="submit" value="Add to Cart">
    </form>
    <a href="index.php">Back to products</a>
</body>
</html>
