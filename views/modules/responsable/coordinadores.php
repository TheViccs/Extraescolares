<?php
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['Tipo']!="responsable"){
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

    <div class="content h-100 w-100 d-flex flex-column bg-white" >
        
        <!-- HEADER -->
        <?php include "../../../views/layout/header.php" ?>

        <!-- CONTENT -->
        <div class="box d-flex flex-column align-items-center bg-white" style="width: 100% !important; min-height:calc(100% - 112px) !important; overflow-y:auto;">    

            <!-- ALERTAS -->
            <?php include "../../../views/layout/alertas.php" ?>

            <a style="margin-left: 70%;" href="http://localhost/Extraescolares/views/modules/responsable/responsable.php">
                <img style="width:10%; height:10vh; min-width:30px; max-height:30px;"src="../../.././assets/img/back.png">
            </a>    

            <!-- TITULO DE CONTENIDO -->            
            <h1 class="mb-4 mt-2 text-center w-100">Gestión de Coordinadores</h1>
            
            <!-- FORMULARIO -->
            <div class="content-form mb-4 p-3 d-flex flex-column align-items-center" style="width: 90% !important;">
            <div class="content-form mb-4 p-5 d-flex flex-column align-items-center border border-dark" style="width: 71% !important;">    
            <div id="formulario_coordinador" >
                    <div id="id_coordinador">
                        <input id="input_id_coordinador" type="text" hidden/>
                        <div>
                            <label style="padding-right: 50px;">Clave</label>
                            <input id="input_clave_coordinador" type="text" placeholder="Clave" >
                        </div>
                    </div>
                    <div id="nombre_coordinador" style="margin-top: 10px; margin-bottom: 10px;">
                        <label style="padding-right: 50px;">Nombre</label>
                        <input style="margin-left: -20px;" id="input_nombre_coordinador" type="Nombre" placeholder="Nombre">
                    </div>
                    <div id="apellido_p_coordinador" style="margin-top: 10px; margin-bottom: 10px;">
                        <label style="padding-right: 50px;">Apellido Paterno</label>
                        <input style="margin-left: -20px;" id="input_apellido_p_coordinador" type="ApellidoP" placeholder="Apellido Paterno">
                    </div>
                    <div id="apellido_m_coordinador" style="margin-top: 10px; margin-bottom: 10px;">
                        <label style="padding-right: 50px;">Apellido Materno</label>
                        <input style="margin-left: -20px;" id="input_apellido_m_coordinador" type="ApellidoM" placeholder="Apellido Materno">
                    </div>
                    <div id="email_coordinador">
                        <label style="padding-right: 50px; margin-bottom: 10px;">Email</label>
                        <input id="input_correo_coordinador" type="email" placeholder="Email" >
                    </div>                   
                </div>  
            </div>

            <!-- BOTONES GUARDAR Y CANCELAR -->
            <div class="d-flex justify-content-evenly"  style="width: 80% !important;  margin-left: 34%;">
                <button id="boton_insert_update_coordinador" class="btn btn-success" onclick="insert_coordinador()" style="margin-left: 25%;">Guardar</button>
                <button class="btn btn-danger" onclick="borrar_datos_input_coordinador()" style="margin-left: -20%;">Cancelar</button>           
            </div>

            <!-- TABLA -->
            <div class="content-table d-flex justify-content-center mb-3" style="width: 90% !important;">
                <table id="tabla_coordinadores">
                    
                </table>
            </div>
        </div>

        <div class="modal fade" id="modal-coordinador" tabindex="-1" aria-labelledby="modal-coordinador-label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-coordinador-label">Borrar Responsabele de Departamento</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <div class="w-100">
                            <h3>Seguro que quiere borrar al coordinador?</h1>
                            <p id="p_clave_resposable"></p>
                            <p id="p_nombre_resposable"></p>
                            <p id="p_correo_resposable"></p>                        
                            <input id="input_id_coordinador_borrar" type="text" hidden/>
                        </div>        
                    </div>
                    <div class="modal-footer d-flex justify-content-evenly">
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-danger" onclick="borrar_coordinador()">Borrar</button>               
                    </div>
                </div>
            </div>   
        </div>
        </div>

        <!-- FOOTER -->
        <?php include "../../../views/layout/footer.php" ?>
        
    </div>
    <script src="../../../js/coordinadores.js"></script>
</body>

</html>
