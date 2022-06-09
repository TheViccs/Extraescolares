//FUNCION PARA OCULTAR CONTENIDO AL DAR CLICK EN NOMBRES DE PROGRAMAS Y ACTIVIDADES
function mostrarContenido() {
    if (this.event.currentTarget.nextElementSibling.hasAttribute("hidden")) {
        this.event.currentTarget.nextElementSibling.removeAttribute("hidden");
    } else {
        this.event.currentTarget.nextElementSibling.setAttribute("hidden", true);
    }
}

//CREA PROGRAMAS
function crear_programas(programas) {
    //OBTENEMOS EL COMPONENTE PRINCIPAL
    let main = document.getElementById("contenedor_programas");
    main.innerHTML = "";
    //POR CADA PROGRAMA
    programas.forEach(programa => {
        //CREAMOS UN DIV QUE CONTENDRA CADA PROGRAMA
        let divContenedor = document.createElement("div");
        divContenedor.classList.add("contenedor-programa");
        //CREAMOS UN DIV QUE CONTENDRA EL TITULO
        let divTitulo = document.createElement("div")
        divTitulo.classList.add("contenedor-programa-titulo");
        divTitulo.setAttribute("onclick", "mostrarContenido()");
        divTitulo.classList.add("titulo-programa");
        let h3 = document.createElement("h3");
        h3.textContent = programa.nombre;
        divTitulo.appendChild(h3);
        //CREAMOS OTRO DIV QUE CONTENDRA LAS ACTIVIDADES DE ESE PROGRAMA
        let divContenido = document.createElement("div");
        //IMPORTANTE SE LE AGREGA A ESTE CONTENEDOR EL ID DEL PROGRAMA PARA DESPUES AGREGAR LAS ACTIVIDADES
        divContenido.classList.add("contenedor-actividades");
        divContenido.id = "programa" + programa.id_programa;
        divContenido.setAttribute("hidden", true);
        divContenedor.appendChild(divTitulo);
        divContenedor.appendChild(divContenido);
        main.appendChild(divContenedor);
    });
}

