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
            <h1 class="titulo">Eliminar Alumno de Grupo</h1>
            <a href="./actividades_gestionar_alumnos.php"><img class="flecha" src="../../.././assets/img/back.png"></a>
        </div>

        <input id="id_grupo" value="<?php if (!empty($_GET)) {
                                            echo $_GET["grupo"];
                                            } ?>" hidden/>
        <input id="id_actividad" value="<?php if (!empty($_GET)) {
                                            echo $_GET["actividad"];
                                            } ?>" hidden/>

        <!-- TABLA CONTENIDO -->
        <div class="contenedor_tabla_insercion">
            <table id="tabla_alumnos"></table>
        </div>

        <!-- FOOTER -->
        <?php include "../../../views/layout/footer.php" ?>

    </div>

    <!-- MODAL BORRAR ALUMNO -->
    <div class="modal fade" id="modal-alumno" tabindex="-1" aria-labelledby="modal-alumno-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-alumno-label">Borrar Alumno</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="w-100">
                        <h3>¿Seguro que quiere borrar al alumno del grupo?</h1>
                            <p id="p_nombre_alumno"></p>
                            <p id="p_carrera"></p>
                            <p id="p_semestre"></p>
                            <p id="p_correo_alumno"></p>
                            <input id="input_id_alumno_borrar" type="text" hidden/>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-evenly">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" onclick="borrar_alumno()">Borrar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="../../../js/coordinador_alumnos_borrar.js"></script>

</body>

</html>