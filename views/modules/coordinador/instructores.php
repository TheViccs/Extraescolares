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
        grid-area: label_clave_instructor;
        text-align: center;
    }

    .input1{
        grid-area: input_clave_instructor;
    }

    .label2{
        grid-area: label_nombre_instructor;
        text-align: center;
    }

    .input2{
        grid-area: input_nombre_instructor;
    }

    .label3{
        grid-area: label_apellidoM_instructor;
        text-align: center;
    }

    .input3{
        grid-area: input_apellidoM_instructor;
    }

    .label4{
        grid-area: label_apellidop_instructor;
        text-align: center;
    }

    .input4{
        grid-area: input_apellidop_instructor;
    }

    .label5{
        grid-area: label_email_instructor;
        text-align: center;
    }

    .input5{
        grid-area: input_email_instructor;
    }

    .label6{
        grid-area: label_sexo_instructor;
        text-align: center;
    }

    .input6{
        grid-area: input_sexo_instructor;
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
        grid-template-columns: repeat(9,.3fr);
        grid-template-areas: 
            "label_clave_instructor input_clave_instructor input_clave_instructor input_clave_instructor input_clave_instructor input_clave_instructor input_clave_instructor input_clave_instructor input_clave_instructor"
            "label_nombre_instructor input_nombre_instructor input_nombre_instructor label_apellidoM_instructor input_apellidoM_instructor input_apellidoM_instructor label_apellidop_instructor input_apellidop_instructor input_apellidop_instructor"
            "label_email_instructor input_email_instructor input_email_instructor input_email_instructor input_email_instructor label_sexo_instructor  input_sexo_instructor input_sexo_instructor input_sexo_instructor"
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
            <a href="http://localhost/Extraescolares/views/modules/coordinador/coordinador.php"><img class="flecha"  src="../../.././assets/img/back.png"></a>
        </div>
        <div class="cuadro1">
            
            <input id="input_id_instructor" type="text" hidden />
            <label class="label1">Clave</label>
            <input class="input1" id="input_clave_instructor" type="text" placeholder="Clave">

            <label class="label2">Nombre</label>
            <input class="input2" id="input_nombre_instructor" type="Nombre" placeholder="Nombre">
                           
            <label class="label3">Apellido Paterno</label>
            <input class="input3" id="input_apellido_p_instructor" type="ApellidoP" placeholder="Apellido Paterno">
                           
            <label class="label4">Apellido Materno</label>
            <input class="input4" id="input_apellido_m_instructor" type="ApellidoM" placeholder="Apellido Materno" required="false">
                            
            <label class="label5">Email</label>
            <input class="input5" id="input_correo_instructor" type="email" placeholder="Email">
                            

            <label class="label6">Sexo</label>
            <select class="input6" id="select_sexo_instructor">
                <option value="O" disabled selected>Elige...</option>
                <option value="M">Masculino</option>
                <option value="F">Femenino</option>
            </select>


        </div>
        <div class="botones2">
            <button class="btn btn-success" onclick="insert_instructor()">Guardar</button>
            <button class="btn btn-danger cancelar" onclick="borrar_datos_input_instructor()">Cancelar</button>
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
                            <h3>Seguro que quiere borrar al instructor?</h1>
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