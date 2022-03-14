$('#tabla_coordinadores').DataTable({
    pageLength: 20,
    caseInsen: false,
    columns: [
        {data: "clave", title:'Clave'},
        {data: "nombre", title: 'Nombre'},
        {data: "correo", title: 'Correo'},
        {data: "botoneditar", title: 'Editar'},
        {data: "botonborrar", title: 'Borrar'},
        {data: "botonimprimir", title: 'Imprimir'}
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

//SELECT DE COORDINADORES
function select_coordinadores(){
    $.ajax({
        type: "GET",
        url: path+"select_coordinadores.php",                           
        success: function(res){    
            let coordinadores = JSON.parse(res);             
            agregar_coordinadores_tabla(coordinadores);
        }
    });
}
select_coordinadores();

//AGREGA PROGRAMAS A DATATABLE
function agregar_coordinadores_tabla(coordinadores){
    let tabla = $("#tabla_coordinadores").DataTable();
    tabla.rows().remove().draw();
    for(let coordinador of coordinadores){
        tabla.row.add({"clave":coordinador.clave,"nombre":coordinador.nombre+" "+coordinador.apellido_p+" "+coordinador.apellido_m,"correo":coordinador.correo,"botoneditar":"<button id='botoneditardepartamento"+coordinador.id_coordinador+"' class='btn btn-primary'>Editar</button>","botonborrar":"<button id='botonborrardepartamento"+coordinador.id_coordinador+"' class='btn btn-danger'>Borrar</button>","botonimprimir":"<button id='botonimprimirdepartamento"+coordinador.id_coordinador+"' class='btn btn-dark'>Imprimir</button>"}).draw();
        /* $("#botoneditarprograma"+programa.id_programa).on( "click", function(){select_programa_id(programa.id_programa)}); */
    }
}

//INSERT DE COORDINADOR
function insert_coordinador(){
    let clave = $("#input_clave_coordinador").val();
    let nombre = $("#input_nombre_coordinador").val();
    let apellido_p = $("#input_apellido_p_coordinador").val();
    let apellido_m = $("#input_apellido_m_coordinador").val();
    let correo = $("#input_correo_coordinador").val();
    if(clave.length !== 0 && nombre.length !== 0 && apellido_p.length !== 0 && apellido_m.length !== 0 && correo.length !== 0){
        $.ajax({
            type: "POST",
            url: path+"insert_coordinador.php",
            data: {"clave":clave,"nombre":nombre,"apellido_p":apellido_p,"apellido_m":apellido_m,"correo":correo + "@colima.tecnm.mx"},
            success: function(res){
                borrar_datos_input_coordinador();
                select_coordinadores();
                if (res === "1") {
                    mostrar_alerta(1);
                }else{
                    mostrar_alerta(2);
                }
            }
        });
    }else{
        mostrar_alerta(2);
    }   
}

//BORRAR DATOS DE LOS INPUT COORDINADOR
function borrar_datos_input_coordinador(){
    $("#input_clave_coordinador").val("");
    $("#input_nombre_coordinador").val("");
    $("#input_apellido_p_coordinador").val("");
    $("#input_apellido_m_coordinador").val("");
    $("#input_correo_coordinador").val("");
}