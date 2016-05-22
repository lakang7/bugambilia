<?php
    require_once('../recursos/tcpdf/tcpdf.php');
    require_once('../recursos/funciones.php');
    
    $pagina=1;
    $con=Conexion();
	$sql_propatron="select pr.idproducto ID, pr.descripcion DES, pr.preciofabrica PRECIO,tp.codig TPCOD,tp.nombre TPNOM, cp.nombreespanol CATNOM,	pp.nombreespanol PPNOM, ma.nombre MATNOM, pr.dimensionlargo LARGO, pr.dimensionancho ANCHO,pr.dimensionalto ALTO, pr.peso PESO, pr.capacidad CAP
	from tipoproducto tp join categoriaproducto cp on tp.idcategoriatipo=cp.idcategoriaproducto
	join producto pr on pr.idtipoproducto=tp.idtipoproducto join patronproducto pp on
	pp.idpatronproducto=pr.idpatronproducto	join material ma on ma.idmaterial=pr.idmaterial
	where pr.idproducto=1";
    $result_ppatron=mysql_query($sql_propatron,$con) or die(mysql_error()); 
    if(mysql_num_rows($result_ppatron)>0){
       $ppatron = mysql_fetch_assoc($result_ppatron);                                
    }
		
	
	$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);         
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Bugambilia');
    $pdf->SetTitle('Reporte de Patron Producto'); //revisar titulo 
    
    // disable header and footer
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);   
    
    // set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    // set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

    // set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, 0);

    // set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);    
    
    
    $pdf->AddPage('P', 'A4');
    $pdf->Image('../imagenes/apariencia/logobugambilia.png', 10, 14, 53,14, 'PNG', 'http://www.gaagdesarrolloempresarial.com', '', true, 150, '', false, false, 0, false, false, false);    
    $pdf->SetFont('courier', 'B', 10); 
    $pdf->Line(10, 29, 200, 29);
	
	
	$suma=30;
	$pdf->SetXY(10,$suma);
    $pdf->SetFont('courier', 'B', 14); 
	$pdf->Cell(105, 10,"DESCRIPCION", 0, 1,"L", 0, '', 0);
	
	$pdf->SetXY(10,$suma+=7);
    $pdf->SetFont('courier', 'N', 10); 
	$pdf->Cell(10, 5,"Precio : ".$ppatron["PRECIO"], 0, 1,"L", 0, '', 0);
	
	$pdf->SetXY(10,$suma+=3);
    $pdf->SetFont('courier', 'N', 10); 
	$pdf->Cell(10, 5,$ppatron["TPCOD"]." - ".$ppatron["TPNOM"], 0, 1,"L", 0, '', 0);
	
	$pdf->SetXY(10,$suma+=3);
    $pdf->SetFont('courier', 'N', 10); 
	$pdf->Cell(10, 5,$ppatron["CATNOM"]." - ".$ppatron["PPNOM"]." - ".$ppatron["MATNOM"], 0, 1,"L", 0, '', 0);
	
	/**dimensiones*/
	$pdf->SetFont('courier', '', 9);
    $pdf->Line(10, $suma+=10, 200, $suma);
	
	$pdf->SetXY(10,$suma);
    $pdf->SetFont('courier', 'B', 12); 
	$pdf->Cell(105, 10,"DIMENSIONES", 0, 1,"L", 0, '', 0);
	
	$pdf->SetXY(10,$suma+=7);
    $pdf->SetFont('courier', 'N', 10); 
	$pdf->Cell(10, 5,"Largo: ".$ppatron["LARGO"]."(cm) - Ancho: ".$ppatron["ANCHO"]."(cm) - Alto: ".$ppatron["ALTO"]."(cm) - Peso:".$ppatron["PESO"]."(Kg) - Capacidad: ".$ppatron["CAP"]."(Lt)", 0, 1,"L", 0, '', 0);
	
	
	/**colores*/
	$pdf->SetFont('courier', '', 9);
    $pdf->Line(10, $suma+=10, 200, $suma);
	
	$pdf->SetXY(10,$suma);
    $pdf->SetFont('courier', 'B', 12); 
	$pdf->Cell(105, 10,"COLORES DISPONIBLES", 0, 1,"L", 0, '', 0);
	
	$sql_colores="select co.`nombre` NOMCOL from `tipoproducto` tp join `categoriaproducto` cp on tp.`idcategoriatipo`=cp.`idcategoriaproducto` join producto pr on pr.`idtipoproducto`=tp.`idtipoproducto` 
	join `patronproducto` pp on pp.`idpatronproducto`=pr.`idpatronproducto` join material ma on ma.`idmaterial` =pr.`idmaterial` join `colorenmaterial` cm on cm.`idmaterial`= ma.`idmaterial` join color co on co.`idcolor`=cm.`idcolor` where pr.`idproducto`='".$ppatron["ID"]."'";
	$result_colores=mysql_query($sql_colores,$con) or die(mysql_error()); 
	$numercolores=mysql_num_rows($result_colores);
	$cuenta=1;
	$suma+=7;
	$colum=10;
	while($colores = mysql_fetch_assoc($result_colores)){
		$pdf->SetXY($colum,$suma);
		$pdf->SetFont('courier', 'N', 10); 
		$pdf->Cell(35, 10,$colores["NOMCOL"]." ", 0, 1,"L", 0, '', 0);
			
		if($colum==160){
			$colum=10;
			$suma+=3;
		}else{
			$colum+=30;
		}
	}
	
	
	/**HISTORICO PRECIOS DE FABRICA*/
	$pdf->SetFont('courier', '', 9);
    $pdf->Line(10, $suma+=12, 200, $suma);
	
	$pdf->SetXY(10,$suma);
    $pdf->SetFont('courier', 'B', 12); 
	$pdf->Cell(105, 10,"HISTORICO PRECIOS DE FABRICA", 0, 1,"L", 0, '', 0);
	
	/*Cabecera de la tabla*/
    $suma+=10;
	$colum=10;
	
    $pdf->SetFont('courier', 'B', 7);
    $pdf->SetXY($colum,$suma);
    $pdf->Cell(60, 4,"DESDE", 1, 1,"C", 0, '', 0);
    $pdf->SetXY($colum+=60,$suma);
    $pdf->Cell(60, 4,"HASTA", 1, 1,"C", 0, '', 0);
    $pdf->SetXY($colum+=60,$suma);
    $pdf->Cell(60, 4,"PRECIO (USD)", 1, 1,"C", 0, '', 0); 
    
	
	/*fila de la tabla*/
    
    $sql_hist="select hp.desde DESDE,hp.hasta HASTA,hp.preciofabrica PRECIO from producto pr join historicopreciofabrica hp on pr.idproducto=hp.idproducto where pr.idproducto='".$ppatron["ID"]." ORDER BY DESDE ASC'";
    $result_hist=mysql_query($sql_hist,$con) or die(mysql_error());
    $numerprecios=mysql_num_rows($result_hist);
    $cuenta=1;
	$colum=10;
	while ($precios = mysql_fetch_assoc($result_hist)) {
		$pdf->SetFont('courier', '', 7);
        $pdf->SetXY($colum,$suma+=4);
        $pdf->Cell(60, 4,date("d / m / Y",strtotime($precios["DESDE"])), 1, 1,"C", 0, '', 0);
	
		
		$pdf->SetFont('courier', '', 7);
        $pdf->SetXY($colum+=60,$suma);
		if($precios["HASTA"]!=""){
			$pdf->Cell(60, 4,date("d / m / Y",strtotime($precios["HASTA"])), 1, 1,"C", 0, '', 0);
		}else{
			$pdf->Cell(60, 4,"Actualidad", 1, 1,"C", 0, '', 0);
		}
		
		$pdf->SetFont('courier', '', 7);
        $pdf->SetXY($colum+=60,$suma);
        $pdf->Cell(60, 4,$precios["PRECIO"], 1, 1,"C", 0, '', 0);
		$colum=10;
		
	}
	/**LISTA DE PRECIOS*/
	$pdf->SetFont('courier', '', 9);
    $pdf->Line(10, $suma+=12, 200, $suma);
	
	$pdf->SetXY(10,$suma);
    $pdf->SetFont('courier', 'B', 12); 
	$pdf->Cell(105, 10,"LISTA DE PRECIOS", 0, 1,"L", 0, '', 0);	
	
	
	/*Cabecera de la tabla*/
    $suma+=10;
	$colum=10;
	
    $pdf->SetFont('courier', 'B', 7);
    $pdf->SetXY($colum,$suma);
    $pdf->Cell(60, 4,"EMPRESA", 1, 1,"C", 0, '', 0);
    $pdf->SetXY($colum+=60,$suma);
    $pdf->Cell(60, 4,"LISTA DE PRECIOS", 1, 1,"C", 0, '', 0);
    $pdf->SetXY($colum+=60,$suma);
    $pdf->Cell(60, 4,"PRECIO DE VENTA", 1, 1,"C", 0, '', 0); 
	
	$sql_list="select em.nombreempresa NOMEMP, lp.nombre LISTNOM,lp.idlistadeprecios,po.precioventa PVENTA from empresa em join listadeprecios lp on em.idempresa=lp.idempresa
    join listatipos lt on lt.idlistadeprecios=lp.idlistadeprecios join tipoproducto tp
    on tp.idtipoproducto=lt.idtipoproducto join producto pr on pr.idtipoproducto=tp.idtipoproducto
    join productosordencompra po on po.idproducto=pr.idproducto
    where pr.idproducto='".$ppatron["ID"]."'";
    $result_list=mysql_query($sql_list,$con) or die(mysql_error());
    $numerprecios=mysql_num_rows($result_list);
    $cuenta=1;
	$colum=10;
	while ($lista = mysql_fetch_assoc($result_list)) {
		$pdf->SetFont('courier', '', 7);
        $pdf->SetXY($colum,$suma+=4);
        $pdf->Cell(60, 4,$lista["NOMEMP"], 1, 1,"C", 0, '', 0);
	
		
		$pdf->SetFont('courier', '', 7);
        $pdf->SetXY($colum+=60,$suma);
		$pdf->Cell(60, 4,$lista["LISTNOM"], 1, 1,"C", 0, '', 0);
		
		
		$pdf->SetFont('courier', '', 7);
        $pdf->SetXY($colum+=60,$suma);
        $pdf->Cell(60, 4,$lista["PVENTA"], 1, 1,"C", 0, '', 0);
		$colum=10;
	
	}/**/
	
	
	
	
	$pdf->Output('Orden de Compra.pdf', 'I');
    /*Agregado desde origen externo*/
   
?>
