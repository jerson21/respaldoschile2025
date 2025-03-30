  <?php
  
include("conexion.php");

  $num_orden = $_GET["num_orden"];
    


    $strsql = "SELECT * FROM orden where num_orden = $num_orden";
    $rs = mysqli_query($conn, $strsql);
    $total_rows = $rs->num_rows;
    $data = array();   
while( $row=mysqli_fetch_array($rs) ) {
$rut_cliente = $row['rut_cliente'];
$direccion = $row['direccion'];
$telefono = $row['telefono'];
$numero = $row['numero'];
$dpto = $row['dpto'];
$correo = $row['correo'];
$instagram = $row['instagram'];
}

$strsqls = "SELECT * FROM clientes WHERE rut = '$rut_cliente'";
    $rss = mysqli_query($conn, $strsqls);
    $total_rows = $rs->num_rows;
    
while($arow=mysqli_fetch_array($rss) ) {

$nombre = $arow['nombre'];

}
 ?>

 <div id="a" class="a" >

              <div class="row gy-4">
<div class="col-md-6">
  <input type="hidden" name="modelo_nuevo" value="Base de Cama">
                  Seleccionar las plazas 
                  <select class="form-select" name="plazas_nuevo" aria-label="Default select example">
                  <option selected>Seleccionar las plazas</option>
                  <option value="1">1 plaza</option>
                  <option value="1 1/2">1 1/2</option>
                  <option value="Full">Full</option>
                  <option value="2">2 Plazas</option>
                  <option value="Queen">Queen</option>
                  <option value="King">King</option>
                  <option value="Super King">Super King</option>
                </select>
                </div>

                <div class="col-md-6">
                  Seleccionar Largo 
                  <select class="form-select" name="alturabase_nuevo" aria-label="Default select example">
                  <option selected>Seleccionar Largo</option>
                  <option value="1.90mt">1.90</option>
                  <option value="2Mt">2 Metros</option>
                  
                  
                  
                </select>
                </div>
                 <div class="col-md-6">
                  Seleccionar tipo de tela
                  <select id="listatelas" name="listatelas" class="form-select" aria-label="Default select example"  required>                  
                  <option value="lino">Lino</option>                  
                  <option value="felpa">Felpa</option>
                  <option value="mosaico">Felpa Mosaico</option>
                  <option value="ecocuero">Eco Cuero</option>
                </select>
                </div>

                <div class="col-md-6" id="select2lista">

                  
                </div>

                

                

              
                
                
               

<script type="text/javascript">
   function establecerVisibilidadImagen(id, visibilidad) {
var img = document.getElementById(id);
img.style.visibility = (visibilidad ? 'visible' : 'hidden');
}


</script>
<script type="text/javascript">
  $(document).ready(function(){
    $('#listatelas').val(1);
    


    
// recargarLista();

    $('#listatelas').change(function(){
      recargarLista();
      recargarListaImg();

    });

     $("#select2lista").change(function(){
      

     });
  })
</script>
<script type="text/javascript">

  function recargarLista(){
    $.ajax({
      type:"POST",
      url:"formularios/datos.php",
      data:"colores=" + $('#listatelas').val(),

      success:function(r){

        $('#select2lista').html(r);
        
      }
    });
  }
</script>

<script type="text/javascript">
   
 
      function recargarListaImg(){
      
      $.ajax({

                data: "color=" + $('#listatelas').val(),
                url:   'formularios/ajax_colores.php',
                type:  'post',  
                datatype: 'html',              
                success:function (datahtml) {                 
                    
                    
                    $("#imagencolor").html(datahtml);
                    

                },
                error:function(){
                   alert("Error seleccionando el tipo de tela");

                }
            });
} 
</script>


