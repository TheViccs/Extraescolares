<?php
include('conexion.php');

$id_p = $_POST['id_programa'];
$clave = $_POST['clave'];
$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$observaciones = $_POST['observaciones'];

$descripcion = !empty($descripcion) ? "'$descripcion'" : "NULL";
$observaciones = !empty($observaciones) ? "'$observaciones'" : "NULL";

$departamentos = $_POST['departamentos'];
$array_departamentos = explode(',',$departamentos);

$sql=("CALL sp_update_programa(".$id_p.",'".$clave."','".$nombre."',$descripcion,$observaciones)");
$result = mysqli_query($conn,$sql);
if($result){
    echo "1";
}     

foreach ($array_departamentos as $departamento) {
    $sql=("CALL sp_update_programa_departamento(".$id_p.",".$departamento.")");
    $result = mysqli_query($conn,$sql);
    if($result){
        echo "1";
    } 
}    
?>