<?php
include('conexion.php');
 
$id_a = $_POST['id_alumno'];
$id_g = $_POST['id_grupo'];
$criterios = $_POST['criterios'];
$array_criterios = json_decode($criterios);
$calificacion_numerica = $_POST['calificacion_numerica'];
$acreditado = $_POST['acreditado'];
$promedio = $_POST['promedio'];

foreach($array_criterios as $fila){
    $sql=("CALL sp_insert_criterio_alumno(".$id_a.",".$id_g.",".$fila[0].",".$fila[1].")");
    $result = mysqli_query($conn,$sql);
    if($result){
        echo "1";
    }
}

$sql=("CALL sp_calificar_alumno(".$id_a.",".$id_g.",".$calificacion_numerica.",".$acreditado.",".$promedio.")");
$result = mysqli_query($conn,$sql);
if($result){
    echo "1";
}

?>