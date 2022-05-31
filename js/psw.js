

function compara(){
    var p1 = document.getElementById('psw1');
    var p2 = document.getElementById('psw2');

    if(p1.value == p2.value){
        modal();
        borrar_datos_input_psw();
    }else{
        modal1();
        borrar_datos_input_psw();
        
    }


}


function borrar_datos_input_psw(){
    $("#psw1").val("");
    $("#psw2").val("");
}

function modal(){
    $("#modal").modal("show");
}

function modal1(){
    $("#myModal").modal("show");
}



