//FUNCIONES PARA DEPARTAMENTOS
//CREACION DE DATATABLE PARA PROGRAMAS
$('#tabla_programas').DataTable({
    pageLength: 20,
    caseInsen: false,
    columns: [
        {data: "nombre", title: 'Nombre'},
        {data: "descripcion", title: 'Descripción'},
        {data: "observaciones", title: 'Observaciones'},
        {data: "botoneditar", title: 'Editar'},
        {data: "botonborrar", title: 'Borrar'},
        {data: "botonimprimir", title: 'Imprimir'}
    ],
    "columnDefs": [
        { "orderable": false, "targets": [3,4,5] },
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

//SELECT DE PROGRAMAS
function select_programas(){
    $.ajax({
        type: "GET",
        url: path+"select_programas.php",                           
        success: function(res){    
            let programas = JSON.parse(res);             
            agregar_programas_tabla(programas);
        }
    });
}
select_programas();

//AGREGA DEPARTAMENTOS A DATATABLE
function agregar_programas_tabla(programas){
    let tabla = $("#tabla_programas").DataTable();
    tabla.rows().remove().draw();
    for(let programa of programas){
        tabla.row.add({"nombre":programa.nombre,"descripcion":programa.descripcion,"observaciones":programa.observaciones,"botoneditar":"<button id='botoneditarprograma"+programa.id_programa+"' class='btn btn-primary'>Editar</button>","botonborrar":"<button id='botonborrarprograma"+programa.id_programa+"' class='btn btn-danger'>Borrar</button>","botonimprimir":"<button id='botonimprimirprograma"+programa.id_programa+"' class='btn btn-dark'>Imprimir</button>"}).draw();
        /* $("#botoneditardepartamento"+departamento.id_departamento).on( "click", function(){select_departamento_id(departamento.id_departamento)});
        $("#botonborrardepartamento"+departamento.id_departamento).on( "click", function(){mostrar_modal_borrar_departamento(departamento.id_departamento, departamento.clave, departamento.nombre, departamento.ubicacion, departamento.extension)}); */
    }
}

//SELECT DE PROGRAMA POR ID
function select_programa_id(id_programa){
    $.ajax({
        type: "POST",
        data: {"id_programa": id_programa},
        url: path+"select_programa_id.php",                           
        success: function(res){    
            let programa = JSON.parse(res)[0];
            $("#input_id_programa").val(departamento.id_departamento);                
            $("#input_nombre_departamento").val(departamento.nombre);
            $("#input_ubicacion_departamento").val(departamento.ubicacion);
            $("#input_extension_departamento").val(departamento.extension);
        }
    });
}