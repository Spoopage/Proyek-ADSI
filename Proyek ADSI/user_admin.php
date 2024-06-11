<?php
include './includes/connection.php';
if (isset($_POST['entry'])) {
    $check_admin = "SELECT id, password FROM admins WHERE username = ?";
    $check_admin = $conn->prepare($check_admin);
    $check_admin->execute([$username]);
    $fetch_admin = $check_admin->fetch();
    $username = trim($_POST['username']);
    $password = password_hash(trim($_POST['password']), $fetch_admin["password"]);
    $nama = trim($_POST['nama_admin']);
    $insert_data = $pengiriman->insert_admin([
        $username,
        $password,
        $nama,
        1
    ]);
    if ($insert_data)
        header('location: user_admin.php?msg=berhasil_ditambahkan');
    else
        $msg = 'Data tidak berhasil ditambahkan!';
}
if (isset($_GET['id'])) {
    $id = trim($_GET['id']);
    $status = trim($_GET['status']);
    $update_admin = $pengiriman->update_status_admin([
        $status,
        $id
    ]);
    if ($update_admin)
        header('location: user_admin.php?msg=berhasil diupdate');
    else
        $msg = 'Data tidak berhasil ditambahkan!';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>

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
    </style>
</head>

<body>
    <div class="navbar-area">
        <nav class="navbar navbar-expand-lg navbar-dark sticky-top" style="background-color: #09111a;">
            <div class="container-fluid">
                <a class="navbar-brand ms-4"> <b>E-COM ADMIN</b></a>
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
                                <a class="nav-link" aria-current="page" href="admin.php">PRODUCT LIST</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="user_admin.php">USER</a>
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
            <div class="col-md-12">
                <form method="post">
                    <h2>Add Admin</h2>
                    <?= (isset($_GET['msg']) && $_GET['msg'] == 'berhasil_ditambahkan') ? '<div class="alert alert-success">Data berhasil ditambahkan</div>' : '' ?>
                    <p>Username</p>
                    <input type="text" name="username" id="" class="form-control form-control-lg"><br />
                    <p>Password</p>
                    <input type="text" name="password" id="" class="form-control form-control-lg"><br />
                    <p>Nama</p>
                    <input type="text" name="nama_admin" id="" class="form-control form-control-lg"><br />

                    <div class="d-grid gap-2">
                        <button class="btn btn-dark btn-lg mt-3 mb-5" name="entry">Entry</button>
                    </div>
                </form>
            </div>
            <br />
            <br />
            <h3>List Admin</h3>

            <?php
            $check_data = "SELECT * FROM admins";
            $check_data = $conn->prepare($check_data);
            $check_data->execute();

            if ($check_data->rowCount() == 0): ?>
                <p>Tidak ada entry log untuk resi ini</p>
            <?php else: ?>

                <br />
                <table class="table">
                    <thead class="table-dark">
                        <th scope="col" width="500">Username</th>
                        <th scope="col" width="200">Nama Admin</th>
                        <th scope="col" width="200">Status Aktif</th>
                        <th scope="col" width="200">Nonaktifkan</th>
                        <th scope="col" width="200">Aktifkan</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        foreach ($pengiriman->tampil_data_admin()->fetchAll(PDO::FETCH_ASSOC) as $data): ?>
                            <tr>
                                <td>
                                    <?= $data['username'] ?>
                                </td>
                                <td>
                                    <?= $data['nama_admin'] ?>
                                </td>
                                <td>
                                    <?= $data['status_aktif'] ?>
                                </td>
                                <td><a href="user_admin.php?id=<?= $data['id'] ?>&status=0"
                                        class="btn btn-danger">NONAKTIFKAN</button></td>
                                <td><a href="user_admin.php?id=<?= $data['id'] ?>&status=1"
                                        class="btn btn-primary">AKTIFKAN</button></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            <?php endif ?>
        </div>
    </div>

    <!-- Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
        </script>
</body>

</html>