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
$actividad_padre = $_POST['actividad_padre'];
$actividad_padre = !empty($actividad_padre) ? "'$actividad_padre'" : "NULL";
$id_a = $_POST['id_actividad'];


$sql=("CALL sp_update_actividad('".$nombre."','".$descripcion."','".$competencia."',".$creditos.",'".$beneficios."',".$capacidad_min.",".$capacidad_max.",'".$fecha_inicio."','".$fecha_fin."',$actividad_padre,".$id_a.")");
$result = mysqli_query($conn,$sql);
if($result){
    echo "1";
}     

?>