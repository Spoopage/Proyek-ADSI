<?php
    $servername = "localhost";
    $username = "root"; // Ganti dengan username MySQL Anda
    $password = ""; // Ganti dengan password MySQL Anda
    $dbname = "proyekuas_adsi";

    // Membuat koneksi
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Memeriksa koneksi
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    class Customer {
        private $address;
        private $conn;

        public function __construct($conn, $address = null) {
            $this->conn = $conn;
            $this->address = $address;
        }

        public function setAddress($customerId, $newAddress) {
            $this->address = $newAddress;
            $stmt = $this->conn->prepare("UPDATE pelanggan SET alamat_pelanggan = ? WHERE id_pelanggan = ?");
            if ($stmt === false) {
                die('Prepare failed: ' . htmlspecialchars($this->conn->error));
            }

            $stmt->bind_param("si", $this->address, $customerId);
            if ($stmt->execute()) {
                echo "Alamat diubah menjadi: " . htmlspecialchars($this->address) . "<br>";
            } else {
                echo "Execute failed: " . htmlspecialchars($stmt->error) . "<br>";
            }
            $stmt->close();
        }

        public function getCustomerIdByName($customerName) {
            $stmt = $this->conn->prepare("SELECT id_pelanggan FROM pelanggan WHERE nama_pelanggan = ?");
            if ($stmt === false) {
                die('Prepare failed: ' . htmlspecialchars($this->conn->error));
            }

            $stmt->bind_param("s", $customerName);
            $stmt->execute();
            $stmt->bind_result($customerId);
            $stmt->fetch();
            $stmt->close();

            return $customerId;
        }       
    }

    class UI {
        private $customer;

        public function __construct($customer) {
            $this->customer = $customer;
        }

        public function changeAddress($customerName, $newAddress) {
            $customerId = $this->customer->getCustomerIdByName($customerName);
            if ($customerId !== null) {
                if ($this->validateData($newAddress)) {
                    $this->customer->setAddress($customerId, $newAddress);
                    $this->showSuccessMessage();
                } else {
                    $this->showErrorMessage();
                }
            } else {
                $this->showCustomerNotFoundMessage();
            }
        }

        private function validateData($data) {
            return !empty(trim($data));
        }

        private function showSuccessMessage() {
            echo "<script>alert('Alamat berhasil diubah!'); window.location.href = 'index.php';</script>";
        }

        private function showErrorMessage() {
            echo "<script>alert('Alamat tidak valid. Silakan coba lagi.'); window.history.back();</script>";
        }

        private function showCustomerNotFoundMessage() {
            echo "<script>alert('Pelanggan tidak ditemukan. Silakan cek kembali nama pelanggan.'); window.history.back();</script>";
        }
    }

    $customer = new Customer($conn);
    $ui = new UI($customer);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $customerName = $_POST['customer_name'];
        $newAddress = $_POST['address'];
        $ui->changeAddress($customerName, $newAddress);
    }

    $conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Address</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 50px;
        }
        form {
            max-width: 400px;
            margin: auto;
        }
        label, input, button {
            display: block;
            width: 100%;
            margin-bottom: 10px;
        }
        input, button {
            padding: 10px;
        }
    </style>
</head>
<body>
    <h1>Silakan Masukkan Nama Pelanggan dan Alamat Baru</h1>
    <form id="addressForm" action="" method="POST">
        <label for="customer_name">Nama Pelanggan</label>
        <input type="text" id="customer_name" name="customer_name" required>
        <label for="address">Alamat Baru</label>
        <input type="text" id="address" name="address" required>
        <button type="submit">Submit</button>
    </form>
</body>
</html>