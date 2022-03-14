<?php
include('conexion.php');

$id_d = $_POST['id_departamento'];
$clave = $_POST['clave'];
$nombre = $_POST['nombre'];
$ubicacion = $_POST['ubicacion'];
$extension = $_POST['extension'];
$correo = $_POST['correo'];

$sql=("CALL sp_update_departamento(".$id_d.",'".$clave."','".$nombre."','".$ubicacion."','".$extension."','".$correo."')");
$result = mysqli_query($conn,$sql);
if($result){
    echo "1";
}     
?>