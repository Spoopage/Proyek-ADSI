<?php include 'includes/connection.php'; ?>


<?php
if (isset($_GET['name'])) {
    $productName = $_GET['name'];
    
    $query = "SELECT * FROM products WHERE nama_product LIKE :productName";
    $statement = $conn->prepare($query);
    $statement->bindValue(':productName', '%' . $productName . '%', PDO::PARAM_STR);
    $statement->execute();
    
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);
    
    
    echo '<div class="container-fluid col-12 flex-wrap row" style="margin: 30px;">';
    foreach ($results as $data) {
        echo '<div class="card col-4" style="margin: 10px; width: 18rem;">';
        echo '<img class="card-img-top" style="width: 265px; height: 265px" src="' . $data["img_src"] . '" alt="Card image cap">';
        echo '<div class="card-body">';
        echo '<h5 class="card-title">' . $data['nama_product'] . '</h5>';
        echo '<p class="card-text">' . $data['deskripsi_product'] . '</p>';
        echo '<p class="card-text">' . format($data['harga']) . '</p>';
        echo '<button class="btn bg-dark text-white add-to-cart" data-product-id="' . $data['id'] . '">Add To Cart</button>';
        echo '</div>';
        echo '</div>';
    }
    echo '</div>';
} else {
    echo 'Invalid request';
}

function format($harga) {
    return "IDR " . number_format($harga, 2, ',', '.');
}

?>

<?php
