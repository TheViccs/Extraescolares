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
    <title>Unidades Responsables</title>
    <?php include "../../../views/layout/imports.php" ?>

</head>
<style>
    * {
        font-size: 1rem;
    }



    .botones2 {
        display: flex;
        width: 80%;
        height: 20%;
        align-items: center;
        justify-content: end;
        min-height: 60px;
        min-width: fit-content;
    }

    .cabecera {
        display: flex;
        margin-top: 2%;
        justify-content: center;
        height: 15%;
        width: 100%;
        min-height: 60px;
        min-width: fit-content;
    }

    .cabecera a {
        height: 100%;
        margin-left: auto;
        margin-right: 5%;
        justify-self: end;
    }

    .cancelar {
        margin-left: 2%;
    }

    .contenedor-inputs2 {
        display: flex;
        justify-content: space-around;
        align-items: center;
        min-height: fit-content;
        width: 100%;
    }

    .contenedor-inputs3 {
        display: flex;
        width: 50%;
        flex-wrap: wrap;
        justify-content: space-around;
        align-items: center;
        min-height: fit-content;
    }

    .contenedor-tabla {
        display: flex;
        justify-content: center;
        margin-bottom: 2%;
        width: 100%;
        box-sizing: contenedor-tabla;
    }


    .contenido2 {
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        min-width: fit-content;
    }

    .label1 {
        grid-area: label_clave_unidades;
        text-align: center;
    }

    .input1 {
        grid-area: input_clave_unidades;
    }

    .label2 {
        grid-area: label_correo_unidades;
        text-align: center;
    }

    .input2 {
        grid-area: input_correo_unidades;
    }

    .label3 {
        grid-area: label_nombre_unidades;
        text-align: center;
    }

    .input3 {
        grid-area: input_nombre_unidades;
    }

    .label4 {
        grid-area: label_ubicacion_unidades;
        text-align: center;
    }

    .input4 {
        grid-area: input_ubicacion_unidades;
    }

    .label5 {
        grid-area: label_extension_unidades;
        text-align: center;
    }

    .input5 {
        grid-area: input_extension_unidades;
    }

    .label6 {
        grid-area: label_jefe_unidades;
        text-align: center;
    }

    .input6 {
        grid-area: input_jefe_unidades;
    }

    .btn6 {
        grid-area: btn_jefe_unidades;
    }

    .cuadro1 {
        padding: 1rem;
        display: grid;
        height: auto;
        flex-shrink: 0;
        width: 80%;
        border: 1px solid black;
        border-radius: 5px;
        min-height: 20%;
        min-width: fit-content;
        grid-gap: 2rem;
        grid-template-columns: repeat(8, .3fr);
        grid-template-areas:
            /*Inputs y labels*/
            "label_clave_unidades input_clave_unidades input_clave_unidades input_clave_unidades label_correo_unidades input_correo_unidades input_correo_unidades input_correo_unidades"
            "label_nombre_unidades input_nombre_unidades input_nombre_unidades input_nombre_unidades input_nombre_unidades input_nombre_unidades input_nombre_unidades input_nombre_unidades"
            "label_ubicacion_unidades input_ubicacion_unidades input_ubicacion_unidades input_ubicacion_unidades label_extension_unidades input_extension_unidades input_extension_unidades input_extension_unidades"
            "label_jefe_unidades label_jefe_unidades input_jefe_unidades input_jefe_unidades input_jefe_unidades input_jefe_unidades input_jefe_unidades btn_jefe_unidades"

    }

    .flecha {
        width: 10%;
        height: 100%;
        min-width: 30px;
        max-height: 30px;
    }

    .footer {
        width: auto;
        min-width: fit-content;
        margin-top: auto;
        justify-self: end;
    }

    .header {
        width: auto;
        min-width: fit-content;
    }

    input {
        height: 2rem;
    }

    label {
        height: 2rem;
    }

    .titulo {
        justify-self: center;
        margin-left: auto;
    }
</style>

<body>

    <div class="contenido2">
        <?php include "../../../views/layout/header.php" ?>
        <!-- ALERTAS -->
        <?php include "../../../views/layout/alertas.php" ?>
        <div class="cabecera">
            <h1 class="titulo">Gestión de Unidades Responsables</h1>
            <a href="http://localhost/Extraescolares/views/modules/admin/administrador.php"><img class="flecha" src="../../.././assets/img/back.png"></a>
        </div>
        <div class="cuadro1">

            <!--Primer regnglon de  divs clave y correo-->

            <input id="input_id_departamento" type="text" hidden />
            <label class="label1">Clave: </label>
            <input class="input1" id="input_clave_departamento" placeholder="Clave" type="text" required />

            <label class="label2">Email</label>
            <div class="input2">
              <input id="input_correo_departamento" type="email" placeholder="Email">  
              <p style="width: 100%; height: 20%;  font-size: 8px; margin-bottom: -100%;">Solo agregue el nombre de usuario</p>
            </div>


            <!--Segundo rengolón de divs Nombre-->
            <label class="label3">Nombre</label>
            <input class="input3" id="input_nombre_departamento" placeholder="Nombre" type="text" required />


            <!--Tercer rengolón de divs extensión y Ubcación -->
            <label class="label4">Ubicación</label>
            <input class="input4" id="input_ubicacion_departamento" placeholder="Ubicación" type="text" required />
            <label class="label5">Extensión</label>
            <input class="input5" id="input_extension_departamento" placeholder="Extensión" type="text" required />

            <!--Cuerto rengolón de divs Jefe de departamento -->
            <label class="label6">Jefe de Departamento:</label>
            <input class="input6" id="input_select_responsables" placeholder="Seleccione al jefe" type="text" list="select_responsables" />
            <datalist id="select_responsables" style="width: 45% !important;">
            </datalist>
            <button class="btn6 btn btn-dark" data-bs-toggle="modal" data-bs-target="#modal_responsable">+</button>

        </div>
        <div class="botones2">
            <button class="btn btn-success" id="boton_insert_update_departamento" onclick="insert_departamento()">Guardar</button>
            <button class="btn btn-danger cancelar" onclick="borrar_datos_input_departamento()">Cancelar</button>
        </div>

        <div class="contenedor-tabla content-table">
            <table id="tabla_departamentos"></table>
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
                                <input id="input_correo_responsable" class="w-50" type="text" />


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

        <?php include "../../../views/layout/footer.php" ?>
    </div>
    <script src="../../../js/departamentos.js"></script>
</body>

</html>