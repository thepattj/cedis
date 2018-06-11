
$(function(){
  $('#entrar').click(function(){
    //alert("funciona");
    document.getElementById('imagen').classList.add('ver');
    document.getElementById('inicio').classList.remove('ver');
    document.getElementById('inicio').classList.add('nover');
    document.getElementById('imagen').classList.remove('nover');
    document.getElementById('menu').classList.remove('nover');
    document.getElementById('menu').classList.add('ver');
  });

  /*----------------ALMACEN--------------------------*/
  $('#buscar').click(function(){
    document.getElementById('tabla').innerHTML += "<h3>RESULTADO</h3><br>"+
    "<table> <tr> <th></th> <th>Cantidad</th> <th>Descripcion</th> <th>Unidad</th> <th> Precio unitario</th> </tr>"+
            "<tr> <th><input type='checkbox'></th> <th>100</th> <th>Tornillo estufa 1/8 x 3/8</th> <th>pza</th> <th>.90</th> </tr>"+
    "</table>"+
    //SE PUEDE AGREGAR ALGUN OTRO DIV PARA PODER MANDAR LOS BOTONES EN LA PARTE DE ABAJO
    "<div class='uno'></div><div class='tresta'><button>Venta</button></div><div class='tresta'><button>Renta</button></div><div class='tresta'><button>Nuevo</button></div>";
  });

  /*---------------COMPRA---------------------------*/
  $('#agregar').click(function(){
    document.getElementById('tablac').innerHTML += "<h3>AGREGADOS</h3><br>"+
    "<table> <tr><th>Cantidad</th> <th>Descripcion</th> <th>Unidad</th> <th> Precio unitario</th> </tr>"+
            "<tr><th><input type='text'></th> <th>Tornillo estufa 1/8 x 3/8</th> <th>pza</th> <th><input type='text'></th> </tr>"+
    "</table>"+
    //SE PUEDE AGREGAR ALGUN OTRO DIV PARA PODER MANDAR LOS BOTONES EN LA PARTE DE ABAJO
    "<div class='uno'></div><div class='tresta'></div><div class='tresta'><button>Almacen</button></div><div class='tresta'></div>";
  });

  /*----------------VENTA----------------------------*/
  $('#agrega').click(function(){
    document.getElementById('tablav').innerHTML += "<h3>TICKET</h3><br>"+
    "<table> <tr> <th></th> <th>Cantidad</th> <th>Descripcion</th> <th>Unidad</th> <th> Precio unitario</th> </tr>"+
            "<tr> <th><input type='checkbox'></th> <th>100</th> <th>Tornillo estufa 1/8 x 3/8</th> <th>pza</th> <th>.90</th> </tr>"+
    "</table>"+
    //SE PUEDE AGREGAR ALGUN OTRO DIV PARA PODER MANDAR LOS BOTONES EN LA PARTE DE ABAJO
    "<div class='uno'></div><div class='tresta'><button>Editar</button></div><div class='tresta'><button>Cobrar</button></div><div class='tresta'><button>Factura</button></div>";
  });

  /*-----------------Reportes--------------------------*/
  $('#reportc').click(function(){
      var seleccion = $("#opcion").val(); 
      
      if (seleccion == 'BVG') {
        document.getElementById('reportb').style.display = 'block';
          document.getElementById('reportcedis').style.display = 'none';
          document.getElementById('reportmh').style.display = 'none';
          document.getElementById('reportp').style.display = 'none';
      } if (seleccion == 'Venta CEDIS') {
        document.getElementById('reportcedis').style.display = 'block';
          document.getElementById('reportb').style.display = 'none';
          document.getElementById('reportmh').style.display = 'none';
          document.getElementById('reportp').style.display = 'none';
      } if (seleccion == 'Produccion Moo House'){
          document.getElementById('reportmh').style.display = 'block';
          document.getElementById('reportb').style.display = 'none';
          document.getElementById('reportcedis').style.display = 'none';
          document.getElementById('reportp').style.display = 'none';
      } if (seleccion == 'Produccion Pan'){
          document.getElementById('reportp').style.display = 'block';
          document.getElementById('reportb').style.display = 'none';
          document.getElementById('reportcedis').style.display = 'none';
          document.getElementById('reportmh').style.display = 'none';
      }
     
  });
    
    
});




function fecha(){
  var f = new Date();
  var month = new Array();
  month[0] = "01";
  month[1] = "02";
  month[2] = "03";
  month[3] = "04";
  month[4] = "05";
  month[5] = "06";
  month[6] = "07";
  month[7] = "08";
  month[8] = "09";
  month[9] = "10";
  month[10] = "11";
  month[11] = "12";
  f = f.getFullYear() + "-" + month[f.getMonth()] + "-" + f.getDate();
  document.getElementById('freporte').value = f;
}