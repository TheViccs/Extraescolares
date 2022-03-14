<?php
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['Tipo']!="responsable"){
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

        <!-- CONTENT -->
        <div class="box d-flex flex-column align-items-center bg-white" style="width: 100% !important; min-height:calc(100% - 112px) !important; overflow-y:auto;">
            <input id="input_id_responsable" type="text" value="<?php echo $_SESSION['id_responsable'] ?>" hidden/>

            <!-- ALERTAS -->
            <?php include "../../../views/layout/alertas.php" ?>

            <!-- TITULO DE CONTENIDO -->
            <h1 class="mb-4 mt-2 text-center w-100">Mis Programas</h1>
            
            <!-- TABLA -->
            <div class="content-table d-flex justify-content-center mb-3" style="width: 90% !important;">
                <table id="tabla_programas">
                    
                </table>
            </div>
        </div>

        <!-- FOOTER -->
        <?php include "../../../views/layout/footer.php" ?>       
    </div>

    <script src="../../../js/programas_responsables.js"></script> 
</body>
</html>