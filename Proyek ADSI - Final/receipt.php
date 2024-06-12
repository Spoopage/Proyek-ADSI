<?php
include './includes/connection.php';

$customer_id = null;
$customer_name = null;
$order_items = [];
$total = 0;
$sum = 0;

if (isset($_POST['complete_order'])) {
    $customer_id = $_SESSION['login_customer'];
    $pelanggan = get_pelanggan_by_id($customer_id);

    $id_transaksi = $_POST['id_transaksi'];

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
                <a class="navbar-brand ms-4"> <b> ABBA </b> </a>
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

    <div class="content-web my-5">
        <h1 class="mb-4">Receipt</h1>
            <p><strong>ID Pelanggan:</strong> <?=$pelanggan['id_pelanggan']?></p>
            <p><strong>Nama Pelanggan:</strong> <?= $pelanggan['nama_pelanggan'] ?></p>
                <!-- <h1>CART <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor"
                        class="bi bi-cart" viewBox="0 0 16 16">
                        <path
                            d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2" />
                    </svg>
                </h1> -->

                <?php
                $check_data = "SELECT * FROM cart";
                $check_data = $conn->prepare($check_data);
                $check_data->execute();

                if ($check_data->rowCount() == 0): ?>
                    <p>Tidak ada product yang ditambahkan.</p>
                <?php else: ?>
                    <br />
                    <table class="table">
                        <thead class="table-dark">
                            <th scope="col" width="250">Gambar</th>
                            <th scope="col" width="200">Nama Produk</th>
                            <th scope="col" width="200">Jumlah</th>
                            <th scope="col" width="200">Harga Produk</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            foreach ($pengiriman->tampil_cart()->fetchAll(PDO::FETCH_ASSOC) as $data): 
                            $sum += $data['jumlah']*$data['harga'];
                            ?>
                                <tr>
                                    <td> <img style="width: 150px; height: 150px" src="<?= $data['img_src'] ?>" alt=""></td>
                                    <td>
                                        <?= $data['nama_product'] ?>
                                    </td>
                                    <td>
                                        <?= $data['jumlah'] ?>
                                    </td>
                                    <td>
                                        <?= format($data['harga']) ?>
                                    </td>
                                    <!-- <td>
                                        <a style="padding-left: 18px; padding-right: 18px; font-size: 18px" href="cart.php?id= <?= $data['id'] ?>&jumlah=<?= $data['jumlah']+1 ?>" class="btn btn-primary btn-sm">+</a>
                                        <a style="padding-left: 24px; padding-right: 24px; font-size: 18px" href="cart.php?id= <?= $data['id'] ?>&jumlah=<?= $data['jumlah']-1 ?>" class="btn btn-danger btn-sm">-</a>
                                        <a style="padding-left: 18px; padding-right: 18px; font-size: 18px" href="cart.php?id= <?= $data['id'] ?>&delete=1" class="btn btn-danger btn-sm">Remove</a>
                                    </td> -->
                                </tr>
                            <?php endforeach?>
                            <h2>TOTAL: <?= format($sum) ?></h2>
                        </tbody>
                    </table>
                <?php endif ?>
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