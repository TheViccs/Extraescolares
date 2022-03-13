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

    <div class="content h-100 d-flex flex-column bg-white w-100" >
        
        <!-- HEADER -->
        <?php include "../../../views/layout/header.php" ?>

        <!-- CONTENT -->
        <div class="d-flex flex-column justify-content-center align-items-center" style="min-height:calc(100% - 112px) !important; overflow-y:auto;">
          <label>Correo</label>
          <input id="email" type="email" />
          <br>
          <label>Contraseña</label>
          <input id="contrasena" type="password" />
          <br>
          <button onclick="login()">Iniciar Sesión</button>    
        </div>
        <!-- FOOTER -->
       <?php include "../../../views/layout/footer.php" ?>
    </div>
    <script src="../../../js/login.js"></script>
</body>
</html>