//CREAR ACTIVIDADES
function crear_actividades(actividades) {
    //POR CADA ACTIVIDAD
    actividades.forEach(actividad => {
        //SE SELECCIONA EL CONTENDOR QUE SE CREO EN LA FUNCION DE CREAR PROGRAMAS DONDE SE AGREGARAN LAS ACTIVIDADES
        let programa = document.querySelector("#programa" + actividad.id_programa);
        //SE CREA UN DIV QUE CONTENDRA LA INFORMACION DE LA ACTIVIDAD
        let divContenedor = document.createElement("div");
        divContenedor.classList.add("contenedor-actividades");
        //SE CREA OTRO DIV PARA EL TITULO DE LA ACTIVIDAD
        let divTitulo = document.createElement("div");
        divTitulo.classList.add("contenedor-actividades-titulo");
        divTitulo.setAttribute("onclick", "mostrarContenido()");
        let h3 = document.createElement("h3");
        h3.textContent = actividad.nombre;
        divTitulo.appendChild(h3);
        //SE CREA OTRO DIV QUE TENDRA TODA LA INFORMACION DE LA ACTIVIDAD
        let contenedorActividad = document.createElement("div");
        contenedorActividad.classList.add("contenedor-actividad");
        contenedorActividad.setAttribute("hidden", true);
        //DIV CON LA DESCRIPCION DE LA ACTIVIDAD
        let divContenedorDescripcion = document.createElement("div");
        divContenedorDescripcion.classList.add("contenedor-actividad-caracteristicas");
        let tituloDescripcion = document.createElement("h5");
        tituloDescripcion.textContent = "Descripción"
        let descripcion = document.createElement("p");
        descripcion.textContent = actividad.descripcion;
        divContenedorDescripcion.appendChild(tituloDescripcion);
        divContenedorDescripcion.appendChild(descripcion);
        //DIV CON LA COMPETENCIA DE LA ACTIVIDAD
        let divContenedorCompetencia = document.createElement("div");
        divContenedorCompetencia.classList.add("contenedor-actividad-caracteristicas");
        let tituloCompetencia = document.createElement("h5");
        tituloCompetencia.textContent = "Competencia"
        let competencia = document.createElement("p");
        competencia.textContent = actividad.competencia;
        divContenedorCompetencia.appendChild(tituloCompetencia);
        divContenedorCompetencia.appendChild(competencia);
        //DIV CON LOS BENEFICIOS DE LA ACTIVIDAD
        let divContenedorBeneficios = document.createElement("div");
        divContenedorBeneficios.classList.add("contenedor-actividad-caracteristicas");
        let tituloBeneficios = document.createElement("h5");
        tituloBeneficios.textContent = "Beneficios"
        let beneficios = document.createElement("p");
        beneficios.textContent = actividad.beneficios;
        divContenedorBeneficios.appendChild(tituloBeneficios);
        divContenedorBeneficios.appendChild(beneficios);
        //DIV CON LOS CREDITOS DE LA ACTIVIDAD
        let divContenedorCreditos = document.createElement("div");
        divContenedorCreditos.classList.add("contenedor-actividad-caracteristicas");
        let tituloCreditos = document.createElement("h5");
        tituloCreditos.textContent = "Creditos que otorga"
        let creditos = document.createElement("p");
        creditos.textContent = actividad.creditos_otorga;
        divContenedorCreditos.appendChild(tituloCreditos);
        divContenedorCreditos.appendChild(creditos);
        //DIV CON LOS MATERIALES QUE NECESITA EL ALUMNO PARA REALIZAR LA ACTIVIDAD
        let divContenedorMateriales = document.createElement("div");
        divContenedorMateriales.classList.add("contenedor-actividad-caracteristicas")
        let titleMateriales = document.createElement("h5");
        titleMateriales.textContent = "Materiales Necesarios"
        let ulMateriales = document.createElement("ul");
        ulMateriales.id = "materiales"+actividad.id_actividad
        divContenedorMateriales.appendChild(titleMateriales);
        divContenedorMateriales.appendChild(ulMateriales);
        //DIV CON LAS FECHAS DE INICIO Y FIN DE LA ACTIVIDAD
        let divContenedorFechas = document.createElement("div");
        divContenedorFechas.classList.add("contenedor-actividad-caracteristicas")
        let titleFechas = document.createElement("h5");
        titleFechas.textContent = "Fechas de Actividad"
        let fecha_inicio = document.createElement("p");
        let fecha_fin = document.createElement("p");
        fecha_inicio.textContent = "Fecha de Inicio: "+actividad.fecha_inicio;
        fecha_fin.textContent = "Fecha de Fin: "+actividad.fecha_fin;
        divContenedorFechas.appendChild(titleFechas);
        divContenedorFechas.appendChild(fecha_inicio);
        divContenedorFechas.appendChild(fecha_fin);
        //DIV DEL VIDEO DE LA ACTIVIDAD (EN CASO DE QUE NO TENGA SE OMITE)
        let tieneVideo = (actividad.video !== null)
        let divContenedorVideos;
        if(tieneVideo){
        divContenedorVideos = document.createElement("div");
        divContenedorVideos.classList.add("contenedor-actividad-video");
        let tituloVideo = document.createElement("h5");
        tituloVideo.textContent = "Video de Actividad"
        let video = document.createElement("video");
        video.controls = true;
        actividad.video===null ? video.src = "" : video.src = actividad.video
        divContenedorVideos.appendChild(tituloVideo);
        divContenedorVideos.appendChild(video);
        }
        //DIV PARA BOTON DE MOSTRAR GRUPOS
        let divBotonGrupos = document.createElement("div");
        divBotonGrupos.classList.add("contenedor-actividad-boton");
        let boton = document.createElement("button");
        boton.textContent = "Mostrar grupos";
        boton.classList.add("btn")
        boton.classList.add("boton-mostrar-grupos");
        boton.onclick = function () {
            let contenedorGrupos = document.getElementById("actividad" + actividad.id_actividad);
            if (contenedorGrupos.style.display === "none") {
                contenedorGrupos.style.display = "block";
                boton.textContent = "Ocultar grupos"
            } else {
                contenedorGrupos.style.display = "none";
                boton.textContent = "Mostrar grupos";
            }
        }
        divBotonGrupos.appendChild(boton);

        contenedorActividad.appendChild(divContenedorDescripcion);
        contenedorActividad.appendChild(divContenedorCompetencia);
        contenedorActividad.appendChild(divContenedorBeneficios);
        contenedorActividad.appendChild(divContenedorCreditos);
        contenedorActividad.appendChild(divContenedorMateriales);
        contenedorActividad.appendChild(divContenedorFechas);
        if(tieneVideo){
            contenedorActividad.appendChild(divContenedorVideos);
        }
        
        contenedorActividad.appendChild(divBotonGrupos);
        //DIV QUE CONTENDRA LOS GRUPOS DE LA ACTIVIDAD
        let divContenido = document.createElement("div")
        divContenido.classList.add("contenedor-grupos");
        //IMPORTANTE SE LE AGREGA A ESTE CONTENEDOR EL ID DE LA ACTIVIDAD PARA DESPUES AGREGAR LOS GRUPOS
        divContenido.id = "actividad" + actividad.id_actividad;
        divContenido.style.display = "none";
        programa.appendChild(divTitulo);
        programa.appendChild(contenedorActividad);
        programa.appendChild(divContenido);
    });
}

