<?php
include('conexion.php');

$id_d = $_POST['id_directivo'];

$sql=("CALL sp_delete_directivo(".$id_d.")");
$result = mysqli_query($conn,$sql);
if($result){
    echo "1";
}     
?>