<?php
include('conexion.php');

$p_id_programa = $_POST['id_programa'];

$sql=("CALL sp_delete_programa(".$p_id_programa.")");
$result = mysqli_query($conn,$sql);
if($result){
    echo "1";
}     
?>