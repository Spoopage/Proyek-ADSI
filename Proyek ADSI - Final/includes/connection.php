<?php

session_start();

try {
    $conn = new PDO('mysql:host=localhost;dbname=proyekuas_adsi', 'root', '');
} catch (PDOException $e) {
    die('Tidak berhasil terkoneksi ke database!<br/>Error: ' . $e);
}

function bukaKoneksiDB()
{
    $host = "localhost";
    $user = "root";
    $pwd = "";
    $database = "proyekuas_adsi";
    $conn = mysqli_connect($host, $user, $pwd, $database) or die("Error connect db");
    return $conn;
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

function get_debit_data($nama_nasabah){
    $data = array();
    $conn = bukaKoneksiDB();
    $sql_query = "SELECT * FROM sample_bank_db WHERE nama_nasabah = '$nama_nasabah';";
    $pelanggan = mysqli_query($conn, $sql_query);
    if ($pelanggan->num_rows > 0) {
        while ($row = $pelanggan->fetch_assoc()) {
            $data["id_nasabah"] = $row["id_nasabah"];
            $data["nama_nasabah"] = $row["nama_nasabah"];
            $data["pin"] = $row["pin"];
            $data["no_kartu"] = $row["no_kartu"];
            $data["security_code"] = $row["security_code"];     
            $data["saldo"] = $row["saldo"];     
        }
    }

    return $data;
}

function get_kredit_data($nama_nasabah){
    $data = array();
    $conn = bukaKoneksiDB();
    $sql_query = "SELECT * FROM sample_bank_krd WHERE nama_nasabah = '$nama_nasabah';";
    $pelanggan = mysqli_query($conn, $sql_query);
    if ($pelanggan->num_rows > 0) {
        while ($row = $pelanggan->fetch_assoc()) {
            $data["id_nasabah"] = $row["id_nasabah"];
            $data["nama_nasabah"] = $row["nama_nasabah"];
            $data["pin"] = $row["pin"];
            $data["no_kartu"] = $row["no_kartu"];
            $data["security_code"] = $row["security_code"];      
        }
    }

    return $data;
}

function get_pelanggan_by_id($id_pelanggan)
{
    $data = array();
    $conn = bukaKoneksiDB();
    $sql_query = "SELECT * FROM pelanggan WHERE id_pelanggan='$id_pelanggan';";
    $pelanggan = mysqli_query($conn, $sql_query);
    if ($pelanggan->num_rows > 0) {
        while ($row = $pelanggan->fetch_assoc()) {
            $data["id_pelanggan"] = $row["id_pelanggan"];
            $data["nama_pelanggan"] = $row["nama_pelanggan"];
            $data["noTelp_pelanggan"] = $row["noTelp_pelanggan"];
            $data["password"] = $row["password"];
            $data["alamat_pelanggan"] = $row["alamat_pelanggan"];     
        }
    }

    return $data;
}

function hapus_cart() {
    $conn = bukaKoneksiDB();
    $sql_query = "DELETE FROM cart";
    $result = mysqli_query($conn, $sql_query) or die(mysqli_error($conn));

    return $result;
}

function make_order() 
{
    $var = generateRandomID();
    $total = calculate_total_price();
    $jum = calculate_jumlah();

    $conn = bukaKoneksiDB();
    $sql_query = "INSERT INTO `order` (`order_id`, `jumlah`, `harga`) VALUES ('$var', $jum, $total);
";
    $result = mysqli_query($conn, $sql_query);

    return $result;
}

function generateRandomID($length = 10) 
{
    $randomString = bin2hex(random_bytes($length / 2));
    $randomInt = mt_rand(1000, 9999);
    $randomID = $randomString . $randomInt;

    return $randomID;
}

function get_all_cart() {
    $conn = bukaKoneksiDB();
    $sql_query = "SELECT * FROM cart;";
    $res = mysqli_query($conn, $sql_query);
    
    return $res;
}

function calculate_total_price() {
    $res = get_all_cart();
    $total = 0;

    while ($row = mysqli_fetch_assoc($res)) {
        $total += $row['jumlah'] * $row['harga'];
    }

    return $total;
}

function calculate_jumlah() {
    $res = get_all_cart();
    $total = 0;

    while ($row = mysqli_fetch_assoc($res)) {
        $total += $row['jumlah'];
    }

    return $total;
}
