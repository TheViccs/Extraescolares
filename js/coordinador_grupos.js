$('#tabla_grupos').DataTable({
    pageLength: 20,
    caseInsen: false,
    columns: [
        { data: "nombre", title: 'Nombre' },
        { data: "total_inscripciones", title: 'Alumnos Inscritos' },
        { data: "instructor", title: 'Instructor' },
        { data: "botonalumnos", title: 'Ver Alumnos' },
        { data: "botonagregaralumno", title: 'Agregar Alumno' }
    ],
    "columnDefs": [
        { "orderable": false, "targets": [3,4] },
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

function select_grupos(){
    let id_actividad = $("#id_actividad").val();
    $.ajax({
        type: "POST",
        url: path+"select_grupo_actividad_id.php",  
        data: {"id_actividad": id_actividad},                    
        success: function(res){    
            let grupos = JSON.parse(res);          
            agregar_grupos_tabla(grupos);
        }
    });
}
select_grupos();

function agregar_grupos_tabla(grupos){
    let id_actividad = $("#id_actividad").val();
    let tabla = $("#tabla_grupos").DataTable();
    tabla.rows().remove().draw();
    for(let grupo of grupos){
        tabla.row.add({"nombre":grupo.nombre, "total_inscripciones":grupo.total_inscripciones, "instructor":grupo.nombre_instructor+" "+grupo.apellido_p+" "+grupo.apellido_m,"botonalumnos":"<button id='botonalumnos"+ grupo.id_grupo+"'class='btn btn-primary'> Ver Alumnos </button>","botonagregaralumno":"<button id='botonagregaralumno"+ grupo.id_grupo+"'class='btn btn-success'> Agregar Alumno </button>"}).draw();
        $("#botonalumnos"+grupo.id_grupo).on( "click", function(){ver_alumnos_grupo(grupo.id_grupo,id_actividad)});
        $("#botonagregaralumno"+grupo.id_grupo).on( "click", function(){ver_alumnos(grupo.id_grupo,id_actividad)});
    }
}

function ver_alumnos_grupo(id_grupo,id_actividad){
    
    window.location.href = "../../../views/modules/coordinador/alumnos_gestionar_borrar.php?grupo="+id_grupo+"&actividad="+id_actividad;

}

function ver_alumnos(id_grupo,id_actividad){
    
    window.location.href = "../../../views/modules/coordinador/alumnos_gestionar_agregar.php?grupo="+id_grupo+"&actividad="+id_actividad;

}