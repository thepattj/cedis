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
		<div class="uno"><H2>Pendientes</H2></div>
		<div class="tres"><span>Cliente</span></div>
		<div class="tres"><span>Dirección</span></div>
		<div class="tres"><span>Fecha de petición</span></div>

		<div class="uno"></div>
		<div class="uno"></div>
		<div class="uno"><H2>Entregados</H2></div>
		<div class="cinco"><span>Cliente</span></div>
		<div class="cinco"><span>Dirección</span></div>
		<div class="cinco"><span>Fecha de petición</span></div>
		<div class="cinco"><span>Fecha de entrega</span></div>
		<div class="cinco"><span>Persona de entrega</span></div>
		
		<div class="tabla" id="tablav"></div>
	</div>
<?php include 'down.php';?>
