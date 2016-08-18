<?php

    require_once('../recursos/phpexcel/Classes/PHPExcel.php');
    require_once('../recursos/funciones.php');
 
    $objPHPExcel = new PHPExcel();
    $objPHPExcel->getProperties()->setCreator("Sistema Bugambilia") // Nombre del autor
    ->setLastModifiedBy("Sistema Bugambilia") //Ultimo usuario que lo modificó
    ->setTitle("Orden de Producción") // Titulo
    ->setSubject("Orden de Producción") //Asunto
    ->setDescription("Orden de Producción");
    
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
                  
    $con=Conexion();
    $sql_orden="select * from ordendeproduccion where idordendeproduccion='".$_GET["id"]."'";
    $result_orden=mysql_query($sql_orden,$con) or die(mysql_error());
    if(mysql_num_rows($result_orden)>0){
       $orden = mysql_fetch_assoc($result_orden);                                
    }
    
    $sql_ordenpro="select * from ordendecompra where idordendecompra='".$orden["idordendecompra"]."'";
    $result_ordenpro=mysql_query($sql_ordenpro,$con) or die(mysql_error());
    if(mysql_num_rows($result_ordenpro)>0){
       $ordenpro = mysql_fetch_assoc($result_ordenpro);                                
    }    
    
    $sql_empresa="select * from empresa where idempresa='".$orden["idempresa"]."'";
    $result_empresa=mysql_query($sql_empresa,$con) or die(mysql_error()); 
    if(mysql_num_rows($result_empresa)>0){
       $empresa = mysql_fetch_assoc($result_empresa);                                
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
    
    $sql_responsable="select * from usuario where idusuario='".$orden["idusuarioresponsable"]."'";
    $result_responsable=mysql_query($sql_responsable,$con) or die(mysql_error());
    if(mysql_num_rows($result_responsable)>0){
       $responsable = mysql_fetch_assoc($result_responsable);                                
    } 
    
    $sql_configuracion = "select * from configuracionsistema where idconfiguracionsistema=1";
    $result_configuracion=mysql_query($sql_configuracion,$con) or die(mysql_error());
    $configuracion = mysql_fetch_assoc($result_configuracion);
    
    
    $fila=2;
    $columna=2;
     $objPHPExcel->setActiveSheetIndex(0)->mergeCells('K'.$fila.':L'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('M'.$fila.':N'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$fila,"Orden de Compra");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$fila,$ordenpro["codigoexterno"]);     
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
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$fila,"ORDEN DE PRODUCCIÓN");
    $objPHPExcel->getActiveSheet()->getStyle('L'.$fila.':N'.$fila)->applyFromArray($estiloTituloColumnasNegrita);
    $objPHPExcel->getActiveSheet()->getStyle('L'.$fila.':N'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);    
    $fila++;
    
    if($ordenpro["conpago"]==2){
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('L'.$fila.':N'.$fila);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$fila,"PEDIDO DE MUESTRA");
        $objPHPExcel->getActiveSheet()->getStyle('L'.$fila.':N'.$fila)->applyFromArray($estiloTituloColumnasNegrita);
        $objPHPExcel->getActiveSheet()->getStyle('L'.$fila.':N'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);    
        $fila++;        
    }
    
    $fila++;
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.$fila.':D'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E'.$fila.':J'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$fila,"Empresa");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$fila,"IMMANTI, S.A. DE C.V."); 
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':J'.$fila)->applyFromArray($estiloTituloColumnas);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':D'.$fila)->applyFromArray($estiloTituloColumnasNegrita);
    $fila++; 
    
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.$fila.':D'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E'.$fila.':J'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$fila,"Contacto");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$fila,$responsable["nombre"]); 
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':J'.$fila)->applyFromArray($estiloTituloColumnas);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':J'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':D'.$fila)->applyFromArray($estiloTituloColumnasNegrita);
    $fila++; 
    
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.$fila.':D'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E'.$fila.':J'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$fila,"Puesto");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$fila,$responsable["puesto"]); 
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':J'.$fila)->applyFromArray($estiloTituloColumnas);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':J'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':D'.$fila)->applyFromArray($estiloTituloColumnasNegrita);
    $fila++;  
    
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.$fila.':D'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E'.$fila.':J'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$fila,"Email");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$fila,$responsable["correo"]); 
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':J'.$fila)->applyFromArray($estiloTituloColumnas);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':J'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':D'.$fila)->applyFromArray($estiloTituloColumnasNegrita);
    $fila++;  
    
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.$fila.':D'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E'.$fila.':J'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$fila,"Telefono");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$fila,$responsable["telefono"]); 
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
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$fila,$configuracion["facturacionempresa"]); 
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':J'.$fila)->applyFromArray($estiloTituloColumnas);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':J'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':D'.$fila)->applyFromArray($estiloTituloColumnasNegrita);
    $fila++;
    
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.$fila.':D'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E'.$fila.':J'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$fila,"Calle");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$fila,$configuracion["facturacioncalle"]); 
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':J'.$fila)->applyFromArray($estiloTituloColumnas);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':J'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':D'.$fila)->applyFromArray($estiloTituloColumnasNegrita);
    $fila++;
    
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.$fila.':D'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E'.$fila.':J'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$fila,"Número Exterior");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$fila,$configuracion["facturacionext"]); 
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':J'.$fila)->applyFromArray($estiloTituloColumnas);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':J'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':D'.$fila)->applyFromArray($estiloTituloColumnasNegrita);
    $fila++;
    
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.$fila.':D'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E'.$fila.':J'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$fila,"Número Interior");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$fila,$configuracion["facturacionint"]); 
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':J'.$fila)->applyFromArray($estiloTituloColumnas);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':J'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':D'.$fila)->applyFromArray($estiloTituloColumnasNegrita);
    $fila++;
    
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.$fila.':D'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E'.$fila.':J'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$fila,"Colonia");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$fila,$configuracion["facturacioncolonia"]); 
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':J'.$fila)->applyFromArray($estiloTituloColumnas);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':J'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':D'.$fila)->applyFromArray($estiloTituloColumnasNegrita);
    $fila++;
    
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.$fila.':D'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E'.$fila.':J'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$fila,"Código Postal");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$fila,$configuracion["facturacionpostal"]); 
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':J'.$fila)->applyFromArray($estiloTituloColumnas);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':J'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':D'.$fila)->applyFromArray($estiloTituloColumnasNegrita);
    $fila++;
    
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.$fila.':D'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E'.$fila.':J'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$fila,"Estado y País");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$fila,$configuracion["facturacionestpais"]); 
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':J'.$fila)->applyFromArray($estiloTituloColumnas);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':J'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':D'.$fila)->applyFromArray($estiloTituloColumnasNegrita);
    $fila++;
    
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.$fila.':D'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E'.$fila.':J'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$fila,"RFC");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$fila,$configuracion["facturacionrfc"]);
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
    
    
    $sql_pro="select * from productosordenproduccion where idordendeproduccion='".$_GET["id"]."'";
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
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$fila,$proorden["preciofabrica"]);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$fila,($proorden["preciofabrica"]*$proorden["numerodeunidades"]));        
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
    
    $observaciones="";
    if($orden["tipoempaque"]==1){
        $observaciones="Empaque Normal";
    }else if($orden["tipoempaque"]==2){
        $observaciones="Empaque Separado";
    }    
    
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.$fila.':N'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$fila,"Observaciones");
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':N'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);    
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':N'.$fila)->applyFromArray($estiloTituloColumnasNegrita);
    $fila++;   
    
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.$fila.':N'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$fila,$observaciones);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':N'.$fila)->applyFromArray($estiloTituloColumnas);    
    $fila++;    
    
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="ordendeproduccion'.$orden["codigoop"].'.xlsx"');
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