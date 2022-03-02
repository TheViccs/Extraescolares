<?php
include('conexion.php');

$clave = $_POST['clave'];

$sql=("CALL sp_select_departamento_clave('".$clave."')");
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