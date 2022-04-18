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
    <title>Responsables</title>
    <?php include "../../../views/layout/imports.php" ?>
</head>

<style>
* {
    font-size: 1rem;
}

html {
    height: 100vh;
    width: 100vw;
}

body {
    height: 100%;
    width: 100%;
    display: flex;
    flex-direction: column;
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
}

.contenido2 {
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    min-width: fit-content;
}

.label1 {
    grid-area: label_clave_resposable;
    text-align: center;
}

.input1 {
    grid-area: input_clave_resposable;
}

.label2 {
    grid-area: label_nombre_resposable;
    text-align: center;
}

.input2 {
    grid-area: input_nombre_resposable;
}

.label3 {
    grid-area: label_apPaterno_resposable;
    text-align: center;
}

.input3 {
    grid-area: input_apPaterno_resposable;
}

.label4 {
    grid-area: label_apMaterno_resposable;
    text-align: center;
}

.input4 {
    grid-area: input_apMaterno_resposable;
}

.label5 {
    grid-area: label_email_resposable;
    text-align: center;
}

.input5 {
    grid-area: input_email_resposable;
}

.label6 {
    grid-area: label_sexo_resposable;
    text-align: center;
}

.input6 {
    grid-area: input_sexo_resposable;
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
    grid-template-columns: repeat(9, .3fr);
    grid-template-areas:
        "label_clave_resposable input_clave_resposable input_clave_resposable input_clave_resposable input_clave_resposable input_clave_resposable input_clave_resposable input_clave_resposable input_clave_resposable"
        "label_nombre_resposable label_nombre_resposable input_nombre_resposable label_apPaterno_resposable label_apPaterno_resposable input_apPaterno_resposable label_apMaterno_resposable label_apMaterno_resposable input_apMaterno_resposable"
        "label_email_resposable  input_email_resposable input_email_resposable input_email_resposable input_email_resposable input_email_resposable input_email_resposable input_email_resposable input_email_resposable"
        "label_sexo_resposable input_sexo_resposable input_sexo_resposable input_sexo_resposable input_sexo_resposable input_sexo_resposable input_sexo_resposable input_sexo_resposable input_sexo_resposable"
    ;
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
            <h1 class="titulo">Gestionar Responsables</h1>
            <a href="http://localhost/Extraescolares/views/modules/admin/administrador.php"><img class="flecha"
                    src="../../.././assets/img/back.png"></a>
        </div>
        <div class="cuadro1">
            
            <input id="input_id_responsable" type="text" hidden />
            <label class="label1">Clave</label>
            <input class="input1" id="input_clave_responsable" type="text" placeholder="Clave">

            <label class="label2">Nombre</label>
            <input class="input2" id="input_nombre_responsable" type="Nombre" placeholder="Nombre">

            <label class="label3">Apellido Paterno</label>
            <input class="input3" id="input_apellido_p_responsable" type="ApellidoP" placeholder="Apellido Paterno">

            <label class="label4">Apellido Materno</label>
            <input class="input4" id="input_apellido_m_responsable" type="ApellidoM" placeholder="Apellido Materno"
                required="false">

            <label class="label5">Email</label>
            <input class="input5" id="input_correo_responsable" type="email" placeholder="Email">

            <label class="label6">Sexo</label>
            <select class="input6" id="select_sexo_responsable">
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

        <div class="modal fade" id="modal-responsable" tabindex="-1" aria-labelledby="modal-responsable-label"
                aria-hidden="true">
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
        <?php include "../../../views/layout/footer.php" ?>
    </div>
    <script src="../../../js/responsables.js"></script>
</body>
</html>