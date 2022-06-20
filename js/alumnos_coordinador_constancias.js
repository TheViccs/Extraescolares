//TABLA DE ACTIVIDADES
$('#tabla_alumnos').DataTable({
    pageLength: 20,
    caseInsen: false,
    columns: [
        { data: "nombre", title: 'Nombre' },
        { data: "carrera", title: 'Carrera' },
        { data: "semestre", title: 'Semestre' },
        { data: "botonimprimirconstancia", title: 'Crear Constancia' },
    ],
    "columnDefs": [
        { "orderable": false, "targets": [3] },
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

function select_alumnos() {
    let id_grupo = $("#id_grupo").val();
    $.ajax({
        type: "POST",
        data: { "id_grupo": id_grupo },
        url: path + "select_alumnos_acreditados_grupo_id.php",
        success: function (res) {
            let alumnos = JSON.parse(res);
            agregar_alumnos_tabla(alumnos);
        }
    });
}
select_alumnos();


function agregar_alumnos_tabla(alumnos) {
    let tabla = $("#tabla_alumnos").DataTable();
    tabla.rows().remove().draw();
    for (let alumno of alumnos) {
        tabla.row.add({ "nombre": alumno.nombre + " " + alumno.apellido_p + " " + alumno.apellido_m, "carrera": alumno.carrera, "semestre": alumno.semestre, "botonimprimirconstancia": "<button id='botonimprimirconstancia" + alumno.id_alumno + "' class= 'btn btn-dark'>Imprimir Constancia</button>" }).draw();
        $("#botonimprimirconstancia" + alumno.id_alumno).on("click", function () { imprimir_constancias(alumno) });
    }
}

function imprimir_constancias(alumno) {
    let pdf = new jsPDF();
    //TITUTLO DEL PDF
    pdf.setProperties({
        title: "Constancia"
    });
    //CONTENIDO
    //NOMBRE DE LA INSTITUCION
    let nombre_institucion = "Tecnológico Nacional de México Campus Colima";
    let x_nombre_institucion = (pdf.internal.pageSize.width / 2) - (pdf.getTextWidth(nombre_institucion) / 2);
    pdf.text(nombre_institucion, x_nombre_institucion, 15)
    //TITULO DEL PDF
    let titulo = "Constancia de Cumplimiento de Actividad Complementaria";
    let x_titulo = (pdf.internal.pageSize.width / 2) - (pdf.getTextWidth(titulo) / 2);
    pdf.text(titulo, x_titulo, 30);
    //PRIMER PARRAFO
    pdf.setFontSize(14);
    let primer_parrafo = "C._________________________\rJefe(a) del Departamento de Servicios Extraescolares o su equivalente en los \rInstitutos Tecnológicos Descentralizados\rPRESENTE";
    pdf.text(primer_parrafo, 20, 60);
    //SEGUNDO PARRAFO
    pdf.setFontSize(14);
    let segundo_parrafo = "El que se suscribe "+alumno.nombre_responsable+", por este medio se permite\rhacer de su conocimiento que el estudiante "
                            +alumno.nombre+" "+alumno.apellido_p+" "+alumno.apellido_m+"\rcon número de control "
                            +alumno.correo.substring(0,alumno.correo.indexOf("@"))+" de la carrera "+alumno.carrera+"\r"
                            +"ha cumplido su actividad complementaria con el nivel de desempeño "+alumno.desempeño+"\r"
                            +"y un valor numérico de "+alumno.calificacion_numerica+", durante el periodo escolar "+alumno.nombre_periodo+"\r"
                            +"con un valor curricular de "+alumno.creditos_actividad+" crédito(s).";
    pdf.text(segundo_parrafo, 20, 95, {align:"justify", angle: 90});
    //ATENTAMENTE
    let at = "ATENTAMENTE";
    let x_at = (pdf.internal.pageSize.width / 2) - (pdf.getTextWidth(at) / 2);
    pdf.text(at, x_at, 165);
    //FIRMA INSTRUCTOR
    let instructor = "________________________\rNombre y firma del (de la)\rprofesor(a) responsable";
    pdf.text(instructor, 20, 235);

    //FIRMA DEPARTAMENTO
    let departamento = "________________________\rVo. Bo. del Jefe(a) del\r"+alumno.nombre_departamento;
    pdf.text(departamento, 100, 235);


    let blob = pdf.output("blob");
    window.open(URL.createObjectURL(blob));
}