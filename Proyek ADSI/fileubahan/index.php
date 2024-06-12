<?php
include 'includes/connection.php';

if (isset($_GET['id'])) {
    foreach ($pengiriman->get_products_index((int) $_GET['id'])->fetchAll(PDO::FETCH_ASSOC) as $data) {
        $productID = $data['id'];

        $check_data = $conn->prepare("SELECT * FROM cart WHERE product_id = :productID");
        $check_data->bindParam(':productID', $productID);
        $check_data->execute();
        
        if ($check_data->rowCount() > 0) {
            $msg = "Data sudah ada di keranjang";
        } else {
            $insert_data = $pengiriman->insert_cart([
                $data['id'],
                $data['nama_product'],
                $data['harga'],
                $data['img_src']
            ]);
        
            if ($insert_data) {
                header('location: index.php?msg=berhasil_ditambahkan');
                exit; 
            } else {
                $msg = 'Data tidak berhasil ditambahkan, terjadi kesalahan.';
            }
        }
        
        if (empty($msg)) {
            $msg = 'Data tidak berhasil ditambahkan, Data sudah ada di dalam keranjang!';
        }
    }
}
function format($harga) {
    $jum = "IDR " . number_format($harga, 2, ',', '.');
    return $jum;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Antar Barang by Adrian</title>

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

        .img_top {
            /* background-image: url("https://media.photographycourse.net/wp-content/uploads/2014/11/08164934/Landscape-Photography-steps.jpg"); */
            height: 50%;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        .store_header{
            margin-top: 5%;
            margin-bottom: 1%;
            padding: 0%;
            font-family: Helvetica;
            text-align: center;
        }

        .navbar_area {
            font-family: Helvetica;
        }

        .store_banner {
            background-image: url("./resources/stock-photo-view-of-landscape-from-kloppenheim-country-estate-machadodorp-province-of-mpumalanga-south-2468214593.jpg");
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
            height: 400px;
            width: 100%;
        }

        .navbar_custom {
            background-color: black;
        }

        hr {
            color: #fff;
        }

        svg {
            color: #fff;
            
        }

        @font-face {
            font-family: myFont;
            src: url(img/coolvetica\ rg.otf);
        }
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
                                <a class="nav-link" aria-current="page" href="cart.php">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg" width="30" height="20" fill="currentColor"
                                        class="bi bi-cart" viewBox="0 0 16 16">
                                        <path
                                            d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2" />
                                    </svg> VIEW CART
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="order.php">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="20" fill="currentColor"
                                        class="bi bi-list" viewBox="0 0 16 16">
                                        <path d="M3 4h10v1H3V4zm0 3h10v1H3V7zm0 3h10v1H3v-1z" />
                                    </svg> VIEW ORDER
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </div>

    <div class="img_top"></div>
    <div class="store_banner" style="margin-top:1px"></div>

    <div class="store_header">
        <nav class="navbar navbar-expand-lg bg-transparent navbar-dark">
            <div class="container justify-content-center" style="text-align: center;">
                <a class="navbar-brand text-dark" style="text-align: center; font-family: myFont;"> <b><h1> CHECK OUT OUR PRODUCTS </h1> </b> </a>
            </div>
        </nav>
    </div>

    <div class="container">
    <form id="searchForm">
        <div class="input-group mb-3">
            <input type="text" class="form-control" id="productName" placeholder="Search by product name">
            <button class="btn btn-outline-secondary btn-dark text-white" type="submit">Search</button>
        </div>
    </form>
</div>

    <div class="container flex-wrap">
        <div class="col-12" style="margin: 40px;">
            <?= isset($msg) ? '<div class="alert alert-danger">' . $msg . '</div>' : '' ?>
            <?= (isset($_GET['msg']) && $_GET['msg'] == 'berhasil_ditambahkan') ? '<div class="alert alert-success">Data berhasil ditambahkan</div>' : '' ?>
        </div>
        <div class="container-fluid col-12 flex-wrap row" style="margin: 30px;">
            <?php foreach ($pengiriman->tampil_products()->fetchAll(PDO::FETCH_ASSOC) as $data): ?>
                <div class="card col-4" style="margin: 10px; width: 18rem;">
                    <img class="card-img-top" style="width: 265px; height: 265px" src="<?= $data["img_src"] ?>" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">
                            <?= $data['nama_product'] ?>
                        </h5>
                        <p class="card-text">
                            <?= $data['deskripsi_product'] ?>
                        </p>
                        <p class="card-text">
                            <?= format($data['harga']) ?>
                        </p>
                        <button class="btn bg-dark text-white add-to-cart" data-product-id="<?= $data['id'] ?>">Add To Cart</button>
                    </div>
                </div>
            <?php endforeach ?>
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
    <script src = "https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function () {
    $('#searchForm').submit(function (e) {
        e.preventDefault();
        var productName = $('#productName').val();

        $.ajax({
            type: 'GET',
            url: 'search_products.php',
            data: { name: productName },
            success: function (response) {
                $('.flex-wrap').html(response);
            },
            error: function () {
                alert('Error occurred while searching for products.');
            }
        });
    });

    $('.flex-wrap').on('click', '.add-to-cart', function (e) {
        e.preventDefault();

        var productId = $(this).data('product-id');

        $.ajax({
            type: 'GET',
            url: 'add_to_cart.php',
            data: { id: productId },
            success: function (response) {
                if (response.success) {
                    alert('Item added to cart successfully!');
                } else {
                    alert(response.message);
                }
            },
            error: function () {
                alert('Error occurred while adding item to cart.');
            }
        });
    });
});

</script>

</body>

</html>
