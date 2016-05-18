<?php
    require_once('../recursos/tcpdf/tcpdf.php');
    require_once('../recursos/funciones.php');
    
    $pagina=1;
    $con=Conexion();
	$sql_patron="select pp.nombreespanol NOMESP,pp.nombreingles NOMING,cp.nombreespanol FORMESP,cp.nombreingles FORMING, pp.idpatronproducto ID from patronproducto pp join categoriaproducto cp on pp.idcategoriaproducto=cp.idcategoriaproducto
	where pp.idpatronproducto=1";
    $result_patron=mysql_query($sql_patron,$con) or die(mysql_error()); 
    if(mysql_num_rows($result_patron)>0){
       $patron = mysql_fetch_assoc($result_patron);                                
    }
		
	
	$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);         
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Bugambilia');
    $pdf->SetTitle('Reporte de Patron '); //revisar titulo 
    
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
	$pdf->Cell(105, 10,$patron["NOMESP"], 0, 1,"L", 0, '', 0);
	$pdf->SetXY(10,$suma+=6);
    $pdf->SetFont('courier', 'B', 14); 
	$pdf->Cell(105, 10,$patron["NOMING"], 0, 1,"L", 0, '', 0);
	/**FORMA*/
	$pdf->SetXY(10,$suma+=6);
    $pdf->SetFont('courier', 'N', 10); 
	$pdf->Cell(105, 10,"Forma : ".$patron["FORMESP"], 0, 1,"L", 0, '', 0);
	$pdf->SetXY(42,$suma);
    $pdf->SetFont('courier', 'N', 10); 
	$pdf->Cell(105, 10," - ".$patron["FORMING"], 0, 1,"L", 0, '', 0);
	
	
	/***MATERIALES DISPONIBLES**/
	
	$pdf->SetXY(10,$suma+=8);
    $pdf->SetFont('courier', 'B', 10); 
	$pdf->Cell(105, 10,"MATERIALES DISPONIBLES", 0, 1,"L", 0, '', 0);
	
	$sql_materiales="select ma.nombre NOMMAT,ma.dias DIASMAT from patronproducto pp join materialespatron mp on pp.idpatronproducto=mp.idpatronproducto	join material ma on ma.idmaterial=mp.idmaterial
	where pp.idpatronproducto='".$patron["ID"]."'";
	$result_material=mysql_query($sql_materiales,$con) or die(mysql_error()); 
	$numermateriales=mysql_num_rows($result_material);
	while($materiales = mysql_fetch_assoc($result_material)){	
		$pdf->SetXY(10,$suma+=6);
		$pdf->SetFont('courier', 'N', 10); 
		$pdf->Cell(70, 10,"Nombre Material : ".$materiales["NOMMAT"], 0, 1,"L", 0, '', 0);
		
		$pdf->SetXY(10,$suma+=4);
		$pdf->SetFont('courier', 'N', 10); 
		$pdf->Cell(70, 10,"Tiempo de Elaboracion : ".$materiales["DIASMAT"], 0, 1,"L", 0, '', 0);
		
		$pdf->SetXY(10,$suma+=4);
		$pdf->SetFont('courier', 'N', 10); 
		$pdf->Cell(70, 10,"Color(es) Disponible(s) : ", 0, 1,"L", 0, '', 0);
			
		$sql_color="select DISTINCT( co.nombre ) NOMCOL 
		from patronproducto pp join categoriaproducto cp on pp.idcategoriaproducto=cp.idcategoriaproducto
		join materialespatron mp on mp.idpatronproducto join material ma on ma.idmaterial=mp.idmaterial
		join colorenmaterial cm on cm.idmaterial=ma.idmaterial join color co on co.idcolor=cm.idcolor
		WHERE pp.idpatronproducto='".$patron["ID"]."' and ma.dias='".$materiales["DIASMAT"]."'";
		$result_color=mysql_query($sql_color,$con) or die(mysql_error()); 
		$numercolor=mysql_num_rows($result_color);
		$suma+=3;
		$colum=10;
		while($colores = mysql_fetch_assoc($result_color)){
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
		$suma+=4;
	}
	
	$pdf->SetXY(10,$suma+=8);
    $pdf->SetFont('courier', 'B', 10); 
	$pdf->Cell(105, 10,"PRODUCTOS BASADOS EN EL PATRON", 0, 1,"L", 0, '', 0);
	
	/******LISTA DE PRODUCTOS *********/
	$sql_productos="select pr.codigo COD,pr.descripcion DES,tp.nombre NOM,pr.preciofabrica PRECIO,ma.nombre MAT,pr.dimensionlargo LARGO,pr.dimensionancho ANCHO,pr.dimensionalto ALTO, pr.peso PESO,pr.capacidad CAP
	from patronproducto pp join producto pr on pp.idpatronproducto=pr.idpatronproducto
	join material ma on ma.idmaterial=pr.idmaterial join tipoproducto tp on tp.idtipoproducto=pr.idtipoproducto
	where pp.idpatronproducto='".$patron["ID"]."'";
	$result_productos=mysql_query($sql_productos,$con) or die(mysql_error()); 
	$numerproductos=mysql_num_rows($result_productos);
	/*while($productos = mysql_fetch_assoc($result_productos)){
		$pdf->SetXY(10,$suma+=6);
		$pdf->SetFont('courier', 'N', 10); 
		$pdf->Cell(70, 10,"CODIGO - DESCRIPCIONS : ".$materiales["NOMMAT"], 0, 1,"L", 0, '', 0);
	}/**/
	
	
	
	
	
	
	
	
	
	
	$pdf->Output('Orden de Compra.pdf', 'I');
    /*Agregado desde origen externo*/
   
?>
