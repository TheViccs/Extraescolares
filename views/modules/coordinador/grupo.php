<?php
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['Tipo']!="coordinador"){
    header('Location: ../../layout/login/index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport">
    <title>instructores</title>
    <?php include "../../../views/layout/imports.php" ?>
</head>
<style>
    *{
        font-size: 1rem;
    }

    html{
        height: 100%;
        width: 100%;
    }

    body{
        height: 100%;
        width: 100%;
        display: flex;
        flex-direction: column;
    }

    .botones2{
        display: flex;
        width: 80%;
        height: 20%;
        align-items: center;
        justify-content: end;
        min-height: 60px;
        min-width: fit-content;
    }

    .cabecera{
        display: flex;
        margin-top: 2%;
        justify-content: center;
        height: 15%;
        width: 100%;
        min-height: 60px;
        min-width: fit-content;
    }

    .cabecera a{
        height: 100%;
        margin-left: auto;
        margin-right: 5%;
        justify-self: end;
    }

    .cancelar{
        margin-left: 2%;
    }

    .contenedor-inputs2{
        display: flex;
        justify-content: space-around;
        align-items: center;
        min-height: fit-content;
        width: 100%;
    }

    .contenedor-inputs3{
        display: flex;
        width: 50%;
        flex-wrap: wrap;
        justify-content: space-around;
        align-items: center;
        min-height: fit-content;
    }

    .contenedor-tabla{
        display: flex;
        justify-content: center;
        margin-bottom: 2%;
        width: 80%;
        border: 1px solid black;
    }

    .dataTable{
        overflow-x: auto !important;
    }

    .contenido2{
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        min-width: fit-content;
    }

    
    .label1{
        grid-area: label_nombre_grupo;
        text-align: center;
    }

    .input1{
        grid-area: input_nombre_grupo;
    }

    .label2{
        grid-area: label_capacidadMin_grupo;
        text-align: center;
    }

    .input2{
        grid-area: input_capacidadMin_grupo;
    }

    .label3{
        grid-area: label_capacidadMax_grupo;
        text-align: center;
    }

    .input3{
        grid-area: input_capacidadMax_grupo;
    }

    

    .label4{
        grid-area: label_total_grupo;
        text-align: center;
    }

    .input4{
        grid-area: input_total_grupo;
    }

    

    .cuadro1{
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
        grid-template-columns: repeat(8,.3fr);
        grid-template-areas: 
            ""
            ""
            ;
    }

    .flecha{
        width: 10%;
        height: 100%;
        min-width: 30px;
        max-height: 30px;
    }

    .footer{
        width: auto;
        min-width: fit-content;
        margin-top: auto;
        justify-self: end;
    }

    .header{
        width: auto;
        min-width: fit-content;
    }

    input{
        height: 2rem;
    }

    label{
        height: 2rem;
    }

    .titulo{
        justify-self: center;
        margin-left: auto;
    }

</style>
<body>
    
    <div class="contenido2">
    <?php include "../../../views/layout/header.php" ?>
        <div class="cabecera">
            <h1 class="titulo">Gestionar instructores</h1>
            <a href="#"><img class="flecha"  src="../../.././assets/img/back.png"></a>
        </div>
        <div class="cuadro1">
            
            <input id="input_id_grupo" type="text" hidden />
            
            <label class="label1">Nombre</label>
            <input class="input1" id="input_nombre_grupo" type="Nombre" placeholder="Nombre">
                           
            <label class="label2">Capacidad Minima</label>
            <input class="input2" id="input_cMin_grupo" type="capacidadMinima" placeholder="Capacidad Minima">
                           
            <label class="label3">Capacidad Maxima</label>
            <input class="input3" id="input_cMax_grupo" type="capacidadMaxima" placeholder="Capacidad Maxima">
                            
            <label class="label4">Total de Inscipciones</label>
            <input class="input4" id="input_inscrip_grupo" type="inscripciones" placeholder="Numero de inscripciones">
                            

            


        </div>
        <div class="botones2">
            <button class="btn btn-success" onclick="">Guardar</button>
            <button class="btn btn-danger cancelar" onclick="">Cancelar</button>
        </div>
        <div class="contenedor-tabla content-table">

        </div>

        <div class="modal fade" id="modal-instructor" tabindex="-1" aria-labelledby="modal-instructor-label"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-instructor-label">Borrar Responsabele de Departamento</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <div class="w-100">
                            <h1>Seguro que quiere borrar al instructor?</h1>
                                <p id="p_clave_instructor"></p>
                                <p id="p_nombre_instructor"></p>
                                <p id="p_sexo_instructor"></p>
                                <p id="p_correo_instructor"></p>
                                <input id="input_id_instructor_borrar" type="text" hidden />
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-evenly">
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-danger" onclick="borrar_responsable()">Borrar</button>
                    </div>
                </div>
            </div>
        <?php include "../../../views/layout/footer.php" ?>
    </div>
    
</body>
</html>