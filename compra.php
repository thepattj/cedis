<?php
include 'up.php';
?>
<script>
    document.getElementById('menu').classList.remove('nover');
    document.getElementById('menu').classList.add('ver');
</script>
  <div id="bg-negro" onclick="cerrar()"></div>
	<div id="modal"></div>
	<div class="contenido">
        <div class="uno"></div>
        <div class="espacio"></div>
        <div class="cuatro">No. Factura</div>
        <div class="cuatro"><input type="text"></div>
        <div class="cuatro"></div>
    	  <div class="espacio"></div>
        <div class="uno"></div>

        <div class="espacio"></div>
        <div class="cuatro">Empresa</div>
        <div class="cuatro"><input type="text"></div>
        <div class="cuatro"></div>
    	  <div class="espacio"></div>
        <div class="uno"></div>

        <div class="espacio"></div>
        <div class="cuatro">Fecha</div>
        <div class="cuatro"><input type="date"></div><!--cambiar despues cuando se tenga el datepicker -->
        <div class="cuatro"></div>
    	  <div class="espacio"></div>
        <div class="uno"></div>

        <div class="espacio"></div>
        <div class="cuatro">Usuario de compra</div>
        <div class="cuatro"><input type="text"></div>
        <div class="cuatro"></div>
    	  <div class="espacio"></div>
        <div class="uno"></div>

        <div class="espacio"></div>
        <div class="cuatro">Descripcion</div>
        <div class="cuatro"><input type="text"></div>
        <div class="cuatro"><button id="agregar">Buscar</button></div>
    	  <div class="espacio"></div>
        <div class="uno"></div>

    	<div id="tablac" class="tabla"></div>
    </div>
<?php include 'down.php';?>
