<?php
include('conexion.php');

$id_a = $_POST['id_alumno'];

$sql=("CALL sp_select_detalles_inscripcion_alumno_id(".$id_a.")");
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