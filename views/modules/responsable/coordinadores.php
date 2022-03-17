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

    <div class="content h-100 w-100 d-flex flex-column bg-white">

        <!-- HEADER -->
        <?php include "../../../views/layout/header.php" ?>

        <!-- CONTENT -->
        <div class="box d-flex flex-column align-items-center bg-white"
            style="width: 100% !important; min-height:calc(100% - 112px) !important; overflow-y:auto;">

            <!-- ALERTAS -->
            <?php include "../../../views/layout/alertas.php" ?>

<<<<<<< HEAD
            <a style="margin-left: 70%;" href="http://localhost/Extraescolares/views/modules/responsable/responsable.php">
                <img style="width:10%; height:10vh; min-width:30px; max-height:30px;"src="../../.././assets/img/back.png">
            </a>    

            <!-- TITULO DE CONTENIDO -->            
            <h1 class="mb-4 mt-2 text-center w-100">Gestión de Coordinadores</h1>
            <input id="input_id_programa_asignar" value="<?php if(!empty($_GET)){echo $_GET["programa"];} ?>" hidden/>
            <input id="input_id_responsable" value="<?php echo $_SESSION['id_responsable'] ?>" hidden/>
=======
           
            <!-- TITULO DE CONTENIDO -->
            <div id="inicio">
                <div id="titulo">
                    <h1>Gestión de Coordinadores</h1>
                </div>
                <div id="flecha">
                    <a id="return" href="http://localhost/Extraescolares/views/modules/admin/administrador.php">
                        <img style="width:10%; height:10vh; min-width:30px; max-height:30px;"
                            src="../../.././assets/img/back.png"></a>
                </div>
            </div>
>>>>>>> 47e15a2be92f13c46f55526e86904b71e0577fd4
            <!-- FORMULARIO -->
            <div class="content-form mb-4 p-3 d-flex w-100 flex-column align-items-center">
                <div id="cuadro">
                     <div id="inputs_coordinador">
                        <input id="input_id_coordinador" type="text" hidden />
                        <div>

                            <label>Clave:</label>
                            <input id="input_clave_coordinador" type="text" placeholder="Clave">
                        </div>
                    </div>
                    <div id="inputs_coordinador">
                        <div id="nombre_coordinador">
                            <label>Nombre:</label>
                            <input id="input_nombre_coordinador" type="Nombre" placeholder="Nombre">
                        </div>
                        <div id="apellido_p_coordinador">
                            <label style="margin-left:5px;">Apellido Paterno:</label>
                            <input id="input_apellido_p_coordinador" type="ApellidoP" placeholder="Apellido Paterno">
                        </div>
                        <div id="apellido_m_coordinador">
                            <label style="margin-left:5px;">Apellido Materno:</label>
                            <input id="input_apellido_m_coordinador" type="ApellidoM" placeholder="Apellido Materno">
                        </div>
                    </div>
                    <div id="inputs_coordinador">
                        <div id="email_coordinador">
                            <label style="margin-left:5px;">Email:</label>
                            <input id="input_correo_coordinador" type="email" placeholder="Email">
                        </div>

                        <div>
                            <label style="margin-left:5px;">Contacto:</label>
                            <input id="input_contacto_coordinador" placeholder="Contacto" type="text" required />
                        </div>

                        <div id="input_genero_coordinador" class="btn-group" style="margin-left:20px; ">
                        <button type="button" class="btn btn-outline-dark dropdown-toggle" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Selecione Genero
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item">M</a></li>
                            <li><a class="dropdown-item">F</a></li>

                        </ul>
                        </div>
                    </div>
                    <br>

                </div>

                <!-- BOTONES GUARDAR Y CANCELAR -->
                <div id="botones">
                    <button id="boton_insert_update_coordinador" class="btn btn-success" onclick="insert_coordinador()">Guardar</button>
                    <button class="btn btn-danger" style="margin-left: 50px;" onclick="borrar_datos_input_coordinador()">Cancelar</button>
                </div>

                <!-- TABLA -->
                <div class="content-table d-flex justify-content-center mb-3" style="width: 90% !important;">
                    <table id="tabla_coordinadores">

                    </table>
                </div>
            </div>

<<<<<<< HEAD
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

        <div class="modal fade" id="modal_borrar_coordinador" tabindex="-1" aria-labelledby="modal_borrar_coordinador-label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal_borrar_coordinador-label">Borrar Coordinador</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <div class="w-100">
                            <h3>Seguro que quiere borrar al coordinador?</h1>
                            <p id="p_clave_coordinador"></p>
                            <p id="p_nombre_coordinador"></p>
                            <p id="p_sexo_coordinador"></p>
                            <p id="p_correo_coordinador"></p>                        
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

        <div class="modal fade" id="modal_asignar_coordinador" tabindex="-1" aria-labelledby="modal_asignar_coordinador-label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal_asignar_coordinador-label">Asignar Coordinador</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <div class="w-100 d-flex flex-column align-items-center">
                            <h3>Seguro que quiere asignar al coordinador?</h1>
                            <p id="p_clave_coordinador_asignar"></p>
                            <p id="p_nombre_coordinador_asignar"></p>
                            <p id="p_sexo_coordinador_asignar"></p>
                            <p id="p_correo_coordinador_asignar"></p>
                            <label>Correo del programa</label>
                            <input id="input_correo_coordinador_programa" type="text" style="width:50%"/><br>
                            <label>Fecha de inicio del coordinador</label>
                            <input id="input_fecha_inicio_coordinador_programa" type="date" style="width:50% !important"/>                       
                            <input id="input_asignar_id_coordinador" type="text" hidden/>
                        </div>        
                    </div>
                    <div class="modal-footer d-flex justify-content-evenly">
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-secondary" onclick="asignar_responsable()">Asignar</button>               
                    </div>
                </div>
            </div>   
        </div>

=======
            <div class="modal fade" id="modal-coordinador" tabindex="-1" aria-labelledby="modal-coordinador-label"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modal-coordinador-label">Borrar Responsabele de Departamento
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            <div class="w-100">
                                <h3>Seguro que quiere borrar al coordinador?</h1>
                                    <p id="p_clave_resposable"></p>
                                    <p id="p_nombre_resposable"></p>
                                    <p id="p_correo_resposable"></p>
                                    <input id="input_id_coordinador_borrar" type="text" hidden />
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-evenly">
                            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-danger" onclick="borrar_coordinador()">Borrar</button>
                        </div>
                    </div>
                </div>
            </div>
>>>>>>> 47e15a2be92f13c46f55526e86904b71e0577fd4
        </div>

        <!-- FOOTER -->
        <?php include "../../../views/layout/footer.php" ?>

    </div>
    <script src="../../../js/coordinadores.js"></script>
</body>

</html>