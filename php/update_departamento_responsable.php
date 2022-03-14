<?php
include('conexion.php');

$id_d = $_POST['id_departamento'];
$clave = $_POST['clave'];
$nombre = $_POST['nombre'];
$ubicacion = $_POST['ubicacion'];
$extension = $_POST['extension'];
$correo = $_POST['correo'];
$id_r = $_POST['id_responsable'];

$sql=("CALL sp_update_departamento_responsable(".$id_d.",'".$clave."','".$nombre."','".$ubicacion."','".$extension."','".$correo."',".$id_r.")");
$result = mysqli_query($conn,$sql);
if($result){
    echo "1";
}  
?>