function mostrarContenido() {
    if (this.event.currentTarget.nextElementSibling.hasAttribute("hidden")) {
        this.event.currentTarget.nextElementSibling.removeAttribute("hidden");
    } else {
        this.event.currentTarget.nextElementSibling.setAttribute("hidden", true);
    }

}




function crear_programas(programas) {
    let main = document.getElementById("contenedor_programas");
    main.innerHTML = "";
    programas.forEach(programa => {
        let divContenedor = document.createElement("div");
        divContenedor.classList.add("contenedor-programa");
        let divTitulo = document.createElement("div")
        divTitulo.classList.add("contenedor-programa-titulo");
        divTitulo.setAttribute("onclick", "mostrarContenido()");
        divTitulo.classList.add("titulo-programa");
        let h3 = document.createElement("h3");
        h3.textContent = programa.nombre;
        divTitulo.appendChild(h3);
        let divContenido = document.createElement("div");
        divContenido.classList.add("contenedor-actividades");
        divContenido.id = "programa" + programa.id_programa;
        divContenido.setAttribute("hidden", true);
        divContenedor.appendChild(divTitulo);
        divContenedor.appendChild(divContenido);
        main.appendChild(divContenedor);
    });
}


function crear_actividades(actividades) {
    actividades.forEach(actividad => {
        let programa = document.querySelector("#programa" + actividad.id_programa);
        let divContenedor = document.createElement("div");
        divContenedor.classList.add("contenedor-actividades");
        let divTitulo = document.createElement("div");
        divTitulo.classList.add("contenedor-actividades-titulo");
        divTitulo.setAttribute("onclick", "mostrarContenido()");
        let h3 = document.createElement("h3");
        h3.textContent = actividad.nombre;
        divTitulo.appendChild(h3);
        let contenedorActividad = document.createElement("div");
        contenedorActividad.classList.add("contenedor-actividad");
        contenedorActividad.setAttribute("hidden", true);

        let divContenedorDescripcion = document.createElement("div");
        divContenedorDescripcion.classList.add("contenedor-actividad-caracteristicas");
        let tituloDescripcion = document.createElement("h5");
        tituloDescripcion.textContent = "Descripción"
        let descripcion = document.createElement("p");
        descripcion.textContent = actividad.descripcion;
        divContenedorDescripcion.appendChild(tituloDescripcion);
        divContenedorDescripcion.appendChild(descripcion);

        let divContenedorCompetencia = document.createElement("div");
        divContenedorCompetencia.classList.add("contenedor-actividad-caracteristicas");
        let tituloCompetencia = document.createElement("h5");
        tituloCompetencia.textContent = "Competencia"
        let competencia = document.createElement("p");
        competencia.textContent = actividad.competencia;
        divContenedorCompetencia.appendChild(tituloCompetencia);
        divContenedorCompetencia.appendChild(competencia);

        let divContenedorBeneficios = document.createElement("div");
        divContenedorBeneficios.classList.add("contenedor-actividad-caracteristicas");
        let tituloBeneficios = document.createElement("h5");
        tituloBeneficios.textContent = "Beneficios"
        let beneficios = document.createElement("p");
        beneficios.textContent = actividad.beneficios;
        divContenedorBeneficios.appendChild(tituloBeneficios);
        divContenedorBeneficios.appendChild(beneficios);

        let divContenedorCreditos = document.createElement("div");
        divContenedorCreditos.classList.add("contenedor-actividad-caracteristicas");
        let tituloCreditos = document.createElement("h5");
        tituloCreditos.textContent = "Creditos que otorga"
        let creditos = document.createElement("p");
        creditos.textContent = actividad.creditos_otorga;
        divContenedorCreditos.appendChild(tituloCreditos);
        divContenedorCreditos.appendChild(creditos);

        let divContenedorMateriales = document.createElement("div");
        divContenedorMateriales.classList.add("contenedor-actividad-caracteristicas")
        let titleMateriales = document.createElement("h5");
        titleMateriales.textContent = "Materiales Necesarios"
        let ulMateriales = document.createElement("ul");
        ulMateriales.id = "materiales"+actividad.id_actividad
        divContenedorMateriales.appendChild(titleMateriales);
        divContenedorMateriales.appendChild(ulMateriales);

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

        let divContenido = document.createElement("div")
        divContenido.classList.add("contenedor-grupos");
        divContenido.id = "actividad" + actividad.id_actividad;
        divContenido.style.display = "none";
        programa.appendChild(divTitulo);
        programa.appendChild(contenedorActividad);
        programa.appendChild(divContenido);
    });
}

