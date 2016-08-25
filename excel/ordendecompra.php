<?php

    require_once('../recursos/phpexcel/Classes/PHPExcel.php');
    require_once('../recursos/funciones.php');
 
    $objPHPExcel = new PHPExcel();
    $objPHPExcel->getProperties()->setCreator("Sistema Bugambilia") // Nombre del autor
    ->setLastModifiedBy("Sistema Bugambilia") //Ultimo usuario que lo modificó
    ->setTitle("Orden de Compra") // Titulo
    ->setSubject("Orden de Compra") //Asunto
    ->setDescription("Orden de Compra");
    
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);  
$objPHPExcel->getActiveSheet()->getPageSetup()->setScale(70);
$objPHPExcel->getActiveSheet()->getPageMargins()->setHeader(0.76);
$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.50);
$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.30);
$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.30);
$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(1.91);
    
$estiloSuperior = array(
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN
        )
    ),
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => 'ffcb2b')
    )    
); 
    
$estiloTitulo = array(
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN
        )
    ),
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => 'FFFF00')
    )    
);    
    
    
$estiloTituloColumnas = array(
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN
        )
    )
);

$estiloTituloColumnasNegrita = array(
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN
        )
    ),
    'font'  => array(
        'bold'  => true,
        'size'  => 11
    )   
);
                  
    $con= Conexion();
    
    $sql_orden="select * from ordendecompra where idordendecompra='".$_GET["id"]."'";
    $result_orden=mysql_query($sql_orden,$con) or die(mysql_error());
    if(mysql_num_rows($result_orden)>0){
       $orden = mysql_fetch_assoc($result_orden);                                
    }
    
    $condiciones="";
    if($orden["condiciones"]==1){
        $condiciones="50% Anticipo 50% Contra Aviso de Entrega";
    }
    if($orden["condiciones"]==2){
        $condiciones="100% Contra Aviso de Entrega";
    }
    if($orden["condiciones"]==3){
        $condiciones="50% Anticipo 15 dias de Credito";
    }
    if($orden["condiciones"]==4){
        $condiciones="50% Anticipo 30 dias de Credito";
    }
    if($orden["condiciones"]==5){
        $condiciones="Credito de 15 días";
    }
    if($orden["condiciones"]==6){
        $condiciones="Credito de 30 días";
    }    
    
    
    $sql_empresa="select * from empresa where idempresa='".$orden["idempresa"]."'";
    $result_empresa=mysql_query($sql_empresa,$con) or die(mysql_error()); 
    if(mysql_num_rows($result_empresa)>0){
       $empresa = mysql_fetch_assoc($result_empresa);                                
    }   
    $metodo="";
    if($empresa["metododepago"]==1){
        $metodo="Transferencia";
    }
    if($empresa["metododepago"]==2){
        $metodo="Deposito";
    } 
    if($empresa["metododepago"]==2){
        $metodo="Efectivo";
    }      
    
    $sql_pais="select * from pais where idpais='".$empresa["idpais"]."'";
    $result_pais=mysql_query($sql_pais,$con) or die(mysql_error());
    if(mysql_num_rows($result_pais)>0){
       $pais = mysql_fetch_assoc($result_pais);                                
    }   
    
    $sql_agenda="select * from agenda where idagenda='".$orden["idagenda01"]."'";
    $result_agenda=mysql_query($sql_agenda,$con) or die(mysql_error());
    if(mysql_num_rows($result_agenda)>0){
       $agenda01 = mysql_fetch_assoc($result_agenda);                                
    } 
    
    $sql_agenda="select * from agenda where idagenda='".$orden["idagenda02"]."'";
    $result_agenda=mysql_query($sql_agenda,$con) or die(mysql_error());
    if(mysql_num_rows($result_agenda)>0){
       $agenda02 = mysql_fetch_assoc($result_agenda);                                
    }  
    
    $sql_agenda="select * from agenda where idagenda='".$orden["idagenda03"]."'";
    $result_agenda=mysql_query($sql_agenda,$con) or die(mysql_error());
    if(mysql_num_rows($result_agenda)>0){
       $agenda03 = mysql_fetch_assoc($result_agenda);                                
    }
    
    
    $fila=2;
    $columna=2;
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('K'.$fila.':L'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('M'.$fila.':N'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$fila,"Orden de Compra");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$fila,$orden["codigoexterno"]);     
    $objPHPExcel->getActiveSheet()->getStyle('K'.$fila.':N'.$fila)->applyFromArray($estiloTituloColumnas);      
    $objPHPExcel->getActiveSheet()->getStyle('K'.$fila.':N'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('K'.$fila.':L'.$fila)->applyFromArray($estiloTituloColumnasNegrita);
    $fila++;
    
    
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('K'.$fila.':L'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('M'.$fila.':N'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$fila,"Orden de Producción");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$fila,$orden["codigoop"]); 
    $objPHPExcel->getActiveSheet()->getStyle('K'.$fila.':N'.$fila)->applyFromArray($estiloTituloColumnas);
    $objPHPExcel->getActiveSheet()->getStyle('K'.$fila.':N'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('K'.$fila.':L'.$fila)->applyFromArray($estiloTituloColumnasNegrita);
    $fila++; 
    
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('K'.$fila.':L'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('M'.$fila.':N'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$fila,"Fecha de Pedido");
    $date = new DateTime($orden["fechaderegistro"]);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$fila,$date->format('d-m-Y')); 
    $objPHPExcel->getActiveSheet()->getStyle('K'.$fila.':N'.$fila)->applyFromArray($estiloTituloColumnas);
    $objPHPExcel->getActiveSheet()->getStyle('K'.$fila.':N'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('K'.$fila.':L'.$fila)->applyFromArray($estiloTituloColumnasNegrita);
    $fila++; 
    
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('K'.$fila.':L'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('M'.$fila.':N'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$fila,"Fecha de Entrega");
    $date = new DateTime($orden["fechadeentrega"]);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$fila,$date->format('d-m-Y')); 
    $objPHPExcel->getActiveSheet()->getStyle('K'.$fila.':N'.$fila)->applyFromArray($estiloTituloColumnas);
    $objPHPExcel->getActiveSheet()->getStyle('K'.$fila.':N'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('K'.$fila.':L'.$fila)->applyFromArray($estiloTituloColumnasNegrita);
    $fila++;$fila++;  
    
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('L'.$fila.':N'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$fila,"ORDEN DE COMPRA");
    $objPHPExcel->getActiveSheet()->getStyle('L'.$fila.':N'.$fila)->applyFromArray($estiloTituloColumnasNegrita);
    $objPHPExcel->getActiveSheet()->getStyle('L'.$fila.':N'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);    
    $fila++;
    
    if($orden["conpago"]==2){
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('L'.$fila.':N'.$fila);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$fila,"PEDIDO DE MUESTRA");
        $objPHPExcel->getActiveSheet()->getStyle('L'.$fila.':N'.$fila)->applyFromArray($estiloTituloColumnasNegrita);
        $objPHPExcel->getActiveSheet()->getStyle('L'.$fila.':N'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);    
        $fila++;        
    }
    
    $fila++;
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.$fila.':D'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E'.$fila.':J'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$fila,"Codigo del Cliente");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$fila,$empresa["codigo"]); 
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':J'.$fila)->applyFromArray($estiloTituloColumnas);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':D'.$fila)->applyFromArray($estiloTituloColumnasNegrita);
    $fila++; 
    
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.$fila.':D'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E'.$fila.':J'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$fila,"Empresa");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$fila,$empresa["nombrecomercial"]); 
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':J'.$fila)->applyFromArray($estiloTituloColumnas);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':J'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':D'.$fila)->applyFromArray($estiloTituloColumnasNegrita);
    $fila++; 
    
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.$fila.':D'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E'.$fila.':J'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$fila,"Contacto");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$fila,$agenda01["nombre"]); 
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':J'.$fila)->applyFromArray($estiloTituloColumnas);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':J'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':D'.$fila)->applyFromArray($estiloTituloColumnasNegrita);
    $fila++;  
    
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.$fila.':D'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E'.$fila.':J'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$fila,"Puesto");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$fila,$agenda01["referencia"]); 
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':J'.$fila)->applyFromArray($estiloTituloColumnas);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':J'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':D'.$fila)->applyFromArray($estiloTituloColumnasNegrita);
    $fila++;  
    
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.$fila.':D'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E'.$fila.':J'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$fila,"Mail");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$fila,$agenda01["email"]); 
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':J'.$fila)->applyFromArray($estiloTituloColumnas);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':J'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':D'.$fila)->applyFromArray($estiloTituloColumnasNegrita);
    $fila++;
    
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.$fila.':D'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E'.$fila.':J'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$fila,"Telefono");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$fila,$agenda01["telefono1"]); 
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':J'.$fila)->applyFromArray($estiloTituloColumnas);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':J'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':D'.$fila)->applyFromArray($estiloTituloColumnasNegrita);
    $fila++;
    
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.$fila.':J'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$fila,"Datos de Facturación"); 
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':J'.$fila)->applyFromArray($estiloTituloColumnas);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':J'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':J'.$fila)->applyFromArray($estiloTituloColumnasNegrita);
    $fila++;
    
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.$fila.':D'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E'.$fila.':J'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$fila,"Nombre");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$fila,$empresa["nombreempresa"]); 
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':J'.$fila)->applyFromArray($estiloTituloColumnas);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':J'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':D'.$fila)->applyFromArray($estiloTituloColumnasNegrita);
    $fila++;
    
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.$fila.':D'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E'.$fila.':J'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$fila,"Calle");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$fila,$empresa["fiscalcalle"]); 
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':J'.$fila)->applyFromArray($estiloTituloColumnas);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':J'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':D'.$fila)->applyFromArray($estiloTituloColumnasNegrita);
    $fila++;
    
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.$fila.':D'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E'.$fila.':J'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$fila,"Número Exterior");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$fila,$empresa["fiscalexterior"]); 
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':J'.$fila)->applyFromArray($estiloTituloColumnas);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':J'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':D'.$fila)->applyFromArray($estiloTituloColumnasNegrita);
    $fila++;
    
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.$fila.':D'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E'.$fila.':J'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$fila,"Número Interior");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$fila,$empresa["fiscalinterior"]); 
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':J'.$fila)->applyFromArray($estiloTituloColumnas);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':J'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':D'.$fila)->applyFromArray($estiloTituloColumnasNegrita);
    $fila++;
    
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.$fila.':D'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E'.$fila.':J'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$fila,"Colonia");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$fila,$empresa["fiscalcolonia"]); 
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':J'.$fila)->applyFromArray($estiloTituloColumnas);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':J'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':D'.$fila)->applyFromArray($estiloTituloColumnasNegrita);
    $fila++;
    
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.$fila.':D'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E'.$fila.':J'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$fila,"Código Postal");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$fila,$empresa["fiscalpostal"]); 
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':J'.$fila)->applyFromArray($estiloTituloColumnas);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':J'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':D'.$fila)->applyFromArray($estiloTituloColumnasNegrita);
    $fila++;
    
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.$fila.':D'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E'.$fila.':J'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$fila,"Estado y País");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$fila,$empresa["fiscalestado"]); 
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':J'.$fila)->applyFromArray($estiloTituloColumnas);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':J'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':D'.$fila)->applyFromArray($estiloTituloColumnasNegrita);
    $fila++;
    
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.$fila.':D'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E'.$fila.':J'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$fila,"RFC");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$fila,$empresa["identificador"]);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':J'.$fila)->applyFromArray($estiloTituloColumnas);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':J'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':D'.$fila)->applyFromArray($estiloTituloColumnasNegrita);
    $fila++; $fila++;
    
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$fila,"#");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$fila,"Material");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$fila,"Clave");
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E'.$fila.':G'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$fila,"Descripcion");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$fila,"Color");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$fila,"Largo");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$fila,"Ancho");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$fila,"Alto");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$fila,"Piezas");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$fila,"Precio");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$fila,"Total");
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':N'.$fila)->applyFromArray($estiloTituloColumnas);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':N'.$fila)->applyFromArray($estiloTituloColumnasNegrita);
    $objPHPExcel->getActiveSheet()->getStyle('H'.$fila.':N'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $fila++;
    
    
    $sql_pro="select * from productosordencompra where idordendecompra='".$orden["idordendecompra"]."'";
    $result_pro=mysql_query($sql_pro,$con) or die(mysql_error());
    $cuenta=1;
    while ($proorden = mysql_fetch_assoc($result_pro)) {
        $sqlproducto="select * from producto where idproducto='".$proorden["idproducto"]."'";
        $resultproducto=mysql_query($sqlproducto,$con) or die(mysql_error());
        $producto = mysql_fetch_assoc($resultproducto);
            
        $sqlmaterial="select * from material where idmaterial='".$producto["idmaterial"]."'";
        $resultMaterial=mysql_query($sqlmaterial,$con) or die(mysql_error());
        $material = mysql_fetch_assoc($resultMaterial);
            
        $sqlcolor="select * from color where idcolor='".$proorden["idcolor"]."'";
        $resultColor=mysql_query($sqlcolor,$con) or die(mysql_error());
        $color = mysql_fetch_assoc($resultColor);         
        
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$fila,$cuenta);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$fila,$material["nombre"]);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$fila,$producto["codigo"]);
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E'.$fila.':G'.$fila);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$fila,$producto["descripcion"]);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$fila,$color["codigo"]);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$fila,$producto["dimensionlargo"]);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$fila,$producto["dimensionancho"]);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$fila,$producto["dimensionalto"]);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$fila,$proorden["numerodeunidades"]);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$fila,$proorden["precioventa"]);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$fila,($proorden["precioventa"]*$proorden["numerodeunidades"]));        
        $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':N'.$fila)->applyFromArray($estiloTituloColumnas);
        $objPHPExcel->getActiveSheet()->getStyle('H'.$fila.':N'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $fila++;
        $cuenta++;
    }
    
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('L'.$fila.':M'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$fila,"Subtotal");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$fila,$orden["subtotal"]);
    $objPHPExcel->getActiveSheet()->getStyle('N'.$fila.':N'.$fila)->applyFromArray($estiloTituloColumnas);
    $objPHPExcel->getActiveSheet()->getStyle('N'.$fila.':N'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('L'.$fila.':L'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    $fila++;
    
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('L'.$fila.':M'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$fila,"Iva ".$orden["poriva"]);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$fila,$orden["iva"]);
    $objPHPExcel->getActiveSheet()->getStyle('N'.$fila.':N'.$fila)->applyFromArray($estiloTituloColumnas);
    $objPHPExcel->getActiveSheet()->getStyle('N'.$fila.':N'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('L'.$fila.':L'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    $fila++;
    
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('L'.$fila.':M'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$fila,"Total");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$fila,$orden["total"]);
    $objPHPExcel->getActiveSheet()->getStyle('N'.$fila.':N'.$fila)->applyFromArray($estiloTituloColumnas);
    $objPHPExcel->getActiveSheet()->getStyle('N'.$fila.':N'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('L'.$fila.':L'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    $fila++; $fila++;   
    
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.$fila.':G'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$fila,"Condiciones de Pago");
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H'.$fila.':N'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$fila,$condiciones);
    $objPHPExcel->getActiveSheet()->getStyle('H'.$fila.':H'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':N'.$fila)->applyFromArray($estiloTituloColumnas);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':G'.$fila)->applyFromArray($estiloTituloColumnasNegrita);
    $fila++;
    
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.$fila.':G'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$fila,"Contacto de Compras");
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H'.$fila.':N'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$fila,$agenda01["nombre"]);
    $objPHPExcel->getActiveSheet()->getStyle('H'.$fila.':H'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':N'.$fila)->applyFromArray($estiloTituloColumnas);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':G'.$fila)->applyFromArray($estiloTituloColumnasNegrita);
    $fila++;
    
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.$fila.':G'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$fila,"Teléfono");
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H'.$fila.':N'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$fila,$agenda01["telefono1"]);
    $objPHPExcel->getActiveSheet()->getStyle('H'.$fila.':H'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':N'.$fila)->applyFromArray($estiloTituloColumnas);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':G'.$fila)->applyFromArray($estiloTituloColumnasNegrita);
    $fila++;
    
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.$fila.':G'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$fila,"Correo Electrónico");
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H'.$fila.':N'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$fila,$agenda01["email"]);
    $objPHPExcel->getActiveSheet()->getStyle('H'.$fila.':H'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':N'.$fila)->applyFromArray($estiloTituloColumnas);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':G'.$fila)->applyFromArray($estiloTituloColumnasNegrita);
    $fila++;   $fila++; 
    
    
    
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.$fila.':N'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$fila,"Contacto Cuenta por Pagar o Persona encargada de recibir factura electrónica");
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':N'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);    
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':N'.$fila)->applyFromArray($estiloTituloColumnasNegrita);
    $fila++;
    
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.$fila.':G'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$fila,"Nombre");
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H'.$fila.':N'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$fila,$agenda02["nombre"]);
    $objPHPExcel->getActiveSheet()->getStyle('H'.$fila.':H'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':N'.$fila)->applyFromArray($estiloTituloColumnas);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':G'.$fila)->applyFromArray($estiloTituloColumnasNegrita);
    $fila++;
    
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.$fila.':G'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$fila,"Teléfono");
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H'.$fila.':N'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$fila,$agenda02["telefono1"]);
    $objPHPExcel->getActiveSheet()->getStyle('H'.$fila.':H'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':N'.$fila)->applyFromArray($estiloTituloColumnas);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':G'.$fila)->applyFromArray($estiloTituloColumnasNegrita);
    $fila++;
    
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.$fila.':G'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$fila,"Correo Electrónico");
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H'.$fila.':N'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$fila,$agenda02["email"]);
    $objPHPExcel->getActiveSheet()->getStyle('H'.$fila.':H'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':N'.$fila)->applyFromArray($estiloTituloColumnas);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':G'.$fila)->applyFromArray($estiloTituloColumnasNegrita);
    $fila++;   $fila++;   
    
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.$fila.':G'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$fila,"Metodo de Pago");
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H'.$fila.':N'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$fila,$metodo);
    $objPHPExcel->getActiveSheet()->getStyle('H'.$fila.':H'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':N'.$fila)->applyFromArray($estiloTituloColumnas);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':G'.$fila)->applyFromArray($estiloTituloColumnasNegrita);
    $fila++;
    
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.$fila.':G'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$fila,"Banco del Cliente");
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H'.$fila.':N'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$fila,$empresa["banco"]);
    $objPHPExcel->getActiveSheet()->getStyle('H'.$fila.':H'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':N'.$fila)->applyFromArray($estiloTituloColumnas);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':G'.$fila)->applyFromArray($estiloTituloColumnasNegrita);
    $fila++;
    
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.$fila.':G'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$fila,"Últimos 4 digitos de la cuenta bancaria");
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H'.$fila.':N'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$fila,$empresa["ultimos"]);
    $objPHPExcel->getActiveSheet()->getStyle('H'.$fila.':H'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':N'.$fila)->applyFromArray($estiloTituloColumnas);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':G'.$fila)->applyFromArray($estiloTituloColumnasNegrita);
    $fila++;   $fila++;      
    
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.$fila.':N'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$fila,"Datos de Entrega");
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':N'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);    
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':N'.$fila)->applyFromArray($estiloTituloColumnasNegrita);
    $fila++;
    
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.$fila.':G'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$fila,"Persona Encargada de Recibir");
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H'.$fila.':N'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$fila,$agenda03["referencia"]." - ".$agenda03["nombre"]);
    $objPHPExcel->getActiveSheet()->getStyle('H'.$fila.':H'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':N'.$fila)->applyFromArray($estiloTituloColumnas);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':G'.$fila)->applyFromArray($estiloTituloColumnasNegrita);
    $fila++;
    
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.$fila.':G'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$fila,"Paqueteria");
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H'.$fila.':N'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$fila,$orden["paqueteria"]);
    $objPHPExcel->getActiveSheet()->getStyle('H'.$fila.':H'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':N'.$fila)->applyFromArray($estiloTituloColumnas);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':G'.$fila)->applyFromArray($estiloTituloColumnasNegrita);
    $fila++;
    
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.$fila.':G'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$fila,"Dirección de Entrega");
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H'.$fila.':N'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$fila,$empresa["entregacalle"].", nro ext ".$empresa["entregaexterior"].", nro int ".$empresa["entregainterior"].", Colonia ".$empresa["entregacolonia"].", Codigo Postal ".$empresa["entregapostal"].", ".$empresa["entregaciudad"].", ".$empresa["entregaestado"].". ".$empresa["entregareferencia"]);
    $objPHPExcel->getActiveSheet()->getStyle('H'.$fila.':H'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':N'.$fila)->applyFromArray($estiloTituloColumnas);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':G'.$fila)->applyFromArray($estiloTituloColumnasNegrita);
    $fila++;   $fila++; 
    
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.$fila.':N'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$fila,"Observaciones");
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':N'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);    
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':N'.$fila)->applyFromArray($estiloTituloColumnasNegrita);
    $fila++;   
    
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.$fila.':N'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$fila,$orden["observaciones"]);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':N'.$fila)->applyFromArray($estiloTituloColumnas);    
    $fila++; 

    //$sheet = $objPHPExcel->setSheetIndexAndTitle(1, "Worksheet"); // first sheet
    $objDrawing = new PHPExcel_Worksheet_Drawing();
    $objDrawing->setName('Logo');
    $objDrawing->setDescription('Logo');
    $logo = '../imagenes/apariencia/logobugambilia.png'; // Provide path to your logo file
    $objDrawing->setPath($logo);
    $objDrawing->setOffsetX(8);    // setOffsetX works properly
    $objDrawing->setOffsetY(300);  //setOffsetY has no effect
    $objDrawing->setCoordinates('B1');
    $objDrawing->setHeight(75); // logo height
    $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());     
    
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="ordendecompra'.$orden["codigoexterno"].'.xlsx"');
    header('Cache-Control: max-age=0');
    // If you're serving to IE 9, then the following may be needed
    header('Cache-Control: max-age=1');

    // If you're serving to IE over SSL, then the following may be needed
    header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
    header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header ('Pragma: public'); // HTTP/1.0

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');
    exit;    
    

    
    ?>