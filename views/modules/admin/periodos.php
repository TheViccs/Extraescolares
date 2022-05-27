<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['Tipo'] != "administrador") {
    header('Location: ../../layout/login/index.php');
}
?>
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
    .label_fecha_inicio_periodo {
        grid-area: label_fecha_inicio_periodo;
        text-align: center;
    }

    .input_fecha_inicio_periodo {
        grid-area: input_fecha_inicio_periodo;
    }

    .label_fecha_fin_periodo {
        grid-area: label_fecha_fin_periodo;
        text-align: center;
    }

    .input_fecha_fin_periodo {
        grid-area: input_fecha_fin_periodo;
    }

    .label_nombre_periodo {
        grid-area: label_nombre_periodo;
        text-align: center;
    }

    .input_nombre_periodo {
        grid-area: input_nombre_periodo;
    }



    .contenedor_inputs_insercion {
        grid-template-columns: repeat(8, .3fr);
        grid-template-areas:
            "label_fecha_inicio_periodo label_fecha_inicio_periodo input_fecha_inicio_periodo input_fecha_inicio_periodo label_fecha_fin_periodo label_fecha_fin_periodo input_fecha_fin_periodo input_fecha_fin_periodo"
            "label_nombre_periodo label_nombre_periodo input_nombre_periodo input_nombre_periodo input_nombre_periodo input_nombre_periodo input_nombre_periodo input_nombre_periodo";
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
            <h1 class="titulo">Gestionar Periodos</h1>
            <a href="http://localhost/Extraescolares/views/modules/admin/administrador.php"><img class="flecha" src="../../.././assets/img/back.png"></a>
        </div>

        <!-- FORMULARIO PARA INSERCIÓN -->
        <div class="contenedor_inputs_insercion">

            <!--Primer regnglon de  divs Fecha inicio y Fecha fin-->
            <input id="input_id_periodo" type="text" hidden />
            <label class="label_fecha_inicio_periodo">Fecha inicio de actividades</label>
            <input class="input_fecha_inicio_periodo" id="input_inicio_actividades" type="date" required>

            <label class="label_fecha_fin_periodo">Fecha fin de actividades</label>
            <input class="input_fecha_fin_periodo" id="input_fin_actividades" type="date" required>


            <label class="label_nombre_periodo">Nombre del periodo</label>
            <input class="input_nombre_periodo" id="input_nombre_periodo" type="text" disabled required>
        </div>

        <!-- BOTONES INSERCION -->
        <div class="contenedor_botones_insercion">
            <button class="btn btn-success" onclick="insert_periodo()">Guardar</button>
            <button class="btn btn-danger cancelar" onclick="borrar_datos_input_periodo()">Cancelar</button>
        </div>

        <!-- FOOTER -->
        <?php include "../../../views/layout/footer.php" ?>
    </div>

    <script src="../../../js/periodos.js"></script>

</body>

</html>