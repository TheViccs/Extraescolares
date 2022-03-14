<?php
include('conexion.php');

$clave = $_POST['clave'];
$nombre = $_POST['nombre'];
$ubicacion = $_POST['ubicacion'];
$extension = $_POST['extension'];
$correo = $_POST['correo'];

$sql=("CALL sp_insert_departamento('".$clave."','".$nombre."','".$ubicacion."','".$extension."','".$correo."')");
$result = mysqli_query($conn,$sql);
if($result){
    echo "1";
}     
?>