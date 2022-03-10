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

            <!-- TITULO DE CONTENIDO -->
            <h1 class="mb-4 mt-2 text-center w-100">Gestión de programas</h1>
            
            <!-- FORMULARIO -->
            <div class="content-form mb-4 p-3 d-flex flex-column align-items-center" style="width: 90% !important;">
                <div class="d-flex justify-content-evenly" style="width: 100% !important;">
                    <input id="input_id_programa" type="text" hidden/>
                    <div class="d-flex justify-content-between" style="width: 45% !important;">
                        <label class="text-center" style="width: 50% !important;">Clave</label>
                        <input id="input_clave_programa" style="width: 50% !important;" type="text" required/>
                    </div>
                    <div class="d-flex justify-content-between" style="width: 45% !important;">
                        <label class="text-center" style="width: 50% !important;">Nombre</label>
                        <input id="input_nombre_programa" style="width: 50% !important;" type="text" required/>
                    </div>                 
                </div>
                <br>
                <div class="d-flex justify-content-evenly" style="width: 100% !important;">          
                    <div class="d-flex justify-content-between" style="width: 45% !important;">
                        <label class="text-center" style="width: 50% !important;">Descripción</label>
                        <textarea id="input_descripcion_programa" style="width: 50% !important;" type="text" required></textarea>
                    </div>
                    <div class="d-flex justify-content-between" style="width: 45% !important;">
                        <label class="text-center" style="width: 50% !important;">Observaciones</label>
                        <textarea id="input_observaciones_programa" style="width: 50% !important;" type="text" required></textarea>
                    </div>
                </div>
                <br>
                <div class="d-flex justify-content-end" style="width: 100% !important;">          
                    <div class="d-flex flex-column" style="width: 74% !important;">
                        <label class="text-center" style="width: 100% !important;">Departamentos</label>
                        <br>
                        <select multiple="multiple" id="select_programas">
                        </select>
                    </div>
                </div>                                                 
            </div>
            
            <!-- BOTONES GUARDAR Y CANCELAR -->
            <div class="d-flex justify-content-evenly" style="width: 50% !important;">
                <button id="boton_insert_update_programa" class="btn btn-success" onclick="insert_programa()">Guardar</button>
                <button class="btn btn-danger" onclick="borrar_datos_input_programa()">Cancelar</button>
            </div>
            
            <!-- TABLA -->
            <div class="content-table d-flex justify-content-center mb-3" style="width: 90% !important;">
                <table id="tabla_programas">
                    
                </table>
            </div>
        </div>

        <!-- FOOTER -->
        <?php include "../../../views/layout/footer.php" ?>       
    </div>

    <!-- MODAL BORRAR PROGRAMA -->
    <div class="modal fade" id="modal_programa" tabindex="-1" aria-labelledby="modal_programa_label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_programa_label">Borrar programa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="w-100">
                        <h3>Seguro que quiere borrar el programa?</h1>
                        <p id="p_clave_programa"></p>
                        <p id="p_nombre_programa"></p>
                        <p id="p_descripcion_programa"></p>
                        <input id="input_id_programa_borrar" type="text" hidden/>
                    </div>        
                </div>
                <div class="modal-footer d-flex justify-content-evenly">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" onclick="borrar_programa()">Borrar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="../../../lib/multiselect/js/jquery.multi-select.js"></script>
    <script src="../../../js/programas.js"></script> 
</body>
</html>