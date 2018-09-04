<?php
	$fechadr = $_GET['fecha']; 
    $a = substr($fechadr, 0, -6);
    $m = substr($fechadr, 5, -3);
    $d = substr($fechadr, -2);
    $fechadr = $d.'/'.$m.'/'.$a;
    $nf = $d.'-'.$m.'-'.$a;


    //$nsrvr = $_POST['srvr'];
	$nsrvr = "ubk";	
	include '../conexion.php';
	
	//echo "esta es la ubicacion".$nsrvr;

	$con = conectarse($nsrvr);
	$i = 0;
    $k = 0;
	$h = 0;
    $p = 0;

    date_default_timezone_set('America/Mexico_City');

	$hora = date('g:i a');
    /*$fechaa = date("d/m/y");
    //$fechaa = '22/06/2018';
    $fechab = date("d/m/y");
    //$fechab = '22/06/2018';*/

    $nombrehoja = 'BVG MHUBK '.$nf;


	$sqlventas = "SELECT ROUND(SUM(((detalle.precio*detalle.cantidad)-(detalle.descuento/100)*(detalle.precio*detalle.cantidad))/((detalle.impuesto1*0.01)+1)),2,1) as TOTAL, gpo.descripcion    
                  FROM cheqdet detalle LEFT JOIN cheques tick ON detalle.foliodet = tick.folio LEFT JOIN productos prod ON detalle.idproducto = prod.idproducto RIGHT JOIN grupos gpo ON prod.idgrupo = gpo.idgrupo
                  WHERE tick.cierre BETWEEN '".$fechadr." 12:00:00 AM' AND '".$fechadr." 11:59:59 PM' AND tick.pagado = 1 and tick.cancelado =0
                  GROUP BY gpo.descripcion
                  ORDER BY gpo.descripcion ASC";

	$sqlcostos = "SELECT ROUND(SUM(ABS(insd.costo*mov.cantidad)),2,1) AS COSTO, gpo.descripcion
				  FROM movsinv mov LEFT JOIN insumosdetalle insd ON mov.idinsumo = insd.idinsumo LEFT JOIN insumos ins ON insd.idinsumo = ins.idinsumo RIGHT JOIN gruposi gpo ON ins.idgruposi = gpo.idgruposi
				  WHERE mov.fecha BETWEEN '".$fechadr." 12:00:00 AM' AND '".$fechadr." 11:59:59 PM' AND mov.idconcepto = 'SPV'
				  GROUP BY gpo.descripcion
				  ORDER BY gpo.descripcion";

    $sqldescuentos = "SELECT SUM(descuentoimporte) as TOTALDESCUENTO
                      FROM cheques
                      WHERE fecha BETWEEN '".$fechadr." 12:00:00 AM' AND '".$fechadr." 11:59:59 PM' AND descuento > 0";


	$stmt = sqlsrv_query($con, $sqlventas);
	$stmt1 = sqlsrv_query($con, $sqlcostos);
    $stmt2 = sqlsrv_query($con, $sqldescuentos);

	if( $stmt === false ) {
    	echo "Error in executing statement.\n";  
	    die( print_r( sqlsrv_errors(), true)); 
	    echo "ERROR DE DATOS";
	}else{
		while ($obj = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
		    //echo $obj['importenetosiniva']."*".$obj['descripcion']."*\n-----\n";
		    $Descripcion[] = $obj ["descripcion"];
            $Importe[] = $obj['TOTAL'];
            $i=$i+1;
		}
		/*for($j=0; $j<$i; $j++){ echo $Descripcion[$j]."\n"; echo $Importe[$j]."\n"; }*/
	}

	if( $stmt1 === false ) {
    	echo "Error in executing statement.\n";  
	    die( print_r( sqlsrv_errors(), true)); 
	    echo "ERROR DE DATOS";
	}else{
		while ($obj = sqlsrv_fetch_array($stmt1, SQLSRV_FETCH_ASSOC)) {
		    //echo $obj['importenetosiniva']."*".$obj['descripcion']."*\n-----\n";
		    $Descripcion1[] = $obj ["descripcion"];
            $Importe1[] = $obj['COSTO'];
            $h = $h + 1;
		}
		/*echo "\n===============================================OTRA LINEA===============================================================\n";
		for($j=0; $j < $k; $j++){ echo $Descripcion1[$j]."\n"; echo $Importe1[$j]."\n"; }*/
	}
    
    if( $stmt2 === false ) {
        echo "Error in executing statement.\n";  
        die( print_r( sqlsrv_errors(), true)); 
        echo "ERROR DE DATOS";
    }else{
        while ($obj = sqlsrv_fetch_array($stmt2, SQLSRV_FETCH_ASSOC)) {
            //echo $obj['importenetosiniva']."*".$obj['descripcion']."*\n-----\n";
            $descuento[] = $obj ["TOTALDESCUENTO"];
        }
        /*echo "\n===============================================OTRA LINEA===============================================================\n";
        echo $descuento[0]."\n";*/
    }

    $c1 = $i;
    $c2 = $h;

    include 'lib/PHPExcel.php';
    include 'lib/PHPExcel/Writer/Excel2007.php';
    $objPHPExcel = new PHPExcel(); //objeto excel

    /*=====SOLO NEGRITAS=====*/
    $styleArray = array(
        'font'  => array(
            'bold'  => true
    ));
    /*=====NEGRITAS Y CENTRADO=====*/
    $styleArra = array(
        'font'  => array(
            'bold'  => true
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        )
    );

    $objPHPExcel->getProperties()->setCreator("MHUBK"); // Nombre del autor

    //Propiedades del libro!
    $objPHPExcel->getProperties()->setLastModifiedBy("TI"); //Ultimo usuario que lo modificó
    $objPHPExcel->getProperties()->setTitle("BVG"); // Titulo
    $objPHPExcel->getProperties()->setSubject("R"); //Asunto
    $objPHPExcel->getProperties()->setDescription("Balance"); //Descripción

    $objPHPExcel->setActiveSheetIndex(0); //indice de hoja-libro

    $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'MOO HOUSE BURGER');
    $objPHPExcel->getActiveSheet()->SetCellValue('A2', 'MOO HOUSE S.A. DE C.V. RFC: MHO150312LKA');
    $objPHPExcel->getActiveSheet()->SetCellValue('A3', 'Av. Volcán No. 205 Ofic. 2, 6. Col. Lomas de Chapultepec III Sección. Miguel Hidalgo, CDMX CIUDAD DE MÉXICO MÉXICO CP 11000');
    $objPHPExcel->getActiveSheet()->SetCellValue('F2', $fechadr);
    $objPHPExcel->getActiveSheet()->SetCellValue('H2', $hora);

    $objPHPExcel->getActiveSheet()->SetCellValue('A6', 'Balance de ventas - Gastos');
    $objPHPExcel->getActiveSheet()->SetCellValue('E6', $fechadr);
    


    $objPHPExcel->getActiveSheet()->SetCellValue('A8', 'Venta Total de Productos por Grupos');
    $objPHPExcel->getActiveSheet()->SetCellValue('A9', 'Descripcion');
    $objPHPExcel->getActiveSheet()->SetCellValue('G9', 'Total');
    $objPHPExcel->getActiveSheet()->SetCellValue('H9', '%');

    
    /*FOR QUE ESCRIBE EL VALOR QUE TRAE EL OBJ DE VENTA*/
    $l=0;   
    for($k=11; ; $k++){
        $celda1 = "A".$k;
        $celda7 = "G".$k;
        $celda8 = "H".$k;
        //$celda13 = "M".$k;
        if($k < $i+$k){
            //echo "celda".$celda1." ".$folio[$l];
            $objPHPExcel->getActiveSheet()->SetCellValue($celda1, $Descripcion[$l]);
            $objPHPExcel->getActiveSheet()->SetCellValue($celda7, $Importe[$l]);            
            /*$objPHPExcel->getActiveSheet()->SetCellValue($celda8, $nombre[$l]);*/
            if($l < $i-1 ){ $l=$l+1; }else{ break; }
        }else{ break; }
    }

    $suma =$c1+11;
    $pie = $suma + 1;

    $celda2 = "A".$suma;
    $celda3 = "G".$suma;
    $celdap = "F".$pie;


    /*celda quqe muestra el descuento de ventas*/
    $objPHPExcel->getActiveSheet()->SetCellValue($celda2, "Descuentos");
    $objPHPExcel->getActiveSheet()->SetCellValue($celda3, "-".$descuento[0]);

    $objPHPExcel->getActiveSheet()->SetCellValue($celdap, 'TOTAL');
    //$objPHPExcel->getActiveSheet()->SetCellValue('G33', $totalv);
    $inicio = $pie + 2;

    $celdai1 = "A".$inicio;
    $celdai2 = "A".($inicio+1);
    $celdai3 = "G".($inicio+1);
    $celdai4 = "H".($inicio+1);


    $objPHPExcel->getActiveSheet()->SetCellValue($celdai1, 'Costo de Insumos');
    $objPHPExcel->getActiveSheet()->SetCellValue($celdai2, 'Descripcion');
    $objPHPExcel->getActiveSheet()->SetCellValue($celdai3, 'Total');
    $objPHPExcel->getActiveSheet()->SetCellValue($celdai4, '%');
    
    $inicioc = $inicio+2;

    $n=0;   
    for($p=$inicioc; ; $p++){
        $celda11 = "A".$p;
        $celda71 = "G".$p;
        $celda81 = "H".$p;
        //$celda13 = "M".$k;
        if($p < $h+$p){
            //echo "celda".$celda1." ".$folio[$l];
            $objPHPExcel->getActiveSheet()->SetCellValue($celda11, $Descripcion1[$n]);
            $objPHPExcel->getActiveSheet()->SetCellValue($celda71, $Importe1[$n]);            
            /*$objPHPExcel->getActiveSheet()->SetCellValue($celda8, $nombre[$l]);*/
            if($n < $h-1 ){ $n=$n+1; }else{ break; }
        }else{ break; }
    }

    $c3 = $inicioc + $h;
    $celdaf = "F".$c3;

    $objPHPExcel->getActiveSheet()->SetCellValue($celdaf, 'TOTAL');
    //$objPHPExcel->getActiveSheet()->SetCellValue('G49', $totalg);

    /*================= FORMATO DE EXCEL ===============*/
    $objPHPExcel->getActiveSheet()->getStyle('A6')->applyFromArray($styleArray); //BALANCE DE VENTAS
    $objPHPExcel->getActiveSheet()->getStyle('A8')->applyFromArray($styleArray); //VENTA TOTAL
    $objPHPExcel->getActiveSheet()->getStyle('A9')->applyFromArray($styleArray); //DESCRIPCION

    $objPHPExcel->getActiveSheet()->getStyle('G9')->applyFromArray($styleArra); //TOTAL CABECERA
    $objPHPExcel->getActiveSheet()->getStyle('H9')->applyFromArray($styleArra); //%

    $objPHPExcel->getActiveSheet()->getStyle($celdap)->applyFromArray($styleArra); //TOTAL DE ABAJO

    $objPHPExcel->getActiveSheet()->getStyle($celdai1)->applyFromArray($styleArray); //COSTO
    $objPHPExcel->getActiveSheet()->getStyle($celdai2)->applyFromArray($styleArray); //DESCRIPCION
    $objPHPExcel->getActiveSheet()->getStyle($celdai3)->applyFromArray($styleArra); //TOTAL CABECERA
    $objPHPExcel->getActiveSheet()->getStyle($celdai4)->applyFromArray($styleArra); //%

    $objPHPExcel->getActiveSheet()->getStyle($celdaf)->applyFromArray($styleArra); //TOTAL DE ABAJO

    /*===UNIR Y AJUSTAR EL TEXTO===*/
    $objPHPExcel->getActiveSheet()->mergeCells('A3:H4'); 
    $objPHPExcel->getActiveSheet()->getStyle('A3:H4')->getAlignment()->setWrapText(true);

    $objPHPExcel->getActiveSheet()->setTitle($nombrehoja);//nombramiento de la hoja

    // Se manda el archivo al navegador web, con el nombre que se indica (Excel2007)
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="BVG MHUBK'.$nf.'.xlsx"');
    header('Cache-Control: max-age=0');

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');

?>