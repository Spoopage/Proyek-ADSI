<?php
include './includes/connection.php';

$customer_id = null;
$customer_name = null;
$order_items = [];
$total = 0;

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
    } 
    // else {
    //     // Handle the case when the customer is not found in the database
    //     echo "Customer not found in the database.";
    //     exit;
    // }
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
    <!-- CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>

    <div class="navbar-area">
        <nav class="navbar navbar-expand-lg navbar-dark sticky-top" style="background-color: #09111a;">
            <div class="container-fluid">
                <a class="navbar-brand ms-4"> <b> A.B.b.A </b> </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar"
                    aria-labelledby="offcanvasDarkNavbarLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">
                            Admin Panel
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                            aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <ul class="navbar-nav justify-content-start flex-grow-1 pe-3">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="index.php">STORE</a>
                            </li>
                            <!-- <li class="nav-item">
                                <a class="nav-link " aria-current="page" href="login.php">LOGIN ADMIN</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="login_customer.php">LOGIN CUSTOMER</a>
                            </li> -->
                        </ul>
                        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="cart.php">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg" width="30" height="20" fill="currentColor"
                                        class="bi bi-cart" viewBox="0 0 16 16">
                                        <path
                                            d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2" />
                                    </svg> VIEW CART
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </div>

    <div class="container mt-5">
        <h1 class="mb-4">Receipt</h1>
        <p><strong>ID Pelanggan:</strong> <?= htmlspecialchars($customer_id) ?></p>
        <p><strong>Nama Pelanggan:</strong> <?= htmlspecialchars($customer_name) ?></p>
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
                        <td><img style="width: 150px; height: 150px" src="<?= $item['./resources/placeholder.png'] ?>" alt=""></td>
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

    <!-- Pilih Cara Bayar -->
    <div class="container my-3">
        <form method="post" action="pilih_cara_bayar.php">
            <button type="submit" name="pilih_cara_bayar" class="btn btn-success">Pilih Cara Bayar</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybBogGzGQ9btx1x4cw8rmYd2IQzE+PsaE3yyzQda3n5L7MQFe" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-pZmtN9Da5RkOj07m+mXT2g2Q2bndXRfuErkR1Xr6ey7q5UqKnbEGzFbb5R5tEX7b" crossorigin="anonymous"></script>
</body>
</html>
