//CREACION DE LA TABLA DE COORDINADORES
function mostrar_coordinadores_tabla() {
    //EN CASO DE QUE NO TENGA UN PROGRAMA PARA ASIGNAR
    if ($("#input_id_programa_asignar").val() === "") {
        $('#tabla_coordinadores').DataTable({
            pageLength: 20,
            caseInsen: false,
            columns: [
                { data: "clave", title: 'Clave' },
                { data: "nombre", title: 'Nombre' },
                { data: "sexo", title: 'Sexo' },
                { data: "botoneditar", title: 'Editar' },
                { data: "botonborrar", title: 'Borrar' },
                { data: "botonimprimir", title: 'Imprimir' }
            ],
            "columnDefs": [
                { "orderable": false, "targets": [3, 4, 5] },
            ],
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: "excelHtml5",
                    text: "Exportar a Excel",
                    exportOptions: {
                        columns: [0, 1, 2]
                    },
                    filename: "Coordinadores",
                    title: "Coordinadores"
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
    } else {
        //EN CASO DE QUE SI TENGA UN PROGRAMA PARA ASIGNAR SE LE AGREGA EL BOTON DE ASIGNAR
        $('#tabla_coordinadores').DataTable({
            pageLength: 20,
            caseInsen: false,
            columns: [
                { data: "clave", title: 'Clave' },
                { data: "nombre", title: 'Nombre' },
                { data: "sexo", title: 'Sexo' },
                { data: "botoneditar", title: 'Editar' },
                { data: "botonborrar", title: 'Borrar' },
                { data: "botonimprimir", title: 'Imprimir' },
                { data: "botonasignar", title: 'Asignar' }
            ],
            "columnDefs": [
                { "orderable": false, "targets": [3, 4, 5, 6] },
            ],
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: "excelHtml5",
                    text: "Exportar a Excel",
                    exportOptions: {
                        columns: [0, 1, 2]
                    },
                    filename: "Coordinadores",
                    title: "Coordinadores"
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
    }
}

mostrar_coordinadores_tabla();


//SELECT DE COORDINADORES
function select_coordinadores() {
    let id_departamento = $("#input_id_departamento").val();
    $.ajax({
        type: "POST",
        url: path + "select_coordinadores_departamento_id.php",
        data: { "id_departamento": id_departamento },
        success: function (res) {
            let coordinadores = JSON.parse(res);
            agregar_coordinadores_tabla(coordinadores);
        }
    });
}
select_coordinadores();

//AGREGA PROGRAMAS A DATATABLE
function agregar_coordinadores_tabla(coordinadores) {
    let tabla = $("#tabla_coordinadores").DataTable();
    tabla.rows().remove().draw();
    for (let coordinador of coordinadores) {
        if ($("#input_id_programa_asignar").val() === "") {
            tabla.row.add({ "clave": coordinador.clave, "nombre": coordinador.nombre + " " + coordinador.apellido_p + " " + coordinador.apellido_m, "sexo": coordinador.sexo, "botoneditar": "<button id='botoneditarcoordinador" + coordinador.id_coordinador + "' class='btn btn-primary'>Editar</button>", "botonborrar": "<button id='botonborrarcoordinador" + coordinador.id_coordinador + "' class='btn btn-danger'>Borrar</button>", "botonimprimir": "<button id='botonimprimircoordinador" + coordinador.id_coordinador + "' class='btn btn-dark'>Imprimir</button>" }).draw();
        } else {
            if (coordinador.id_programa !== $("#input_id_programa_asignar").val()) {
                tabla.row.add({ "clave": coordinador.clave, "nombre": coordinador.nombre + " " + coordinador.apellido_p + " " + coordinador.apellido_m, "sexo": coordinador.sexo, "botoneditar": "<button id='botoneditarcoordinador" + coordinador.id_coordinador + "' class='btn btn-primary'>Editar</button>", "botonborrar": "<button id='botonborrarcoordinador" + coordinador.id_coordinador + "' class='btn btn-danger'>Borrar</button>", "botonimprimir": "<button id='botonimprimircoordinador" + coordinador.id_coordinador + "' class='btn btn-dark'>Imprimir</button>", "botonasignar": "<button id='botonasignarcoordinador" + coordinador.id_coordinador + "' class='btn btn-secondary'>Asignar</button>" }).draw();
            } else {
                tabla.row.add({ "clave": coordinador.clave, "nombre": coordinador.nombre + " " + coordinador.apellido_p + " " + coordinador.apellido_m, "sexo": coordinador.sexo, "botoneditar": "<button id='botoneditarcoordinador" + coordinador.id_coordinador + "' class='btn btn-primary'>Editar</button>", "botonborrar": "<button id='botonborrarcoordinador" + coordinador.id_coordinador + "' class='btn btn-danger'>Borrar</button>", "botonimprimir": "<button id='botonimprimircoordinador" + coordinador.id_coordinador + "' class='btn btn-dark'>Imprimir</button>", "botonasignar": "<button id='botonasignarcoordinador" + coordinador.id_coordinador + "' class='btn btn-secondary' disabled>Asignar</button>" }).draw();
            }
            $("#botonasignarcoordinador" + coordinador.id_coordinador).on("click", function () { mostrar_modal_asignar_coordinador(coordinador.id_coordinador, coordinador.clave, coordinador.nombre + " " + coordinador.apellido_p + " " + coordinador.apellido_m, coordinador.sexo) });
        }
        $("#botoneditarcoordinador" + coordinador.id_coordinador).on("click", function () { select_coordinador_id(coordinador.id_coordinador) });
        $("#botonborrarcoordinador" + coordinador.id_coordinador).on("click", function () { mostrar_modal_borrar_coordinador(coordinador.id_coordinador, coordinador.clave, coordinador.nombre + " " + coordinador.apellido_p + " " + coordinador.apellido_m, coordinador.sexo) });
        $("#botonimprimircoordinador" + coordinador.id_coordinador).on("click", function () { generar_pdf(coordinador.id_coordinador) });
    }
}

//INSERT DE COORDINADOR
function insert_coordinador() {
    let clave = $("#input_clave_coordinador").val();
    let nombre = $("#input_nombre_coordinador").val();
    let apellido_p = $("#input_apellido_p_coordinador").val();
    let apellido_m = $("#input_apellido_m_coordinador").val();
    let sexo = $("#select_sexo_coordinador").val();
    let id_departamento = $("#input_id_departamento").val();
    if (id_departamento.length !== 0 && clave.length !== 0 && nombre.length !== 0 && apellido_p.length !== 0 && apellido_m.length !== 0 && sexo !== null) {
        $.ajax({
            type: "POST",
            url: path + "insert_coordinador.php",
            data: { "id_departamento": id_departamento, "clave": clave, "nombre": nombre, "apellido_p": apellido_p, "apellido_m": apellido_m, "sexo": sexo },
            success: function (res) {
                console.log(res);
                select_coordinadores();
                borrar_datos_input_coordinador();
                if (res === "1") {
                    mostrar_alerta(1);
                } else {
                    mostrar_alerta(3);
                }
            }
        });
    } else {
        mostrar_alerta(2);
    }
}

//BORRAR DATOS DE LOS INPUT COORDINADOR
function borrar_datos_input_coordinador() {
    $("#input_clave_coordinador").val("");
    $("#input_nombre_coordinador").val("");
    $("#input_apellido_p_coordinador").val("");
    $("#input_apellido_m_coordinador").val("");
    $("#select_sexo_coordinador").val("O");
    $("#input_contacto_coordinador").val("");
    $("#boton_insert_update_coordinador").attr("onclick", "insert_responsable()");
}

//SELECT DE COORDINADOR POR ID
function select_coordinador_id(id_coordinador) {
    $.ajax({
        type: "POST",
        data: { "id_coordinador": id_coordinador },
        url: path + "select_coordinador_id.php",
        success: function (res) {
            let coordinador = JSON.parse(res)[0];
            $("#input_id_coordinador").val(id_coordinador);
            $("#input_clave_coordinador").val(coordinador.clave);
            $("#input_nombre_coordinador").val(coordinador.nombre);
            $("#input_apellido_p_coordinador").val(coordinador.apellido_p);
            $("#input_apellido_m_coordinador").val(coordinador.apellido_m);
            $("#select_sexo_coordinador").val(coordinador.sexo);
            $("#boton_insert_update_coordinador").attr("onclick", "update_coordinador()");
        }
    });
}

//IMPRIMIR PDF PROGRAMA
function generar_pdf(id_coordinador) {
    $.ajax({
        type: "POST",
        data: { "id_coordinador": id_coordinador },
        url: path + "select_coordinador_id.php",
        success: function (res) {
            let coordinadores = JSON.parse(res);
            let programas = [];
            let data = [];
            coordinadores.forEach(coordinador => {
                programas.push(coordinador.nombre_programa);
            });
            data.push([coordinadores[0].clave, coordinadores[0].nombre + " " + coordinadores[0].apellido_p + " " + coordinadores[0].apellido_m, coordinadores[0].sexo, programas]);
            let pdf = new jsPDF();
            let columns = [["Clave", "Nombre", "Sexo", "Programas"]];
            pdf.setProperties({
                title: "Tabla Coordinador " + coordinadores[0].nombre
            });
            let texto = "Coordinador " + coordinadores[0].nombre;
            let x = (pdf.internal.pageSize.width / 2) - (pdf.getTextWidth(texto) / 2)
            pdf.text(texto, x, 15);
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

//UPDATE DE COORDINADOR
function update_coordinador() {
    let id_coordinador = $("#input_id_coordinador").val();
    let clave = $("#input_clave_coordinador").val();
    let nombre = $("#input_nombre_coordinador").val();
    let apellido_p = $("#input_apellido_p_coordinador").val();
    let apellido_m = $("#input_apellido_m_coordinador").val();
    let sexo = $("#select_sexo_coordinador").val();
    if (id_coordinador.length !== 0 && clave.length !== 0 && nombre.length !== 0 && apellido_p.length !== 0 && apellido_m.length !== 0 && sexo !== null) {
        $.ajax({
            type: "POST",
            url: path + "update_coordinador.php",
            data: { "id_coordinador": id_coordinador, "clave": clave, "nombre": nombre, "apellido_p": apellido_p, "apellido_m": apellido_m, "sexo": sexo },
            success: function (res) {
                borrar_datos_input_coordinador();
                select_coordinadores();
                if (res === "1") {
                    mostrar_alerta(1);
                } else {
                    mostrar_alerta(3);
                }
            }
        });
    } else {
        mostrar_alerta(3);
    }
}

//MOSTRAR MODAL BORRAR COORDINADOR
function mostrar_modal_borrar_coordinador(id_coordinador, clave, nombre, sexo) {
    $("#modal_borrar_coordinador").modal("show");
    $("#p_clave_coordinador").text("Clave: " + clave);
    $("#p_nombre_coordinador").text("Nombre: " + nombre);
    $("#p_sexo_coordinador").text("Sexo: " + sexo);
    $("#input_id_coordinador_borrar").val(id_coordinador);
}

//BORRAR RESPONSABLE
function borrar_coordinador() {
    let id_coordinador = $("#input_id_coordinador_borrar").val();
    let id_departamento = $("#input_id_departamento").val();
    $.ajax({
        type: "POST",
        url: path + "delete_coordinador.php",
        data: { "id_coordinador": id_coordinador, "id_departamento": id_departamento },
        success: function (res) {
            select_coordinadores();
            $("#modal_borrar_coordinador").modal("hide");
            if (res === "1") {
                mostrar_alerta(1);
            } else {
                mostrar_alerta(3)
            }
        }
    });
}

//MOSTRAR MODAL ASIGNAR
function mostrar_modal_asignar_coordinador(id_coordinador, clave, nombre, sexo) {
    $("#modal_asignar_coordinador").modal("show");
    $("#p_clave_coordinador_asignar").text("Clave: " + clave);
    $("#p_nombre_coordinador_asignar").text("Nombre: " + nombre);
    $("#p_sexo_coordinador_asignar").text("Sexo: " + sexo);
    $("#input_asignar_id_coordinador").val(id_coordinador);
}

//ASIGNAR RESPONSABLE A PROGRAMA
function asignar_responsable() {
    let id_coordinador = $("#input_asignar_id_coordinador").val();
    let id_programa = $("#input_id_programa_asignar").val();
    let id_departamento = $("#input_id_departamento").val();
    let fecha_inicio = $("#input_fecha_inicio_coordinador_programa").val();
    
    if (id_coordinador.length !== 0 && id_programa.length !== 0 && id_departamento.length !== 0 && fecha_inicio.length !== 0) {
        $.ajax({
            type: "POST",
            url: path + "insert_coordinador_programa.php",
            data: { "id_coordinador": id_coordinador, "id_programa": id_programa, "fecha_inicio": fecha_inicio, "id_departamento": id_departamento },
            success: function (res) {
                $("#modal_asignar_coordinador").modal("hide");
                if (res === "1") {
                    mostrar_alerta(1);
                    setTimeout(function () { window.location.href = "../../../views/modules/responsable/responsable.php" }, 1500)
                } else {
                    mostrar_alerta(3)
                }
            }
        });
    } else {
        mostrar_alerta(2);
    }
}
