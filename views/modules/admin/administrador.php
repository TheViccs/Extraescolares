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
<body class="h-100 w-100">  

    <div class="content m-0 h-100 w-100 d-flex flex-column bg-white" style="width: calc(100% - 280px);">
        
        <!-- HEADER -->
        <?php include "../../../views/layout/header.php" ?>

        <!-- CONTENT -->
        <div class="d-flex flex-column align-items-center bg-white" style="width: 100% !important; min-height: calc(100% - 112px) !important; overflow-y:auto;">
            <div class="menu w-50 h-50 p-3 ">
                <ul class="contenedor-menu w-90 h-100 text-center">
                    <li>
                        <a style="text-decoration: none;}" href="http://localhost/extraescolares/views/modules/admin/periodos.php">Gestionar Periodos</a>
                    </li>
                    <li>
                        <a style="text-decoration: none;}" href="http://localhost/extraescolares/views/modules/admin/departamentos.php">Gestionar Departamentos</a>
                    </li>
                    <li>
                        <a style="text-decoration: none;}" href="http://localhost/extraescolares/views/modules/admin/responsables.php">Gestionar Responsables</a>
                    </li>
                    <li>
                        <a style="text-decoration: none;}" href="http://localhost/extraescolares/views/modules/admin/programas.php">Gestionar Programas</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- FOOTER -->
       <?php include "../../../views/layout/footer.php" ?>
        
    </div>
    <script src="../../../js/departamentos.js"></script>
</body>

</html>