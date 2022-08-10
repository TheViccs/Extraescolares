$(document).ready(function() {$('#listaElemento input[type="text"]').val('');})

//Agregar Material Dado por la escuela
var boton = document.getElementById("add_Material");
boton.addEventListener("click", function () {
    $( "#listaElemento" ).append( "<li id='listaElemento' > <div class='cuadro8' style='margin-top:10px;'> <label class='label9'>Material</label> <input class='input9 form-control input_material_actividad'  id='input_material_actividad' placeholder='Material' type='text' required> <label class='label19'>Cantidad</label> <input class='input19 form-control input_cantidad_material' id='input_cantidad_material' type='number' placeholder='Cantidad'> <button class='btn_Eliminar btn-danger cancelar' onclick='eliminar(this)' id='Eliminar_Material'>Eliminar Material</button> </div>  </li>" );
}, false);

function eliminar(obj){
    $(obj).parent().parent().remove();
}

//Agregar Material por parte del estudiamte
var boton = document.getElementById("add_Material_alumnos");
boton.addEventListener("click", function () {
    $( "#listaElementoAlumno" ).append( "<li id='listaElementoAlumno' > <div class='cuadro8' style='margin-top:10px;'> <label class='label9'>Material</label> <input class='input9 form-control input_material_alumno_actividad' id='input_material_alumno_actividad' placeholder='Material' type='text' required> <label class='label19'> Cantidad </label> <input class='input19 form-control input_cantidad_alumno_material' id='input_cantidad_alumno_material' type='number' placeholder='Cantidad'> <button class='btn_Eliminar btn-danger cancelar' onclick='eliminar(this)' id='Eliminar_Material_alumno'>Eliminar Material</button> </div> </li>" );
}, false);

//Agregar Tema
var boton = document.getElementById("add_Temas");
boton.addEventListener("click", function () {
    $( "#listaElementoTemas" ).append( "<li> <div class='cuadro7' style='margin-top:10px;'> <input id='input_id_temas' type='text' hidden /> <label class='label11'>Tema</label> <input class='input11 form-control input_temNombre_activida' id='input_temNombre_activida' type='text' placeholder='Nombre'> <label class='label12'>Duración</label> <div class='contenedor_input_correo_departamento contenedor_semanas_descripcion input12'><input class='form-control input_temSemanas_activida' id='input_temSemanas_activida' type='number' placeholder='Semanas de Duración'> <p class='descripcion_insercion_correo'>Numero de Semanas</p> </div> <label class='label13'>Descripción</label> <textarea class='input13 form-control input_temDescripcion_actividad' id='input_temDescripcion_actividad' placeholder='Descripción' type='text' required></textarea> <button class='btn_Eliminar btn-danger cancelar' onclick='eliminar(this)' id='Eliminar_Tema'>Eliminar Material</button></div> </li>" );
}, false);

//Eliminar cuadros
function eliminar(obj){
    $(obj).parent().parent().remove();
}




const tagets = document.querySelectorAll('[data-target]');
const content = document.querySelectorAll('[data-content]');

$( document ).ready(function() {
    $('#tapPrincipal').click()
  });

tagets.forEach(taget =>{
    taget.addEventListener('click',(e) => {
        console.log(content)
        content.forEach(c => {
            c.classList.remove('active')
        })
        const t = document.querySelector(e.currentTarget.dataset.target)
        t.classList.add('active')
    })
})


//TABLA DE ACTIVIDADES
$('#tabla_actividad').DataTable({
    pageLength: 20,
    caseInsen: false,
    columns: [
        { data: "nombre", title: 'Nombre' },
        { data: "creditos", title: 'Creditos' },
        { data: "capMin", title: 'Capacidad Mínima' },
        { data: "capMax", title: 'Capacidad Máxima' },
        { data: "inicio", title: 'Inicio' },
        { data: "fin", title: 'Fin' },
        { data: "botoneditar", title: 'Editar' },
        { data: "botonborrar", title: 'Borrar' },
        { data: "botonimprimir", title: 'Imprimir' },
        { data: "botongrupos", title: 'Gestionar Grupos' }
    ],
    "columnDefs": [
        { "orderable": false, "targets": [6, 7, 8, 9] },
    ],
    dom:'Bfrtip' ,
    buttons: [
        { 
            extend: "excelHtml5",
            text: "Exportar a Excel",
            exportOptions: {
                columns: [0,1,2,3,4,5]
            },
            filename: "Actividades",
            title: "Actividades"
        }
    ],
    lengthChange: false,
    language: {
        "decimal": "",
        "emptyTable": "No hay información",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
        "infoEmpty": "Mostrando 0 de 0 de 0 Entradas",
        "infoFiltered": "(Filtrado de _MAX_ total entradas)",
        "infoPostFix": "",
        "thousands": ",",
        "lengthMenu": "Mostrar _MENU_ Entradas",
        "loadingRecords": "Cargando...",
        "processing": "Procesando...",
        "search": "Buscar:",
        "zeroRecords": "Sin resultados encontrados",
        "paginate": {
            "first": "Primero",
            "last": "Ultimo",
            "next": "Siguiente",
            "previous": "Anterior"
        }
    },
});

