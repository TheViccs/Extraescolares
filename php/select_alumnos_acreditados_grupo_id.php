<?php
include('conexion.php');

$id_g = $_POST['id_grupo'];

$sql=("CALL sp_select_alumnos_acreditados_grupo_id(".$id_g.")");
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