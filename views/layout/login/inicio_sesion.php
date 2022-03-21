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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Extraescolares</title>

    <!-- IMPORTS -->
    <?php include "../../../views/layout/imports.php" ?>

</head>

<body class="d-flex m-0 h-100 w-100">

    <div class="content h-100 d-flex flex-column bg-white w-100" id="contenidoLogin">

        <!-- HEADER -->
        <?php include "../../../views/layout/header.php" ?>
        <!-- <a style="margin-left: 70%;" href="http://localhost/Extraescolares/views/layout/home.php">
                <img style="width:5%; height:10vh; min-width:30px; max-height:30px;"
                    src="../../.././assets/img/back.png"></a> -->
        <!-- CONTENT -->
        <div class="d-flex flex-column justify-content-center align-items-center"
            style="min-height:calc(100% - 112px) !important; overflow-y:auto;">
            <div class="d-flex flex-column justify-content-center align-items-center "
                style="width: 25% !important; height: 35% !important; background-color: white; border-radius: 10%; border: solid black 3px;">
                <div class="d-flex w-40 justify-content-center align-items-center mb-4">
                    <img style="width:10%; height:10vh; min-width:54px; max-height:60px;"
                        src="../../../assets/img/itcolima.svg" alt="ITCOLIMA" class="plecaTECNM">
                    <h1 class="m-2">SiGAC</h1>
                </div>
                <div style="display: flex; margin-left: 25px; margin-top:20px">
                    <label style="margin-right: 5px;">Usuario: </label>
                    <input id="email" type="email" placeholder="Correo/Usuario" />
                </div>

                <br>
                <div style="margin-top:20px">
                    <label>Contraseña: </label>
                    <input id="contrasena" type="password" placeholder="Contraseña" />
                </div>


                <br>
                <button class="btn btn-outline-success" onclick="login()" style="margin-top:20px">Iniciar Sesión</button>
            </div>
        </div>

        <!-- FOOTER -->
        <?php include "../../../views/layout/footer.php" ?>
    </div>
    <script src="../../../js/login.js"></script>
</body>

</html>