//MODAL PARA CONFIRMACION DE INSCRIPCION DE LA ACTIVIDAD
function mostart_modal_inscripcion(id_actividad,id_grupo){
    $("#id_actividad_inscribirse").val(id_actividad);
    $("#id_grupo_inscribirse").val(id_grupo);
    $("#modal_confirmacion_registro").modal("show");
}

//CREAR GRUPOS
function crear_grupos(grupos) {
    //POR CADA GRUPO
    grupos.forEach(grupo => {
        //SE SELECCIONA EL CONTENEDOR QUE SE CREO EN CREAR ACTIVIDAD QUE CONTENDRA LOS GRUPOS
        let actividad = document.querySelector("#actividad" + grupo.id_actividad);
        //SE CREA UN DIV QUE CONTENDRA CADA GRUPO
        let divContenedor = document.createElement("div");
        divContenedor.classList.add("contenedor-grupo");
        //SE CREA UN DIV PARA EL TITULO DEL GRUPO
        let divTitulo = document.createElement("div");
        divTitulo.classList.add("contenedor-grupo-titulo");
        divTitulo.setAttribute("onclick", "mostrarContenido()");
        let h3 = document.createElement("h3");
        h3.textContent = "Grupo " + grupo.nombre + " - " + grupo.nombre_caracteristica;
        divTitulo.appendChild(h3);
        //SE CREA UN DIV QUE CONTENDRA TODA LA INFROMACION DEL GRUPO
        let divContenido = document.createElement("div")
        divContenido.classList.add("descripcion-grupo");
        divContenido.id = "grupo" + grupo.id_grupo;
        divContenido.setAttribute("hidden", true);
        const diasSemana = ["Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"];
        //SE CREA UNA TABLA PARA LOS HORARIOS DEL GRUPO
        let tabla = document.createElement("table");
        tabla.classList.add("tabla-grupo-horario");
        let thead = document.createElement("thead");
        let trthead = document.createElement("tr");
        diasSemana.forEach(dia => {
            let th = document.createElement("th");
            th.textContent = dia;
            trthead.appendChild(th);
        });
        thead.appendChild(trthead);
        let tbody = document.createElement("tbody");
        let trtbody = document.createElement("tr");
        diasSemana.forEach(dia => {
            let th = document.createElement("th");
            th.textContent = "";
            th.id = dia + grupo.id_grupo;
            trtbody.appendChild(th);
        });
        tbody.appendChild(trtbody);
        tabla.appendChild(thead);
        tabla.appendChild(tbody);
        divContenido.appendChild(tabla);
        //SE CREA UN DIV PARA LA DESCRIPCION DEL GRUPO
        let divDescripcion = document.createElement("div");
        divDescripcion.classList.add("contenedor-caracteristicas");
        //SE CREA UN DIV PARA EL LUGAR
        let divContenedorLugar = document.createElement("div");
        divContenedorLugar.classList.add("contenedor-grupo-caracteristica");
        let tituloLugar = document.createElement("h5");
        tituloLugar.textContent = "Lugar: "
        let lugar = document.createElement("p");
        lugar.textContent = grupo.nombre_lugar;
        divContenedorLugar.appendChild(tituloLugar);
        divContenedorLugar.appendChild(lugar);
        //SE CREA UN DIV PARA EL INSTRUCTOR
        let divContenedorInstructor = document.createElement("div");
        divContenedorInstructor.classList.add("contenedor-grupo-caracteristica");
        let tituloInstructor = document.createElement("h5");
        tituloInstructor.textContent = "Instructor: "
        let instructor = document.createElement("p");
        instructor.textContent = grupo.nombre_instructor + " " + grupo.apellido_p + " " + grupo.apellido_m;
        divContenedorInstructor.appendChild(tituloInstructor);
        divContenedorInstructor.appendChild(instructor);
        divDescripcion.appendChild(divContenedorLugar);
        divDescripcion.appendChild(divContenedorInstructor);
        divContenido.appendChild(divDescripcion);
        //SE CREA UN H3 PARA MOSTRAR LA CAPACIDAD DEL GRUPO ACTUALMENTE
        let cupo = document.createElement("h3");
        cupo.textContent = "Espacio disponible: " + (grupo.capacidad_max - grupo.total_inscripciones);
        divContenido.appendChild(cupo);
        //SE CREA EL BOTON PARA REGISTARSE
        let boton = document.createElement("button");
        boton.onclick = function(){
            mostart_modal_inscripcion(grupo.id_actividad, grupo.id_grupo);
        }
        boton.textContent = "Registrarse";
        boton.classList.add("btn")
        boton.classList.add("boton-registarse-grupo");
        if (grupo.total_inscripciones === grupo.capacidad_max) {
            boton.classList.add("lleno");
        }
        divContenido.appendChild(boton);
        divContenedor.appendChild(divTitulo);
        divContenedor.appendChild(divContenido);
        actividad.appendChild(divContenedor);
    });
}

