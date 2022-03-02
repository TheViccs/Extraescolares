<?php
include('conexion.php');

$nombre = $_POST['nombre'];
$fecha_i_a = $_POST['fecha_i_a'];
$fecha_f_a = $_POST['fecha_f_a'];
$fecha_i_i = $_POST['fecha_i_i'];
$fecha_f_i = $_POST['fecha_f_i'];


$sql=("CALL sp_insert_periodo('".$nombre."','".$fecha_i_a."','".$fecha_f_a."','".$fecha_i_i."','".$fecha_f_i."')");
$result = mysqli_query($conn,$sql);
if($result){
    echo "1";
}     
?>