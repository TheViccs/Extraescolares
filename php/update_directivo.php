<?php
include('conexion.php');

$id_d = $_POST['id_directivo'];
$clave = $_POST['clave'];
$nombre = $_POST['nombre'];
$apellido_p = $_POST['apellido_p'];
$apellido_m = $_POST['apellido_m'];
$sexo = $_POST['sexo'];
$correo = $_POST['correo'];

$sql=("CALL sp_update_directivo(".$id_d.",'".$clave."','".$nombre."','".$apellido_p."','".$apellido_m."','".$correo."','".$sexo."')");
$result = mysqli_query($conn,$sql);
if($result){
    echo "1";
}
?>