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
            <a href="http://localhost/Extraescolares/views/modules/admin/administrador.php"><img class="flecha"
                    src="../../.././assets/img/back.png"></a>
        </div>
        <div class="cuadro1">

            <!--Primer regnglon de  divs clave y correo-->

            <input id="input_id_departamento" type="text" hidden />
            <label class="label1">Clave: </label>
            <input class="input1" id="input_clave_departamento" placeholder="Clave" type="text" required />

            <label class="label2">Correo</label>
            <input class="input2" id="input_correo_departamento" placeholder="Correo" type="text" required />

            <!--Segundo rengolón de divs Nombre-->
            <label class="label3">Nombre</label>
            <input class="input3" id="input_nombre_departamento" placeholder="Nombre" type="text" required />


            <!--Tercer rengolón de divs extensión y Ubcación -->
            <label class="label4">Ubicación</label>
            <input class="input4" id="input_ubicacion_departamento" placeholder="Ubicación" type="text" required />
            <label class="label5">Extensión</label>
            <input class="input5" id="input_extension_departamento" placeholder="Extensión" type="text" required
                required />

            <!--Cuerto rengolón de divs Jefe de departamento -->
                    <label class="label6">Jefe de Departamento:</label>
                    <input class="input6" id="input_select_responsables" placeholder="Seleccione al jefe" type="text"
                        list="select_responsables" />
                    <datalist id="select_responsables" style="width: 45% !important;">
                    </datalist>
                    <button class="btn6 btn btn-dark" data-bs-toggle="modal" data-bs-target="#modal_responsable">+</button>
            
        </div>
        <div class="botones2">
            <button class="btn btn-success" id="boton_insert_update_departamento"
                onclick="insert_departamento()">Guardar</button>
            <button class="btn btn-danger cancelar" onclick="borrar_datos_input_departamento()">Cancelar</button>
        </div>

        <div class="contenedor-tabla content-table">
            <table id="tabla_departamentos"></table>
        </div>


        <?php include "../../../views/layout/footer.php" ?>
    </div>
    <script src="../../../js/departamentos.js"></script>
</body>
</html>