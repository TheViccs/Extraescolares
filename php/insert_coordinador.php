<?php
include('conexion.php');

$clave = $_POST['clave'];
$nombre = $_POST['nombre'];
$apellido_p = $_POST['apellido_p'];
$apellido_m = $_POST['apellido_m'];
$correo = $_POST['correo'];

$sql=("CALL sp_insert_coordinador('".$clave."','".$nombre."','".$apellido_p."','".$apellido_m."','".$correo."')");
$result = mysqli_query($conn,$sql);
if($result){
    echo "1";
}     
?>