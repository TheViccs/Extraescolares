<?php
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['Tipo']!="administrador"){
    header('Location: ../../layout/login/index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport">
    <title>Extraescolares</title>
    <?php include "../../../views/layout/imports.php" ?>
</head>
<body>
    <div class="contenido2">
        <?php include "../../../views/layout/header.php" ?>
        <div class="cabecera">
            <h1 class="titulo">Gestión de Responsables</h1>
            <a href="#"><img class="flecha"  src="../../.././assets/img/back.png"></a>
        </div>
        <div class="cuadro1">
            <input id="input_id_responsable" type="text" hidden />
            <label class="label_clave_responsable">Clave</label>
            <input id="input_clave_responsable" class="input_clave_responsable" type="text" placeholder="Clave">
            <label class="label_nombre_responsable">Nombre</label>
            <input id="input_nombre_responsable" class="input_nombre_responsable" type="text" placeholder="Nombre">
            <label class="label_apellido_p_responsable">Apellido Paterno</label>
            <input id="input_apellido_p_responsable" class="input_apellido_p_responsable" type="text" placeholder="Apellido Paterno">
            <label class="label_apellido_m_responsable">Apellido Materno</label>
            <input id="input_apellido_m_responsable" class="input_apellido_m_responsable" type="text" placeholder="Apellido Materno" required>
            <label class="label_correo_responsable">Email</label>
            <input id="input_correo_responsable" class="input_correo_responsable" type="email" placeholder="Email">
            <label class="label_sexo_responsable">Sexo</label>
            <select id="select_sexo_responsable" class="select_sexo_responsable">
                <option value="O" disabled selected>Elige...</option>
                <option value="M">Masculino</option>
                <option value="F">Femenino</option>
            </select>
        </div>
        <div class="botones2">
            <button id="boton_insert_update_responsable" class="btn btn-success" onclick="insert_responsable()">Guardar</button>
            <button class="btn btn-danger" onclick="borrar_datos_input_responsable()">Cancelar</button>
        </div>
        <div class="contenedor-tabla content-table">
            <table id="tabla-responsables">

            </table>
        </div>
        <?php include "../../../views/layout/footer.php" ?>
    </div>

    <div class="modal fade" id="modal-responsable" tabindex="-1" aria-labelledby="modal-responsable-label"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-responsable-label">Borrar Responsabele de Departamento</h5>
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
    <script src="../../../js/responsables.js"></script>
</body>
</html>