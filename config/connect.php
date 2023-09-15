<?php
function getConnect(){


$host ='147.139.214.202';
$username = "user_bank_api";
$password = "YyDyKWpa7WxN5kY8";
$db = "tsa_bank";


    $conn = new mysqli($host,$username,$password,$db);

    if($conn->connect_errno){
        echo "Can't Connect Error :" . $conn->connect_error;
        exit();
    }
    return $conn;
}

?>