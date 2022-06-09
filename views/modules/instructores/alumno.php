<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['Tipo'] != "instructor") {
    header('Location: ../../layout/login/index.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport">
    <title>SiGAC</title>
    <?php include "../../../views/layout/imports.php" ?>
</head>
<style>
    .formulario_calificacion_alumno {
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        width: 80%;
    }

    .contenedor_radio_calificacion {
        display: flex;
        justify-content: space-around;
        align-items: center;
        width: 70%;
    }

    .contenedor_criterios {
        width: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-start;
    }

    .contenedor_criterio {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: flex-start;
        background-color: lightgray;
        border-radius: 10px;
        margin-bottom: 5px;
    }

    .descripcion_criterio {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 30%;
        text-align: center;
        padding: 8px;
    }

    .inputs_calificacion {
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 10px;
    }

    .contenedor_boton_calificar{
        width: 100%;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .label_calificacion_numerica{
        text-align: center;
        width: 20%;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .input_calificacion_numerica{
        width: 8%;
    }

    .label_desempeño{
        text-align: center;
        width: 18%;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .input_desempeño{
        width: 20%;
        margin-right: 20px;
    }

    .label_acreditacion{
        text-align: center;
        width: 10%;
    }

    .input_acreditacion{
        width: 5%;
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
            <h1 class="titulo">Calificar</h1>
            <a href="./grupos.php"><img class="flecha" src="../../.././assets/img/back.png"></a>
        </div>

        <input id="id_instructor" value="<?php echo $_SESSION["id_instructor"] ?>" hidden />
        <input id="id_grupo" value="<?php if (!empty($_GET)) {
                                        echo $_GET["grupo"];
                                    } ?>" hidden />
        <input id="id_alumno" value="<?php if (!empty($_GET)) {
                                        echo $_GET["alumno"];
                                    } ?>" hidden />

        <!-- TABLA CONTENIDO -->
        <div class="formulario_calificacion_alumno">
            <div class="contenedor_criterios" id="contenedor_criterios">
                <div class="contenedor_criterio">
                    <p class="descripcion_criterio">Descripcion muy larga para ver que pasa cuando la descripcion tiene demasiado texto y ver si se va para abajo</p>
                    <div class="contenedor_radio_calificacion">
                        <input type="radio" name="criterio1" value="1">Insuficiente
                        <input type="radio" name="criterio1" value="2">Suficiente
                        <input type="radio" name="criterio1" value="3">Bueno
                        <input type="radio" name="criterio1" value="4">Excelente
                    </div>
                </div>
                <div class="contenedor_criterio">
                    <p class="descripcion_criterio">Descripcion muy larga para ver que pasa cuando la descripcion tiene demasiado texto y ver si se va para abajo</p>
                    <div class="contenedor_radio_calificacion">
                        <input type="radio" name="criterio2" value="1">Insuficiente
                        <input type="radio" name="criterio2" value="2">Suficiente
                        <input type="radio" name="criterio2" value="3">Bueno
                        <input type="radio" name="criterio2" value="4">Excelente
                    </div>
                </div>
                <div class="contenedor_criterio">
                    <p class="descripcion_criterio">Descripcion muy larga para ver que pasa cuando la descripcion tiene demasiado texto y ver si se va para abajo</p>
                    <div class="contenedor_radio_calificacion">
                        <input type="radio" name="criterio3" value="1">Insuficiente
                        <input type="radio" name="criterio3" value="2">Suficiente
                        <input type="radio" name="criterio3" value="3">Bueno
                        <input type="radio" name="criterio3" value="4">Excelente
                    </div>
                </div>
                <div class="contenedor_criterio">
                    <p class="descripcion_criterio">Descripcion muy larga para ver que pasa cuando la descripcion tiene demasiado texto y ver si se va para abajo</p>
                    <div class="contenedor_radio_calificacion">
                        <input type="radio" name="criterio4" value="1">Insuficiente
                        <input type="radio" name="criterio4" value="2">Suficiente
                        <input type="radio" name="criterio4" value="3">Bueno
                        <input type="radio" name="criterio4" value="4">Excelente
                    </div>
                </div>
                <div class="contenedor_criterio">
                    <p class="descripcion_criterio">Descripcion muy larga para ver que pasa cuando la descripcion tiene demasiado texto y ver si se va para abajo</p>
                    <div class="contenedor_radio_calificacion">
                        <input type="radio" name="criterio5" value="1">Insuficiente
                        <input type="radio" name="criterio5" value="2">Suficiente
                        <input type="radio" name="criterio5" value="3">Bueno
                        <input type="radio" name="criterio5" value="4">Excelente
                    </div>
                </div>
                <div class="contenedor_criterio">
                    <p class="descripcion_criterio">Descripcion</p>
                    <div class="contenedor_radio_calificacion">
                        <input type="radio" name="criterio6" value="1">Insuficiente
                        <input type="radio" name="criterio6" value="2">Suficiente
                        <input type="radio" name="criterio6" value="3">Bueno
                        <input type="radio" name="criterio6" value="4">Excelente
                    </div>
                </div>
                <div class="contenedor_criterio">
                    <p class="descripcion_criterio">Descripcion</p>
                    <div class="contenedor_radio_calificacion">
                        <input type="radio" name="criterio7" value="1">Insuficiente
                        <input type="radio" name="criterio7" value="2">Suficiente
                        <input type="radio" name="criterio7" value="3">Bueno
                        <input type="radio" name="criterio7" value="4">Excelente
                    </div>
                </div>
            </div>
            <div class="inputs_calificacion">
                <label class="label_calificacion_numerica">Calificación numérica</label>
                <input class="input_calificacion_numerica" type="number" id="calificacion_numerica_alumno" disabled/>
                <label class="label_desempeño">Desempeño</label>
                <input class="input_desempeño" type="text" id="desempeño_alumno" disabled/>
                <label class="label_acreditacion">Acreditar</label>
                <input class="input_acreditacion" type="checkbox" id="boolean_acreditado_alumno" value="1"/>
            </div>
            <div class="contenedor_boton_calificar">
                <button class="btn btn-success" onclick="calificar_alumno()">Guardar</button>
            </div>
        </div>

        <!-- FOOTER -->
        <?php include "../../../views/layout/footer.php" ?>

    </div>

    <script src="../../../js/calificar_alumno_instructor.js"></script>

</body>

</html>