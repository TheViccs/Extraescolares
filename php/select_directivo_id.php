<?php
include('conexion.php');

$id_d = $_POST['id_directivo'];

$sql=("CALL sp_select_directivo_id(".$id_d.")");
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