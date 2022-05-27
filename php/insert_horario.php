<?php
include('conexion.php');

$dia = $_POST['dia'];
$hora_inicio = $_POST['hora_inicio'];
$hora_fin = $_POST['hora_fin'];
$id_g = $_POST['id_grupo'];

$sql=("CALL sp_insert_horario('".$dia."','".$hora_inicio."','".$hora_fin."',".$id_g.")");
$result = mysqli_query($conn,$sql);
if($result){
    echo "1";
}
?>