<?php
include('conexion.php');

$id_g = $_POST['id_grupo'];

$sql=("CALL sp_delete_grupo(".$id_g.")");
$result = mysqli_query($conn,$sql);
if($result){
    echo "1";
}     
?>