<?php
include('conexion.php');

$id = $_POST['id'];
$nombre = $_POST['nombre'];
$ubicacion = $_POST['ubicacion'];
$extension = $_POST['extension'];

$sql=("CALL insert_departamento('".$id."','".$nombre."','".$ubicacion."','".$extension."')");
$result = mysqli_query($conn,$sql);
if($result){
    echo "1";
}     
?>