function select_actividades(){
    let id_programa = $("#input_id_programa").val();
    $.ajax({
        type: "POST",
        data: {"id_programa": id_programa},
        url: path+"select_actividades_programa_id.php",                           
        success: function(res){    
            let actividades = JSON.parse(res);
            agregar_actividades_tabla(actividades);
            agregar_actividades_select(actividades)
        }
    });
}
select_actividades();


function agregar_actividades_tabla(actividades){
    let tabla = $("#tabla_actividad").DataTable();
    tabla.rows().remove().draw();
    for(let actividad of actividades){
        tabla.row.add({"nombre":actividad.nombre, "creditos":actividad.creditos_otorga, "capMin":actividad.capacidad_min,"capMax":actividad.capacidad_max,"inicio":actividad.fecha_inicio,"fin":actividad.fecha_fin,"botoneditar":"<button id='botoneditar"+ actividad.id_actividad+"'class='btn btn-primary'> Editar </button>", "botonborrar": "<button id='botonborrar"+actividad.id_actividad+"'class='btn btn-danger' >Borrar</button>", "botonimprimir":"<button id='botonimprimir"+actividad.id_actividad+"' class= 'btn btn-dark'>Imprimir</button>","botongrupos": "<button id='botongrupos"+actividad.id_actividad+"' class= 'btn btn-dark'>Gestionar Grupos</button>"}).draw();
        $("#botoneditar"+actividad.id_actividad).on( "click", function(){select_actividad_id(actividad.id_actividad)});
        $("#botonborrar"+actividad.id_actividad).on( "click", function(){mostrar_modal_borrar_actividad(actividad.id_actividad, actividad.nombre, actividad.descripcion, actividad.competencia, actividad.creditos_otorga, actividad.beneficios,actividad.capacidad_min,actividad.capacidad_max,actividad.fecha_inicio,actividad.fecha_fin)});
        $("#botonimprimir"+actividad.id_actividad).on( "click", function(){generar_pdf(actividad.id_actividad)});
        $("#botongrupos"+actividad.id_actividad).on( "click", function(){crear_grupos(actividad.id_actividad)});
    }
}

function agregar_actividades_select(actividades){
    $("#select_actividad").html("");
    for(let actividad of actividades){
        $("#select_actividad").append("<option id="+actividad.id_actividad+" value='"+actividad.nombre+"'></option>");
    }
}

function insert_actividad(){
    let nombre = $("#input_nombre_actividad").val();
    let creditos = $("#input_creditos_actividad").val();
    let capacidad_max = $("#input_cMax_actividad").val();
    let capacidad_min = $("#input_cMin_actividad").val();
    let descripcion = $("#input_descripcion_actividad").val();
    let competencia = $("#input_competencia_actividad").val();
    let beneficios = $("#input_beneficios_actividad").val();
    let fecha_inicio = $("#input_fechainicio_actividad").val();
    let fecha_fin = $("#input_fechafin_actividad").val();
    let id_programa = $("#input_id_programa").val();
    let video = $("#input_video_actividad")[0].files[0];
    let form_data = new FormData();
    form_data.append("nombre",nombre);
    form_data.append("creditos",creditos);
    form_data.append("capacidad_max",capacidad_max);
    form_data.append("capacidad_min",capacidad_min);
    form_data.append("descripcion",descripcion);
    form_data.append("competencia",competencia);
    form_data.append("beneficios",beneficios);
    form_data.append("fecha_inicio",fecha_inicio);
    form_data.append("fecha_fin",fecha_fin);
    form_data.append("id_programa",id_programa);
    if(nombre.length !== 0 && creditos.length !== 0 && capacidad_max.length !== 0 && capacidad_min.length !== 0 && fecha_inicio.length !== 0 && fecha_fin.length !== 0 && id_programa.length !== 0){
        let val = $("#input_padre_actividad").val(); 
        let id_actividad = $("#select_actividad option[value='"+val+"']").attr("id");
        let actividad_padre;
        if(id_actividad!==undefined){
            actividad_padre = id_actividad;
        }else{
            actividad_padre = "";
        }
        form_data.append("video",video);
        form_data.append("actividad_padre",actividad_padre);
        console.log(form_data);
        $.ajax({
            type: "POST",
            url: path+"insert_actividad.php",
            data: form_data,
            contentType: false,
            processData:false,
            success: function(res){
                console.log(res);
                borrar_datos_input_actividad();
                select_actividades();
                $("#input_id_actividad").val(parseInt(JSON.parse(res)[0].id_actividad_insertada));
                content.forEach(c => {
                    c.classList.remove('active')
                })
                const t = document.querySelector("#materialNecesario");
                t.classList.add('active')
                if (Number.isInteger(parseInt(JSON.parse(res)[0].id_actividad_insertada))) {
                    mostrar_alerta(1);
                }else{
                    mostrar_alerta(3);
                }
            }
        });
    }else{
        mostrar_alerta(2);
    }
}


