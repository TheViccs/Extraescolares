<?php
include('conexion.php');

$id_c = $_POST['id_coordinador'];
$id_d = $_POST['id_departamento'];

$sql=("CALL sp_delete_coordinador(".$id_c.",".$id_d.")");
$result = mysqli_query($conn,$sql);
if($result){
    echo "1";
}     
?>