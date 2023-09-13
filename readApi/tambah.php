<?php 
require_once "../config/getConneciton.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Transaksi</title>
    <link rel="stylesheet" href="style/style.css"> </head>

<body>
    <h1>Transaksi</h1>
    <p>form ini digunakan untuk Transaksi</p>
                <form action="../API/create_transaction.php" method="post" id="form">
                        <div class="form-group">
                            <label for="">Rekening Tujuan</label>
                            <input type="text" name="rektujuan" id="rektujuan" placeholder="Rekening Tujuan" aria-describedby="helpId"> </div>
                        <div class="form-group">
                            <label for="">Rekening Asal</label>
                            <input type="text" name="rekasal" id="rekasal" placeholder="Rekening Asal" aria-describedby="helpId"> </div>
                        <div class="form-group">
                            <label for="">Nominal</label>
                            <input type="text" name="nominal" id="nominal" placeholder="Nominal" aria-describedby="helpId"> </div>
                        <div class="form-group">
                            <button type="submit" name="tambahData">Transfer</button>
                        </div>
                    </form>
    
        
     
</body>

</html>