<script type="text/javascript">
var RegionesYcomunas = {

  "regiones": [{
      "NombreRegion": "Arica y Parinacota",
      "comunas": ["Arica", "Camarones", "Putre", "General Lagos"]
  },
    {
      "NombreRegion": "Tarapacá",
      "comunas": ["Iquique", "Alto Hospicio", "Pozo Almonte", "Camiña", "Colchane", "Huara", "Pica"]
  },
    {
      "NombreRegion": "Antofagasta",
      "comunas": ["Antofagasta", "Mejillones", "Sierra Gorda", "Taltal", "Calama", "Ollagüe", "San Pedro de Atacama", "Tocopilla", "María Elena"]
  },
    {
      "NombreRegion": "Atacama",
      "comunas": ["Copiapó", "Caldera", "Tierra Amarilla", "Chañaral", "Diego de Almagro", "Vallenar", "Alto del Carmen", "Freirina", "Huasco"]
  },
    {
      "NombreRegion": "Coquimbo",
      "comunas": ["La Serena", "Coquimbo", "Andacollo", "La Higuera", "Paiguano", "Vicuña", "Illapel", "Canela", "Los Vilos", "Salamanca", "Ovalle", "Combarbalá", "Monte Patria", "Punitaqui", "Río Hurtado"]
  },
    {
      "NombreRegion": "Valparaíso",
      "comunas": ["Valparaíso", "Casablanca", "Concón", "Juan Fernández", "Puchuncaví", "Quintero", "Viña del Mar", "Isla de Pascua", "Los Andes", "Calle Larga", "Rinconada", "San Esteban", "La Ligua", "Cabildo", "Papudo", "Petorca", "Zapallar", "Quillota", "Calera", "Hijuelas", "La Cruz", "Nogales", "San Antonio", "Algarrobo", "Cartagena", "El Quisco", "El Tabo", "Santo Domingo", "San Felipe", "Catemu", "Llaillay", "Panquehue", "Putaendo", "Santa María", "Quilpué", "Limache", "Olmué", "Villa Alemana"]
  },
    {
      "NombreRegion": "Región del Libertador Gral. Bernardo O’Higgins",
      "comunas": ["Rancagua", "Codegua", "Coinco", "Coltauco", "Doñihue", "Graneros", "Las Cabras", "Machalí", "Malloa", "Mostazal", "Olivar", "Peumo", "Pichidegua", "Quinta de Tilcoco", "Rengo", "Requínoa", "San Vicente", "Pichilemu", "La Estrella", "Litueche", "Marchihue", "Navidad", "Paredones", "San Fernando", "Chépica", "Chimbarongo", "Lolol", "Nancagua", "Palmilla", "Peralillo", "Placilla", "Pumanque", "Santa Cruz"]
  },
    {
      "NombreRegion": "Región del Maule",
      "comunas": ["Talca", "ConsVtución", "Curepto", "Empedrado", "Maule", "Pelarco", "Pencahue", "Río Claro", "San Clemente", "San Rafael", "Cauquenes", "Chanco", "Pelluhue", "Curicó", "Hualañé", "Licantén", "Molina", "Rauco", "Romeral", "Sagrada Familia", "Teno", "Vichuquén", "Linares", "Colbún", "Longaví", "Parral", "ReVro", "San Javier", "Villa Alegre", "Yerbas Buenas"]
  },
    {
      "NombreRegion": "Región del Biobío",
      "comunas": ["Concepción", "Coronel", "Chiguayante", "Florida", "Hualqui", "Lota", "Penco", "San Pedro de la Paz", "Santa Juana", "Talcahuano", "Tomé", "Hualpén", "Lebu", "Arauco", "Cañete", "Contulmo", "Curanilahue", "Los Álamos", "Tirúa", "Los Ángeles", "Antuco", "Cabrero", "Laja", "Mulchén", "Nacimiento", "Negrete", "Quilaco", "Quilleco", "San Rosendo", "Santa Bárbara", "Tucapel", "Yumbel", "Alto Biobío", "Chillán", "Bulnes", "Cobquecura", "Coelemu", "Coihueco", "Chillán Viejo", "El Carmen", "Ninhue", "Ñiquén", "Pemuco", "Pinto", "Portezuelo", "Quillón", "Quirihue", "Ránquil", "San Carlos", "San Fabián", "San Ignacio", "San Nicolás", "Treguaco", "Yungay"]
  },
    {
      "NombreRegion": "Región de la Araucanía",
      "comunas": ["Temuco", "Carahue", "Cunco", "Curarrehue", "Freire", "Galvarino", "Gorbea", "Lautaro", "Loncoche", "Melipeuco", "Nueva Imperial", "Padre las Casas", "Perquenco", "Pitrufquén", "Pucón", "Saavedra", "Teodoro Schmidt", "Toltén", "Vilcún", "Villarrica", "Cholchol", "Angol", "Collipulli", "Curacautín", "Ercilla", "Lonquimay", "Los Sauces", "Lumaco", "Purén", "Renaico", "Traiguén", "Victoria", ]
  },
    {
      "NombreRegion": "Región de Los Ríos",
      "comunas": ["Valdivia", "Corral", "Lanco", "Los Lagos", "Máfil", "Mariquina", "Paillaco", "Panguipulli", "La Unión", "Futrono", "Lago Ranco", "Río Bueno"]
  },
    {
      "NombreRegion": "Región de Los Lagos",
      "comunas": ["Puerto Montt", "Calbuco", "Cochamó", "Fresia", "FruVllar", "Los Muermos", "Llanquihue", "Maullín", "Puerto Varas", "Castro", "Ancud", "Chonchi", "Curaco de Vélez", "Dalcahue", "Puqueldón", "Queilén", "Quellón", "Quemchi", "Quinchao", "Osorno", "Puerto Octay", "Purranque", "Puyehue", "Río Negro", "San Juan de la Costa", "San Pablo", "Chaitén", "Futaleufú", "Hualaihué", "Palena"]
  },
    {
      "NombreRegion": "Región Aisén del Gral. Carlos Ibáñez del Campo",
      "comunas": ["Coihaique", "Lago Verde", "Aisén", "Cisnes", "Guaitecas", "Cochrane", "O’Higgins", "Tortel", "Chile Chico", "Río Ibáñez"]
  },
    {
      "NombreRegion": "Región de Magallanes y de la AntárVca Chilena",
      "comunas": ["Punta Arenas", "Laguna Blanca", "Río Verde", "San Gregorio", "Cabo de Hornos (Ex Navarino)", "AntárVca", "Porvenir", "Primavera", "Timaukel", "Natales", "Torres del Paine"]
  },
    {
      "NombreRegion": "Región Metropolitana de Santiago",
      "comunas": ["Cerrillos", "Cerro Navia", "Conchalí", "El Bosque", "Estación Central", "Huechuraba", "Independencia", "La Cisterna", "La Florida", "La Granja", "La Pintana", "La Reina", "Las Condes", "Lo Barnechea", "Lo Espejo", "Lo Prado", "Macul", "Maipú", "Ñuñoa", "Pedro Aguirre Cerda", "Peñalolén", "Providencia", "Pudahuel", "Quilicura", "Quinta Normal", "Recoleta", "Renca", "San Joaquín", "San Miguel", "San Ramón", "Santiago", "Vitacura", "Puente Alto", "Pirque", "San José de Maipo", "Colina", "Lampa", "TilTil", "San Bernardo", "Buin", "Calera de Tango", "Paine", "Melipilla", "Alhué", "Curacaví", "María Pinto", "San Pedro", "Talagante", "El Monte", "Isla de Maipo", "Padre Hurtado", "Peñaflor"]
  }]
}


