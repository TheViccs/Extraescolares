//TABLA DE ACTIVIDADES
$('#tabla_actividades').DataTable({
    pageLength: 20,
    caseInsen: false,
    scrollY: true,
    columns: [
        { data: "nombre", title: 'Nombre' },
        { data: "creditos", title: 'Creditos' },
        { data: "inicio", title: 'Inicio' },
        { data: "fin", title: 'Fin' },
        { data: "botongrupos", title: 'Mostrar Grupos' }
    ],
    "columnDefs": [
        { "orderable": false, "targets": [4] },
    ],
    dom:'Bfrtip' ,
    buttons: [
        { 
            extend: "excelHtml5",
            text: "Exportar a Excel",
            exportOptions: {
                columns: [0,1,2,3]
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
        }
    });
}
select_actividades();


function agregar_actividades_tabla(actividades){
    let tabla = $("#tabla_actividades").DataTable();
    tabla.rows().remove().draw();
    for(let actividad of actividades){
        tabla.row.add({"nombre":actividad.nombre, "creditos":actividad.creditos_otorga, "inicio":actividad.fecha_inicio,"fin":actividad.fecha_fin, "botongrupos": "<button id='botongrupos"+actividad.id_actividad+"' class= 'btn btn-dark'>Ver Grupos</button>"}).draw();
        $("#botongrupos"+actividad.id_actividad).on( "click", function(){ver_grupos(actividad.id_actividad)});
    }
}

function ver_grupos(id_actividad){
    window.location.href = "../../../views/modules/coordinador/constancias_grupos.php?actividad="+id_actividad;
}