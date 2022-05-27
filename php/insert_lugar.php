<?php
include('conexion.php');
 
$nombre = $_POST['lugar'];
$capacidad_max = $_POST['capacidad'];
$observaciones = $_POST['observaciones'];
$observaciones = !empty($observaciones) ? "'$observaciones'" : "NULL";

$sql=("CALL sp_insert_lugar('".$nombre."',".$capacidad_max.",$observaciones)");
$result = mysqli_query($conn,$sql);
if($result){
    echo "1";
}

?>