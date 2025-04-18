<?php require_once "init.php" ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pedidos</title>
  

     <!-- Fuentes e íconos -->
<link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">  
     <!-- Fuentes e íconos  -->
  <script src="https://kit.fontawesome.com/c5b4401310.js" crossorigin="anonymous"></script>
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link href="https://www.respaldoschile.cl/assets/img/favicon.png" rel="icon">

  <!-- Estilos principales -->
  <link href="css/sb-admin-2.min.css" rel="stylesheet"> 
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  <!-- Librerías adicionales -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@latest/dist/flatpickr.min.css">
  <script src="https://cdn.jsdelivr.net/npm/flatpickr@latest/dist/flatpickr.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.1/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.1/dist/sweetalert2.all.min.js"></script>

   <!-- <link rel="stylesheet" type="text/css" href="css/design_respaldoschile.css">  -->

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="https://cdn.datatables.net/1.11.1/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/rowgroup/1.1.3/js/dataTables.rowGroup.min.js"></script>

</head>

<body>
<?php require_once "vistas/parte_superior.php";

include_once '../bd/conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();?>



    <h1>Bodega</h1>





<div class="container-fluid" style="padding:15px; text-align: center; overflow: auto;  width: 1300px; background-color: #F5F5F5;" >


<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap5.min.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/rowreorder/1.2.8/css/rowReorder.dataTables.min.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/searchbuilder/1.1.0/css/searchBuilder.dataTables.min.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
 <link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet">
   <link href="https://cdn.datatables.net/select/1.3.3/css/select.dataTables.min.css" rel="stylesheet">
   <link href="https://cdn.datatables.net/datetime/1.1.0/css/dataTables.dateTime.min.css" rel="stylesheet">
   <link href="libs/Editor-2.0.4/css/editor.dataTables.min.css" rel="stylesheet">

 <script type="text/javascript"  src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<!-- <script type="text/javascript"  src="https://cdn.datatables.net/1.10.25/js/dataTables.dataTables.min.js"></script> -->
<script type="text/javascript"  src="https://cdn.datatables.net/rowreorder/1.2.8/js/dataTables.rowReorder.min.js"></script>
<script type="text/javascript"  src="https://cdn.datatables.net/searchbuilder/1.1.0/js/dataTables.searchBuilder.min.js"></script>
<!-- <script type="text/javascript"  src="https://editor.datatables.net/extensions/Editor/js/dataTables.editor.min.js"></script> -->
<script type="text/javascript"  src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript"  src="https://cdn.datatables.net/select/1.3.3/js/dataTables.select.min.js"></script>

<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.3/js/buttons.html5.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/rowgroup/1.1.3/js/dataTables.rowGroup.min.js"></script>





  <div class="table-responsive">
    <table id="tabla-bodega" class="table table-striped table-bordered table-condensed" style=" font-size: 1rem;">
        <thead class="text-center">
            <tr>
                <th data-field="checkbox" style="width: 1rem;"><input type="checkbox" id="checkAll"></th>
                <th data-field="id" style="width: 1rem;">Id</th>
                <th data-field="Producto" style="width: 4rem;">Producto</th>
                <th data-field="Detalles" style="width: 7rem;">Detalles</th>
                <th data-field="Nombre Interno" style="width: 7rem;">Nombre Interno</th>
                <th data-field="Marca" style="width: 6rem;">Marca</th>
                <th data-field="Marca" style="width: 3rem;">Bodega</th>
                <th data-field="Costo" style="width: 1rem;">Costo</th>
                <th data-field="Cantidad" style="width: 1rem;">Cantidad</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $consulta = "SELECT * FROM productos_bodega pb LEFT JOIN bodega b ON pb.id_prod = b.id_producto ORDER BY pb.id_prod";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
            $datt = $resultado->fetchAll(PDO::FETCH_ASSOC);

            foreach ($datt as $rdat) {
               
                    $cantidad = $rdat['cantidad'];
               

                // Agregar clase CSS "table-danger" si la cantidad es menor a 10
                $filaClase = '';
                if ($cantidad < 10) {
                    $filaClase = 'table-danger'; // Rojo
                } elseif ($cantidad < 30) {
                    $filaClase = 'table-warning'; // Amarillo
                }
                ?>
                <tr class="<?php echo $filaClase; ?>">
                    <td style="height: 10px; padding: 1px;">
                        <input type="checkbox" name="selectedItems[]" class="itemCheckbox" value="<?php echo $rdat['id_prod']; ?>">
                    </td>
                    <td style="height: 10px; padding: 1px;"><?php echo $rdat['id_prod']; ?></td>
                    <td style="height: 10px; padding: 1px;"><?php echo $rdat['producto']; ?></td>
                    <td style="height: 10px; padding: 1px;"><?php echo $rdat['material'] . " " . $rdat['detalle']; ?></td>
                    <td style="height: 10px; padding: 1px;"><?php if($rdat['nombre_interno'] != ""){ echo $rdat['nombre_interno'];} else{ echo $rdat['detalle'];} ?></td>
                    <td style="height: 10px; padding: 1px;"><?php echo $rdat['marca']; ?></td>
                    <td style="height: 10px; padding: 1px;"><?php echo $rdat['sector_id']; ?></td>
                    <td style="height: 10px; padding: 1px;"><?php echo $rdat['costo']; ?></td>
                    <td style="height: 10px; padding: 1px;"><?php echo $cantidad; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<button id="generateNoteBtn" class="btn btn-primary">Generate Purchase Note</button>

<script>
    $(document).ready(function() {
        $(document).ready(function() {
        var table = $('#tabla-bodega').DataTable({
            dom: 'Bfrtip',
            iDisplayLength: 30,
            buttons: [

{
     extend: 'print',
     text: 'Imprimir Ruta'
    },  {
            extend: 'excel',
            text: 'Exportar a excel',
            filename: 'telas', 
        }
            ],
            language: {
                search: "Buscar:",
                zeroRecords: "No se encontraron resultados.",
                infoEmpty: "Mostrando 0 de 0 elementos",
                infoFiltered: "(filtrados de _MAX_ elementos totales)",
                lengthMenu: "Mostrar _MENU_ elementos por página",
                paginate: {
                    first: "Primero",
                    last: "Último",
                    next: "Siguiente",
                    previous: "Anterior"
                }
            },
            pagingType: "full_numbers"
        });

        $('#checkAll').click(function() {
            $('.itemCheckbox').prop('checked', $(this).prop('checked'));
        });

        $('#generateNoteBtn').click(function() {
            var selectedItems = [];
            $('.itemCheckbox:checked').each(function() {
                selectedItems.push($(this).val());
            });

            console.log(selectedItems);
        });
    });
});
</script>




</div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Respaldos Chile 2023</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">¿Confirma salir y cerrar Sesión?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body"></div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
          <a class="btn btn-primary" href="../bd/logout.php">Salir</a>
  
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->

  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>



  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- código propio JS --> 
    <script type="text/javascript" src="main.js"></script>  
    

      <!-- código propio JS --> 
      <script type="text/javascript" src="main.js"></script>  
    
    

    

    </body>
    
    </html>
    

