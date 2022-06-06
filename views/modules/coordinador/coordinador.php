<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['Tipo'] != "coordinador") {
    header('Location: ../../layout/login/index.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SiGAC</title>

    <!-- IMPORTS -->
    <?php include "../../../views/layout/imports.php" ?>

</head>

<body>

    <div class="contenedor_principal_menu">

        <!-- HEADER -->
        <?php include "../../../views/layout/header.php" ?>
        
        <!-- CONTENT -->
        <div class="contendor_menu_principal">
            <div class="menu">
                <ul class="contenedor_menu">
                    <li>
                        <a href="./actividades.php"><img class="icono" src="https://cdn-icons-png.flaticon.com/512/4850/4850929.png" /><span>Gestionar Actividades</span></a>
                    </li>
                    <li>
                        <a href="./instructores.php"><img class="icono" src="https://cdn-icons-png.flaticon.com/512/3410/3410674.png" /><span>Gestionar Instructores</span></a>
                    </li>
                    <li>
                        <a href="./agregar_estudiante.php"><img class="icono" src="https://cdn-icons.flaticon.com/png/512/3631/premium/3631618.png?token=exp=1654526989~hmac=14c9d0a6e4564d6ff83d6ec63b103485" /><span>Gestionar Instructores</span></a>
                    </li>
                    <li>
                        <a href="./constnacias.php"><img class="icono" src="https://cdn-icons-png.flaticon.com/512/1358/1358533.png" /><span>Generar constnacias</span></a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- FOOTER -->
        <?php include "../../../views/layout/footer.php" ?>
    </div>
</body>

</html>