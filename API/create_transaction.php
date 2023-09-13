<?php 
#Get connection database
require_once "../config/getConneciton.php";

$conn = getConnection();
    



if(isset($_POST['tambahData'])){
    $idTF = rand(10,100);
    $rekAsal = $_POST['rekasal'];
    $rekTujuan = $_POST['rektujuan'];
    $nominal = $_POST['nominal'];
    $tanggal = date('Y-m-d');    
    $status = 'oke';
    try{
        
        $sql = $conn->prepare("INSERT INTO TblTransfer (idTransfer,rektujuan,rekasal,nominal,tgltf,status) VALUES (?,?,?,?,?,?)");
        $sql-> bindParam(1,$idTF,);
        $sql-> bindParam(2,$rekTujuan);
        $sql-> bindParam(3,$rekAsal);
        $sql-> bindParam(4,$nominal);        
        $sql-> bindParam(5,$tanggal);        
        $sql-> bindParam(6,$status);    
        $sql->execute();   
        //change saldo account 
        transfer($rekAsal,$rekTujuan,$nominal);
        
        if($sql){
            // echo "sukses";
            getDataAkun();
        }
    }
    catch (PDOException $e){
        echo $e->getMessage();
    }
    finally {
        $sql=null;
    }
} else {
    echo "gagal";
}

 function transfer($from,$to, $amount){
    try {
        $conn = getConnection();
        $conn->beginTransaction();
        $getRekAsal= 'SELECT saldo FROM TblAkun where idAkun=:from';
        $stmt = $conn->prepare($getRekAsal);
        $stmt->execute(array(':from'=>$from));
        $availableAmmount = (int) $stmt->fetchColumn();
        $stmt->closeCursor(); 

        if($availableAmmount < $amount){
            echo "not enough saldo";
            return false;
        }
        else if(!$from && !$to){
            echo "Account rekening not found";
            return false;
        }
        //deduct saldo account
        $sql_update_saldo = 'UPDATE TblAkun SET saldo = saldo - :amount WHERE idAkun = :from';
        $stmt = $conn->prepare($sql_update_saldo);
        $stmt->execute(array(':amount'=>$amount,':from'=>$from));
        $stmt->closeCursor();
        
        //add receiving transafer saldo
        $sql_update_to = "UPDATE TblAkun SET saldo = saldo + :amount WHERE idAkun =:to";
        $stmt = $conn ->prepare($sql_update_to);
        $stmt->execute(array(':amount'=>$amount,':to'=>$to));
        $stmt->closeCursor();

        //commit transaction
        $conn->commit();
    }
    catch (PDOException $e){
        $conn->rollBack();
        echo "error : " . $e->getMessage();
    }
    finally{
        $conn= null;
    }
}


?>