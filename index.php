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

      <div class="div1"></div>
      <div class="div1"></div>
      <div class="div1"><h1 >INICIO DE SESION</h1></div>
      <div class="div1"></div>
        
      <div class="div3"></div>
      <div class="div3"><img src="image/candado2.png"></div>
      <div class="div3"></div>
      <div class="div1"></div>
        
        
      <div class="div3"></div>
      <div class="div3"><input id="usuario" type="text"></div>
      <div class="div3"></div>
      <div class="div1"></div>

      <div class="div1"></div>
      <div class="div3"></div>
      <div class="div3"><input id="pass" type="password"></div>
      <div class="div3"></div>
      <div class="div1"></div>

      <div class="div1"></div>
      <div class="div3"></div>
      <div class="div3">
        <select>
          <option>Compras - CEDIS</option>
          <option>Ventas - CEDIS</option>
          <option>Sucursal</option>
          <option>Caja</option>
          <option>Compras - Sucursal</option>          
        </select>
      </div>
      <div class="div3"></div>
      <div class="div1"></div>
        
      <div class="div3"></div>
      <div class="div3"><button id="entrar">Aceptar</button></div>
      <div class="div3"></div>
      <div class="div1"></div>
    </div>
    <div class="contenido nover" id="imagen">
        <img src="image/">
    </div>
  </div>
	
	<?php include 'down.php';?>