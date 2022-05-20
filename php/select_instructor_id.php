<?php
include('conexion.php');

$id_i = $_POST['id_instructor'];

$sql=("CALL sp_select_instructor_id(".$id_i.")");
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