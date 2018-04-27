<?php
include 'up.php';
?>
<!--<script>
src="js/funciones.js"
</script>-->
	<div id="bg-negro" onclick="cerrar()"></div>
	<div id="modal"></div>

  <div class="background">
    <div class="contenido" id="inicio">

      <div class="uno"></div>
      <div class="uno"></div>
      <div class="uno"><h1 >INICIO DE SESION</h1></div>
      <div class="uno"></div>
        
      <div class="tres"></div>
      <div class="tres"><img src="image/candado2.png"></div>
      <div class="tres"></div>
      <div class="uno"></div>
        
        
      <div class="tres"></div>
      <div class="tres"><input id="usuario" type="text"></div>
      <div class="tres"></div>
      <div class="uno"></div>

      <div class="uno"></div>
      <div class="tres"></div>
      <div class="tres"><input id="pass" type="password"></div>
      <div class="tres"></div>
      <div class="uno"></div>

      <div class="uno"></div>
      <div class="tres"></div>
      <div class="tres">
        <select>
          <option>Compras - CEDIS</option>
          <option>Ventas - CEDIS</option>
          <option>Sucursal</option>
          <option>Caja</option>
          <option>Compras - Sucursal</option>          
        </select>
      </div>
      <div class="tres"></div>
      <div class="uno"></div>
        
      <div class="tres"></div>
      <div class="tres"><button id="entrar">Aceptar</button></div>
      <div class="tres"></div>
      <div class="uno"></div>
    </div>
    <div class="contenido nover" id="imagen">
        <img src="image/">
    </div>
  </div>
	
	<?php include 'down.php';?>