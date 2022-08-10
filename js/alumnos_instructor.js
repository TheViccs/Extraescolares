//CREA DATATABLE EN LA TABLA ALUMNOS
$('#tabla_alumnos').DataTable({
    pageLength: 20,
    caseInsen: false,
    columns: [
        { data: "nombre", title: 'Nombre Alumno' },
        { data: "semestre", title: 'Semestre' },
        { data: "carrera", title: 'Carrera' },
        { data: "botoncalificar", title: 'Calificar Alumno' }
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
            title: "Alumnos"
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

//SELECT DE LOS ALUMNOS EN GRUPO
function select_alumnos(){
    let id_grupo = $("#id_grupo").val();
    $.ajax({
        type: "POST",
        url: path+"select_alumnos_grupo_id.php",  
        data: {"id_grupo": id_grupo},                    
        success: function(res){    
            let alumnos = JSON.parse(res);          
            agregar_alumnos_tabla(alumnos);
        }
    });
}
select_alumnos();

//AGREGA LAS FILAS DE ALUMNOS AL DATATABLE
function agregar_alumnos_tabla(alumnos){
    let tabla = $("#tabla_alumnos").DataTable();
    tabla.rows().remove().draw();
    for(let alumno of alumnos){
        tabla.row.add({"nombre":alumno.nombre+" "+alumno.apellido_p+" "+alumno.apellido_m, "semestre":alumno.semestre,"carrera":alumno.carrera, "botoncalificar":"<button id='botoncalificar"+ alumno.id_alumno+"'class='btn btn-primary'> Calificar Alumno</button>"}).draw();
        $("#botoncalificar"+alumno.id_alumno).on( "click", function(){calificar_alumno(alumno.id_alumno)});
    }
}

//CAMBIA DE VENTANA MANDANDO EL ID DEL ALUMNO Y DEL GRUPO
function calificar_alumno(id_alumno){
    window.location.href = "../../../views/modules/instructores/alumno.php?alumno="+id_alumno+"&grupo="+$("#id_grupo").val();
}