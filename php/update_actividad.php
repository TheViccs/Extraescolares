<?php
include('conexion.php');
 
$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$competencia = $_POST['competencia'];
$creditos = $_POST['creditos'];
$beneficios = $_POST['competencia'];
$capacidad_min = $_POST['capacidad_min'];
$capacidad_max = $_POST['capacidad_max'];
$fecha_inicio = $_POST['fecha_inicio'];
$fecha_fin = $_POST['fecha_fin'];
$id_a = $_POST['id_actividad'];

$material_actividad = $_POST['material_actividad'];
$array_material_actividad = json_decode($material_actividad);

$material_alumno = $_POST['material_alumno'];
$array_material_alumno = json_decode($material_alumno);

$temas = $_POST['temas'];
$array_temas = json_decode($temas);

$criterios = $_POST['criterios'];
$array_criterios = json_decode($criterios);


$sql=("CALL sp_update_actividad('".$nombre."','".$descripcion."','".$competencia."','".$creditos."','".$beneficios."',".$capacidad_min.",".$capacidad_max.",'".$fecha_inicio."','".$fecha_fin."',".$id_a.")");
$result = mysqli_query($conn,$sql);
if($result){
    echo "1";
}     

$sql=("CALL sp_delete_complementos_actividad(".$id_a.")");
$result = mysqli_query($conn,$sql);
if($result){
    echo "1";
}     

foreach($array_material_actividad as $fila){
    $sql=("CALL sp_insert_material_actividad(".$fila[0].",'".$fila[1]."',".$id_a.")");
    $result = mysqli_query($conn,$sql);
}

foreach($array_material_alumno as $fila){
    $sql=("CALL sp_insert_material_alumno(".$fila[0].",'".$fila[1]."',".$id_a.")");
    $result = mysqli_query($conn,$sql);
}
    
foreach($array_temas as $fila){
    $sql=("CALL sp_insert_tema(".$fila[0].",'".$fila[1]."',".$fila[2].",".$id_a.")");
    $result = mysqli_query($conn,$sql);
}

foreach($array_criterios as $fila){
    $sql=("CALL sp_insert_criterio_evaluacion(".$fila[0].",'".$fila[1]."',".$id_a.")");
    $result = mysqli_query($conn,$sql);
}
?>