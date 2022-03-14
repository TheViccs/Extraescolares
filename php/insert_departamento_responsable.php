<?php
include('conexion.php');

$clave = $_POST['clave'];
$nombre = $_POST['nombre'];
$ubicacion = $_POST['ubicacion'];
$extension = $_POST['extension'];
$correo = $_POST['correo'];
$id_r = $_POST['id_responsable'];

$sql=("CALL sp_insert_departamento_responsable('".$clave."','".$nombre."','".$ubicacion."','".$extension."','".$correo.",".$id_r.")");
$result = mysqli_query($conn,$sql);
if($result){
    echo "1";
}     
?>