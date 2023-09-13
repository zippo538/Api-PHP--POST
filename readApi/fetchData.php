<?php
require_once "../config/getConneciton.php";
    function getDataAkun(){ 
    $conn = getConnection();
    $query = $conn->query("SELECT * FROM TblAkun");
    $query->execute();
    $result = $query->fetchAll();
        ?>

        <table>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>No Rekening</th>
                <th>Saldo</th>
            </tr>
            <?php 
            $no=1;
            foreach($result as $rows){
                echo "<tr>";
                echo "<td>".$no."</td>";
                echo "<td>".$rows['nama']."</td>";
                echo "<td>".$rows['norek']."</td>";
                echo "<td>".$rows['saldo']."</td>";
                $no++;
            }
            ?>
        </table>
        
  <?php  
    }

    getDataAkun();
    ?>