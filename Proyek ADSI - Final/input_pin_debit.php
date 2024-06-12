<?php

include './includes/connection.php';

if(isset($_GET['nama_nasabah'])){
    $name = $_GET['nama_nasabah'];

    $debit_data = get_debit_data($name);
}

if(isset($_POST['verify'])) {
    $pin = $_POST['pin'];

    if($debit_data['pin'] == $pin) {
        
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Pin Debit</title>
    <!-- CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Enter Pin</h1>
        <form method="post" action="">
            <div class="mb-3">
                <label for="pin" class="form-label">Pin</label>
                <input type="text" class="form-control" id="pin" name="pin" required>
            </div>
            <button type="submit" class="btn btn-primary" name="verify">Verify</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybBogGzGQ9btx1x4cw8rmYd2IQzE+PsaE3yyzQda3n5L7MQFe" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-pZmtN9Da5RkOj07m+mXT2g2Q2bndXRfuErkR1Xr6ey7q5UqKnbEGzFbb5R5tEX7b" crossorigin="anonymous"></script>
</body>
</html>
