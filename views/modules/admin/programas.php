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
    <meta name="viewport">
    <title>SiGAC</title>
    <?php include "../../../views/layout/imports.php" ?>
</head>
<style>
    .label_clave_programa {
        grid-area: label_clave_programa;
        text-align: center;
    }

    .input_clave_programa {
        grid-area: input_clave_programa;
    }

    .label_nombre_programa {
        grid-area: label_nombre_programa;
        text-align: center;
    }

    .input_nombre_programa {
        grid-area: input_nombre_programa;
    }

    .label_descripcion_programa {
        grid-area: label_des_programa;
        text-align: center;
    }

    .input_descripcion_programa {
        grid-area: input_des_programa;
    }

    .label_observaciones_programa {
        grid-area: label_obs_programa;
        text-align: center;
    }

    .input_observaciones_programa {
        grid-area: input_obs_programa;
    }

    .label_departamentos_programa {
        grid-area: label_dep_programa;
        text-align: center;
    }

    .input_departamento_programa {
        grid-area: input_dep_programa;
    }

    .contenedor_inputs_insercion {
        grid-template-columns: repeat(8, .3fr);
        grid-template-areas:
            "label_clave_programa input_clave_programa label_nombre_programa input_nombre_programa input_nombre_programa input_nombre_programa input_nombre_programa input_nombre_programa"
            "label_des_programa input_des_programa input_des_programa input_des_programa input_des_programa input_des_programa input_des_programa input_des_programa"
            "label_obs_programa input_obs_programa input_obs_programa input_obs_programa input_obs_programa input_obs_programa input_obs_programa input_obs_programa"
            "label_dep_programa input_dep_programa input_dep_programa input_dep_programa input_dep_programa input_dep_programa input_dep_programa input_dep_programa"
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
            <h1 class="titulo">Gestionar Programas</h1>
            <a href="http://localhost/Extraescolares/views/modules/admin/administrador.php"><img class="flecha" src="../../.././assets/img/back.png"></a>
        </div>

        <!-- FORMULARIO PARA INSERCIÓN -->
        <div class="contenedor_inputs_insercion">

            <input id="input_id_programa" type="text" hidden />
            <label class="label_clave_programa">Clave</label>
            <input class="input_clave_programa" id="input_clave_programa" placeholder="Clave" type="text" required />

            <label class="label_nombre_programa">Nombre</label>
            <input class="input_nombre_programa" id="input_nombre_programa" placeholder="Nombre" type="text" required />

            <label class="label_descripcion_programa">Descripción</label>
            <textarea class="input_descripcion_programa" id="input_descripcion_programa" placeholder="Inserte una descripción" type="text" required></textarea>

            <label class="label_observaciones_programa">Observaciones</label>
            <textarea class="input_observaciones_programa" id="input_observaciones_programa" placeholder="Observaciones" type="text" required></textarea>

            <label class="label_departamentos_programa">Departamentos</label>
            <div class="input_departamento_programa">
                <select multiple="multiple" id="select_programas"></select>
            </div>

        </div>

        <!-- BOTONES INSERCION -->
        <div class="contenedor_botones_insercion">
            <button class="btn btn-success" id="boton_insert_update_programa" onclick="insert_programa()">Guardar</button>
            <button class="btn btn-danger cancelar" onclick="borrar_datos_input_programa()">Cancelar</button>
        </div>

        <!-- TABLA CONTENIDO -->
        <div class="contenedor_tabla_insercion">
            <table id="tabla_programas"></table>
        </div>

        <!-- FOOTER -->
        <?php include "../../../views/layout/footer.php" ?>
    </div>

    <!-- MODAL BORRAR PROGRAMA -->
    <div class="modal fade" id="modal_programa" tabindex="-1" aria-labelledby="modal_programa_label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_programa_label">Borrar programa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="w-100">
                        <h3>Seguro que quiere borrar el programa?</h1>
                            <p id="p_clave_programa"></p>
                            <p id="p_nombre_programa"></p>
                            <p id="p_descripcion_programa"></p>
                            <P id="p_observaciones_programa"></P>
                            <input id="input_id_programa_borrar" type="text" hidden />
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-evenly">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" onclick="borrar_programa()">Borrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL CORREO DEPARTAMENTO PROGRAMA -->
    <div class="modal fade" id="modal_departamentos" tabindex="-1" aria-labelledby="modal_departamentos_label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_departamentos_label">Agregar correos a programa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="w-100">
                        <h6>Ingrese el correo para cada unidad</h1>
                            <div id="inputs_correo_departamento">

                            </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-evenly">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-success" id="insert_programa_departamento_correos" onclick="insert_programa_departamento_correos()">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="../../../lib/multiselect/js/jquery.multi-select.js"></script>
    <script src="../../../js/programas_admin.js"></script>

</body>

</html>