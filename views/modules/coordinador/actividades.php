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
    <title>SiGAC</title>

    <!-- IMPORTS -->
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
}

.dataTable {
    overflow-x: auto !important;
}

.dataTables_wrapper{
    overflow-x: auto;
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

.label7 {
    grid-area: label_compe_actividad;
    text-align: center;
}

.input7 {
    grid-area: input_compe_actividad;
}

.label8 {
    grid-area: label_bene_actividad;
    text-align: center;
}

.input8 {
    grid-area: input_bene_actividad;
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

.label19 {
    grid-area: label_cantidad_material;
    text-align: center;
}

.input19 {
    grid-area: input_cantidad_material;

}

.lable_Agregar {
    grid-area: label_Agregar_Elemento;
    text-align: center;
}

.btn1 {
    grid-area: btn_padre_actividad;
}

.btn_Agregar {
    grid-area: btn_Agregar_Elemento;
}

.btn_Eliminar {
    grid-area: btn_Eliminar_Elemento;
}

.cuadro_material_necesario {
    grid-area: cuadro_material;
}

.cuadro_temas {
    grid-area: cuadro_tema;
}

.cuadro_criterios{
    grid-area: cuadro_criteriosE;
}

.label_video_actividad{
    grid-area: label_video_actividad;
}

.input_video_actividad{
    grid-area: input_video_actividad;
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
        "label_feini_actividad input_feini_actividad input_feini_actividad input_feini_actividad label_fefin_actividad input_fefin_actividad input_fefin_actividad input_fefin_actividad" 
        "label_video_actividad label_video_actividad input_video_actividad input_video_actividad input_video_actividad input_video_actividad input_video_actividad input_video_actividad"
        "label_actPAdre_actividad label_actPAdre_actividad input_actPAdre_actividad input_actPAdre_actividad input_actPAdre_actividad input_actPAdre_actividad input_actPAdre_actividad btn_padre_actividad"
        ;

}

.cuadro2 {

    padding: 1rem;
    display: grid;
    height: auto;
    flex-shrink: 0;
    width: auto;
    border: 1px solid black;
    border-radius: 5px;
    min-height: 20%;
    min-width: fit-content;
    grid-gap: 2rem;
    grid-template-columns: repeat(8, .3fr);
    grid-template-areas:
        "cuadro_material cuadro_material cuadro_material cuadro_material cuadro_material cuadro_material cuadro_material cuadro_material" 
        "label_Agregar_Elemento label_Agregar_Elemento btn_Agregar_Elemento btn_Agregar_Elemento btn_Agregar_Elemento btn_Agregar_Elemento btn_Agregar_Elemento btn_Agregar_Elemento"

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

        "cuadro_material cuadro_material cuadro_material cuadro_material cuadro_material cuadro_material cuadro_material cuadro_material"
        "label_Agregar_Elemento label_Agregar_Elemento btn_Agregar_Elemento btn_Agregar_Elemento btn_Agregar_Elemento btn_Agregar_Elemento btn_Agregar_Elemento btn_Agregar_Elemento"

        ;

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
        "label_materialdado_actividad input_materialdado_actividad input_materialdado_actividad input_materialdado_actividad label_cantidad_material input_cantidad_material input_cantidad_material btn_Eliminar_Elemento btn_Eliminar_Elemento"
        "label_Agregar_Elemento label_Agregar_Elemento label_Agregar_Elemento btn_Agregar_Elemento btn_Agregar_Elemento btn_Agregar_Elemento btn_Agregar_Elemento btn_Agregar_Elemento"

        ;

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

    "cuadro_criteriosE cuadro_criteriosE cuadro_criteriosE cuadro_criteriosE cuadro_criteriosE cuadro_criteriosE cuadro_criteriosE cuadro_criteriosE"
    "label_Agregar_Elemento label_Agregar_Elemento btn_Agregar_Elemento btn_Agregar_Elemento btn_Agregar_Elemento btn_Agregar_Elemento btn_Agregar_Elemento btn_Agregar_Elemento"

    ;

}

.cuadro7 {
    padding: 1rem;
    display: grid;
    height: auto;
    flex-shrink: 0;
    width: auto;
    border: 1px solid black;
    border-radius: 5px;
    min-height: 80%;
    min-width: fit-content;
    grid-gap: 2rem;
    grid-template-columns: repeat(8, .3fr);
    grid-template-areas:
        "label_temNombre_actividad input_temNombre_actividad input_temNombre_actividad input_temNombre_actividad label_temsema_actividad input_temsema_actividad input_temsema_actividad input_temsema_actividad  "
        "label_temdes_actividad label_temdes_actividad input_temsdes_actividad input_temsdes_actividad input_temsdes_actividad input_temsdes_actividad input_temsdes_actividad input_temsdes_actividad"
        "btn_Eliminar_Elemento btn_Eliminar_Elemento btn_Eliminar_Elemento btn_Eliminar_Elemento btn_Eliminar_Elemento btn_Eliminar_Elemento btn_Eliminar_Elemento btn_Eliminar_Elemento"
        ;
}

.cuadro8 {
    padding: 1rem;
    display: grid;
    height: 60%;
    flex-shrink: 0;
    width: 60%;
    border: 1px solid black;
    border-radius: 5px;
    min-height: 20%;
    min-width: fit-content;
    grid-gap: 2rem;
    grid-template-columns: repeat(10, .3fr);
    grid-template-areas:
        "label_materialdado_actividad input_materialdado_actividad input_materialdado_actividad input_materialdado_actividad label_cantidad_material input_cantidad_material input_cantidad_material btn_Eliminar_Elemento  btn_Eliminar_Elemento";
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

        "cuadro_tema cuadro_tema cuadro_tema cuadro_tema cuadro_tema cuadro_tema cuadro_tema cuadro_tema"
        "label_Agregar_Elemento label_Agregar_Elemento btn_Agregar_Elemento btn_Agregar_Elemento btn_Agregar_Elemento btn_Agregar_Elemento btn_Agregar_Elemento btn_Agregar_Elemento"
;
    }

.cuadro10{
    padding: 1rem;
    display: grid;
    height: auto;
    flex-shrink: 0;
    width: auto;
    border: 1px solid black;
    border-radius: 5px;
    min-height: 20%;
    min-width: fit-content;
    grid-gap: 2rem;
    grid-template-columns: repeat(5, .3fr);
    grid-template-areas:
        "label_cenombre_actividad input_cenombre_actividad input_cenombre_actividad btn_Eliminar_Elemento btn_Eliminar_Elemento"
        "label_cedes_actividad input_cedes_actividad input_cedes_actividad input_cedes_actividad input_cedes_actividad"
        
        ;

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

.menu{
  display: flex;
  width: auto;  
}

.menu p{
  margin-right: 2rem;
  cursor: pointer;
}

[data-content]{
  display: none;
}

.active[data-content]{
    display: flex;
    flex-direction: column;
    width: 100%;
    justify-content: center;
    align-items: center;
}

.container{
    width: 80%;
    text-align: center;
}


.contenedor_semanas_descripcion{
    display: flex;
    flex-direction: column;
    color: red;
    font-style: italic;
    
    
    
}

.descripcion_insercion_correo{
    font-size: 11px !important;
    margin: 0 !important;
    

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
            <h1 class="titulo">Gestionar Actividad</h1>
            <a href="http://localhost/Extraescolares/views/modules/coordinador/coordinador.php"><img class="flecha" src="../../.././assets/img/back.png"></a>
        </div>
        

        <div class="menu cabecera">
            <p data-taget="#principal" id="tapPrincipal">Principal</p>
            <p data-taget="#agregarActividad">Agregar Actividad</p>
            <p data-taget="#materialNecesario">Material Necesario</p>
            <p data-taget="#materialNecesarioEstu">Material Estudiante</p>
            <p data-taget="#temas">Temas</p>
            <p data-taget="#criterrios">Criteros</p>
         </div>

        
        <div class="container">
            <div data-content id="principal" >
                <div class="contenedor-tabla content-table">
                    
                <center><table id="tabla_actividad"></table></center>
                    

                </div>
            </div>

            <div data-content id="agregarActividad">
                
                    <div class="cabecera">
                    <center> <h2 class="titulo">Agregar Actividad</h2> </center>
                    </div>
                

                    <div class="cuadro1">
            
                    <input id="input_id_actividad" type="text" hidden />
                    <input id="input_id_programa" type="text" value=<?php echo $_SESSION['id_programa']?> hidden />
                    <label class="label1">Nombre</label>
                    <input class="input1 form-control" id="input_nombre_actividad" type="text" placeholder="Nombre de la actividad">
                    <label class="label2">Créditos</label>
                    <input class="input2 form-control" id="input_creditos_actividad" type="number" value="1">
                    <label class="label3">Actividad padre</label>
                    <input class="input3 form-control" id="input_padre_actividad" type="text" placeholder="Actividad Padre" list="select_actividad">
                    <datalist id="select_actividad" style="width: 45% !important;"> </datalist>
                    <button class="btn1 btn btn-dark" data-bs-toggle="modal" data-bs-target="">+</button>
                    <label class="label4">Capacidad Maxima</label>
                    <input class="input4 form-control" id="input_cMax_actividad" type="number" placeholder="Capacidad Maxima">
                    <label class="label5">Capacidad Minima</label>
                    <input class="input5 form-control" id="input_cMin_actividad" type="number" placeholder="Capacidad Minima">
                    <label class="label6">Descripción</label>
                    <textarea class="input6 form-control" id="input_descripcion_actividad" placeholder="Descripción" type="text" required></textarea>
                    <label class="label7">Competencia</label>
                    <textarea class="input7 form-control" id="input_competencia_actividad" placeholder="Competencia" type="text" required></textarea>
                    <label class="label8">Beneficios</label>
                    <textarea class="input8 form-control" id="input_beneficios_actividad" placeholder="Beneficios" type="text" required></textarea>
                    <label class="label16">Fecha Inicio</label>
                    <input class="input16 form-control" id="input_fechainicio_actividad" type="date" placeholder="Inicio de la actividad">
                    <label class="label17">Fecha Fin</label>
                    <input class="input17 form-control " id="input_fechafin_actividad" type="date" placeholder="Fin de la actividad">
                    <label class="label_video_actividad">Video de Actividad</label>
                    <input class="input_video_actividad" id="input_video_actividad" type="file" accept="video/mp4,video/x-m4v,video/*"/>
                </div>
                <div class="botones2">
                    <button class="btn btn-success" id="btn_insert_update_actividad" onclick="insert_actividad()">Guardar Actividad</button>
                    <button class="btn btn-danger cancelar" onclick="borrar_datos_input_actividad()">Cancelar</button>
                </div>
            </div>

            <div data-content id="materialNecesario">
                
                    <div class="cabecera">
                        <center><h2 class="titulo">Material Necesario</h2></center>
                    </div>
                
                
                <div class="cuadro2">

                    <button class="btn_Agregar btn btn-primary" id="add_Material" data-bs-target="">Agregar Material</button>
                    <label class="lable_Agregar">Agregar nuevo matetial</label>
                    <input id="input_id_material" type="text" hidden />
            
                    <div class="cuadro_material_necesario" >
                   
                            <ul style="list-style:none;" id="listaElemento">
                                <li >
                                    <div class="cuadro8">
                                        <label class='label9'>Material</label>
                                        <input class="input9 form-control input_material_actividad"  id="input_material_actividad" placeholder="Material" type="text" required>
                                        <label class="label19">Cantidad</label>
                                        <input class="input19 form-control input_cantidad_material" id="input_cantidad_material" type="number" placeholder="Cantidad">
                                        <button class="btn_Eliminar btn-danger cancelar" onclick='eliminar(this)' id="Eliminar_Material">Eliminar Material</button>
                                    </div> 
                                </li>
                            </ul>
                        
                    </div>
                </div>
                <div class="botones2">
                    <button class="btn btn-success" onclick="insertar_material_actividad()">Guardar Material</button>
                    <button class="btn btn-danger cancelar" onclick="borrar_materiales_actividad()">Cancelar</button>
                </div>
            </div>
            

            <div data-content id="materialNecesarioEstu">
                
                    <div class="cabecera">
                        <center><h2 class="titulo">Material Por Parte Del Estudiante</h2></center>
                    </div>
                
                    
                <div class="cuadro3">
                    <label class="lable_Agregar">Agregar nuevo matetial</label>
                    <button class="btn_Agregar btn btn-primary" id="add_Material_alumnos" data-bs-target="">Agregar Material</button>
                    <input id="input_id_material_alumno" type="text" hidden />
            
                    <div class="cuadro_material_necesario" >
                          
                            <ul style="list-style:none;" id="listaElementoAlumno">
                                <li >
                                    <div class="cuadro8">
                                        <label class='label9'>Material</label>
                                        <input class="input9 form-control input_material_alumno_actividad"  id="input_material_alumno_actividad" placeholder="Material" type="text" required></input>
                                        <label class="label19">Cantidad</label>
                                        <input class="input19 form-control input_cantidad_alumno_material" id="input_cantidad_alumno_material" type="number" placeholder="Cantidad">
                                        <button class="btn_Eliminar btn-danger cancelar" onclick='eliminar(this)' id="Eliminar_Material_alumno">Eliminar Material</button>
                                    </div> 
                                </li>
                            </ul>
                           
                    </div>
                </div>
                <div class="botones2">
                    <button class="btn btn-success" onclick="insertar_material_alumno()">Guardar Material</button>
                    <button class="btn btn-danger cancelar" onclick="borrar_materiales_alumno()">Cancelar</button>
                </div>
            </div>

            <div data-content id="temas">
            
                <div class="cabecera">
                    <center><h2 class="titulo">Temas</h2></center>
                </div>
            
                
            <div class="cuadro9">
                <label class="lable_Agregar">Agregar Tema</label>
                <button class="btn_Agregar btn btn-primary" id="add_Temas" data-bs-target="">Agregar Material</button>
                <input id="input_id_tema" type="text" hidden />
            
                <div class="cuadro_temas">
                    
                        <ul style="list-style:none;" id="listaElementoTemas">
                            <li>
                                <div class="cuadro7" style="margin-top:10px;">
                                    <input id="input_id_temas" type="text" hidden />
                                    <label class="label11">Tema</label>
                                    <input class="input11 form-control input_temNombre_activida" id="input_temNombre_activida" type="text" placeholder="Nombre">

                                    <label class="label12">Duración</label>
                                    
                                    <div class="contenedor_input_correo_departamento contenedor_semanas_descripcion input12">
                                        <input class=" form-control input_temSemanas_activida" id="input_temSemanas_activida" type="number" placeholder="Semanas de Duración">
                                        <p class="descripcion_insercion_correo">Numero de Semanas</p>
                                    </div> 


                                    <label class="label13">Descripción</label>
                                    <textarea class="input13 form-control input_temDescripcion_actividad" id="input_temDescripcion_actividad" placeholder="Descripción" type="text" required></textarea>
                                    <button class="btn_Eliminar btn-danger cancelar" onclick='eliminar(this)' id="Eliminar_Tema">Eliminar Material</button>
                                </div>
                            </li>
                        </ul>
                    
                </div>   
                

            </div>
            <div class="botones2">
                    <button class="btn btn-success" onclick="insertar_temas()">Guardar Temas</button>
                    <button class="btn btn-danger cancelar" onclick="borrar_temas()">Cancelar</button>
                </div> 

            </div>
                <div data-content id="criterrios">
                    
                        <div class="cabecera">
                            <center><h2 class="titulo">Criterios de Evaluación</h2></center>
                        </div>
                         
                <div class="cuadro5">
                    <label class="lable_Agregar">Agregar Criterios</label>
                    <button class="btn_Agregar btn btn-primary" id="add_Criterio" data-bs-target="">Agregar Material</button>
                    <input id="input_id_criterios" type="text" hidden />

                        <div class="cuadro_criterios">
                            
                                <ul style="list-style:none;" id="listaElementoCriterios">
                                    <li>
                                        <div class="cuadro10">
                                            <label class="label14">Nombre</label>
                                            <input class="input14 form-control input_criterioevalNombre_activida" id="input_criterioevalNombre_activida" type="text" placeholder="Nombre">
                                            <label class="label15">Descripción</label>
                                            <textarea class="input15 form-control input_criterioevaldes_actividad" id="input_criterioevaldes_actividad" placeholder="Descripción" type="text" required></textarea>
                                            <button class="btn_Eliminar btn-danger cancelar" onclick='eliminar(this)' id="Eliminar_Material">Eliminar Material</button>
                                        </div>
                                    </li>
                                </ul>
                            
                        </div>
                </div>
                <div class="botones2">
                    <button class="btn btn-success" onclick="insertar_criterios_evaluacion()">Guardar Criterios</button>
                    <button class="btn btn-danger cancelar" onclick="borrar_criterios_evaluacion()">Cancelar</button>
                </div>
            </div>
            
        </div> <!--container-->

        <div class="modal fade" id="modal_borrar_actividad" tabindex="-1" aria-labelledby="modal_borrar_actividad_label"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal_borrar_actividad_label">Borrar Actividad</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <div class="w-100">
                            <h3>Seguro que quiere borrar la actividad?</h1>
                            <p id="p_nombre_actividad"></p>
                            <p id="p_descripcion_actividad"></p>
                            <p id="p_competencia_actividad"></p>
                            <p id="p_creditos_actividad"></p>
                            <p id="p_beneficios_actividad"></p>
                            <p id="p_capacidad_min_actividad"></p>
                            <p id="p_capacidad_max_actividad"></p>
                            <p id="p_fecha_inicio_actividad"></p>
                            <p id="p_fecha_fin_actividad"></p>
                            <input id="input_id_actividad_borrar" type="text" hidden />
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-evenly">
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-danger" onclick="borrar_actividad()">Borrar</button>
                    </div>
                </div>
            </div>
        </div>
        <?php include "../../../views/layout/footer.php" ?>
    </div>
    <script src="../../../js/actividad.js"></script>

</body>
</html>
