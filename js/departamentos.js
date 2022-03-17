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
        $("#select_responsables").append("<option id="+responsable.id_responsable+" value='"+responsable.nombre+" "+responsable.apellido_p+" "+responsable.apellido_m+"'></option>");
    }
}

//INSERT RESPONSABLE
function insert_responsable(){
    let clave = $("#input_clave_responsable").val();
    let nombre = $("#input_nombre_responsable").val();
    let apellido_p = $("#input_apellido_p_responsable").val();
    let apellido_m = $("#input_apellido_m_responsable").val();
    let sexo = $("#select_sexo_responsable").val();
    let correo = $("#input_correo_responsable" ).val();
    if(clave.length!==0 && nombre.length!==0 && apellido_p.length!==0 && apellido_m.length!==0 && correo.length!==0 && sexo!==null ){
        $.ajax({
            type: "POST",
            url: path+"insert_responsable.php",  
            data: {"clave": clave, "nombre": nombre, "apellido_p":apellido_p, "apellido_m": apellido_m, "sexo":sexo, "correo":correo + "@colima.tecnm.mx" } ,                         
            success: function(res){
                if(res==="1"){
                    select_responsables();  
                    borrar_datos_input_responsable(); 
                    $("#modal_responsable").modal("hide");
                    mostrar_alerta(1);
                }else{
                    $("#modal_responsable").modal("hide");
                    mostrar_alerta(3);
                }
                                
            }
        });
    }else{
        $("#modal_responsable").modal("hide");
        mostrar_alerta(2);
    }
}

//BORRAR DATOS INPUT DE RESPONSABLE
function borrar_datos_input_responsable(){
    $("#input_clave_responsable").val("");
    $("#input_nombre_responsable").val("");
    $("#input_correo_responsable").val("");
    $("#select_sexo_responsable").val("O");
}

//------------------------------------------------------------------------------------------------------

//FUNCIONES PARA DEPARTAMENTOS
//CREACION DE DATATABLE PARA DEPARTAMENTOS
$('#tabla_departamentos').DataTable({
    pageLength: 20,
    caseInsen: false,
    columns: [
        {data: "clave", title: 'Clave'},
        {data: "nombre", title: 'Nombre'},
        {data: "ubicacion", title: 'Ubicación'},
        {data: "extension", title: 'Extensión'},
        {data: "correo", title: 'Correo'},
        {data: "botoneditar", title: 'Editar'},
        {data: "botonborrar", title: 'Borrar'},
        {data: "botonimprimir", title: 'Imprimir'}
    ],
    "columnDefs": [
        { "orderable": false, "targets": [5,6,7] },
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
    let tabla = $("#tabla_departamentos").DataTable();
    tabla.rows().remove().draw();
    for(let departamento of departamentos){
<<<<<<< HEAD
        tabla.row.add({"clave":departamento.clave,"nombre":departamento.nombre,"ubicacion":departamento.ubicacion,"extension":departamento.extension,"correo":departamento.correo,"botoneditar":"<button id='botoneditardepartamento"+departamento.id_departamento+"' class='btn btn-primary'>Editar</button>","botonborrar":"<button id='botonborrardepartamento"+departamento.id_departamento+"' class='btn btn-danger'>Borrar</button>","botonimprimir":"<button id='botonimprimirdepartamento"+departamento.id_departamento+"' class='btn btn-dark'>Imprimir</button>"}).draw();
=======
        tabla.row.add({"clave":departamento.clave,"nombre":departamento.nombre,"ubicacion":departamento.ubicacion,"extension":departamento.extension,"correo": departamento.correo,"botoneditar":"<button id='botoneditardepartamento"+departamento.id_departamento+"' class='btn btn-primary'>Editar</button>","botonborrar":"<button id='botonborrardepartamento"+departamento.id_departamento+"' class='btn btn-danger'>Borrar</button>","botonimprimir":"<button id='botonimprimirdepartamento"+departamento.id_departamento+"' class='btn btn-dark'>Imprimir</button>"}).draw();
>>>>>>> 4914928ddb951b63a79900ac935265275b03dadb
        $("#botoneditardepartamento"+departamento.id_departamento).on( "click", function(){select_departamento_id(departamento.id_departamento)});
        $("#botonborrardepartamento"+departamento.id_departamento).on( "click", function(){mostrar_modal_borrar_departamento(departamento.id_departamento, departamento.clave, departamento.nombre, departamento.ubicacion, departamento.extension, departamento.correo)});
        $("#botonimprimirdepartamento"+departamento.id_departamento).on( "click", function(){generar_pdf(departamento.id_departamento)});
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
            $("#input_correo_departamento").val(departamento.correo);
            $("#input_select_responsables").val($("#select_responsables option[id=" +departamento.id_responsable+"]").attr("value"));
            $("#boton_insert_update_departamento").attr("onclick","update_departamento()");
        }
    });
}

//UPDATE DE DEPARTAMENTO
function update_departamento(){
    let id_departamento = $("#input_id_departamento").val();
    let clave = $("#input_clave_departamento").val();
    let nombre = $("#input_nombre_departamento").val();
    let ubicacion = $("#input_ubicacion_departamento").val();
    let extension = $("#input_extension_departamento").val();
    let correo = $("#input_correo_departamento").val();
    if(id_departamento.length !== 0 && clave.length !== 0 && nombre.length !== 0 && ubicacion.length !== 0 && extension.length !== 0 && correo.length !== 0){
        let val = $("#input_select_responsables").val(); 
        let id_responsable = $("#select_responsables option[value='"+val+"']").attr("id");
        if(id_responsable!==undefined){
            update_departamento_responsable(id_departamento,clave,nombre,ubicacion,extension,correo,id_responsable);
        }else{
            update_only_departamento(id_departamento,clave,nombre,ubicacion,extension,correo);
        }
    }else{
        mostrar_alerta(2);
    } 
}

