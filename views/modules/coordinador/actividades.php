<?php
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['Tipo']!="coordinador"){
    header('Location: ../../layout/login/index.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport">
    <title>Interfaz</title>
    <?php include "../../../views/layout/imports.php" ?>
</head>
<style>
* {
    font-size: 1rem;
}

html {
    height: 100%;
    width: 100%;
}

body {
    height: 100%;
    width: 100%;
    display: flex;
    flex-direction: column;
}

.botones2 {
    display: flex;
    width: 80%;
    height: 20%;
    align-items: center;
    justify-content: end;
    min-height: 60px;
    min-width: fit-content;

}

.cabecera {
    display: flex;
    margin-top: 2%;
    justify-content: center;
    height: 15%;
    width: 100%;
    min-height: 60px;
    min-width: fit-content;
}

.cabecera a {
    height: 100%;
    margin-left: auto;
    margin-right: 5%;
    justify-self: end;
}

.cancelar {
    margin-left: 2%;
}

.contenedor-inputs2 {
    display: flex;
    justify-content: space-around;
    align-items: center;
    min-height: fit-content;
    width: 100%;
}

.contenedor-inputs3 {
    display: flex;
    width: 50%;
    flex-wrap: wrap;
    justify-content: space-around;
    align-items: center;
    min-height: fit-content;
}

.contenedor-tabla {
    display: flex;
    justify-content: center;
    margin-bottom: 2%;
    width: 80%;
    border: 1px solid black;
}

.dataTable {
    overflow-x: auto !important;
}

.contenido2 {
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    min-width: fit-content;
}

/*PRIMER CUADRO*/
.label1 {
    grid-area: label_nombre_actividad;
    text-align: center;
}

.input1 {
    grid-area: input_nombre_actividad;
}

.label2 {
    grid-area: label_creAct_actividad;
    text-align: center;
}

.input2 {
    grid-area: input_creAct_actividad;
}

.label3 {
    grid-area: label_actPAdre_actividad;
    text-align: center;
}

.input3 {
    grid-area: input_actPAdre_actividad;
}

.label4 {
    grid-area: label_capMAx_actividad;
    text-align: center;
}

.input4 {
    grid-area: input_capMAx_actividad;
}

.label5 {
    grid-area: label_capmini_actividad;
    text-align: center;
}

.input5 {
    grid-area: input_capmini_actividad;
}

.label6 {
    grid-area: label_desc_actividad;
    text-align: center;
}

.input6 {
    grid-area: input_desc_actividad;
}

.label8 {
    grid-area: label_bene_actividad;
    text-align: center;
}

.input8 {
    grid-area: input_bene_actividad;
}

.label7 {
    grid-area: label_compe_actividad;
    text-align: center;
}

.input7 {
    grid-area: input_compe_actividad;
}

.label9 {
    grid-area: label_materialdado_actividad;
    text-align: center;
}

.input9 {
    grid-area: input_materialdado_actividad;
}

.label10 {
    grid-area: label_matealu_actividad;
    text-align: center;
}

.input10 {
    grid-area: input_matealu_actividad;
}

.label11 {
    grid-area: label_temNombre_actividad;
    text-align: center;
}

.input11 {
    grid-area: input_temNombre_actividad;

}

.label12 {
    grid-area: label_temsema_actividad;
    text-align: center;
}

.input12 {
    grid-area: input_temsema_actividad;

}

.label13 {
    grid-area: label_temdes_actividad;
    text-align: center;
}

.input13 {
    grid-area: input_temsdes_actividad;

}

.label14 {
    grid-area: label_cenombre_actividad;
    text-align: center;
}

.input14 {
    grid-area: input_cenombre_actividad;

}

.label15 {
    grid-area: label_cedes_actividad;
    text-align: center;
}

.input15 {
    grid-area: input_cedes_actividad;

}

.label16 {
    grid-area: label_feini_actividad;
    text-align: center;
}

.input16 {
    grid-area: input_feini_actividad;

}

.label17 {
    grid-area: label_fefin_actividad;
    text-align: center;
}

.input17 {
    grid-area: input_fefin_actividad;

}

.label18 {
    grid-area: label_pnombre_actividad;
    text-align: center;
}

.input18 {
    grid-area: input_pnombre_actividad;

}

.label19 {
    grid-area: label_materialdado_actividad_add;
    text-align: center;
}



.label20 {
    grid-area: label_cantidad_material;
    text-align: center;
}

.input20 {
    grid-area: input_cantidad_material;

}

.input21 {
    grid-area: cuadro_material;
}

.input22 {
    grid-area: cuadro_tema;
}
.label22 {
    grid-area: label_materialAlum_actividad_add;
    text-align: center;
}

.label23 {
    grid-area: label_tema_add;
    text-align: center;
}

.btn6 {
    grid-area: btn_padre_actividad;
}



.btn7 {
    grid-area: btn_add_actividad;
}

.btn8 {
    grid-area: btn_elimaner_material;
}

.btn9 {
    grid-area: btn_add_actividadAlum;
}

.btn10 {
    grid-area: btn_add_temas;
}

.btn11 {
    grid-area: btn_Eliminar_temas;
}

.cuadro1 {
    padding: 1rem;
    display: grid;
    height: auto;
    flex-shrink: 0;
    width: 80%;
    border: 1px solid black;
    border-radius: 5px;
    min-height: 20%;
    min-width: fit-content;
    grid-gap: 2rem;
    grid-template-columns: repeat(8, .3fr);
    grid-template-areas:

        /*PRIMER CUADRO*/
        "label_nombre_actividad input_nombre_actividad input_nombre_actividad input_nombre_actividad label_creAct_actividad input_creAct_actividad input_creAct_actividad input_creAct_actividad"
        "label_capmini_actividad input_capmini_actividad input_capmini_actividad input_capmini_actividad label_capMAx_actividad input_capMAx_actividad input_capMAx_actividad  input_capMAx_actividad"
        "label_desc_actividad input_desc_actividad input_desc_actividad input_desc_actividad input_desc_actividad input_desc_actividad input_desc_actividad input_desc_actividad"
        "label_bene_actividad input_bene_actividad input_bene_actividad input_bene_actividad input_bene_actividad input_bene_actividad input_bene_actividad input_bene_actividad"
        "label_compe_actividad input_compe_actividad input_compe_actividad input_compe_actividad input_compe_actividad input_compe_actividad input_compe_actividad input_compe_actividad"
        "label_actPAdre_actividad input_actPAdre_actividad input_actPAdre_actividad input_actPAdre_actividad input_actPAdre_actividad input_actPAdre_actividad input_actPAdre_actividad btn_padre_actividad"
    ;

}

.cuadro2 {
    padding: 1rem;
    display: grid;
    height: auto;
    flex-shrink: 0;
    width: 80%;
    border: 1px solid black;
    border-radius: 5px;
    min-height: 20%;
    min-width: fit-content;
    grid-gap: 2rem;
    grid-template-columns: repeat(5, .3fr);
    grid-template-areas:
        "label_materialdado_actividad_add btn_add_actividad btn_add_actividad btn_add_actividad btn_add_actividad "
        "cuadro_material cuadro_material cuadro_material cuadro_material cuadro_material" 
        ;
}


.cuadro3 {
    padding: 1rem;
    display: grid;
    height: auto;
    flex-shrink: 0;
    width: 80%;
    border: 1px solid black;
    border-radius: 5px;
    min-height: 20%;
    min-width: fit-content;
    grid-gap: 2rem;
    grid-template-columns: repeat(8, .3fr);
    grid-template-areas:

        "label_materialAlum_actividad_add label_materialAlum_actividad_add btn_add_actividadAlum btn_add_actividadAlum btn_add_actividadAlum btn_add_actividadAlum btn_add_actividadAlum btn_add_actividadAlum"
        "cuadro_material cuadro_material cuadro_material cuadro_material cuadro_material cuadro_material cuadro_material cuadro_material";

}

.cuadro4 {
    padding: 1rem;
    display: grid;
    height: auto;
    flex-shrink: 0;
    width: 80%;
    border: 1px solid black;
    border-radius: 5px;
    min-height: 20%;
    min-width: fit-content;
    grid-gap: 2rem;
    grid-template-columns: repeat(8, .3fr);
    grid-template-areas:
        "label_materialdado_actividad_add label_materialdado_actividad_add label_materialdado_actividad_add btn_add_actividad btn_add_actividad btn_add_actividad btn_add_actividad btn_add_actividad"
        "label_materialdado_actividad input_materialdado_actividad input_materialdado_actividad input_materialdado_actividad input_materialdado_actividad input_materialdado_actividad input_materialdado_actividad input_materialdado_actividad";

}

.cuadro5 {
    padding: 1rem;
    display: grid;
    height: auto;
    flex-shrink: 0;
    width: 80%;
    border: 1px solid black;
    border-radius: 5px;
    min-height: 20%;
    min-width: fit-content;
    grid-gap: 2rem;
    grid-template-columns: repeat(8, .3fr);
    grid-template-areas:

        "label_cenombre_actividad input_cenombre_actividad input_cenombre_actividad input_cenombre_actividad input_cenombre_actividad input_cenombre_actividad input_cenombre_actividad input_cenombre_actividad"
        "label_cedes_actividad input_cedes_actividad input_cedes_actividad input_cedes_actividad input_cedes_actividad input_cedes_actividad input_cedes_actividad input_cedes_actividad"

    ;

}

.cuadro6 {
    padding: 1rem;
    display: grid;
    height: auto;
    flex-shrink: 0;
    width: 80%;
    border: 1px solid black;
    border-radius: 5px;
    min-height: 20%;
    min-width: fit-content;
    grid-gap: 2rem;
    grid-template-columns: repeat(8, .3fr);
    grid-template-areas:

        "label_feini_actividad input_feini_actividad input_feini_actividad input_feini_actividad label_fefin_actividad input_fefin_actividad input_fefin_actividad input_fefin_actividad"
        "label_pnombre_actividad input_pnombre_actividad input_pnombre_actividad input_pnombre_actividad input_pnombre_actividad input_pnombre_actividad input_pnombre_actividad input_pnombre_actividad"
    ;

}

.cuadro7 {
    padding: 1rem;
    display: flex;
    flex-direction: column;
    height: auto;
    flex-shrink: 0;
    width: 80%;
    border: 1px solid black;
    border-radius: 5px;
    min-height: 20%;
    min-width: fit-content;
    grid-gap: 2rem;
    grid-template-columns: repeat(8, .3fr);
    grid-template-areas:
        "label_temNombre_actividad label_temNombre_actividad input_temNombre_actividad input_temNombre_actividad input_temNombre_actividad input_temNombre_actividad input_temNombre_actividad input_temNombre_actividad"
        "label_temsema_actividad label_temsema_actividad input_temsema_actividad input_temsema_actividad input_temsema_actividad input_temsema_actividad input_temsema_actividad input_temsema_actividad"
        "label_temdes_actividad label_temdes_actividad input_temsdes_actividad input_temsdes_actividad input_temsdes_actividad input_temsdes_actividad input_temsdes_actividad input_temsdes_actividad"
        "btn_Eliminar_temas btn_Eliminar_temas btn_Eliminar_temas btn_Eliminar_temas btn_Eliminar_temas btn_Eliminar_temas btn_Eliminar_temas btn_Eliminar_temas"
        ;
}

.cuadro8 {
    padding: 1rem;
    display: flex;
    flex-direction: column;
    height: auto;
    flex-shrink: 0;
    width: 80%;
    border: 1px solid black;
    border-radius: 5px;
    min-height: 20%;
    min-width: fit-content;
    grid-gap: 2rem;
    grid-template-columns: repeat(8, .3fr);
    grid-template-areas:
        " input_materialdado_actividad input_materialdado_actividad input_materialdado_actividad input_materialdado_actividad input_materialdado_actividad input_materialdado_actividad input_materialdado_actividad input_materialdado_actividad"
        "label_cantidad_material label_cantidad_material  input_cantidad_material input_cantidad_material input_cantidad_material input_cantidad_material input_cantidad_material input_cantidad_material"
        "btn_elimaner_material btn_elimaner_material btn_elimaner_material btn_elimaner_material btn_elimaner_material btn_elimaner_material btn_elimaner_material btn_elimaner_material";
}

.cuadro9 {
    padding: 1rem;
    display: grid;
    height: auto;
    flex-shrink: 0;
    width: 80%;
    border: 1px solid black;
    border-radius: 5px;
    min-height: 20%;
    min-width: fit-content;
    grid-gap: 2rem;
    grid-template-columns: repeat(8, .3fr);
    grid-template-areas:

        "label_tema_add label_tema_add btn_add_temas btn_add_temas btn_add_temas btn_add_temas btn_add_temas btn_add_temas"
        "cuadro_tema cuadro_tema cuadro_tema cuadro_tema cuadro_tema cuadro_tema cuadro_tema cuadro_tema";
    }



}

.flecha {
    width: 10%;
    height: 100%;
    min-width: 30px;
    max-height: 30px;
}

.footer {
    width: auto;
    min-width: fit-content;
    margin-top: auto;
    justify-self: end;
}

.header {
    width: auto;
    min-width: fit-content;
}

input {
    height: 2rem;
}

label {
    height: 2rem;
}

.titulo {
    justify-self: center;
    margin-left: auto;
}

ul.navega li {
  display: inline;
  padding-right: 0.5em;
}
</style>

<body>

    <div class="contenido2">
        <?php include "../../../views/layout/header.php" ?>
        <div class="cabecera">
            <h1 class="titulo">Gestionar Actividad</h1>
            <a href="#"><img class="flecha" src="../../.././assets/img/back.png"></a>
        </div>

        <div class="contenedor-tabla content-table">
            <div style="overflow: auto;">
                <table id="tabla_avtividad"></table>
            </div>

        </div>

        <center>
            <div class="cabecera">
                <h2 class="titulo">Agregar Actividad</h2>
            </div>
        </center>

        <div class="cuadro1">
            <input id="input_id_actividad" type="text" hidden />
            <label class="label1">Nombre</label>
            <input class="input1" id="input_nombre_actividad" type="text" placeholder="Nombre de la actividad">

            <label class="label2">Créditos</label>
            <input class="input2" id="input_credito_activida" type="text"
                placeholder="Total de creditos por esta actividad">

            <label class="label3">Actividad padre</label>
            <input class="input3" id="input_padre_activida" type="text" placeholder="Actividad Padre"
                list="select_actividad">
            <datalist id="select_actividad" style="width: 45% !important;">

            </datalist>
            <button class="btn6 btn btn-dark" data-bs-toggle="modal" data-bs-target="">+</button>



            <label class="label4">Capacidad Maxima</label>
            <input class="input4" id="input_cMax_activida" type="text" placeholder="Capacidad Max">

            <label class="label5">Capacidad Minima</label>
            <input class="input5" id="input_cMin_activida" type="text" placeholder="Capacidad Minima">

            <label class="label6">Descripción</label>
            <textarea class="input6" id="input_descripcion_actividad" placeholder="Descripción" type="text"
                required></textarea>

            <label class="label7">Competencia</label>
            <textarea class="input7" id="input_competencia_actividad" placeholder="Competencia" type="text"
                required></textarea>

            <label class="label8">Beneficios</label>
            <textarea class="input8" id="input_beneficios_actividad" placeholder="Beneficios" type="text"
                required></textarea>

        </div>


        <center>
            <div class="cabecera">
                <h2 class="titulo">Material Necesario</h2>
            </div>
        </center>

        <div class="cuadro2" id="cuadro2">

            <button class="btn7 btn btn-primary" id="add_Material" data-bs-target="">Agregar Material</button>
            <label class="label19">Agregar nuevo matetial</label>
            <input id="input_id_material" type="text" hidden />
            
            <div class="input21" >
                <center>    
                <ul style="list-style:none;" id="listaElemento">
                    <li >
                        <div class="cuadro8">
                            <label class='label9'>Material</label>
                            <input class="input9 form-control"  id="input_material_actividad" placeholder="Material" type="text" required></textarea>
                            <label class="label20">Cantidad</label>
                            <input class="input20" id="input_cantidad_material" type="text" placeholder="Cantidad">
                            <button class="btn8 btn-danger cancelar" onclick='eliminar(this)' id="Eliminar_Material">Eliminar Material</button>
                        </div> 
                    </li>
                </ul>
                </center>   
            </div>
        </div>

        <center>
            <div class="cabecera">
                <h2 class="titulo">Material Por Parte Del Estudiante</h2>
            </div>
        </center>

        <div class="cuadro3">
            <label class="label22">Agregar nuevo matetial</label>
            <button class="btn9 btn btn-primary" id="add_Material_alumnos" data-bs-target="">Agregar Material</button>
            <input id="input_id_material_alumno" type="text" hidden />

            <div class="input21" >
                <center>    
                <ul style="list-style:none;" id="listaElementoAlumno">
                    <li >
                        <div class="cuadro8">
                            <label class='label9'>Material</label>
                            <input class="input9 form-control"  id="input_material_alumno_actividad" placeholder="Material" type="text" required></textarea>
                            <label class="label20">Cantidad</label>
                            <input class="input20" id="input_cantidad_alumno_material" type="text" placeholder="Cantidad">
                            <button class="btn8 btn-danger cancelar" onclick='eliminarME(this)' id="Eliminar_Material_alumno">Eliminar Material</button>
                        </div> 
                    </li>
                </ul>
                </center>   
            </div>

        </div>



        <center>
            <div class="cabecera">
                <h2 class="titulo">Temas</h2>
            </div>
        </center>

        <div class="cuadro9">
            <label class="label23">Agregar Tema</label>
            <button class="btn10 btn btn-primary" id="add_Temas" data-bs-target="">Agregar Material</button>
            <input id="input_id_tema" type="text" hidden />
            
             <div class="input22">
                <center>
                    <ul style="list-style:none;" id="listaElementoTemas">
                        <li>
                            <div class="cuadro7">
                                <input id="input_id_temas" type="text" hidden />
                                <label class="label11">Tema</label>
                                <input class="input11" id="input_temNombre_activida" type="text" placeholder="Nombre">

                                <label class="label12">Duración</label>
                                <input class="input12" id="input_temSemanas_activida" type="date" placeholder="Semanas de Duración">

                                <label class="label13">Descripción</label>
                                <textarea class="input13" id="input_temDescripcion_actividad" placeholder="Descripción" type="text" required></textarea>
                                <button class="btn8 btn-danger cancelar" onclick='eliminarTE(this)' id="Eliminar_Tema">Eliminar Material</button>
                            </div>
                        </li>
                    </ul>
                </center>

            </div>          

        </div>

        <center>
            <div class="cabecera">
                <h2 class="titulo">Criterios de Evaluación</h2>
            </div>
        </center>

        <div class="cuadro5">
            <input id="input_id_criteriosEvaluacion" type="text" hidden />
            <label class="label14">Nombre</label>
            <input class="input14" id="input_criterioevalNombre_activida" type="text" placeholder="Nombre">

            <label class="label15">Descripción</label>
            <textarea class="input15" id="input_criterioevaldes_actividad" placeholder="Descripción" type="text"
                required></textarea>

        </div>

        <center>
            <div class="cabecera">
                <h2 class="titulo">Periodo de la Actividad</h2>
            </div>
        </center>

        <div class="cuadro6">
            <input id="input_id_periodoact" type="text" hidden />
            <label class="label16">Inicio</label>
            <input class="input16" id="input_fechainicio_activida" type="date" placeholder="Inicio de la actividad">

            <label class="label17">Fin</label>
            <input class="input17" id="input_fechafin_activida" type="date" placeholder="Fin de la actividad">

            <label class="label18">Periodo</label>
            <input class="input18" id="input_nombresemestre_activida" type="text" placeholder="Nombre del Periodo">



        </div>
        <div class="botones2">
            <button class="btn btn-success">Guardar Todo</button>
            <button class="btn btn-danger cancelar">Cancelar Actividad</button>
        </div>




        <?php include "../../../views/layout/footer.php" ?>
    </div>
    <script src="../../../js/actividad.js"></script>

</body>

</html>