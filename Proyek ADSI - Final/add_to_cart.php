<?php
include 'includes/connection.php';

$response = ['success' => false, 'message' => ''];

if (isset($_GET['id'])) {
    $productId = (int)$_GET['id'];

    $checkData = "SELECT * FROM cart WHERE product_id = " . $productId;
    $checkData = $conn->prepare($checkData);
    $checkData->execute();

    if ($checkData->rowCount() != 0) {
        $response['message'] = 'Data sudah ada di keranjang';
    } else {
        $productData = $pengiriman->get_products_index($productId)->fetch(PDO::FETCH_ASSOC);
        $insertData = $pengiriman->insert_cart([
            $productData['id'],
            $productData['nama_product'],
            $productData['harga'],
            $productData['img_src']
        ]);

        if ($insertData) {
            $response['success'] = true;
        } else {
            $response['message'] = 'Data tidak berhasil ditambahkan, Data sudah ada di dalam keranjang!';
        }
    }
} else {
    $response['message'] = 'Invalid request';
}

header('Content-Type: application/json');
echo json_encode($response);
?>
