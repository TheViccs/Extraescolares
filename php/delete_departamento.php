<?php
include('conexion.php');

$id_d = $_POST['id_departamento'];

$sql=("CALL sp_delete_departamento(".$id_d.")");
$result = mysqli_query($conn,$sql);
if($result){
    echo "1";
}     
?>