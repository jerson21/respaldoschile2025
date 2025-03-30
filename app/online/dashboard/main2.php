$(document).ready(function(){
    tablaPersonas = $("#tablaPersonas").DataTable({
        iDisplayLength: 50,
        rowGroup: true,
      

        
    language: {
            lengthMenu: "Mostrar _MENU_ registros",
            zeroRecords: "No se encontraron resultados",
            info: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            infoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
            infoFiltered: "(filtrado de un total de _MAX_ registros)",
            sSearch: "Buscar:",
            oPaginate: {
                sFirst: "Primero",
                sLast:"Último",
                sNext:"Siguiente",
                sPrevious: "Anterior"
             },
             sProcessing:"Procesando...",
        },

        order: [[0, 'asc'], [2, 'asc']],
        rowGroup: {
           dataSrc: [ 0 ]
        },
         columnDefs:[{
          targets: [ 0 ],
            visible: false
       }],

        
    });
    
$("#btnNuevo").click(function(){
    $("#formPersonas").trigger("reset");
    $(".modal-header").css("background-color", "#1cc88a");
    $(".modal-header").css("color", "white");
    $(".modal-title").text("Nueva Persona");            
    $("#modalCRUD").modal("show");        
    id=null;
    opcion = 1; //alta
});    
    
var fila; //capturar la fila para editar o borrar el registro
    
//botón EDITAR  pedido  
$(document).on("click", ".btnEditar", function(){
    fila = $(this).closest("tr");
    ide = fila.find('td:eq(0)').text();
    rut = fila.find('td:eq(1)').text();

    pais = fila.find('td:eq(2)').text();
    edad = parseInt(fila.find('td:eq(3)').text());
    modelo = fila.find('td:eq(2)').text();
    plazas = fila.find('td:eq(3)').text();
    altura = fila.find('td:eq(4)').text();
    tela = fila.find('td:eq(5)').text();
    color = fila.find('td:eq(6)').text();
    direccion = fila.find('td:eq(7)').text();
    numero = fila.find('td:eq(8)').text();
    comuna = fila.find('td:eq(9)').text();
    telefono = fila.find('td:eq(10)').text();
    
    $("#ide").val(ide);
    $("#rut").val(rut);
    $("#modelo").val(modelo);
    $("#plazas").val(plazas);
    $("#alturabase").val(altura);
    $("#tela").val(tela);
    $("#color").val(color);
    $("#direccion").val(direccion);
    $("#numero").val(numero);
    $("#comuna").val(comuna);
    $("#telefono").val(telefono);
    opcion = 5; //editar
    
    $(".modal-header").css("background-color", "#4e73df");
    $(".modal-header").css("color", "white");
    $(".modal-title").text("Editar Pedido");            
    $("#modalEditarPedido").modal("show");  
    
});

//botón EDITAR ESTADO    
$(document).on("click", ".btnEditarestado", function(){
    fila = $(this).closest("tr");
    id = parseInt(fila.find('td:eq(0)').text());
    rut = fila.find('td:eq(1)').text();
    pais = fila.find('td:eq(2)').text();
    edad = parseInt(fila.find('td:eq(3)').text());
    
    $("#id").val(id);
    $("#estado").val(pais);
    $("#edad").val(edad);
    opcion = 4; //editar
    
    $(".modal-header").css("background-color", "#4e73df");
    $(".modal-header").css("color", "white");
    $(".modal-title").text("Editar Estado");            
    $("#modalCRUD").modal("show");  
    
});

//botón BORRAR
$(document).on("click", ".btnBorrar", function(){    
    fila = $(this);
    id = parseInt($(this).closest("tr").find('td:eq(0)').text());
    opcion = 3 //borrar
    var respuesta = confirm("¿Está seguro de eliminar el registro: "+id+"?");
    if(respuesta){
        $.ajax({
            url: "bd/crud.php",
            type: "POST",
            dataType: "json",
            data: {opcion:opcion, id:id},
            success: function(){
                tablaPersonas.row(fila.parents('tr')).remove().draw();
            }
        });
    }   
});
//Aceptar compra

$("#aceptarpedido").submit(function(e){
e.preventDefault();    
    
    id = parseInt(fila.find('td:eq(0)').text());
    opcion = 4 //borrar
    estado = 1;
    $.ajax({
        url: "bd/crud.php",
        type: "POST",
        dataType: "json",
        data: {estado:estado, id:id, opcion:opcion},
        success: function(data){  
            console.log(data);  
            alert(id);
            id = data[0].id;            
            rut_cliente = data[0].rut_cliente;
            modelo = data[0].modelo;
            plazas = data[0].plazas;
            alturabase = data[0].alturabase;
            material = data[0].tipotela;
            color = data[0].color;
            comuna = data[0].comuna;
            estadoped = data[0].estadopedido;
            if(estadoped == 1){
                                   estadoped = "<div class='text-center' ><div class='btn-group'><button class='btn btn-secondary btnEditarestado' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Aceptado</button></div>";
                                }if(estadoped == 2){
                                   estadoped = "<div class='text-center' ><div class='btn-group'><button class='btn btn-info btnEditarestado' id='parpadea' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>En Fabricacion</button></div>";
                                }if(estadoped == 0){ 
                                    estadoped = "<div class='text-center' ><div class='btn-group'><button class='btn btn-warning btnEditarestado' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>No Aceptado</button></div>";
                                }
                                if(estadoped == 3){
                                    estadoped = "<div class='text-center' ><div class='btn-group'><button class='btn btn-info btnEditarestado' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Pedido Listo</button></div>";
                                }
            

                tablaPersonas.row(fila).data([id,rut_cliente,modelo,plazas,alturabase,material,color,comuna,estadoped,,]).draw();          
        },
        error:function(){
                   alert("Error cambiando estado");

                }          
});
});
    
$("#editarestado").submit(function(e){
    e.preventDefault();    
    estado = $("#estado").val();
    pais = $.trim($("#pais").val());
    edad = $.trim($("#edad").val());    
    $.ajax({
        url: "bd/crud.php",
        type: "POST",
        dataType: "json",
        data: {estado:estado, id:id, opcion:opcion},
        success: function(data){  
            console.log(data);  

            id = data[0].id;            
            rut_cliente = data[0].rut_cliente;
            modelo = data[0].modelo;
            plazas = data[0].plazas;
            alturabase = data[0].alturabase;
            material = data[0].tipotela;
            direccion = data[0].direccion;
            numero = data[0].numero;
             comuna = data[0].comuna;
            color = data[0].color;
            comuna = data[0].comuna;
            telefono = data[0].telefono;
            estadoped = data[0].estadopedido;
            if(data[0].estadopedido == "1"){
                                   estadoped = "<div class='text-center' ><div class='btn-group'><button class='btn btn-secondary btnEditarestado' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Aceptado</button></div>";
                                }if(data[0].estadopedido == 2){
                                   estadoped = "<div class='text-center' ><div class='btn-group'><button class='btn btn-info btnEditarestado' id='parpadea' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>En Fabricacion</button></div>";
                                }if(data[0].estadopedido == 0){ 
                                    estadoped = "<div class='text-center' ><div class='btn-group'><button class='btn btn-warning btnEditarestado' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>No Aceptado</button></div>";
                                }
                                if(data[0].estadopedido == 3){
                                    estadoped = "<div class='text-center' ><div class='btn-group'><button class='btn btn-info btnEditarestado' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Pedido Listo</button></div>";
                                }
            if(opcion == 1){tablaPersonas.row.add([id,nombre,pais,edad]).draw();}
            else{
                tablaPersonas.row(fila).data([id,rut_cliente,modelo,plazas,alturabase,material,color,direccion,numero,comuna,telefono,estadoped,,]).draw();}             
        },
        error:function(){
                   alert("Error cambiando estado");

                }       
    });
    $("#modalCRUD").modal("hide");    
    
});    


$("#editarpedido").submit(function(e){
    e.preventDefault();    
    ide = $("#ide").val();
    rut = $.trim($("#rut").val());
    modelo = $.trim($("#modelo").val());
    plazas = $.trim($("#plazas").val()); 
    tela = $.trim($("#tela").val());  
    color = $.trim($("#color").val());
     telefono = $.trim($("#telefono").val());
    alturabase = $.trim($("#alturabase").val());  
    direccion = $.trim($("#direccion").val());   
    numero = $.trim($("#numero").val());
    comuna = $.trim($("#comuna").val());  
    $.ajax({
        url: "bd/crud.php",
        type: "POST",
        dataType: "json",
        data: {ide:ide,rut:rut,telefono:telefono, opcion:5,modelo:modelo,plazas:plazas,tela:tela,color:color,alturabase:alturabase,direccion:direccion,numero:numero,comuna:comuna},
        success: function(data){  
            console.log(data);  

            id = data[0].id;            
            rut_cliente = data[0].rut_cliente;
            modelo = data[0].modelo;
            plazas = data[0].plazas;
            alturabase = data[0].alturabase;
            material = data[0].tipotela;
            direccion = data[0].direccion;
            numero = data[0].numero;
             comuna = data[0].comuna;
             telefono = data[0].telefono;
            

            estadoped = data[0].estadopedido;
            if(data[0].estadopedido == "1"){
                                   estadoped = "<div class='text-center' ><div class='btn-group'><button class='btn btn-secondary btnEditarestado' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Aceptado</button></div>";
                                }if(data[0].estadopedido == 2){
                                   estadoped = "<div class='text-center' ><div class='btn-group'><button class='btn btn-info btnEditarestado' id='parpadea' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>En Fabricacion</button></div>";
                                }if(data[0].estadopedido == 0){ 
                                    estadoped = "<div class='text-center' ><div class='btn-group'><button class='btn btn-warning btnEditarestado' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>No Aceptado</button></div>";
                                }
                                if(data[0].estadopedido == 3){
                                    estadoped = "<div class='text-center' ><div class='btn-group'><button class='btn btn-info btnEditarestado' style='font-size:0.8rem;max-height:1.5rem; line-height:12px;'>Pedido Listo</button></div>";
                                }
            if(opcion == 1){tablaPersonas.row.add([id,nombre,pais,edad]).draw();}
            else{
                tablaPersonas.row(fila).data([id,rut_cliente,modelo,plazas,alturabase,material,color,direccion,numero,comuna,telefono,estadoped,,]).draw();}            
        },
        error:function(){
                   alert("Error cambiando estado");

                }       
    });
    $("#modalEditarPedido").modal("hide");    
    
});    
    
});