<?php
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['Tipo']!="coordinador"){
    header('Location: ../../layout/login/index.php');
}
?>
<!DOCTYPE html>
<html lang="en" class="vh-100 vw-100 m-0 bg-dark">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Extraescolares</title>
    
    <!-- IMPORTS -->
    <?php include "../../../views/layout/imports.php" ?>

</head>
<body class="d-flex m-0 h-100 w-100">  

    <div class="content h-100 w-100 d-flex flex-column bg-white">
        
        <!-- HEADER -->
        <?php include "../../../views/layout/header.php" ?>
        <?php include "../../../views/layout/alertas.php" ?>
        <!-- CONTENT -->    
        <div class="d-flex flex-column align-items-center bg-white" style="width: 100% !important; min-height: calc(100% - 137px) !important; overflow-y:auto; margin-top: 20px;"> 
            <div class="menu h-100 p-3">
                <ul class="contenedor-menu w-90 h-100 text-center">
                    <li>
                        <a href="./actividades.php"><img class="icono" style="width: 50px; height: 50px;" src="https://cdn-icons-png.flaticon.com/512/4850/4850929.png"/><span>Gestionar Actividades</span></a>
                    </li>
                    <li>
                        <a href="./instructores.php"><img class="icono" style="width: 50px; height: 50px;" src="https://cdn-icons-png.flaticon.com/512/3410/3410674.png"/><span>Gestionar Instructores</span></a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- FOOTER -->
       <?php include "../../../views/layout/footer.php" ?>
    </div>
</body>
</html>