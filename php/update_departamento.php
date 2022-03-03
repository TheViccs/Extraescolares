<?php
include('conexion.php');

$id_d = $_POST['id_departamento'];
$clave = $_POST['clave'];
$nombre = $_POST['nombre'];
$ubicacion = $_POST['ubicacion'];
$extension = $_POST['extension'];

$sql=("CALL sp_update_departamento(".$id_d.",'".$clave."','".$nombre."','".$ubicacion."','".$extension."')");
$result = mysqli_query($conn,$sql);
if($result){
    echo "1";
}     
?>