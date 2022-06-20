<?php
include('conexion.php');

$id_a = $_POST['id_alumno'];
$id_grupo = $_POST['id_grupo'];
$id_actividad = $_POST['id_actividad'];

$sql=("CALL sp_delete_detalles_inscripcion(".$id_a.",".$id_grupo.",".$id_actividad.")");
$result = mysqli_query($conn,$sql);
if($result){
    echo "1";
}     
?>