<?php 
session_start();
include('conexion.php');

$correo = $_POST['correo'];
$contrasena = $_POST['contrasena'];

$sql=("CALL sp_login('".$correo."','".$contrasena."')");
$result = mysqli_query($conn,$sql);
$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
if($row){
    foreach($row as $columna => $valor){
        $_SESSION[$columna] = $valor;
    }
    $_SESSION['loggedin'] = true;
    echo $_SESSION['Tipo'];
}else{
    echo "0";
}


?>