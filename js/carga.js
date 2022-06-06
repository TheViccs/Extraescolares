function agregar_actividades(carga){
    let tabla = document.querySelector("#tbody_actividades_carga_complementaria");
    tabla.innerHTML = "";
    carga.forEach(actividad => {
        let tr = document.createElement("tr");

        let thactividad = document.createElement("th");
        thactividad.textContent = actividad.nombre_actividad;
        let thgrupo = document.createElement("th");
        thgrupo.textContent = actividad.nombre;
        let thinstructor = document.createElement("th");
        thinstructor.textContent = actividad.nombre_instructor+" "+actividad.apellido_p+" "+actividad.apellido_m;
        let thlugar = document.createElement("th");
        thlugar.textContent = actividad.nombre_lugar;
        let thlunes = document.createElement("th");
        thlunes.id = "Lunes"+actividad.id_grupo;
        let thmartes = document.createElement("th");
        thmartes.id = "Martes"+actividad.id_grupo;
        let thmiercoles = document.createElement("th");
        thmiercoles.id = "Miércoles"+actividad.id_grupo;
        let thjueves = document.createElement("th");
        thjueves.id = "Jueves"+actividad.id_grupo;
        let thviernes = document.createElement("th");
        thviernes.id = "Viernes"+actividad.id_grupo;
        let thsabado = document.createElement("th");
        thsabado.id = "Sabado"+actividad.id_grupo;
        tr.append(thactividad);
        tr.append(thgrupo);
        tr.append(thinstructor);
        tr.append(thlugar);
        tr.append(thlunes);
        tr.append(thmartes);
        tr.append(thmiercoles);
        tr.append(thjueves);
        tr.append(thviernes);
        tr.append(thsabado);
        tabla.append(tr);
    });
}

//SELECT DE CARGA COMPLEMENTARIA
function select_carga(){
    let id_alumno = $("#id_alumno").val();
    $.ajax({
        type: "POST",
        url: path+"select_carga_complementaria_alumno_id.php",
        data: {"id_alumno":id_alumno},                           
        success: function(res){    
            let carga = JSON.parse(res);
            $("#numero_actividades_alumno").text(carga.length);
            let usuario = $("#correo_alumno").val().substring(0,$("#correo_alumno").val().indexOf("@"));
            $("#alumno").text(usuario);   
            agregar_actividades(carga);
            select_horarios();
        }
    });
}
select_carga();

//SELECT DE CARGA COMPLEMENTARIA
function select_horarios(){
    let id_alumno = $("#id_alumno").val();
    $.ajax({
        type: "POST",
        url: path+"select_horarios_carga_complementaria_alumno_id.php",
        data: {"id_alumno":id_alumno},                           
        success: function(res){    
            let horarios = JSON.parse(res);    
            console.log(horarios);         
            horarios.forEach(horario => {
                let dato = document.querySelector("#"+horario.dia+horario.id_grupo);
                dato.textContent = moment(horario.hora_inicio,"HH:mm:ss").format("HH:mm").toString() + " - " + moment(horario.hora_fin,"HH:mm:ss").format("HH:mm").toString();
            });
        }
    });
}

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


function getDataUri(url, cb){
    var image = new Image();
    image.setAttribute('crossOrigin', 'anonymous'); //getting images from external domain
    image.onload = function () {
        var canvas = document.createElement('canvas');
        canvas.width = this.naturalWidth;
        canvas.height = this.naturalHeight;
        //next three lines for white background in case png has a transparent background
        var ctx = canvas.getContext('2d');
        ctx.fillStyle = '#fff';  /// set white fill style
        ctx.fillRect(0, 0, canvas.width, canvas.height);
        canvas.getContext('2d').drawImage(this, 0, 0);
        cb(canvas.toDataURL('image/png'));
    };
    image.src = url;
}

let imgUrl = '../../../assets/img/logoitcolima.png';
let logo = null;

getDataUri(imgUrl, function(dataUri) {
    logo = dataUri;
});

//IMPRIMIR PDF CARGA
function generar_pdf(id_alumno){
    $.ajax({
        type: "POST",
        data: {"id_alumno": id_alumno},
        url: path+"select_carga_complementaria_alumno_id.php",                           
        success: function(res1){   
            $.ajax({
                type: "POST",
                data: {"id_alumno": id_alumno},
                url: path+"select_horarios_carga_complementaria_alumno_id.php",                           
                success: function(res2){
                    let carga = JSON.parse(res1);
                    let horarios = JSON.parse(res2);
                    let pdf = new jsPDF('l');
                    let columns = [["Actividad", "Grupo", "Instructor", "Lugar","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado"]];
                    let data = [];
                    let dias = ["Lunes","Martes","Miércoles","Jueves","Viernes","Sábado"]
                    carga.forEach(actividad => {
                        let carga = [actividad.nombre_actividad,actividad.nombre, actividad.nombre_instructor+" "+actividad.apellido_p+" "+actividad.apellido_m,actividad.nombre_lugar];          
                            dias.forEach(dia => {    
                                let encontrado = false;
                                horarios.forEach(horario => {             
                                    if(actividad.id_grupo===horario.id_grupo && horario.dia===dia){
                                        encontrado = true;
                                        carga.push(moment(horario.hora_inicio,"HH:mm:ss").format("HH:mm").toString() + " - " + moment(horario.hora_fin,"HH:mm:ss").format("HH:mm").toString());
                                    } 
                                })   
                                if(!encontrado){
                                    carga.push("");
                                }       
                            });          
                        data.push(carga);
                    });
                    pdf.setProperties({
                        title: "Carga Académica"
                    });
                    pdf.addImage(logo, 'PNG', 0, 5, 140, 30);
                    let nombre_institucion = "Tecnológico Nacional de México Campus Colima";
                    let x_nombre_institucion = (pdf.internal.pageSize.width/2) - (pdf.getTextWidth(nombre_institucion)/2);
                    let texto = "Carga Académica";
                    let x_texto = (pdf.internal.pageSize.width/2) - (pdf.getTextWidth(texto)/2);
                    pdf.text(nombre_institucion,x_nombre_institucion,15)
                    pdf.text(texto,x_texto,30)
                    pdf.autoTable({
                        startY: 40,
                        head: columns,
                        body: data,
                    })
                    let blob = pdf.output("blob");
                    window.open(URL.createObjectURL(blob));                   
                }
            });        
        }
    });

}

