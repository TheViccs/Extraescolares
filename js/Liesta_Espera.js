$('#tabla_listaEspera').DataTable({
    pageLength: 20,
    caseInsen: false,
    columns: [
        {data: "nombre", title: 'Numero de Control'},
        {data: "correo", title: 'Correo'},
        {data: "carrera", title: 'Carrera'},
        {data: "botonAgregar", title: 'Agregar'}
        
    ],
    "columnDefs": [
        { "orderable": false, "targets": [3,4] },
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

