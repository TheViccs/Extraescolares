<?php
include('conexion.php');
 
$id_a = $_POST['id_actividad'];
$material_alumno = $_POST['material_alumno'];
$array_material_alumno = json_decode($material_alumno);

$sql=("CALL sp_delete_materiales_alumno(".$id_a.")");
$result = mysqli_query($conn,$sql);
echo $result;
if($result){
    echo "1";
}

foreach($array_material_alumno as $fila){
    $sql=("CALL sp_insert_material_alumno('".$fila[0]."',".$fila[1].",".$id_a.")");
    $result = mysqli_query($conn,$sql);
    echo $result;
    if($result){
        echo "1";
    }
}

?>