<?php
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['Tipo']!="administrador"){
    header('Location: ../../layout/login/index.php');
}
?>
<!DOCTYPE html>
<html lang="en" class="vh-100 vw-100 m-0 bg-dark">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Extraescolares</title>

    <!-- IMPORTS -->
    <?php include "../../../views/layout/imports.php" ?>

</head>
<body class="d-flex m-0 h-100 w-100">
<<<<<<< HEAD
    


    <div class="content h-100 w-100 d-flex flex-column bg-white">
=======

    <div class="content h-100 w-100 d-flex flex-column bg-white" style="min-height: 100% !important;">
>>>>>>> 320b860fae063eb675f5724dad9ef0fc7801b667
        
    <!-- HEADER -->
        <?php include "../../../views/layout/header.php" ?>

        <!-- CONTENT -->
        <div class="box d-flex flex-column align-items-center bg-white" style="width: 100% !important; min-height:calc(100% - 112px) !important; overflow-y:auto;">
            
            <!-- ALERTAS -->
            <?php include "../../../views/layout/alertas.php" ?>

            <a style="margin-left: 70%;" href="http://localhost/Extraescolares/views/modules/admin/administrador.php">
                <img style="width:10%; height:10vh; min-width:30px; max-height:30px;"
                    src="../../.././assets/img/back.png"></a>
            <!-- TITULO DE CONTENIDO -->
            <h1 class="mb-4 mt-2 text-center w-100">Gestión de periodos</h1>
            
            <!-- FORMULARIO -->
            <div class="content-form mb-4 p-3 d-flex flex-column align-items-center" style="width: 90% !important;">
            <div class="content-form mb-4 p-5 d-flex flex-column align-items-center border border-dark" style="width: 72% !important;">
                <div class="d-flex justify-content-evenly" style="width: 100% !important;">
                    <input id="input_id_periodo" type="text" hidden/>
                    <div class="d-flex justify-content-between" style="width: 45% !important;">
                        <label class="text-center" style="width: 50% !important;">Fecha inicio de actividades</label>
                        <input id="input_inicio_actividades" type="date" style="width: 50% !important;" required>
                    </div>
                    <div class="d-flex justify-content-between" style="width: 45% !important;">
                        <label class="text-center" style="width: 50% !important;">Fecha fin de actividades</label>
                        <input id="input_fin_actividades" type="date" style="width: 50% !important;" required>
                    </div>
                </div>
                <br>
                <div class="d-flex justify-content-center" style="width: 50% !important;">
                    <label class="text-center" style="width: 50% !important;">Nombre del periodo</label>
                    <input id="input_nombre_periodo" type="text" style="width: 50% !important;" disabled required>
                </div>                
            </div>
        </div>
            
            <!-- BOTONES GUARDAR Y CANCELAR -->
            <div class="d-flex flex-row-reverse" style="width: 80% !important;  margin-right: 15%;">
                <button class="btn btn-success" onclick="insert_periodo()" style="margin-left: 50px;">Guardar</button >
                <button class="btn btn-danger" onclick="borrar_datos_input_periodo()">Cancelar</button >
            </div>

        </div>

        <!-- FOOTER -->
        <?php include "../../../views/layout/footer.php" ?>

    </div>
    <script src="../../../js/periodos.js"></script>
</body>
</html>