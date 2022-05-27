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
        grid-template-areas:
            "label_nombre_grupo input_nombre_grupo input_nombre_grupo label_capacidadMin_grupo input_capacidadMin_grupo input_capacidadMin_grupo label_capacidadMax_grupo input_capacidadMax_grupo input_capacidadMax_grupo"
            "label_instructor_grupo input_instructor_grupo input_instructor_grupo input_instructor_grupo input_instructor_grupo input_instructor_grupo input_instructor_grupo input_instructor_grupo btn_instructor_grupo"
            "label_caracteristica_grupo input_caracteristica_grupo input_caracteristica_grupo btn_caracteristica_grupo label_lugar_grupo input_lugar_grupo input_lugar_grupo btn_lugar_grupo .";
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

            <input id="input_id_grupo" type="text" hidden />
            <label class="label_nombre_grupo">Nombre</label>
            <input class="input_nombre_grupo" id="input_nombre_grupo" type="Nombre" placeholder="Nombre">

            <label class="label_capacidad_min_grupo">Capacidad Minima</label>
            <input class="input_capacidad_min_grupo" type="number" id="input_cMin_grupo" type="capacidadMinima" placeholder="Capacidad Minima">

            <label class="label_capacidad_max_grupo">Capacidad Maxima</label>
            <input class="input_capacidad_max_grupo" type="number" id="input_cMax_grupo" type="capacidadMaxima" placeholder="Capacidad Maxima">

            <label class="label_instructor_grupo">Instructor</label>
            <input class="input_intructor_grupo form-control" id="input_padre_actividad" type="text" placeholder="Instructor" list="select_instructor">
            <datalist id="select_instructor" style="width: 45% !important;"> </datalist>
            <button class="btn_agregar_instructor btn btn-dark" data-bs-toggle="modal" data-bs-target="">+</button>

            <label class="label_caracteristica_grupo">Característica</label>
            <input class="input_caracteristica_grupo form-control" id="input_padre_actividad" type="text" placeholder="Característica" list="select_caracteristica">
            <datalist id="select_caracteristica" style="width: 45% !important;"> </datalist>
            <button class="btn_agregar_caracteristica_grupo btn btn-dark" data-bs-toggle="modal" data-bs-target="">+</button>

            <label class="label_lugar_grupo">Lugar</label>
            <input class="input_lugar_grupo form-control" id="input_padre_actividad" type="text" placeholder="Lugar" list="select_lugar">
            <datalist id="select_lugar" style="width: 45% !important;"> </datalist>
            <button class="btn_agregar_lugar_grupo btn btn-dark" data-bs-toggle="modal" data-bs-target="">+</button>

        </div>

        <!-- BOTONES INSERCION -->
        <div class="contenedor_botones_insercion">
            <button class="btn btn-success" onclick="">Guardar</button>
            <button class="btn btn-danger cancelar" onclick="">Cancelar</button>
        </div>


        <!-- TABLA CONTENIDO -->
        <div class="contenedor_tabla_insercion">

        </div>

        <!-- FOOTER -->
        <?php include "../../../views/layout/footer.php" ?>

    </div>

    <!-- MODAL BORRAR DEPARTAMENTO -->
    <div class="modal fade" id="modal-grupo" tabindex="-1" aria-labelledby="modal-grupo-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-grupo-label">Borrar Responsabele de Departamento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="w-100">
                        <h1>Seguro que quiere borrar al grupo?</h1>
                        <p id="p_clave_grupo"></p>
                        <p id="p_nombre_grupo"></p>
                        <p id="p_sexo_grupo"></p>
                        <p id="p_correo_grupo"></p>
                        <input id="input_id_grupo_borrar" type="text" hidden />
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-evenly">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" onclick="borrar_grupo()">Borrar</button>
                </div>
            </div>
        </div>
    </div>

</body>

</html>