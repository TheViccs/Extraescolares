<?php
include('conexion.php');

$id = $_POST['id'];
$nombre = $_POST['nombre'];
$correo = $_POST['correo'];

$sql=("CALL insert_responsable('".$id."','".$nombre."','".$correo."')");
$result = mysqli_query($conn,$sql);
if($result){
    echo "1";
}     
?>