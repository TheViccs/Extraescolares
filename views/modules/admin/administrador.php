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
        <div class="d-flex flex-column align-items-center bg-white" style="width: 100% !important; min-height: calc(100% - 112px) !important; overflow-y:auto;">
            
            <!-- ALERTAS -->
            <?php include "../../../views/layout/alertas.php" ?>

            <!-- TITULO DE CONTENIDO -->
            <h1 class="mb-4 mt-2 text-center w-100">Vista del Administrador</h1>
            
            <!-- BODY -->
            

        <!-- FOOTER -->
        <?php include "../../../views/layout/footer.php" ?>

    </div>

    <!-- MODAL INSERTAR RESPONSABLE DE DEPARTAMENTO-->
    <div class="modal fade" id="modal-responsable" tabindex="-1" aria-labelledby="modal-responsable-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-responsable-label">Agregar responsable de departamento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="w-100">
                        <div class="w-100 d-flex">
                            <label class="w-50">Clave</label>
                            <input id="input_clave_responsable" class="w-50" type="text"/>
                        </div>
                        <br>
                        <div class="w-100 d-flex">
                            <label class="w-50">Nombre</label>
                            <input id="input_nombre_responsable" class="w-50" type="text"/>
                        </div>
                        <br>
                        <div class="w-100 d-flex">
                            <label class="w-50">Correo</label>
                            <input id="input_correo_responsable" class="w-50" type="text"/>
                        </div>
                    </div>        
                </div>
                <div class="modal-footer d-flex justify-content-evenly">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="insert_responsable()">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL BORRAR DEPARTAMENTO -->
    <div class="modal fade" id="modal-departamento" tabindex="-1" aria-labelledby="modal-departamento-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-departamento-label">Borrar departamento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="w-100">
                        <h3>Seguro que quiere borrar el departamento?</h1>
                        <p id="p_clave_departamento"></p>
                        <p id="p_nombre_departamento"></p>
                        <p id="p_ubicacion_departamento"></p>
                        <p id="p_extension_departamento"></p>
                        <input id="input_id_departamento_borrar" type="text" hidden/>
                    </div>        
                </div>
                <div class="modal-footer d-flex justify-content-evenly">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" onclick="borrar_departamento()">Borrar</button>
                </div>
            </div>
        </div>
    </div>
    <script src="../../../js/departamentos.js"></script>
</body>
</html>