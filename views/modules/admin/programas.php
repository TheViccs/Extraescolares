<?php
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['Tipo']!="administrador"){
    header('Location: ../../layout/login/index.php');
}
?>



<!-- FORMULARIO 
                        
                            
                            
                        
                            <label class="text-center">Descripción</label>
                            <textarea id="input_descripcion_programa" placeholder="Inserte una descripción" type="text" required></textarea>
                        
                            <label class="text-center" >Observaciones</label>
                            <textarea id="input_observaciones_programa"  placeholder="Observaciones" type="text" required></textarea>
                       
                            <label class="text-center" >Departamentos</label>
                            <select multiple="multiple" id="select_programas">
                            </select>
                        -->

<!-- BOTONES GUARDAR Y CANCELAR 
                <button id="boton_insert_update_programa" class="btn btn-success" onclick="insert_programa()" >Guardar</button>
                <button class="btn btn-danger" onclick="borrar_datos_input_programa()">Cancelar</button>
            </div>-->








<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport">
    <title>Interfaz</title>
    <?php include "../../../views/layout/imports.php" ?>
</head>
<style>
* {
    font-size: 1rem;
}

html {
    height: 100%;
    width: 100%;
    margin: 0%;
    padding: 0%;
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
    width: 80%;
    border: 1px solid black;
    
}

.contenido2 {
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    min-width: fit-content;
}

.label1 {
    grid-area: label_clave_programa;
    text-align: center;
}

.input1 {
    grid-area: input_clave_programa;
}

.label2 {
    grid-area: label_nombre_programa;
    text-align: center;
}

.input2 {
    grid-area: input_nombre_programa;
}

.label3 {
    grid-area: label_des_programa;
    text-align: center;
}

.input3 {
    grid-area: input_des_programa;
}

.label4 {
    grid-area: label_obs_programa;
    text-align: center;
}

.input4 {
    grid-area: input_obs_programa;
}

.label5 {
    grid-area: label_dep_programa;
    text-align: center;
}

.input5 {
    grid-area: input_dep_programa;
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
        "label_clave_programa input_clave_programa label_nombre_programa input_nombre_programa input_nombre_programa input_nombre_programa input_nombre_programa input_nombre_programa"
        "label_des_programa input_des_programa input_des_programa input_des_programa label_obs_programa input_obs_programa input_obs_programa input_obs_programa"
        "label_dep_programa input_dep_programa input_dep_programa input_dep_programa input_dep_programa input_dep_programa input_dep_programa input_dep_programa"
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
        <?php include "../../../views/layout/alertas.php" ?>

        <div class="cabecera">
            <h1 class="titulo">Gestionar Programas</h1>
            <a href="http://localhost/Extraescolares/views/modules/admin/administrador.php"><img class="flecha"
                    src="../../.././assets/img/back.png"></a>
        </div>
        <div class="cuadro1">

            <input id="input_id_programa" type="text" hidden />
            <label class="label1">Clave</label>
            <input class="input1" id="input_clave_programa" placeholder="Clave" type="text" required />

            <label class="label2">Nombre</label>
            <input class="input2" id="input_nombre_programa" placeholder="Nombre" type="text" required />

            <label class="label3">Descripción</label>
            <textarea class="input3" id="input_descripcion_programa" placeholder="Inserte una descripción" type="text" required></textarea>

            <label class="label4" >Observaciones</label>
            <textarea class="input4" id="input_observaciones_programa"  placeholder="Observaciones" type="text" required></textarea>

            <label class="label5" >Departamentos</label>
            <div class="input5">
                <select   multiple="multiple" id="select_programas"></select>

            </div>
            



        </div>

        <!-- MODAL BORRAR PROGRAMA--> 
    <div class="modal fade" id="modal_programa" tabindex="-1" aria-labelledby="modal_programa_label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_programa_label">Borrar programa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="w-100">
                        <h3>Seguro que quiere borrar el programa?</h1>
                        <p id="p_clave_programa"></p>
                        <p id="p_nombre_programa"></p>
                        <p id="p_descripcion_programa"></p>
                        <input id="input_id_programa_borrar" type="text" hidden/>
                    </div>        
                </div>
                <div class="modal-footer d-flex justify-content-evenly">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" onclick="borrar_programa()">Borrar</button>
                </div>
            </div>
        </div>
    </div>


        <div class="botones2">
            <button class="btn btn-success">Guardar</button>
            <button class="btn btn-danger cancelar">Cancelar</button>
        </div>
        <div class="contenedor-tabla content-table">
            <table id="tabla_programas">

            </table>

        </div>
        <?php include "../../../views/layout/footer.php" ?>
    </div>
    <script src="../../../lib/multiselect/js/jquery.multi-select.js"></script>
    <script src="../../../js/programas.js"></script>
</body>

</html>