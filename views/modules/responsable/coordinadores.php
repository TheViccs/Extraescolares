<?php
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['Tipo']!="responsable"){
    header('Location: ../../layout/login/index.php');
}
?>


<!-- IMPORTS -->
<?php include "../../../views/layout/imports.php" ?>









<!-- ALERTAS -->
<?php include "../../../views/layout/alertas.php" ?>

<!--

            <input id="input_id_programa_asignar" value="<?php if(!empty($_GET)){echo $_GET["programa"];} ?>" hidden/>
            <input id="input_id_responsable" value="<?php echo $_SESSION['id_responsable'] ?>" hidden/>
            
           
        -->            


<!-- TABLA
            
                


        

        </div>-->
<!--
       
        
  
    -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport">
    <title>Coordinadores</title>
    <?php include "../../../views/layout/imports.php" ?>
</head>
<style>
* {
    font-size: 1rem;
}

html {
    height: 100%;
    width: 100%;
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

.dataTable {
    overflow-x: auto !important;
}

.contenido2 {
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    min-width: fit-content;
}

.label1 {
    grid-area: label_clave_coordi;
    text-align: center;
}

.input1 {
    grid-area: input_clave_coordi;
}

.label2 {
    grid-area: label_nombre_coordi;
    text-align: center;
}

.input2 {
    grid-area: input_nombre_coordi;
}

.label3 {
    grid-area: label_apPaterno_coordi;
    text-align: center;
}

.input3 {
    grid-area: input_apPaterno_coordi;
}

.label4 {
    grid-area: label_apMaterno_coordi;
    text-align: center;
}

.input4 {
    grid-area: input_apMaterno_coordi;
}

.label5 {
    grid-area: label_email_coordi;
    text-align: center;
}

.input5 {
    grid-area: input_email_coordi;
}

.label6 {
    grid-area: label_tel_coordi;
    text-align: center;
}

.input6 {
    grid-area: input_tel_coordi;
}

.label7 {
    grid-area: label_sexo_coordi;
    text-align: center;
}

.input7 {
    grid-area: input_sexo_coordi;
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
        "label_clave_coordi input_clave_coordi input_clave_coordi input_clave_coordi input_clave_coordi input_clave_coordi input_clave_coordi input_clave_coordi input_clave_coordi"
        "label_nombre_coordi input_nombre_coordi input_nombre_coordi label_apPaterno_coordi label_apPaterno_coordi input_apPaterno_coordi label_apMaterno_coordi label_apMaterno_coordi input_apMaterno_coordi"
        "label_email_coordi input_email_coordi input_email_coordi label_tel_coordi input_tel_coordi input_tel_coordi label_sexo_coordi input_sexo_coordi input_sexo_coordi"
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
        <div class="cabecera">
            <h1 class="titulo">Gestionar Coordinadores</h1>
            <a href="http://localhost/Extraescolares/views/modules/responsable/responsable.php"><img class="flecha" src="../../.././assets/img/back.png"></a>
        </div>
        <div class="cuadro1">

            <input id="input_id_programa_asignar" value="<?php if(!empty($_GET)){echo $_GET["programa"];} ?>" hidden />
            <input id="input_id_responsable" value="<?php echo $_SESSION['id_responsable'] ?>" hidden />
            <input id="input_id_coordinador" type="text" hidden />

            <label class="lable1">Clave:</label>
            <input class="input1" id="input_clave_coordinador" type="text" placeholder="Clave">

            <label class="label2">Nombre:</label>
            <input class="input2" id="input_nombre_coordinador" type="Nombre" placeholder="Nombre">

            <label class="label3">Apellido Paterno:</label>
            <input class="input3" id="input_apellido_p_coordinador" type="ApellidoP" placeholder="Apellido Paterno">

            <label class="label4">Apellido Materno:</label>
            <input class="input4" id="input_apellido_m_coordinador" type="ApellidoM" placeholder="Apellido Materno"
                required="false">
            
            <label class="label5">Email:</label>
            <input class="input5" id="input_correo_coordinador" type="email" placeholder="Email">

            <label class="label6">Telefono:</label>
            <input class="input6" id="input_contacto_coordinador" placeholder="Telefono" type="text" required />

            <label class="label7">Sexo:</label>
            <select class="input7" id="select_sexo_responsable">
                <option value="O" disabled selected>Elige...</option>
                <option value="M">Masculino</option>
                <option value="F">Femenino</option>
            </select>



        </div>
        <div class="botones2">
            <button class="btn btn-success" onclick="insert_coordinador()">Guardar</button>
            <button class="btn btn-danger cancelar" onclick="borrar_datos_input_coordinador()">Cancelar</button>

            
        </div>
        <div class="contenedor-tabla content-table">
            <table id="tabla_coordinadores">

            </table>
        </div>

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
                            <input id="input_id_coordinador_borrar" type="text" hidden/>
                        </div>        
                    </div>
                    <div class="modal-footer d-flex justify-content-evenly">
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-danger" onclick="borrar_coordinador()">Borrar</button>               
                    </div>
                </div>
            </div>   
        </div>

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
                            <label>Correo del programa</label>
                            <input id="input_correo_coordinador_programa" type="text" style="width:50%"/><br>
                            <label>Fecha de inicio del coordinador</label>
                            <input id="input_fecha_inicio_coordinador_programa" type="date" style="width:50% !important"/>                       
                            <input id="input_asignar_id_coordinador" type="text" hidden/>
                        </div>        
                    </div>
                    <div class="modal-footer d-flex justify-content-evenly">
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-secondary" onclick="asignar_responsable()">Asignar</button>               
                    </div>
                </div>
            </div>   
        </div>
        <?php include "../../../views/layout/footer.php" ?>
    </div>
    <script src="../../../js/coordinadores.js"></script>

</body>

</html>