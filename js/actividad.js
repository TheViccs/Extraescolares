//TABLA DE ACTIVIDADES
$('#tabla_avtividad').DataTable({
    pageLength: 20,
    caseInsen: false,
    columns: [
        {data: "idActividad", title: 'IdActividad'},
        {data: "idPrograma", title: 'IdPrograma'},
        {data: "nombre", title: 'Nombre'},
        {data: "descripcion", title: 'Descripcion'},
        {data: "competencia", title: 'Competencia'},
        {data: "creditos", title: 'Creditos'},
        {data: "beneficios", title: 'Beneficios'},
        {data: "capMax", title: 'CapMax'},
        {data: "capMin", title: 'CapMin'},
        {data: "inicio", title: 'Inicio'},
        {data: "fin", title: 'Fin'},
        {data: "padre", title: 'Padre'},
        {data: "botoneditar", title: 'Editar'},
        {data: "botonborrar", title: 'Borrar'},
        {data: "botonimprimir", title: 'Imprimir'}
    ],
    "columnDefs": [
        { "orderable": false, "targets": [15,6,7] },
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