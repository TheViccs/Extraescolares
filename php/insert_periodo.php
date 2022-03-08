<?php
include('conexion.php');

$nombre = $_POST['nombre'];
$fecha_i_a = $_POST['fecha_i_a'];
$fecha_f_a = $_POST['fecha_f_a'];

$sql=("CALL sp_insert_periodo('".$nombre."','".$fecha_i_a."','".$fecha_f_a."')");
$result = mysqli_query($conn,$sql);
if($result){
    echo "1";
}     
?>