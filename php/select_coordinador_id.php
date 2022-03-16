<?php
include('conexion.php');

$id_c = $_POST['id_coordinador'];

$sql=("CALL sp_select_coordinador_id(".$id_c.")");
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