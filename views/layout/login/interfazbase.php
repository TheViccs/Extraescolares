<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport">
    <title>Interfaz</title>
    <?php include "../../../views/layout/imports.php" ?>
</head>
<body>
    
    <div class="contenido2">
    <?php include "../../../views/layout/header.php" ?>
        <div class="cabecera">
            <h1 class="titulo">Titulo</h1>
            <a href="#"><img class="flecha"  src="../../.././assets/img/back.png"></a>
        </div>
        <div class="cuadro1">
            <label class="label1">Clave</label>
            <input class="input1" placeholder="Clave">
            <label class="label2">Nombre</label>
            <input class="input2" placeholder="Nombre">
            <label class="label3">Correo</label>
            <input class="input3" placeholder="Correo">
        </div>
        <div class="botones2">
            <button class="btn btn-success">Guardar</button>
            <button class="btn btn-danger cancelar">Cancelar</button>
        </div>
        <div class="contenedor-tabla content-table">

        </div>
        <?php include "../../../views/layout/footer.php" ?>
    </div>
    
</body>
</html>