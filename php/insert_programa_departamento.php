<?php
include('conexion.php');

$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$observaciones = $_POST['observaciones'];
$descripcion = !empty($descripcion) ? "'$descripcion'" : "NULL";
$observaciones = !empty($observaciones) ? "'$observaciones'" : "NULL";
$departamentos = $_POST['departamentos'];
$array_departamentos = explode(',',$departamentos);

$sql=("CALL sp_insert_programa('".$nombre."',$descripcion,$observaciones)");
$result = mysqli_query($conn,$sql);
if($result){
    echo "1";
}     

foreach ($array_departamentos as $departamento) {
    $sql=("CALL sp_insert_programa_departamento(".$departamento.")");
    $result = mysqli_query($conn,$sql);
    if($result){
        echo "1";
    } 
}    
?>