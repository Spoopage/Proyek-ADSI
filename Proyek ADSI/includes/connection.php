<?php

session_start();

try {
    $conn = new PDO('mysql:host=localhost;dbname=proyekuas_adsi', 'root', '');
} catch (PDOException $e) {
    die('Tidak berhasil terkoneksi ke database!<br/>Error: ' . $e);
}

include 'proyek.class.php';

$pengiriman = new Products($conn);
$session_login = isset($_SESSION['login']) ? $_SESSION['login'] : '';

if (isset($session_login)) {
    // $fetch_admin = "SELECT * FROM admins WHERE id = ?";
    // $fetch_admin = $conn->prepare($fetch_admin);
    // $fetch_admin->execute([$session_login]);
    // $fetch_admin = $fetch_admin->fetch();

    $fetch_pelanggan = "SELECT * FROM pelanggan WHERE id_pelanggan = ?";
    $fetch_pelanggan = $conn->prepare($fetch_pelanggan);
    $fetch_pelanggan->execute([$session_login]);
    $fetch_pelanggan = $fetch_pelanggan->fetch();
} else {
    // $fetch_admin = null;
    $fetch_pelanggan = null;
}
