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
.input1 {
    grid-area: input_contra;
    height: 35px;
}

.label1 {
    grid-area: label_contra;
    display: flex;
    justify-content: center;
    align-items: center;
}

.input2 {
    grid-area: input_contra2;
    height: 35px;
}

.label2 {
    grid-area: label_contra2;
    display: flex;
    justify-content: center;
    align-items: center;
}


.contenedor_inputs_insercion {
    align-content: center;
    grid-template-columns: repeat(5, .3fr);
    grid-template-areas:
        " input_contra label_contra label_contra label_contra label_contra"
        " input_contra2 label_contra2 label_contra2 label_contra2 label_contra2"
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
            <input class="label1" id="psw1" type="password" />

            <label class="input2">Verifique Nueva contraseña</label>
            <input class="label2" id="psw2" type="password" />

        </div>

        <!-- BOTONES INSERCION -->
        <div class="contenedor_botones_insercion">
            <button class="btn btn-success" id="" onclick="compara()">Guardar</button>
            <button class="btn btn-danger cancelar" onclick="borrar_datos_input_psw()">Cancelar</button>
        </div>


        <div class="modal" tabindex="-1" role="dialog" id="modal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Contraseña</h5>
                    </div>
                    <div class="modal-body">
                        <p>Contraseña modificada.</p>
                    </div>
                   
                </div>
            </div>
        </div>

        <div class="modal" tabindex="-1" role="dialog" id="modal1">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Contraseña</h5>
                    </div>
                    <div class="modal-body">
                        <p>Error de contraseña.</p>
                    </div>
                   
                </div>
            </div>
        </div>



        <!-- FOOTER -->
        <?php include "../../../views/layout/footer.php" ?>
    </div>

    <!-- MODAL BORRAR HORARIO -->


    <script src="../../../js/psw.js"></script>

</body>

</html>