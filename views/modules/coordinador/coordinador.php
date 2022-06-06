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
                        <a href="./agregar_estudiante.php"><img class="icono" src="https://cdn-icons.flaticon.com/png/512/863/premium/863864.png?token=exp=1654521857~hmac=be1e22b20f3a7d2b222893f4fc2578d0" /><span>Gestionar Instructores</span></a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- FOOTER -->
        <?php include "../../../views/layout/footer.php" ?>
    </div>
</body>

</html>