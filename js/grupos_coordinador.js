//FUNCIONES PARA PROGRAMAS
//CREACION DE DATATABLE PARA GRUPOS
$('#tabla_grupos').DataTable({
    pageLength: 20,
    caseInsen: false,
    columns: [
        {data: "nombre", title: 'Nombre'},
        {data: "nombre_caracteristica", title: 'Característica'},
        {data: "capacidad_min", title: 'Capacidad Mínima'},
        {data: "capacidad_max", title: 'Capacidad Máxima'},
        {data: "total_inscripciones", title: 'Inscritos'},
        {data: "nombre_instructor", title: 'Instructor'},
        {data: "nombre_lugar", title: 'Lugar'},
        {data: "botoneditar", title: 'Editar'},
        {data: "botonborrar", title: 'Borrar'},
        {data: "botonimprimir", title: 'Imprimir'},
        {data: "botonhorarios", title: 'Gestionar Horarios'}
    ],
    "columnDefs": [
        { "orderable": false, "targets": [7,8,9,10] },
    ],
    dom:'Bfrtip' ,
    buttons: [
        { 
            extend: "excelHtml5",
            text: "Exportar a Excel",
            exportOptions: {
                columns: [0,1,2,3,4,5,6]
            },
            filename: "Grupos",
            title: "Grupos"
        }
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
function select_grupos(){
    let id_actividad = $("#input_id_actividad").val();
    $.ajax({
        type: "POST",
        data: {"id_actividad":id_actividad},
        url: path+"select_grupo_actividad_id.php",                           
        success: function(res){    
            let grupos = JSON.parse(res);             
            agregar_grupos_tabla(grupos);
        }
    });
}
select_grupos();

//AGREGA GRUPOS A DATATABLE
function agregar_grupos_tabla(grupos){
    let tabla = $("#tabla_grupos").DataTable();
    tabla.rows().remove().draw();
    for(let grupo of grupos){
        tabla.row.add({"nombre":grupo.nombre,"nombre_caracteristica":grupo.nombre_caracteristica,"capacidad_min":grupo.capacidad_min,"capacidad_max":grupo.capacidad_max,"total_inscripciones":grupo.total_inscripciones,"nombre_instructor":grupo.nombre_instructor+" "+grupo.apellido_p+" "+grupo.apellido_m,"nombre_lugar":grupo.nombre_lugar,"botoneditar":"<button id='botoneditargrupo"+grupo.id_grupo+"' class='btn btn-primary'>Editar</button>","botonborrar":"<button id='botonborrargrupo"+grupo.id_grupo+"' class='btn btn-danger'>Borrar</button>","botonhorarios":"<button id='botonagregarhorario"+grupo.id_grupo+"' class='btn btn-warning'>Gestionar Horarios</button>","botonimprimir":"<button id='botonimprimirgrupo"+grupo.id_grupo+"' class='btn btn-dark'>Imprimir</button>"}).draw();
        $("#botoneditargrupo"+grupo.id_grupo).on( "click", function(){select_grupo_id(grupo.id_grupo)});
        $("#botonborrargrupo"+grupo.id_grupo).on( "click", function(){mostrar_modal_borrar_departamento(grupo.id_grupo,grupo.nombre, grupo.nombre_caracteristica, grupo.total_inscripciones,grupo.nombre_instructor+" "+grupo.apellido_p+" "+grupo.apellido_m,grupo.nombre_lugar)});
        $("#botonimprimirgrupo"+grupo.id_grupo).on( "click", function(){generar_pdf(grupo.id_grupo)});
        $("#botonagregarhorario"+grupo.id_grupo).on( "click", function(){gestionar_horarios(grupo.id_grupo)});
    }
}

//SELECT DE INSTRUCTORES
function select_instructores(){
    let id_departamento = $("#input_id_departamento").val();
    $.ajax({
        type: "POST",
        data: {"id_departamento":id_departamento},
        url: path+"select_instructores_departamento_id.php",                           
        success: function(res){                    
            let instructores = JSON.parse(res);
            agregar_instructores_select(instructores);
        }
    });
}
select_instructores();

//AGREGA INSTRUCTORES AL SELECT
function agregar_instructores_select(instructores){
    $("#select_instructores").html("");
    for(let instructor of instructores){
        $("#select_instructores").append("<option id="+instructor.id_instructor+" value='"+instructor.nombre+" "+instructor.apellido_p+" "+instructor.apellido_m+"'></option>");
    }
}

//SELECT DE CARACTERISTICAS
function select_caracteristicas(){
    $.ajax({
        type: "GET",
        url: path+"select_caracteristicas.php",                           
        success: function(res){                    
            let caracteristicas = JSON.parse(res);
            agregar_caracteristicas_select(caracteristicas);
        }
    });
}
select_caracteristicas();

//AGREGA CARACTERISTICAS AL SELECT
function agregar_caracteristicas_select(caracteristicas){
    $("#select_caracteristicas").html("");
    for(let caracteristica of caracteristicas){
        $("#select_caracteristicas").append("<option id="+caracteristica.id_caracteristica+" value='"+caracteristica.nombre+"'></option>");
    }
}

//SELECT DE LUGARES
function select_lugares(){
    $.ajax({
        type: "GET",
        url: path+"select_lugares.php",                           
        success: function(res){                    
            let lugares = JSON.parse(res);
            agregar_lugares_select(lugares);
        }
    });
}
select_lugares();

//AGREGA LUGARES AL SELECT
function agregar_lugares_select(lugares){
    $("#select_lugares").html("");
    for(let lugar of lugares){
        $("#select_lugares").append("<option id="+lugar.id_lugar+" value='"+lugar.nombre+"'></option>");
    }
}

//INSERT CARACTERISTICA
function insert_caracteristica(){
    let caracteristica = $("#input_caracteristica_grupo_modal").val();
    if(caracteristica.length !== 0){
        $.ajax({
            type: "POST",
            url: path+"insert_caracteristica.php",  
            data: {"caracteristica": caracteristica} ,                         
            success: function(res){
                console.log(res);
                if(res==="1"){
                    select_caracteristicas();  
                    $("#input_caracteristica_grupo").val(caracteristica);
                    borrar_datos_input_caracteristica(); 
                    $("#modal_caracteristica").modal("hide");
                    mostrar_alerta(1);
                }else{
                    $("#modal_caracteristica").modal("hide");
                    mostrar_alerta(3);
                }
                                
            }
        });
    }else{
        $("#modal_responsable").modal("hide");
        mostrar_alerta(2);
    }
}

//BORRAR INPUTS MODAL CARACTERISTICA
function borrar_datos_input_caracteristica(){
    $("#input_caracteristica_grupo_modal").val("");
}

//INSERT LUGAR
function insert_lugar(){
    let lugar = $("#input_lugar_grupo_modal").val();
    let capacidad_max = $("#input_capacidad_max_lugar_grupo_modal").val();
    let observaciones = $("#input_observaciones_lugar_grupo_modal").val();
    if(lugar.length !== 0 && capacidad_max.length !== 0){
        $.ajax({
            type: "POST",
            data:{"lugar":lugar, "capacidad":capacidad_max, "observaciones":observaciones},
            url: path+"insert_lugar.php",                         
            success: function(res){
                if(res==="1"){
                    select_lugares();  
                    $("#input_lugar_grupo").val(lugar);
                    borrar_datos_input_lugar(); 
                    $("#modal_lugar").modal("hide");
                    mostrar_alerta(1);
                }else{
                    $("#modal_lugar").modal("hide");
                    mostrar_alerta(3);
                }
                                
            }
        });
    }else{
        $("#modal_lugar").modal("hide");
        mostrar_alerta(2);
    }
}

//BORRAR INPUTS MODAL LUGAR
function borrar_datos_input_lugar(){
    $("#input_lugar_grupo_modal").val("");
    $("#input_capacidad_max_lugar_grupo_modal").val("");
    $("#input_observaciones_lugar_grupo_modal").val("");
}

//INSERTAR INSTRUCTOR
function insert_instructor(){
    let nombre = $("#input_nombre_instructor_grupo_modal").val();
    let apellido_p = $("#input_apellido_p_instructor_grupo_modal").val();
    let apellido_m = $("#input_apellido_m_instructor_grupo_modal").val();
    let sexo = $("#select_sexo_instructor_grupo_modal").val();
    let correo = $("#input_correo_instructor_grupo_modal").val();
    let fecha_inicio = $("#input_fecha_inicio_instructor_grupo_modal").val();
    let fecha_fin = $("#input_fecha_fin_instructor_grupo_modal").val();
    let id_departamento = $("#input_id_departamento").val();
    if(nombre.length !== 0 && apellido_p.length !== 0 && apellido_m.length !== 0 && correo.length !== 0 && sexo!==null && fecha_inicio.length!==0 && fecha_fin.length!==0 && id_departamento.length !== 0){
        $.ajax({
            type: "POST",
            url: path+"insert_instructor.php",
            data: {"nombre":nombre,"apellido_p":apellido_p,"apellido_m":apellido_m,"sexo":sexo,"correo":correo + "@colima.tecnm.mx", "fecha_inicio": fecha_inicio, "fecha_fin": fecha_fin, "id_departamento": id_departamento},
            success: function(res){
                borrar_datos_input_instructor();
                select_instructores();
                $("#input_instructor_grupo").val(nombre+" "+apellido_p+" "+apellido_m);
                $("#modal_instructor").modal("hide");
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

//BORRA LOS INPUTS DE INSTRUCTOR
function borrar_datos_input_instructor(){
    $("#input_nombre_instructor_grupo_modal").val("");
    $("#input_apellido_p_instructor_grupo_modal").val("");
    $("#input_apellido_m_instructor_grupo_modal").val("");
    $("#select_sexo_instructor_grupo_modal").val("O");
    $("#input_correo_instructor_grupo_modal").val("");
    $("#input_fecha_inicio_instructor_grupo_modal").val("");
    $("#input_fecha_fin_instructor_grupo_modal").val("");
}

//NOS LLEVA A LA VENTANA PARA GESTIONAR HORARIOS CON UN ID DEL GRUPO
function gestionar_horarios(id_grupo){
    window.location.href = "../../../views/modules/coordinador/horarios.php?grupo="+id_grupo;
}

//SELECT DE GRUPO POR ID
function select_grupo_id(id_grupo){
    $.ajax({
        type: "POST",
        data: {"id_grupo": id_grupo},
        url: path+"select_grupo_id.php",                           
        success: function(res){    
            let grupo = JSON.parse(res)[0];
            $("#input_id_grupo").val(grupo.id_grupo);                
            $("#input_nombre_grupo").val(grupo.nombre);
            $("#input_cMin_grupo").val(grupo.capacidad_min);
            $("#input_cMax_grupo").val(grupo.capacidad_max);
            $("#input_instructor_grupo").val($("#select_instructores option[id=" +grupo.id_instructor+"]").attr("value"));
            $("#input_caracteristica_grupo").val($("#select_caracteristicas option[id=" +grupo.id_caracteristica+"]").attr("value"));
            $("#input_lugar_grupo").val($("#select_lugares option[id=" +grupo.id_lugar+"]").attr("value"));
            $("#boton_insert_update_grupo").attr("onclick","update_grupo()");
        }
    });
}

//INSERT DE GRUPO
function insert_grupo(){    
    let id_actividad = $("#input_id_actividad").val();      
    let nombre = $("#input_nombre_grupo").val();
    let capacidad_min = $("#input_cMin_grupo").val();
    let capacidad_max = $("#input_cMax_grupo").val();
    let val_input_instructor = $("#input_instructor_grupo").val(); 
    let id_instructor = $("#select_instructores option[value='"+val_input_instructor+"']").attr("id");
    let val_input_caracteristica = $("#input_caracteristica_grupo").val(); 
    let id_caracteristica = $("#select_caracteristicas option[value='"+val_input_caracteristica+"']").attr("id");
    let val_input_lugar = $("#input_lugar_grupo").val(); 
    let id_lugar = $("#select_lugares option[value='"+val_input_lugar+"']").attr("id");
    $.ajax({
        type: "POST",
        url: path+"insert_grupo.php",  
        data: {"nombre": nombre, "capacidad_min": capacidad_min, "capacidad_max": capacidad_max, "id_instructor": id_instructor, "id_caracteristica":id_caracteristica, "id_lugar":id_lugar, "id_actividad":id_actividad} ,                         
        success: function(res){  
            console.log(res);
            select_grupos();
            if(res==="1"){
                mostrar_alerta(1);
                borrar_datos_input_grupo();
            }else{
                mostrar_alerta(3);
            }           
        }
    });
}

//BORRA DATOS DE INPUTS DE GRUPO
function borrar_datos_input_grupo(){
    $("#input_id_grupo").val("");                
    $("#input_nombre_grupo").val("");
    $("#input_cMin_grupo").val("");
    $("#input_cMax_grupo").val("");
    $("#input_instructor_grupo").val("");
    $("#input_caracteristica_grupo").val("");
    $("#input_lugar_grupo").val("");
    $("#boton_insert_update_grupo").attr("onclick","insert_grupo()");
}

//UPDATE A GRUPO
function update_grupo(){    
    let id_grupo = $("#input_id_grupo").val();      
    let nombre = $("#input_nombre_grupo").val();
    let capacidad_min = $("#input_cMin_grupo").val();
    let capacidad_max = $("#input_cMax_grupo").val();
    let val_input_instructor = $("#input_instructor_grupo").val(); 
    let id_instructor = $("#select_instructores option[value='"+val_input_instructor+"']").attr("id");
    let val_input_caracteristica = $("#input_caracteristica_grupo").val(); 
    let id_caracteristica = $("#select_caracteristicas option[value='"+val_input_caracteristica+"']").attr("id");
    let val_input_lugar = $("#input_lugar_grupo").val(); 
    let id_lugar = $("#select_lugares option[value='"+val_input_lugar+"']").attr("id");
    $.ajax({
        type: "POST",
        url: path+"update_grupo.php",  
        data: {"nombre": nombre, "capacidad_min": capacidad_min, "capacidad_max": capacidad_max, "id_instructor": id_instructor, "id_caracteristica":id_caracteristica, "id_lugar":id_lugar, "id_grupo":id_grupo} ,                         
        success: function(res){  
            console.log(res);
            select_grupos();
            if(res==="1"){
                mostrar_alerta(1);
                borrar_datos_input_grupo();
            }else{
                mostrar_alerta(3);
            }           
        }
    });
}

//MOSTRAR MODAL BORRAR DEPARTAMENTO
function mostrar_modal_borrar_departamento(id_grupo,nombre, caracteristica, total_inscripciones,instructor,lugar){
    $("#p_nombre_grupo").text("Nombre: "+nombre);
    $("#p_caracteristica_grupo").text("Caracteristica: "+caracteristica);
    $("#p_total_inscripciones_grupo").text("Total de Inscritos: "+total_inscripciones);
    $("#p_instructor_grupo").text("Instructor: "+instructor);
    $("#p_lugar_grupo").text("Lugar: "+lugar);
    $("#input_id_grupo_borrar").val(id_grupo);
    $("#modal_borrar_grupo").modal("show");
}

//BORRAR DEPARTAMENTO
function borrar_grupo(){
    let id_grupo = $("#input_id_grupo_borrar").val();
    $.ajax({
        type: "POST",
        url: path+"delete_grupo.php",  
        data: {"id_grupo": id_grupo} ,                         
        success: function(res){
            select_grupos();
            $("#modal_borrar_grupo").modal("hide");   
            if(res==="1"){
                mostrar_alerta(1);
            }else{
                mostrar_alerta(3)
            }
        }
    })
}

//IMPRIME PDF CON DATOS DEL GRUPO
function generar_pdf(id_grupo){
    $.ajax({
        type: "POST",
        data: {"id_grupo": id_grupo},
        url: path+"select_grupo_id.php",                           
        success: function(res){   
            let grupo = JSON.parse(res)[0];           
            let pdf = new jsPDF('l');
            let columns = [["Nombre", "Caracteristica", "Total Inscripciones","Instructor", "Lugar", "Capacidad Mínima", "Capacidad Máxima"]];
            let data = [[grupo.nombre, grupo.nombre_caracteristica, grupo.total_inscripciones, grupo.nombre_instructor+" "+grupo.apellido_p+" "+grupo.apellido_m, grupo.nombre_lugar, grupo.capacidad_min, grupo.capacidad_max]];
            pdf.setProperties({
                title: "Tabla grupo "+grupo.nombre
            });
            let texto = "Grupo "+grupo.nombre;
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