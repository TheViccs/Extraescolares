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
    .label_nombre_instructor {
        grid-area: label_nombre_instructor;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .input_nombre_instructor {
        grid-area: input_nombre_instructor;
    }

    .label_apellido_m_instructor {
        grid-area: label_apellidoM_instructor;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .input_apellido_m_instructor {
        grid-area: input_apellidoM_instructor;
    }

    .label_apellido_p_instructor {
        grid-area: label_apellidop_instructor;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .input_apellido_p_instructor {
        grid-area: input_apellidop_instructor;
    }

    .label_correo_instructor {
        grid-area: label_email_instructor;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .input_correo_instructor {
        grid-area: input_email_instructor;
    }

    .label_sexo_instructor {
        grid-area: label_sexo_instructor;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .input_sexo_instructor {
        grid-area: input_sexo_instructor;
        height: 35px;
    }

    .contenedor_inputs_insercion {
        grid-template-columns: repeat(6, .3fr);
        grid-template-areas:
            "label_nombre_instructor input_nombre_instructor label_apellidop_instructor input_apellidop_instructor label_apellidoM_instructor input_apellidoM_instructor"
            "label_email_instructor input_email_instructor input_email_instructor label_sexo_instructor input_sexo_instructor ."
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
            <h1 class="titulo">Gestionar instructores</h1>
            <a href="http://localhost/Extraescolares/views/modules/coordinador/coordinador.php"><img class="flecha" src="../../.././assets/img/back.png"></a>
        </div>

        <!-- FORMULARIO PARA INSERCIÓN -->
        <div class="contenedor_inputs_insercion">

            <input id="input_id_departamento" type="text" value=<?php echo $_SESSION['id_departamento'] ?> hidden />
            <input id="input_id_instructor" type="text" hidden />

            <label class="label_nombre_instructor">Nombre</label>
            <input class="input_nombre_instructor" id="input_nombre_instructor" type="Nombre" placeholder="Nombre">

            <label class="label_apellido_p_instructor">Apellido Paterno</label>
            <input class="input_apellido_p_instructor" id="input_apellido_p_instructor" type="ApellidoP" placeholder="Apellido Paterno">

            <label class="label_apellido_m_instructor">Apellido Materno</label>
            <input class="input_apellido_m_instructor" id="input_apellido_m_instructor" type="ApellidoM" placeholder="Apellido Materno" required="false">

            <label class="label_correo_instructor">Email</label>
            <div class="input_correo_instructor contenedor_correo_descripcion">
                <input id="input_correo_instructor" type="email" placeholder="Email">
                <p class="descripcion_insercion_correo">Solo agregue el nombre de usuario</p>
            </div>

            <label class="label_sexo_instructor">Sexo</label>
            <select class="input_sexo_instructor" id="select_sexo_instructor">
                <option value="O" disabled selected>Elige...</option>
                <option value="M">Masculino</option>
                <option value="F">Femenino</option>
            </select>

        </div>

        <!-- BOTONES INSERCION -->
        <div class="contenedor_botones_insercion">
            <button class="btn btn-success" id="boton_insert_update_instructor" onclick="mostrar_modal_insertar_instructor()">Guardar</button>
            <button class="btn btn-danger cancelar" onclick="borrar_datos_input_instructor()">Cancelar</button>
        </div>

        <!-- TABLA CONTENIDO -->
        <div class="contenedor_tabla_insercion">
            <table id="tabla-instructores"></table>
        </div>

        <!-- FOOTER -->
        <?php include "../../../views/layout/footer.php" ?>
    </div>

    <!-- MODAL BORRAR INSTRUCTOR -->
    <div class="modal fade" id="modal-instructor" tabindex="-1" aria-labelledby="modal-instructor-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-instructor-label">Borrar Instructor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="w-100">
                        <h3>Seguro que quiere borrar al instructor?</h1>
                            <p id="p_clave_instructor"></p>
                            <p id="p_nombre_instructor"></p>
                            <p id="p_sexo_instructor"></p>
                            <p id="p_correo_instructor"></p>
                            <input id="input_id_instructor_borrar" type="text" hidden />
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-evenly">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" onclick="borrar_instructor()">Borrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL INSERTAR INSTRUCTOR -->
    <div class="modal fade" id="modal_insertar_instructor" tabindex="-1" aria-labelledby="modal_insertar_instructor-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_insertar_instructor-label">Insertar Instructor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="w-100 d-flex flex-column align-items-center">
                        <h3>Datos del instructor</h3>
                        <p id="p_clave_instructor_insertar"></p>
                        <p id="p_nombre_instructor_insertar"></p>
                        <p id="p_sexo_instructor_insertar"></p>
                        <p id="p_correo_instructor_insertar"></p>
                        <label>Fecha de inicio del instructor</label>
                        <input id="input_fecha_inicio_instructor" type="date" style="width:50% !important" />
                        <label>Fecha de fin del instructor</label>
                        <input id="input_fecha_fin_instructor" type="date" style="width:50% !important" />
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-evenly">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-secondary" onclick="insert_instructor()">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="../../../js/instructores.js"></script>

</body>

</html>