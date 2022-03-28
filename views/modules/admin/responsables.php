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

    <div class="content h-100 w-100 ">

        <!-- HEADER -->
        <?php include "../../../views/layout/header.php" ?>

        <!-- CONTENT -->
        <div class="box d-flex flex-column align-items-center bg-white"
            style="width: 100% !important; min-height:calc(100% - 137px) !important; overflow-y:auto;">



            <div id="inicio">
                <div id="titulo">
                    <h1>Gestión de Responsables</h1>
                </div>
                <div id="flecha">
                    <a id="return" href="http://localhost/Extraescolares/views/modules/admin/administrador.php">
                        <img style="width:10%; height:10vh; min-width:30px; max-height:30px;"
                            src="../../.././assets/img/back.png"></a>
                </div>
            </div>

            <!-- FORMULARIO -->
            <div class="content-form mb-4 p-3 d-flex flex-column align-items-center" style="width: 90% !important;">
                <div id="cuadro">

                    <div>
                        <div id="inputs_coordinador" >
                            <div id="id_responsable">
                                <input id="input_id_responsable" type="text" hidden />
                                <div>
                                    <label style="padding-right: 114px;">Clave</label>
                                    <input id="input_clave_responsable" type="text" placeholder="Clave">
                                </div>
                            </div>
                        </div>

                        <div id="inputs_coordinador">
                            <div id="nombre_responsable" style="margin-top: 10px; margin-bottom: 10px;">
                                <label style="padding-right: 114px;">Nombre</label>
                                <input style="margin-left: -20px;" id="input_nombre_responsable" type="Nombre"
                                    placeholder="Nombre">
                            </div>
                            <div id="apellido_p_responsable" style="margin-top: 10px; margin-bottom: 10px;">
                                <label style="padding-right: 55px; margin-left:20px;" >Apellido Paterno</label>
                                <input style="margin-left: -20px;" id="input_apellido_p_responsable" type="ApellidoP"
                                    placeholder="Apellido Paterno">
                            </div>
                            <div id="apellido_m_responsable" style="margin-top: 10px; margin-bottom: 10px;">
                                <label style="padding-right: 50px; margin-left:20px;">Apellido Materno</label>
                                <input style="margin-left: -20px;" id="input_apellido_m_responsable" type="ApellidoM"
                                    placeholder="Apellido Materno" required="false">
                            </div>
                        </div>


                        <div id="inputs_coordinador" style="margin-bottom:20px;">
                            <div id="email_responsable">
                                <label style="padding-right: 114px; margin-bottom: 10px;">Email</label>
                                <input id="input_correo_responsable" type="email" placeholder="Email">
                            </div>
                            <div id="sexo_responsable">
                                <label style="padding-right: 118px; margin-bottom: 10px; margin-left:20px;">Sexo</label>
                                <select id="select_sexo_responsable">
                                    <option value="O" disabled selected>Elige...</option>
                                    <option value="M">Masculino</option>
                                    <option value="F">Femenino</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- BOTONES GUARDAR Y CANCELAR -->
            <div class="d-flex flex-row-reverse" style="width: 80% !important;  margin-right: 9%;">
                <button id="boton_insert_update_responsable" class="btn btn-success" onclick="insert_responsable()"
                    style="margin-left: 10%;">Guardar</button>
                <button class="btn btn-danger" onclick="borrar_datos_input_responsable()">Cancelar</button>
            </div>

            <!-- TABLA -->
            <div class="content-table d-flex justify-content-center mb-3" style="width: 90% !important;">
                <table id="tabla-responsables">

                </table>
            </div>
        </div>

        <div class="modal fade" id="modal-responsable" tabindex="-1" aria-labelledby="modal-responsable-label"
            aria-hidden="true">
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
                                <p id="p_sexo_resposable"></p>
                                <p id="p_correo_resposable"></p>
                                <input id="input_id_responsable_borrar" type="text" hidden />
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
    <script src="../../../js/responsables.js"></script>
</body>

</html>