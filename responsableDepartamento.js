$('#tabla-responsables').DataTable({
    pageLength: 20,
    caseInsen: false,
    columns: [
        {data: "clave", title: 'Clave'},
        {data: "nombre", title: 'Nombre'},
        {data: "correo", title: 'Correo'},
        {data: "botoneditar", title: 'Editar'},
        {data: "botonborrar", title: 'Borrar'}
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

function select_responsables_1(){
    $.ajax({
        type: "GET",
        url: "./php/select_responsables.php",                           
        success: function(res){    
            let responsables = JSON.parse(res);             
            agregar_responsables_tabla(responsables);
        }
    });
}
select_responsables_1();


//AGREGA DEPARTAMENTOS A DATATABLE
function agregar_responsables_tabla(responsables){
    let tabla = $("#tabla-responsables").DataTable();
    tabla.rows().remove().draw();
    for(let responsable of responsables){
        tabla.row.add({"clave":responsable.clave, "nombre":responsable.nombre, "correo":responsable.correo,"botoneditar":"<button id='botoneditarresponsable"+ responsable.id_responsable+"'class='btn btn-primary'> Editar </button>", "botonborrar": "<button id='botonborrarresponsable"+responsable.id_responsable+"'class='btn btn-danger' >Borrar</button>" }).draw();
       //$("#botoneditarresponsable"+responsable.id_responsable).on( "click", function(){select_responsable_id(responsable.id_responsable)});
       $("#botonborrarresponsable"+responsable.id_responsable).on( "click", function(){mostrar_modal_borrar_departamento(responsable.id_responsable, responsable.clave, responsable.nombre, responsable.correo)});
    }
}

//INSERTAR RESPONSABLE
function insert_responsable(){
    let clave = $("#input_clave_responsable").val();
    let nombre = $("#input_nombre_responsable").val();
    let correo = $("#input_correo_responsable").val();

    if(clave.length !== 0 && nombre.length !== 0 && correo.length !== 0){
        $.ajax({
            type: "POST",
            url: "./php/insert_responsable.php",
            data: {"clave":clave,"nombre":nombre,"correo":correo},
            success: function(res){
                select_responsables_1();
                if (res == 1) {
                    if (id_responsable != undefined) {
                        
                    }
                    
                }
            }
        });
    }

}

//LIMPIAR CAJAS DE TEXTO
function borrar_datos_input_responsable(){
    $("#input_clave_responsable").val("");
    $("#input_nombre_responsable").val("");
    $("#input_correo_responsable").val("");

}