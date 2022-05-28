//FUNCIONES PARA PROGRAMAS
//CREACION DE DATATABLE PARA HORARIOS
$('#tabla_horarios').DataTable({
    pageLength: 20,
    caseInsen: false,
    columns: [
        {data: "dia", title: 'Día'},
        {data: "hora_inicio", title: 'Hora Inicio'},
        {data: "hora_fin", title: 'Hora Fin'},
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


function select_horarios(){
    let id_grupo = $("#input_id_grupo").val();
    $.ajax({
        type: "POST",
        url: path+"select_horarios_grupo_id.php",  
        data: {"id_grupo": id_grupo},                    
        success: function(res){    
            let horarios = JSON.parse(res);             
            agregar_horarios_tabla(horarios);
        }
    });
}
select_horarios();


//AGREGA HORARIOS A DATATABLE
function agregar_horarios_tabla(horarios){
    let tabla = $("#tabla_horarios").DataTable();
    tabla.rows().remove().draw();
    for(let horario of horarios){
        tabla.row.add({"dia":horario.dia,"hora_inicio":horario.hora_inicio,"hora_fin":horario.hora_fin,"botoneditar":"<button id='botoneditarhorario"+horario.id_horario+"' class='btn btn-primary'>Editar</button>","botonborrar":"<button id='botonborrarhorario"+horario.id_horario+"' class='btn btn-danger'>Borrar</button>"}).draw();
        $("#botoneditarhorario"+horario.id_horario).on( "click", function(){select_horario_id(horario.id_horario)});
        $("#botonborrarhorario"+horario.id_horario).on( "click", function(){mostrar_modal_borrar_horario(horario.id_horario, horario.dia, horario.hora_inicio, horario.hora_fin)});
    }
}

//INSERTAR HORARIO
function insert_horario(){
    let dia = $("#select_dia_grupo").val();
    let hora_inicio = $("#input_hora_inicio_grupo").val();
    let hora_fin = $("#input_hora_fin_grupo").val();
    let id_grupo = $("#input_id_grupo").val();
    if(dia !== null && hora_inicio.length !== 0 && hora_fin.length !== 0 && id_grupo.length !== 0){
        $.ajax({
            type: "POST",
            url: path+"insert_horario.php",
            data: {"dia":dia,"hora_inicio":hora_inicio,"hora_fin":hora_fin,"id_grupo":id_grupo},
            success: function(res){
                if (res === "1") {
                    mostrar_alerta(1);
                    borrar_datos_input_horario();
                    select_horarios();
                }else{
                    mostrar_alerta(3);
                }
            }
        });
    }else{
        mostrar_alerta(2);
    }
}

function borrar_datos_input_horario(){
    $("#select_dia_grupo").val("O");
    $("#input_hora_inicio_grupo").val("");
    $("#input_hora_fin_grupo").val("");
    $("#boton_insert_update_horario").attr("onclick","insert_horario()");
}

//SELECT DE HORARIO POR ID
function select_horario_id(id_horario){
    $.ajax({
        type: "POST",
        data: {"id_horario": id_horario},
        url: path+"select_horario_id.php",                           
        success: function(res){    
            let horario = JSON.parse(res)[0];
            $("#input_id_horario").val(horario.id_horario);  
            $("#select_dia_grupo").val(horario.dia);                
            $("#input_hora_inicio_grupo").val(horario.hora_inicio);
            $("#input_hora_fin_grupo").val(horario.hora_fin);
            $("#boton_insert_update_horario").attr("onclick","update_horario()");
        }
    });
}

//UPDATE HORARIO
function update_horario(){
    let dia = $("#select_dia_grupo").val();
    let hora_inicio = $("#input_hora_inicio_grupo").val();
    let hora_fin = $("#input_hora_fin_grupo").val();
    let id_horario = $("#input_id_horario").val();
    if(dia !== null && hora_inicio.length !== 0 && hora_fin.length !== 0 && id_horario.length !== 0){
        $.ajax({
            type: "POST",
            url: path+"update_horario.php",
            data: {"dia":dia,"hora_inicio":hora_inicio,"hora_fin":hora_fin,"id_horario":id_horario},
            success: function(res){
                if (res === "1") {
                    mostrar_alerta(1);
                    borrar_datos_input_horario();
                    select_horarios();
                }else{
                    mostrar_alerta(3);
                }
            }
        });
    }else{
        mostrar_alerta(2);
    }
}

function mostrar_modal_borrar_horario(id_horario,dia,hora_incio,hora_fin){
    $("#p_dia_horario").text("Día: "+dia);
    $("#p_hora_inicio_horario").text("Hora de Inicio: "+hora_incio);
    $("#p_hora_fin_horario").text("Hora de Fin: "+hora_fin);
    $("#input_id_horario_borrar").val(id_horario);
    $("#modal_borrar_horario").modal("show");
}

//BORRAR INSTRUCTOR
function borrar_horario(){
    let id_horario= $("#input_id_horario_borrar").val();
    $.ajax({
        type: "POST",
        url: path+"delete_horario.php",  
        data: {"id_horario": id_horario} ,                         
        success: function(res){
            select_horarios();
            $("#modal_borrar_horario").modal("hide");   
            if(res==="1"){
                mostrar_alerta(1);
            }else{
                mostrar_alerta(3)
            }
        }
    });
}