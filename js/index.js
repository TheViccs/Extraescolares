var path = "../../../php/"

//FUNCIONES ALERTAS
//CREAR ALERTA
function crear_alerta(tipo){
    switch (tipo) {
        case 1:
            $("#alertas").append(
                '<div id="alerta" class="alert alert-success d-flex align-items-center" role="alert">'
                    +'<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>'
                    +'<div>'
                    +   'Se han guardado los cambios correctamente'
                    +'</div>'
                +'</div>');
            break;
        case 2:
            $("#alertas").append(
                '<div id="alerta" class="alert alert-warning d-flex align-items-center" role="alert">'
                    +'<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:"><use xlink:href="#exclamation-triangle-fill"/></svg>'
                    +'<div>'
                    +   'Por favor llena todos los campos'
                    +'</div>'
                +'</div>');
            break;
        case 3:
            $("#alertas").append(
                '<div id="alerta" class="alert alert-danger d-flex align-items-center" role="alert">'
                    +'<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>'
                    +'<div>'
                    +   'Hubo un error por favor intentelo de nuevo'
                    +'</div>'
                +'</div>');
            break;
        default:
            break;
    }
    
}

//MOSTRAR Y ELIMINAR ALERTA
function mostrar_alerta(tipo){
    crear_alerta(tipo);
    let contenedorAlertas = document.getElementById("alertas");
    let alertas = contenedorAlertas.children;
    for(let alerta of alertas){
        $(alerta).delay(3000).slideUp(100, function() {
            $(this).alert('close');
        });
    }
}

//CONVERTIR IMAGEN
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