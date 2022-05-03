<?php
include('conexion.php');

$id_i = $_POST['id_instructor'];
$nombre = $_POST['nombre'];
$apellido_p = $_POST['apellido_p'];
$apellido_m = $_POST['apellido_m'];
$telefono = $_POST['telefono'];
$sexo = $_POST['sexo'];
$correo = $_POST['correo'];

$sql=("CALL sp_update_instructor(".$id_i.",'".$nombre."','".$apellido_p."','".$apellido_m."','".$telefono."','".$sexo."','".$correo."')");
$result = mysqli_query($conn,$sql);
if($result){
    echo "1";
}
?>