function mostart_modal_inscripcion(id_actividad,id_grupo){
    $("#id_actividad_inscribirse").val(id_actividad);
    $("#id_grupo_inscribirse").val(id_grupo);
    $("#modal_confirmacion_registro").modal("show");
}


function crear_grupos(grupos) {
    grupos.forEach(grupo => {
        let actividad = document.querySelector("#actividad" + grupo.id_actividad);
        let divContenedor = document.createElement("div");
        divContenedor.classList.add("contenedor-grupo");
        let divTitulo = document.createElement("div");
        divTitulo.classList.add("contenedor-grupo-titulo");
        divTitulo.setAttribute("onclick", "mostrarContenido()");
        let h3 = document.createElement("h3");
        h3.textContent = "Grupo " + grupo.nombre + " - " + grupo.nombre_caracteristica;
        divTitulo.appendChild(h3);
        let divContenido = document.createElement("div")
        divContenido.classList.add("descripcion-grupo");
        divContenido.id = "grupo" + grupo.id_grupo;
        divContenido.setAttribute("hidden", true);
        const diasSemana = ["Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"];
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

        let divDescripcion = document.createElement("div");
        divDescripcion.classList.add("contenedor-caracteristicas");
        let divContenedorLugar = document.createElement("div");
        divContenedorLugar.classList.add("contenedor-grupo-caracteristica");
        let tituloLugar = document.createElement("h5");
        tituloLugar.textContent = "Lugar: "
        let lugar = document.createElement("p");
        lugar.textContent = grupo.nombre_lugar;
        divContenedorLugar.appendChild(tituloLugar);
        divContenedorLugar.appendChild(lugar);
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

        let cupo = document.createElement("h3");
        cupo.textContent = "Espacio disponible: " + (grupo.capacidad_max - grupo.total_inscripciones);
        divContenido.appendChild(cupo);

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


function crear_horarios(horarios){
    horarios.forEach(horario => {
        let cuadroDia = document.querySelector("#" + horario.dia + horario.id_grupo);
        cuadroDia.classList.add("dia-horario");
        cuadroDia.textContent = moment(horario.hora_inicio,"HH:mm:ss").format("HH:mm").toString() + " - " + moment(horario.hora_fin,"HH:mm:ss").format("HH:mm").toString();
    })
}

function crear_materiales(materiales){
    materiales.forEach(material => {
        let ulMateriales = document.querySelector("#materiales" + material.id_actividad);
        let li = document.createElement("li");
        li.textContent = material.nombre +": "+material.cantidad
        ulMateriales.appendChild(li);
    });
}

function select_programas() {
    $.ajax({
        type: "GET",
        url: path + "select_programas.php",
        success: function (res) {
            let programas = JSON.parse(res);
            crear_programas(programas);
            select_actividades();
        }
    });
}
select_programas();




function select_actividades() {
    $.ajax({
        type: "GET",
        url: path + "select_actividades.php",
        success: function (res) {
            console.log(res);
            let actividades = JSON.parse(res);
            crear_actividades(actividades);
            select_materiales_alumno();
        }
    });
}

function select_materiales_alumno() {
    $.ajax({
        type: "GET",
        url: path + "select_materiales.php",
        success: function (res) {
            let materiales = JSON.parse(res);
            console.log(materiales);
            crear_materiales(materiales);
            select_grupos();
        }
    });
}


function select_grupos() {
    $.ajax({
        type: "GET",
        url: path + "select_grupos.php",
        success: function (res) {
            let grupos = JSON.parse(res);
            crear_grupos(grupos);
            select_horarios();
        }
    });
}

function select_horarios() {
    $.ajax({
        type: "GET",
        url: path + "select_horarios.php",
        success: function (res) {
            let horarios = JSON.parse(res);
            crear_horarios(horarios);
        }
    });
}


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
