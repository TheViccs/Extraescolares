$('#tabla-directivos').DataTable({
    pageLength: 20,
    caseInsen: false,
    columns: [
        {data: "clave", title: 'Clave'},
        {data: "nombre", title: 'Nombre'},
        {data: "sexo", title: 'Sexo'},
        {data: "correo", title: 'Correo'},
        {data: "botoneditar", title: 'Editar'},
        {data: "botonborrar", title: 'Borrar'},
        {data: "botonimprimir", title: 'Imprimir'}
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

function select_directivos(){
    $.ajax({
        type: "GET",
        url: path+"select_directivos.php",                    
        success: function(res){    
            let directivos = JSON.parse(res);             
            agregar_directivos_tabla(directivos);
        }
    });
}
select_directivos();


//AGREGA directivos A DATATABLE
function agregar_directivos_tabla(directivos){
    let tabla = $("#tabla-directivos").DataTable();
    tabla.rows().remove().draw();
    for(let directivo of directivos){
        tabla.row.add({"clave":directivo.clave,"nombre":directivo.nombre+" "+directivo.apellido_p+" "+directivo.apellido_m,"sexo":directivo.sexo ,"correo":directivo.correo,"botoneditar":"<button id='botoneditardirectivo"+ directivo.id_directivo+"'class='btn btn-primary'> Editar </button>", "botonborrar": "<button id='botonborrardirectivo"+directivo.id_directivo+"'class='btn btn-danger' >Borrar</button>", "botonimprimir":"<button id='botonimprimir"+directivo.id_directivo+"' class= 'btn btn-dark'>Imprimir</button>"}).draw();
        $("#botoneditardirectivo"+directivo.id_directivo).on( "click", function(){select_directivo_id(directivo.id_directivo)});
        $("#botonborrardirectivo"+directivo.id_directivo).on( "click", function(){mostrar_modal_borrar_directivo(directivo.id_directivo, directivo.nombre+" "+directivo.apellido_p+" "+directivo.apellido_m, directivo.sexo, directivo.correo)});
        $("#botonimprimir"+directivo.id_directivo).on( "click", function(){generar_pdf(directivo.id_directivo)});
    }
}

//MOSTRAR MODAL BORRAR directivo
function mostrar_modal_borrar_directivo(id_directivo, nombre, sexo,correo){
    $("#p_nombre_directivo").text("Nombre: "+nombre);
    $("#p_sexo_directivo").text("Sexo: "+sexo);
    $("#p_correo_directivo").text("Correo: "+correo);
    $("#input_id_directivo_borrar").val(id_directivo);
    $("#modal-directivo").modal("show");
}


//MODAL INSERTAR directivo
function mostrar_modal_insertar_directivo(){
    let nombre = $("#input_nombre_directivo").val();
    let apellido_p = $("#input_apellido_p_directivo").val();
    let apellido_m = $("#input_apellido_m_directivo").val();
    let sexo = $("#select_sexo_directivo").val();
    let correo = $("#input_correo_directivo").val();
    let id_departamento = $("#input_id_departamento").val();
    if(nombre.length !== 0 && apellido_p.length !== 0 && apellido_m.length !== 0 && correo.length !== 0 && sexo!==null && id_departamento.length !== 0){
        $("#p_nombre_directivo_insertar").text("Nombre: "+nombre+" "+apellido_p+" "+apellido_m);
        $("#p_sexo_directivo_insertar").text("Sexo: "+sexo);
        $("#p_correo_directivo_insertar").text("Correo: "+correo);
        $("#modal_insertar_directivo").modal("show");
    }else{
        mostrar_alerta(2);
    }
    
}


//INSERTAR directivo
function insert_directivo(){
    let clave = $("#input_clave_directivo").val();
    let nombre = $("#input_nombre_directivo").val();
    let apellido_p = $("#input_apellido_p_directivo").val();
    let apellido_m = $("#input_apellido_m_directivo").val();
    let sexo = $("#select_sexo_directivo").val();
    let correo = $("#input_correo_directivo").val();
    if(clave.length !== 0 && nombre.length !== 0 && apellido_p.length !== 0 && apellido_m.length !== 0 && correo.length !== 0 && sexo!==null){
        $.ajax({
            type: "POST",
            url: path+"insert_directivo.php",
            data: {"clave":clave,"nombre":nombre,"apellido_p":apellido_p,"apellido_m":apellido_m,"sexo":sexo,"correo":correo + "@colima.tecnm.mx"},
            success: function(res){
                console.log(res);
                select_directivos();
                if (res === "1") {
                    borrar_datos_input_directivo();
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

//UPDATE A directivo
function update_directivo(){
    let id_directivo = $("#input_id_directivo").val();
    let clave = $("#input_clave_directivo").val();
    let nombre = $("#input_nombre_directivo").val();
    let apellido_p = $("#input_apellido_p_directivo").val();
    let apellido_m = $("#input_apellido_m_directivo").val();
    let sexo = $("#select_sexo_directivo").val();
    let correo = $("#input_correo_directivo").val();
    if(id_directivo.length !== 0 && nombre.length !== 0 && apellido_p.length !== 0 && apellido_m.length !== 0 && correo.length !== 0 && sexo!=="O"){
        $.ajax({
            type: "POST",
            url: path+"update_directivo.php",  
            data: {"id_directivo": id_directivo, "nombre": nombre, "apellido_p": apellido_p, "apellido_m": apellido_m, "sexo":sexo,"correo": correo} ,                         
            success: function(res){ 
                console.log(res);
                select_directivos(); 
                if(res==="1"){
                    mostrar_alerta(1);
                    borrar_datos_input_directivo();
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
function borrar_datos_input_directivo(){
    $("#input_clave_directivo").val("");
    $("#input_nombre_directivo").val("");
    $("#input_apellido_p_directivo").val("");
    $("#input_apellido_m_directivo").val("");
    $("#select_sexo_directivo").val("O");
    $("#input_correo_directivo").val("");
    $("#boton_insert_update_directivo").attr("onclick","mostrar_modal_insertar_directivo()");
}

//BORRAR directivo
function borrar_directivo(){
    let id_directivo= $("#input_id_directivo_borrar").val();
    $.ajax({
        type: "POST",
        url: path+"delete_directivo.php",  
        data: {"id_directivo": id_directivo} ,                         
        success: function(res){
            select_directivos();
            $("#modal-directivo").modal("hide");   
            if(res==="1"){
                mostrar_alerta(1);
            }else{
                mostrar_alerta(3)
            }
        }
    });
}

//IMPRIMIR PDF DEPARTAMENTO
function generar_pdf(id_directivo){
    $.ajax({
        type: "POST",
        data: {"id_directivo": id_directivo},
        url: path+"select_directivo_id.php",                           
        success: function(res){   
            let directivo = JSON.parse(res)[0];           
            let pdf = new jsPDF();
            let columns = [["Nombre","Correo"]]; 
            let data = [[directivo.nombre+" "+directivo.apellido_p+" "+directivo.apellido_m, directivo.correo]];
            pdf.setProperties({
                title: "Tabla directivo "+directivo.nombre
            });
            let texto = "directivo "+directivo.nombre;
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


//SELECT DE directivo POR ID
function select_directivo_id(id_directivo){
    $.ajax({
        type: "POST",
        data: {"id_directivo": id_directivo},
        url: path+"select_directivo_id.php",                           
        success: function(res){    
            let directivo = JSON.parse(res)[0];
            $("#input_id_directivo").val(directivo.id_directivo);                
            $("#input_nombre_directivo").val(directivo.nombre);
            $("#input_apellido_p_directivo").val(directivo.apellido_p);
            $("#input_apellido_m_directivo").val(directivo.apellido_m);
            $("#select_sexo_directivo").val(directivo.sexo);
            $("#input_correo_directivo").val(directivo.correo);
            $("#boton_insert_update_directivo").attr("onclick","update_directivo()");
        }
    });
}