<?php
include 'up.php';
?>
<script>
    document.getElementById('menu').classList.remove('nover');
    document.getElementById('menu').classList.add('ver');
</script>	<div id="bg-negro" onclick="cerrar()"></div>
	<div id="modal"></div>
	<div class="contenido">
		<div class="uno"></div>
		<div class="uno"></div>
		<div class="dos"><span>Cliente</span></div><div class="dos"><input type="text" id="cliente"></div>
		<div class="dos"><span>Fecha</span></div><div class="dos"><input type="date" id="fecha"></div>
		<div class="dos"><span>Dirección</span></div><div class="dos"><input type="text" id="dir"></div>
		<div class="dos"><span>Envio</span></div><div class="dos"><input type="text" id="decis"></div>
		<div class="uno"></div><div class="uno"></div><div class="uno"></div>
		<div class="cuatro">Cantidad</div><div class="cuatro">Descripción</div><div class="cuatro">P.Unitario</div>
		<div class="uno"></div>
		<div class="cuatro"><input type="number" id="cant"></div><div class="cuatro"><input type="text" id="descrip"></div><div class="cuatro"><input type="number" id="precio" disabled=""></div><div class="cuatro"><button id="agrega">imgplus</button></div>
		
		<div class="tabla" id="tablav"></div>
	</div>
<?php include 'down.php';?>
