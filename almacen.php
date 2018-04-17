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
        <div class="cuatro">Buscar por:</div>
        <div class="cuatro"> Caracterisitca de la seleccion</div>
        <div class="cuatro"></div>
	    <div class="espacio"></div>
        <div class="uno"></div>
    
        <div class="espacio"></div>
        <div class="cuatro"><select>
            <option style="display:none;">Selecciona</option>
            <option>Clave</option>
            <option>Descripcion</option>
            <option>Nombre Comun</option>
            <option>Otro...</option>
        </select></div>
        <div class="cuatro"> <input type="text" style="width:100%;" placeholder="Escribe ..."></div>
        <div class="cuatro"><button id="buscar">Buscar <img> </button></div>
    	<div class="espacio"></div>
    	<div class="uno"></div><div class="uno"></div><div class="uno"></div>
    	
    	<div id="tabla" class="tabla">
    	    
    	</div>
    </div>
<?php include 'down.php';?>