jQuery(document).ready(function () {


  var iRegion = 0;
  var htmlRegion = '<option value="sin-region">Seleccione región</option><option value="sin-region">--</option>';
  var htmlComunas = '<option value="sin-region">Seleccione comuna</option><option value="sin-region">--</option>';

  jQuery.each(RegionesYcomunas.regiones, function () {
    htmlRegion = htmlRegion + '<option value="' + RegionesYcomunas.regiones[iRegion].NombreRegion + '">' + RegionesYcomunas.regiones[iRegion].NombreRegion + '</option>';
    iRegion++;
  });

  jQuery('#regiones').html(htmlRegion);
  jQuery('#comunas').html(htmlComunas);

  jQuery('#regiones').change(function () {
    var iRegiones = 0;
    var valorRegion = jQuery(this).val();
    var htmlComuna = '<option value="sin-comuna">Seleccione comuna</option><option value="sin-comuna">--</option>';
    jQuery.each(RegionesYcomunas.regiones, function () {
      if (RegionesYcomunas.regiones[iRegiones].NombreRegion == valorRegion) {
        var iComunas = 0;
        jQuery.each(RegionesYcomunas.regiones[iRegiones].comunas, function () {
          htmlComuna = htmlComuna + '<option value="' + RegionesYcomunas.regiones[iRegiones].comunas[iComunas] + '">' + RegionesYcomunas.regiones[iRegiones].comunas[iComunas] + '</option>';
          iComunas++;
        });
      }
      iRegiones++;
    });
    jQuery('#comunas').html(htmlComuna);
  });
  jQuery('#comunas').change(function () {
    if (jQuery(this).val() == 'sin-region') {
      alert('selecciones Región');
    } else if (jQuery(this).val() == 'sin-comuna') {
      alert('selecciones Comuna');
    }
  });
  jQuery('#regiones').change(function () {
    if (jQuery(this).val() == 'sin-region') {
      alert('selecciones Región');
    }
  });

});
</script>

