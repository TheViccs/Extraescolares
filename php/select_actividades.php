<?php
include('conexion.php');

$id_p = $_POST['id_programa'];

$sql=("CALL sp_select_actividades(".$id_p.")");
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