<?php

include 'includes/connection.php';

//===========================AWAL=====================================
if (isset($_POST['entry'])) {
    $name_product = trim($_POST['name_product']);
    $id_product = trim($_POST['id_product']);
    $stock = trim($_POST['stock']);
    
    $insert_data = $pengiriman->insert_products([
        'name' => $name_product,
        'id' => $id_product,
        'stock' => $stock
    ]);

    if ($insert_data)
        header('location: admin.php?msg=berhasil_ditambahkan');
    else
        $msg = 'Data tidak berhasil ditambahkan!';
}
    
// function format($harga) {
//     $jum = "IDR " . number_format($harga,2,',','.');
//     return $jum;
// }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>

    <!-- CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

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
    </style>
</head>

<body>
    <div class="navbar-area">
        <nav class="navbar navbar-expand-lg navbar-dark sticky-top" style="background-color: #09111a;">
            <div class="container-fluid">
                <a class="navbar-brand ms-4"> <b>E-COM ADMIN</b></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">
                            Admin Panel
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <ul class="navbar-nav justify-content-start flex-grow-1 pe-3">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="admin.php">PRODUCT STOCK LIST</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="user_admin.php">USER</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="logout.php">LOGOUT</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="index.php">STORE</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </div>

    <div class="container">
        <div class="content-web my-5">
            <h3>Products Stock List</h3>

            <div class="mb-3">
                <input type="text" class="form-control" id="searchProduct" placeholder="Search by product name">
            </div>

            <?php
            $check_data = "SELECT * FROM products";
            $check_data = $conn->prepare($check_data);
            $check_data->execute();

            if ($check_data->rowCount() == 0) : ?>
                <p>Tidak ada product yang disimpan.</p>
            <?php else : ?>

                <br />
                <table class="table">
                    <thead class="table-dark">
                        <th scope="col" width="200">Nama Produk</th>
                        <th scope="col" width="200">ID Produk</th>
                        <th scope="col" width="200">Stok Produk</th>
                        <th scope="col" width="200">Action</th>
                        </tr>
                    </thead>
                    <tbody id="productTableBody"></tbody>
                </table>
            <?php endif ?>
        </div>
        <div class="col-md-12">
                <form method="post">
                    <h2>Add Product</h2>

                    <?= isset($msg) ? '<div class="alert alert-danger">' . $msg . '</div>' : '' ?>

                    <?= (isset($_GET['msg']) && $_GET['msg'] == 'berhasil_ditambahkan') ? '<div class="alert alert-success">Data berhasil ditambahkan</div>' : '' ?>

                    <p>Nama Product</p>
                    <input type="text" name="name_product" id="" class="form-control form-control-lg"><br />
                    <p>ID Product</p>
                    <input type="text" name="id_product" id="" class="form-control form-control-lg"><br />

                    <p>Stock</p>
                    <input type="text" name="stock" id="" class="form-control form-control-lg"><br />

                    <div class="d-grid gap-2">
                        <button class="btn btn-dark btn-lg mt-3 mb-5" name="entry">ADD</button>
                    </div>
                </form>
            </div>
    </div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

<script>
    $(document).ready(function () {
    $('#searchProduct').keyup(function () {
        var searchTerm = $(this).val();

        $.ajax({
            type: 'GET',
            url: 'product_list.php',
            data: { name: searchTerm },
            dataType: 'json',
            success: function (response) {
                updateProductTable(response);
            },
            error: function () {
                console.error('Error occurred while searching for products.');
            }
        });
    });

    loadProductData();

    function loadProductData() {
        $.ajax({
            url: 'fetch_products.php',
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                updateProductTable(response);
            },
            error: function () {
                console.error('Error occurred while fetching product data.');
            }
        });
    }

    function updateProductTable(data) {
        $('#productTableBody').empty();

        $.each(data, function (index, item) {
            $('#productTableBody').append(`
                <tr>
                    <td>${item.name}</td>
                    <td>${item.id}</td>
                    <td>${item.stock}</td>
                    <td>
                        <a href="edit.php?id=${item.id}" class="btn btn-primary btn-sm">Edit</a>
                        <a href="delete.php?id=${item.id}" class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>
            `);
        });
    }
});
//===============================AKHIR=========================================
</script>
</body>

</html>
