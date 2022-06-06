<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SiGAC</title>

    <!-- IMPORTS -->
    <?php include "../../../views/layout/imports.php" ?>

</head>
<style>

    
    .contenedor_inputs_insercion {
        align-content: center;
        grid-template-columns: repeat(9, .3fr);
        grid-template-areas:
        
        ;
    }
</style>

<body>
    <div class="contenedor_principal_insercion">

        <!-- HEADER -->
        <?php include "../../../views/layout/header.php" ?>

        <!-- ALERTAS -->
        <?php include "../../../views/layout/alertas.php" ?>

        <!-- CABECERA -->
        <div class="cabecera">
            <h1 class="titulo">Agregar Alumno</h1>
            <a href="http://localhost/Extraescolares/views/modules/coordinador/coordinador.php"><img class="flecha" src="../../.././assets/img/back.png"></a>
        </div>

        
        <div class="contenedor_tabla_insercion">
            <table id="tabla_listaEspera"></table>
        </div>
        
        <!-- FORMULARIO PARA INSERCIÓN -->
        <!-- <div class="contenedor_inputs_insercion">

            

        </div> -->

        

        

        <!-- FOOTER -->
        <?php include "../../../views/layout/footer.php" ?>
    </div>

    
    

    <script src="../../../js/horarios.js"></script>

</body>
<script src="../../../js/Liesta_Espera.js"></script>

</html>