<script>
var searchInput = 'search_input';

$(document).ready(function () {
    var autocomplete;
    autocomplete = new google.maps.places.Autocomplete((document.getElementById(searchInput)), {
        types: ['geocode']
    });
        
    google.maps.event.addListener(autocomplete, 'place_changed', function () {
        var near_place = autocomplete.getPlace();
        document.getElementById('loc_lat').value = near_place.geometry.location.lat();
        document.getElementById('loc_long').value = near_place.geometry.location.lng();
                
        document.getElementById('latitude_view').innerHTML = near_place.geometry.location.lat();
        document.getElementById('longitude_view').innerHTML = near_place.geometry.location.lng();
          
    });
});
</script>

<script type="text/javascript"> let autocomplete;
let address1Field;
let address2Field;
let postalField;

function initAutocomplete() {
  address1Field = document.querySelector("#ship-address");
  address2Field = document.querySelector("#address2");
  postalField = document.querySelector("#postcode");
  // Create the autocomplete object, restricting the search predictions to
  // addresses in the US and Canada.
  autocomplete = new google.maps.places.Autocomplete(address1Field, {
    componentRestrictions: { country: ["us", "ca"] },
    fields: ["address_components", "geometry"],
    types: ["address"],
  });
  address1Field.focus();
  // When the user selects an address from the drop-down, populate the
  // address fields in the form.
  autocomplete.addListener("place_changed", fillInAddress);
}

function fillInAddress() {
  // Get the place details from the autocomplete object.
  const place = autocomplete.getPlace();
  let address1 = "";
  let postcode = "";

  // Get each component of the address from the place details,
  // and then fill-in the corresponding field on the form.
  // place.address_components are google.maps.GeocoderAddressComponent objects
  // which are documented at http://goo.gle/3l5i5Mr
  for (const component of place.address_components) {
    const componentType = component.types[0];

    switch (componentType) {
      case "street_number": {
        address1 = `${component.long_name} ${address1}`;
        break;
      }

      case "route": {
        address1 += component.short_name;
        break;
      }

      

      case "postal_code_suffix": {
        postcode = `${postcode}-${component.long_name}`;
        break;
      }
      case "locality":
        document.querySelector("#locality").value = component.long_name;
        break;

      case "administrative_area_level_1": {
        document.querySelector("#state").value = component.short_name;
        break;
      }
      case "country":
        document.querySelector("#country").value = component.long_name;
        break;
    }
  }
  address1Field.value = address1;
  postalField.value = postcode;
  // After filling the form with address components from the Autocomplete
  // prediction, set cursor focus on the second address line to encourage
  // entry of subpremise information such as apartment, unit, or floor number.
  address2Field.focus();
} </script>
<script type="text/javascript">
function validaForm(){
    // Campos de texto
    if($("#name").val() == ""){
        
        $("#name").focus();       // Esta función coloca el foco de escritura del usuario en el campo Nombre directamente.
        $("#name_error").html("Debe ingresar este campo");
        
        return false;
    }
    
    

    // Checkbox
    

    return true; // Si todo está correcto
}
          
  
$(document).ready( function() {   // Esta parte del código se ejecutará automáticamente cuando la página esté lista.
    $("#formular").on('submit', function(evt){    // Con esto establecemos la acción por defecto de nuestro botón de enviar.
      evt.preventDefault();  
                                     // Primero validará el formulario.
            if(validaForm()){                               // Primero validará el formulario.
            $.post("formularios/agregarpedidobeta.php",$("#formular").serialize(),function(res){
                $(".container").fadeOut("slow");   // Hacemos desaparecer el div "formulario" con un efecto fadeOut lento.
                if(res == 1){
                    $('#exito').html(res);
                    $("#exito").delay(500).fadeIn("slow");      // Si hemos tenido éxito, hacemos aparecer el div "exito" con un efecto fadeIn lento tras un delay de 0,5 segundos.
                
                } else {
                    $("#fracaso").delay(500).fadeIn("slow");
                    $("#fracaso").html(res);

                        // Si no, lo mismo, pero haremos aparecer el div "fracaso"
                }
            });
        }
            
        
    });    
});


        </script>