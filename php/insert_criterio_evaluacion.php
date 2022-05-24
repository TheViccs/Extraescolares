<?php
include('conexion.php');
 
$id_a = $_POST['id_actividad'];
$criterios_evaluacion = $_POST['criterios_evaluacion'];
$array_criterios_evaluacion = json_decode($criterios_evaluacion);

$sql=("CALL sp_delete_criterios_evaluacion(".$id_a.")");
$result = mysqli_query($conn,$sql);
echo $result;
if($result){
    echo "1";
}

foreach($array_criterios_evaluacion as $fila){
    $sql=("CALL sp_insert_criterio_evaluacion('".$fila[0]."','".$fila[1]."',".$id_a.")");
    $result = mysqli_query($conn,$sql);
    echo $result;
    if($result){
        echo "1";
    }
}

?>