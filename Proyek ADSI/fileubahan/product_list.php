<?php
include 'includes/connection.php';

if (isset($_GET['name'])) {
    $productName = $_GET['name'];

    $query = "SELECT * FROM products WHERE nama_product LIKE :productName";
    $statement = $conn->prepare($query);
    $statement->bindValue(':productName', '%' . $productName . '%', PDO::PARAM_STR);
    $statement->execute();

    $results = $statement->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($results);
} else {
    echo json_encode([]);
}
?>
