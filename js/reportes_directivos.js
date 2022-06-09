$('#tabla_reporte').DataTable({
    pageLength: 20,
    caseInsen: false,
    columns: [
        { data: "nombre", title: 'Nombre' },
        { data: "total", title: 'Total Inscripciones' },
    ],
    "columnDefs": [
        
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

function select_total_inscripciones(){
    $.ajax({
        type: "GET",
        url: path+"select_total_inscripciones.php",                           
        success: function(res){    
            let total = JSON.parse(res)[0]; 
            $("#total_inscripciones").text(total.total_inscripciones);            
            console.log(total.total_inscripciones);
        }
    });
}
select_total_inscripciones();

function select_total_inscripciones_programa(){
    $.ajax({
        type: "POST",
        url: path+"select_total_inscripciones_programa.php",                     
        success: function(res){    
            let programas = JSON.parse(res);          
            agregar_datos_tabla(programas);
        }
    });
}

function agregar_datos_tabla(datos){
    let tabla = $("#tabla_reporte").DataTable();
    tabla.rows().remove().draw();
    for(let dato of datos){
        tabla.row.add({"nombre":dato.nombre,"total":dato.total}).draw();
    }
}

function select_total_inscripciones_actividad(){
    $.ajax({
        type: "POST",
        url: path+"select_total_inscripciones_actividad.php",                     
        success: function(res){    
            let actividades = JSON.parse(res);          
            agregar_datos_tabla(actividades);
        }
    });
}

function select_total_inscripciones_carrera(){
    $.ajax({
        type: "POST",
        url: path+"select_total_inscripciones_carrera.php",                     
        success: function(res){    
            let carreras = JSON.parse(res);          
            agregar_datos_tabla(carreras);
        }
    });
}

function select_total_inscripciones_semestre(){
    $.ajax({
        type: "POST",
        url: path+"select_total_inscripciones_semestre.php",                     
        success: function(res){    
            let semestres = JSON.parse(res);          
            agregar_datos_tabla(semestres);
        }
    });
}
select_total_inscripciones_programa();
