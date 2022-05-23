<?php
include('conexion.php');

$nombre = $_POST['nombre'];
$apellido_p = $_POST['apellido_p'];
$apellido_m = $_POST['apellido_m'];
$sexo = $_POST['sexo'];
$correo = $_POST['correo'];
$fecha_inicio = $_POST['fecha_inicio'];
$fecha_fin = $_POST['fecha_fin'];
$id_d = $_POST['id_departamento'];

$sql=("CALL sp_insert_instructor('".$nombre."','".$apellido_p."','".$apellido_m."','".$sexo."','".$correo."','".$fecha_inicio."','".$fecha_fin."',".$id_d.")");
$result = mysqli_query($conn,$sql);
if($result){
    echo "1";
}
?>