function borrar_datos_input_actividad(){
    $("#input_nombre_actividad").val("");
    $("#input_creditos_actividad").val("");
    $("#input_cMax_actividad").val("");
    $("#input_cMin_actividad").val("");
    $("#input_descripcion_actividad").val("");
    $("#input_competencia_actividad").val("");
    $("#input_beneficios_actividad").val("");
    $("#input_fechainicio_actividad").val("");
    $("#input_fechafin_actividad").val("");
    $("#input_padre_actividad").val("");
    $("#btn_insert_update_actividad").attr("onclick","insert_actividad()");
}


function mostrar_modal_borrar_actividad(id_actividad, nombre, descripcion, competencia, creditos_otorga, beneficios,capacidad_min,capacidad_max,fecha_inicio,fecha_fin){
    $("#p_nombre_actividad").text("Nombre: "+nombre);
    $("#p_descripcion_actividad").text("Descripcion: "+descripcion);
    $("#p_competencia_actividad").text("Competencia: "+competencia);
    $("#p_creditos_actividad").text("Creditos que otorga: "+creditos_otorga);
    $("#p_beneficios_actividad").text("Beneficios: "+beneficios);
    $("#p_capacidad_min_actividad").text("Capacidad míninima: "+capacidad_min);
    $("#p_capacidad_max_actividad").text("Capacidad máxima: "+capacidad_max);
    $("#p_fecha_inicio_actividad").text("Fecha inicio: "+fecha_inicio);
    $("#p_fecha_fin_actividad").text("Fecha fin: "+fecha_fin);
    $("#input_id_actividad_borrar").val(id_actividad);
    $("#modal_borrar_actividad").modal("show");
}

function borrar_actividad(){
    let id_actividad = $("#input_id_actividad_borrar").val();
    $.ajax({
        type: "POST",
        url: path+"delete_actividad.php",  
        data: {"id_actividad": id_actividad} ,                         
        success: function(res){
            select_actividades();
            $("#modal_borrar_actividad").modal("hide");   
            if(res==="1"){
                mostrar_alerta(1);
            }else{
                mostrar_alerta(3)
            }
        }
    });
}


function insertar_material_actividad(){
    let id_actividad = $("#input_id_actividad").val();
    let nombre_materiales = document.querySelectorAll(".input_material_actividad");
    let cantidad_materiales = document.querySelectorAll(".input_cantidad_material");
    let array_materiales = [];
    for (let index = 0; index < nombre_materiales.length; index++) {
        array_materiales.push([nombre_materiales[index].value, cantidad_materiales[index].value]);    
    }
    let material_vacio = false;
    array_materiales.forEach(material => material.includes("") ? material_vacio=true : null);
    if(!material_vacio && id_actividad.length!==0){
        $.ajax({
            type: "POST",
            url: path+"insert_material_actividad.php",  
            data: {"id_actividad": id_actividad, "material_actividad": JSON.stringify(array_materiales)} ,                         
            success: function(res){
                mostrar_alerta(1);
                borrar_materiales_actividad();
                content.forEach(c => {
                    c.classList.remove('active')
                })
                const t = document.querySelector("#materialNecesarioEstu");
                t.classList.add('active')
            }
        });
    }else{
        mostrar_alerta(2);
    }
}

