<?php
include('conexion.php');

$id_g = $_POST['id_grupo'];
$nombre = $_POST['nombre'];
$capacidad_max = $_POST['capacidad_max'];
$capacidad_min = $_POST['capacidad_min'];
$id_l = $_POST['id_lugar'];
$id_c = $_POST['id_caracteristica'];
$id_i = $_POST['id_instructor'];

$sql=("CALL sp_update_grupo(".$id_g.",'".$nombre."',".$capacidad_max.",".$capacidad_min.",".$id_l.",".$id_c.",".$id_i.")");
$result = mysqli_query($conn,$sql);
if($result){
    $last_id_grupo = mysqli_insert_id($conn);
    echo "1";
}     

?>