//CREA HORARIOS
function crear_horarios(horarios){
    //POR CADA HORARIO
    horarios.forEach(horario => {
        //SE SELECCIONA CADA CUADRO DE LA TABLA DE CADA GRUPO QUE SE CREO CON ESE ID Y SE PONE EL HORARIO
        let cuadroDia = document.querySelector("#" + horario.dia + horario.id_grupo);
        cuadroDia.classList.add("dia-horario");
        cuadroDia.textContent = moment(horario.hora_inicio,"HH:mm:ss").format("HH:mm").toString() + " - " + moment(horario.hora_fin,"HH:mm:ss").format("HH:mm").toString();
    })
}

//CREA MATERIALES
function crear_materiales(materiales){
    //POR CADA MATERIAL
    materiales.forEach(material => {
        //SE CREA UN ELEMENTO DE LISTA EL CUAL SE AGREGARA A LA LISTA DE MATERIALES PARA CADA ACTIVIDAD
        let ulMateriales = document.querySelector("#materiales" + material.id_actividad);
        let li = document.createElement("li");
        li.textContent = material.nombre +": "+material.cantidad
        ulMateriales.appendChild(li);
    });
}

//SELECT DE PROGRAMAS
function select_programas() {
    $.ajax({
        type: "GET",
        url: path + "select_programas.php",
        success: function (res) {
            let programas = JSON.parse(res);
            //CREA LOS PROGRAMAS
            crear_programas(programas);
            //UNA VEZ CREADOS LOS PROGRAMAS LLAMA AL SELECT DE ACTIVIDADES
            select_actividades();
        }
    });
}
select_programas();



//SELECT DE ACTIVIDADES
function select_actividades() {
    $.ajax({
        type: "GET",
        url: path + "select_actividades.php",
        success: function (res) {
            let actividades = JSON.parse(res);
            //CREA LAS ACTIVIDADES
            crear_actividades(actividades);
            //UNA VEZ CREADAS LAS ACTIVIDADES LLAMA AL SELECT DE MATERIALES
            select_materiales_alumno();
        }
    });
}

//SELECT DE MATERIALES
function select_materiales_alumno() {
    $.ajax({
        type: "GET",
        url: path + "select_materiales.php",
        success: function (res) {
            let materiales = JSON.parse(res);
            //CREA LOS MATERILES
            crear_materiales(materiales);
            //UNA VEZ CREADOS LOS MATERIALES LLAMA AL SELECT DE GRUPOS
            select_grupos();
        }
    });
}

//SELECT DE GRUPOS
function select_grupos() {
    $.ajax({
        type: "GET",
        url: path + "select_grupos.php",
        success: function (res) {
            let grupos = JSON.parse(res);
            //CREA LOS GRUPOS
            crear_grupos(grupos);
            //UNA VEZ CREADOS LOS GRUPOS LLAMA AL SELECT DE HORARIOS
            select_horarios();
        }
    });
}

//SELECT DE HORARIOS
function select_horarios() {
    $.ajax({
        type: "GET",
        url: path + "select_horarios.php",
        success: function (res) {
            let horarios = JSON.parse(res);
            //CREA LOS HORARIOS
            crear_horarios(horarios);
        }
    });
}

//FUNCION AL DAR CLICK EN EL BOTON DE REGISTRARSE EN UN GRUPO
function registrarse(){
    let id_actividad = $("#id_actividad_inscribirse").val();
    let id_grupo = $("#id_grupo_inscribirse").val();
    let id_alumno = $("#id_alumno").val();
    if(id_actividad.length!==0 && id_grupo.length!==0 && id_alumno.length!==0){
        $.ajax({
            type: "POST",
            url: path+"insert_detalle_inscripcion_alumno.php",  
            data: {"id_actividad": id_actividad, "id_grupo": id_grupo, "id_alumno":id_alumno} ,                         
            success: function(res){
                let mensaje = JSON.parse(res)[0].mensaje;
                $("#modal_confirmacion_registro").modal("hide");  
                select_programas();
                if(mensaje==="INSERTADO"){
                    mostrar_alerta(1);
                }else{
                    mostrar_alerta(3)
                }
            }
        });
    }else{
        mostrar_alerta(2);
    } 
}
