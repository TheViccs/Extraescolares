<?php
include('conexion.php');
 
$id_a = $_POST['id_actividad'];
$temas = $_POST['temas'];
$array_temas = json_decode($temas);

$sql=("CALL sp_delete_temas(".$id_a.")");
$result = mysqli_query($conn,$sql);
echo $result;
if($result){
    echo "1";
}

foreach($array_temas as $fila){
    $sql=("CALL sp_insert_tema('".$fila[0]."','".$fila[1]."',".$fila[2].",".$id_a.")");
    $result = mysqli_query($conn,$sql);
    echo $result;
    if($result){
        echo "1";
    }
}

?>