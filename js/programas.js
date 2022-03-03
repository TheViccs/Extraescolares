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
        tabla.row.add({"nombre":programa.nombre,"descripcion":programa.descripcion,"observaciones":programa.observaciones,"botoneditar":"<button id='botoneditarprograma"+programa.id_programa+"' class='btn btn-primary'>Editar</button>","botonborrar":"<button id='botonborrarprograma"+programa.id_programa+"' class='btn btn-danger'>Borrar</button>","botonimprimir":"<button id='botonimprimirprograma"+programa.id_programa+"' class='btn btn-dark'>Imprimir</button>"}).draw();
        $("#botoneditarprograma"+programa.id_programa).on( "click", function(){select_programa_id(programa.id_programa)});
        $("#botonborrarprograma"+programa.id_programa).on( "click", function(){mostrar_modal_borrar_programa(programa.id_programa, programa.nombre, programa.descripcion)});
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
            let departamentos = JSON.parse(res).map(function(programa){
                return programa.nombre_departamento;
            });
            $("#input_id_programa").val(programa.id_programa);                
            $("#input_nombre_programa").val(programa.nombre);
            $("#input_descripcion_programa").val(programa.descripcion);
            $("#input_observaciones_programa").val(programa.observaciones);
            if(departamentos[0]!==null){
                $('#select_programas').multiSelect("select",departamentos);
            }else{
                $('#select_programas').multiSelect('deselect_all');
            }
        }
    });
}

//MOSTRAR MODAL BORRAR PROGRAMA
function mostrar_modal_borrar_programa(id_programa, nombre, descripcion){
    $("#modal_programa").modal("show");
    $("#p_nombre_programa").text("Nombre: "+nombre);
    if(descripcion===null){
        descripcion = "N/A";
    }
    $("#p_descripcion_programa").text("Descripción: "+descripcion);
    $("#input_id_programa_borrar").val(id_programa);
}

//INSERT DE PROGRAMA
function insert_programa(){
    let nombre = $("#input_nombre_programa").val();
    let descripcion = $("#input_descripcion_programa").val();
    let observaciones = $("#input_observaciones_programa").val();
    if(nombre.length !== 0){
        let departamentos = [].map.call($("#select_programas option:selected"),function(departamento){
            return departamento.id;
        })
        $.ajax({
            type: "POST",
            url: path+"insert_programa.php",  
            data: {"nombre": nombre, "descripcion": descripcion, "observaciones": observaciones} ,                         
            success: function(res){  
                select_programas();
                if(res==="1"){
                    let departamentos = [].map.call($("#select_programas option:selected"),function(departamento){
                        return departamento.id;
                    })
                    if(departamentos.length===0){
                        /* 
                            MODIFICAR ESTO
                            select_departamento_clave(clave,id_responsable); 
                        */
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