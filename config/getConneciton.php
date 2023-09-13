<?php 
function getConnection() {
$dsn ='mysql:dbname=tsa_bank;host=185.73.39.162';
$username = "user_bank_api";
$password = "YyDyKWpa7WxN5kY8";
return new PDO($dsn,$username,$password);
}
?>