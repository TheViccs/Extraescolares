<?php
include('conexion.php');

$id_r = $_POST['id_responsable'];

$sql=("CALL sp_select_programas_responsable_id(".$id_r.")");
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