<?php
include('conexion.php');

$id_a = $_POST['id_actividad'];
$id_g = $_POST['id_grupo'];
$id_alumno = $_POST['id_alumno'];

$sql=("CALL sp_insert_detalle_inscripcion_alumno_coordinador(".$id_alumno.",".$id_g.",".$id_a.")");
$result = mysqli_query($conn,$sql);

if($result){
    $emparray = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $emparray[] = $row;
    }
    echo json_encode($emparray, JSON_UNESCAPED_UNICODE);
}else{
    echo "0";
}    

?>