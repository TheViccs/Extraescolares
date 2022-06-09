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
<style>

    .label_dia_grupo{
        grid-area: label_dia_grupo;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .input_dia_grupo{
        grid-area: input_dia_grupo;
        height: 35px;
    }

    .label_hora_inicio_grupo{
        grid-area: label_hora_inicio_grupo;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .input_hora_inicio_grupo{
        grid-area: input_hora_inicio_grupo;
    }

    .label_hora_fin_grupo{
        grid-area: label_hora_fin_grupo;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .input_hora_fin_grupo{
        grid-area: input_hora_fin_grupo;
    }

    .contenedor_inputs_insercion {
        align-content: center;
        grid-template-columns: repeat(9, .3fr);
        grid-template-areas:
            "label_dia_grupo input_dia_grupo input_dia_grupo label_hora_inicio_grupo input_hora_inicio_grupo input_hora_inicio_grupo label_hora_fin_grupo input_hora_fin_grupo input_hora_fin_grupo"
        ;
    }
</style>

<body>
    <div class="contenedor_principal_insercion">

        <!-- HEADER -->
        <?php include "../../../views/layout/header.php" ?>

        <!-- ALERTAS -->
        <?php include "../../../views/layout/alertas.php" ?>

        <!-- CABECERA -->
        <div class="cabecera">
            <h1 class="titulo">Gestionar Horarios</h1>
            <a href="http://localhost/Extraescolares/views/modules/coordinador/coordinador.php"><img class="flecha" src="../../.././assets/img/back.png"></a>
        </div>

        <!-- FORMULARIO PARA INSERCIÓN -->
        <div class="contenedor_inputs_insercion">

            <input id="input_id_horario" type="text" hidden />
            <input id="input_id_grupo" type="text" value="<?php if (!empty($_GET)) {
                                                                echo $_GET["grupo"];
                                                            } ?>" hidden />
            <label class="label_dia_grupo">Día</label>
            <select class="input_dia_grupo" id="select_dia_grupo">
                <option value="O" disabled selected>Elige...</option>
                <option value="Lunes">Lunes</option>
                <option value="Martes">Martes</option>
                <option value="Miércoles">Miércoles</option>
                <option value="Jueves">Jueves</option>
                <option value="Viernes">Viernes</option>
                <option value="Sábado">Sábado</option>
            </select>

            <label class="label_hora_inicio_grupo">Hora de Inicio</label>
            <input class="input_hora_inicio_grupo" type="time" id="input_hora_inicio_grupo"/>

            <label class="label_hora_fin_grupo">Hora de Fin</label>
            <input class="input_hora_fin_grupo" type="time" id="input_hora_fin_grupo"/>

        </div>

        <!-- BOTONES INSERCION -->
        <div class="contenedor_botones_insercion">
            <button class="btn btn-success" id="boton_insert_update_horario" onclick="insert_horario()">Guardar</button>
            <button class="btn btn-danger cancelar" onclick="borrar_datos_input_horario()">Cancelar</button>
        </div>

        <!-- TABLA CONTENIDO -->
        <div class="contenedor_tabla_insercion">
            <table id="tabla_horarios"></table>
        </div>

        <!-- FOOTER -->
        <?php include "../../../views/layout/footer.php" ?>
    </div>

    <!-- MODAL BORRAR HORARIO -->
    <div class="modal fade" id="modal_borrar_horario" tabindex="-1" aria-labelledby="modal_borrar_horario-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_borrar_horario-label">Borrar Instructor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="w-100">
                        <h3>Seguro que quiere borrar al horario?</h1>
                            <p id="p_dia_horario"></p>
                            <p id="p_hora_inicio_horario"></p>
                            <p id="p_hora_fin_horario"></p>
                            <input id="input_id_horario_borrar" type="text" hidden />
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-evenly">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" onclick="borrar_horario()">Borrar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="../../../js/horarios_coordinador.js"></script>

</body>

</html>