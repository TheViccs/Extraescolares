<?php
include('conexion.php');

$r_id_responsable = $_POST['id_responsable'];

$sql=("CALL sp_delete_responsable(".$r_id_responsable.")");
$result = mysqli_query($conn,$sql);
if($result){
    echo "1";
}     
?>