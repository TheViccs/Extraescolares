<?php
include('conexion.php');

$id_c = $_POST['id_coordinador'];
$id_p = $_POST['id_programa'];
$correo = $_POST['correo'];
$fecha_inicio = $_POST['fecha_inicio'];


$sql=("CALL sp_insert_coordinador_programa(".$id_c.",".$id_p.",'".$correo."','".$fecha_inicio."')");
$result = mysqli_query($conn,$sql);
if($result){
    echo "1";
}     
?>