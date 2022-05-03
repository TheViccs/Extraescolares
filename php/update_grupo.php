<?php
include('conexion.php');

$id_g = $_POST['id_grupo'];
$nombre = $_POST['nombre'];
$capacidad_max = $_POST['capacidad_max'];
$capacidad_min = $_POST['capacidad_min'];
$id_a = $_POST['id_actividad'];
$id_l = $_POST['id_lugar'];
$id_c = $_POST['id_caracteristica'];
$id_i = $_POST['id_instructor'];

$horarios = $_POST['horarios'];
$array_horarios = json_decode($horarios);

$sql=("CALL sp_update_grupo(".$id_g.",'".$nombre."',".$capacidad_max.",".$capacidad_min.",".$id_a.",".$id_l.",".$id_c.",".$id_i.")");
$result = mysqli_query($conn,$sql);
if($result){
    $last_id_grupo = mysqli_insert_id($conn);
    echo "1";
}     

$sql=("CALL sp_delete_complementos_grupo(".$id_g.")");
$result = mysqli_query($conn,$sql);
if($result){
    echo "1";
}     

foreach($array_horarios as $fila){
    $sql=("CALL sp_insert_horario('".$fila[0]."','".$fila[1]."','".$fila[2]."')");
    $result = mysqli_query($conn,$sql);
    $last_id_horario = mysqli_insert_id($conn);
    $sql=("CALL sp_insert_grupo_horario(".$last_id_grupo.",".$last_id_horario.")");
    $result = mysqli_query($conn,$sql);
}

?>