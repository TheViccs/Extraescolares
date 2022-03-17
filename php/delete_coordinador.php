<?php
include('conexion.php');

$id_c = $_POST['id_coordinador'];
$id_r = $_POST['id_responsable'];

$sql=("CALL sp_delete_coordinador(".$id_c.",".$id_r.")");
$result = mysqli_query($conn,$sql);
if($result){
    echo "1";
}     
?>