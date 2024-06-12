<?php
    require_once 'includes/connection.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Item</title>

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
    <?php
    if (isset($_GET['id'])) {
        $productId = $_GET['id'];
        $query = "SELECT * FROM products WHERE id = $productId";
        $result = $conn->query($query);
        $row = $result->fetch(PDO::FETCH_ASSOC);

        if(isset($_POST['submit'])){
            $name_product = trim($_POST['name_product']);
            $id_product = trim($_POST['id']);
            $stock = trim($_POST['stock']);
    
            $sql = "UPDATE products SET name= ?, id = ?, stock = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$name_product, $id_product, $stock, $productId]);
            header("Location: admin.php");
            $stmt->close();
        }
    }
    ?>
        <nav class="navbar navbar-dark navbar-expand-lg bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Halo, Admin</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="admin.php">Product List</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="user_admin.php">User Admin</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Store</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container-fluid my-2 p-3">
            <div class="row mb-2">
                <div class="col-4">
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="name_product" class="form-label">Nama Product : </label>
                            <input type="text" class="form-control" value ="<?php echo $row['name']?>" id="name_product" name ="name_product" required>
                        </div>
                        <div class="mb-3">
                            <label for="id" class="form-label">ID Product : </label>
                            <input type="text" class="form-control" value ="<?php echo $row['id']?>" id="id" name ="id" required>
                        </div>
                        <div class="mb-3">
                            <label for="inHar" class="form-label">Stock : </label>
                            <input type ="number"class="form-control" value="<?php echo $row['stock']?>" id="stock" name="stock" required></textarea>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary" id="submit" name ="submit">Submit</button>
                            <button type="button" class="btn btn-danger" id ="back">Back</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</body>

<script>
    document.getElementById('back').addEventListener('click', function() {
        window.location.href = 'admin.php';
    });
</script>

</html>
