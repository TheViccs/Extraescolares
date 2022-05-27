<?php
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['Tipo']!="responsable"){
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
        <div class="contenedor_principal_insercion">
            <!-- HEADER -->
            <?php include "../../../views/layout/header.php" ?>

            <!-- CABECERA -->
            <div class="cabecera">
                <h1 class="titulo">Programas</h1>
                <a href="http://localhost/Extraescolares/views/modules/responsable/responsable.php"><img class="flecha" src="../../.././assets/img/back.png"></a>
            </div>

            <!-- INPUT DEPARTAMENTO -->
            <input id="input_id_departamento" type="text" value="<?php echo $_SESSION['id_departamento'] ?>" hidden/>

            <!-- TABLA CONTENIDO -->
            <div class="contenedor_tabla_insercion">
                <table id="tabla_programas"></table>
            </div>

            <!-- FOOTER -->
            <?php include "../../../views/layout/footer.php" ?>
        </div>

        <script src="../../../js/programas_responsables.js"></script>

    </body>

    </html>