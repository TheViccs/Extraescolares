<?php 
include('conexion.php');

$id_a = $_POST['id_alumno'];
$id_g = $_POST['id_grupo'];

if(isset($_FILES['constancia']['tmp_name'])) {
    $img = $_FILES["constancia"]["name"]; 
    $tmp = $_FILES["constancia"]["tmp_name"]; 
    $path = "assets/constancias/";
    $move_path = dirname(__FILE__);
    $img_name = $path.strtolower((microtime(true))."-".$img); 
    $move_path = substr($move_path,0,strlen($move_path)-3).$img_name;
    $url = "'../../../$img_name'";
    move_uploaded_file($tmp,$move_path);
}else{
    $url = "";
    $url = !empty($img) ? "'$img'" : "NULL";
}

$sql=("CALL sp_subir_constancia(".$id_a.",".$id_g.",$url)");
$result = mysqli_query($conn,$sql);

if($result){
    echo "1";
}

?>