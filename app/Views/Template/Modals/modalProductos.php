<!-- Modal -->
<div class="modal fade" id="modalFormProductos" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl" >
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal">Nuevo Producto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form id="formProductos" name="formProductos" enctype="multipart/form-data" class="form-horizontal">
      <input type="hidden" id="idProducto" name="idProducto" value="">
              <p class="text-primary">Los campos con asterisco (<span class="required">*</span>) son obligatorios.</p>
              <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                      <label class="control-label">Nombre Producto s <span class="required">*</span></label>
                      <input class="form-control" id="txtNombre" name="txtNombre" type="text" required="">
                    </div>
                    <div class="form-group">
                      <label class="control-label">Descripción Producto</label>
                      <textarea class="form-control" id="txtDescripcion" name="txtDescripcion" ></textarea>
                    </div>
                    
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label">Código <span class="required">*</span></label>
                        <input class="form-control" id="txtCodigo" name="txtCodigo" type="text" placeholder="Código de barra" required="">
                        <br>
                        <div id="divBarCode" class="notblock textcenter">
                            <div id="printCode">
                                <svg id="barcode"></svg> 
                            </div>
                            <button class="btn btn-success btn-sm" type="button" onClick="fntPrintBarcode('#printCode')"><i class="fas fa-print"></i> Imprimir</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="control-label">Precio <span class="required">*</span></label>
                            <input class="form-control" id="txtPrecio" name="txtPrecio" type="text" >
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label">Stock <span class="required">*</span></label>
                            <input class="form-control" id="txtStock" name="txtStock" type="text" required="">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="listCategoria">Categoría <span class="required">*</span></label>
                            <select class="form-control" data-live-search="true" id="listCategoria" name="listCategoria" required=""></select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="listStatus">Estado <span class="required">*</span></label>
                            <select class="form-control selectpicker" id="listStatus" name="listStatus" required="">
                              <option value="1">Activo</option>
                              <option value="2">Inactivo</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6" style="background-color:#FF9696;">
                    <label><input type="checkbox" id="precio_unico" name="precio_unico" value="1"> Producto Precio unico</label><br>
                    </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="listColores">Materiales disponibles <span class="required">*</span></label>
                            <div id="listColores" name="listColores"></div>
                        </div>
                        
                    </div>

                    <div class="row" id="altura_base" style="display: none;">
                        <div class="form-group col-md-6">
                            <label for="listAlturas">Altura Base <span class="required">*</span></label>
                            <div id="listAlturas" name="listAlturas"></div>
                        </div>
                        
                    </div>

                        <div id="precios" style="display: none;">
                            <div id="a">  Precios<span class="required">*</span>
                            </div>
                            <div class="row">
                      
                        <div class="form-group col-md-6">
                            
                           
                            <label class="control-label">1 plaza</label><input class="form-control" type="text" name="1plaza">                           
                            <label class="control-label">1 1/2</label><input class="form-control" type="text" name="plazaymedia" >
                            <label class="control-label">Full plaza</label><input class="form-control" type="text" name="full">
                            <label class="control-label">Queen</label><input class="form-control" type="text" name="queen">
                        

                                
                            </div>

                            <div class="form-group col-md-6">
 
                            <label class="control-label">2 plazas </label><input class="form-control" type="text" name="2plazas">                           
                            <label class="control-label">King </label><input class="form-control" type="text" name="king">
                            <label class="control-label">SuperKing </label><input class="form-control" type="text" name="superking">
                            </div>
                        
                        
                            </div>
                    </div>

                     <div id="precios_velador" style="display: none;">
                            <div id="a">  Precios<span class="required">AltoxAnchoxFondo</span>
                            </div>
                            <div class="row">
                      
                        <div class="form-group col-md-6">
                            
                           
                            <label class="control-label">60x50x40</label><input class="form-control" type="text" name="60x50x40">                           
                            <label class="control-label">60x50x45</label><input class="form-control" type="text" name="60x50x45" >
                            <label class="control-label">60x40x40</label><input class="form-control" type="text" name="60x40x40">
                        

                                
                            </div>

                            <div class="form-group col-md-6">
 
                            <label class="control-label">70x50x40</label><input class="form-control" type="text" name="70x50x40" >                           
                            <label class="control-label">70x50x45 </label><input class="form-control" type="text" name="70x50x45">
                            
                            </div>
                        
                        
                            </div>
                    </div>

                     <div id="producto_colores" style="display: none;">
                            <div id="a">  Colores Disponibles<span class="required"></span>
                            </div>
                            <div class="row">
                      
                        <div class="form-group col-md-6">
                            
                           
                            <label class="control-label">Color1</label><input class="form-control" type="text" name="color1">                           
                            <label class="control-label">Color2</label><input class="form-control" type="text" name="color2" >
                            <label class="control-label">Color3</label><input class="form-control" type="text" name="color3">
                            <label class="control-label">Color4</label><input class="form-control" type="text" name="color4">
                            <label class="control-label">Color5</label><input class="form-control" type="text" name="color5">

                                
                            </div>

                            <div class="form-group col-md-6">
 
                            
                            
                            </div>
                        
                        
                            </div>
                    </div>

                    <div id="precios_sofas" style="display: none;">
                            <div id="a">  Precios<span class="required"> Cant Cuerpos</span>
                            </div>
                            <div class="row">
                      
                        <div class="form-group col-md-6">
                            
                           
                            <label class="control-label">1 cuerpo</label><input class="form-control" type="text" name="cuerpo1">                           
                            <label class="control-label">2 cuerpos</label><input class="form-control" type="text" name="cuerpo2" >
                            <label class="control-label">3 cuerpos</label><input class="form-control" type="text" name="cuerpo3">
                            <label class="control-label">4 cuerpos</label><input class="form-control" type="text" name="cuerpo4">
                            <label class="control-label">5 cuerpos</label><input class="form-control" type="text" name="cuerpo5">
                        

                                
                            </div>

                            
                        
                        
                            </div>
                    </div>

                      <div id="precios_banqueta" style="display: none;">
                            <div id="a">  Precios<span class="required"> Tamaño</span>
                            </div>
                            <div class="row">
                      
                        <div class="form-group col-md-6">
                            
                           
                            <label class="control-label">Pouff 50 Alto x 50 Ancho</label><input class="form-control" type="text" name="b50x50">                           
                            <label class="control-label">90 Alto x 45 Ancho </label><input class="form-control" type="text" name="b90x45" >
                            <label class="control-label">100 Alto x 45 Ancho</label><input class="form-control" type="text" name="b100x45">
                            <label class="control-label">120 Alto x 45 Ancho</label><input class="form-control" type="text" name="b120x45">
                            <label class="control-label">150 Alto x 45 Ancho</label><input class="form-control" type="text" name="b150x45">
                            <label class="control-label">90 Alto x 35 Ancho</label><input class="form-control" type="text" name="b90x35">
                            <label class="control-label">100 Alto x 35 Ancho</label><input class="form-control" type="text" name="b100x35">
                            <label class="control-label">120 Alto x 35 Ancho</label><input class="form-control" type="text" name="b120x35">
                            <label class="control-label">150 Alto x 35 Ancho</label><input class="form-control" type="text" name="b150x35">
                        

                                
                            </div>

                            
                        
                        
                            </div>
                    </div>

                     




                    <div class="row">
                       <div class="form-group col-md-6">
                           <button id="btnActionForm" class="btn btn-primary btn-lg btn-block" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span></button>
                       </div> 
                       <div class="form-group col-md-6">
                           <button class="btn btn-danger btn-lg btn-block" type="button" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cerrar</button>
                       </div> 
                    </div>  
                </div>
              </div>
              
              <div class="tile-footer">
                 <div class="form-group col-md-12">
                     <div id="containerGallery">
                         <span>Agregar foto (440 x 545)</span>
                         <button class="btnAddImage btn btn-info btn-sm" type="button">
                             <i class="fas fa-plus"></i>
                         </button>
                     </div>
                     <hr>
                     <div id="containerImages">
                         <!-- <div id="div24">
                             <div class="prevImage">
                                 <img src="<?= media(); ?>/images/uploads/producto1.jpg">
                             </div>
                             <input type="file" name="foto" id="img1" class="inputUploadfile">
                             <label for="img1" class="btnUploadfile"><i class="fas fa-upload "></i></label>
                             <button class="btnDeleteImage" type="button" onclick="fntDelItem('div24')"><i class="fas fa-trash-alt"></i></button>
                         </div>
                         <div id="div24">
                             <div class="prevImage">
                                 <img class="loading" src="<?= media(); ?>/images/loading.svg">
                             </div>
                             <input type="file" name="foto" id="img1" class="inputUploadfile">
                             <label for="img1" class="btnUploadfile"><i class="fas fa-upload "></i></label>
                             <button class="btnDeleteImage" type="button" onclick="fntDelItem('div24')"><i class="fas fa-trash-alt"></i></button>
                         </div> -->
                        
                     </div>
                 </div>
                                
              </div>
            </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalViewProducto" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl" >
    <div class="modal-content">
      <div class="modal-header header-primary">
        <h5 class="modal-title" id="titleModal">Datos del Producto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered">
          <tbody>
            <tr>
              <td>Codigo:</td>
              <td id="celCodigo"></td>
            </tr>
            <tr>
              <td>Nombres:</td>
              <td id="celNombre"></td>
            </tr>
            <tr>
              <td>Precio:</td>
              <td id="celPrecio"></td>
            </tr>
            <tr>
              <td>Stock:</td>
              <td id="celStock"></td>
            </tr>
            <tr>
              <td>Categoría:</td>
              <td id="celCategoria"></td>
            </tr>
            <tr>
              <td>Status:</td>
              <td id="celStatus"></td>
            </tr>
            <tr>
              <td>Descripción:</td>
              <td id="celDescripcion"></td>
            </tr>
            <tr>
              <td>Fotos de referencia:</td>
              <td id="celFotos">
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

