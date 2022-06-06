<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['Tipo'] != "instructor") {
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
                        <a href="./grupos.php"><img class="icono" src="https://cdn-icons-png.flaticon.com/512/978/978012.png" /><span>Mis grupos</span></a>
                    </li>         
                </ul>
            </div>
        </div>

        <!-- FOOTER   -->
        <?php include "../../../views/layout/footer.php" ?>
    </div>
</body>

</html>