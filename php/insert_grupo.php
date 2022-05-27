<?php
include('conexion.php');
 
$nombre = $_POST['nombre'];
$capacidad_max = $_POST['capacidad_max'];
$capacidad_min = $_POST['capacidad_min'];
$id_a = $_POST['id_actividad'];
$id_l = $_POST['id_lugar'];
$id_c = $_POST['id_caracteristica'];
$id_i = $_POST['id_instructor'];

$sql=("CALL sp_insert_grupo('".$nombre."',".$capacidad_max.",".$capacidad_min.",".$id_a.",".$id_l.",".$id_c.",".$id_i.")");
$result = mysqli_query($conn,$sql);
if($result){
    echo "1";
}     

?>