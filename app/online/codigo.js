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
            url: "http://localhost:3000/api/auth/login",
            crossDomain: true,
            type: "POST",
            dataType: "json",
            data: { usuario: usuario, password: password },
            success: function(response) {
                if (response.status === "success") {
                    // Guardar token para futuras solicitudes
                    if (response.token) {
                        localStorage.setItem("token", response.token);
                    }
                    // Ahora login en PHP para iniciar sesión en el dashboard legacy
                    $.ajax({
                        url: "/bd/login.php",
                        type: "POST",
                        dataType: "json",
                        data: { usuario: usuario, password: password },
                        xhrFields: { withCredentials: true }
                    }).done(function(phpResp) {
                        if (phpResp.status === "success") {
                            Swal.fire({
                                icon: 'success',
                                title: '¡Conexión exitosa!',
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'Ingresar'
                            }).then((result) => {
                                if (result.value) {
                                    window.location.href = phpResp.redirect;
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error PHP',
                                text: phpResp.error || 'Error en login PHP.'
                            });
                        }
                    }).fail(function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error PHP',
                            text: 'No se pudo conectar con el servidor de login PHP.'
                        });
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error Auth',
                        text: response.error
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error Auth',
                    text: 'No se pudo conectar con el servidor de login.'
                });
            }
        });
    }     
});
