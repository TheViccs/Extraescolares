<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['Tipo'] != "alumno") {
    header('Location: ../../layout/login/index.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Extraescolares</title>
    <!-- IMPORTS -->
    <?php include "../../../views/layout/imports.php" ?>
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
            grid-area: label_nombre_grupo;
            text-align: center;
        }

        .input1 {
            grid-area: input_nombre_grupo;
        }

        .label2 {
            grid-area: label_capacidadMin_grupo;
            text-align: center;
        }

        .input2 {
            grid-area: input_capacidadMin_grupo;
        }

        .label3 {
            grid-area: label_capacidadMax_grupo;
            text-align: center;
        }

        .input3 {
            grid-area: input_capacidadMax_grupo;
        }



        .label4 {
            grid-area: label_total_grupo;
            text-align: center;
        }

        .input4 {
            grid-area: input_total_grupo;
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
                ""
                ""
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

        .contenido2 {
            width: 100%;
        }

        .contenido-carga {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
        }

        .contenedor-tabla-carga-alumno {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .tabla-carga-alumno {
            min-height: fit-content;
            width: 80%;
            max-width: 80%;
        }

        .tabla-carga-alumno tr {
            display: flex;
            justify-content: space-around;
            align-items: center;
            height: 100%;
        }

        .tabla-carga-alumno th {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 60px;
        }

        .tabla-carga-alumno tbody {
            border: 1px solid black;
            min-height: fit-content;
        }

        .tabla-carga-alumno tbody th{
            font-size: 15px;
            font-weight: 400;
        }

        .periodo{
            display: flex;
            justify-content: flex-start;
            align-items: center ;
            width: 80%;
            border: 1px solid black;
            border-radius: 10px;
            margin-bottom: 20px;
            padding: 5px;
        }
        
        .tbody_actividades_kardex th{
            height: 30px;
        }

        .periodo *{
            display: flex;
            justify-content: center;
            align-items: center ;
            margin: 0;
            margin-right: 10px;
        }

        .cursando{
            background-color: rgb(250, 200 ,100);
        }

        .acreditada{
            background-color: rgb(110, 200 ,140);
        }

        .reprobada{
            background-color: rgb(200, 100 ,100);
        }

        .descripcion-colores{
            display: flex;
            justify-content: space-around;
            align-items: center;
            margin-bottom: 20px;
            width: 50%;
        }

        .cuadro-color{
            height: 30px;
            width: 30px;
        }

        .btn-constancia{
            aspect-ratio: 1;
            height: 30px;
            display: flex;
            justify-content: center;
            align-items: center;
            background: transparent;
        }

        .tabla-carga-alumno th{
            w
        }

    </style>
</head>

<body>
    <div class="h-100 w-100 d-flex flex-column bg-white">
        <!-- HEADER -->
        <?php include "../../../views/layout/header.php" ?>

        <!-- CONTENT -->
        <div class="d-flex flex-column align-items-center bg-white" style="width: 100% !important; min-height: calc(100% - 137px) !important; overflow-y:auto;">
            <div class="contenido2">
                <div class="cabecera">
                    <h1 class="titulo">Mi Kárdex</h1>
                    <a href="alumno.php"><img class="flecha" src="../../.././assets/img/back.png"></a>
                </div>
                <div class="contenido-carga">
                <input id="id_alumno" value="<?php echo $_SESSION['id_alumno'] ?>" hidden />
                <input id="correo_alumno" value="<?php echo $_SESSION['correo'] ?>" hidden />
                    <div class="periodo">
                        <h5>Periodo</h5>
                        <p id="periodo_actual"></p>
                        <h5>Actividades Acreditadas</h5>
                        <p id="actividades_acreditadas_alumno"></p>
                        <h5>Usuario</h5>
                        <p id="alumno"></p>
                    </div>
                    <div class="descripcion-colores">
                        <div class="cuadro-color acreditada"></div><p>Acreditada</p>
                        <div class="cuadro-color cursando"></div><p>Cursando</p>
                        <div class="cuadro-color reprobada"></div><p>No Acreditada</p>
                    </div>
                    <div class="contenedor-tabla-carga-alumno">
                        <table class="tabla-carga-alumno">
                            <thead>
                                <tr>
                                    <th>
                                        [Créditos] <br> Actividad
                                    </th>
                                    <th>
                                        Periodo
                                    </th>
                                    <th>
                                        Calificación
                                    </th>
                                    <th>
                                        Desempeño
                                    </th>
                                    <th>
                                        Estatus
                                    </th>
                                    <th>
                                        Constancia
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="tbody_actividades_kardex" id="tbody_actividades_kardex">
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- FOOTER -->
        <?php include "../../../views/layout/footer.php" ?>

    </div>

    <script src="../../../js/kardex_alumno.js"></script>

</body>

</html>