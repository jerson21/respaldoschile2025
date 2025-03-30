<?php require_once "vistas/parte_superior.php"?>

<!--INICIO del cont principal-->
<div class="container" style=" max-width: 400rem; width: 200rem; ">
    <h1>Pedidos</h1>
</div>

<?php 
include_once 'bd/conexion.php';
$objeto1 = new Conexion();
$conexion = $objeto1->Conectar();

$consulta = "SELECT *  from rutas";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data=$resultado->fetchAll(PDO::FETCH_ASSOC);





  


  $cadena="<label>Rutas Disponibles </label><br> 
      <form action='' method='GET'>
      <select  id='rutas' name='rutas'>
<option value='-1'>Seleccionar una ruta</option> ";
  foreach ($data as $ver) {
    $fecha = $ver['fecha'];
    $idruta = $ver['id'];
    $fecha = fechaCastellano($fecha);

    

  $consulta2 = "SELECT comuna from pedidos where ruta_asignada = $idruta group by comuna";
$resultado = $conexion->prepare($consulta2);
$resultado->execute();
$data2=$resultado->fetchAll(PDO::FETCH_ASSOC);


 $comuna = "";

   foreach ($data2 as $ver2) {
    $comuna .= ', '.strtoupper($ver2['comuna']);
    
  }

    $cadena=$cadena.'<option value='.$ver['id'].'>'.$ver['id'].' - '.$fecha.' '.$comuna.'</option>';
  }

  
  echo  $cadena."</select><input type='submit' value='Ingresar'></form><br><br>";

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

<script type="text/javascript">

    
// recargarLista();



$(document).ready(function() {
var idruta = <?php echo $_GET['rutas']; ?>;

var tabla_usuarios = $('#tablapedidosenruta2').DataTable({
  iDisplayLength: 50,
dom: 'Bfrtip',
    buttons: [

       {
            extend: 'print',
            text: 'Imprimir Ruta',
            exportOptions: {
                    columns: [ 1, 2, 3,4,5,6,7,8,9,10,11,14 ]
                },
                
                messageBottom: 'www.RespaldosChile.cl',
                customize: function(window) {
    $(window.document.body).children().eq(0).after('<div style="text-align:center;"><img src="https://www.respaldoschile.cl/img/logorespaldos.png" width="200px"></div><div> Numero de Ruta: <?php echo $_GET['id']; ?><br> Despachador Asignado: Nombre despachador <br> Fecha de ruta: 00-00-0000</div>');
  }

        },

        {
            extend: 'excel',
            text: 'Exportar a excel'
        },
        {
            extend: 'pdf',
            text: 'Generar PDF'
        }


         
    ],

  "language": {
          "sProcessing":     "Procesando...",
          "sLengthMenu":     "Mostrar _MENU_ registros",
          "sZeroRecords":    "No se encontraron resultados",
          "sEmptyTable":     "Ningún dato disponible en esta tabla",
          "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
          "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
          "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
          "sInfoPostFix":    "",
          "sSearch":         "Buscar:",
          "sUrl":            "",
          "sInfoThousands":  ",",
          "sLoadingRecords": "Cargando...",
          "oPaginate": {
            "sFirst":    "Primero",
            "sLast":     "Último",
            "sNext":     "Siguiente",
            "sPrevious": "Anterior"
          } },
      
      "ajax":{ url:"cargar_pedidos_enruta.php", type:"post",  data : { "id" : idruta },
        "columns": [
             
             { "data": "id" },
            { "data": "rut_cliente" },
            { "data": "modelo" },
            { "data": "plazas" },
            { "data": "tipotela" },
            { "data": "color" },
            { "data": "alturabase" },
            { "data": "direccion" },
            { "data": "comuna" },
            { "data": "telefono"  },
            { "data": "instagram" },
            { "data": "mododepago" },
            { "data": "precio" },
            { "data": "comentarios" },,
            
            
            {
                data: null,
                className: "dt-center editor-edit",
                defaultContent: '<i class="fa fa-pencil"/>',
                orderable: false
            },

            
        ]
        },
        select: true,
        
        rowReorder: {
          selector: "td:first-child",
          dataSrc: 0,
      },
     
      
        

          

      initComplete: function () {


            this.api().columns([3,4,5]).every( function () {
                var column = this;
                var select = $('<select><option value=""></option></select>')
                    .appendTo( $(column.footer()).empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
 
                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );
 
                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                } );
              })
          }

      });
            //tabla_usuarios.columns( [0] ).visible( false );

         tabla_usuarios.on("row-reorder", function (e, diff, edit) {
        var result = 'Reorder started on row: '+edit.triggerRow.data()[0]+'<br>';

        for (var i=0, ien=diff.length ; i<ien ; i++) {
            var rowData = tabla_usuarios.row( diff[i].node ).data();

            result += rowData[2]+' se actualizo a la posicion '+
                diff[i].newData+' (was '+diff[i].oldData+')<br>';
                var nuevoordenvar = diff[i].newData;
                actualizarorden();
        }

function actualizarorden(){
$.ajax({
        url: 'actualizarorden.php',
        
        type:"POST",
        data: {id: rowData[2],nuevoorden: nuevoordenvar},
        

        success: function(response) {
          if(response == 1){
                    alert(_TOTAL_registros);
                    
                  }
          
        }
      })
}



        //$('#result').html('Event result:<br>'+result);

        // Actualizamos en BD

                
    }); 

      
    } );


