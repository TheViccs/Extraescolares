function select_criterios(){
    $.ajax({
        type: "GET",
        url: path+"select_criterios.php",                    
        success: function(res){    
            let criterios = JSON.parse(res);          
            crear_criterios(criterios)
        }
    });
}
select_criterios();

function crear_criterios(criterios){
    let contenedor_criterios = document.getElementById("contenedor_criterios");
    contenedor_criterios.innerHTML = "";
    criterios.forEach(criterio => {
        let divContendorCriterio = document.createElement("div");
        divContendorCriterio.classList.add("contenedor_criterio");
        divContendorCriterio.id = criterio.id_criterio;
        let divDescripcionCriterio = document.createElement("p");
        divDescripcionCriterio.classList.add("descripcion_criterio");
        divDescripcionCriterio.textContent = criterio.descripcion;
        let divContenedorCalificaciones = document.createElement("div");
        divContenedorCalificaciones.classList.add("contenedor_radio_calificacion");
        let radio1 = document.createElement("input");
        radio1.type = "radio";
        radio1.name = criterio.id_criterio;
        radio1.value = "1";
        let radio2 = document.createElement("input");
        radio2.type = "radio";
        radio2.name = criterio.id_criterio;
        radio2.value = "2";
        let radio3 = document.createElement("input");
        radio3.type = "radio";
        radio3.name = criterio.id_criterio;
        radio3.value = "3";
        let radio4 = document.createElement("input");
        radio4.type = "radio";
        radio4.name = criterio.id_criterio;
        radio4.value = "4";
        divContenedorCalificaciones.append(radio1);
        divContenedorCalificaciones.append("Insuficiente");
        divContenedorCalificaciones.append(radio2);
        divContenedorCalificaciones.append("Suficiente");
        divContenedorCalificaciones.append(radio3);
        divContenedorCalificaciones.append("Bueno");
        divContenedorCalificaciones.append(radio4);
        divContenedorCalificaciones.append("Excelente");
        divContendorCriterio.append(divDescripcionCriterio);
        divContendorCriterio.append(divContenedorCalificaciones);
        contenedor_criterios.append(divContendorCriterio);
    });

    select_criterios_alumno();
    select_calificacion_alumno();

}

function calificar_alumno(){
    let id_alumno = $("#id_alumno").val();
    let id_grupo = $("#id_grupo").val();
    let criterios = document.getElementsByClassName("contenedor_criterio");
    criterios = [].slice.call(criterios);
    let calificaciones = criterios.map(criterio => {
        if(document.querySelector("input[name='"+criterio.id+"']:checked")!==null){
            return document.querySelector("input[name='"+criterio.id+"']:checked").value
        }else{
            return null
        }
    });
    let calificacion_numerica = document.getElementById("calificacion_numerica_alumno").value;
    let acreditado = document.getElementById("boolean_acreditado_alumno").checked;
    if(calificaciones.includes(null) || calificacion_numerica.length===0){
        mostrar_alerta(2)
    }else{
        let valor_acreditado = 0;
        if(acreditado){
            valor_acreditado = 1;
        }
        let promedio = 0;
        criterios.forEach((criterio,index) => {
            calificaciones[index] = [criterio.id, parseInt(calificaciones[index])]
            promedio += calificaciones[index][1];
        })
        promedio /=7;
        insert_calificacion_alumno(id_alumno,id_grupo,calificaciones, calificacion_numerica, valor_acreditado, promedio.toFixed(2));
    }
}


function insert_calificacion_alumno(id_alumno, id_grupo,calificaciones, calificacion_numerica, valor_acreditado, promedio){
    $.ajax({
        type: "POST",
        url: path+"calificar_alumno.php",
        data: {"id_alumno":id_alumno, "id_grupo":id_grupo, "criterios":JSON.stringify(calificaciones),"calificacion_numerica":calificacion_numerica, "acreditado":valor_acreditado, "promedio":promedio},                           
        success: function(res){
            if(Number.isInteger(parseInt(JSON.parse(res)))){
                mostrar_alerta(1);
            }else{
                mostrar_alerta(3);
            }
            
        }
    });
}


function select_criterios_alumno(){
    let id_alumno = $("#id_alumno").val();
    let id_grupo = $("#id_grupo").val();
    $.ajax({
        type: "POST",
        data: {"id_alumno":id_alumno,"id_grupo":id_grupo},
        url: path+"select_criterios_alumno.php",                       
        success: function(res){    
            let criterios = JSON.parse(res);
            criterios.forEach(criterio => {
                document.querySelector("input[name='"+criterio.id_criterio+"'][value='"+criterio.desempeño+"']").checked = true;
            });
        }
    });
}


function select_calificacion_alumno(){
    let id_alumno = $("#id_alumno").val();
    let id_grupo = $("#id_grupo").val();
    $.ajax({
        type: "POST",
        data: {"id_alumno":id_alumno,"id_grupo":id_grupo},
        url: path+"select_calificacion_alumno.php",                       
        success: function(res){    
            let calificacion = JSON.parse(res)[0];
            console.log(calificacion)
            document.getElementById("calificacion_numerica_alumno").value = calificacion.calificacion_numerica
            document.getElementById("boolean_acreditado_alumno").checked = (calificacion.acreditacion === "1");
        }
    });
}