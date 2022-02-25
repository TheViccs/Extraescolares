<?php
include('conexion.php');

$clave = $_POST['clave'];
$nombre = $_POST['nombre'];
$correo = $_POST['correo'];

$sql=("CALL sp_insert_responsable('".$clave."','".$nombre."','".$correo."')");
$result = mysqli_query($conn,$sql);
if($result){
    echo "1";
}     
?>