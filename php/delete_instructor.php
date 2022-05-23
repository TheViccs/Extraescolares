<?php
include('conexion.php');

$id_i = $_POST['id_instructor'];

$sql=("CALL sp_delete_instructor(".$id_i.")");
$result = mysqli_query($conn,$sql);
if($result){
    echo "1";
}     
?>