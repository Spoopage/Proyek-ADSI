<?php
include './includes/connection.php';

$order_id = $_GET['order_id'];

$query = "SELECT * FROM transaksi WHERE order_id = :order_id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':order_id', $order_id);
$stmt->execute();
$order_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

$total = 0;

if (!empty($order_items)) {
    $customer_id = $order_items[0]['customer_id'];
    $customer_name = $order_items[0]['customer_name'];
}

function format($angka)
{
    return 'Rp ' . number_format($angka, 2, ',', '.');
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
                <?php foreach ($order_items as $item): 
                    $total += $item['quantity'] * $item['price'];
                ?>
                    <tr>
                        <td><img style="width: 150px; height: 150px" src="<?= $item['img_src'] ?>" alt=""></td>
                        <td><?= $item['product_name'] ?></td>
                        <td><?= $item['quantity'] ?></td>
                        <td><?= format($item['price']) ?></td>
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
