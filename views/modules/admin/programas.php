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
                    <input id="input_id_departamento" type="text" hidden/>
                    <div class="d-flex justify-content-between" style="width: 45% !important;">
                        <label class="text-center" style="width: 50% !important;">Nombre</label>
                        <input id="input_nombre_programa" style="width: 50% !important;" type="text" required/>
                    </div>
                    <div class="d-flex justify-content-evenly" style="width: 45% !important;">
                        <label class="text-center" style="width: 45% !important;">Departamento</label>
                        <input id="input_select_departamentos" type="text" list="select_responsables" style="width: 38% !important;"/>
                        <datalist id="select_departamentos" style="width: 45% !important;">
                        </datalist>
                        <button class="btn btn-dark p-0" style="height: 28px; width: 28px;" data-bs-toggle="modal" data-bs-target="#modal-responsable">+</button>
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
            </div>
            
            <!-- BOTONES GUARDAR Y CANCELAR -->
            <div class="d-flex justify-content-evenly" style="width: 50% !important;">
                <button class="btn btn-success" onclick="">Guardar</button>
                <button class="btn btn-danger" onclick="">Cancelar</button>
            </div>
            
            <!-- TABLA -->
            <div class="content-table d-flex justify-content-center mb-3" style="width: 90% !important;">
                <table id="tabla-programas">
                    
                </table>
            </div>
        </div>

        <!-- FOOTER -->
        <?php include "../../../views/layout/footer.php" ?>

    </div>
</body>
</html>