<?php
include('conexion.php');
 
$id_a = $_POST['id_actividad'];
$material_actividad = $_POST['material_actividad'];
$array_material_actividad = json_decode($material_actividad);

$sql=("CALL sp_delete_materiales_actividad(".$id_a.")");
$result = mysqli_query($conn,$sql);
if($result){
    echo "1";
}

foreach($array_material_actividad as $fila){
    $sql=("CALL sp_insert_material_actividad('".$fila[0]."',".$fila[1].",".$id_a.")");
    $result = mysqli_query($conn,$sql);
    if($result){
        echo "1";
    }
}

?>