</script>

     <div id="pedidos"></div>
     	 <div class="container" style="display:inline-block; margin:0 auto;padding: 10px; ">
        <div class="row">
                <div class="col-lg-12" >
                    <div class="table-responsive" style="margin:0; width: 100rem;">        
                        <table id="tablapedidosenruta2" class="table table-striped table-bordered table-condensed" style="width:100%; font-size:0.8rem; ">
                        <thead class="text-center">
                            <tr>

                                
                                <th>Id</th>
                                <th style="width:3rem;">Rut Cliente</th>
                                <th style="width:7rem;">Modelo</th>                                
                                <th>Plazas</th>  
                                <th style="max-width:2rem;">Alt</th>
                                <th>Tela</th>
                                <th style="width:7rem;">Color</th>
                                 <th style="width:7rem;">Direccion</th>
                                  <th style="width:2rem;">Nº</th>
                                   <th style="width:7rem;">Comuna</th>
                                   <th style="width:3rem;">Telefono</th>
                                
                                <th style="width:5rem;">Estado Pedido</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        


                        </table>
                    </div>
                </div>
            </div>
        </div>

   




<!-- PEDIDOS DISPONIBLES -->

    
 <?php

$objeto = new Conexion();
$conexion = $objeto->Conectar();

$consulta = "SELECT * FROM pedidos where ruta_asignada = 0 ORDER BY id and rut_cliente";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data=$resultado->fetchAll(PDO::FETCH_ASSOC);


$consulta2 = "SELECT * FROM pedidos GROUP BY num_orden HAVING COUNT(num_orden) > 1 ORDER BY num_orden asc";

$resultado2 = $conexion->prepare($consulta2);
$resultado2->execute();
$data2 = $resultado2->fetchAll(PDO::FETCH_ASSOC);

foreach($data2 as $dat){
    
    $numeros_deorden[] = $dat['num_orden'];
}


        
     


?>


     
    <div class="container " style="display:inline-block; margin:0 auto; margin-top: 2rem; padding: 10px; ">
    		<div class="alert alert-success" style="text-align: center !important; margin:0 auto!important;">Pedidos Disponibles:</div>
    </div>
<div class="container" style="display:inline-block; padding: 10px; ">

 
    <br>  
        <div class="row">
                <div class="col-lg-12" >
                    <div class="table-responsive" style="margin:0; width: 100rem;">        
                        <table id="tablaPersonas" class="table table-striped table-bordered table-condensed" style="width:100%; font-size:0.8rem; ">
                        <thead class="text-center">
                            <tr>

                                
                                <th>Id</th>
                                <th style="width:3rem;">Rut Cliente</th>
                                <th style="width:7rem;">Modelo</th>                                
                                <th>Plazas</th>  
                                <th style="max-width:2rem;">Alt</th>
                                <th>Tela</th>
                                <th style="width:7rem;">Color</th>
                                 <th style="width:7rem;">Direccion</th>
                                  <th style="width:2rem;">Nº</th>
                                   <th style="width:7rem;">Comuna</th>
                                   <th style="width:3rem;">Telefono</th>
                                
                                <th style="width:5rem;">Estado Pedido</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php                            
                            foreach($data as $dat) {                                                        
                            ?>
                            <tr>
<?php
$numerodeorden = $dat['num_orden'];

if (in_array($numerodeorden, $numeros_deorden)) { ?>
                                
                                <td style="height:10px; padding: 1px; background-color: rgba(0, 145, 71, 0.1);"><?php echo $dat['id'] ?></td>
                                <td style="height:10px; padding: 1px; background-color: rgba(0, 145, 71, 0.1);"><?php echo $dat['rut_cliente'] ?></td>
<?php }else{?>
                               
                                
                                <td style="height:10px; padding: 1px; "><?php echo $dat['id'] ?></td>
                                <td style="height:10px; padding: 1px; "><?php echo $dat['rut_cliente'] ?></td>
<?php }


?>
                                
                                
                                <td style="height:10px; padding: 1px;"><?php echo $dat['modelo'] ?></td>
                                <td style="height:10px; padding: 1px;"><?php echo $dat['plazas'] ?></td> 
                                <td style="height:10px; padding: 1px;"><?php echo $dat['alturabase'] ?></td>
                                <td style="height:10px; padding: 1px;"><?php echo $dat['tipotela'] ?></td>
                                <td style="height:10px; padding: 1px;" ><?php echo $dat['color'] ?></td>
                                <td style="height:10px; padding: 1px;"><?php echo $dat['direccion'] ?></td>
                                 <td style="height:10px; padding: 1px;" ><?php echo $dat['numero'] ?></td>
                                  <td style="height:10px; padding: 1px;" ><?php echo $dat['comuna'] ?></td>
                                  <td style="height:10px; padding: 1px;"><?php echo $dat['telefono'] ?></td>
                                
                                <td style="height:10px; padding: 1px;"><?php if($dat['estadopedido'] == "1"){
                                   echo "<div class='text-center' ><div class='btn-group'><button class='btn btn-secondary btnEditarestado' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Aceptado</button></div>";
                                }elseif($dat['estadopedido'] == "2"){
                                    echo "<div class='text-center' ><div class='btn-group'><button class='btn btn-info btnEditarestado' id='parpadea' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>En Fabricacion</button></div>";
                                }elseif($dat['estadopedido'] == "0"){ 
                                    echo "<div class='text-center' ><div class='btn-group'><button class='btn btn-warning btnEditarestado' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>No Aceptado</button></div>";
                                }
                                elseif($dat['estadopedido'] == "3"){
                                    echo "<div class='text-center' ><div class='btn-group'><button class='btn btn-info btnEditarestado' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Pedido Listo</button></div>";
                                }
                                elseif($dat['estadopedido'] == "9"){
                                    echo "<div class='text-center' ><div class='btn-group'><button class='btn btn-warning btnEditarestado' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Reagendar</button></div>";
                                }



                            ?></td>   
                                <td style="height:10px; padding: 1px;"></td>
                            </tr>
                            <?php
                                }
                            ?>                                
                        </tbody>        
                       </table>                    
                    </div>
                </div>
        </div>  
    </div>    
      
