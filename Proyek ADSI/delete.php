<?php 
    include 'includes/connection.php'; 
?>

<?php
// Check if the 'id' parameter is set in the URL
if (isset($_GET['id'])) {
    $productId = $_GET['id'];

    // Delete the product from the database
    $sql = "DELETE FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$productId]);

    // Redirect back to the product list or a success page
    header('Location: admin.php');
    exit();
}
?>
