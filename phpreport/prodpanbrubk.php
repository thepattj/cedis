<?php
    $nsrvr = "brubk";  
    include '../conexion.php';

    $i=0;
    $k=0;
    $l=0;
    $m=0;
    $n=0;
    $o=0;
    $p=0;
    //echo "esta es la ubicacion".$nsrvr;

    $con = conectarse($nsrvr);

    date_default_timezone_set('America/Mexico_City');

    $hora = date('g:i a');
    /*$fechafinal = date("d/m/y");//DOMINGO
    $fecha6 =date('d/m/y', strtotime('-1 day')); //SAB
    $fecha5 =date('d/m/y', strtotime('-2 day')); //VIE
    $fecha4 =date('d/m/y', strtotime('-3 day')); //JUE
    $fecha3 =date('d/m/y', strtotime('-4 day')); //MIE
    $fecha2 =date('d/m/y', strtotime('-5 day')); //MAR
    $fecha1 =date('d/m/y', strtotime('-6 day')); //LUN*/

    $fechafinal = date('d/m/y', strtotime('-1 day'));//DOMINGO
    $fecha6 =date('d/m/y', strtotime('-2 day')); //SAB
    $fecha5 =date('d/m/y', strtotime('-3 day')); //VIE
    $fecha4 =date('d/m/y', strtotime('-4 day')); //JUE
    $fecha3 =date('d/m/y', strtotime('-5 day')); //MIE
    $fecha2 =date('d/m/y', strtotime('-6 day')); //MAR
    $fecha1 =date('d/m/y', strtotime('-7 day')); //LUN
    
    $sqlventaslun = "SELECT prod.descripcion, sum(detalle.cantidad) AS Cantidad
                    FROM cheqdet detalle LEFT JOIN cheques tick ON detalle.foliodet = tick.folio LEFT JOIN productos prod ON detalle.idproducto = prod.idproducto RIGHT JOIN grupos gpo ON prod.idgrupo = gpo.idgrupo
                    WHERE tick.cierre BETWEEN '".$fecha1." 12:00:00 AM' AND '".$fecha1." 11:59:59 PM' AND tick.pagado = 1 and tick.cancelado =0 AND gpo.descripcion = 'PANADERIA'
                    GROUP BY prod.descripcion
                    ORDER BY prod.descripcion ASC";

    $sqlventasmar = "SELECT prod.descripcion, sum(detalle.cantidad) AS Cantidad
                    FROM cheqdet detalle LEFT JOIN cheques tick ON detalle.foliodet = tick.folio LEFT JOIN productos prod ON detalle.idproducto = prod.idproducto RIGHT JOIN grupos gpo ON prod.idgrupo = gpo.idgrupo
                    WHERE tick.cierre BETWEEN '".$fecha2." 12:00:00 AM' AND '".$fecha2." 11:59:59 PM' AND tick.pagado = 1 and tick.cancelado =0 AND gpo.descripcion = 'PANADERIA'
                    GROUP BY prod.descripcion
                    ORDER BY prod.descripcion ASC";

    $sqlventasmie = "SELECT prod.descripcion, sum(detalle.cantidad) AS Cantidad
                    FROM cheqdet detalle LEFT JOIN cheques tick ON detalle.foliodet = tick.folio LEFT JOIN productos prod ON detalle.idproducto = prod.idproducto RIGHT JOIN grupos gpo ON prod.idgrupo = gpo.idgrupo
                    WHERE tick.cierre BETWEEN '".$fecha3." 12:00:00 AM' AND '".$fecha3." 11:59:59 PM' AND tick.pagado = 1 and tick.cancelado =0 AND gpo.descripcion = 'PANADERIA'
                    GROUP BY prod.descripcion
                    ORDER BY prod.descripcion ASC";

    $sqlventasjue = "SELECT prod.descripcion, sum(detalle.cantidad) AS Cantidad
                    FROM cheqdet detalle LEFT JOIN cheques tick ON detalle.foliodet = tick.folio LEFT JOIN productos prod ON detalle.idproducto = prod.idproducto RIGHT JOIN grupos gpo ON prod.idgrupo = gpo.idgrupo
                    WHERE tick.cierre BETWEEN '".$fecha4." 12:00:00 AM' AND '".$fecha4." 11:59:59 PM' AND tick.pagado = 1 and tick.cancelado =0 AND gpo.descripcion = 'PANADERIA'
                    GROUP BY prod.descripcion
                    ORDER BY prod.descripcion ASC";

    $sqlventasvie = "SELECT prod.descripcion, sum(detalle.cantidad) AS Cantidad
                    FROM cheqdet detalle LEFT JOIN cheques tick ON detalle.foliodet = tick.folio LEFT JOIN productos prod ON detalle.idproducto = prod.idproducto RIGHT JOIN grupos gpo ON prod.idgrupo = gpo.idgrupo
                    WHERE tick.cierre BETWEEN '".$fecha5." 12:00:00 AM' AND '".$fecha5." 11:59:59 PM' AND tick.pagado = 1 and tick.cancelado =0 AND gpo.descripcion = 'PANADERIA'
                    GROUP BY prod.descripcion
                    ORDER BY prod.descripcion ASC";

    $sqlventassab = "SELECT prod.descripcion, sum(detalle.cantidad) AS Cantidad
                    FROM cheqdet detalle LEFT JOIN cheques tick ON detalle.foliodet = tick.folio LEFT JOIN productos prod ON detalle.idproducto = prod.idproducto RIGHT JOIN grupos gpo ON prod.idgrupo = gpo.idgrupo
                    WHERE tick.cierre BETWEEN '".$fecha6." 12:00:00 AM' AND '".$fecha6." 11:59:59 PM' AND tick.pagado = 1 and tick.cancelado =0 AND gpo.descripcion = 'PANADERIA'
                    GROUP BY prod.descripcion
                    ORDER BY prod.descripcion ASC";

    $sqlventasdom = "SELECT prod.descripcion, sum(detalle.cantidad) AS Cantidad
                    FROM cheqdet detalle LEFT JOIN cheques tick ON detalle.foliodet = tick.folio LEFT JOIN productos prod ON detalle.idproducto = prod.idproducto RIGHT JOIN grupos gpo ON prod.idgrupo = gpo.idgrupo
                    WHERE tick.cierre BETWEEN '".$fechafinal." 12:00:00 AM' AND '".$fechafinal." 11:59:59 PM' AND tick.pagado = 1 and tick.cancelado =0 AND gpo.descripcion = 'PANADERIA'
                    GROUP BY prod.descripcion
                    ORDER BY prod.descripcion ASC";

    //echo $sqlventaslun;

    $stmt = sqlsrv_query($con, $sqlventaslun);
    $stmt0 = sqlsrv_query($con, $sqlventasmar);
    $stmt1 = sqlsrv_query($con, $sqlventasmie);
    $stmt2 = sqlsrv_query($con, $sqlventasjue);
    $stmt3 = sqlsrv_query($con, $sqlventasvie);
    $stmt4 = sqlsrv_query($con, $sqlventassab);
    $stmt5 = sqlsrv_query($con, $sqlventasdom);

    /*===================DIA LUNES==============*/
    if( $stmt === false ) {
        echo "Error in executing statement.\n";  
        die( print_r( sqlsrv_errors(), true)); 
        echo "ERROR DE DATOS";
    }else{
        while ($obj = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            //echo $obj['importenetosiniva']."*".$obj['descripcion']."*\n-----\n";
            $Descripcion[] = $obj ["descripcion"];
            $Cantidad[] = ROUND($obj['Cantidad']);
            $i=$i+1;
        }
        //for($j=0; $j<$i; $j++){ echo $Descripcion[$j]."\n"; echo $Cantidad[$j]."\n"; }
    }

    /*====================DIA MARTES ===============*/
    if( $stmt0 === false ) {
        echo "Error in executing statement.\n";  
        die( print_r( sqlsrv_errors(), true)); 
        echo "ERROR DE DATOS";
    }else{
        while ($obj = sqlsrv_fetch_array($stmt0, SQLSRV_FETCH_ASSOC)) {
            //echo $obj['importenetosiniva']."*".$obj['descripcion']."*\n-----\n";
            $Descripcion0[] = $obj ["descripcion"];
            $Cantidad0[] = ROUND($obj['Cantidad']);
            $k=$k+1;
        }
        //for($j=0; $j<$i; $j++){ echo $Descripcion0[$j]."\n"; echo $Cantidad0[$j]."\n"; }
    }
    /*====================DIA MIERCOLES============*/
    if( $stmt1 === false ) {
        echo "Error in executing statement.\n";  
        die( print_r( sqlsrv_errors(), true)); 
        echo "ERROR DE DATOS";
    }else{
        while ($obj = sqlsrv_fetch_array($stmt1, SQLSRV_FETCH_ASSOC)) {
            //echo $obj['importenetosiniva']."*".$obj['descripcion']."*\n-----\n";
            $Descripcion1[] = $obj ["descripcion"];
            $Cantidad1[] = ROUND($obj['Cantidad']);
            $l=$l+1;
        }
        //for($j=0; $j<$i; $j++){ echo $Descripcion[$j]."\n"; echo $Cantidad[$j]."\n"; }
    }
    /*=-==============DIA JUEVES================*/
    if( $stmt2 === false ) {
        echo "Error in executing statement.\n";  
        die( print_r( sqlsrv_errors(), true)); 
        echo "ERROR DE DATOS";
    }else{
        while ($obj = sqlsrv_fetch_array($stmt2, SQLSRV_FETCH_ASSOC)) {
            //echo $obj['importenetosiniva']."*".$obj['descripcion']."*\n-----\n";
            $Descripcion2[] = $obj ["descripcion"];
            $Cantidad2[] = ROUND($obj['Cantidad']);
            $m=$m+1;
        }
        //for($j=0; $j<$i; $j++){ echo $Descripcion[$j]."\n"; echo $Cantidad[$j]."\n"; }
    }
    /*================DIA VIERNES===============*/
    if( $stmt3 === false ) {
        echo "Error in executing statement.\n";  
        die( print_r( sqlsrv_errors(), true)); 
        echo "ERROR DE DATOS";
    }else{
        while ($obj = sqlsrv_fetch_array($stmt3, SQLSRV_FETCH_ASSOC)) {
            //echo $obj['importenetosiniva']."*".$obj['descripcion']."*\n-----\n";
            $Descripcion3[] = $obj ["descripcion"];
            $Cantidad3[] = ROUND($obj['Cantidad']);
            $n=$n+1;
        }
        //for($j=0; $j<$i; $j++){ echo $Descripcion[$j]."\n"; echo $Cantidad[$j]."\n"; }
    }
    /*==============DIA SABADO==================*/
    if( $stmt4 === false ) {
        echo "Error in executing statement.\n";  
        die( print_r( sqlsrv_errors(), true)); 
        echo "ERROR DE DATOS";
    }else{
        while ($obj = sqlsrv_fetch_array($stmt4, SQLSRV_FETCH_ASSOC)) {
            //echo $obj['importenetosiniva']."*".$obj['descripcion']."*\n-----\n";
            $Descripcion4[] = $obj ["descripcion"];
            $Cantidad4[] = ROUND($obj['Cantidad']);
            $o=$o+1;
        }
        //for($j=0; $j<$i; $j++){ echo $Descripcion[$j]."\n"; echo $Cantidad[$j]."\n"; }
    }
    /*===============DIA DOMINGO================*/
    if( $stmt5 === false ) {
        echo "Error in executing statement.\n";  
        die( print_r( sqlsrv_errors(), true)); 
        echo "ERROR DE DATOS";
    }else{
        while ($obj = sqlsrv_fetch_array($stmt5, SQLSRV_FETCH_ASSOC)) {
            //echo $obj['importenetosiniva']."*".$obj['descripcion']."*\n-----\n";
            $Descripcion5[] = $obj ["descripcion"];
            $Cantidad5[] = ROUND($obj['Cantidad']);
            $p=$p+1;
        }
        //for($j=0; $j<$i; $j++){ echo $Descripcion[$j]."\n"; echo $Cantidad[$j]."\n"; }
    }


    $file = fopen("C:\Users\Josue\Downloads\panbrubk.txt", "w");
    fwrite($file, 'DIA LUNES'. '  -  ' .$fecha1.PHP_EOL);
    for($j=0; $j<$i; $j++){ 
        fwrite($file, $Descripcion[$j] ."\t");
        fwrite($file, $Cantidad[$j] .PHP_EOL);
    }
    fwrite($file, PHP_EOL. 'DIA MARTES' .'  -  ' .$fecha2.PHP_EOL);
    for($j=0; $j<$k; $j++){ 
        fwrite($file, $Descripcion0[$j] ."\t");
        fwrite($file, $Cantidad0[$j] .PHP_EOL);
    }
    fwrite($file, PHP_EOL. 'DIA MIERCOLES' .'  -  ' .$fecha3.PHP_EOL);
    for($j=0; $j<$l; $j++){ 
        fwrite($file, $Descripcion1[$j] ."\t");
        fwrite($file, $Cantidad1[$j] .PHP_EOL);
    }
    fwrite($file, PHP_EOL. 'DIA JUEVES' .'  -  ' .$fecha4.PHP_EOL);
    for($j=0; $j<$m; $j++){ 
        fwrite($file, $Descripcion2[$j] ."\t");
        fwrite($file, $Cantidad2[$j] .PHP_EOL);
    }
    fwrite($file, PHP_EOL. 'DIA VIERNES' .'  -  ' .$fecha5.PHP_EOL);
    for($j=0; $j<$n; $j++){ 
        fwrite($file, $Descripcion3[$j] ."\t");
        fwrite($file, $Cantidad3[$j] .PHP_EOL);
    }
    fwrite($file, PHP_EOL. 'DIA SABADO' .'  -  ' .$fecha6.PHP_EOL);
    for($j=0; $j<$o; $j++){ 
        fwrite($file, $Descripcion4[$j] ."\t");
        fwrite($file, $Cantidad4[$j] .PHP_EOL);
    }
    fwrite($file, PHP_EOL. 'DIA DOMINGO' .'  -  ' .$fechafinal.PHP_EOL);
    for($j=0; $j<$p; $j++){ 
        fwrite($file, $Descripcion5[$j] ."\t");
        fwrite($file, $Cantidad5[$j] .PHP_EOL);
    }
    fclose($file);
?>