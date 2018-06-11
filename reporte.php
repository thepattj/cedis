<html>
<head>
	<title>GRUPO MOO HOUSE</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/estilo.css">
	<script src="js/jquery-3.3.1.js"></script> <!-- se agrego el jquery 14-2 -->
	<script type="text/javascript" src="js/funciones.js"></script>
	<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
</head>
<body onload="fecha()">

<header>
	<!-- DATOS DE LOGIN -->
	<div id="barra-titulo">
		<div class="titulo">
			<h1 style="color: rgba(108,174,68,1);">Moo House Group</h1>
			<!--<img style="width: 25%;" src="image/IMG_20161224_150946934.jpg">-->
		</div>
       <div class="menu" id="menu">
           <ul>
               <a style="color: rgba(108,174,68,1);" href="almacen.php"><li>Almacen</li></a>
               <a style="color: rgba(108,174,68,1);" href="compra.php"><li>Compra</li></a>
               <a style="color: rgba(108,174,68,1);" href="pendiente.php"><li>Pendiente</li></a>
               <a style="color: rgba(108,174,68,1);" href="reporte.php"><li>Reporte</li></a>
               <a style="color: rgba(108,174,68,1);" href="venta.php"><li>Venta</li></a>
           </ul>
       </div>
    </div>
</header>

    <div id="bg-negro" onclick="cerrar()"></div>
	<div id="modal"></div>
	<div class="contenido">
		<div class="div1"></div>
		<div class="div1"></div>
		<div class="div2"><span>Reporte</span></div>
		<div class="div2"><select id="opcion">
            <option style="display:none;">Selecciona</option>
            <option>BVG</option>
            <option>Venta CEDIS</option>
            <option>Produccion Moo House</option>
            <option>Produccion Pan</option>
        </select></div>
        
		<div class="div3"><span>Fecha</span></div><div class="div3"><input type="date" id="freporte"></div><div class="div3"><button id="reportc">Aceptar</button></div>
		
		<div class="result" id="reportb" style="display: none;">
		    <h3>Reporte de BVG</h3><br>
            <div class='div2'> <div class='div1'>Moo House BQA</div> </div>   
            <div class='div2'> <div class='div4'><button style='cursor: pointer;' id='mhbqa' onclick='envioreport(this.id)'><img class='lbtn' src='img/report.png'></button></div></div>
            
             <div class='div2'> <div class='div1'>Moo House UPT</div> </div>
             <div class='div2'> <div class='div4'><button style='cursor: pointer;' id='mhupt' onclick='envioreport(this.id)'><img class='lbtn' src='img/report.png'></button></div> </div>
             
            <div class='div2'> <div class='div1'>Moo House UBK</div> </div>
            <div class='div2'>  <div class='div4'><button style='cursor: pointer;' id='mhubk' onclick='envioreport(this.id)'><img class='lbtn' src='img/report.png'></button></div> </div>
            
            <div class='div2'> <div class='div1'>Brioche Bistro</div> </div>
            <div class='div2'> <div class='div4'><button style='cursor: pointer;' id='brubk' onclick='envioreport(this.id)'><img class='lbtn'src='img/report.png'></button></div>	</div>
            
            <div class='div2'> <div class='div1'>The Bakery</div> </div>
            <div class='div2'> <div class='div4'><button style='cursor: pointer;' id='brubk' onclick='envioreport(this.id)'><img class='lbtn'src='img/report.png'></button></div>	</div>
		</div>
		<div class="result" id="reportcedis" style="display: none;">
		    <h3>Reporte de CEDIS</h3><br>
            <div class='div2'> <div class='div1'>Venta Diaria</div> </div>   <div class='div2'> <div class='div4'><button style='cursor: pointer;' id='mhbqa' onclick='envioreport(this.id)'><img class='lbtn' src='img/report.png'></button></div></div>
            
            <div class='div2'> <div class='div1'>Venta Semanal</div> </div> <div class='div2'> <div class='div4'><button style='cursor: pointer;' id='mhupt' onclick='envioreport(this.id)'><img class='lbtn' src='img/report.png'></button></div> </div>
            
            <div class='div2'> <div class='div1'>Venta del Mes terminado</div> </div> <div class='div2'>  <div class='div4'><button style='cursor: pointer;' id='mhubk' onclick='envioreport(this.id)'><img class='lbtn' src='img/report.png'></button></div> </div>
		</div>
		<div class="result" id="reportmh" style="display: none;">
		    <h3>Produccion Moo House Semana que transcurrio</h3><br>
            <div class='div2'> <div class='div1'>Insumos Usados</div> </div>   <div class='div2'> <div class='div4'><button style='cursor: pointer;' id='mhbqa' onclick='envioreport(this.id)'><img class='lbtn' src='img/report.png'></button></div></div>
		</div>
		<div class="result" id="reportp" style="display: none;">
		    <h3>Produccion de Pan Semana que transcurrio</h3><br>
            <div class='div2'> <div class='div1'>Ventas</div> </div>   <div class='div2'> <div class='div4'><button style='cursor: pointer;' id='mhbqa' onclick='envioreport(this.id)'><img class='lbtn' src='img/report.png'></button></div></div>
		</div>
	</div>
</body>
</html>