//UPDATE A DEPARTAMENTO Y A DEPARTAMENTO-RESPONSABLE
function update_departamento_responsable(id_departamento,clave,nombre,ubicacion,extension,correo,id_responsable){
    $.ajax({
        type: "POST",
        url: path+"update_departamento_responsable.php",  
        data: {"id_departamento":id_departamento,"clave": clave, "nombre": nombre, "ubicacion": ubicacion, "extension": extension,"correo": correo, "id_responsable": id_responsable} ,                         
        success: function(res){ 
            select_departamentos(); 
            if(res==="1"){
                mostrar_alerta(1);
                borrar_datos_input_departamento();
            }else{
                mostrar_alerta(3);
            }
        }
    });
}

//UPDATE A DEPARTAMENTO
function update_only_departamento(id_departamento,clave,nombre,ubicacion,extension,correo){
    $.ajax({
        type: "POST",
        url: path+"update_departamento.php",  
        data: {"id_departamento":id_departamento,"clave": clave, "nombre": nombre, "ubicacion": ubicacion, "extension": extension, "correo":correo} ,                         
        success: function(res){ 
            select_departamentos(); 
            if(res==="1"){
                mostrar_alerta(1);
                borrar_datos_input_departamento();
            }else{
                mostrar_alerta(3);
            }
        }
    });
}

//MOSTRAR MODAL BORRAR DEPARTAMENTO
function mostrar_modal_borrar_departamento(id_departamento, clave, nombre, ubicacion, extension,correo){
    $("#modal_departamento").modal("show");
    $("#p_clave_departamento").text("Clave: "+clave);
    $("#p_nombre_departamento").text("Nombre: "+nombre);
    $("#p_ubicacion_departamento").text("Ubicación: "+ubicacion);
    $("#p_extension_departamento").text("Extensión: "+extension);
    $("#p_correo_departamento").text("Extensión: "+correo);
    $("#input_id_departamento_borrar").val(id_departamento);
}

//INSERT DE DEPARTAMENTOS
function insert_departamento(){
    let clave = $("#input_clave_departamento").val();
    let nombre = $("#input_nombre_departamento").val();
    let ubicacion = $("#input_ubicacion_departamento").val();
    let extension = $("#input_extension_departamento").val();
    let correo = $("#input_correo_departamento").val();
    if(clave.length !== 0 && nombre.length !== 0 && ubicacion.length !== 0 && extension.length !== 0 && correo.length !== 0){
        let val = $("#input_select_responsables").val(); 
        let id_responsable = $("#select_responsables option[value='"+val+"']").attr("id");
        if(id_responsable!==undefined){
            insert_departamento_responsable(clave, nombre, ubicacion, extension,correo, id_responsable);
        }else{
            insert_only_departamento(clave, nombre, ubicacion, extension,correo);
        }
    }else{
        mostrar_alerta(2);
    }   
}

//INSERT EN DEPARTAMENTO
function insert_only_departamento(clave, nombre, ubicacion, extension,correo){
    $.ajax({
        type: "POST",
        url: path+"insert_departamento.php",  
        data: {"clave": clave, "nombre": nombre, "ubicacion": ubicacion, "extension": extension, "correo":correo+"@colima.tecnm.mx"} ,                         
        success: function(res){  
            select_departamentos();
            if(res==="1"){
                mostrar_alerta(1);
                borrar_datos_input_departamento();
            }else{
                mostrar_alerta(3);
            }           
        }
    });
}


//INSERT EN DEPARTAMENTO Y EN DEPARTAMENTO-RESPONSABLE
function insert_departamento_responsable(clave, nombre, ubicacion, extension, correo,id_responsable){
    $.ajax({
        type: "POST",
        url: path+"insert_departamento_responsable.php",  
        data: {"clave": clave, "nombre": nombre, "ubicacion": ubicacion, "extension": extension,"correo":correo+"@colima.tecnm.mx", "id_responsable": id_responsable} ,                         
        success: function(res){ 
            select_departamentos(); 
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
    $("#input_correo_departamento").val("");
    $("#input_select_responsables").val("");
    $("#boton_insert_update_departamento").attr("onclick","insert_departamento()");
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
            $("#modal_departamento").modal("hide");   
            if(res==="1"){
                mostrar_alerta(1);
            }else{
                mostrar_alerta(3)
            }
        }
    });
}

//IMPRIMIR PDF DEPARTAMENTO
function generar_pdf(id_departamento){
    $.ajax({
        type: "POST",
        data: {"id_departamento": id_departamento},
        url: path+"select_departamento_id.php",                           
        success: function(res){   
            let departamento = JSON.parse(res)[0];           
            let pdf = new jsPDF();
            let columns = [["Clave", "Nombre", "Ubicación", "Extensión","Responsable"]];
            console.log(departamento.nombre_responsable);
            let data = [[departamento.clave, departamento.nombre, departamento.ubicacion, departamento.extension, departamento.nombre_responsable+" "+departamento.apellido_p+" "+departamento.apellido_m]];
            pdf.setProperties({
                title: "Tabla Departamento "+departamento.nombre
            });
            let texto = "Departamento "+departamento.nombre;
            let x = (pdf.internal.pageSize.width/2) - (pdf.getTextWidth(texto)/2)
            pdf.text(texto,x,15);
            pdf.autoTable({
                startY: 25,
                head: columns,
                body: data,
            })
            let blob = pdf.output("blob");
            window.open(URL.createObjectURL(blob));          
        }
    });
}

