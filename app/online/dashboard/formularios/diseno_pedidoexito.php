<?php
header('Content-Type: text/html; charset=utf-8');
 require_once "../vistas/parte_superior.php";
$vendedor = "EJEMPLO";
$lastid = "11111";
$nuevoregistroorden = "111";



echo "
  <script src='https://cdn.jsdelivr.net/npm/sweetalert2@10'></script>
  <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css'>
  <script>
    Swal.fire({
      title: 'Pedido Ingresado con éxito',
      html: `Vendedor: " . $vendedor . "<br>
      Numero de Pedido: " . $lastid . "<br>
      Numero de Orden: " . $nuevoregistroorden . "<br>
      <img width='30%' src='img/okimg.png'> `,
      icon: 'success',
      showCancelButton: false,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Finalizar Pedido',
      confirmButtonColor: '#fd7e14',
      cancelButtonText: 'Cerrar',
      showCloseButton: true,
      focusConfirm: false,
      html:
        `
         <div style='text-align: center; margin-bottom: 1.5rem;'>
          <a href='agregarpedido.php?num_orden=" . $nuevoregistroorden . "' class='btn btn-info btn-sm' style='margin-right: 5px;color:white;'>Agregar un pedido a la orden anterior</a>
        </div>

        <div style='text-align:center; '>
          <a href='agregarpedido.php' class='btn btn-success btn-sm'>Agregar un nuevo pedido</a>
        </div>
       
        `,
        
      allowOutsideClick: false
    }).then((result) => {
      if (result.isConfirmed) {
        // Aquí puedes realizar la acción de finalización del pedido y enviar el correo
        Swal.fire({
          title: 'Pedido finalizado',
          text: 'El pedido se ha finalizado correctamente',
          icon: 'success',
          html:
        `
        <div style='text-align:center; margin-top: 10px;'>
          <a href='reportes/pedido.php?id=" . $nuevoregistroorden . "' class='btn btn-primary btn-sm'>Imprimir Comprobante</a> 
        </div> `,
          showConfirmButton: true,
          allowOutsideClick: false
        }).then(() => {
          window.location.href = 'agregarpedido.php';
        });
      }
    });
  </script>";



  ?>


<?php





 require_once "../vistas/parte_inferior.php";
  ?>

 

