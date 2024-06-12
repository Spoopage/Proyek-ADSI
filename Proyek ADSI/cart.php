<?php

// if (isset($_POST['complete_order'])) {
//     // Get cart items
//     $query = "SELECT * FROM cart";
//     $stmt = $conn->prepare($query);
//     $stmt->execute();
//     $cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // // Insert cart items into transaksi table
    // foreach ($cart_items as $item) {
    //     $id_transaksi = uniqid(); // Create a unique order ID
    //     $product_name = $item['nama_product'];
    //     $quantity = $item['jumlah'];
    //     $price = $item['harga'];
    //     $img_src = $item['img_src'];

    //     $insert_order = "INSERT INTO transaksi (id_transaksi, product_name, quantity, price, img_src) VALUES (:id_transaksi, :product_name, :quantity, :price, :img_src)";
    //     $stmt = $conn->prepare($insert_order);
    //     $stmt->bindParam(':order_id', $id_transaksi);
    //     $stmt->bindParam(':product_name', $product_name);
    //     $stmt->bindParam(':quantity', $quantity);
    //     $stmt->bindParam(':price', $price);
    //     $stmt->bindParam(':img_src', $img_src);
    //     $stmt->execute();
    // }

    include './includes/connection.php';

    $sum = 0;
    if (isset($_GET['id'])) {
        foreach ($pengiriman->get_cart_index((int) $_GET['id'])->fetchAll(PDO::FETCH_ASSOC) as $data) {
            if (isset($_GET['delete'])) {
                $insert_data = $pengiriman->delete_cart($_GET['id']);
            }
            else if ((int)$_GET['jumlah'] >= 1) {
                $insert_data = $pengiriman->update_jumlah_cart([
                    $_GET['jumlah'],
                    $_GET['id']
                ]);
            } else if ((int)$_GET['jumlah'] <= 0){
                $insert_data = false;
            } 
            if ($insert_data)
                header('location: cart.php?msg=berhasil_ditambahkan');
            else
                $msg = 'Data tidak berhasil diupdate, gunakan tombol delete untuk menghapus!';
        }
    }
    
    function format($harga) {
        $jum = "IDR " . number_format($harga,2,',','.');
        return $jum;
    }
    
    if (isset($_POST['complete_order'])) {
        // Get the customer_id from the session or any other source
        $customer_id = $_SESSION['login_customer'];
    
        // Fetch the customer_name from the pelanggan table
        // $query = "SELECT nama_pelanggan FROM pelanggan WHERE id_pelanggan = ?";
        // $stmt = $conn->prepare($query);
        // $stmt->execute([$customer_id]);
        // $customer_data = $stmt->fetch(PDO::FETCH_ASSOC);
        // $customer_name = $customer_data['nama_pelanggan'];
    
        $query = "SELECT nama_pelanggan FROM pelanggan WHERE id_pelanggan = ?";
        $stmt = mysqli_prepare($customer_id, $query); // Prepare the statement
        mysqli_stmt_bind_param($stmt, "i", $customer_id); // Bind parameters
        mysqli_stmt_execute($stmt); // Execute the statement
        mysqli_stmt_bind_result($stmt, $customer_name); // Bind result
        mysqli_stmt_fetch($stmt); // Fetch the result
        mysqli_stmt_close($stmt); // Close the statement
        
        // Generate a unique transaction ID
        $id_transaksi = uniqid();
    
        // Calculate the total price
        $total = 0;
        foreach ($pengiriman->tampil_cart()->fetchAll(PDO::FETCH_ASSOC) as $item) {
            $total += $item['jumlah'] * $item['harga'];
        }
    
        // Insert the transaction details into the transaksi table
        $pengiriman->insert_transaksi([$id_transaksi, $customer_id, $customer_name, $total, date('Y-m-d H:i:s')]);
    
        // Clear the cart
        $clear_cart = "DELETE FROM cart";
        $clear_stmt = $conn->prepare($clear_cart);
        $clear_stmt->execute();
    
        // Redirect to the receipt page with the necessary data
        header("Location: receipt.php?id_transaksi=$id_transaksi&customer_id=$customer_id&customer_name=$customer_name&total=$total");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>

    <!-- CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- Styling -->
    <style>
        .content-web {
            border: 1px solid #ccc;
            padding: 15px;
            border-radius: 5px;
        }

        .table-dark tbody {
            background-color: #fff;
        }

        .navbar_area {
            font-family: Helvetica;
        }

        hr {
            color: #fff;
        }

        /* #selesai_pesanan {
            position: absolute;
            right: 0px;
            width: 300px;
            border: 3px solid #73AD21;
            padding: 10px;
        } */

        /* footer {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            background-color: #09111a;
            color: #fff;
            padding: 10px 0;
            text-align: left;
        } */

    </style>
</head>

<body>
    <div class="navbar-area">
        <nav class="navbar navbar-expand-lg navbar-dark sticky-top" style="background-color: #09111a;">
            <div class="container-fluid">
                <a class="navbar-brand ms-4"> <b> E-COM </b> </a>
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
                                <a class="nav-link" aria-current="page" href="index.php">STORE</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="login.php">LOGIN ADMIN</a>
                            </li>
                        </ul>
                        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="cart.php">
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
        <div class="container">
            <div class="content-web my-5">
                <h1>CART <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor"
                        class="bi bi-cart" viewBox="0 0 16 16">
                        <path
                            d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2" />
                    </svg>
                </h1>

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
                            <th scope="col" width="200">Action</th>
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
                                    <td>
                                        <a style="padding-left: 18px; padding-right: 18px; font-size: 18px" href="cart.php?id= <?= $data['id'] ?>&jumlah=<?= $data['jumlah']+1 ?>" class="btn btn-primary btn-sm">+</a>
                                        <a style="padding-left: 24px; padding-right: 24px; font-size: 18px" href="cart.php?id= <?= $data['id'] ?>&jumlah=<?= $data['jumlah']-1 ?>" class="btn btn-danger btn-sm">-</a>
                                        <a style="padding-left: 18px; padding-right: 18px; font-size: 18px" href="cart.php?id= <?= $data['id'] ?>&delete=1" class="btn btn-danger btn-sm">Remove</a>
                                    </td>
                                </tr>
                            <?php endforeach?>
                            <h2>TOTAL: <?= format($sum) ?></h2>
                        </tbody>
                    </table>
                <?php endif ?>
            </div>

            
        </div>

        <!-- Selesaikan Pesanan -->
        <div class="container my-3">
            <form method="post" action="receipt.php">
                <input type="hidden" name="id_transaksi" value="<?= $id_transaksi ?>">
                <input type="hidden" name="customer_id" value="<?= $customer_id ?>">
                <input type="hidden" name="customer_name" value="<?= $customer_name ?>">
                <button type="submit" name="complete_order" class="btn btn-success">Selesaikan Pesanan</button>
            </form>
        </div>
    

        <footer class="py-2 mt-5" style="background-color: #09111a;">
        <div class="container text-left text-light">
            <p class="display-7 mt-1 mb-1" style="font-family: myFont;">Antar Barang by Adrian</p>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
                <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741M1 11.105l4.708-2.897L1 5.383z"/>
            </svg>
            <small class="text-50 mb-1">antarbarangbyadrian@gmail.com</small>
        </div>

        <div class="container text-left text-light">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone" viewBox="0 0 16 16">
                <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/>
            </svg>
            <small class="text-50">08123456789</small>
        </div>
        <div class="container text-left text-light mb-2">
            <hr class="hr-light" />
            <small class="text-white-50">&copy; 2023 Antar Barang by Adrian. All rights reserved.</small>
        </div>
    </footer>

    <!-- Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>

</html>
