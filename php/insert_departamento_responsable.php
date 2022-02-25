<?php
include('conexion.php');

$id_d = $_POST['id_departamento'];
$id_r = $_POST['id_responsable'];

$sql=("CALL sp_insert_departamento_responsable(".$id_d.",".$id_r.")");
$result = mysqli_query($conn,$sql);
if($result){
    echo "1";
}     
?>