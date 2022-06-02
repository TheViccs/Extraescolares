<?php
include('conexion.php');
 
$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$descripcion = !empty($descripcion) ? "'$descripcion'" : "NULL";
$competencia = $_POST['competencia'];
$competencia = !empty($competencia) ? "'$competencia'" : "NULL";
$creditos = $_POST['creditos'];
$beneficios = $_POST['beneficios'];
$beneficios = !empty($beneficios) ? "'$beneficios'" : "NULL";
$capacidad_min = $_POST['capacidad_min'];
$capacidad_max = $_POST['capacidad_max'];
$fecha_inicio = $_POST['fecha_inicio'];
$fecha_fin = $_POST['fecha_fin'];
$actividad_padre = $_POST['actividad_padre'];
$actividad_padre = !empty($actividad_padre) ? "'$actividad_padre'" : "NULL";
$id_a = $_POST['id_actividad'];

if(isset($_FILES['video']['tmp_name'])) {
    $img = $_FILES["video"]["name"]; 
    $tmp = $_FILES["video"]["tmp_name"]; 
    $path = "assets/videos/";
    $move_path = dirname(__FILE__);
    $img_name = $path.strtolower((microtime(true))."-".$img); 
    $move_path = substr($move_path,0,strlen($move_path)-3).$img_name;
    $url = "'../../../$img_name'";
    move_uploaded_file($tmp,$move_path);
}else{
    $url = "";
    $url = !empty($img) ? "'$img'" : "NULL";
}

$sql=("CALL sp_update_actividad('".$nombre."','".$descripcion."','".$competencia."',".$creditos.",'".$beneficios."',".$capacidad_min.",".$capacidad_max.",'".$fecha_inicio."','".$fecha_fin."',".$id_a.",$actividad_padre,$url)");
$result = mysqli_query($conn,$sql);

if($result){
    echo $result;
}     

?>