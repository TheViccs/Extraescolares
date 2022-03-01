function imprimirfecha(){
    
    

    console.log(abr_inicio+"-"+abr_fin+" "+anio);
}

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