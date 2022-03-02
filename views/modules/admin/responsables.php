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
    
    <!-- SIDEBAR -->
    <?php include "../../../views/layout/sidebar.php" ?>

    <div class="content h-100 d-flex flex-column bg-white" style="width: calc(100% - 280px);">
        
        <!-- HEADER -->
        <?php include "../../../views/layout/header.php" ?>

        <!-- CONTENT -->
        <div class="box d-flex flex-column align-items-center bg-white" style="width: 100% !important; min-height:calc(100% - 112px) !important; overflow-y:auto;">
            
            <!-- ALERTAS -->
            <?php include "../../../views/layout/alertas.php" ?>

                        
            <!-- FORMULARIO -->
            <h1 class="mb-4 mt-2 text-center w-100">Gestión de Responsables</h1>
            
            <div class="content-form mb-4 p-3 d-flex flex-column align-items-center" style="width: 90% !important;">
                <div id="formulario_responsable" >
                    <div id="id_responsable">
                        <label style="padding-right: 50px;">Clave</label>
                        <input id="input_clave_responsable" type="text" placeholder="Clave" >
                    </div>

                    <div id="nombre_responsable" style="margin-top: 10px; margin-bottom: 10px;">
                        <label style="padding-right: 50px;">Nombre</label>
                        <input style="margin-left: -20px;" id="input_nombre_responsable" type="Nombre" placeholder="Nombre">
                    </div>

                    <div id="email_responsable">
                        <label style="padding-right: 50px; margin-bottom: 10px;">Email</label>
                        <input id="input_correo_responsable" type="email" placeholder="Email" >
                    </div>
                    
                </div>  

            <!-- BOTONES GUARDAR Y CANCELAR -->
            <div class="d-flex justify-content-evenly" style="width: 50% !important;">
                <button class="btn btn-success" onclick="insert_responsable()">Guardar</button>
                <button class="btn btn-danger" onclick="borrar_datos_input_responsable()">Cancelar</button>
                
            </div>
            <!-- TABLA -->
            <div class="content-table d-flex justify-content-center mb-3" style="width: 90% !important;">
                <table id="tabla-responsables">
                    
                </table>
            </div>
        </div>

        <div class="modal fade" id="modal-responsable" tabindex="-1" aria-labelledby="modal-responsable-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-responsable-label">Borrar Responsabele de Departamento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="w-100">
                        <h3>Seguro que quiere borrar al Responsable?</h1>
                        <p id="p_clave_resposable"></p>
                        <p id="p_nombre_resposable"></p>
                        <p id="p_correo_resposable"></p>
                        
                        <input id="input_id_responsable_borrar" type="text" hidden/>
                    </div>        
                </div>
                <div class="modal-footer d-flex justify-content-evenly">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" onclick="borrar_responsable()">Borrar</button>
                    
                </div>
            </div>
        </div>
    </div>

        <!-- FOOTER -->
        <?php include "../../../views/layout/footer.php" ?>

    </div>
    <script src="../../../js/responsableDepartamento.js"></script>
</body>
</html>