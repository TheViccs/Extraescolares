<?php
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['Tipo']!="alumno"){
    header('Location: ../../layout/login/index.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport">
    <title>Interfaz</title>
    <?php include "../../../views/layout/imports.php" ?>
</head>
<body>
    
<div class="content h-100 w-100 d-flex flex-column bg-white">
        
        <!-- HEADER -->
        <?php include "../../../views/layout/header.php" ?>
        <?php include "../../../views/layout/alertas.php" ?>
        <!-- CONTENT -->    
        <div class="d-flex flex-column align-items-center bg-white" style="width: 100% !important; min-height: calc(100% - 137px) !important; overflow-y:auto; margin-top: 20px;"> 
            <div class="menu h-100 p-3">
                <ul class="contenedor-menu w-90 h-100 text-center">
                    <li>
                        <a href="http://localhost/Extraescolares/views/modules/alumno/grupos.php"><img class="icono" style="width: 50px; height: 50px;" src="https://cdn-icons-png.flaticon.com/512/1198/1198416.png"/><span>Actividades</span></a>
                    </li>
                    <li>
                        <a href="#"><img class="icono" style="width: 50px; height: 50px;" src="https://cdn-icons.flaticon.com/png/512/3290/premium/3290158.png?token=exp=1653598130~hmac=2d806e939d479bbf3e9ab0db8328d26c"/><span>Kardex</span></a>
                    </li>
                    <li>
                        <a href="http://localhost/Extraescolares/views/modules/alumno/carga.php"><img class="icono" style="width: 50px; height: 50px;" src="https://cdn-icons-png.flaticon.com/512/1092/1092004.png"/><span>Descargar Carga</span></a>
                    </li>

                </ul>
            </div>
        </div>

        <!-- FOOTER -->
       <?php include "../../../views/layout/footer.php" ?>
    </div>
    
</body>
</html>