<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SiGAC</title>

    <!-- IMPORTS -->
    <?php include "../../../views/layout/imports.php" ?>

</head>
<style>

.input1{
        grid-area: input_contra;
        height: 35px;
    }

.label1{
        grid-area: label_contra;
        display: flex;
        justify-content: center;
        align-items: center;
    }

   
    .contenedor_inputs_insercion {
        align-content: center;
        grid-template-columns: repeat(5, .3fr);
        grid-template-areas:
            " input_contra label_contra label_contra label_contra label_contra"
        ;
    }
</style>

<body>
    <div class="contenedor_principal_insercion">

        <!-- HEADER -->
        <?php include "../../../views/layout/header.php" ?>

        <!-- ALERTAS -->
        <?php include "../../../views/layout/alertas.php" ?>

        <!-- CABECERA -->
        <div class="cabecera">
            <h1 class="titulo">Editar Contraseña</h1>
            <a onclick="salir()"><img class="flecha" src="../../.././assets/img/back.png"></a>
        </div>

        <!-- FORMULARIO PARA INSERCIÓN -->
        <div class="contenedor_inputs_insercion">

            <input id="input_id_contra" type="text" hidden />
           

            <label class="input1">Ingrese Nueva contraseña</label>
            <input class="label1" type="text"/>

        </div>

        <!-- BOTONES INSERCION -->
        <div class="contenedor_botones_insercion">
            <button class="btn btn-success" id="" onclick="">Guardar</button>
            <button class="btn btn-danger cancelar" onclick="">Cancelar</button>
        </div>

        

        <!-- FOOTER -->
        <?php include "../../../views/layout/footer.php" ?>
    </div>

    <!-- MODAL BORRAR HORARIO -->


    <script src=""></script>

</body>

</html>