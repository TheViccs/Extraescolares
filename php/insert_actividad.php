<?php
include('conexion.php');
 
$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$competencia = $_POST['competencia'];
$creditos = $_POST['creditos'];
$beneficios = $_POST['beneficios'];
$capacidad_min = $_POST['capacidad_min'];
$capacidad_max = $_POST['capacidad_max'];
$fecha_inicio = $_POST['fecha_inicio'];
$fecha_fin = $_POST['fecha_fin'];
$id_p = $_POST['id_programa'];
$actividad_padre = $_POST['actividad_padre'];
$actividad_padre = !empty($actividad_padre) ? "'$actividad_padre'" : "NULL";

$sql=("CALL sp_insert_actividad('".$nombre."','".$descripcion."','".$competencia."','".$creditos."','".$beneficios."',".$capacidad_min.",".$capacidad_max.",'".$fecha_inicio."','".$fecha_fin."',".$id_p.",$actividad_padre)");
$result = mysqli_query($conn,$sql);

if($result){
    $emparray = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $emparray[] = $row;
    }
    echo json_encode($emparray, JSON_UNESCAPED_UNICODE);
}else{
    echo "0";
}   

?>