<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['Tipo'] != "directivo") {
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
    .contenedor_reportes{
        display: flex;
        flex-direction: column;
        width: 100%;
        align-items: center;
    }

    .contenedor_total_inscripciones{
        display: flex;
        width: 100%;
        justify-content: center;
    }

    .total_inscripciones{
        margin-left: 8px;
    }

    .contenedor_reporte_seleccionado{
        display: flex;
        justify-content: center;
        align-items: center;
        width: 60%;
    }

    .contenedor_botones_reportes{
        margin-top: 20px;
        width: 30%;
        display: flex;
        justify-content: space-around;
        align-items: center;
    }

    #tabla_reporte{
        text-align: center;
    }
</style>
<body>
    <div class="contenedor_principal_insercion">
        <!-- HEADER -->
        <?php include "../../../views/layout/header.php" ?>

        <!-- CABECERA -->
        <div class="cabecera">
            <h1 class="titulo">Reportes</h1>
            <a href="./directivo.php"><img class="flecha" src="../../.././assets/img/back.png"></a>
        </div>
        <div class="contenedor_reportes">
            <div class="contenedor_total_inscripciones">
                <h3>Total de inscripciones del periodo actual: </h3>
                <h3 class="total_inscripciones" id="total_inscripciones"></h3>
            </div>
            <h5 style="margin-top: 20px;">Seleccione reporte de inscripciones de alumnos por</h5>
            <div class="contenedor_botones_reportes">
                <button class="btn btn-primary" onclick="select_total_inscripciones_programa()">Programa</button>
                <button class="btn btn-primary" onclick="select_total_inscripciones_actividad()">Actividad</button>
                <button class="btn btn-primary" onclick="select_total_inscripciones_carrera()">Carrera</button>
                <button class="btn btn-primary" onclick="select_total_inscripciones_semestre()">Semestre</button>
            </div>
            <div class="contenedor_reporte_seleccionado">
                <table id="tabla_reporte">

                </table>
            </div>
        </div>

        <!-- FOOTER -->
        <?php include "../../../views/layout/footer.php" ?>
    </div>

    <script src="../../../js/reportes.js"></script>

</body>

</html>