function login(){
    let correo = $("#email").val();
    let contrasena = $("#contrasena").val();
    $.ajax({
        type: "POST",
        url: path+"login.php",  
        data: {"correo": correo, "contrasena": contrasena} ,                         
        success: function(res){ 
            if(res==="responsable"){
                window.location.href = "../../../views/modules/admin/administrador.php"
            } 
        }
    });
}