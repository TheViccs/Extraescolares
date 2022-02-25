<?php
include('conexion.php');

$clave = $_POST['clave'];
$nombre = $_POST['nombre'];
$ubicacion = $_POST['ubicacion'];
$extension = $_POST['extension'];

$sql=("CALL sp_insert_departamento('".$clave."','".$nombre."','".$ubicacion."','".$extension."')");
$result = mysqli_query($conn,$sql);
if($result){
    echo "1";
}     
?>