$('#tabla-responsables').DataTable({
    pageLength: 20,
    caseInsen: false,
    columns: [
        {data: "clave", title: 'Clave'},
        {data: "nombre", title: 'Nombre'},
        {data: "correo", title: 'Correo'},
        {data: "botoneditar", title: 'Editar'},
        {data: "botonborrar", title: 'Borrar'},
        {data: "botonimprimir", title: 'Impirmir'}
    ],
    "columnDefs": [
        { "orderable": false, "targets": [4,5] },
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
        url: path+"select_responsables.php",                           
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
        tabla.row.add({"clave":responsable.clave, "nombre":responsable.nombre, "correo":responsable.correo,"botoneditar":"<button id='botoneditarresponsable"+ responsable.id_responsable+"'class='btn btn-primary'> Editar </button>", "botonborrar": "<button id='botonborrarresponsable"+responsable.id_responsable+"'class='btn btn-danger' >Borrar</button>", "botonimprimir":"<button id='botonimprimir"+responsable.id_responsable+"' class= 'btn btn-dark'>Imprimir</button>"}).draw();
       $("#botoneditarresponsable"+responsable.id_responsable).on( "click", function(){select_responsable_id(responsable.id_responsable)});
       $("#botonborrarresponsable"+responsable.id_responsable).on( "click", function(){mostrar_modal_borrar_responsable(responsable.id_responsable, responsable.clave, responsable.nombre, responsable.correo)});
       $("#botonimprimir");
    }
}

//MOSTRAR MODAL BORRAR RESPONSABLE
function mostrar_modal_borrar_responsable(id_responsable, clave, nombre, correo){
    $("#modal-responsable").modal("show");
    $("#p_clave_resposable").text("Clave: "+clave);
    $("#p_nombre_resposable").text("Nombre: "+nombre);
    $("#p_correo_resposable").text("Correo: "+correo);
    $("#input_id_responsable_borrar").val(id_responsable);
}


//INSERTAR RESPONSABLE
function insert_responsable(){
    let clave = $("#input_clave_responsable").val();
    let nombre = $("#input_nombre_responsable").val();
    let correo = $("#input_correo_responsable").val();

    if(clave.length !== 0 && nombre.length !== 0 && correo.length !== 0){
        $.ajax({
            type: "POST",
            url: path+"insert_responsable.php",
            data: {"clave":clave,"nombre":nombre,"correo":correo},
            success: function(res){
                borrar_datos_input_responsable();
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

//BORRAR RESPONSABLE
function borrar_responsable(){
    let id_responsable= $("#input_id_responsable_borrar").val();
    $.ajax({
        type: "POST",
        url: path+"delete_responsable.php",  
        data: {"id_responsable": id_responsable} ,                         
        success: function(res){
            select_responsables_1();
            $("#modal-responsable").modal("hide");   
            if(res==="1"){
                mostrar_alerta(1);
            }else{
                mostrar_alerta(3)
            }
        }
    });
}

/*
//SELECT DE DEPARTAMENTO POR ID
function select_responsables_id(id_responsable){
    $.ajax({
        type: "POST",
        data: {"id_departamento": id_departamento},
        url: path+"select_departamento_id.php",                           
        success: function(res){    
            let departamento = JSON.parse(res)[0];
            $("#input_id_departamento").val(departamento.id_departamento);                
            $("#input_clave_departamento").val(departamento.clave);
            $("#input_nombre_departamento").val(departamento.nombre);
            $("#input_ubicacion_departamento").val(departamento.ubicacion);
            $("#input_extension_departamento").val(departamento.extension);
            $("#input_select_responsables").val($("#select_responsables option[data-id='" +departamento.id_responsable+"']").attr("value"));
        }
    });
}*/

