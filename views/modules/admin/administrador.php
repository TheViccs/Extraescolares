<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['Tipo'] != "administrador") {
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

        <!-- MENÚ DE ADMINISTRADOR -->
        <div class="contendor_menu_principal">
            <div class="menu">
                <ul class="contenedor_menu">
                    <li>
                        <a href="./periodos.php"><img class="icono" src="https://cdn-icons-png.flaticon.com/512/2370/2370264.png" /><span>Gestionar Periodos</span></a>
                    </li>
                    <li>
                        <a href="./departamentos.php"><img class="icono" src="https://cdn-icons-png.flaticon.com/512/921/921296.png" /><span>Gestionar Unidades Responsables</span></a>
                    </li>
                    <li>
                        <a href="./responsables.php"><img class="icono" src="https://cdn-icons-png.flaticon.com/512/4395/4395348.png" /><span>Gestionar Responsables</span></a>
                    </li>
                    <li>
                        <a href="./programas.php"><img class="icono" src="https://cdn-icons-png.flaticon.com/512/1032/1032432.png" /><span>Gestionar Programas</span></a>
                    </li>
                    <li>
                        <a href="./directivos.php"><img class="icono" src="https://cdn-icons-png.flaticon.com/512/2666/2666404.png" /><span>Gestionar Directivos</span></a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- FOOTER -->
        <?php include "../../../views/layout/footer.php" ?>
    </div>
</body>

</html>