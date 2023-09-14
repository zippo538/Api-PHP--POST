<?php 
require_once "../config/getConneciton.php";
require_once "../readApi/fetchData.php";
$conn = getConnection();

    $rekAsal = $_GET['rekasal'];
    $rekTujuan = $_POST['rektujuan'];
    $nominal = $_POST['nominal'];
      
    try{
        //begin transfer saldo
        $conn->beginTransaction();
        $sql= transferSaldo($rekAsal,$rekTujuan,$nominal);
        $conn->commit();

        if($sql){
            echo "sukses";
            getDataAkun();
        }

    }
    catch (PDOException $e){
        echo " 1.error : " . $e->getMessage() . PHP_EOL;
    }
    finally{
        $conn= null;
    }

    function transferSaldo($from,$to, $amount){
        $conn = getConnection();
        $status = "Oke";
        
        try {
            $conn->beginTransaction();
            //get Saldo 
            $getRekAsal= 'SELECT saldo FROM TblAkun where idAkun=:from';
            $stmt = $conn->prepare($getRekAsal);
            $stmt->execute(array(':from'=>$from));
            $availableAmmount = (int) $stmt->fetchColumn();
            $stmt->closeCursor(); 
    
            if($availableAmmount < $amount){
                $status = "Gagal";
                addTransaction($from,$to,$amount,$status);
                echo "amount saldo not enough";
                return false;
            }
            else if(!$from && !$to){
                $status = "Gagal";
                addTransaction($from,$to,$amount,$status);
                echo "not found Account";
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
            
    
            //add transaction
            addTransaction($from,$to,$amount,$status);

            //commit transaction
            $conn->commit();
        }
        catch (PDOException $e){
            $conn->rollBack();
            echo "2. error: " . $e->getMessage();
        }
        finally{
            $conn= null;
        }
    }

    function addTransaction ($from,$to,$amount,$status){
        $tanggal = date('Y-m-d');
        
        $idTF = rand(1,1000);
        $conn = getConnection();
        
        $sql_transaction = $conn->prepare("INSERT INTO TblTransfer (idTransfer,rektujuan,rekasal,nominal,tgltf,status) VALUES (?,?,?,?,?,?)");
            $sql_transaction-> bindParam(1,$idTF,);
            $sql_transaction-> bindParam(2,$to);
            $sql_transaction-> bindParam(3,$from);
            $sql_transaction-> bindParam(4,$amount);        
            $sql_transaction-> bindParam(5,$tanggal);        
            $sql_transaction-> bindParam(6,$status); 
            $sql_transaction->execute();
        }  
        



    function getById($idRekening) {
        $conn = getConnection();
        $sql = "SELECT idAkun From TblAkun Where idAkun=:idRekening";
        $stmt = $conn->prepare($sql);
        return $stmt->execute();

    }



?>