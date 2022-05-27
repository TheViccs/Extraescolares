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
    <title>Grupos</title>

    <!-- IMPORTS -->
    <?php include "../../../views/layout/imports.php" ?>

</head>
<style>
    .label_nombre_grupo {
        grid-area: label_nombre_grupo;
        text-align: center;
    }

    .input_nombre_grupo {
        grid-area: input_nombre_grupo;
    }

    .label_capacidad_min_grupo {
        grid-area: label_capacidadMin_grupo;
        text-align: center;
    }

    .input_capacidad_min_grupo {
        grid-area: input_capacidadMin_grupo;
    }

    .label_capacidad_max_grupo {
        grid-area: label_capacidadMax_grupo;
        text-align: center;
    }

    .input_capacidad_max_grupo {
        grid-area: input_capacidadMax_grupo;
    }

    .label_instructor_grupo {
        grid-area: label_instructor_grupo;
        text-align: center;
    }

    .input_intructor_grupo {
        grid-area: input_instructor_grupo;
    }

    .btn_agregar_instructor {
        grid-area: btn_instructor_grupo;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 33px;
    }

    .label_caracteristica_grupo {
        grid-area: label_caracteristica_grupo;
        text-align: center;
    }

    .input_caracteristica_grupo {
        grid-area: input_caracteristica_grupo;
    }

    .btn_agregar_caracteristica_grupo {
        grid-area: btn_caracteristica_grupo;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 33px;
    }

    .label_lugar_grupo {
        grid-area: label_lugar_grupo;
        text-align: center;
    }

    .input_lugar_grupo {
        grid-area: input_lugar_grupo;
    }

    .btn_agregar_lugar_grupo {
        grid-area: btn_lugar_grupo;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 33px;
    }

    .contenedor_inputs_insercion {
        grid-template-columns: repeat(9, .3fr);
        align-content: center;
        align-items: center;
        grid-template-areas:
            "label_nombre_grupo input_nombre_grupo input_nombre_grupo label_capacidadMin_grupo input_capacidadMin_grupo input_capacidadMin_grupo label_capacidadMax_grupo input_capacidadMax_grupo input_capacidadMax_grupo"
            "label_instructor_grupo input_instructor_grupo input_instructor_grupo input_instructor_grupo input_instructor_grupo input_instructor_grupo input_instructor_grupo input_instructor_grupo btn_instructor_grupo"
            "label_caracteristica_grupo input_caracteristica_grupo input_caracteristica_grupo btn_caracteristica_grupo . label_lugar_grupo input_lugar_grupo input_lugar_grupo btn_lugar_grupo";
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
            <h1 class="titulo">Gestionar grupos</h1>
            <a href="http://localhost/Extraescolares/views/modules/coordinador/coordinador.php"><img class="flecha" src="../../.././assets/img/back.png"></a>
        </div>

        <!-- FORMULARIO PARA INSERCIÓN -->
        <div class="contenedor_inputs_insercion">
            <input id="input_id_departamento" type="text" value="<?php echo $_SESSION['id_departamento'] ?>" hidden />
            <input id="input_id_actividad" type="text" value="<?php if (!empty($_GET)) {
                                                                    echo $_GET["actividad"];
                                                                } ?>" hidden />
            <input id="input_id_grupo" type="text" hidden />
            <label class="label_nombre_grupo">Nombre</label>
            <input class="input_nombre_grupo" id="input_nombre_grupo" type="Nombre" placeholder="Nombre">

            <label class="label_capacidad_min_grupo">Capacidad Minima</label>
            <input class="input_capacidad_min_grupo" type="number" id="input_cMin_grupo" type="capacidadMinima" placeholder="Capacidad Minima">

            <label class="label_capacidad_max_grupo">Capacidad Maxima</label>
            <input class="input_capacidad_max_grupo" type="number" id="input_cMax_grupo" type="capacidadMaxima" placeholder="Capacidad Maxima">

            <label class="label_instructor_grupo">Instructor</label>
            <input class="input_intructor_grupo form-control" id="input_instructor_grupo" type="text" placeholder="Instructor" list="select_instructores">
            <datalist id="select_instructores" style="width: 45% !important;"> </datalist>
            <button class="btn_agregar_instructor btn btn-dark" data-bs-toggle="modal" data-bs-target="#modal_instructor">+</button>

            <label class="label_caracteristica_grupo">Característica</label>
            <input class="input_caracteristica_grupo form-control" id="input_caracteristica_grupo" type="text" placeholder="Característica" list="select_caracteristicas">
            <datalist id="select_caracteristicas" style="width: 45% !important;"> </datalist>
            <button class="btn_agregar_caracteristica_grupo btn btn-dark" data-bs-toggle="modal" data-bs-target="#modal_caracteristica">+</button>

            <label class="label_lugar_grupo">Lugar</label>
            <input class="input_lugar_grupo form-control" id="input_lugar_grupo" type="text" placeholder="Lugar" list="select_lugares">
            <datalist id="select_lugares" style="width: 45% !important;"> </datalist>
            <button class="btn_agregar_lugar_grupo btn btn-dark" data-bs-toggle="modal" data-bs-target="#modal_lugar">+</button>

        </div>

        <!-- BOTONES INSERCION -->
        <div class="contenedor_botones_insercion">
            <button id="boton_insert_update_grupo" class="btn btn-success" onclick="insert_grupo()">Guardar</button>
            <button class="btn btn-danger cancelar" onclick="borrar_datos_input_grupo()">Cancelar</button>
        </div>


        <!-- TABLA CONTENIDO -->
        <div class="contenedor_tabla_insercion">
            <table id="tabla_grupos"></table>
        </div>

        <!-- FOOTER -->
        <?php include "../../../views/layout/footer.php" ?>

    </div>

    <!-- MODAL BORRAR GRUPO -->
    <div class="modal fade" id="modal_borrar_grupo" tabindex="-1" aria-labelledby="modal_borrar_grupo-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_borrar_grupo-label">Borrar Grupo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="w-100">
                        <h1>Seguro que quiere borrar al grupo?</h1>
                        <p id="p_nombre_grupo"></p>
                        <p id="p_caracteristica_grupo"></p>
                        <p id="p_total_inscripciones_grupo"></p>
                        <p id="p_instructor_grupo"></p>
                        <p id="p_lugar_grupo"></p>
                        <input id="input_id_grupo_borrar" type="text" hidden />
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-evenly">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" onclick="borrar_grupo()">Borrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL CARACTERISTICA GRUPO -->
    <div class="modal fade" id="modal_caracteristica" tabindex="-1" aria-labelledby="modal_caracteristica-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_caracteristica-label">Agregar Característica</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="w-100">
                        <div class="w-100 d-flex">
                            <label class="w-50">Nombre</label>
                            <input id="input_caracteristica_grupo_modal" class="w-50" type="text" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-evenly">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-success" onclick="insert_caracteristica()">Agregar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL LUGAR GRUPO -->
    <div class="modal fade" id="modal_lugar" tabindex="-1" aria-labelledby="modal_lugar-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_lugar-label">Agregar Lugar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="w-100">
                        <div class="w-100 d-flex">
                            <label class="w-50">Nombre</label>
                            <input id="input_lugar_grupo_modal" class="w-50" type="text" placeholder="Nombre" />
                        </div>
                        <br>
                        <div class="w-100 d-flex">
                            <label class="w-50">Capacidad Máxima</label>
                            <input id="input_capacidad_max_lugar_grupo_modal" class="w-50" type="number" placeholder="Capacidad Máxima" />
                        </div>
                        <br>
                        <div class="w-100 d-flex">
                            <label class="w-50">Observaciones</label>
                            <textarea id="input_observaciones_lugar_grupo_modal" class="w-50" placeholder="Observaciones"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-evenly">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-success" onclick="insert_lugar()">Agregar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL INSTRUCTOR GRUPO -->
    <div class="modal fade" id="modal_instructor" tabindex="-1" aria-labelledby="modal_instructor-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_instructor-label">Agregar Instructor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="w-100">
                        <div class="w-100 d-flex">
                            <label class="w-50">Nombre</label>
                            <input id="input_nombre_instructor_grupo_modal" class="w-50" type="text" placeholder="Nombre" />
                        </div>
                        <br>
                        <div class="w-100 d-flex">
                            <label class="w-50">Apellido Paterno</label>
                            <input id="input_apellido_p_instructor_grupo_modal" class="w-50" type="text" placeholder="Apellido Paterno" />
                        </div>
                        <br>
                        <div class="w-100 d-flex">
                            <label class="w-50">Apellido Materno</label>
                            <input id="input_apellido_m_instructor_grupo_modal" class="w-50" type="text" placeholder="Apellido Materno" />
                        </div>
                        <br>
                        <div class="w-100 d-flex">
                            <label class="w-50">Sexo</label>
                            <select class="input_sexo_instructor w-50" id="select_sexo_instructor_grupo_modal">
                                <option value="O" disabled selected>Elige...</option>
                                <option value="M">Masculino</option>
                                <option value="F">Femenino</option>
                            </select>
                        </div>
                        <br>
                        <div class="w-100 d-flex">
                            <label class="w-50">Fecha Inicio</label>
                            <input id="input_fecha_inicio_instructor_grupo_modal" class="w-50" type="date" placeholder="Fecha Inicio" />
                        </div>
                        <br>
                        <div class="w-100 d-flex">
                            <label class="w-50">Fecha Fin</label>
                            <input id="input_fecha_fin_instructor_grupo_modal" class="w-50" type="date" placeholder="Fecha Fin" />
                        </div>
                        <br>
                        <div class="w-100 d-flex">
                            <label class="w-50">Correo</label>
                            <div class="input_correo_instructor contenedor_correo_descripcion w-50">
                                <input id="input_correo_instructor_grupo_modal" type="email" placeholder="Email">
                                <p class="descripcion_insercion_correo">Solo agregue el nombre de usuario</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-evenly">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-success" onclick="insert_instructor()">Agregar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="../../../js/grupos.js"></script>

</body>

</html>