//CRWACION DE DATATABLE DE INSTRUCTORES
$('#tabla-instructores').DataTable({
    pageLength: 20,
    caseInsen: false,
    columns: [
        {data: "nombre", title: 'Nombre'},
        {data: "sexo", title: 'Sexo'},
        {data: "correo", title: 'Correo'},
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

//SELECT DE INSTRUCTORES DEL DEPARTAMENTO
function select_instructores(){
    let id_departamento = $("#input_id_departamento").val();
    $.ajax({
        type: "POST",
        url: path+"select_instructores_departamento_id.php",  
        data: {"id_departamento": id_departamento},                    
        success: function(res){    
            let instructores = JSON.parse(res);             
            agregar_instructores_tabla(instructores);
        }
    });
}
select_instructores();


//AGREGA INSTRUCTORES A DATATABLE
function agregar_instructores_tabla(instructores){
    let tabla = $("#tabla-instructores").DataTable();
    tabla.rows().remove().draw();
    for(let instructor of instructores){
        tabla.row.add({"nombre":instructor.nombre+" "+instructor.apellido_p+" "+instructor.apellido_m,"sexo":instructor.sexo ,"correo":instructor.correo,"botoneditar":"<button id='botoneditarinstructor"+ instructor.id_instructor+"'class='btn btn-primary'> Editar </button>", "botonborrar": "<button id='botonborrarinstructor"+instructor.id_instructor+"'class='btn btn-danger' >Borrar</button>", "botonimprimir":"<button id='botonimprimir"+instructor.id_instructor+"' class= 'btn btn-dark'>Imprimir</button>"}).draw();
        $("#botoneditarinstructor"+instructor.id_instructor).on( "click", function(){select_instructor_id(instructor.id_instructor)});
        $("#botonborrarinstructor"+instructor.id_instructor).on( "click", function(){mostrar_modal_borrar_instructor(instructor.id_instructor, instructor.nombre+" "+instructor.apellido_p+" "+instructor.apellido_m, instructor.sexo, instructor.correo)});
        $("#botonimprimir"+instructor.id_instructor).on( "click", function(){generar_pdf(instructor.id_instructor)});
    }
}

//MOSTRAR MODAL BORRAR INSTRUCTOR
function mostrar_modal_borrar_instructor(id_instructor, nombre, sexo,correo){
    $("#p_nombre_instructor").text("Nombre: "+nombre);
    $("#p_sexo_instructor").text("Sexo: "+sexo);
    $("#p_correo_instructor").text("Correo: "+correo);
    $("#input_id_instructor_borrar").val(id_instructor);
    $("#modal-instructor").modal("show");
}


//MODAL INSERTAR INSTRUCTOR
function mostrar_modal_insertar_instructor(){
    let nombre = $("#input_nombre_instructor").val();
    let apellido_p = $("#input_apellido_p_instructor").val();
    let apellido_m = $("#input_apellido_m_instructor").val();
    let sexo = $("#select_sexo_instructor").val();
    let correo = $("#input_correo_instructor").val();
    let id_departamento = $("#input_id_departamento").val();
    if(nombre.length !== 0 && apellido_p.length !== 0 && apellido_m.length !== 0 && correo.length !== 0 && sexo!==null && id_departamento.length !== 0){
        $("#p_nombre_instructor_insertar").text("Nombre: "+nombre+" "+apellido_p+" "+apellido_m);
        $("#p_sexo_instructor_insertar").text("Sexo: "+sexo);
        $("#p_correo_instructor_insertar").text("Correo: "+correo);
        $("#modal_insertar_instructor").modal("show");
    }else{
        mostrar_alerta(2);
    }
    
}


//INSERTAR INSTRUCTOR
function insert_instructor(){
    let nombre = $("#input_nombre_instructor").val();
    let apellido_p = $("#input_apellido_p_instructor").val();
    let apellido_m = $("#input_apellido_m_instructor").val();
    let sexo = $("#select_sexo_instructor").val();
    let correo = $("#input_correo_instructor").val();
    let fecha_inicio = $("#input_fecha_inicio_instructor").val();
    let fecha_fin = $("#input_fecha_fin_instructor").val();
    let id_departamento = $("#input_id_departamento").val();
    if(nombre.length !== 0 && apellido_p.length !== 0 && apellido_m.length !== 0 && correo.length !== 0 && sexo!==null && fecha_inicio.length!==0 && fecha_fin.length!==0 && id_departamento.length !== 0){
        $.ajax({
            type: "POST",
            url: path+"insert_instructor.php",
            data: {"nombre":nombre,"apellido_p":apellido_p,"apellido_m":apellido_m,"sexo":sexo,"correo":correo + "@colima.tecnm.mx", "fecha_inicio": fecha_inicio, "fecha_fin": fecha_fin, "id_departamento": id_departamento},
            success: function(res){
                borrar_datos_input_instructor();
                select_instructores();
                $("#modal_insertar_instructor").modal("hide");
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

//UPDATE A INSTRUCTOR
function update_instructor(){
    let id_instructor = $("#input_id_instructor").val();
    let clave = $("#input_clave_instructor").val();
    let nombre = $("#input_nombre_instructor").val();
    let apellido_p = $("#input_apellido_p_instructor").val();
    let apellido_m = $("#input_apellido_m_instructor").val();
    let sexo = $("#select_sexo_instructor").val();
    let correo = $("#input_correo_instructor").val();
    if(id_instructor.length !== 0 && nombre.length !== 0 && apellido_p.length !== 0 && apellido_m.length !== 0 && correo.length !== 0 && sexo!=="O"){
        $.ajax({
            type: "POST",
            url: path+"update_instructor.php",  
            data: {"id_instructor": id_instructor, "nombre": nombre, "apellido_p": apellido_p, "apellido_m": apellido_m, "sexo":sexo,"correo": correo} ,                         
            success: function(res){ 
                console.log(res);
                select_instructores(); 
                if(res==="1"){
                    mostrar_alerta(1);
                    borrar_datos_input_instructor();
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
function borrar_datos_input_instructor(){
    $("#input_nombre_instructor").val("");
    $("#input_apellido_p_instructor").val("");
    $("#input_apellido_m_instructor").val("");
    $("#select_sexo_instructor").val("O");
    $("#input_correo_instructor").val("");
    $("#input_fecha_inicio_instructor").val("");
    $("#input_fecha_fin_instructor").val("");
    $("#boton_insert_update_instructor").attr("onclick","mostrar_modal_insertar_instructor()");
}

//BORRAR INSTRUCTOR
function borrar_instructor(){
    let id_instructor= $("#input_id_instructor_borrar").val();
    $.ajax({
        type: "POST",
        url: path+"delete_instructor.php",  
        data: {"id_instructor": id_instructor} ,                         
        success: function(res){
            select_instructores();
            $("#modal-instructor").modal("hide");   
            if(res==="1"){
                mostrar_alerta(1);
            }else{
                mostrar_alerta(3)
            }
        }
    });
}

//IMPRIMIR PDF DEPARTAMENTO
function generar_pdf(id_instructor){
    $.ajax({
        type: "POST",
        data: {"id_instructor": id_instructor},
        url: path+"select_instructor_id.php",                           
        success: function(res){   
            let instructor = JSON.parse(res)[0];           
            let pdf = new jsPDF();
            let columns = [["Nombre","Correo"]]; 
            let data = [[instructor.nombre+" "+instructor.apellido_p+" "+instructor.apellido_m, instructor.correo]];
            pdf.setProperties({
                title: "Tabla Instructor "+instructor.nombre
            });
            let texto = "Instructor "+instructor.nombre;
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


//SELECT DE INSTRUCTOR POR ID
function select_instructor_id(id_instructor){
    $.ajax({
        type: "POST",
        data: {"id_instructor": id_instructor},
        url: path+"select_instructor_id.php",                           
        success: function(res){    
            let instructor = JSON.parse(res)[0];
            $("#input_id_instructor").val(instructor.id_instructor);                
            $("#input_nombre_instructor").val(instructor.nombre);
            $("#input_apellido_p_instructor").val(instructor.apellido_p);
            $("#input_apellido_m_instructor").val(instructor.apellido_m);
            $("#select_sexo_instructor").val(instructor.sexo);
            $("#input_correo_instructor").val(instructor.correo);
            $("#boton_insert_update_instructor").attr("onclick","update_instructor()");
        }
    });
}