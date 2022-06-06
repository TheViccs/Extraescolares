$('#tabla_grupos').DataTable({
    pageLength: 20,
    caseInsen: false,
    columns: [
        { data: "nombre_actividad", title: 'Nombre de Actividad' },
        { data: "nombre_grupo", title: 'Nombre de Grupo' },
        { data: "total_inscripciones", title: 'Alumnos Inscritos' },
        { data: "botonimprimir", title: 'Imprimir Lista' },
        { data: "botoncalificar", title: 'Calificar Alumnos' }
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
    let id_instructor = $("#id_instructor").val();
    $.ajax({
        type: "POST",
        url: path+"select_grupos_instructor_id.php",  
        data: {"id_instructor": id_instructor},                    
        success: function(res){    
            let grupos = JSON.parse(res);          
            agregar_grupos_tabla(grupos);
        }
    });
}
select_grupos();

function agregar_grupos_tabla(grupos){
    let tabla = $("#tabla_grupos").DataTable();
    tabla.rows().remove().draw();
    for(let grupo of grupos){
        tabla.row.add({"nombre_actividad":grupo.nombre_actividad, "nombre_grupo":grupo.nombre,"total_inscripciones":grupo.total_inscripciones, "botonimprimir":"<button id='botonimprimirgrupo"+ grupo.id_grupo+"'class='btn btn-primary'> Imprimir Lista </button>", "botoncalificar": "<button id='botoncalificar"+grupo.id_grupo+"'class='btn btn-danger' >Calificar Alumnos</button>"}).draw();
        $("#botoncalificar"+grupo.id_grupo).on( "click", function(){calificar_grupo(grupo.id_grupo)});
    }
}

function calificar_grupo(id_grupo){
    
    window.location.href = "../../../views/modules/instructores/alumnos.php?grupo="+id_grupo;

}