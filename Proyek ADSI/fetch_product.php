<?php
include 'includes/connection.php';

// Fetch product data
$productData = $pengiriman->tampil_products()->fetchAll(PDO::FETCH_ASSOC);

// Return JSON response
header('Content-Type: application/json');
echo json_encode($productData);
?>