<!--Modal para CRUD Editar estado de compra-->
<div class="modal fade" id="modalCRUD" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>
        <form id="editarestado">    
            <div class="modal-body">
                <div class="form-group">
                <label for="id" class="col-form-label">Cod:</label>
                <input type="text" class="form-control" id="id" readonly>
                </div>
                <div class="form-group">
                <select name="estado" id="estado" class="form-control" >
                    <option value="" disabled selected>Selecciona Estado</option>
                    <option value="1">Aceptar Compra</option>
                    <option value="2">Enviar a Fabricación</option>
                    <option value="3">Pedido Listo</option>
                    <option value="9">Reagendar</option>
                  </select>
                </div>                
                            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                <button type="submit" id="btnGuardar" class="btn btn-dark">Guardar</button>
            </div>
        </form>    
        </div>
    </div>
</div>  

<!--Modal para CRUD EDITAR PEDIDO-->
<div class="modal fade" id="modalEditarPedido" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>
        <form id="editarpedido">    
            <div class="modal-body">
                <div class="form-group">
                <label for="id" class="col-form-label">Cod:</label>
                <input type="text" class="form-control" id="ide" name="ide" readonly>
                </div>
                <div class="form-group">
                <label for="id" class="col-form-label">Rut:</label>
                <input type="text" class="form-control" id="rut" name="rut">
                </div>
                <div class="row gy-4">
                    <div class="col-lg-4">
                <label for="modelo" class="col-form-label">Modelo:</label>
                <input type="text" class="form-control" id="modelo" name="modelo">
                </div>
                <div class="col-lg-4">
                <label for="plazas" class="col-form-label">Plazas:</label>
                <input type="text" class="form-control" id="plazas" name="plazas">
                </div>
                <div class="col-lg-4">
                <label for="tela" class="col-form-label">Tela:</label>
                <input type="text" class="form-control" id="tela" name="tela">
                </div>
                    <div class="col-lg-4">
                <label for="color" class="col-form-label">Color:</label>
                <input type="text" class="form-control" id="color" name="color">
                </div>
                <div class="col-lg-4">
                <label for="color" class="col-form-label">Altura:</label>
                <input type="text" class="form-control" id="alturabase" name="alturabase">
                </div>
                <div class="col-lg-4">
                <label for="color" class="col-form-label">Telefono:</label>
                <input type="text" class="form-control" id="telefono" name="telefono">
                </div>
                </div> 
                 <div class="row gy-4">
                <div class="col-lg-4">
                <label for="color" class="col-form-label">Direccion:</label>
                <input type="text" class="form-control" id="direccion" name="direccion">
                </div>
                <div class="col-lg-4">
                <label for="color" class="col-form-label">Num:</label>
                <input type="text" class="form-control" id="numero" name="numero">
                </div>
                <div class="col-lg-4">
                <label for="color" class="col-form-label">Comuna:</label>
                <input type="text" class="form-control" id="comuna" name="comuna">
                </div>
                 </div>
                    
                               
                            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                <button type="submit" id="btnGuardar" class="btn btn-dark">Guardar</button>
            </div>
        </form>    
        </div>
    </div>
</div>  
      
    
    


<?php require_once "vistas/parte_inferior.php"?>