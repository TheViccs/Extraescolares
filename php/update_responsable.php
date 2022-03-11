<?php
include('conexion.php');

$id_responsable = $_POST['id_responsable'];
$clave = $_POST['clave'];
$nombre = $_POST['nombre'];
$apellido_p = $_POST['apellido_p'];
$apellido_m = $_POST['apellido_m'];
$correo = $_POST['correo'];

$sql=("CALL sp_update_responsable(".$id_responsable.",'".$clave."','".$nombre."','".$apellido_p."','".$apellido_m."','".$correo."')");
$result = mysqli_query($conn,$sql);
if($result){
    echo "1";
}     
?>