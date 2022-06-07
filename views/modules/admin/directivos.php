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
    <title>SiGAC</title>

    <!-- IMPORTS -->
    <?php include "../../../views/layout/imports.php" ?>

</head>
<style>
    .label_nombre_directivo {
        grid-area: label_nombre_directivo;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .input_nombre_directivo {
        grid-area: input_nombre_directivo;
    }

    .label_apellido_m_directivo {
        grid-area: label_apellidoM_directivo;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .input_apellido_m_directivo {
        grid-area: input_apellidoM_directivo;
    }

    .label_apellido_p_directivo {
        grid-area: label_apellidop_directivo;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .input_apellido_p_directivo {
        grid-area: input_apellidop_directivo;
    }

    .label_clave_directivo {
        grid-area: label_clave_directivo;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .input_clave_directivo {
        grid-area: input_clave_directivo;
    }

    .label_correo_directivo {
        grid-area: label_email_directivo;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .input_correo_directivo {
        grid-area: input_email_directivo;
    }

    .label_sexo_directivo {
        grid-area: label_sexo_directivo;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .input_sexo_directivo {
        grid-area: input_sexo_directivo;
        height: 35px;
    }

    .contenedor_inputs_insercion {
        grid-template-columns: repeat(6, .3fr);
        grid-template-areas:
            "label_nombre_directivo input_nombre_directivo label_apellidop_directivo input_apellidop_directivo label_apellidoM_directivo input_apellidoM_directivo"
            "label_clave_directivo input_clave_directivo label_email_directivo input_email_directivo label_sexo_directivo input_sexo_directivo"
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
            <h1 class="titulo">Gestionar directivos</h1>
            <a href="http://localhost/Extraescolares/views/modules/coordinador/coordinador.php"><img class="flecha" src="../../.././assets/img/back.png"></a>
        </div>

        <!-- FORMULARIO PARA INSERCIÓN -->
        <div class="contenedor_inputs_insercion">

            <input id="input_id_directivo" type="text" hidden />

            <label class="label_nombre_directivo">Nombre</label>
            <input class="input_nombre_directivo" id="input_nombre_directivo" type="Nombre" placeholder="Nombre">

            <label class="label_apellido_p_directivo">Apellido Paterno</label>
            <input class="input_apellido_p_directivo" id="input_apellido_p_directivo" type="text" placeholder="Apellido Paterno">

            <label class="label_apellido_m_directivo">Apellido Materno</label>
            <input class="input_apellido_m_directivo" id="input_apellido_m_directivo" type="text" placeholder="Apellido Materno" required="false">

            <label class="label_clave_directivo">Clave</label>
            <input class="input_clave_directivo" id="input_clave_directivo" type="text" placeholder="Clave" required="false">

            <label class="label_correo_directivo">Email</label>
            <div class="input_correo_directivo contenedor_correo_descripcion">
                <input id="input_correo_directivo" type="email" placeholder="Email">
                <p class="descripcion_insercion_correo">Solo agregue el nombre de usuario</p>
            </div>

            <label class="label_sexo_directivo">Sexo</label>
            <select class="input_sexo_directivo" id="select_sexo_directivo">
                <option value="O" disabled selected>Elige...</option>
                <option value="M">Masculino</option>
                <option value="F">Femenino</option>
            </select>

        </div>

        <!-- BOTONES INSERCION -->
        <div class="contenedor_botones_insercion">
            <button class="btn btn-success" id="boton_insert_update_directivo" onclick="insert_directivo()">Guardar</button>
            <button class="btn btn-danger cancelar" onclick="borrar_datos_input_directivo()">Cancelar</button>
        </div>

        <!-- TABLA CONTENIDO -->
        <div class="contenedor_tabla_insercion">
            <table id="tabla-directivos"></table>
        </div>

        <!-- FOOTER -->
        <?php include "../../../views/layout/footer.php" ?>
    </div>

    <!-- MODAL BORRAR directivo -->
    <div class="modal fade" id="modal-directivo" tabindex="-1" aria-labelledby="modal-directivo-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-directivo-label">Borrar directivo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="w-100">
                        <h3>Seguro que quiere borrar al directivo?</h1>
                            <p id="p_clave_directivo"></p>
                            <p id="p_nombre_directivo"></p>
                            <p id="p_sexo_directivo"></p>
                            <p id="p_correo_directivo"></p>
                            <input id="input_id_directivo_borrar" type="text" hidden />
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-evenly">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" onclick="borrar_directivo()">Borrar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="../../../js/directivos.js"></script>

</body>

</html>