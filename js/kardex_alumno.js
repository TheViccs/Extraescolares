//SELECT DE PERIODO
function select_periodo(){
    $.ajax({
        type: "GET",
        url: path+"select_periodo.php",                           
        success: function(res){ 
            let periodo = JSON.parse(res);
            if(periodo.length!==0){
                periodo = periodo[0]; 
                if(moment(periodo.fecha_fin_actividades).add(1,"days")>=moment()){
                    $("#periodo_actual").text(periodo.nombre);
                }
            }
        }
    });
}
select_periodo();

//PONE USUARIO EN LA BARRA DE ARRIBA DEL KARDEX
function poner_usuario(){
    let usuario = $("#correo_alumno").val().substring(0,$("#correo_alumno").val().indexOf("@"));
    $("#alumno").text(usuario); 
}
poner_usuario();

//CREA EL KARDEX DEL ALUMNO
function crear_kardex(kardex){
    //OBTIENE EL BODY DE LA TABLA DEL KARDEX
    let contenedor_kardex = document.querySelector("#tbody_actividades_kardex");
    contenedor_kardex.innerHTML = "";
    //POR CADA ACTIVIDAD
    kardex.forEach(actividad => {
        let estatus = "";
        //CREA UNA FILA
        let tr = document.createElement("tr");
        //LA CUAL SI NO SE HA TERMINADO LA ACTIVIDAD Y EL ALUMNO YA ESTA ACREDITADO LO MUESTRA EN VERDE Y COMO ACREDITADA
        //SI NO ESTA ACREDITADO SE VERA EN AMARILLO Y CURSANDO
        if(moment(actividad.fecha_fin_actividades) > moment()){
            if(actividad.acreditacion==="1"){
                tr.classList.add("acreditada")
                estatus = "Acreditada";
            }else{
                tr.classList.add("cursando")
                estatus = "Cursando";
            }        
        }else{
            //EN CASO DE QUE SE HAYA TERMINADO LA ACTIVIDAD Y ESTE ACREDITADA SE MOSTRARA VERDE Y COMO ACREDITADA
            //SI NO EN ROJA Y COMO NO ACREDITADA
            if(actividad.acreditacion==="1"){
                tr.classList.add("acreditada")
                estatus = "Acreditada";
            }else{
                tr.classList.add("reprobada")
                estatus = "No Acreditada"
            }

        }
        //SE CREA UNA COLUMNA CON EL NOMBRE DE LA ACTIVIDAD Y LOS CREDITOS QUE OTORGA
        let thactividad = document.createElement("th");
        thactividad.textContent = "["+actividad.creditos_otorga+"] "+actividad.nombre;
        //COLUMNA CON EL NOMBRE DEL PERIODO DONDE SE CURSO
        let thperiodo = document.createElement("th");
        thperiodo.textContent = actividad.nombre_periodo;
        //COLUMNA CON LA CALIFICACION
        let thcalificacion = document.createElement("th");
        thcalificacion.textContent = actividad.calificacion_numerica;
        //COLUMNA CON LA CALIFICACION
        let thdesempeño = document.createElement("th");
        thdesempeño.textContent = actividad.desempeño;
        //COLUMNA CON EL ESTATUS (ACREDITADA, CURSANDO, NO ACREDITADA)
        let thestatus = document.createElement("th");
        thestatus.textContent = estatus;
        //SE AGREGAN A LOS COMPONENTES PADRE
        tr.append(thactividad);
        tr.append(thperiodo);
        tr.append(thcalificacion);
        tr.append(thdesempeño);
        tr.append(thestatus);
        contenedor_kardex.append(tr);
    });
}

//SELECT DE DETALLES DE INSCRIPCIONES
function select_kardex(){
    let id_alumno = $("#id_alumno").val();
    $.ajax({
        type: "POST",
        data: {"id_alumno":id_alumno},
        url: path+"select_detalles_inscripcion_alumno_id.php",                           
        success: function(res){
            let kardex = JSON.parse(res);
            crear_kardex(kardex);
        }
    });
}
select_kardex();


//SELECT DE DETALLES DE INSCRIPCIONES
function select_actividades_acreditadas(){
    let id_alumno = $("#id_alumno").val();
    $.ajax({
        type: "POST",
        data: {"id_alumno":id_alumno},
        url: path+"select_actividades_acreditadas_alumno_id.php",                           
        success: function(res){ 
            let conteo = JSON.parse(res)[0];
            $("#actividades_acreditadas_alumno").text(conteo.actividades_acreditadas);
        }
    });
}
select_actividades_acreditadas();