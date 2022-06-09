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
    .label_clave_responsable {
        grid-area: label_clave_resposable;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .input_clave_responsable {
        grid-area: input_clave_resposable;
    }

    .label_nombre_responsable {
        grid-area: label_nombre_resposable;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .input_nombre_responsable {
        grid-area: input_nombre_resposable;
    }

    .label_apellido_p_responsable {
        grid-area: label_apPaterno_resposable;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .input_apellido_p_responsable {
        grid-area: input_apPaterno_resposable;
    }

    .label_apellido_m_responsable {
        grid-area: label_apMaterno_resposable;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .input_apellido_m_responsable {
        grid-area: input_apMaterno_resposable;
    }

    .label_correo_responsable {
        grid-area: label_email_resposable;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .input_correo_responsable {
        grid-area: input_email_resposable;
        width: 100%;
        display: flex;
        flex-direction: column;
    }

    .label_sexo_responsable {
        grid-area: label_sexo_responsable;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .input_sexo_responsable {
        grid-area: input_sexo_resposable;
        height: 35px;
    }

    .contenedor_inputs_insercion {
        grid-template-columns: repeat(6, .3fr);
        grid-template-areas:
            "label_clave_resposable input_clave_resposable label_email_resposable input_email_resposable label_sexo_responsable input_sexo_resposable"
            "label_nombre_resposable input_nombre_resposable label_apPaterno_resposable input_apPaterno_resposable label_apMaterno_resposable input_apMaterno_resposable"
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
            <h1 class="titulo">Gestionar Responsables</h1>
            <a href="http://localhost/Extraescolares/views/modules/admin/administrador.php"><img class="flecha" src="../../.././assets/img/back.png"></a>
        </div>

        <!-- FORMULARIO PARA INSERCIÓN -->
        <div class="contenedor_inputs_insercion">

            <input id="input_id_responsable" type="text" hidden />
            <label class="label_clave_responsable">Clave</label>
            <input class="input_clave_responsable" id="input_clave_responsable" type="text" placeholder="Clave">

            <label class="label_nombre_responsable">Nombre</label>
            <input class="input_nombre_responsable" id="input_nombre_responsable" type="Nombre" placeholder="Nombre">

            <label class="label_apellido_p_responsable">Apellido Paterno</label>
            <input class="input_apellido_p_responsable" id="input_apellido_p_responsable" type="ApellidoP" placeholder="Apellido Paterno">

            <label class="label_apellido_m_responsable">Apellido Materno</label>
            <input class="input_apellido_m_responsable" id="input_apellido_m_responsable" type="ApellidoM" placeholder="Apellido Materno" required="false">

            <label class="label_correo_responsable">Email</label>
            <div class="input_correo_responsable contenedor_correo_descripcion">
                <input id="input_correo_responsable" type="email" placeholder="Email">
                <p class="descripcion_insercion_correo">Solo agregue el nombre de usuario</p>
            </div>

            <label class="label_sexo_responsable">Sexo</label>
            <select class="input_sexo_responsable" id="select_sexo_responsable">
                <option value="O" disabled selected>Elige...</option>
                <option value="M">Masculino</option>
                <option value="F">Femenino</option>
            </select>

        </div>

        <!-- BOTONES INSERCION -->
        <div class="contenedor_botones_insercion">
            <button id="boton_insert_update_responsable" class="btn btn-success" onclick="insert_responsable()">Guardar</button>
            <button class="btn btn-danger cancelar" onclick="borrar_datos_input_responsable()">Cancelar</button>
        </div>

        <!-- TABLA CONTENIDO -->
        <div class="contenedor_tabla_insercion">
            <table id="tabla-responsables"></table>
        </div>

        <!-- FOOTER -->
        <?php include "../../../views/layout/footer.php" ?>
    </div>

    <!-- MODAL BORRAR RESPONSABLE -->
    <div class="modal fade" id="modal-responsable" tabindex="-1" aria-labelledby="modal-responsable-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-responsable-label">Borrar Responsabele de Departamento
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="w-100">
                        <h3>Seguro que quiere borrar al Responsable?</h1>
                            <p id="p_clave_resposable"></p>
                            <p id="p_nombre_resposable"></p>
                            <p id="p_sexo_resposable"></p>
                            <p id="p_correo_resposable"></p>
                            <input id="input_id_responsable_borrar" type="text" hidden />
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-evenly">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" onclick="borrar_responsable()">Borrar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="../../../js/responsables_admin.js"></script>

</body>

</html>