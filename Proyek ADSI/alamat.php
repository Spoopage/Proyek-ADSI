<?php
session_start();

// Establish database connection
try {
    $conn = new PDO('mysql:host=localhost;dbname=proyekuas_adsi', 'root', '');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Tidak berhasil terkoneksi ke database!<br/>Error: ' . $e->getMessage());
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit_address'])) {
        $address = isset($_POST['address']) ? $_POST['address'] : '';
        $customer_id = isset($_SESSION['login']) ? $_SESSION['login'] : null;

        if (!empty($address) && !empty($customer_id)) {
            try {
                $stmt = $conn->prepare("UPDATE pelanggan SET alamat_pelanggan = :address WHERE id_pelanggan = :customer_id");
                $stmt->bindParam(':address', $address);
                $stmt->bindParam(':customer_id', $customer_id);
                $stmt->execute();
                
                // Redirect to another page after address is updated
                header("Location: index.php");
                exit();
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alamat</title>
    <!-- Your CSS styles here -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 50px;
        }
        h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        form {
            max-width: 400px;
            margin: auto;
        }
        label, input, button {
            display: block;
            width: 100%;
            margin-bottom: 10px;
            font-size: 18px; /* Increase font size */
        }
        input, button {
            padding: 10px;
            font-size: 18px; /* Increase font size */
        }
    </style>
</head>
<body>
    <h1>Masukkan Alamat Anda</h1>
    <form id="addressForm" action="" method="POST">
        <label for="address">Masukkan Alamat Anda</label>
        <input type="text" id="address" name="address" required>
        <button type="submit" name="submit_address">Submit</button>
    </form>
</body>
</html>
