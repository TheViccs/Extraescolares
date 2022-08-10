<?php
include('conexion.php');

$id_c = $_POST['id_coordinador'];
$id_p = $_POST['id_programa'];
$id_d = $_POST['id_departamento'];
$fecha_inicio = $_POST['fecha_inicio'];


$sql=("CALL sp_insert_coordinador_programa(".$id_c.",".$id_p.",".$id_d.",'".$fecha_inicio."')");
$result = mysqli_query($conn,$sql);
if($result){
    echo "1";
}     
?>