//CREACION DE DATATABLE DE GRUPOS
$('#tabla_grupos').DataTable({
    pageLength: 20,
    caseInsen: false,
    columns: [
        { data: "nombre_actividad", title: 'Nombre de Actividad' },
        { data: "nombre_grupo", title: 'Nombre de Grupo' },
        { data: "total_inscripciones", title: 'Alumnos Inscritos' },
        { data: "botonimprimir", title: 'Imprimir Lista' },
        { data: "botoncalificar", title: 'Calificar Alumnos' }
    ],
    "columnDefs": [
        { "orderable": false, "targets": [3,4] },
    ],
    dom:'Bfrtip' ,
    buttons: [
        { 
            extend: "excelHtml5",
            text: "Exportar a Excel",
            exportOptions: {
                columns: [0,1,2]
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

//SELECT DE GRUPOS
function select_grupos(){
    let id_instructor = $("#id_instructor").val();
    $.ajax({
        type: "POST",
        url: path+"select_grupos_instructor_id.php",  
        data: {"id_instructor": id_instructor},                    
        success: function(res){    
            let grupos = JSON.parse(res);          
            agregar_grupos_tabla(grupos);
        }
    });
}
select_grupos();

//AGREGA LOS GRUPOS AL DATATABLE
function agregar_grupos_tabla(grupos){
    let tabla = $("#tabla_grupos").DataTable();
    tabla.rows().remove().draw();
    for(let grupo of grupos){
        tabla.row.add({"nombre_actividad":grupo.nombre_actividad, "nombre_grupo":grupo.nombre,"total_inscripciones":grupo.total_inscripciones, "botonimprimir":"<button id='botonimprimirgrupo"+ grupo.id_grupo+"'class='btn btn-primary'> Imprimir Lista </button>", "botoncalificar": "<button id='botoncalificar"+grupo.id_grupo+"'class='btn btn-danger' >Ver Alumnos</button>"}).draw();
        $("#botoncalificar"+grupo.id_grupo).on( "click", function(){calificar_grupo(grupo.id_grupo)});
        $("#botonimprimirgrupo"+grupo.id_grupo).on( "click", function(){imprimir_lista(grupo.id_grupo)});
    }
}

function imprimir_lista(id_grupo){
    $.ajax({
        type: "POST",
        url: path+"select_alumnos_grupo_id.php",  
        data: {"id_grupo": id_grupo},                    
        success: function(res){    
            let alumnos = JSON.parse(res);          
            console.log(alumnos)
            let pdf = new jsPDF('l');
            let columns = [["Nombre","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20"]]; 
            let data = []
            alumnos.forEach(alumno => {
                data.push([alumno.nombre+" "+ alumno.apellido_p+" "+alumno.apellido_m,"","","","","","","","","","","","","","","","","","","",""])
            })
            pdf.setProperties({
                title: "Lista"
            });
            let texto = "Lista"
            let x = (pdf.internal.pageSize.width/2) - (pdf.getTextWidth(texto)/2)
            pdf.text(texto,x,15);
            pdf.autoTable({
                startY: 25,
                head: columns,
                body: data,
                headStyles :{fillColor : [50, 50, 50], minCellWidth: 10},
                tableLineColor: [50, 50, 50],
                tableLineWidth: 0.2,
                theme: "grid",
            })
            let blob = pdf.output("blob");
            window.open(URL.createObjectURL(blob));      
        }
    });
}

//NOS MANDA A LA VENTANA PARA VER LOS ALUMNOS CON EL ID DE UN GRUPO
function calificar_grupo(id_grupo){
    window.location.href = "../../../views/modules/instructores/alumnos.php?grupo="+id_grupo;
}