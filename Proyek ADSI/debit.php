<?php

include './includes/connection.php';

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     $name = $_POST['name'];
//     $card_number = $_POST['card_number'];
//     $pin = $_POST['pin'];

//     // Here you would handle the payment processing logic, e.g., save to database, call payment API, etc.
//     // For this example, we'll just display the submitted data.
//     echo "<p>Payment Information:</p>";
//     echo "<p>Name: " . htmlspecialchars($name) . "</p>";
//     echo "<p>Card Number: " . htmlspecialchars($card_number) . "</p>";
//     echo "<p>PIN: " . htmlspecialchars($pin) . "</p>";
// }

if($_POST['verify']){
    $name = $_POST['name'];
    $card_number = $_POST['card_number'];
    $security_code = $_POST['security_code'];


}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debit</title>
    <!-- CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Enter Payment Information</h1>
        <form method="post" action="">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="card_number" class="form-label">Card Number</label>
                <input type="text" class="form-control" id="card_number" name="card_number" required>
            </div>
            <div class="mb-3">
                <label for="pin" class="form-label">Security Code</label>
                <input type="text" class="form-control" id="security_code" name="security_code" required>
            </div>
            <button type="submit" class="btn btn-primary" name="verify">Verify</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybBogGzGQ9btx1x4cw8rmYd2IQzE+PsaE3yyzQda3n5L7MQFe" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-pZmtN9Da5RkOj07m+mXT2g2Q2bndXRfuErkR1Xr6ey7q5UqKnbEGzFbb5R5tEX7b" crossorigin="anonymous"></script>
</body>
</html>
