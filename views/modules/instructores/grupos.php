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
    <meta name="viewport">
    <title>SiGAC</title>
    <?php include "../../../views/layout/imports.php" ?>
</head>
<style>

</style>

<body>

    <div class="contenedor_principal_insercion">
        <!-- HEADER -->
        <?php include "../../../views/layout/header.php" ?>

        <!-- ALERTAS -->
        <?php include "../../../views/layout/alertas.php" ?>

        <!-- CABECERA -->
        <div class="cabecera">
            <h1 class="titulo">Mis Grupos</h1>
            <a href="./instructor.php"><img class="flecha" src="../../.././assets/img/back.png"></a>
        </div>

        <input id="id_instructor" value="<?php echo $_SESSION["id_instructor"] ?>" hidden/>

        <!-- TABLA CONTENIDO -->
        <div class="contenedor_tabla_insercion">
            <table id="tabla_grupos"></table>
        </div>

        <!-- FOOTER -->
        <?php include "../../../views/layout/footer.php" ?>

    </div>

    <script src="../../../js/grupos_instructor.js"></script>

</body>

</html>