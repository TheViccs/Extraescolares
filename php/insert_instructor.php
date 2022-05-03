<?php
include('conexion.php');

$nombre = $_POST['nombre'];
$apellido_p = $_POST['apellido_p'];
$apellido_m = $_POST['apellido_m'];
$telefono = $_POST['telefono'];
$sexo = $_POST['sexo'];
$correo = $_POST['correo'];
$id_d = $_POST['id_departamento'];

$sql=("CALL sp_insert_instructor('".$nombre."','".$apellido_p."','".$apellido_m."','".$telefono."','".$sexo."','".$correo."',".$id_d.")");
$result = mysqli_query($conn,$sql);
if($result){
    echo "1";
}
?>