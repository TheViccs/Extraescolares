//FUNCIONES PARA PERIODOS
//FUNCION PARA QUE SE AGREGUE VALOR EN EL NOMBRE DEL PERIODO
$("#input-inicio-actividades").change(function(){
    let mes_inicio_actividades = moment($("#input-inicio-actividades").val()).lang("es").format('ll');
    let punto = mes_inicio_actividades.indexOf('.');
    let abr_inicio = mes_inicio_actividades.substring(punto-3,punto);
    abr_inicio = abr_inicio.charAt(0).toUpperCase()+abr_inicio.slice(1);
    if($("#input-nombre-periodo").val().length <=3){
        $("#input-nombre-periodo").val(abr_inicio);
    }else{
        valoranterior = $("#input-nombre-periodo").val();
        $("#input-nombre-periodo").val(abr_inicio+valoranterior.substring(3,12));
    }
    
});

//FUNCION PARA QUE SE AGREGUE VALOR EN EL NOMBRE DEL PERIODO
$("#input-fin-actividades").change(function(){
    valoranterior = $("#input-nombre-periodo").val();
    if(valoranterior.length <12){
        let mes_fin_actividades = moment($("#input-fin-actividades").val()).lang("es").format('ll');
        punto = mes_fin_actividades.indexOf('.');
        let abr_fin = mes_fin_actividades.substring(punto-3,punto);
        abr_fin = abr_fin.charAt(0).toUpperCase()+abr_fin.slice(1);
        let anio = moment($("#input-inicio-actividades").val()).format('YYYY');
        $("#input-nombre-periodo").val(valoranterior+"-"+abr_fin+" "+anio);
    }else{
        valoranterior = $("#input-nombre-periodo").val().substring(0,3);
        let mes_fin_actividades = moment($("#input-fin-actividades").val()).lang("es").format('ll');
        punto = mes_fin_actividades.indexOf('.');
        let abr_fin = mes_fin_actividades.substring(punto-3,punto);
        abr_fin = abr_fin.charAt(0).toUpperCase()+abr_fin.slice(1);
        let anio = moment($("#input-inicio-actividades").val()).format('YYYY');
        $("#input-nombre-periodo").val(valoranterior+"-"+abr_fin+" "+anio);
    }
});

//INSERT DE PERIODO
function insert_periodo(){
    let nombre = $("#input-nombre-periodo").val();
    let fecha_i_a = $("#input-inicio-actividades").val();
    let fecha_f_a = $("#input-fin-actividades").val();
    let fecha_i_i = $("#input-inicio-inscripciones").val();
    let fecha_f_i = $("#input-fin-inscripciones").val();
    if(nombre.length !== 0 && fecha_i_a.length !== 0 && fecha_f_a.length !== 0 && fecha_i_i.length !== 0 && fecha_f_i.length !== 0){
        $.ajax({
            type: "POST",
            url: path+"insert_periodo.php",  
            data: {"nombre": nombre, "fecha_i_a": fecha_i_a, "fecha_f_a": fecha_f_a, "fecha_i_i": fecha_i_i, "fecha_f_i": fecha_f_i} ,                         
            success: function(res){  
                if(res==="1"){   
                    mostrar_alerta(1);
                    select_periodo();  
                }else{
                    mostrar_alerta(3);
                }           
            }
        });
    }else{
        mostrar_alerta(2);
    }   
}

//SELECT DE PERIODO
function select_periodo(){
    $.ajax({
        type: "GET",
        url: path+"select_periodo.php",                           
        success: function(res){    
            let periodo = JSON.parse(res)[0];  
            if(moment(periodo.fecha_fin_actividades)>moment()){
                $("#input-nombre-periodo").val(periodo.nombre);
                $("#input-inicio-actividades").val(periodo.fecha_inicio_actividades);
                $("#input-fin-actividades").val(periodo.fecha_fin_actividades);
                $("#input-inicio-inscripciones").val(periodo.fecha_inicio_inscripciones);
                $("#input-fin-inscripciones").val(periodo.fecha_fin_inscripciones);
            }else{
                $("#input-nombre-periodo").val("");
                $("#input-inicio-actividades").val("");
                $("#input-fin-actividades").val("");
                $("#input-inicio-inscripciones").val("");
                $("#input-fin-inscripciones").val("");
            }
        }
    });
}

select_periodo();