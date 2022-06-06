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

function poner_usuario(){
    let usuario = $("#correo_alumno").val().substring(0,$("#correo_alumno").val().indexOf("@"));
    $("#alumno").text(usuario); 
}
poner_usuario();

function crear_kardex(kardex){
    let contenedor_kardex = document.querySelector("#tbody_actividades_kardex");
    contenedor_kardex.innerHTML = "";
    kardex.forEach(actividad => {
        let estatus = "";
        let tr = document.createElement("tr");
        if(moment(actividad.fecha_fin_actividades) > moment()){
            if(actividad.acreditacion==="1"){
                tr.classList.add("acreditada")
                estatus = "Acreditada";
            }else{
                tr.classList.add("cursando")
                estatus = "Cursando";
            }        
        }else{
            if(actividad.acreditacion==="1"){
                tr.classList.add("acreditada")
                estatus = "Acreditada";
            }else{
                tr.classList.add("reprobada")
                estatus = "No Acreditada"
            }

        }
        let thactividad = document.createElement("th");
        thactividad.textContent = "["+actividad.creditos_otorga+"] "+actividad.nombre;
    
        let thperiodo = document.createElement("th");
        thperiodo.textContent = actividad.nombre_periodo;

        let thcalificacion = document.createElement("th");
        thcalificacion.textContent = actividad.calificacion_numerica;

        let thestatus = document.createElement("th");
        thestatus.textContent = estatus;

        tr.append(thactividad);
        tr.append(thperiodo);
        tr.append(thcalificacion);
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