<?php
    $nsrvr = "bqa";  
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
    
    $sqlventaslun = "SELECT ins.descripcion, sum(abs(mov.cantidad)) as Cantidad, ins.unidad
                    FROM movsinv mov LEFT JOIN insumosdetalle insd ON mov.idinsumo = insd.idinsumo LEFT JOIN insumos ins ON insd.idinsumo = ins.idinsumo RIGHT JOIN gruposi gpo ON ins.idgruposi = gpo.idgruposi
                    WHERE mov.fecha BETWEEN '".$fecha1." 12:00:00 AM' AND '".$fecha1." 11:59:59 PM' 
                                         AND mov.idconcepto = 'SPV'
                                         AND ( gpo.descripcion = 'PRODUCCION'
                                         OR gpo.descripcion = 'PANADERIA')
                    GROUP BY ins.descripcion, ins.unidad, gpo.descripcion
                    ORDER BY gpo.descripcion ASC";

    $sqlventasmar = "SELECT ins.descripcion, sum(abs(mov.cantidad)) as Cantidad, ins.unidad
                    FROM movsinv mov LEFT JOIN insumosdetalle insd ON mov.idinsumo = insd.idinsumo LEFT JOIN insumos ins ON insd.idinsumo = ins.idinsumo RIGHT JOIN gruposi gpo ON ins.idgruposi = gpo.idgruposi
                    WHERE mov.fecha BETWEEN '".$fecha2." 12:00:00 AM' AND '".$fecha2." 11:59:59 PM' 
                                         AND mov.idconcepto = 'SPV'
                                         AND ( gpo.descripcion = 'PRODUCCION'
                                         OR gpo.descripcion = 'PANADERIA')
                    GROUP BY ins.descripcion, ins.unidad, gpo.descripcion
                    ORDER BY gpo.descripcion ASC";

    $sqlventasmie = "SELECT ins.descripcion, sum(abs(mov.cantidad)) as Cantidad, ins.unidad
                    FROM movsinv mov LEFT JOIN insumosdetalle insd ON mov.idinsumo = insd.idinsumo LEFT JOIN insumos ins ON insd.idinsumo = ins.idinsumo RIGHT JOIN gruposi gpo ON ins.idgruposi = gpo.idgruposi
                    WHERE mov.fecha BETWEEN '".$fecha3." 12:00:00 AM' AND '".$fecha3." 11:59:59 PM' 
                                         AND mov.idconcepto = 'SPV'
                                         AND ( gpo.descripcion = 'PRODUCCION'
                                         OR gpo.descripcion = 'PANADERIA')
                    GROUP BY ins.descripcion, ins.unidad, gpo.descripcion
                    ORDER BY gpo.descripcion ASC";

    $sqlventasjue = "SELECT ins.descripcion, sum(abs(mov.cantidad)) as Cantidad, ins.unidad
                    FROM movsinv mov LEFT JOIN insumosdetalle insd ON mov.idinsumo = insd.idinsumo LEFT JOIN insumos ins ON insd.idinsumo = ins.idinsumo RIGHT JOIN gruposi gpo ON ins.idgruposi = gpo.idgruposi
                    WHERE mov.fecha BETWEEN '".$fecha4." 12:00:00 AM' AND '".$fecha4." 11:59:59 PM' 
                                         AND mov.idconcepto = 'SPV'
                                         AND ( gpo.descripcion = 'PRODUCCION'
                                         OR gpo.descripcion = 'PANADERIA')
                    GROUP BY ins.descripcion, ins.unidad, gpo.descripcion
                    ORDER BY gpo.descripcion ASC";

    $sqlventasvie = "SELECT ins.descripcion, sum(abs(mov.cantidad)) as Cantidad, ins.unidad
                    FROM movsinv mov LEFT JOIN insumosdetalle insd ON mov.idinsumo = insd.idinsumo LEFT JOIN insumos ins ON insd.idinsumo = ins.idinsumo RIGHT JOIN gruposi gpo ON ins.idgruposi = gpo.idgruposi
                    WHERE mov.fecha BETWEEN '".$fecha5." 12:00:00 AM' AND '".$fecha5." 11:59:59 PM' 
                                         AND mov.idconcepto = 'SPV'
                                         AND ( gpo.descripcion = 'PRODUCCION'
                                         OR gpo.descripcion = 'PANADERIA')
                    GROUP BY ins.descripcion, ins.unidad, gpo.descripcion
                    ORDER BY gpo.descripcion ASC";

    $sqlventassab = "SELECT ins.descripcion, sum(abs(mov.cantidad)) as Cantidad, ins.unidad
                    FROM movsinv mov LEFT JOIN insumosdetalle insd ON mov.idinsumo = insd.idinsumo LEFT JOIN insumos ins ON insd.idinsumo = ins.idinsumo RIGHT JOIN gruposi gpo ON ins.idgruposi = gpo.idgruposi
                    WHERE mov.fecha BETWEEN '".$fecha6." 12:00:00 AM' AND '".$fecha6." 11:59:59 PM' 
                                         AND mov.idconcepto = 'SPV'
                                         AND ( gpo.descripcion = 'PRODUCCION'
                                         OR gpo.descripcion = 'PANADERIA')
                    GROUP BY ins.descripcion, ins.unidad, gpo.descripcion
                    ORDER BY gpo.descripcion ASC";

    $sqlventasdom = "SELECT ins.descripcion, sum(abs(mov.cantidad)) as Cantidad, ins.unidad
                    FROM movsinv mov LEFT JOIN insumosdetalle insd ON mov.idinsumo = insd.idinsumo LEFT JOIN insumos ins ON insd.idinsumo = ins.idinsumo RIGHT JOIN gruposi gpo ON ins.idgruposi = gpo.idgruposi
                    WHERE mov.fecha BETWEEN '".$fechafinal." 12:00:00 AM' AND '".$fechafinal." 11:59:59 PM' 
                                         AND mov.idconcepto = 'SPV'
                                         AND ( gpo.descripcion = 'PRODUCCION'
                                         OR gpo.descripcion = 'PANADERIA')
                    GROUP BY ins.descripcion, ins.unidad, gpo.descripcion
                    ORDER BY gpo.descripcion ASC";

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
            $Cantidad[] = $obj['Cantidad'];
            $Unidad[] =$obj['unidad'];
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
            $Cantidad0[] = $obj['Cantidad'];
            $Unidad0[] =$obj['unidad'];
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
            $Cantidad1[] = $obj['Cantidad'];
            $Unidad1[] =$obj['unidad'];
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
            $Cantidad2[] = $obj['Cantidad'];
            $Unidad2[] =$obj['unidad'];
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
            $Cantidad3[] = $obj['Cantidad'];
            $Unidad3[] =$obj['unidad'];
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
            $Cantidad4[] = $obj['Cantidad'];
            $Unidad4[] =$obj['unidad'];
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
            $Cantidad5[] = $obj['Cantidad'];
            $Unidad5[] =$obj['unidad'];
            $p=$p+1;
        }
        //for($j=0; $j<$i; $j++){ echo $Descripcion[$j]."\n"; echo $Cantidad[$j]."\n"; }
    }


    $file = fopen("C:\Users\Josue\Downloads\producmhbqa.txt", "w");
    fwrite($file, 'DIA LUNES' ."  -  " .$fecha1);
    for($j=0; $j<$i; $j++){ 
        fwrite($file, $Descripcion[$j] ."\t");
        fwrite($file, $Cantidad[$j] ."\t");
        fwrite($file, $Unidad[$j] .PHP_EOL);
    }
    fwrite($file, PHP_EOL. 'DIA MARTES' ."  -  " .$fecha2);
    for($j=0; $j<$k; $j++){ 
        fwrite($file, $Descripcion0[$j] ."\t");
        fwrite($file, $Cantidad0[$j] ."\t");
        fwrite($file, $Unidad0[$j] .PHP_EOL);
    }
    fwrite($file, PHP_EOL. 'DIA MIERCOLES' ."  -  " .$fecha3);
    for($j=0; $j<$l; $j++){ 
        fwrite($file, $Descripcion1[$j] ."\t");
        fwrite($file, $Cantidad1[$j] ."\t");
        fwrite($file, $Unidad1[$j] .PHP_EOL);
    }
    fwrite($file, PHP_EOL. 'DIA JUEVES' ."  -  " .$fecha4);
    for($j=0; $j<$m; $j++){ 
        fwrite($file, $Descripcion2[$j] ."\t");
        fwrite($file, $Cantidad2[$j] ."\t");
        fwrite($file, $Unidad2[$j] .PHP_EOL);
    }
    fwrite($file, PHP_EOL. 'DIA VIERNES' ."  -  " .$fecha5);
    for($j=0; $j<$n; $j++){ 
        fwrite($file, $Descripcion3[$j] ."\t");
        fwrite($file, $Cantidad3[$j] ."\t");
        fwrite($file, $Unidad3[$j] .PHP_EOL);
    }
    fwrite($file, PHP_EOL. 'DIA SABADO' ."  -  " .$fecha6);
    for($j=0; $j<$o; $j++){ 
        fwrite($file, $Descripcion4[$j] ."\t");
        fwrite($file, $Cantidad4[$j] ."\t");
        fwrite($file, $Unidad4[$j] .PHP_EOL);
    }
    fwrite($file, PHP_EOL. 'DIA DOMINGO' ."  -  " .$fechafinal);
    for($j=0; $j<$p; $j++){ 
        fwrite($file, $Descripcion5[$j] ."\t");
        fwrite($file, $Cantidad5[$j] ."\t");
        fwrite($file, $Unidad5[$j] .PHP_EOL);
    }
    fclose($file);
?>