$('#formLogin').submit(function(e) {
    console.log("Verificando si codigo.js se está ejecutando...");

    e.preventDefault();
    var usuario = $.trim($("#usuario").val());    
    var password = $.trim($("#password").val());    

    if(usuario.length == "" || password == ""){
        Swal.fire({
            icon: 'warning',
            title: 'Debe ingresar un usuario y/o contraseña',
        });
        return false; 
    } else {
        $.ajax({
            url: "bd/login.php",
            type: "POST",
            dataType: "json", // Se asegura de recibir JSON
            data: { usuario: usuario, password: password }, 
            success: function(response) {               
                if (response.status === "success") {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Conexión exitosa!',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Ingresar'
                    }).then((result) => {
                        if(result.value){
                            window.location.href = response.redirect;
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.error // Muestra el mensaje de error de login.php
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudo conectar con el servidor.'
                });
            }
        });
    }     
});
