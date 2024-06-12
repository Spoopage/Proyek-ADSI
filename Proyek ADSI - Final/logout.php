<?php
include 'includes/connect.php';

unset($_SESSION['login']);

header('location: login.php');
?>