function borrar_materiales_actividad(){
    $( "#listaElemento" ).html("");
    $( "#listaElemento" ).append( "<li id='listaElemento' > <div class='cuadro8' style='margin-top: 10px;'> <label class='label9'>Material</label> <input class='input9 form-control input_material_actividad' id='input_material_actividad' placeholder='Material' type='text' required></input> <label class='label20'>Cantidad</label> <input class='input20 input_cantidad_material' id='input_cantidad_material' type='text' placeholder='Cantidad'> <button id='Eliminar_Material' onclick='eliminar(this)' class='btn8 btn-danger cancelar'>Eliminar Material</button></div> </li>" );
}


function insertar_material_alumno(){
    let id_actividad = $("#input_id_actividad").val();
    let nombre_materiales = document.querySelectorAll(".input_material_alumno_actividad");
    let cantidad_materiales = document.querySelectorAll(".input_cantidad_alumno_material");
    let array_materiales = [];
    for (let index = 0; index < nombre_materiales.length; index++) {
        array_materiales.push([nombre_materiales[index].value, cantidad_materiales[index].value]);    
    }
    let material_vacio = false;
    array_materiales.forEach(material => material.includes("") ? material_vacio=true : null);
    if(!material_vacio && id_actividad.length!==0){
        $.ajax({
            type: "POST",
            url: path+"insert_material_alumno.php",  
            data: {"id_actividad": id_actividad, "material_alumno": JSON.stringify(array_materiales)} ,                         
            success: function(res){
                mostrar_alerta(1);
                borrar_materiales_alumno();
                content.forEach(c => {
                    c.classList.remove('active')
                })
                const t = document.querySelector("#temas");
                t.classList.add('active')
            }
        });
    }else{
        mostrar_alerta(2);
    }
}

function borrar_materiales_alumno(){
    $( "#listaElementoAlumno" ).html("");
    $( "#listaElementoAlumno" ).append( "<li id='listaElementoAlumno' > <div class='cuadro8' style='margin-top: 10px;'> <label class='label9'>Material</label> <input class='input9 form-control input_material_alumno_actividad' id='input_material_alumno_actividad' placeholder='Material' type='text' required></input> <label class='label19'>Cantidad</label> <input class='inpu19 form-control input_cantidad_alumno_material' id='input_cantidad_alumno_material' type='text' placeholder='Cantidad'> <button id='Eliminar_Material_alumno' onclick='eliminar(this)' class='btn_Eliminar btn-danger cancelar'>Eliminar Material</button></div> </li>" );
}

function insertar_temas(){
    let id_actividad = $("#input_id_actividad").val();
    let nombre_temas = document.querySelectorAll(".input_temNombre_activida");
    let duracion_temas = document.querySelectorAll(".input_temSemanas_activida");
    let descripcion_temas = document.querySelectorAll(".input_temDescripcion_actividad");
    let array_temas = [];
    for (let index = 0; index < nombre_temas.length; index++) {
        array_temas.push([nombre_temas[index].value, descripcion_temas[index].value, duracion_temas[index].value]);    
    }
    let tema_vacio = false;
    array_temas.forEach(tema => (tema[0]==="" || tema[2]==="") ? tema_vacio=true : null);
    if(!tema_vacio && id_actividad.length!==0 && duracion_temas.length!==0){
        $.ajax({
            type: "POST",
            url: path+"insert_temas.php",  
            data: {"id_actividad": id_actividad, "temas": JSON.stringify(array_temas)} ,                         
            success: function(res){
                mostrar_alerta(1);
                borrar_temas();
                content.forEach(c => {
                    c.classList.remove('active')
                })
                const t = document.querySelector("#tapPrincipal");
                t.classList.add('active')
            }
        });
    }else{
        mostrar_alerta(2);
    }
}

function borrar_temas(){
    $( "#listaElementoTemas" ).html("");
    $( "#listaElementoTemas" ).append( "<li> <div class= 'cuadro7' style='margin-top: 10px;'> <input id='input_id_temas' type='text' hidden /> <label class='label11'>Tema</label> <input class='input11 form-control input_temNombre_activida' id='input_temNombre_activida' type='text' placeholder='Nombre'> <label class='label12'>Duración</label> <input class='input12 input_temSemanas_activida' id='input_temSemanas_activida' type='number' placeholder='Semanas de Duración'> <label class='label13'>Descripción</label> <textarea class='input13 input_temDescripcion_actividad' id='input_temDescripcion_actividad' placeholder='Descripción' type='text' required></textarea> <button class='btn8 btn-danger cancelar' onclick='eliminar(this)' id='Eliminar_Tema'>Eliminar Material</button> </div> </li>" );
}

