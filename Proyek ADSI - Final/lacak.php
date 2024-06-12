<?php
    include './includes/connection.php';

    function format($harga)
    {
        $jum = "IDR " . number_format($harga, 2, ',', '.');
        return $jum;
    }
    
    if (isset($_POST['complete_order'])) {
        $customer_id = $_SESSION['login_customer'];
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
    <title>Order Location</title>

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

        .lacak_banner {
            background-image: url("./resources/pelacak.png");
            background-position: center; 
            background-size: contain;
            background-repeat: no-repeat;
            background-size: 55%; 
            height: 100vh;
            width: 100%;
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
    </style>
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
                                <a class="nav-link" aria-current="page" href="index.php">STORE</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="login.php">LOGIN ADMIN</a>
                            </li>
                        </ul>
                        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="order.php">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M9.354 1.646a.5.5 0 0 1 0 .708L4.707 7.5H14.5a.5.5 0 0 1 0 1H4.707l4.647 4.646a.5.5 0 0 1-.708.708l-5-5a.5.5 0 0 1 0-.708l5-5a.5.5 0 0 1 .708 0z"/>
                                    </svg> BACK
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        <div class="container">
            <div class="content-web my-5" style="text-align: center;">
                <h1>Lokasi Order Anda</h1>
                <div class="img_top"></div>
                <div class="lacak_banner" style="margin-top:0px"></div>
                <div class="lokasi_header">
                    <nav class="navbar navbar-expand-lg bg-transparent navbar-dark">
                        <div class="container justify-content-center" style="text-align: center;">
                            <a class="navbar-brand text-dark" style="text-align: center; font-family: myFont;"> <b><h1>Jl. Jemur Andayani</h1> </b> </a>
                        </div>
                    </nav>
                </div>
            </div>   
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