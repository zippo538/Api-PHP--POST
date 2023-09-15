<?php 
include "../config/connect.php";
$conn = getConnect();
header('Content-Type: application/json; charset=utf-8');


$idRek = $_GET['norek'];
$toRek = $_POST['rektujuan'];
$amount = $_POST['saldo'];
$date = date('Y-m-d');    
$status = "success";

try {
    $conn->begin_transaction();
    if($sql = $conn->prepare("INSERT INTO TblTransfer (idTransfer,rektujuan,rekasal,nominal,tgltf,status) VALUES (?,?,?,?,?,?)")) {
        $sql->bind_param(1,$sql->insert_id);
        $sql->bind_param(2,$idRek);
        $sql->bind_param(3,$toRek);
        $sql->bind_param(4,$amount);
        $sql->bind_param(5,$date);
        if(isset($sql->error)){
            $status = "fail";
            header(json_encode($status));
        }
        $sql->bind_param(6,$sql->$status);

        //checking amount 
        $sql_saldo= 'SELECT saldo FROM TblAkun where norek=:idRek';
        $stmt = $conn->prepare($sql_saldo);
        $stmt->execute(array(':idRek'=>$idRek));
        $availableAmmount = mysqli_fetch_column($sql_saldo,1);
        $stmt->close(); 

        if($availableAmmount < $amount){
            echo "not enough saldo";
            return false;
        }
        else if(!$from && !$to){
            echo "Account rekening not found";
            return false;
        }
    }
}
catch(mysqli_sql_exception $e){
    echo "error : " . $e->getMessage();
}

//


?>