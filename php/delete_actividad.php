<?php
include('conexion.php');

$id_a = $_POST['id_actividad'];

$sql=("CALL sp_delete_actividad(".$id_a.")");
$result = mysqli_query($conn,$sql);
if($result){
    echo "1";
}     

?>