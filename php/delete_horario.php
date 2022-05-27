<?php
include('conexion.php');

$id_h = $_POST['id_horario'];

$sql=("CALL sp_delete_horario(".$id_h.")");
$result = mysqli_query($conn,$sql);
if($result){
    echo "1";
}     
?>