function select_actividad_id(id_actividad){
    select_actividad(id_actividad);
    select_materiales_actividad(id_actividad);
    select_materiales_alumno(id_actividad);
    select_temas(id_actividad);
}

function select_actividad(id_actividad){
    $.ajax({
        type: "POST",
        data: {"id_actividad": id_actividad},
        url: path+"select_actividad.php",                           
        success: function(res){    
            let actividad = JSON.parse(res)[0];
            $("#input_id_actividad").val(id_actividad); 
            $("#input_nombre_actividad").val(actividad.nombre);
            $("#input_creditos_actividad").val(actividad.creditos_otorga);
            $("#input_cMax_actividad").val(actividad.capacidad_max);
            $("#input_cMin_actividad").val(actividad.capacidad_min);
            $("#input_descripcion_actividad").val(actividad.descripcion);
            $("#input_competencia_actividad").val(actividad.competencia);
            $("#input_beneficios_actividad").val(actividad.beneficios);
            $("#input_fechainicio_actividad").val(actividad.fecha_inicio);
            $("#input_fechafin_actividad").val(actividad.fecha_fin);
            $("#input_padre_actividad").val($("#select_actividad option[id=" +actividad.actividad_padre+"]").attr("value"));
            $("#btn_insert_update_actividad").attr("onclick","update_actividad()");
            content.forEach(c => {
                c.classList.remove('active')
            })
            const t = document.querySelector("#agregarActividad");
            t.classList.add('active')
        }
    });
}

function select_materiales_actividad(id_actividad){
    $.ajax({
        type: "POST",
        data: {"id_actividad": id_actividad},
        url: path+"select_material_actividad.php",                           
        success: function(res){    
            let materiales = JSON.parse(res);
            $( "#listaElemento" ).html("");
            materiales.forEach(material => {
                $( "#listaElemento" ).append( "<li id='listaElemento' > <div class='cuadro8' style='margin-top: 10px;'> <label class='label9'>Material</label> <input class='input9 form-control input_material_actividad' id='input_material_actividad' placeholder='Material' type='text' value='"+material.nombre+"' required></input> <label class='label19'>Cantidad</label> <input class='input19 input_cantidad_material' id='input_cantidad_material' type='text' placeholder='Cantidad' value='"+material.cantidad+"'> <button id='Eliminar_Material' onclick='eliminar(this)' class='btn_Eliminar btn-danger cancelar'>Eliminar Material</button></div> </li>" );
            });
        }
    });
}

function select_materiales_alumno(id_actividad){
    $.ajax({
        type: "POST",
        data: {"id_actividad": id_actividad},
        url: path+"select_material_alumno.php",                           
        success: function(res){    
            let materiales = JSON.parse(res);
            $( "#listaElementoAlumno" ).html("");
            materiales.forEach(material => {
                $("#listaElementoAlumno").append( "<li id='listaElementoAlumno' > <div class='cuadro8' style='margin-top: 10px;'> <label class='label9'>Material</label> <input class='input9 form-control input_material_alumno_actividad' id='input_material_alumno_actividad' placeholder='Material' type='text' value='"+material.nombre+"' required></input> <label class='label19'>Cantidad</label> <input class='input19 form-control input_cantidad_alumno_material' id='input_cantidad_alumno_material' type='text' placeholder='Cantidad' value='"+material.cantidad+"'> <button id='Eliminar_Material_alumno' onclick='eliminar(this)' class='btn_Eliminar btn-danger cancelar'>Eliminar Material</button></div> </li>" );
            });
        }
    });
}

