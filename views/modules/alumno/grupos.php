<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['Tipo'] != "alumno") {
    header('Location: ../../layout/login/index.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Extraescolares</title>

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
            <h1 class="titulo">Programas</h1>
            <a href="alumno.php"><img class="flecha" src="../../.././assets/img/back.png"></a>
        </div>

        <!-- CONTENT -->
        <input id="id_alumno" value="<?php echo $_SESSION['id_alumno'] ?>" hidden />
        <div class="main" id="contenedor_programas">


        </div>

        <!-- FOOTER -->
        <?php include "../../../views/layout/footer.php" ?>

    </div>

    <!-- MODAL INSERTAR INSTRUCTOR -->
    <div class="modal fade" id="modal_confirmacion_registro" tabindex="-1" aria-labelledby="modal_confirmacion_registro-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_confirmacion_registro-label">Registrarse a Actividad</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="w-100 d-flex flex-column align-items-center">
                        <p>¿Realmente deseas registarte en esta actividad?<br>
                           Una vez inscrito no podrás quitar tu registro
                    </p>
                    <input id="id_actividad_inscribirse" hidden/>
                    <input id="id_grupo_inscribirse" hidden/>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-evenly">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-success" onclick="registrarse()">Registrarse</button>
                </div>
            </div>
        </div>
    </div>

    <script src="../../../js/registro_actividades_alumno.js"></script>

</body>

</html>
