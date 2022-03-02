//FUNCIONES PARA RESPONSABLES
//SELECT DE RESPONSABLES
function select_responsables(){
    $.ajax({
        type: "GET",
        url: path+"select_responsables.php",                           
        success: function(res){                    
            let responsables = JSON.parse(res);
            agregar_responsables_select(responsables);
        }
    });
}
select_responsables();

//AGREGA RESPONSABLES AL SELECT
function agregar_responsables_select(responsables){
    $("#select_responsables").html("");
    for(let responsable of responsables){
        $("#select_responsables").append("<option data-id='"+responsable.id_responsable+"' value='"+responsable.nombre+"'></option>");
    }
}

//INSERT RESPONSABLE
function insert_responsable(){
    let clave = $("#input_clave_responsable").val();
    let nombre = $("#input_nombre_responsable").val();
    let correo = $("#input_correo_responsable").val();
    if(clave.length!==0 && nombre.length!==0 && correo.length!==0 ){
        $.ajax({
            type: "POST",
            url: path+"insert_responsable.php",  
            data: {"clave": clave, "nombre": nombre, "correo": correo} ,                         
            success: function(res){
                if(res==="1"){
                    select_responsables();  
                    borrar_datos_input_responsable(); 
                    $("#modal-responsable").modal("hide");
                    mostrar_alerta(1);
                }else{
                    $("#modal-responsable").modal("hide");
                    mostrar_alerta(3);
                }
                                
            }
        });
    }else{
        $("#modal-responsable").modal("hide");
        mostrar_alerta(2);
    }
}

//BORRAR DATOS INPUT DE RESPONSABLE
function borrar_datos_input_responsable(){
    $("#input_clave_responsable").val("");
    $("#input_nombre_responsable").val("");
    $("#input_correo_responsable").val("");
}

//------------------------------------------------------------------------------------------------------

//FUNCIONES PARA DEPARTAMENTOS
//CREACION DE DATATABLE PARA DEPARTAMENTOS
$('#tabla-departamentos').DataTable({
    pageLength: 20,
    caseInsen: false,
    columns: [
        {data: "clave", title: 'Clave'},
        {data: "nombre", title: 'Nombre'},
        {data: "ubicacion", title: 'Ubicación'},
        {data: "extension", title: 'Extensión'},
        {data: "botoneditar", title: 'Editar'},
        {data: "botonborrar", title: 'Borrar'}
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

//SELECT DE DEPARTAMENTOS
function select_departamentos(){
    $.ajax({
        type: "GET",
        url: path+"select_departamentos.php",                           
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
        tabla.row.add({"clave":departamento.clave,"nombre":departamento.nombre,"ubicacion":departamento.ubicacion,"extension":departamento.extension,"botoneditar":"<button id='botoneditardepartamento"+departamento.id_departamento+"' class='btn btn-primary'>Editar</button>","botonborrar":"<button id='botonborrardepartamento"+departamento.id_departamento+"' class='btn btn-danger'>Borrar</button>"}).draw();
        $("#botoneditardepartamento"+departamento.id_departamento).on( "click", function(){select_departamento_id(departamento.id_departamento)});
        $("#botonborrardepartamento"+departamento.id_departamento).on( "click", function(){mostrar_modal_borrar_departamento(departamento.id_departamento, departamento.clave, departamento.nombre, departamento.ubicacion, departamento.extension)});
    }
}

//SELECT DE DEPARTAMENTO POR ID
function select_departamento_id(id_departamento){
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
}

//MOSTRAR MODAL BORRAR DEPARTAMENTO
function mostrar_modal_borrar_departamento(id_departamento, clave, nombre, ubicacion, extension){
    $("#modal-departamento").modal("show");
    $("#p_clave_departamento").text("Clave: "+clave);
    $("#p_nombre_departamento").text("Nombre: "+nombre);
    $("#p_ubicacion_departamento").text("Ubicación: "+ubicacion);
    $("#p_extension_departamento").text("Extensión: "+extension);
    $("#input_id_departamento_borrar").val(id_departamento);
}

//INSERT DE DEPARTAMENTOS
function insert_departamento(){
    let clave = $("#input_clave_departamento").val();
    let nombre = $("#input_nombre_departamento").val();
    let ubicacion = $("#input_ubicacion_departamento").val();
    let extension = $("#input_extension_departamento").val();
    if(clave.length !== 0 && nombre.length !== 0 && ubicacion.length !== 0 && extension.length !== 0){
        $.ajax({
            type: "POST",
            url: path+"insert_departamento.php",  
            data: {"clave": clave, "nombre": nombre, "ubicacion": ubicacion, "extension": extension} ,                         
            success: function(res){  
                select_departamentos();
                if(res==="1"){
                    let val = $("#input_select_responsables").val(); 
                    let id_responsable = $("#select_responsables option[value='"+val+"']").attr("data-id");
                    if(id_responsable!==undefined){
                        select_departamento_clave(clave,id_responsable);
                    }else{
                        mostrar_alerta(1);
                    }
                }else{
                    mostrar_alerta(3);
                }           
            }
        });
    }else{
        mostrar_alerta(2);
    }   
}

//SELECT DEPARTAMENTO POR CLAVE
function select_departamento_clave(clave,id_responsable){
    $.ajax({
        type: "POST",
        data: {"clave": clave},
        url: path+"select_departamento_clave.php",                           
        success: function(res){    
            let departamento = JSON.parse(res)[0];
            insert_departamento_responsable(departamento.id_departamento,id_responsable);
        }
    }); 
}

//INSERTAR DATOS EN DEPARTAMENTO-RESPONSABLE
function insert_departamento_responsable(id_departamento,id_responsable){
        $.ajax({
            type: "POST",
            url: path+"insert_departamento_responsable.php",  
            data: {"id_departamento": id_departamento,"id_responsable": id_responsable} ,                         
            success: function(res){  
                if(res==="1"){
                    mostrar_alerta(1);
                    borrar_datos_input_departamento();
                }else{
                    mostrar_alerta(3);
                }
            }
        });
    
}

//BORRAR DATOS DE LOS INPUT DEPARTAMENTO
function borrar_datos_input_departamento(){
    $("#input_clave_departamento").val("");
    $("#input_nombre_departamento").val("");
    $("#input_ubicacion_departamento").val("");
    $("#input_extension_departamento").val("");
    $("#input_select_responsables").val("");
}

//BORRAR DEPARTAMENTO
function borrar_departamento(){
    let id_departamento = $("#input_id_departamento_borrar").val();
    $.ajax({
        type: "POST",
        url: path+"delete_departamento.php",  
        data: {"id_departamento": id_departamento} ,                         
        success: function(res){
            select_departamentos();
            $("#modal-departamento").modal("hide");   
            if(res==="1"){
                mostrar_alerta(1);
            }else{
                mostrar_alerta(3)
            }
        }
    });
}

//------------------------------------------------------------------------------------------------------

