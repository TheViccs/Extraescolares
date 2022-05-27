<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['Tipo'] != "responsable") {
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
    .label_clave_coordinador {
        grid-area: label_clave_coordi;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .input_clave_coordinador {
        grid-area: input_clave_coordi;
        width: 100%;
    }

    .label_nombre_coordinador {
        grid-area: label_nombre_coordi;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .input_nombre_coordinador {
        grid-area: input_nombre_coordi;
        width: 100%;
    }

    .label_apellido_p_coordinador {
        grid-area: label_apPaterno_coordi;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .input_apellido_p_coordinador {
        grid-area: input_apPaterno_coordi;
        width: 100%;
    }

    .label_apellido_m_coordinador {
        grid-area: label_apMaterno_coordi;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .input_apellido_m_coordinador {
        grid-area: input_apMaterno_coordi;
        width: 100%;
    }


    .label6 {
        grid-area: label_tel_coordi;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .input6 {
        grid-area: input_tel_coordi;
        width: 100%;
    }

    .label_sexo_coordinador {
        grid-area: label_sexo_coordi;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .input_sexo_coordinador {
        grid-area: input_sexo_coordi;
        width: 100%;
        height: 35px;
    }

    .contenedor_inputs_insercion {
        grid-template-columns: repeat(9, .3fr);
        grid-template-areas:
            "label_clave_coordi input_clave_coordi input_clave_coordi label_sexo_coordi input_sexo_coordi input_sexo_coordi label_nombre_coordi input_nombre_coordi input_nombre_coordi"
            "label_apPaterno_coordi label_apPaterno_coordi input_apPaterno_coordi input_apPaterno_coordi label_apMaterno_coordi label_apMaterno_coordi input_apMaterno_coordi input_apMaterno_coordi ."
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
            <h1 class="titulo">Gestionar Coordinadores</h1>
            <a href="http://localhost/Extraescolares/views/modules/responsable/responsable.php"><img class="flecha" src="../../.././assets/img/back.png"></a>
        </div>

        <!-- FORMULARIO PARA INSERCIÓN -->
        <div class="contenedor_inputs_insercion">

            <input id="input_id_programa_asignar" value="<?php if (!empty($_GET)) {
                                                                echo $_GET["programa"];
                                                            } ?>" hidden />
            <input id="input_id_departamento" value="<?php echo $_SESSION['id_departamento'] ?>" hidden />
            <input id="input_id_coordinador" type="text" hidden />

            <label class="label_clave_coordinador">Clave:</label>
            <input class="input_clave_coordinador" id="input_clave_coordinador" type="text" placeholder="Clave">

            <label class="label_nombre_coordinador">Nombre:</label>
            <input class="input_nombre_coordinador" id="input_nombre_coordinador" type="Nombre" placeholder="Nombre">

            <label class="label_apellido_p_coordinador">Apellido Paterno:</label>
            <input class="input_apellido_p_coordinador" id="input_apellido_p_coordinador" type="ApellidoP" placeholder="Apellido Paterno">

            <label class="label_apellido_m_coordinador">Apellido Materno:</label>
            <input class="input_apellido_m_coordinador" id="input_apellido_m_coordinador" type="ApellidoM" placeholder="Apellido Materno" required="false">

            <label class="label_sexo_coordinador">Sexo:</label>
            <select class="input_sexo_coordinador" id="select_sexo_coordinador">
                <option value="O" disabled selected>Elige...</option>
                <option value="M">Masculino</option>
                <option value="F">Femenino</option>
            </select>
        </div>

        <!-- BOTONES INSERCION -->
        <div class="contenedor_botones_insercion">
            <button class="btn btn-success" onclick="insert_coordinador()">Guardar</button>
            <button class="btn btn-danger cancelar" onclick="borrar_datos_input_coordinador()">Cancelar</button>
        </div>

        <!-- TABLA CONTENIDO -->
        <div class="contenedor_tabla_insercion">
            <table id="tabla_coordinadores">

            </table>
        </div>

        <!-- FOOTER -->
        <?php include "../../../views/layout/footer.php" ?>
    </div>

    <!-- MODAL BORRAR COORDINADOR -->
    <div class="modal fade" id="modal_borrar_coordinador" tabindex="-1" aria-labelledby="modal_borrar_coordinador-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_borrar_coordinador-label">Borrar Coordinador</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="w-100">
                        <h3>Seguro que quiere borrar al coordinador?</h1>
                            <p id="p_clave_coordinador"></p>
                            <p id="p_nombre_coordinador"></p>
                            <p id="p_sexo_coordinador"></p>
                            <p id="p_correo_coordinador"></p>
                            <input id="input_id_coordinador_borrar" type="text" hidden />
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-evenly">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" onclick="borrar_coordinador()">Borrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL ASIGNAR COORDINADOR A PROGRAMA-->
    <div class="modal fade" id="modal_asignar_coordinador" tabindex="-1" aria-labelledby="modal_asignar_coordinador-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_asignar_coordinador-label">Asignar Coordinador</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="w-100 d-flex flex-column align-items-center">
                        <h3>Seguro que quiere asignar al coordinador?</h1>
                            <p id="p_clave_coordinador_asignar"></p>
                            <p id="p_nombre_coordinador_asignar"></p>
                            <p id="p_sexo_coordinador_asignar"></p>
                            <p id="p_correo_coordinador_asignar"></p>
                            <label>Fecha de inicio del coordinador</label>
                            <input id="input_fecha_inicio_coordinador_programa" type="date" style="width:50% !important" />
                            <input id="input_asignar_id_coordinador" type="text" hidden />
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-evenly">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-secondary" onclick="asignar_responsable()">Asignar</button>
                </div>
            </div>
        </div>
    </div>
    <script src="../../../js/coordinadores.js"></script>

</body>

</html>