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
    <div class="contenedor_principal_insercion">

        <!-- HEADER -->
        <?php include "../../../views/layout/header.php" ?>

        <!-- ALERTAS -->
        <?php include "../../../views/layout/alertas.php" ?>

        <!-- CABECERA -->
        <div class="cabecera">
            <h1 class="titulo">Gestionar Alumnos de Actividad</h1>
            <a href="./coordinador.php"><img class="flecha" src="../../.././assets/img/back.png"></a>
        </div>

        <input id="input_id_programa" type="text" value=<?php echo $_SESSION['id_programa'] ?> hidden />
        
        <div class="contenedor_tabla_insercion">
            <table id="tabla_actividades"></table>
        </div>
                

        <!-- FOOTER -->
        <?php include "../../../views/layout/footer.php" ?>
    </div>

</body>

<script src="../../../js/coordinador_actividades.js"></script>

</html>