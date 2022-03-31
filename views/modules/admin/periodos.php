<?php
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['Tipo']!="administrador"){
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
<body>
    
    <div class="contenido2">
    <?php include "../../../views/layout/header.php" ?>
        <div class="cabecera">
            <h1 class="titulo">Titulo</h1>
            <a href="#"><img class="flecha"  src="../../.././assets/img/back.png"></a>
        </div>
        <div class="cuadro1">
            
        </div>
        <div class="botones2">
            <button class="btn btn-success" onclick="insert_periodo()">Guardar</button >
            <button class="btn btn-danger cancelar" onclick="borrar_datos_input_periodo()">Cancelar</button >
        </div>
        
        <?php include "../../../views/layout/footer.php" ?>
    </div>
    
</body>
</html>



            
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
                <div class="d-flex justify-content-center" style="width: 50% !important; margin-top: 20px;">
                    <label class="text-center" style="width: 50% !important;">Nombre del periodo</label>
                    <input id="input_nombre_periodo" type="text" style="width: 50% !important;" disabled required>
                </div>                
            </div>
        </div>
            