function select_temas(id_actividad){
    $.ajax({
        type: "POST",
        data: {"id_actividad": id_actividad},
        url: path+"select_temas.php",                           
        success: function(res){    
            let temas = JSON.parse(res);
            $( "#listaElementoTemas" ).html("");
            temas.forEach(tema => {
                $( "#listaElementoTemas" ).append( "<li> <div class= 'cuadro7' style='margin-top: 10px;'> <input id='input_id_temas' type='text' hidden /> <label class='label11'>Tema</label> <input class='input11 form-control input_temNombre_activida' id='input_temNombre_activida' type='text' placeholder='Nombre' value='"+tema.nombre+"'> <label class='label12'>Duración</label> <input class='input12 input_temSemanas_activida' id='input_temSemanas_activida' type='number' placeholder='Semanas de Duración' value='"+tema.semanas+"'> <label class='label13'>Descripción</label> <textarea class='input13 input_temDescripcion_actividad' id='input_temDescripcion_actividad' placeholder='Descripción' type='text' required>"+tema.descripcion+"</textarea> <button class='btn8 btn-danger cancelar' onclick='eliminar(this)' id='Eliminar_Tema'>Eliminar Material</button> </div> </li>" );
            });
        }
    });
}


function update_actividad(){
    let id_actividad = $("#input_id_actividad").val();
    let nombre = $("#input_nombre_actividad").val();
    let creditos = $("#input_creditos_actividad").val();
    let capacidad_max = $("#input_cMax_actividad").val();
    let capacidad_min = $("#input_cMin_actividad").val();
    let descripcion = $("#input_descripcion_actividad").val();
    let competencia = $("#input_competencia_actividad").val();
    let beneficios = $("#input_beneficios_actividad").val();
    let fecha_inicio = $("#input_fechainicio_actividad").val();
    let fecha_fin = $("#input_fechafin_actividad").val();
    let video = $("#input_video_actividad")[0].files[0];
    let form_data = new FormData();
    form_data.append("nombre",nombre);
    form_data.append("creditos",creditos);
    form_data.append("capacidad_max",capacidad_max);
    form_data.append("capacidad_min",capacidad_min);
    form_data.append("descripcion",descripcion);
    form_data.append("competencia",competencia);
    form_data.append("beneficios",beneficios);
    form_data.append("fecha_inicio",fecha_inicio);
    form_data.append("fecha_fin",fecha_fin);
    form_data.append("id_actividad",id_actividad);
    if(id_actividad.length !== 0 && nombre.length !== 0 && creditos.length !== 0 && capacidad_max.length !== 0 && capacidad_min.length !== 0 && fecha_inicio.length !== 0 && fecha_fin.length !== 0){
        let val = $("#input_padre_actividad").val(); 
        let id_actividad_padre = $("#select_actividad option[value='"+val+"']").attr("id");
        let actividad_padre;
        if(id_actividad_padre!==undefined){
            actividad_padre = id_actividad_padre;
        }else{
            actividad_padre = "";
        }
        form_data.append("actividad_padre",actividad_padre);
        form_data.append("video",video);
        $.ajax({
            type: "POST",
            url: path+"update_actividad.php",
            contentType: false,
            processData:false,
            data: form_data,
            success: function(res){
                console.log(res);
                borrar_datos_input_actividad();
                select_actividades();
                content.forEach(c => {
                    c.classList.remove('active')
                })
                const t = document.querySelector("#principal");
                t.classList.add('active')
                if (res === "1") {
                    mostrar_alerta(1);
                }else{
                    mostrar_alerta(3);
                }
            }
        });
    }else{
        mostrar_alerta(2);
    }
}

function generar_pdf(id_actividad){
    $.ajax({
        type: "POST",
        data: {"id_actividad": id_actividad},
        url: path+"select_actividad.php",                           
        success: function(res){   
            let actividad = JSON.parse(res)[0];           
            let pdf = new jsPDF('l');
            let columns = [["Nombre", "Descripcion", "Competencia","Creditos", "Beneficios", "Capacidad Mínima", "Capacidad Máxima", "Fecha de Inicio", "Fecha de Fin"]];
            let data = [[actividad.nombre, actividad.descripcion, actividad.competencia, actividad.creditos_otorga, actividad.beneficios,actividad.capacidad_min,actividad.capacidad_max, actividad.fecha_inicio, actividad.fecha_fin]];
            pdf.setProperties({
                title: "Tabla actividad "+actividad.nombre
            });
            let texto = "Actividad "+actividad.nombre;
            let x = (pdf.internal.pageSize.width/2) - (pdf.getTextWidth(texto)/2)
            pdf.text(texto,x,15);
            pdf.autoTable({
                startY: 25,
                head: columns,
                body: data,
            })
            let blob = pdf.output("blob");
            window.open(URL.createObjectURL(blob));          
        }
    });
}

function crear_grupos(id_actividad){
    window.location.href = "../../../views/modules/coordinador/grupos.php?actividad="+id_actividad;
}