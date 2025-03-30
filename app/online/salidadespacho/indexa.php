<!DOCTYPE html>
        <html>
          <head>
            <title>Instascan</title>
            <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/3.3.3/adapter.min.js"></script>
      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.min.js"></script>
      <script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js" integrity="sha384-THPy051/pYDQGanwU6poAc/hOdQxjnOEXzbT+OuUAFqNqFjL+4IGLBgCJC3ZOShY" crossorigin="anonymous"></script>
          </head>
          <body>
            <div class="container">
                <div style="text-align: center;"> <img src="https://www.respaldoschile.cl/img/logorespaldos.png" width="200rem;"> </div>
                <div class="row">
                    <div class="col-md-6">
                        <video id="preview" width="100%"></video>
                    </div>
                    <div class="col-md-6">
                        <label>Codigo Leido</label>
                        <input type="text" name="text" id="text" readonyy="" placeholder="scan qrcode" class="form-control">
                    </div>



                </div>
                <div>
                  <form action="" method="get">
                   <?php 
                   include("conexion.php");
$sql="SELECT *  from rutas";


  $result=mysqli_query($conn,$sql);


  $cadena="<label>Rutas Disponibles </label><br> 
      <select  id='rutas' name='rutas'>
<option value='-1'>Seleccionar una ruta</option> ";
  while ($ver=mysqli_fetch_row($result)) {
    $fecha = $ver[1];
    $idruta = $ver[0];
    $fecha = fechaCastellano($fecha);

    $sql2="SELECT comuna from pedidos where ruta_asignada = $idruta";

  $result2=mysqli_query($conn,$sql2);


 $comuna = "";

  while ($ver2=mysqli_fetch_row($result2)) {
    $comuna .= ', '.$ver2[0];
    
  }

    $cadena=$cadena.'<option value='.$ver[0].'>'.$ver[0].' - '.$fecha.' '.$comuna.'</option>';
  }

  echo  $cadena."</select><br><br>";

  function fechaCastellano ($fecha) {
  $fecha = substr($fecha, 0, 10);
  $numeroDia = date('d', strtotime($fecha));
  $dia = date('l', strtotime($fecha));
  $mes = date('F', strtotime($fecha));
  $anio = date('Y', strtotime($fecha));
  $dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
  $dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
  $nombredia = str_replace($dias_EN, $dias_ES, $dia);
$meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
  $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
  $nombreMes = str_replace($meses_EN, $meses_ES, $mes);
  return $nombredia." ".$numeroDia." de ".$nombreMes." de ".$anio;
}


                    ?>
                    <input type="submit">
                  </form>
                </div>
            </div>

            <form action=""  method="post" name="formulario-busqueda" id="formulario-busqueda">
            <input type="text" class="form-control producto" name="codigo" id="codigo" autofocus="on" autocomplete="off" onchange="validarsalida()" >
          </form>


            <script type="text/javascript">

function validar(){


}


              
               
              

                 
function validarsalida(){
               var codigo = document.getElementById('codigo').value;
                

                var ruta = <?php echo $_GET['rutas']; ?> ;
               $.ajax({
              url :"validarsalida.php",
              type:"POST",
              
              
              data:{id:codigo,ruta:ruta},
              success:function(r){
                alert(r);


              },
                              error:function(){

                                 alert("error");

                              }
              });


                }

              

            </script>
          </body>
        </html>
        