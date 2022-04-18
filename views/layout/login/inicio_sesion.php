<?php
session_start();
if(isset($_SESSION['loggedin'])){
    header('Location: ../../layout/login/index.php');
}
?>
<!DOCTYPE html>
<html lang="en" class="vh-100 vw-100 m-0 bg-dark">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Extraescolares</title>

    <!-- IMPORTS -->
    <?php include "../../../views/layout/imports.php" ?>
    <style>
    * {
        margin: 0 !important;
    }

    #fondo {
        background: url("../../../assets/img/Tec-de-Colima.jpeg");
        width: 100%;
        text-align: center;
    }
    </style>
</head>

<body class="d-flex m-0 h-100 w-100" id="fondo">
    <div class="h-100 d-flex flex-column bg-white w-100">

        <!-- CONTENT -->
        <div class="d-flex flex-column h-100 w-100 justify-content-center align-items-center">
            <div class="d-flex flex-column align-items-center justify-content-around"
                style="width:25%;  background-color:white; border-radius:2%; border: 1px solid black; min-height: 60% !important; height:fit-content; max-height:fit-content; min-width:fit-content;">
                <div class="d-flex justify-content-around align-items-center" style="max-width:100%; overflow:hidden">
                    <img style="width:10%; height:10vh; min-width:54px; max-height:60px;"
                        src="../../../assets/img/itcolima.svg" alt="ITCOLIMA" class="plecaTECNM">
                    <h1>SiGAC</h1>
                </div>
                <input id="email" type="email" style="max-width:100%" placeholder="Correo/Usuario" />
                <input id="contrasena" type="password" style="max-width:100%" placeholder="Contraseña" />
                <button style="max-width:100%; max-height:25%; overflow:hidden" class="btn btn-success"
                    onclick="login()">Iniciar Sesión</button>
            </div>
        </div>
    </div>
    <script src="../../../js/login.js"></script>
</body>

</html>