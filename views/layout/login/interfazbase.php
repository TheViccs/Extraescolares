<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interfaz</title>
    <?php include "../../../views/layout/imports.php" ?>
</head>
<style>
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
    }

    .cabecera{
        display: flex;
        margin-top: 2%;
        justify-content: center;
        height: 15%;
        width: 100%;
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

    .contenedor-tabla{
        display: flex;
        justify-content: center;
        margin-bottom: 2%;
        width: 80%;
        border: 1px solid black;
    }

    .contenido2{
        height: calc(100% - 112px);
        display: flex;
        flex-direction: column;
        align-items: center;
        overflow-y: auto;
    }

    .cuadro1{
        height: 45%;
        flex-shrink: 0;
        width: 80%;
        border: 1px solid black;
        border-radius: 5px;
    }
    
    .flecha{
        width: 10%;
        height: 100%;
        min-width: 30px;
        max-height: 30px;
    }

    .titulo{
        justify-self: center;
        margin-left: auto;
    }

</style>
<body>
    <?php include "../../../views/layout/header.php" ?>
    <div class="contenido2">
        <div class="cabecera">
            <h1 class="titulo">Titulo</h1>
            <a href="#"><img class="flecha"  src="../../.././assets/img/back.png"></a>
        </div>
        <div class="cuadro1">

        </div>
        <div class="botones2">
            <button class="btn btn-success">Guardar</button>
            <button class="btn btn-danger cancelar">Cancelar</button>
        </div>
        <div class="contenedor-tabla content-table">

        </div>
    </div>
    <?php include "../../../views/layout/footer.php" ?>
</body>
</html>