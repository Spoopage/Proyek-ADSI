<?php
include './includes/connection.php';

if (isset($_POST['complete_order'])) {
    $id_transaksi = $_POST['id_transaksi'];
    $customer_name = $_POST['customer_name'];

    // Fetch the customer_id from the pelanggan table based on the customer_name
    $query = "SELECT id_pelanggan FROM pelanggan WHERE nama_pelanggan = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$customer_name]);

    if ($stmt->rowCount() > 0) {
        $customer_data = $stmt->fetch(PDO::FETCH_ASSOC);
        $customer_id = $customer_data['id_pelanggan'];

        // Fetch the order items from the cart table
        $query = "SELECT * FROM cart";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $order_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Calculate the total price
        $total = 0;
        foreach ($order_items as $item) {
            $total += $item['jumlah'] * $item['harga'];
        }

        // Insert the transaction details into the transaksi table
        if (isset($customer_id)) {
            $insert_query = "INSERT INTO transaksi (id, customer_id, customer_name, total, transaction_date) VALUES (?, ?, ?, ?, NOW())";
            $insert_stmt = $conn->prepare($insert_query);
            $insert_stmt->execute([$id_transaksi, $customer_id, $customer_name, $total]);

            // Clear the cart
            $clear_cart = "DELETE FROM cart";
            $clear_stmt = $conn->prepare($clear_cart);
            $clear_stmt->execute();
        } else {
            // Handle the case when the customer_id is not set
            echo "Error: Customer ID is not set correctly.";
            exit;
        }
    } else {
        // Handle the case when the customer is not found in the database
        echo "Customer not found in the database.";
        exit;
    }
}

function format($angka)
{
    return 'IDR ' . number_format($angka, 2, ',', '.');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Receipt</h1>
        <p><strong>Customer ID:</strong> <?= htmlspecialchars($customer_id) ?></p>
        <p><strong>Customer Name:</strong> <?= htmlspecialchars($customer_name) ?></p>
        <table class="table">
            <thead class="table-dark">
                <tr>
                    <th scope="col">Gambar</th>
                    <th scope="col">Nama Produk</th>
                    <th scope="col">Jumlah</th>
                    <th scope="col">Harga Produk</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($order_items as $item): ?>
                    <tr>
                        <td><img style="width: 150px; height: 150px" src="<?= $item['img_src'] ?>" alt=""></td>
                        <td><?= $item['nama_product'] ?></td>
                        <td><?= $item['jumlah'] ?></td>
                        <td><?= format($item['harga']) ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="3"><strong>Total</strong></td>
                    <td><strong><?= format($total) ?></strong></td>
                </tr>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybBogGzGQ9btx1x4cw8rmYd2IQzE+PsaE3yyzQda3n5L7MQFe" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-pZmtN9Da5RkOj07m+mXT2g2Q2bndXRfuErkR1Xr6ey7q5UqKnbEGzFbb5R5tEX7b" crossorigin="anonymous"></script>
</body>
</html>
