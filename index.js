//CREACION DE DATATABLE PARA DEPARTAMENTOS
$('#tabla-departamentos').DataTable({
    pageLength: 20,
    caseInsen: false,
    columns: [
        {data: "id", title: 'ID'},
        {data: "nombre", title: 'Nombre'},
        {data: "ubicacion", title: 'Ubicación'},
        {data: "extension", title: 'Extensión'},
        {data: "botoneditar", title: 'Editar'},
        {data: "botonborrar", title: 'Borrar'}
    ],
    "columnDefs": [
        { "orderable": false, "targets": [4,5] },//ocultar para columna 0
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

//FUNCIONES PARA REPRESENTANTES
//SELECT DE REPRESENTANTES
function select_representantes(){
    $.ajax({
        type: "GET",
        url: "./php/select_representantes.php",                           
        success: function(res){                    
            let representantes = JSON.parse(res);
            agregar_representantes_select(representantes);
        }
    });
}
select_representantes();

//AGREGA REPRESENTANTES AL SELECT
function agregar_representantes_select(representantes){
    for(let representante of representantes){
        $("#select_representantes").append("<option id='"+representante.id_responsable+"'>"+representante.nombre+"</option>");
    }
}

//INSERT REPRESENTANTE
function insert_representante(){
    let id = $("#input_id_r").val();
    let nombre = $("#input_nombre_representante").val();
    let correo = $("#input_correo_representante").val();
    $.ajax({
        type: "POST",
        url: "./php/insert_responsable.php",  
        data: {"id": id, "nombre": nombre, "correo": correo} ,                         
        success: function(res){
            console.log(res); 
            select_representantes();  
            borrar_datos_input_representante();                 
        }
    });
}

//BORRAR DATOS INPUT DE REPRESENTANTE
function borrar_datos_input_representante(){
    $("#input_id").val("");
    $("#input_nombre_representante").val("");
    $("#input_correo_representante").val("");
}


//FUNCIONES PARA DEPARTAMENTOS
//SELECT DE DEPARTAMENTO POR ID
function select_departamento_id(id){
    $.ajax({
        type: "POST",
        data: {"id_departamento": id},
        url: "./php/select_departamento_id.php",                           
        success: function(res){    
            let departamento = JSON.parse(res)[0];
            $("#input_id_departamento").val(departamento.id_departamento);                
            $("#input_id").val(departamento.id);
            $("#input_nombre_departamento").val(departamento.nombre);
            $("#input_ubicacion_departamento").val(departamento.ubicacion);
            $("#input_extension_departamento").val(departamento.extension);
        }
    });
}

//SELECT DE DEPARTAMENTOS
function select_departamentos(){
    $.ajax({
        type: "GET",
        url: "./php/select_departamentos.php",                           
        success: function(res){    
            let departamentos = JSON.parse(res);             
            agregar_departamentos_tabla(departamentos);
        }
    });
}
select_departamentos();

//AGREGA DEPARTAMENTOS A DATATABLE
function agregar_departamentos_tabla(departamentos){
    let tabla = $("#tabla-departamentos").DataTable();
    tabla.rows().remove().draw();
    for(let departamento of departamentos){
        tabla.row.add({"id":departamento.id,"nombre":departamento.nombre,"ubicacion":departamento.ubicacion,"extension":departamento.extension,"botoneditar":"<button id='botoneditardepartamento"+departamento.id_departamento+"' class='btn btn-primary'>Editar</button>","botonborrar":"<button id='botonborrardepartamento"+departamento.id_departamento+"' class='btn btn-danger'>Borrar</button>"}).draw();
        $("#botoneditardepartamento"+departamento.id_departamento).on( "click", function(){select_departamento_id(departamento.id_departamento)});
        $("#botonborrardepartamento"+departamento.id_departamento).on( "click", function(){mostrar_modal_borrar_departamento(departamento.id_departamento, departamento.id, departamento.nombre, departamento.ubicacion, departamento.extension)});
    }
}

//INSERT DE DEPARTAMENTOS
function insert_departamento(){
    let id = $("#input_id").val();
    let nombre = $("#input_nombre_departamento").val();
    let ubicacion = $("#input_ubicacion_departamento").val();
    let extension = $("#input_extension_departamento").val();
    if(id.length !== 0 && nombre.length !== 0 && ubicacion.length !== 0 && extension.length !== 0){
        $.ajax({
            type: "POST",
            url: "./php/insert_departamento.php",  
            data: {"id": id, "nombre": nombre, "ubicacion": ubicacion, "extension": extension} ,                         
            success: function(res){    
                select_departamentos();
                borrar_datos_input_departamento();
            }
        });
    }else{
        
    }   
}

//BORRAR DATOS DE LOS INPUT DEPARTAMENTO
function borrar_datos_input_departamento(){
    $("#input_id").val("");
    $("#input_nombre_departamento").val("");
    $("#input_ubicacion_departamento").val("");
    $("#input_extension_departamento").val("");
}

//MOSTRAR MODAL BORRAR DEPARTAMENTO
function mostrar_modal_borrar_departamento(id, id2, nombre, ubicacion, extension){
    $("#modal-departamento").modal("show");
    $("#p_datos_departamento").text("ID: "+id2+" Nombre: "+nombre+" Ubicación: "+ubicacion+" Extensión: "+extension);
    $("#input_id_departamento_borrar").val(id);
}
