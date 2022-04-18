<?php
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['Tipo']!="responsable"){
    header('Location: ../../layout/login/index.php');
}
?>

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
<<<<<<< HEAD
        
=======
>>>>>>> 95cce2cdbc39e8e0e930842a3e212f0c54f48b2a
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
                <h1 class="titulo">Programas</h1>
                <a href="http://localhost/Extraescolares/views/modules/responsable/responsable.php"><img class="flecha" src="../../.././assets/img/back.png"></a>
            </div>

         
            <input id="input_id_responsable" type="text" value="<?php echo $_SESSION['id_responsable'] ?>" hidden />

            <div class="contenedor-tabla content-table">
                <table id="tabla_programas">

                </table>


            </div>
            <?php include "../../../views/layout/footer.php" ?>
        </div>

        <script src="../../../js/programas_responsables.js"></script>

    </body>

    </html>