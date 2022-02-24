<?php

include('conexion.php');
$sql=("CALL select_departamentos()");
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