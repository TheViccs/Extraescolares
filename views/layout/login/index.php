<?php 
session_start();
if(isset($_SESSION['loggedin'])){
    if($_SESSION['Tipo']=="administrador"){
        header('Location: ../../modules/admin/administrador.php');
    }else if($_SESSION['Tipo']=="responsable"){
        header('Location: ../../modules/responsable/responsable.php');
    }else if($_SESSION['Tipo']=="coordinador"){
        header('Location: ../../modules/coordinador/coordinador.php');
    }else if($_SESSION['Tipo']=="alumno"){
        header('Location: ../../modules/alumno/alumno.php');
    }else if($_SESSION['Tipo']=="instructor"){
        header('Location: ../../modules/instructores/home.php');
    }
}else{
    header('Location: ../../layout/login/inicio_sesion.php');
}
?>