<?php
include('conexion.php');
 
$nombre = $_POST['caracteristica'];


$sql=("CALL sp_insert_caracteristica('".$nombre."')");
$result = mysqli_query($conn,$sql);
if($result){
    echo "1";
}

?>