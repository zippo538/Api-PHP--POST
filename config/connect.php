<?php
$dsn ='mysql:dbname=tsa_bank;host=185.73.39.162';
$username = "user_bank_api";
$password = "YyDyKWpa7WxN5kY8";

try{
    $conn = new PDO($dsn,$username,$password);
    $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    echo "Connect Succesfully";
}
catch (PDOException $e){
    echo("Can't open the database." . $e->getMessage());
}
finally{
    $conn = null;
}



?>