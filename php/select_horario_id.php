<?php
include('conexion.php');

$id_h = $_POST['id_horario'];

$sql=("CALL sp_select_horario_id(".$id_h.")");
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