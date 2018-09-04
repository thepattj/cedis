<?php
    $fechadr = $_GET['fecha']; 
    $a = substr($fechadr, 0, -6);
    $m = substr($fechadr, 5, -3);
    $d = substr($fechadr, -2);
    $fechadr = $d.'/'.$m.'/'.$a;
    //echo $fechadr;
    $d2 = $d-($d-1);
    if($d2 == 1){ $d2 = '01';}
    $fechapm = $d2.'/'.$m.'/'.$a;       
    //echo '-'.$fechapm;

    $serverName = "25.102.99.218,1989";
    $connectionInfo = array( "Database"=>"softrestaurant95pro_cedis", "UID"=>"sa", "PWD"=>"National09");  
    $conn = sqlsrv_connect( $serverName, $connectionInfo);
    if( $conn === false ){  
        echo "Could not connect a bqa\n\n";  
        die( print_r( sqlsrv_errors(), true));  
    }
    date_default_timezone_set('America/Mexico_City');

    $hora = date('g:i a');

    $nombrehoja = 'Reporte Mensual';

    //echo $fechapm.'FECHA DEL LUNES'.$fechadr;

     $sql = "SELECT  dbo.cheqdet.foliodet as folio, dbo.cheques.idcliente, dbo.clientes.nombre, dbo.cheqdet.idproducto, dbo.productos.descripcion, dbo.cheqdet.precio AS costo, dbo.cheqdet.cantidad, dbo.cheqdet.impuesto1 AS IVA, (dbo.cheqdet.precio*dbo.cheqdet.cantidad) AS TOTAL, dbo.cheques.numcheque, dbo.cheques.cierre, dbo.cheques.fecha

            FROM dbo.cheques INNER JOIN dbo.empresas ON dbo.cheques.idempresa = dbo.empresas.idempresa
                             INNER JOIN dbo.cheqdet ON dbo.cheques.folio = dbo.cheqdet.foliodet
                             INNER JOIN dbo.productos ON dbo.cheqdet.idproducto = dbo.productos.idproducto
                             INNER JOIN dbo.clientes ON dbo.cheques.idcliente = dbo.clientes.idcliente
            WHERE dbo.cheques.cancelado = 0 AND dbo.cheques.cierre BETWEEN '".$fechapm." 12:00:00 AM' AND '".$fechadr." 11:59:59 PM' ORDER BY dbo.cheques.idcliente ASC, dbo.cheques.cierre ASC";
    //echo $sql;

    $i=0;
    $cont=0;       

    $stmt = sqlsrv_query($conn, $sql);
   if( $stmt === false ) {
        echo "Error in executing statement.\n";  
        die( print_r( sqlsrv_errors(), true)); 
        echo "ERROR DE DATOS";
    }else{
        while ($obj = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            //echo $obj['seriefolio']."*".$obj['folio']."*".$obj['descuentocuenta']."*".$obj['foliodet']."*".$obj['idcliente']."*".$obj['nombre']."*".$obj['costo']."*".$obj['cantidad']."*".$obj['idproducto']."*".$obj['descripcion']."*".$obj['preciocatalogo']."*".$obj['IVA']."*".$obj['numcheque']."*".$obj['cancelado']."*".date_format($obj['cierre'],'d-m-Y')."*".date_format($obj['fecha'],'d-m-Y')."*";

            $cliente[] = trim($obj['idcliente']);
            $nombre[] = trim($obj['nombre']);
            $folio[] = trim($obj ["folio"]);
            $idproducto[] = $obj['idproducto'];
            $nombreproducto[] = utf8_encode($obj['descripcion']);
            $costo[] = $obj['costo'];
            $cantidad[] = $obj['cantidad'];
            $iva[] = $obj['IVA'];
            $total[] = $obj['TOTAL'];            
            $numcheque[] = $obj['numcheque'];
            $cierre[] = date_format($obj['cierre'],'d-m-Y H:i:s');
            $fecha[] = date_format($obj['fecha'],'d-m-Y');
            $i=$i+1;
        }
        //for($j=0; $j<$i; $j++){ echo $cliente[$j]."\n"; echo "\t================================\t"; }
    }

    include 'lib/PHPExcel.php';
    include 'lib/PHPExcel/Writer/Excel2007.php';
    $objPHPExcel = new PHPExcel(); //objeto excel

    $objPHPExcel->getProperties()->setCreator("CEDIS"); // Nombre del autor

    //Propiedades del libro!
    $objPHPExcel->getProperties()->setLastModifiedBy("Josue"); //Ultimo usuario que lo modificó
    $objPHPExcel->getProperties()->setTitle("Reporte de ventas por sucursal"); // Titulo
    $objPHPExcel->getProperties()->setSubject("R"); //Asunto
    $objPHPExcel->getProperties()->setDescription("Reporte"); //Descripción

    $objPHPExcel->getActiveSheet();

    $creacion = 0;
    $escribir = 0;

    for($a=0; $a<$i; $a++){

        if ($cliente[$a] == "OHUCR") {
            if($escribir == 7){
                $objPHPExcel->setActiveSheetIndex(7);
                $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'MOO HOUSE BURGER');
                $objPHPExcel->getActiveSheet()->SetCellValue('A2', 'MOO HOUSE S.A. DE C.V. RFC: MHO150312LKA');
                $objPHPExcel->getActiveSheet()->SetCellValue('A3', 'Av. Volcán No. 205 Ofic. 2, 6. Col. Lomas de Chapultepec III Sección. Miguel Hidalgo, CDMX CIUDAD DE MÉXICO MÉXICO CP 11000');
                $objPHPExcel->getActiveSheet()->SetCellValue('K2', $fechapm);
                $objPHPExcel->getActiveSheet()->SetCellValue('K3', $hora);

                $objPHPExcel->getActiveSheet()->SetCellValue('A6', 'Detalle de ventas del día');
                $objPHPExcel->getActiveSheet()->SetCellValue('D6', $fechapm);
                $objPHPExcel->getActiveSheet()->SetCellValue('E6', 'A');
                $objPHPExcel->getActiveSheet()->SetCellValue('F6', $fechadr);
                
                $objPHPExcel->getActiveSheet()->SetCellValue('I5', 'TOTAL VENTA');
                $objPHPExcel->getActiveSheet()->SetCellValue('I6', '=SUMA(i11:i100)');
                $formula = $objPHPExcel->getActiveSheet()->getCell('I6')->getValue();

                $objPHPExcel->getActiveSheet()->SetCellValue('A9', 'Folio');
                $objPHPExcel->getActiveSheet()->SetCellValue('B9', 'Cliente');
                $objPHPExcel->getActiveSheet()->SetCellValue('C9', 'Nombre Cliente');
                $objPHPExcel->getActiveSheet()->SetCellValue('D9', 'Clave Producto');
                $objPHPExcel->getActiveSheet()->SetCellValue('E9', 'Descripcion');
                $objPHPExcel->getActiveSheet()->SetCellValue('F9', 'Costo');
                $objPHPExcel->getActiveSheet()->SetCellValue('G9', 'Cantidad');
                $objPHPExcel->getActiveSheet()->SetCellValue('H9', 'IVA');
                $objPHPExcel->getActiveSheet()->SetCellValue('I9', 'TOTAL');
                $objPHPExcel->getActiveSheet()->SetCellValue('J9', 'NO. Cheque');
                $objPHPExcel->getActiveSheet()->SetCellValue('K9', 'Cierre');
                $objPHPExcel->getActiveSheet()->SetCellValue('L9', 'Fecha Pedido');

                $l = $a;
                for($k = 11; ; $k++){
                    $celda1 = "A".$k;
                    $celda2 = "B".$k;
                    $celda3 = "C".$k;
                    $celda4 = "D".$k;
                    $celda5 = "E".$k;
                    $celda6 = "F".$k;
                    $celda7 = "G".$k;
                    $celda8 = "H".$k;
                    $celda9 = "I".$k;
                    $celda10 = "J".$k;
                    $celda11 = "K".$k;
                    $celda12 = "L".$k;
                    if($k<$i+$k){
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda1, $folio[$a]);
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda2, $cliente[$a]);            
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda3, $nombre[$a]);
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda4, $idproducto[$a]);
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda5, $nombreproducto[$a]);
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda6, $costo[$a]);
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda7, $cantidad[$a]);
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda8, $iva[$a]);
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda9, $total[$a]);           
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda10, $numcheque[$a]);
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda11, $cierre[$a]);
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda12, $fecha[$a]);
                        //$objPHPExcel->getActiveSheet()->SetCellValue($celda, $a);
                        //if(($cliente[$a+1] == 'OHUCR')||($a+1 <= $i-1)){ $a=$a+1; } else{ break; }
                        if($a < $i-1 ){ $a=$a+1; }else{ break; }
                    }else{ break; }                        
                }
                
                $objPHPExcel->getActiveSheet()->setTitle('OHUCR');
                //$escribir = 6;
            }
        } if ($cliente[$a] == "MHUPT") {
            if($escribir == 6){
                $objPHPExcel->setActiveSheetIndex(6);
                $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'MOO HOUSE BURGER');
                $objPHPExcel->getActiveSheet()->SetCellValue('A2', 'MOO HOUSE S.A. DE C.V. RFC: MHO150312LKA');
                $objPHPExcel->getActiveSheet()->SetCellValue('A3', 'Av. Volcán No. 205 Ofic. 2, 6. Col. Lomas de Chapultepec III Sección. Miguel Hidalgo, CDMX CIUDAD DE MÉXICO MÉXICO CP 11000');
                $objPHPExcel->getActiveSheet()->SetCellValue('K2', $fechapm);
                $objPHPExcel->getActiveSheet()->SetCellValue('K3', $hora);

                $objPHPExcel->getActiveSheet()->SetCellValue('A6', 'Detalle de ventas del día');
                $objPHPExcel->getActiveSheet()->SetCellValue('D6', $fechapm);
                $objPHPExcel->getActiveSheet()->SetCellValue('E6', 'A');
                $objPHPExcel->getActiveSheet()->SetCellValue('F6', $fechadr);

                $objPHPExcel->getActiveSheet()->SetCellValue('I5', 'TOTAL VENTA');
                $objPHPExcel->getActiveSheet()->SetCellValue('I6', '=SUMA(i11:i100)');
                $formula = $objPHPExcel->getActiveSheet()->getCell('I6')->getValue();

                $objPHPExcel->getActiveSheet()->SetCellValue('A9', 'Folio');
                $objPHPExcel->getActiveSheet()->SetCellValue('B9', 'Cliente');
                $objPHPExcel->getActiveSheet()->SetCellValue('C9', 'Nombre Cliente');
                $objPHPExcel->getActiveSheet()->SetCellValue('D9', 'Clave Producto');
                $objPHPExcel->getActiveSheet()->SetCellValue('E9', 'Descripcion');
                $objPHPExcel->getActiveSheet()->SetCellValue('F9', 'Costo');
                $objPHPExcel->getActiveSheet()->SetCellValue('G9', 'Cantidad');
                $objPHPExcel->getActiveSheet()->SetCellValue('H9', 'IVA');
                $objPHPExcel->getActiveSheet()->SetCellValue('I9', 'TOTAL');
                $objPHPExcel->getActiveSheet()->SetCellValue('J9', 'NO. Cheque');
                $objPHPExcel->getActiveSheet()->SetCellValue('K9', 'Cierre');
                $objPHPExcel->getActiveSheet()->SetCellValue('L9', 'Fecha Pedido');

                $l = $a;
                for($k = 11; ; $k++){
                    $celda1 = "A".$k;
                    $celda2 = "B".$k;
                    $celda3 = "C".$k;
                    $celda4 = "D".$k;
                    $celda5 = "E".$k;
                    $celda6 = "F".$k;
                    $celda7 = "G".$k;
                    $celda8 = "H".$k;
                    $celda9 = "I".$k;
                    $celda10 = "J".$k;
                    $celda11 = "K".$k;
                    $celda12 = "L".$k;
                    if($k<$i+$k){
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda1, $folio[$l]);
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda2, $cliente[$l]);            
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda3, $nombre[$l]);
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda4, $idproducto[$l]);
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda5, $nombreproducto[$l]);
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda6, $costo[$l]);
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda7, $cantidad[$l]);
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda8, $iva[$l]);
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda9, $total[$l]);           
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda10, $numcheque[$l]);
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda11, $cierre[$l]);
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda12, $fecha[$l]);
                        //$objPHPExcel->getActiveSheet()->SetCellValue($celda, $a);
                        if($cliente[$l+1] == 'MHUPT'){ $l=$l+1; } else{ break; }
                    }else{ break; }                        
                }
                
             
                $objPHPExcel->getActiveSheet()->setTitle('MHUPT');
                $escribir = 7;
            }
        }if ($cliente[$a] == "MHUBK") {
            if($escribir == 5){
                $objPHPExcel->setActiveSheetIndex(5);
                $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'MOO HOUSE BURGER');
                $objPHPExcel->getActiveSheet()->SetCellValue('A2', 'MOO HOUSE S.A. DE C.V. RFC: MHO150312LKA');
                $objPHPExcel->getActiveSheet()->SetCellValue('A3', 'Av. Volcán No. 205 Ofic. 2, 6. Col. Lomas de Chapultepec III Sección. Miguel Hidalgo, CDMX CIUDAD DE MÉXICO MÉXICO CP 11000');
                $objPHPExcel->getActiveSheet()->SetCellValue('K2', $fechapm);
                $objPHPExcel->getActiveSheet()->SetCellValue('K3', $hora);

                $objPHPExcel->getActiveSheet()->SetCellValue('A6', 'Detalle de ventas del día');
                $objPHPExcel->getActiveSheet()->SetCellValue('D6', $fechapm);
                $objPHPExcel->getActiveSheet()->SetCellValue('E6', 'A');
                $objPHPExcel->getActiveSheet()->SetCellValue('F6', $fechadr);

                $objPHPExcel->getActiveSheet()->SetCellValue('I5', 'TOTAL VENTA');
                $objPHPExcel->getActiveSheet()->SetCellValue('I6', '=SUMA(i11:i100)');
                $formula = $objPHPExcel->getActiveSheet()->getCell('I6')->getValue();

                $objPHPExcel->getActiveSheet()->SetCellValue('A9', 'Folio');
                $objPHPExcel->getActiveSheet()->SetCellValue('B9', 'Cliente');
                $objPHPExcel->getActiveSheet()->SetCellValue('C9', 'Nombre Cliente');
                $objPHPExcel->getActiveSheet()->SetCellValue('D9', 'Clave Producto');
                $objPHPExcel->getActiveSheet()->SetCellValue('E9', 'Descripcion');
                $objPHPExcel->getActiveSheet()->SetCellValue('F9', 'Costo');
                $objPHPExcel->getActiveSheet()->SetCellValue('G9', 'Cantidad');
                $objPHPExcel->getActiveSheet()->SetCellValue('H9', 'IVA');
                $objPHPExcel->getActiveSheet()->SetCellValue('I9', 'TOTAL');
                $objPHPExcel->getActiveSheet()->SetCellValue('J9', 'NO. Cheque');
                $objPHPExcel->getActiveSheet()->SetCellValue('K9', 'Cierre');
                $objPHPExcel->getActiveSheet()->SetCellValue('L9', 'Fecha Pedido');



                $l = $a;
                for($k=11; ; $k++){
                    $celda1 = "A".$k;
                    $celda2 = "B".$k;
                    $celda3 = "C".$k;
                    $celda4 = "D".$k;
                    $celda5 = "E".$k;
                    $celda6 = "F".$k;
                    $celda7 = "G".$k;
                    $celda8 = "H".$k;
                    $celda9 = "I".$k;
                    $celda10 = "J".$k;
                    $celda11 = "K".$k;
                    $celda12 = "L".$k;
                    //$celda13 = "M".$k;
                    if($k < $i+$k){
                        //echo "celda".$celda1." ".$folio[$l];
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda1, $folio[$l]);
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda2, $cliente[$l]);            
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda3, $nombre[$l]);
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda4, $idproducto[$l]);
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda5, $nombreproducto[$l]);
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda6, $costo[$l]);
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda7, $cantidad[$l]);
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda8, $iva[$l]);
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda9, $total[$l]);           
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda10, $numcheque[$l]);
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda11, $cierre[$l]);
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda12, $fecha[$l]);
                        if($cliente[$l+1] == 'MHUBK'){ $l=$l+1; }else{ break; }
                    }else{ break; }               
                }

                $objPHPExcel->getActiveSheet()->setTitle('MHUBK');
                $escribir = $escribir +1;
            }
        }if ($cliente[$a] == "MHLVA") {
            if($escribir == 4) {
                $objPHPExcel->setActiveSheetIndex(4);
                $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'MOO HOUSE BURGER');
                $objPHPExcel->getActiveSheet()->SetCellValue('A2', 'MOO HOUSE S.A. DE C.V. RFC: MHO150312LKA');
                $objPHPExcel->getActiveSheet()->SetCellValue('A3', 'Av. Volcán No. 205 Ofic. 2, 6. Col. Lomas de Chapultepec III Sección. Miguel Hidalgo, CDMX CIUDAD DE MÉXICO MÉXICO CP 11000');
                $objPHPExcel->getActiveSheet()->SetCellValue('K2', $fechapm);
                $objPHPExcel->getActiveSheet()->SetCellValue('K3', $hora);

                $objPHPExcel->getActiveSheet()->SetCellValue('A6', 'Detalle de ventas del día');
                $objPHPExcel->getActiveSheet()->SetCellValue('D6', $fechapm);
                $objPHPExcel->getActiveSheet()->SetCellValue('E6', 'A');
                $objPHPExcel->getActiveSheet()->SetCellValue('F6', $fechadr);

                $objPHPExcel->getActiveSheet()->SetCellValue('I5', 'TOTAL VENTA');
                $objPHPExcel->getActiveSheet()->SetCellValue('I6', '=SUMA(i11:i100)');
                $formula = $objPHPExcel->getActiveSheet()->getCell('I6')->getValue();

                $objPHPExcel->getActiveSheet()->SetCellValue('A9', 'Folio');
                $objPHPExcel->getActiveSheet()->SetCellValue('B9', 'Cliente');
                $objPHPExcel->getActiveSheet()->SetCellValue('C9', 'Nombre Cliente');
                $objPHPExcel->getActiveSheet()->SetCellValue('D9', 'Clave Producto');
                $objPHPExcel->getActiveSheet()->SetCellValue('E9', 'Descripcion');
                $objPHPExcel->getActiveSheet()->SetCellValue('F9', 'Costo');
                $objPHPExcel->getActiveSheet()->SetCellValue('G9', 'Cantidad');
                $objPHPExcel->getActiveSheet()->SetCellValue('H9', 'IVA');
                $objPHPExcel->getActiveSheet()->SetCellValue('I9', 'TOTAL');
                $objPHPExcel->getActiveSheet()->SetCellValue('J9', 'NO. Cheque');
                $objPHPExcel->getActiveSheet()->SetCellValue('K9', 'Cierre');
                $objPHPExcel->getActiveSheet()->SetCellValue('L9', 'Fecha Pedido');

                $l = $a;
                for($k = 11; ; $k++){
                    $celda1 = "A".$k;
                    $celda2 = "B".$k;
                    $celda3 = "C".$k;
                    $celda4 = "D".$k;
                    $celda5 = "E".$k;
                    $celda6 = "F".$k;
                    $celda7 = "G".$k;
                    $celda8 = "H".$k;
                    $celda9 = "I".$k;
                    $celda10 = "J".$k;
                    $celda11 = "K".$k;
                    $celda12 = "L".$k;
                    if($k<$i+$k){
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda1, $folio[$l]);
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda2, $cliente[$l]);            
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda3, $nombre[$l]);
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda4, $idproducto[$l]);
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda5, $nombreproducto[$l]);
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda6, $costo[$l]);
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda7, $cantidad[$l]);
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda8, $iva[$l]);
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda9, $total[$l]);           
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda10, $numcheque[$l]);
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda11, $cierre[$l]);
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda12, $fecha[$l]);
                        //$objPHPExcel->getActiveSheet()->SetCellValue($celda, $a);
                        if($cliente[$l+1] == 'MHLVA'){ $l=$l+1; } else{ break; }
                    }else{ break; }                        
                }
                
             
                $objPHPExcel->getActiveSheet()->setTitle('MHLVA');
                $escribir = $escribir +1;
            }
        } if ($cliente[$a] == "MHBQA") {
            if($escribir == 3){
                $objPHPExcel->setActiveSheetIndex(3);
                $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'MOO HOUSE BURGER');
                $objPHPExcel->getActiveSheet()->SetCellValue('A2', 'MOO HOUSE S.A. DE C.V. RFC: MHO150312LKA');
                $objPHPExcel->getActiveSheet()->SetCellValue('A3', 'Av. Volcán No. 205 Ofic. 2, 6. Col. Lomas de Chapultepec III Sección. Miguel Hidalgo, CDMX CIUDAD DE MÉXICO MÉXICO CP 11000');
                $objPHPExcel->getActiveSheet()->SetCellValue('K2', $fechapm);
                $objPHPExcel->getActiveSheet()->SetCellValue('K3', $hora);

                $objPHPExcel->getActiveSheet()->SetCellValue('A6', 'Detalle de ventas del día');
                $objPHPExcel->getActiveSheet()->SetCellValue('D6', $fechapm);
                $objPHPExcel->getActiveSheet()->SetCellValue('E6', 'A');
                $objPHPExcel->getActiveSheet()->SetCellValue('F6', $fechadr);

                $objPHPExcel->getActiveSheet()->SetCellValue('I5', 'TOTAL VENTA');
                $objPHPExcel->getActiveSheet()->SetCellValue('I6', '=SUMA(i11:i100)');
                $formula = $objPHPExcel->getActiveSheet()->getCell('I6')->getValue();

                $objPHPExcel->getActiveSheet()->SetCellValue('A9', 'Folio');
                $objPHPExcel->getActiveSheet()->SetCellValue('B9', 'Cliente');
                $objPHPExcel->getActiveSheet()->SetCellValue('C9', 'Nombre Cliente');
                $objPHPExcel->getActiveSheet()->SetCellValue('D9', 'Clave Producto');
                $objPHPExcel->getActiveSheet()->SetCellValue('E9', 'Descripcion');
                $objPHPExcel->getActiveSheet()->SetCellValue('F9', 'Costo');
                $objPHPExcel->getActiveSheet()->SetCellValue('G9', 'Cantidad');
                $objPHPExcel->getActiveSheet()->SetCellValue('H9', 'IVA');
                $objPHPExcel->getActiveSheet()->SetCellValue('I9', 'TOTAL');
                $objPHPExcel->getActiveSheet()->SetCellValue('J9', 'NO. Cheque');
                $objPHPExcel->getActiveSheet()->SetCellValue('K9', 'Cierre');
                $objPHPExcel->getActiveSheet()->SetCellValue('L9', 'Fecha Pedido');

                $l = $a;
                for($k=11; ; $k++){
                    $celda1 = "A".$k;
                    $celda2 = "B".$k;
                    $celda3 = "C".$k;
                    $celda4 = "D".$k;
                    $celda5 = "E".$k;
                    $celda6 = "F".$k;
                    $celda7 = "G".$k;
                    $celda8 = "H".$k;
                    $celda9 = "I".$k;
                    $celda10 = "J".$k;
                    $celda11 = "K".$k;
                    $celda12 = "L".$k;
                    //$celda13 = "M".$k;
                    if($k < $i+$k){
                        //echo "celda".$celda1." ".$folio[$l];
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda1, $folio[$l]);
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda2, $cliente[$l]);            
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda3, $nombre[$l]);
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda4, $idproducto[$l]);
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda5, $nombreproducto[$l]);
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda6, $costo[$l]);
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda7, $cantidad[$l]);
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda8, $iva[$l]);
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda9, $total[$l]);           
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda10, $numcheque[$l]);
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda11, $cierre[$l]);
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda12, $fecha[$l]);
                        if($cliente[$l+1] == 'MHBQA'){ $l=$l+1; }else{ break; }
                    }else{ break; }               
                }

                $objPHPExcel->getActiveSheet()->setTitle('MHBQA');
                $escribir = $escribir +1;
            }
        } if ($cliente[$a] == "BRUBK") {
            if($escribir == 2){
                $objPHPExcel->setActiveSheetIndex(2);
                $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'MOO HOUSE BURGER');
                $objPHPExcel->getActiveSheet()->SetCellValue('A2', 'MOO HOUSE S.A. DE C.V. RFC: MHO150312LKA');
                $objPHPExcel->getActiveSheet()->SetCellValue('A3', 'Av. Volcán No. 205 Ofic. 2, 6. Col. Lomas de Chapultepec III Sección. Miguel Hidalgo, CDMX CIUDAD DE MÉXICO MÉXICO CP 11000');
                $objPHPExcel->getActiveSheet()->SetCellValue('K2', $fechapm);
                $objPHPExcel->getActiveSheet()->SetCellValue('K3', $hora);

                $objPHPExcel->getActiveSheet()->SetCellValue('A6', 'Detalle de ventas del día');
                $objPHPExcel->getActiveSheet()->SetCellValue('D6', $fechapm);
                $objPHPExcel->getActiveSheet()->SetCellValue('E6', 'A');
                $objPHPExcel->getActiveSheet()->SetCellValue('F6', $fechadr);

                $objPHPExcel->getActiveSheet()->SetCellValue('I5', 'TOTAL VENTA');
                $objPHPExcel->getActiveSheet()->SetCellValue('I6', '=SUMA(i11:i100)');
                $formula = $objPHPExcel->getActiveSheet()->getCell('I6')->getValue();

                $objPHPExcel->getActiveSheet()->SetCellValue('A9', 'Folio');
                $objPHPExcel->getActiveSheet()->SetCellValue('B9', 'Cliente');
                $objPHPExcel->getActiveSheet()->SetCellValue('C9', 'Nombre Cliente');
                $objPHPExcel->getActiveSheet()->SetCellValue('D9', 'Clave Producto');
                $objPHPExcel->getActiveSheet()->SetCellValue('E9', 'Descripcion');
                $objPHPExcel->getActiveSheet()->SetCellValue('F9', 'Costo');
                $objPHPExcel->getActiveSheet()->SetCellValue('G9', 'Cantidad');
                $objPHPExcel->getActiveSheet()->SetCellValue('H9', 'IVA');
                $objPHPExcel->getActiveSheet()->SetCellValue('I9', 'TOTAL');
                $objPHPExcel->getActiveSheet()->SetCellValue('J9', 'NO. Cheque');
                $objPHPExcel->getActiveSheet()->SetCellValue('K9', 'Cierre');
                $objPHPExcel->getActiveSheet()->SetCellValue('L9', 'Fecha Pedido');

                $l = $a;
                for($k=11; ; $k++){
                    $celda1 = "A".$k;
                    $celda2 = "B".$k;
                    $celda3 = "C".$k;
                    $celda4 = "D".$k;
                    $celda5 = "E".$k;
                    $celda6 = "F".$k;
                    $celda7 = "G".$k;
                    $celda8 = "H".$k;
                    $celda9 = "I".$k;
                    $celda10 = "J".$k;
                    $celda11 = "K".$k;
                    $celda12 = "L".$k;
                    //$celda13 = "M".$k;
                    if($k < $i+$k){
                        //echo "celda".$celda1." ".$folio[$l];
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda1, $folio[$l]);
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda2, $cliente[$l]);            
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda3, $nombre[$l]);
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda4, $idproducto[$l]);
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda5, $nombreproducto[$l]);
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda6, $costo[$l]);
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda7, $cantidad[$l]);
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda8, $iva[$l]);
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda9, $total[$l]);           
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda10, $numcheque[$l]);
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda11, $cierre[$l]);
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda12, $fecha[$l]);
                        if($cliente[$l+1] == 'BRUBK'){ $l=$l+1; }else{ break; }
                    }else{ break; }               
                }

                $objPHPExcel->getActiveSheet()->setTitle('BRUBK');
                $escribir = $escribir +1;
            }
        } if ($cliente[$a] == "BRALM") {
            if($escribir == 1) {
                $objPHPExcel->setActiveSheetIndex(1);
                $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'MOO HOUSE BURGER');
                $objPHPExcel->getActiveSheet()->SetCellValue('A2', 'MOO HOUSE S.A. DE C.V. RFC: MHO150312LKA');
                $objPHPExcel->getActiveSheet()->SetCellValue('A3', 'Av. Volcán No. 205 Ofic. 2, 6. Col. Lomas de Chapultepec III Sección. Miguel Hidalgo, CDMX CIUDAD DE MÉXICO MÉXICO CP 11000');
                $objPHPExcel->getActiveSheet()->SetCellValue('K2', $fechapm);
                $objPHPExcel->getActiveSheet()->SetCellValue('K3', $hora);

                $objPHPExcel->getActiveSheet()->SetCellValue('A6', 'Detalle de ventas del día');
                $objPHPExcel->getActiveSheet()->SetCellValue('D6', $fechapm);
                $objPHPExcel->getActiveSheet()->SetCellValue('E6', 'A');
                $objPHPExcel->getActiveSheet()->SetCellValue('F6', $fechadr);

                $objPHPExcel->getActiveSheet()->SetCellValue('I5', 'TOTAL VENTA');
                $objPHPExcel->getActiveSheet()->SetCellValue('I6', '=SUMA(i11:i100)');
                $formula = $objPHPExcel->getActiveSheet()->getCell('I6')->getValue();

                $objPHPExcel->getActiveSheet()->SetCellValue('A9', 'Folio');
                $objPHPExcel->getActiveSheet()->SetCellValue('B9', 'Cliente');
                $objPHPExcel->getActiveSheet()->SetCellValue('C9', 'Nombre Cliente');
                $objPHPExcel->getActiveSheet()->SetCellValue('D9', 'Clave Producto');
                $objPHPExcel->getActiveSheet()->SetCellValue('E9', 'Descripcion');
                $objPHPExcel->getActiveSheet()->SetCellValue('F9', 'Costo');
                $objPHPExcel->getActiveSheet()->SetCellValue('G9', 'Cantidad');
                $objPHPExcel->getActiveSheet()->SetCellValue('H9', 'IVA');
                $objPHPExcel->getActiveSheet()->SetCellValue('I9', 'TOTAL');
                $objPHPExcel->getActiveSheet()->SetCellValue('J9', 'NO. Cheque');
                $objPHPExcel->getActiveSheet()->SetCellValue('K9', 'Cierre');
                $objPHPExcel->getActiveSheet()->SetCellValue('L9', 'Fecha Pedido');

                $l = $a;
                for($k=11; ; $k++){
                    $celda1 = "A".$k;
                    $celda2 = "B".$k;
                    $celda3 = "C".$k;
                    $celda4 = "D".$k;
                    $celda5 = "E".$k;
                    $celda6 = "F".$k;
                    $celda7 = "G".$k;
                    $celda8 = "H".$k;
                    $celda9 = "I".$k;
                    $celda10 = "J".$k;
                    $celda11 = "K".$k;
                    $celda12 = "L".$k;
                    //$celda13 = "M".$k;
                    if($k < $i+$k){
                        //echo "celda".$celda1." ".$folio[$l];
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda1, $folio[$l]);
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda2, $cliente[$l]);            
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda3, $nombre[$l]);
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda4, $idproducto[$l]);
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda5, $nombreproducto[$l]);
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda6, $costo[$l]);
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda7, $cantidad[$l]);
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda8, $iva[$l]);
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda9, $total[$l]);           
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda10, $numcheque[$l]);
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda11, $cierre[$l]);
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda12, $fecha[$l]);
                        if($cliente[$l+1] == 'BRALM'){ $l=$l+1; }else{ break; }
                    }else{ break; }               
                }

                $objPHPExcel->getActiveSheet()->setTitle('BRALM');
                $escribir = $escribir +1;
            }
        } if ($cliente[$a] == "BKBQA") {
            if($creacion < 7){
                $objPHPExcel->createSheet();
                $creacion = $creacion + 1;
            }if($escribir == 0){
                $objPHPExcel->setActiveSheetIndex(0);

                $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'MOO HOUSE BURGER');
                $objPHPExcel->getActiveSheet()->SetCellValue('A2', 'MOO HOUSE S.A. DE C.V. RFC: MHO150312LKA');
                $objPHPExcel->getActiveSheet()->SetCellValue('A3', 'Av. Volcán No. 205 Ofic. 2, 6. Col. Lomas de Chapultepec III Sección. Miguel Hidalgo, CDMX CIUDAD DE MÉXICO MÉXICO CP 11000');
                $objPHPExcel->getActiveSheet()->SetCellValue('K2', $fechapm);
                $objPHPExcel->getActiveSheet()->SetCellValue('K3', $hora);

                $objPHPExcel->getActiveSheet()->SetCellValue('A6', 'Detalle de ventas del día');
                $objPHPExcel->getActiveSheet()->SetCellValue('D6', $fechapm);
                $objPHPExcel->getActiveSheet()->SetCellValue('E6', 'A');
                $objPHPExcel->getActiveSheet()->SetCellValue('F6', $fechadr);

                $objPHPExcel->getActiveSheet()->SetCellValue('I5', 'TOTAL VENTA');
                $objPHPExcel->getActiveSheet()->SetCellValue('I6', '=SUMA(i11:i100)');
                $formula = $objPHPExcel->getActiveSheet()->getCell('I6')->getValue();

                $objPHPExcel->getActiveSheet()->SetCellValue('A9', 'Folio');
                $objPHPExcel->getActiveSheet()->SetCellValue('B9', 'Cliente');
                $objPHPExcel->getActiveSheet()->SetCellValue('C9', 'Nombre Cliente');
                $objPHPExcel->getActiveSheet()->SetCellValue('D9', 'Clave Producto');
                $objPHPExcel->getActiveSheet()->SetCellValue('E9', 'Descripcion');
                $objPHPExcel->getActiveSheet()->SetCellValue('F9', 'Costo');
                $objPHPExcel->getActiveSheet()->SetCellValue('G9', 'Cantidad');
                $objPHPExcel->getActiveSheet()->SetCellValue('H9', 'IVA');
                $objPHPExcel->getActiveSheet()->SetCellValue('I9', 'TOTAL');
                $objPHPExcel->getActiveSheet()->SetCellValue('J9', 'NO. Cheque');
                $objPHPExcel->getActiveSheet()->SetCellValue('K9', 'Cierre');
                $objPHPExcel->getActiveSheet()->SetCellValue('L9', 'Fecha Pedido');       

                $l = $a;
                for($k=11; ; $k++){
                    $celda1 = "A".$k;
                    $celda2 = "B".$k;
                    $celda3 = "C".$k;
                    $celda4 = "D".$k;
                    $celda5 = "E".$k;
                    $celda6 = "F".$k;
                    $celda7 = "G".$k;
                    $celda8 = "H".$k;
                    $celda9 = "I".$k;
                    $celda10 = "J".$k;
                    $celda11 = "K".$k;
                    $celda12 = "L".$k;
                    //$celda13 = "M".$k;
                    if($k < $i+$k){
                        //echo "celda".$celda1." ".$folio[$l];
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda1, $folio[$l]);
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda2, $cliente[$l]);            
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda3, $nombre[$l]);
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda4, $idproducto[$l]);
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda5, $nombreproducto[$l]);
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda6, $costo[$l]);
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda7, $cantidad[$l]);
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda8, $iva[$l]);
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda9, $total[$l]);           
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda10, $numcheque[$l]);
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda11, $cierre[$l]);
                        $objPHPExcel->getActiveSheet()->SetCellValue($celda12, $fecha[$l]);
                        if($cliente[$l+1] == 'BKBQA'){ $l=$l+1; }else{ break; }
                    }else{ break; }
                }
                $objPHPExcel->getActiveSheet()->setTitle('BKBQA');
                $escribir = $escribir +1;
            }
        }  
    }

    // Se manda el archivo al navegador web, con el nombre que se indica (Excel2007)
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="DetalleVentas.xlsx"');
    header('Cache-Control: max-age=0');

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');
?>