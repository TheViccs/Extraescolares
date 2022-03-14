$('#tabla_programas').DataTable({
    pageLength: 20,
    caseInsen: false,
    columns: [
        {data: "clave", title:'Clave'},
        {data: "nombre", title: 'Nombre'},
        {data: "descripcion", title: 'Descripción'},
        {data: "observaciones", title: 'Observaciones'},
        {data: "botonasignar", title: 'Asignar Coordinador'}
    ],
    "columnDefs": [
        { "orderable": false, "targets": [4] },
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
    let id_responsable = $("#input_id_responsable").val();
    $.ajax({
        type: "POST",
        url: path+"select_programas_responsable_id.php",  
        data: {"id_responsable": id_responsable} ,                           
        success: function(res){    
            let programas = JSON.parse(res);             
            agregar_programas_tabla(programas);
        }
    });
}
select_programas();

//AGREGA PROGRAMAS A DATATABLE
function agregar_programas_tabla(programas){
    let tabla = $("#tabla_programas").DataTable();
    tabla.rows().remove().draw();
    for(let programa of programas){
        tabla.row.add({"clave":programa.clave,"nombre":programa.nombre,"descripcion":programa.descripcion,"observaciones":programa.observaciones,"botonasignar":"<button id='botonasignar"+programa.id_programa+"' class='btn btn-primary'>Asignar</button>"}).draw();
        /* $("#botoneditarprograma"+programa.id_programa).on( "click", function(){select_programa_id(programa.id_programa)}); */
    }
}