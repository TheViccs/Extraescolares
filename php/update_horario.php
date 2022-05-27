<?php
include('conexion.php');

$dia = $_POST['dia'];
$hora_inicio = $_POST['hora_inicio'];
$hora_fin = $_POST['hora_fin'];
$id_h = $_POST['id_horario'];

$sql=("CALL sp_update_horario('".$dia."','".$hora_inicio."','".$hora_fin."',".$id_h.")");
$result = mysqli_query($conn,$sql);

if($result){
    echo "1";
}
?>