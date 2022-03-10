$('#tabla-responsables').DataTable({
    pageLength: 20,
    caseInsen: false,
    columns: [
        {data: "clave", title: 'Clave'},
        {data: "nombre", title: 'Nombre'},
        {data: "correo", title: 'Correo'},
        {data: "botoneditar", title: 'Editar'},
        {data: "botonborrar", title: 'Borrar'},
        {data: "botonimprimir", title: 'Impirmir'}
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

function select_responsables_1(){
    $.ajax({
        type: "GET",
        url: path+"select_responsables.php",                           
        success: function(res){    
            let responsables = JSON.parse(res);             
            agregar_responsables_tabla(responsables);
        }
    });
}
select_responsables_1();


//AGREGA DEPARTAMENTOS A DATATABLE
function agregar_responsables_tabla(responsables){
    let tabla = $("#tabla-responsables").DataTable();
    tabla.rows().remove().draw();
    for(let responsable of responsables){
        tabla.row.add({"clave":responsable.clave, "nombre":responsable.nombre+" "+responsable.apellido_p+" "+responsable.apellido_m, "correo":responsable.correo,"botoneditar":"<button id='botoneditarresponsable"+ responsable.id_responsable+"'class='btn btn-primary'> Editar </button>", "botonborrar": "<button id='botonborrarresponsable"+responsable.id_responsable+"'class='btn btn-danger' >Borrar</button>", "botonimprimir":"<button id='botonimprimir"+responsable.id_responsable+"' class= 'btn btn-dark'>Imprimir</button>"}).draw();
     $("#botoneditarresponsable"+responsable.id_responsable).on( "click", function(){select_responsables_id(responsable.id_responsable)});
       $("#botonborrarresponsable"+responsable.id_responsable).on( "click", function(){mostrar_modal_borrar_responsable(responsable.id_responsable, responsable.clave, responsable.nombre, responsable.correo)});
       $("#botonimprimir"+responsable.id_responsable).on( "click", function(){generar_pdf(responsable.id_responsable)});
    }
}

//MOSTRAR MODAL BORRAR RESPONSABLE
function mostrar_modal_borrar_responsable(id_responsable, clave, nombre, correo){
    $("#modal-responsable").modal("show");
    $("#p_clave_resposable").text("Clave: "+clave);
    $("#p_nombre_resposable").text("Nombre: "+nombre);
    $("#p_correo_resposable").text("Correo: "+correo);
    $("#input_id_responsable_borrar").val(id_responsable);
}


//INSERTAR RESPONSABLE
function insert_responsable(){
    let clave = $("#input_clave_responsable").val();
    let nombre = $("#input_nombre_responsable").val();
    let apellido_p = $("#input_apellido_p_responsable").val();
    let apellido_m = $("#input_apellido_m_responsable").val();
    let correo = $("#input_correo_responsable").val();

    if(clave.length !== 0 && nombre.length !== 0 && apellido_p.length !== 0 && apellido_m.length !== 0 && correo.length !== 0){
        $.ajax({
            type: "POST",
            url: path+"insert_responsable.php",
            data: {"clave":clave,"nombre":nombre,"apellido_p":apellido_p,"apellido_m":apellido_m,"correo":correo + "@colima.tecnm.mx"},
            success: function(res){
                borrar_datos_input_responsable();
                select_responsables_1();
                if (res == 1) {
                    if (id_responsable != undefined) {
                        
                    }
                    
                }
            }
        });
    }

}

//LIMPIAR CAJAS DE TEXTO
function borrar_datos_input_responsable(){
    $("#input_clave_responsable").val("");
    $("#input_nombre_responsable").val("");
    $("#input_apellido_p_responsable").val("");
    $("#input_apellido_m_responsable").val("");
    $("#input_correo_responsable").val("");
}

//BORRAR RESPONSABLE
function borrar_responsable(){
    let id_responsable= $("#input_id_responsable_borrar").val();
    $.ajax({
        type: "POST",
        url: path+"delete_responsable.php",  
        data: {"id_responsable": id_responsable} ,                         
        success: function(res){
            select_responsables_1();
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
            let data = [[responsable.clave_responsable, responsable.nombre, responsable.correo]];
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
function select_responsables_id(id_responsable){
    $.ajax({
        type: "POST",
        data: {"id_responsable": id_responsable},
        url: path+"select_responsable_id.php",                           
        success: function(res){    
            let responsable = JSON.parse(res)[0];
            console.log(res);
            //$("#input_id_responsable").val(responsable.id_responsable);                
            $("#input_clave_responsable").val(responsable.clave_responsable);
            $("#input_nombre_responsable").val(responsable.nombre);
            $("#input_apellido_p_responsable").val(responsable.apellido_p);
            $("#input_apellido_m_responsable").val(responsable.apellido_m);
            $("#input_correo_responsable").val(responsable.correo);
        }
    });
}

