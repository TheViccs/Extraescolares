<?php
include('conexion.php');

$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$observaciones = $_POST['observaciones'];

$descripcion = !empty($descripcion) ? "'$descripcion'" : "NULL";
$observaciones = !empty($observaciones) ? "'$observaciones'" : "NULL";

$sql=("CALL sp_insert_programa('".$nombre."',$descripcion,$observaciones)");
$result = mysqli_query($conn,$sql);
if($result){
    echo "1";
}     
?>