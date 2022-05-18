$(document).ready(function() {$('#listaElemento input[type="text"]').val('');})

//Agregar Material Dado por la escuela
var boton = document.getElementById("add_Material");
boton.addEventListener("click", function () {
    $( "#listaElemento" ).append( "<li id='listaElemento' > <div class='cuadro8' style='margin-top: 10px;'> <label class='label9'>Material</label> <input class='input9 form-control' id='input_material_actividad' placeholder='Material' type='text' required></input> <label class='label20'>Cantidad</label> <input class='input20' id='input_cantidad_material' type='text' placeholder='Cantidad'> <button id='Eliminar_Material' onclick='eliminar(this)' class='btn8 btn-danger cancelar'>Eliminar Material</button></div> </li>" );
}, false);

function eliminar(obj){
    $(obj).parent().parent().remove();
}

//Agregar Material por parte del estudiamte
var boton = document.getElementById("add_Material_alumnos");
boton.addEventListener("click", function () {
    $( "#listaElementoAlumno" ).append( "<li id='listaElementoAlumno' > <div class='cuadro8' style='margin-top: 10px;'> <label class='label9'>Material</label> <input class='input9 form-control' id='input_material_alumno_actividad' placeholder='Material' type='text' required></input> <label class='label20'>Cantidad</label> <input class='input20 form-control' id='input_cantidad_alumno_material' type='text' placeholder='Cantidad'> <button id='Eliminar_Material_alumno' onclick='eliminar(this)' class='btn8 btn-danger cancelar'>Eliminar Material</button></div> </li>" );
}, false);

//Agregar Tema
var boton = document.getElementById("add_Temas");
boton.addEventListener("click", function () {
    $( "#listaElementoTemas" ).append( "<li> <div class= 'cuadro7' style='margin-top: 10px;'> <input id='input_id_temas' type='text' hidden /> <label class='label11'>Tema</label> <input class='input11 form-control' id='input_temNombre_activida' type='text' placeholder='Nombre'> <label class='label12'>Duración</label> <input class='input12' id='input_temSemanas_activida' type='date' placeholder='Semanas de Duración'> <label class='label13'>Descripción</label> <textarea class='input13' id='input_temDescripcion_actividad' placeholder='Descripción' type='text' required></textarea> <button class='btn8 btn-danger cancelar' onclick='eliminar(this)' id='Eliminar_Tema'>Eliminar Material</button> </div> </li>" );
}, false);

//Agregar Criterio
var boton = document.getElementById("add_Criterio");
boton.addEventListener("click", function () {
    $( "#listaElementoCriterios" ).append( "<li> <div class='cuadro10' style='margin-top: 10px;'> <label class='abel14'>Nombre</label> <input class='input14 form-control' id='input_criterioevalNombre_activida' type='text' placeholder='Nombre'> <label class='label15'>Descripción</label> <textarea class='input15' id='input_criterioevaldes_actividad' placeholder='Descripción' type='text' required></textarea> <button class='btn_Eliminar btn-danger cancelar' onclick='eliminar(this)' id='Eliminar_Material'>Eliminar Material</button> </div> </li>");
}, false);

//Eliminar cuadros
function eliminar(obj){
    $(obj).parent().parent().remove();
}




const tagets = document.querySelectorAll('[data-taget]');
const content = document.querySelectorAll('[data-content]');

$( document ).ready(function() {
    $('#tapPrincipal').click()
    console.log($('#tapPrincipal'));
  });

tagets.forEach(taget =>{
    taget.addEventListener('click',() => {
        content.forEach(c => {
            c.classList.remove('active')
        })
        const t = document.querySelector(taget.dataset.taget);
        t.classList.add('active')


    })
})


//TABLA DE ACTIVIDADES
$('#tabla_avtividad').DataTable({
    pageLength: 20,
    caseInsen: false,
    columns: [
        { data: "idActividad", title: 'IdActividad' },
        { data: "idPrograma", title: 'IdPrograma' },
        { data: "nombre", title: 'Nombre' },
        { data: "descripcion", title: 'Descripcion' },
        { data: "competencia", title: 'Competencia' },
        { data: "creditos", title: 'Creditos' },
        { data: "beneficios", title: 'Beneficios' },
        { data: "capMax", title: 'CapMax' },
        { data: "capMin", title: 'CapMin' },
        { data: "inicio", title: 'Inicio' },
        { data: "fin", title: 'Fin' },
        { data: "padre", title: 'Padre' },
        { data: "botoneditar", title: 'Editar' },
        { data: "botonborrar", title: 'Borrar' },
        { data: "botonimprimir", title: 'Imprimir' }
    ],
    "columnDefs": [
        { "orderable": false, "targets": [15, 6, 7] },
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

//INSERT EN DEPARTAMENTO
function insert_only_departamento(idActividad, idPrograma, nombre, descripcion, competencia, creditos, beneficios, capMax, capMin, inicio, fin, padre) {
    $.ajax({
        type: "POST",
        url: path + "insert_departamento.php",
        data: { "idActividad": idActividad, "idPrograma": idPrograma, "nombre": nombre, "descripcion": descripcion, "competencia": competencia, "creditos": creditos, "beneficios": beneficios, "capMax": capMax, "capMin": capMin, "inicio": inicio, "fin": fin, "padre": padre },
        success: function (res) {
            //select_departamentos();
            if (res === "1") {
                mostrar_alerta(1);
                //borrar_datos_input_departamento();
            } else {
                mostrar_alerta(3);
            }
        }
    });
}
