function login(){
    let correo = $("#email" ).val();
    let contrasena = $("#contrasena" ).val();
    $.ajax({
        type: "POST",
        url: path+"login.php",  
        data: {"correo": correo+"@colima.tecnm.mx", "contrasena": contrasena} ,                         
        success: function(res){ 
            window.location.href = "../../../views/layout/login/index.php"
        }
    });
}

function salir(){
    $.ajax({
        type: "POST",
        url: path+"exit.php",  
        data: {} ,                         
        success: function(res){ 
            window.location.href = "../../../views/layout/login/index.php"
        }
    });
}