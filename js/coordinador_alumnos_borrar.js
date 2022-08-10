//TABLA DE ACTIVIDADES
$('#tabla_alumnos').DataTable({
    pageLength: 20,
    caseInsen: false,
    columns: [
        { data: "nombre", title: 'Nombre' },
        { data: "carrera", title: 'Carrera' },
        { data: "semestre", title: 'Semestre' },
        { data: "botoneliminar", title: 'Eliminar Alumno' },
    ],
    "columnDefs": [
        { "orderable": false, "targets": [3] },
    ],
    dom:'Bfrtip' ,
    buttons: [
        { 
            extend: "excelHtml5",
            text: "Exportar a Excel",
            exportOptions: {
                columns: [0,1,2]
            },
            filename: "Alumnos",
            title: "Alumnos",
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

function select_alumnos() {
    let id_grupo = $("#id_grupo").val();
    console.log(id_grupo);
    $.ajax({
        type: "POST",
        data: { "id_grupo": id_grupo },
        url: path + "select_alumnos_grupo_id.php",
        success: function (res) {
            let alumnos = JSON.parse(res);
            agregar_alumnos_tabla(alumnos);
        }
    });
}
select_alumnos();


function agregar_alumnos_tabla(alumnos) {
    let tabla = $("#tabla_alumnos").DataTable();
    tabla.rows().remove().draw();
    for (let alumno of alumnos) {
        tabla.row.add({ "nombre": alumno.nombre + " " + alumno.apellido_p + " " + alumno.apellido_m, "carrera": alumno.carrera, "semestre": alumno.semestre, "botoneliminar": "<button id='botoneliminar" + alumno.id_alumno + "' class= 'btn btn-danger'>Eliminar Alumno</button>" }).draw();
        $("#botoneliminar"+alumno.id_alumno).on( "click", function(){mostrar_modal_borrar_alumno(alumno.id_alumno, alumno.nombre + " " + alumno.apellido_p + " " + alumno.apellido_m, alumno.carrera, alumno.semestre)});
    }
}

function mostrar_modal_borrar_alumno(id_alumno,nombre, carrera, semestre){
    $("#p_nombre_alumno").text("Nombre: "+nombre)
    $("#p_carrera").text("Carrera: "+carrera)
    $("#p_semestre").text("Semestre: "+semestre)
    $("#input_id_alumno_borrar").val(id_alumno)
    $("#modal-alumno").modal("show");
}

function borrar_alumno(){
    let id_alumno = $("#input_id_alumno_borrar").val();
    let id_grupo = $("#id_grupo").val();
    let id_actividad = $("#id_actividad").val();
    $.ajax({
        type: "POST",
        url: path+"delete_detalles_inscripcion_alumno.php",  
        data: {"id_alumno": id_alumno,"id_actividad":id_actividad,"id_grupo":id_grupo} ,                         
        success: function(res){
            console.log(res);
            select_alumnos();
            $("#modal-alumno").modal("hide");   
            if(res==="1"){
                mostrar_alerta(1);
            }else{
                mostrar_alerta(3)
            }
        }
    });
}