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
    *{
        font-size: 1rem;
    }

    html{
        height: 100vh;
        width: 100vw;
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

    .contenido2{
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        min-width: fit-content;
    }

    .label1{
        grid-area: label-clave;
        text-align: center;
    }

    .input1{
        grid-area: input-clave;
    }

    .label2{
        grid-area: label-nombre;
        text-align: center;
    }

    .input2{
        grid-area: input-nombre;
    }

    .label3{
        grid-area: label-correo;
        text-align: center;
    }

    .input3{
        grid-area: input-correo;
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
            "label-clave input-clave label-nombre input-nombre input-nombre input-nombre input-nombre input-nombre"
            "label-correo input-correo input-correo input-correo input-correo input-correo input-correo input-correo";
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
            <h1 class="titulo">Titulo</h1>
            <a href="#"><img class="flecha"  src="../../.././assets/img/back.png"></a>
        </div>
        <div class="cuadro1">
            <label class="label1">Clave</label>
            <input class="input1" placeholder="Clave">
            <label class="label2">Nombre</label>
            <input class="input2" placeholder="Nombre">
            <label class="label3">Correo</label>
            <input class="input3" placeholder="Correo">
        </div>
        <div class="botones2">
            <button class="btn btn-success">Guardar</button>
            <button class="btn btn-danger cancelar">Cancelar</button>
        </div>
        <div class="contenedor-tabla content-table">

        </div>
        <?php include "../../../views/layout/footer.php" ?>
    </div>
    
</body>
</html>