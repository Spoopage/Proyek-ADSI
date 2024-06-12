<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Payment Method</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Pilih Cara Pembayaran</h2>
    <div class="row mt-4">
        <div class="col-md-4">
            <button type="button" class="btn btn-secondary btn-block" onclick="window.location.href='debit.php'">Debit</button>
        </div>
        <div class="col-md-4">
            <button type="button" class="btn btn-secondary btn-block" onclick="window.location.href='kredit.php'">Credit</button>
        </div>
        <div class="col-md-4">
            <button type="button" class="btn btn-secondary btn-block" onclick="window.location.href='qris.php'">QRIS</button>
        </div>
    </div>
</div>
</body>
</html>
