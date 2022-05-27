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

    <!-- IMPORTS -->
    <?php include "../../../views/layout/imports.php" ?>
    
</head>
<style>
    .label_clave_departamento {
        grid-area: label_clave_unidades;
        text-align: center;
    }

    .input_clave_departamento {
        grid-area: input_clave_unidades;
    }

    .label_correo_departamento {
        grid-area: label_correo_unidades;
        text-align: center;
    }

    .contenedor_input_correo_departamento {
        grid-area: input_correo_unidades;
    }

    .label_nombre_departamento {
        grid-area: label_nombre_unidades;
        text-align: center;
    }

    .input_nombre_departamento {
        grid-area: input_nombre_unidades;
    }

    .label_ubicacion_departamento {
        grid-area: label_ubicacion_unidades;
        text-align: center;
    }

    .input_ubicacion_departamento {
        grid-area: input_ubicacion_unidades;
    }

    .label_extension_departamento {
        grid-area: label_extension_unidades;
        text-align: center;
    }

    .input_extension_departamento {
        grid-area: input_extension_unidades;
    }

    .label_responsable_departamento {
        grid-area: label_jefe_unidades;
        text-align: center;
    }

    .input_responsable_departamento {
        grid-area: input_jefe_unidades;
    }

    .btn_insert_responsable_departamento {
        grid-area: btn_jefe_unidades;
    }

    .contenedor_inputs_insercion {
        grid-template-columns: repeat(8, .3fr);
        grid-template-areas:
            /*Inputs y labels*/
            "label_clave_unidades input_clave_unidades input_clave_unidades input_clave_unidades label_correo_unidades input_correo_unidades input_correo_unidades input_correo_unidades"
            "label_nombre_unidades input_nombre_unidades input_nombre_unidades input_nombre_unidades input_nombre_unidades input_nombre_unidades input_nombre_unidades input_nombre_unidades"
            "label_ubicacion_unidades input_ubicacion_unidades input_ubicacion_unidades input_ubicacion_unidades label_extension_unidades input_extension_unidades input_extension_unidades input_extension_unidades"
            "label_jefe_unidades label_jefe_unidades input_jefe_unidades input_jefe_unidades input_jefe_unidades input_jefe_unidades input_jefe_unidades btn_jefe_unidades";
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
            <h1 class="titulo">Gestión de Unidades Responsables</h1>
            <a href="http://localhost/Extraescolares/views/modules/admin/administrador.php"><img class="flecha" src="../../.././assets/img/back.png"></a>
        </div>

        <!-- FORMULARIO PARA INSERCIÓN -->
        <div class="contenedor_inputs_insercion">

            <!--Primer regnglon de  divs clave y correo-->
            <input id="input_id_departamento" type="text" hidden />
            <label class="label_clave_departamento">Clave: </label>
            <input class="input_clave_departamento" id="input_clave_departamento" placeholder="Clave" type="text" required />

            <label class="label_correo_departamento">Email</label>
            <div class="contenedor_input_correo_departamento contenedor_correo_descripcion">
                <input id="input_correo_departamento" type="email" placeholder="Email">
                <p class="descripcion_insercion_correo">Solo agregue el nombre de usuario</p>
            </div>

            <!--Segundo rengolón de divs Nombre-->
            <label class="label_nombre_departamento">Nombre</label>
            <input class="input_nombre_departamento" id="input_nombre_departamento" placeholder="Nombre" type="text" required />

            <!--Tercer rengolón de divs extensión y Ubcación -->
            <label class="label_ubicacion_departamento">Ubicación</label>
            <input class="input_ubicacion_departamento" id="input_ubicacion_departamento" placeholder="Ubicación" type="text" required />
            
            <label class="label_extension_departamento">Extensión</label>
            <input class="input_extension_departamento" id="input_extension_departamento" placeholder="Extensión" type="text" required />

            <!--Cuerto rengolón de divs Jefe de departamento -->
            <label class="label_responsable_departamento">Jefe de Departamento:</label>
            <input class="input_responsable_departamento" id="input_select_responsables" placeholder="Seleccione al jefe" type="text" list="select_responsables" />
            <datalist id="select_responsables" style="width: 45% !important;">
            </datalist>
            <button class="btn_insert_responsable_departamento btn btn-dark" data-bs-toggle="modal" data-bs-target="#modal_responsable">+</button>

        </div>

        <!-- BOTONES INSERCION -->
        <div class="contenedor_botones_insercion">
            <button class="btn btn-success" id="boton_insert_update_departamento" onclick="insert_departamento()">Guardar</button>
            <button class="btn btn-danger cancelar" onclick="borrar_datos_input_departamento()">Cancelar</button>
        </div>

        <!-- TABLA CONTENIDO -->
        <div class="contenedor_tabla_insercion">
            <table id="tabla_departamentos"></table>
        </div>

        <!-- FOOTER -->
        <?php include "../../../views/layout/footer.php" ?>
    </div>

    <!-- MODAL INSERTAR RESPONSABLE DE DEPARTAMENTO-->
    <div class="modal fade" id="modal_responsable" tabindex="-1" aria-labelledby="modal_responsable_label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_responsable_label">Agregar responsable de departamento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="w-100">
                        <div class="w-100 d-flex">
                            <label class="w-50">Clave</label>
                            <input id="input_clave_responsable" class="w-50" type="text" />
                        </div>
                        <br>
                        <div class="w-100 d-flex">
                            <label class="w-50">Nombre</label>
                            <input id="input_nombre_responsable" class="w-50" type="text" />
                        </div>
                        <br>
                        <div class="w-100 d-flex">
                            <label class="w-50">Apellido Paterno</label>
                            <input id="input_apellido_p_responsable" class="w-50" type="text" />
                        </div>
                        <br>
                        <div class="w-100 d-flex">
                            <label class="w-50">Apellido Materno</label>
                            <input id="input_apellido_m_responsable" class="w-50" type="text" />
                        </div>
                        <br>
                        <div class="w-100 d-flex">
                            <label class="w-50">Correo</label>
                            <div class="contenedor_correo_descripcion w-50">
                                <input id="input_correo_responsable" type="text" />
                                <p class="descripcion_insercion_correo">Solo agregue el nombre de usuario</p>
                            </div>

                        </div>
                        <br>
                        <div class="w-100 d-flex">
                            <label class="w-50">Sexo</label>
                            <select class="w-50" id="select_sexo_responsable">
                                <option value="O" disabled selected>Elige...</option>
                                <option value="M">Masculino</option>
                                <option value="F">Femenino</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="modal-footer d-flex justify-content-evenly">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="insert_responsable()">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL BORRAR DEPARTAMENTO -->
    <div class="modal fade" id="modal_departamento" tabindex="-1" aria-labelledby="modal_departamento_label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_departamento_label">Borrar departamento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="w-100">
                        <h3>Seguro que quiere borrar el departamento?</h1>
                            <p id="p_clave_departamento"></p>
                            <p id="p_nombre_departamento"></p>
                            <p id="p_ubicacion_departamento"></p>
                            <p id="p_extension_departamento"></p>
                            <p id="p_correo_departamento"></p>
                            <input id="input_id_departamento_borrar" type="text" hidden />
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-evenly">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" onclick="borrar_departamento()">Borrar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="../../../js/departamentos.js"></script>

</body>

</html>