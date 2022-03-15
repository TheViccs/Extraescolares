$('#tabla-responsables').DataTable({
    pageLength: 20,
    caseInsen: false,
    columns: [
        {data: "clave", title: 'Clave'},
        {data: "nombre", title: 'Nombre'},
        {data: "sexo", title: 'Sexo'},
        {data: "correo", title: 'Correo'},
        {data: "botoneditar", title: 'Editar'},
        {data: "botonborrar", title: 'Borrar'},
        {data: "botonimprimir", title: 'Impirmir'}
    ],
    "columnDefs": [
        { "orderable": false, "targets": [4,5,6] },
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

function select_responsables(){
    $.ajax({
        type: "GET",
        url: path+"select_responsables.php",                           
        success: function(res){    
            let responsables = JSON.parse(res);             
            agregar_responsables_tabla(responsables);
        }
    });
}
select_responsables();


//AGREGA DEPARTAMENTOS A DATATABLE
function agregar_responsables_tabla(responsables){
    let tabla = $("#tabla-responsables").DataTable();
    tabla.rows().remove().draw();
    for(let responsable of responsables){
        tabla.row.add({"clave":responsable.clave, "nombre":responsable.nombre+" "+responsable.apellido_p+" "+responsable.apellido_m,"sexo":responsable.sexo ,"correo":responsable.correo,"botoneditar":"<button id='botoneditarresponsable"+ responsable.id_responsable+"'class='btn btn-primary'> Editar </button>", "botonborrar": "<button id='botonborrarresponsable"+responsable.id_responsable+"'class='btn btn-danger' >Borrar</button>", "botonimprimir":"<button id='botonimprimir"+responsable.id_responsable+"' class= 'btn btn-dark'>Imprimir</button>"}).draw();
        $("#botoneditarresponsable"+responsable.id_responsable).on( "click", function(){select_responsable_id(responsable.id_responsable)});
        $("#botonborrarresponsable"+responsable.id_responsable).on( "click", function(){mostrar_modal_borrar_responsable(responsable.id_responsable, responsable.clave, responsable.nombre+" "+responsable.apellido_p+" "+responsable.apellido_m, responsable.sexo, responsable.correo)});
        $("#botonimprimir"+responsable.id_responsable).on( "click", function(){generar_pdf(responsable.id_responsable)});
    }
}

//MOSTRAR MODAL BORRAR RESPONSABLE
function mostrar_modal_borrar_responsable(id_responsable, clave, nombre, sexo,correo){
    $("#modal-responsable").modal("show");
    $("#p_clave_resposable").text("Clave: "+clave);
    $("#p_nombre_resposable").text("Nombre: "+nombre);
    $("#p_sexo_resposable").text("Sexo: "+sexo);
    $("#p_correo_resposable").text("Correo: "+correo);
    $("#input_id_responsable_borrar").val(id_responsable);
}


//INSERTAR RESPONSABLE
function insert_responsable(){
    let clave = $("#input_clave_responsable").val();
    let nombre = $("#input_nombre_responsable").val();
    let apellido_p = $("#input_apellido_p_responsable").val();
    let apellido_m = $("#input_apellido_m_responsable").val();
    let sexo = $("#select_sexo_responsable").val();
    console.log(sexo);
    let correo = $("#input_correo_responsable").val();
    if(clave.length !== 0 && nombre.length !== 0 && apellido_p.length !== 0 && apellido_m.length !== 0 && correo.length !== 0 && sexo!==null){
        $.ajax({
            type: "POST",
            url: path+"insert_responsable.php",
            data: {"clave":clave,"nombre":nombre,"apellido_p":apellido_p,"apellido_m":apellido_m,"sexo":sexo,"correo":correo + "@colima.tecnm.mx"},
            success: function(res){
                borrar_datos_input_responsable();
                select_responsables();
                if (res === "1") {
                    mostrar_alerta(1);
                }else{
                    mostrar_alerta(3);
                }
            }
        });
    }else{
        mostrar_alerta(2);
    }
}

//UPDATE A RESPONSABLE
function update_responsable(){
    let id_responsable = $("#input_id_responsable").val();
    let clave = $("#input_clave_responsable").val();
    let nombre = $("#input_nombre_responsable").val();
    let apellido_p = $("#input_apellido_p_responsable").val();
    let apellido_m = $("#input_apellido_m_responsable").val();
    let sexo = $("#select_sexo_responsable").val();
    let correo = $("#input_correo_responsable").val();
    if(id_responsable.length !== 0 && clave.length !== 0 && nombre.length !== 0 && apellido_p.length !== 0 && apellido_m.length !== 0 && correo.length !== 0 && sexo!=="O"){
        $.ajax({
            type: "POST",
            url: path+"update_responsable.php",  
            data: {"id_responsable": id_responsable, "clave": clave, "nombre": nombre, "apellido_p": apellido_p, "apellido_m": apellido_m, "sexo":sexo,"correo": correo} ,                         
            success: function(res){ 
                select_responsables(); 
                if(res==="1"){
                    mostrar_alerta(1);
                    borrar_datos_input_responsable();
                }else{
                    mostrar_alerta(3);
                }
            }
        });
    }else{
        mostrar_alerta(2);
    }
}

//LIMPIAR CAJAS DE TEXTO
function borrar_datos_input_responsable(){
    $("#input_clave_responsable").val("");
    $("#input_nombre_responsable").val("");
    $("#input_apellido_p_responsable").val("");
    $("#input_apellido_m_responsable").val("");
    $("#select_sexo_responsable").val("O");
    $("#input_correo_responsable").val("");
    $("#boton_insert_update_responsable").attr("onclick","insert_responsable()");
}

//BORRAR RESPONSABLE
function borrar_responsable(){
    let id_responsable= $("#input_id_responsable_borrar").val();
    $.ajax({
        type: "POST",
        url: path+"delete_responsable.php",  
        data: {"id_responsable": id_responsable} ,                         
        success: function(res){
            select_responsables();
            $("#modal-responsable").modal("hide");   
            if(res==="1"){
                mostrar_alerta(1);
            }else{
                mostrar_alerta(3)
            }
        }
    });
}

//IMPRIMIR PDF DEPARTAMENTO
function generar_pdf(id_responsable){
    $.ajax({
        type: "POST",
        data: {"id_responsable": id_responsable},
        url: path+"select_responsable_id.php",                           
        success: function(res){   
            let responsable = JSON.parse(res)[0];           
            let pdf = new jsPDF();
            let columns = [["Clave","Nombre","Correo"]]; 
            let data = [[responsable.clave_responsable, responsable.nombre+" "+responsable.apellido_p+" "+responsable.apellido_m, responsable.correo]];
            pdf.setProperties({
                title: "Tabla Responsable "+responsable.nombre
            });
            let texto = "Responsable "+responsable.nombre;
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


//SELECT DE DEPARTAMENTO POR ID
function select_responsable_id(id_responsable){
    $.ajax({
        type: "POST",
        data: {"id_responsable": id_responsable},
        url: path+"select_responsable_id.php",                           
        success: function(res){    
            let responsable = JSON.parse(res)[0];
            $("#input_id_responsable").val(responsable.id_responsable);                
            $("#input_clave_responsable").val(responsable.clave_responsable);
            $("#input_nombre_responsable").val(responsable.nombre);
            $("#input_apellido_p_responsable").val(responsable.apellido_p);
            $("#input_apellido_m_responsable").val(responsable.apellido_m);
            $("#select_sexo_responsable").val(responsable.sexo);
            $("#input_correo_responsable").val(responsable.correo_responsable);
            $("#boton_insert_update_responsable").attr("onclick","update_responsable()");
        }
    });
}

