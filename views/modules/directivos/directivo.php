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
                    <p><?php echo $_SESSION['id_directivo'] ?></p>
                    <li>
                        <a href=""><img class="icono" src="https://cdn-icons-png.flaticon.com/512/944/944053.png" /><span>Reportes</span></a>
                    </li>
                    
                </ul>
            </div>
        </div>

        <!-- FOOTER -->
        <?php include "../../../views/layout/footer.php" ?>
    </div>
</body>

</html>