//FUNCIONES PARA DEPARTAMENTOS
//SELECT DE DEPARTAMENTOS
function select_departamentos(){
    $.ajax({
        type: "GET",
        url: path+"select_departamentos.php",                           
        success: function(res){                    
            let departamentos = JSON.parse(res);
            agregar_departamentos_select(departamentos);
        }
    });
}
select_departamentos();

//AGREGAR LOS DEPARTAMENTOS AL SELECT
function agregar_departamentos_select(departamentos){
    $("#select_programas").html("");
    for(let departamento of departamentos){
        $("#select_programas").append("<option id="+departamento.id_departamento+" value='"+departamento.nombre+"'>"+departamento.nombre+"</option>");
    }
    $("#select_programas").multiSelect();
}

//------------------------------------------------------------------------------------------------------

//FUNCIONES PARA PROGRAMAS
//CREACION DE DATATABLE PARA PROGRAMAS
$('#tabla_programas').DataTable({
    pageLength: 20,
    caseInsen: false,
    columns: [
        {data: "clave", title:'Clave'},
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

//AGREGA PROGRAMAS A DATATABLE
function agregar_programas_tabla(programas){
    let tabla = $("#tabla_programas").DataTable();
    tabla.rows().remove().draw();
    for(let programa of programas){
        tabla.row.add({"clave":programa.clave,"nombre":programa.nombre,"descripcion":programa.descripcion,"observaciones":programa.observaciones,"botoneditar":"<button id='botoneditarprograma"+programa.id_programa+"' class='btn btn-primary'>Editar</button>","botonborrar":"<button id='botonborrarprograma"+programa.id_programa+"' class='btn btn-danger'>Borrar</button>","botonimprimir":"<button id='botonimprimirprograma"+programa.id_programa+"' class='btn btn-dark'>Imprimir</button>"}).draw();
        $("#botoneditarprograma"+programa.id_programa).on( "click", function(){select_programa_id(programa.id_programa)});
        $("#botonborrarprograma"+programa.id_programa).on( "click", function(){mostrar_modal_borrar_programa(programa.id_programa,programa.clave, programa.nombre, programa.descripcion)});
        $("#botonimprimirprograma"+programa.id_programa).on( "click", function(){generar_pdf(programa.id_programa)});
    }
}

//FUNCION PARA REALIZAR LOS INSERT DE PROGRAMA
function insert_programa(){
    //OBTIENE VALORES DE LOS INPUT
    let clave =  $("#input_clave_programa").val();
    let nombre = $("#input_nombre_programa").val();
    let descripcion = $("#input_descripcion_programa").val();
    let observaciones = $("#input_observaciones_programa").val();
    //VERIFICA QUE LA CLAVE Y EL NOMBRE NO ESTEN VACIOS
    if(clave.length !==0 && nombre.length !== 0){
        //OBTIENE LOS ID DE LOS DEPARTAMENTOS SELECCIONADOS
        let departamentos = [].map.call($("#select_programas option:selected"),function(departamento){
            return departamento.id;
        })
        //OBTIENE LOS ID Y LOS NOMBRES DE LOS DEPARTAMENTOS SELECCIONADOS
        let departamentosaux = [].map.call($("#select_programas option:selected"),function(departamento){
            return [departamento.id, departamento.value];
        })
        if(departamentos.length===0){
            insert_only_programa(clave,nombre,descripcion,observaciones);
        }else{
            $("#modal_departamentos_label").text("Agregar correos a programa "+nombre)
            $("#inputs_correo_departamento").html("");
            departamentosaux.forEach(departamento => {
                $("#inputs_correo_departamento").append("<label>Correo "+departamento[1]+"</label><br><input class='correo-departamento' placeholder='Correo'/><br>")
            });
            $("#modal_departamentos").modal("show");       
        }
    }else{
        mostrar_alerta(2);
    }   
}

function insert_programa_departamento_correos(){
    let flag = false;

    let correos = [].map.call($(".correo-departamento"),function(correo){
        if(correo.value.length === 0){
            flag = true;
        }
        return correo.value+"@colima.tecnm.mx";
    });
    if(flag){
        $("#modal_departamentos").modal("hide");
        mostrar_alerta(2);
    }else{
        let clave =  $("#input_clave_programa").val();
        let nombre = $("#input_nombre_programa").val();
        let descripcion = $("#input_descripcion_programa").val();
        let observaciones = $("#input_observaciones_programa").val();
        let departamentos = [].map.call($("#select_programas option:selected"),function(departamento){
            return departamento.id;
        })
        insert_programa_departamento(clave, nombre, descripcion, observaciones, departamentos, correos);
    }
}

//INSERT DE SOLO EL PROGRAMA
function insert_only_programa(clave, nombre, descripcion, observaciones){
    $.ajax({
        type: "POST",
        url: path+"insert_programa.php",  
        data: {"clave": clave, "nombre": nombre, "descripcion": descripcion, "observaciones": observaciones} ,                         
        success: function(res){ 
            select_programas();
            if(res==="1"){
                mostrar_alerta(1);
                borrar_datos_input_programa();
            }else{
                mostrar_alerta(3);
            }           
        }
    });
}

//INSERT A PROGRAMA Y A DEPARTAMENTO PROGRAMA
function insert_programa_departamento(clave, nombre, descripcion, observaciones, departamentos, correos){
    $.ajax({
        type: "POST",
        url: path+"insert_programa_departamento.php",  
        data: {"clave": clave, "nombre": nombre, "descripcion": descripcion, "observaciones": observaciones, "departamentos": departamentos.toString(), "correos": correos.toString()} ,                         
        success: function(res){  
            mostrar_alerta(1);
            select_programas();
            borrar_datos_input_programa();  
            $("#modal_departamentos").modal("hide");
        }
    });
}

//SELECT DE PROGRAMA POR ID
function select_programa_id(id_programa){
    $.ajax({
        type: "POST",
        data: {"id_programa": id_programa},
        url: path+"select_programa_id.php",                           
        success: function(res){    
            let programa = JSON.parse(res)[0];
            let departamentos = JSON.parse(res).map(function(programa){
                return programa.nombre_departamento;
            });
            $("#input_id_programa").val(id_programa); 
            $("#input_clave_programa").val(programa.clave);                
            $("#input_nombre_programa").val(programa.nombre);
            $("#input_descripcion_programa").val(programa.descripcion);
            $("#input_observaciones_programa").val(programa.observaciones);
            if(departamentos[0]!==null){
                $('#select_programas').multiSelect("select",departamentos);
            }else{
                $('#select_programas').multiSelect('deselect_all');
            }
            $("#boton_insert_update_programa").attr("onclick","update_programa()");
            $("#insert_programa_departamento_correos").attr("onclick","update_programa_departamento_correos()");
        }
    });
}

//UPDATE PROGRAMA
function update_programa(){
    let id_programa = $("#input_id_programa").val();
    let clave =  $("#input_clave_programa").val();
    let nombre = $("#input_nombre_programa").val();
    let descripcion = $("#input_descripcion_programa").val();
    let observaciones = $("#input_observaciones_programa").val();
    if(id_programa.length !== 0 && clave.length !== 0 && nombre.length !== 0){
        let departamentos = [].map.call($("#select_programas option:selected"),function(departamento){
            return departamento.id;
        })
        if(departamentos.length===0){
            update_only_programa(id_programa,clave,nombre,descripcion,observaciones);
        }else{
            let departamentosaux = [].map.call($("#select_programas option:selected"),function(departamento){
                return [departamento.id, departamento.value];
            })
            $("#modal_departamentos_label").text("Agregar correos a programa "+nombre)
            $("#inputs_correo_departamento").html("");
            departamentosaux.forEach(departamento => {
            $("#inputs_correo_departamento").append("<label>Correo "+departamento[1]+"</label><br><input class='correo-departamento' placeholder='Correo'/><br>")
            });
            $("#modal_departamentos").modal("show");       
        }
    }else{
        mostrar_alerta(2);
    } 
}

function update_programa_departamento_correos(){
    let flag = false;
    let correos = [].map.call($(".correo-departamento"),function(correo){
        if(correo.value.length === 0){
            flag = true;
        }
        return correo.value+"@colima.tecnm.mx";
    });

    if(flag){
        $("#modal_departamentos").modal("hide");
        mostrar_alerta(2);
    }else{
        let id_programa = $("#input_id_programa").val();
        let clave =  $("#input_clave_programa").val();
        let nombre = $("#input_nombre_programa").val();
        let descripcion = $("#input_descripcion_programa").val();
        let observaciones = $("#input_observaciones_programa").val();
        let departamentos = [].map.call($("#select_programas option:selected"),function(departamento){
            return departamento.id;
        })
        update_programa_departamento(id_programa,clave, nombre, descripcion, observaciones, departamentos, correos);
    }
}

//UPDATE A DEPARTAMENTO
function update_only_programa(id_programa,clave,nombre,descripcion,observaciones){
    $.ajax({
        type: "POST",
        url: path+"update_programa.php",  
        data: {"id_programa":id_programa, "clave":clave, "nombre": nombre, "descripcion": descripcion, "observaciones": observaciones} ,                         
        success: function(res){ 
            select_programas(); 
            if(res==="1"){
                mostrar_alerta(1);
                borrar_datos_input_programa();
            }else{
                mostrar_alerta(3);
            }
        }
    });
}

//UPDATE A PROGRAMA Y A PROGRAMA-DEPARTAMENTO
function update_programa_departamento(id_programa,clave,nombre,descripcion,observaciones,departamentos,correos){
    $.ajax({
        type: "POST",
        url: path+"update_programa_departamento.php",  
        data: {"id_programa": id_programa,"clave": clave, "nombre": nombre, "descripcion": descripcion, "observaciones": observaciones, "departamentos": departamentos.toString(), "correos": correos.toString()} ,                         
        success: function(res){  
            mostrar_alerta(1);
            select_programas();
            borrar_datos_input_programa();  
            $("#modal_departamentos").modal("hide");
        }
    });
}

//MOSTRAR MODAL BORRAR PROGRAMA
function mostrar_modal_borrar_programa(id_programa,clave, nombre, descripcion){
    $("#modal_programa").modal("show");
    $("#p_clave_programa").text("Clave: "+clave);
    $("#p_nombre_programa").text("Nombre: "+nombre);
    if(descripcion===null){
        descripcion = "N/A";
    }
    $("#p_descripcion_programa").text("Descripción: "+descripcion);
    $("#input_id_programa_borrar").val(id_programa);
}

//BORRAR DATOS DE LOS INPUT DEPARTAMENTO
function borrar_datos_input_programa(){
    $("#input_clave_programa").val("");
    $("#input_nombre_programa").val("");
    $("#input_descripcion_programa").val("");
    $("#input_observaciones_programa").val("");
    $('#select_programas').multiSelect('deselect_all');
    $("#boton_insert_update_programa").attr("onclick","insert_programa()");
    $("#insert_programa_departamento_correos").attr("onclick","insert_programa_departamento_correos()");
}

//BORRAR PROGRAMA
function borrar_programa(){
    let id_programa = $("#input_id_programa_borrar").val();
    $.ajax({
        type: "POST",
        url: path+"delete_programa.php",  
        data: {"id_programa": id_programa} ,                         
        success: function(res){
            select_programas();
            $("#modal_programa").modal("hide");   
            if(res==="1"){
                mostrar_alerta(1);
            }else{
                mostrar_alerta(3)
            }
        }
    });
}

//IMPRIMIR PDF PROGRAMA
function generar_pdf(id_programa){
    $.ajax({
        type: "POST",
        data: {"id_programa": id_programa},
        url: path+"select_programa_id.php",                           
        success: function(res){   
            let programas = JSON.parse(res);
            let departamentos = [];
            let data = []; 
            programas.forEach(programa => {
                departamentos.push(programa.nombre_departamento);
            });
            data.push([programas[0].clave, programas[0].nombre, programas[0].descripcion, programas[0].observaciones, departamentos]);
            let pdf = new jsPDF();
            let columns = [["Clave", "Nombre", "Descripción", "Observaciones","Departamentos"]];            
            pdf.setProperties({
                title: "Tabla Programa "+programas[0].nombre
            });
            let texto = "Programa "+programas[0].nombre;
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