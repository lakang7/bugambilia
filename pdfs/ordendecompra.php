<?php
    require_once('../recursos/tcpdf/tcpdf.php');
    require_once('../recursos/funciones.php');
    
    $pagina=1;
    $con=Conexion();
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
                
    
    
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);         
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Bugambilia');
    $pdf->SetTitle('Orden de Compra'); 
    
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
    
    $suma=10;
    $pdf->SetFont('courier', 'B', 8);
    $pdf->SetXY(140,$suma);
    $pdf->Cell(35, 4,"Orden de Compra", 0, 1,"L", 0, '', 0);
    $pdf->SetXY(175,$suma);
    $pdf->SetFont('courier', 'N', 8);
    $pdf->Cell(25, 4,$orden["codigoexterno"],0, 1,"L", 0, '', 0); $suma+=4;
    
    $pdf->SetFont('courier', 'B', 8);
    $pdf->SetXY(140,$suma);
    $pdf->Cell(35, 4,"Orden de Producción", 0, 1,"L", 0, '', 0);
    $pdf->SetXY(175,$suma);
    $pdf->SetFont('courier', 'N', 8);
    $pdf->Cell(25, 4,$orden["codigoop"], 0, 1,"L", 0, '', 0); $suma+=4;  
    
    $pdf->SetFont('courier', 'B', 8);
    $pdf->SetXY(140,$suma);
    $pdf->Cell(35, 4,"Fecha de Pedido", 0, 1,"L", 0, '', 0);
    $date = new DateTime($orden["fechaderegistro"]);
    $pdf->SetXY(175,$suma);
    $pdf->SetFont('courier', 'N', 8);
    $pdf->Cell(25, 4,$date->format('d-m-Y'), 0, 1,"L", 0, '', 0); $suma+=4;
    
    $pdf->SetFont('courier', 'B', 8);
    $pdf->SetXY(140,$suma);
    $pdf->Cell(35, 4,"Fecha de Entrega", 0, 1,"L", 0, '', 0);
    $date = new DateTime($orden["fechadeentrega"]);
    $pdf->SetXY(175,$suma);
    $pdf->SetFont('courier', 'N', 8);
    $pdf->Cell(25, 4,$date->format('d-m-Y'), 0, 1,"L", 0, '', 0); $suma+=7;    
    
    $pdf->Line(10, $suma, 200, $suma);
    
    $pdf->SetFont('courier', '', 9);
    $pdf->Line(10, 285, 200, 285);
    $pdf->SetXY(170,287);
    $pdf->Cell(30, 4,"Página Nro. 0".$pagina, 0, 1,"R", 0, '', 0);  $pagina++;    
    
    $pdf->SetFont('courier', 'B', 12);
    $pdf->SetXY(140,30);
    $pdf->Cell(60, 4,"ORDEN DE COMPRA", 0, 1,"C", 0, '', 0); 
    if($orden["conpago"]==2){
        $pdf->SetXY(140,35);
        $pdf->Cell(60, 4,"PEDIDO DE MUESTRA", 0, 1,"C", 0, '', 0);        
    }

    
    
    $suma=35;
    $pdf->SetFont('courier', 'B', 8);
    $pdf->SetXY(10,$suma);
    $pdf->Cell(35, 4,"Código del Cliente", 1, 1,"L", 0, '', 0);
    $pdf->SetXY(45,$suma);
    $pdf->SetFont('courier', 'N', 8);
    $pdf->Cell(70, 4,$empresa["codigo"], 1, 1,"L", 0, '', 0); $suma+=4;
    
    $pdf->SetFont('courier', 'B', 8);
    $pdf->SetXY(10,$suma);
    $pdf->Cell(35, 4,"Empresa", 1, 1,"L", 0, '', 0);
    $pdf->SetXY(45,$suma);
    $pdf->SetFont('courier', 'N', 8);
    $pdf->Cell(70, 4,$empresa["nombrecomercial"], 1, 1,"L", 0, '', 0); $suma+=4;  
    
    $pdf->SetFont('courier', 'B', 8);
    $pdf->SetXY(10,$suma);
    $pdf->Cell(35, 4,"Contacto", 1, 1,"L", 0, '', 0);
    $pdf->SetXY(45,$suma);
    $pdf->SetFont('courier', 'N', 8);
    $pdf->Cell(70, 4,$agenda01["nombre"], 1, 1,"L", 0, '', 0); $suma+=4; 
    
    $pdf->SetFont('courier', 'B', 8);
    $pdf->SetXY(10,$suma);
    $pdf->Cell(35, 4,"Puesto", 1, 1,"L", 0, '', 0);
    $pdf->SetXY(45,$suma);
    $pdf->SetFont('courier', 'N', 8);
    $pdf->Cell(70, 4,$agenda01["referencia"], 1, 1,"L", 0, '', 0); $suma+=4;     
   
    $pdf->SetFont('courier', 'B', 8);
    $pdf->SetXY(10,$suma);
    $pdf->Cell(35, 4,"Mail", 1, 1,"L", 0, '', 0);
    $pdf->SetXY(45,$suma);
    $pdf->SetFont('courier', 'N', 8);
    $pdf->Cell(70, 4,$agenda01["email"], 1, 1,"L", 0, '', 0); $suma+=4; 
    
    $pdf->SetFont('courier', 'B', 8);
    $pdf->SetXY(10,$suma);
    $pdf->Cell(35, 4,"Teléfono", 1, 1,"L", 0, '', 0);
    $pdf->SetXY(45,$suma);
    $pdf->SetFont('courier', 'N', 8);
    $pdf->Cell(70, 4,$agenda01["telefono1"], 1, 1,"L", 0, '', 0); $suma+=4; 
    
    $pdf->SetFont('courier', 'B', 9);
    $pdf->SetXY(10,$suma);
    $pdf->Cell(105, 5,"Datos de Facturación", 1, 1,"C", 0, '', 0); $suma+=5; 
    
    $pdf->SetFont('courier', 'B', 8);
    $pdf->SetXY(10,$suma);
    $pdf->Cell(35, 4,"Nombre", 1, 1,"L", 0, '', 0);
    $pdf->SetXY(45,$suma);
    $pdf->SetFont('courier', 'N', 8);
    $pdf->Cell(70, 4,$empresa["nombreempresa"], 1, 1,"L", 0, '', 0); $suma+=4; 
    
    $pdf->SetFont('courier', 'B', 8);
    $pdf->SetXY(10,$suma);
    $pdf->Cell(35, 4,"Calle", 1, 1,"L", 0, '', 0);
    $pdf->SetXY(45,$suma);
    $pdf->SetFont('courier', 'N', 8);
    $pdf->Cell(70, 4,$empresa["fiscalcalle"], 1, 1,"L", 0, '', 0); $suma+=4;
    
    $pdf->SetFont('courier', 'B', 8);
    $pdf->SetXY(10,$suma);
    $pdf->Cell(35, 4,"Número Exterior", 1, 1,"L", 0, '', 0);
    $pdf->SetXY(45,$suma);
    $pdf->SetFont('courier', 'N', 8);
    $pdf->Cell(70, 4,$empresa["fiscalexterior"], 1, 1,"L", 0, '', 0); $suma+=4;  
    
    $pdf->SetFont('courier', 'B', 8);
    $pdf->SetXY(10,$suma);
    $pdf->Cell(35, 4,"Número Interior", 1, 1,"L", 0, '', 0);
    $pdf->SetXY(45,$suma);
    $pdf->SetFont('courier', 'N', 8);
    $pdf->Cell(70, 4,$empresa["fiscalinterior"], 1, 1,"L", 0, '', 0); $suma+=4;
    
    $pdf->SetFont('courier', 'B', 8);
    $pdf->SetXY(10,$suma);
    $pdf->Cell(35, 4,"Colonia", 1, 1,"L", 0, '', 0);
    $pdf->SetXY(45,$suma);
    $pdf->SetFont('courier', 'N', 8);
    $pdf->Cell(70, 4,$empresa["fiscalcolonia"], 1, 1,"L", 0, '', 0); $suma+=4;   
    
    $pdf->SetFont('courier', 'B', 8);
    $pdf->SetXY(10,$suma);
    $pdf->Cell(35, 4,"Código Postal", 1, 1,"L", 0, '', 0);
    $pdf->SetXY(45,$suma);
    $pdf->SetFont('courier', 'N', 8);
    $pdf->Cell(70, 4,$empresa["fiscalpostal"], 1, 1,"L", 0, '', 0); $suma+=4; 
    
    $pdf->SetFont('courier', 'B', 8);
    $pdf->SetXY(10,$suma);
    $pdf->Cell(35, 4,"Estado y País", 1, 1,"L", 0, '', 0);
    $pdf->SetXY(45,$suma);
    $pdf->SetFont('courier', 'N', 8);
    $pdf->Cell(70, 4,$empresa["fiscalestado"], 1, 1,"L", 0, '', 0); $suma+=4; 
    
    $pdf->SetFont('courier', 'B', 8);
    $pdf->SetXY(10,$suma);
    $pdf->Cell(35, 4,"RFC", 1, 1,"L", 0, '', 0);
    $pdf->SetXY(45,$suma);
    $pdf->SetFont('courier', 'N', 8);
    $pdf->Cell(70, 4,$empresa["identificador"], 1, 1,"L", 0, '', 0); $suma+=4;     
    
    $suma=$suma+5;
    $pdf->SetFont('courier', 'B', 7);
    $pdf->SetXY(10,$suma);
    $pdf->Cell(7, 4,"#", 1, 1,"L", 0, '', 0);
    $pdf->SetXY(17,$suma);
    $pdf->Cell(18, 4,"Material", 1, 1,"L", 0, '', 0);
    $pdf->SetXY(35,$suma);
    $pdf->Cell(18, 4,"Clave", 1, 1,"L", 0, '', 0); 
    $pdf->SetXY(53,$suma);
    $pdf->Cell(65, 4,"Descripcion", 1, 1,"L", 0, '', 0); 
    $pdf->SetXY(118,$suma);
    $pdf->Cell(11, 4,"Color", 1, 1,"C", 0, '', 0);  
    $pdf->SetXY(129,$suma);
    $pdf->Cell(11, 4,"Largo", 1, 1,"C", 0, '', 0);
    $pdf->SetXY(140,$suma);
    $pdf->Cell(11, 4,"Ancho", 1, 1,"C", 0, '', 0); 
    $pdf->SetXY(151,$suma);
    $pdf->Cell(11, 4,"Alto", 1, 1,"C", 0, '', 0); 
    $pdf->SetXY(162,$suma);
    $pdf->Cell(10, 4,"Piezas", 1, 1,"C", 0, '', 0); 
    $pdf->SetXY(172,$suma);
    $pdf->Cell(14, 4,"Precio", 1, 1,"C", 0, '', 0); 
    $pdf->SetXY(186,$suma);
    $pdf->Cell(17, 4,"Total", 1, 1,"C", 0, '', 0);
    
    $sql_pro="select * from productosordencompra where idordendecompra='".$orden["idordendecompra"]."'";
    $result_pro=mysql_query($sql_pro,$con) or die(mysql_error());
    $numerproductos=mysql_num_rows($result_pro);
    $cuenta=1;
    if($numerproductos<=42){
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
            
            $suma=$suma+4;
            $pdf->SetFont('courier', '', 7);
            $pdf->SetXY(10,$suma);
            $pdf->Cell(7, 4,$cuenta, 1, 1,"R", 0, '', 0);
            $pdf->SetXY(17,$suma);
            $pdf->Cell(18, 4,$material["nombre"], 1, 1,"L", 0, '', 0);
            $pdf->SetXY(35,$suma);
            $pdf->Cell(18, 4,$producto["codigo"], 1, 1,"L", 0, '', 0); 
            $pdf->SetXY(53,$suma);
            $pdf->Cell(65, 4,$producto["descripcion"], 1, 1,"L", 0, '', 0); 
            $pdf->SetXY(118,$suma);
            $pdf->Cell(11, 4,$color["codigo"], 1, 1,"C", 0, '', 0);  
            $pdf->SetXY(129,$suma);
            $pdf->Cell(11, 4,$producto["dimensionlargo"], 1, 1,"R", 0, '', 0);
            $pdf->SetXY(140,$suma);
            $pdf->Cell(11, 4,$producto["dimensionancho"], 1, 1,"R", 0, '', 0); 
            $pdf->SetXY(151,$suma);
            $pdf->Cell(11, 4,$producto["dimensionalto"], 1, 1,"R", 0, '', 0); 
            $pdf->SetXY(162,$suma);
            $pdf->Cell(10, 4,$proorden["numerodeunidades"], 1, 1,"C", 0, '', 0); 
            $pdf->SetXY(172,$suma);
            $pdf->Cell(14, 4,"$".$proorden["precioventa"], 1, 1,"C", 0, '', 0); 
            $pdf->SetXY(186,$suma);
            $pdf->Cell(17, 4,"$".($proorden["precioventa"]*$proorden["numerodeunidades"]), 1, 1,"R", 0, '', 0);
            $cuenta++;
                                           
        }        
    }else 
    if($numerproductos>42){
        if($cuenta<42){
            while (($proorden = mysql_fetch_assoc($result_pro)) && $cuenta<42) {            
                $sqlproducto="select * from producto where idproducto='".$proorden["idproducto"]."'";
                $resultproducto=mysql_query($sqlproducto,$con) or die(mysql_error());
                $producto = mysql_fetch_assoc($resultproducto);
                
                $sqlmaterial="select * from material where idmaterial='".$producto["idmaterial"]."'";
                $resultMaterial=mysql_query($sqlmaterial,$con) or die(mysql_error());
                $material = mysql_fetch_assoc($resultMaterial);
                
                $sqlcolor="select * from color where idcolor='".$proorden["idcolor"]."'";
                $resultColor=mysql_query($sqlcolor,$con) or die(mysql_error());
                $color = mysql_fetch_assoc($resultColor);            
            
                $suma=$suma+4;
                $pdf->SetFont('courier', '', 7);
                $pdf->SetXY(10,$suma);
                $pdf->Cell(7, 4,$cuenta, 1, 1,"R", 0, '', 0);
                $pdf->SetXY(17,$suma);
                $pdf->Cell(18, 4,$material["nombre"], 1, 1,"L", 0, '', 0);
                $pdf->SetXY(35,$suma);
                $pdf->Cell(18, 4,$producto["codigo"], 1, 1,"L", 0, '', 0); 
                $pdf->SetXY(53,$suma);
                $pdf->Cell(65, 4,$producto["descripcion"], 1, 1,"L", 0, '', 0); 
                $pdf->SetXY(118,$suma);
                $pdf->Cell(11, 4,$color["codigo"], 1, 1,"C", 0, '', 0);  
                $pdf->SetXY(129,$suma);
                $pdf->Cell(11, 4,$producto["dimensionlargo"], 1, 1,"R", 0, '', 0);
                $pdf->SetXY(140,$suma);
                $pdf->Cell(11, 4,$producto["dimensionancho"], 1, 1,"R", 0, '', 0); 
                $pdf->SetXY(151,$suma);
                $pdf->Cell(11, 4,$producto["dimensionalto"], 1, 1,"R", 0, '', 0); 
                $pdf->SetXY(162,$suma);
                $pdf->Cell(10, 4,$proorden["numerodeunidades"], 1, 1,"C", 0, '', 0); 
                $pdf->SetXY(172,$suma);
                $pdf->Cell(14, 4,"$".$proorden["precioventa"], 1, 1,"C", 0, '', 0); 
                $pdf->SetXY(186,$suma);
                $pdf->Cell(17, 4,"$".($proorden["precioventa"]*$proorden["numerodeunidades"]), 1, 1,"R", 0, '', 0);
                $cuenta++;
            }
          
            
        }
        if($cuenta>=42){
            $pdf->AddPage('P', 'A4');
            $pdf->Image('../imagenes/apariencia/logobugambilia.png', 10, 14, 53,14, 'PNG', 'http://www.gaagdesarrolloempresarial.com', '', true, 150, '', false, false, 0, false, false, false);    
            $pdf->SetFont('courier', 'B', 10); 
    
            $suma=10;
            $pdf->SetFont('courier', 'B', 8);
            $pdf->SetXY(140,$suma);
            $pdf->Cell(35, 4,"Orden de Compra", 0, 1,"L", 0, '', 0);
            $pdf->SetXY(175,$suma);
            $pdf->SetFont('courier', 'N', 8);
            $pdf->Cell(25, 4,$orden["codigoexterno"],0, 1,"L", 0, '', 0); $suma+=4;
    
            $pdf->SetFont('courier', 'B', 8);
            $pdf->SetXY(140,$suma);
            $pdf->Cell(35, 4,"Orden de Producción", 0, 1,"L", 0, '', 0);
            $pdf->SetXY(175,$suma);
            $pdf->SetFont('courier', 'N', 8);
            $pdf->Cell(25, 4,$orden["codigoop"], 0, 1,"L", 0, '', 0); $suma+=4;  
    
            $pdf->SetFont('courier', 'B', 8);
            $pdf->SetXY(140,$suma);
            $pdf->Cell(35, 4,"Fecha de Pedido", 0, 1,"L", 0, '', 0);
            $pdf->SetXY(175,$suma);
            $pdf->SetFont('courier', 'N', 8);
            $pdf->Cell(25, 4,$orden["fechaderegistro"], 0, 1,"L", 0, '', 0); $suma+=4;
    
            $pdf->SetFont('courier', 'B', 8);
            $pdf->SetXY(140,$suma);
            $pdf->Cell(35, 4,"Fecha de Entrega", 0, 1,"L", 0, '', 0);
            $pdf->SetXY(175,$suma);
            $pdf->SetFont('courier', 'N', 8);
            $pdf->Cell(25, 4,$orden["fechadeentrega"], 0, 1,"L", 0, '', 0); $suma+=7;    
            
            $pdf->Line(10, $suma, 200, $suma);   
            
            $pdf->SetFont('courier', '', 9);
            $pdf->Line(10, 285, 200, 285);
            $pdf->SetXY(170,287);
            $pdf->Cell(30, 4,"Página Nro. 0".$pagina, 0, 1,"R", 0, '', 0);  $pagina++;              
            
            
            $suma=30;
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
            
                $suma=$suma+4;
                $pdf->SetFont('courier', '', 7);
                $pdf->SetXY(10,$suma);
                $pdf->Cell(7, 4,$cuenta, 1, 1,"R", 0, '', 0);
                $pdf->SetXY(17,$suma);
                $pdf->Cell(18, 4,$material["nombre"], 1, 1,"L", 0, '', 0);
                $pdf->SetXY(35,$suma);
                $pdf->Cell(18, 4,$producto["codigo"], 1, 1,"L", 0, '', 0); 
                $pdf->SetXY(53,$suma);
                $pdf->Cell(65, 4,$producto["descripcion"], 1, 1,"L", 0, '', 0); 
                $pdf->SetXY(118,$suma);
                $pdf->Cell(11, 4,$color["codigo"], 1, 1,"C", 0, '', 0);  
                $pdf->SetXY(129,$suma);
                $pdf->Cell(11, 4,$producto["dimensionlargo"], 1, 1,"R", 0, '', 0);
                $pdf->SetXY(140,$suma);
                $pdf->Cell(11, 4,$producto["dimensionancho"], 1, 1,"R", 0, '', 0); 
                $pdf->SetXY(151,$suma);
                $pdf->Cell(11, 4,$producto["dimensionalto"], 1, 1,"R", 0, '', 0); 
                $pdf->SetXY(162,$suma);
                $pdf->Cell(10, 4,$proorden["numerodeunidades"], 1, 1,"C", 0, '', 0); 
                $pdf->SetXY(172,$suma);
                $pdf->Cell(14, 4,"$".$proorden["precioventa"], 1, 1,"C", 0, '', 0); 
                $pdf->SetXY(186,$suma);
                $pdf->Cell(17, 4,"$".($proorden["precioventa"]*$proorden["numerodeunidades"]), 1, 1,"R", 0, '', 0);
                $cuenta++;
            }             
        }            
    }     
    
    $suma=$suma+4;
    $pdf->SetXY(172,$suma);
    $pdf->Cell(14, 4,"Subtotal", 0, 1,"R", 0, '', 0); 
    $pdf->SetXY(186,$suma);
    $pdf->Cell(17, 4,"$".round($orden["subtotal"],2), 1, 1,"R", 0, '', 0);  
    
    $suma=$suma+4;
    $pdf->SetXY(172,$suma);
    $pdf->Cell(14, 4,"Iva(".round($orden["poriva"],2)."%)", 0, 1,"R", 0, '', 0); 
    $pdf->SetXY(186,$suma);
    $pdf->Cell(17, 4,"$".round($orden["iva"],2), 1, 1,"R", 0, '', 0);  
    
    $suma=$suma+4;
    $pdf->SetXY(172,$suma);
    $pdf->Cell(14, 4,"Total", 0, 1,"R", 0, '', 0); 
    $pdf->SetXY(186,$suma);
    $pdf->Cell(17, 4,"$".round($orden["total"],2), 1, 1,"R", 0, '', 0);    
    
    /*-------------------------------------------------------------------*/
    
    $suma+=8;
    if(($suma+16)>275){
        $pdf->AddPage('P', 'A4');
        $pdf->Image('../imagenes/apariencia/logobugambilia.png', 10, 14, 53,14, 'PNG', 'http://www.gaagdesarrolloempresarial.com', '', true, 150, '', false, false, 0, false, false, false);    
        $pdf->SetFont('courier', 'B', 10); 
        $pdf->Line(10, 30, 200, 30);
        
        $suma=10;
        $pdf->SetFont('courier', 'B', 8);
        $pdf->SetXY(140,$suma);
        $pdf->Cell(35, 4,"Orden de Compra", 0, 1,"L", 0, '', 0);
        $pdf->SetXY(175,$suma);
        $pdf->SetFont('courier', 'N', 8);
        $pdf->Cell(25, 4,$orden["codigoexterno"],0, 1,"L", 0, '', 0); $suma+=4;
    
        $pdf->SetFont('courier', 'B', 8);
        $pdf->SetXY(140,$suma);
        $pdf->Cell(35, 4,"Orden de Producción", 0, 1,"L", 0, '', 0);
        $pdf->SetXY(175,$suma);
        $pdf->SetFont('courier', 'N', 8);
        $pdf->Cell(25, 4,$orden["codigoop"], 0, 1,"L", 0, '', 0); $suma+=4;  
    
        $pdf->SetFont('courier', 'B', 8);
        $pdf->SetXY(140,$suma);
        $pdf->Cell(35, 4,"Fecha de Pedido", 0, 1,"L", 0, '', 0);
        $pdf->SetXY(175,$suma);
        $pdf->SetFont('courier', 'N', 8);
        $pdf->Cell(25, 4,$orden["fechaderegistro"], 0, 1,"L", 0, '', 0); $suma+=4;
    
        $pdf->SetFont('courier', 'B', 8);
        $pdf->SetXY(140,$suma);
        $pdf->Cell(35, 4,"Fecha de Entrega", 0, 1,"L", 0, '', 0);
        $pdf->SetXY(175,$suma);
        $pdf->SetFont('courier', 'N', 8);
        $pdf->Cell(25, 4,$orden["fechadeentrega"], 0, 1,"L", 0, '', 0); $suma+=7;
        
        $pdf->SetFont('courier', '', 9);
        $pdf->Line(10, 285, 200, 285);
        $pdf->SetXY(170,287);
        $pdf->Cell(30, 4,"Página Nro. 0".$pagina, 0, 1,"R", 0, '', 0);  $pagina++;        
        
        $suma=35;        
    }
    
    $pdf->SetFont('courier', 'B', 8);
    $pdf->SetXY(10,$suma);
    $pdf->Cell(93, 4,"Condiciones de Pago", 1, 1,"L", 0, '', 0);
    $pdf->SetXY(103,$suma);
    $pdf->SetFont('courier', 'N', 8);
    $pdf->Cell(100, 4,$condiciones, 1, 1,"L", 0, '', 0); $suma+=4; 
    
    $pdf->SetFont('courier', 'B', 8);
    $pdf->SetXY(10,$suma);
    $pdf->Cell(93, 4,"Contacto de Compras", 1, 1,"L", 0, '', 0);
    $pdf->SetXY(103,$suma);
    $pdf->SetFont('courier', 'N', 8);
    $pdf->Cell(100, 4,$agenda01["nombre"], 1, 1,"L", 0, '', 0); $suma+=4;
    
    $pdf->SetFont('courier', 'B', 8);
    $pdf->SetXY(10,$suma);
    $pdf->Cell(93, 4,"Teléfono", 1, 1,"L", 0, '', 0);
    $pdf->SetXY(103,$suma);
    $pdf->SetFont('courier', 'N', 8);
    $pdf->Cell(100, 4,$agenda01["telefono1"], 1, 1,"L", 0, '', 0); $suma+=4; 
    
    $pdf->SetFont('courier', 'B', 8);
    $pdf->SetXY(10,$suma);
    $pdf->Cell(93, 4,"Correo Electrónico", 1, 1,"L", 0, '', 0);
    $pdf->SetXY(103,$suma);
    $pdf->SetFont('courier', 'N', 8);
    $pdf->Cell(100, 4,$agenda01["email"], 1, 1,"L", 0, '', 0); $suma+=4;    
    
    
    /*-------------------------------------------------------------------*/
    
    $suma+=2;
    if(($suma+16)>275){
        $pdf->AddPage('P', 'A4');
        $pdf->Image('../imagenes/apariencia/logobugambilia.png', 10, 14, 53,14, 'PNG', 'http://www.gaagdesarrolloempresarial.com', '', true, 150, '', false, false, 0, false, false, false);    
        $pdf->SetFont('courier', 'B', 10);     
        $pdf->Line(10, 30, 200, 30);
        
        $suma=10;
        $pdf->SetFont('courier', 'B', 8);
        $pdf->SetXY(140,$suma);
        $pdf->Cell(35, 4,"Orden de Compra", 0, 1,"L", 0, '', 0);
        $pdf->SetXY(175,$suma);
        $pdf->SetFont('courier', 'N', 8);
        $pdf->Cell(25, 4,$orden["codigoexterno"],0, 1,"L", 0, '', 0); $suma+=4;
    
        $pdf->SetFont('courier', 'B', 8);
        $pdf->SetXY(140,$suma);
        $pdf->Cell(35, 4,"Orden de Producción", 0, 1,"L", 0, '', 0);
        $pdf->SetXY(175,$suma);
        $pdf->SetFont('courier', 'N', 8);
        $pdf->Cell(25, 4,$orden["codigoop"], 0, 1,"L", 0, '', 0); $suma+=4;  
    
        $pdf->SetFont('courier', 'B', 8);
        $pdf->SetXY(140,$suma);
        $pdf->Cell(35, 4,"Fecha de Pedido", 0, 1,"L", 0, '', 0);
        $pdf->SetXY(175,$suma);
        $pdf->SetFont('courier', 'N', 8);
        $pdf->Cell(25, 4,$orden["fechaderegistro"], 0, 1,"L", 0, '', 0); $suma+=4;
    
        $pdf->SetFont('courier', 'B', 8);
        $pdf->SetXY(140,$suma);
        $pdf->Cell(35, 4,"Fecha de Entrega", 0, 1,"L", 0, '', 0);
        $pdf->SetXY(175,$suma);
        $pdf->SetFont('courier', 'N', 8);
        $pdf->Cell(25, 4,$orden["fechadeentrega"], 0, 1,"L", 0, '', 0); $suma+=7;        
        
        $pdf->SetFont('courier', '', 9);
        $pdf->Line(10, 285, 200, 285);
        $pdf->SetXY(170,287);
        $pdf->Cell(30, 4,"Página Nro. 0".$pagina, 0, 1,"R", 0, '', 0);  $pagina++;        
        
        $suma=35;        
    }    
    
    $pdf->SetFont('courier', 'B', 8);
    $pdf->SetXY(10,$suma);
    $pdf->Cell(193, 4,"Contacto Cuenta por Pagar o Persona encargada de recibir factura electrónica", 1, 1,"C", 0, '', 0); $suma+=4;    
    
    $pdf->SetFont('courier', 'B', 8);
    $pdf->SetXY(10,$suma);
    $pdf->Cell(93, 4,"Nombre", 1, 1,"L", 0, '', 0);
    $pdf->SetXY(103,$suma);
    $pdf->SetFont('courier', 'N', 8);
    $pdf->Cell(100, 4,$agenda02["nombre"], 1, 1,"L", 0, '', 0); $suma+=4;
    
    $pdf->SetFont('courier', 'B', 8);
    $pdf->SetXY(10,$suma);
    $pdf->Cell(93, 4,"Teléfono", 1, 1,"L", 0, '', 0);
    $pdf->SetXY(103,$suma);
    $pdf->SetFont('courier', 'N', 8);
    $pdf->Cell(100, 4,$agenda02["telefono1"], 1, 1,"L", 0, '', 0); $suma+=4; 
    
    $pdf->SetFont('courier', 'B', 8);
    $pdf->SetXY(10,$suma);
    $pdf->Cell(93, 4,"Correo Electrónico", 1, 1,"L", 0, '', 0);
    $pdf->SetXY(103,$suma);
    $pdf->SetFont('courier', 'N', 8);
    $pdf->Cell(100, 4,$agenda02["email"], 1, 1,"L", 0, '', 0); $suma+=4;
    
    /*-------------------------------------------------------------------*/
    
    $suma+=2;
    if(($suma+12)>275){
        $pdf->AddPage('P', 'A4');
        $pdf->Image('../imagenes/apariencia/logobugambilia.png', 10, 14, 53,14, 'PNG', 'http://www.gaagdesarrolloempresarial.com', '', true, 150, '', false, false, 0, false, false, false);    
        $pdf->SetFont('courier', 'B', 10);     
        $pdf->Line(10, 30, 200, 30);
        
        $suma=10;
        $pdf->SetFont('courier', 'B', 8);
        $pdf->SetXY(140,$suma);
        $pdf->Cell(35, 4,"Orden de Compra", 0, 1,"L", 0, '', 0);
        $pdf->SetXY(175,$suma);
        $pdf->SetFont('courier', 'N', 8);
        $pdf->Cell(25, 4,$orden["codigoexterno"],0, 1,"L", 0, '', 0); $suma+=4;
    
        $pdf->SetFont('courier', 'B', 8);
        $pdf->SetXY(140,$suma);
        $pdf->Cell(35, 4,"Orden de Producción", 0, 1,"L", 0, '', 0);
        $pdf->SetXY(175,$suma);
        $pdf->SetFont('courier', 'N', 8);
        $pdf->Cell(25, 4,$orden["codigoop"], 0, 1,"L", 0, '', 0); $suma+=4;  
    
        $pdf->SetFont('courier', 'B', 8);
        $pdf->SetXY(140,$suma);
        $pdf->Cell(35, 4,"Fecha de Pedido", 0, 1,"L", 0, '', 0);
        $pdf->SetXY(175,$suma);
        $pdf->SetFont('courier', 'N', 8);
        $pdf->Cell(25, 4,$orden["fechaderegistro"], 0, 1,"L", 0, '', 0); $suma+=4;
    
        $pdf->SetFont('courier', 'B', 8);
        $pdf->SetXY(140,$suma);
        $pdf->Cell(35, 4,"Fecha de Entrega", 0, 1,"L", 0, '', 0);
        $pdf->SetXY(175,$suma);
        $pdf->SetFont('courier', 'N', 8);
        $pdf->Cell(25, 4,$orden["fechadeentrega"], 0, 1,"L", 0, '', 0); $suma+=7;        
        
        $pdf->SetFont('courier', '', 9);
        $pdf->Line(10, 285, 200, 285);
        $pdf->SetXY(170,287);
        $pdf->Cell(30, 4,"Página Nro. 0".$pagina, 0, 1,"R", 0, '', 0);  $pagina++;        
        
        $suma=35;         
    }
    
    $pdf->SetFont('courier', 'B', 8);
    $pdf->SetXY(10,$suma);
    $pdf->Cell(93, 4,"Método de Pago", 1, 1,"L", 0, '', 0);
    $pdf->SetXY(103,$suma);
    $pdf->SetFont('courier', 'N', 8);
    $pdf->Cell(100, 4,$metodo, 1, 1,"L", 0, '', 0); $suma+=4;
    
    $pdf->SetFont('courier', 'B', 8);
    $pdf->SetXY(10,$suma);
    $pdf->Cell(93, 4,"Banco del Cliente", 1, 1,"L", 0, '', 0);
    $pdf->SetXY(103,$suma);
    $pdf->SetFont('courier', 'N', 8);
    $pdf->Cell(100, 4,$empresa["banco"], 1, 1,"L", 0, '', 0); $suma+=4; 
    
    $pdf->SetFont('courier', 'B', 8);
    $pdf->SetXY(10,$suma);
    $pdf->Cell(93, 4,"Últimos 4 Dígitos de la cuenta bancaria", 1, 1,"L", 0, '', 0);
    $pdf->SetXY(103,$suma);
    $pdf->SetFont('courier', 'N', 8);
    $pdf->Cell(100, 4,$empresa["ultimos"], 1, 1,"L", 0, '', 0); $suma+=4;    
    
    /*-------------------------------------------------------------------*/
    
    $suma+=2;
    if(($suma+20)>275){
        $pdf->AddPage('P', 'A4');
        $pdf->Image('../imagenes/apariencia/logobugambilia.png', 10, 14, 53,14, 'PNG', 'http://www.gaagdesarrolloempresarial.com', '', true, 150, '', false, false, 0, false, false, false);    
        $pdf->SetFont('courier', 'B', 10);     
        $pdf->Line(10, 30, 200, 30);
        
        $suma=10;
        $pdf->SetFont('courier', 'B', 8);
        $pdf->SetXY(140,$suma);
        $pdf->Cell(35, 4,"Orden de Compra", 0, 1,"L", 0, '', 0);
        $pdf->SetXY(175,$suma);
        $pdf->SetFont('courier', 'N', 8);
        $pdf->Cell(25, 4,$orden["codigoexterno"],0, 1,"L", 0, '', 0); $suma+=4;
    
        $pdf->SetFont('courier', 'B', 8);
        $pdf->SetXY(140,$suma);
        $pdf->Cell(35, 4,"Orden de Producción", 0, 1,"L", 0, '', 0);
        $pdf->SetXY(175,$suma);
        $pdf->SetFont('courier', 'N', 8);
        $pdf->Cell(25, 4,$orden["codigoop"], 0, 1,"L", 0, '', 0); $suma+=4;  
    
        $pdf->SetFont('courier', 'B', 8);
        $pdf->SetXY(140,$suma);
        $pdf->Cell(35, 4,"Fecha de Pedido", 0, 1,"L", 0, '', 0);
        $pdf->SetXY(175,$suma);
        $pdf->SetFont('courier', 'N', 8);
        $pdf->Cell(25, 4,$orden["fechaderegistro"], 0, 1,"L", 0, '', 0); $suma+=4;
    
        $pdf->SetFont('courier', 'B', 8);
        $pdf->SetXY(140,$suma);
        $pdf->Cell(35, 4,"Fecha de Entrega", 0, 1,"L", 0, '', 0);
        $pdf->SetXY(175,$suma);
        $pdf->SetFont('courier', 'N', 8);
        $pdf->Cell(25, 4,$orden["fechadeentrega"], 0, 1,"L", 0, '', 0); $suma+=7;        
        
        $pdf->SetFont('courier', '', 9);
        $pdf->Line(10, 285, 200, 285);
        $pdf->SetXY(170,287);
        $pdf->Cell(30, 4,"Página Nro. 0".$pagina, 0, 1,"R", 0, '', 0);  $pagina++;        
        
        $suma=35;         
    }
    
    $pdf->SetFont('courier', 'B', 8);
    $pdf->SetXY(10,$suma);
    $pdf->Cell(193, 4,"Datos de Entrega", 1, 1,"C", 0, '', 0); $suma+=4;  
    
    $pdf->SetFont('courier', 'B', 8);
    $pdf->SetXY(10,$suma);
    $pdf->Cell(93, 4,"Persona Encargada de Recibir", 1, 1,"L", 0, '', 0);
    $pdf->SetXY(103,$suma);
    $pdf->SetFont('courier', 'N', 8);
    $pdf->Cell(100, 4,$agenda03["referencia"]." - ".$agenda03["nombre"], 1, 1,"L", 0, '', 0); $suma+=4;  
    
    $pdf->SetFont('courier', 'B', 8);
    $pdf->SetXY(10,$suma);
    $pdf->Cell(93, 4,"Paqueteria", 1, 1,"L", 0, '', 0);
    $pdf->SetXY(103,$suma);
    $pdf->SetFont('courier', 'N', 8);
    $pdf->Cell(100, 4,$orden["paqueteria"], 1, 1,"L", 0, '', 0); $suma+=4; 
    
    $pdf->SetFont('courier', 'N', 8);
    $pdf->SetXY(10,$suma);
    //$pdf->MultiCell(193, 4,"Dirección de Entrega: ".$empresa["entregacalle"].", nro ext ".$empresa["entregaexterior"].", nro int ".$empresa["entregainterior"].", Colonia ".$empresa["entregacolonia"].", Codigo Postal ".$empresa["entregapostal"].", ".$empresa["entregaciudad"].", ".$empresa["entregaestado"].". ".$empresa["entregareferencia"], 1, "L", 0, 0, 10, $suma, true); $suma+=8;     
    $pdf->writeHTMLCell(193,4,10,$suma,"<b>Dirección de Entrega: </b>".$empresa["entregacalle"].", nro ext ".$empresa["entregaexterior"].", nro int ".$empresa["entregainterior"].", Colonia ".$empresa["entregacolonia"].", Codigo Postal ".$empresa["entregapostal"].", ".$empresa["entregaciudad"].", ".$empresa["entregaestado"].". ".$empresa["entregareferencia"], 1, 0, false, true, "L");
    
    /*-------------------------------------------------------------------*/
    
    $suma+=15;
    
    $pdf->SetFont('courier', 'B', 8);
    $pdf->SetXY(10,$suma);
    $pdf->Cell(193, 4,"Observaciones", 1, 1,"C", 0, '', 0); $suma+=4; 
    
    $pdf->SetFont('courier', 'N', 8);
    $pdf->MultiCell(193, 4,$orden["observaciones"], 1, "L", 0, 0, 10, $suma, true);        
    
    if($_GET["aux"]==0){
        $pdf->Output('Orden de Compra '.$orden["codigoexterno"].'.pdf', 'I');
    }else if($_GET["aux"]==1){
        $pdf->Output('C:\xampp\htdocs\bugambilia\pdfs\temporal\Orden de Compra '.$orden["codigoexterno"].'.pdf', 'F');
        
        $sqlORDENCOMPRA="select * from ordendecompra where idordendecompra='".$_GET["id"]."'";
        $resultORDENCOMPRA=mysql_query($sqlORDENCOMPRA,$con) or die(mysql_error());
        $ordendecompra = mysql_fetch_assoc($resultORDENCOMPRA);
        
        $sql_CONFIGURACION="select * from configuracionsistema where idconfiguracionsistema=1";
        $result_CONFIGURACION=mysql_query($sql_CONFIGURACION,$con) or die(mysql_error());
        if(mysql_num_rows($result_CONFIGURACION)>0){
            $configuracion = mysql_fetch_assoc($result_CONFIGURACION);                                                                                                                                           
        } 
        
        $sqlAGENDA="select * from agenda where idagenda='".$ordendecompra["idagenda01"]."'";
        $resultAGENDA=mysql_query($sqlAGENDA,$con) or die(mysql_error());
        $contacto = mysql_fetch_assoc($resultAGENDA);        
        
        
        require_once "Mail.php";
        include 'Mail/mime.php' ;

        $from = '<'.$configuracion["correo"].'>';        
        $to = $contacto["email"];
        $subject = 'Orden de Compra '.$ordendecompra["codigoexterno"];

        $headers = array(
            'From' => $from,
            'To' => $to,
            'Subject' => $subject
        ); 
        
        $mime = new Mail_mime();
        $mime -> setHTMLBody("Estimado cliente, adjunto le estamos enviando la Orden de Compra ".$ordendecompra["codigoexterno"].", para que la pueda revisar y nos confirme si todos los datos son correctos para proceder a mandar a produccion.\n");        
        $mime -> addAttachment("C:\\xampp\\htdocs\\bugambilia\\pdfs\\temporal\\Orden de Compra ".$orden["codigoexterno"].".pdf",'pdf');
        $body = $mime->get();
        $headers = $mime -> headers($headers);        
        
        $smtp = Mail::factory('smtp', array(
            'host' => $configuracion["servidor"],
            'port' => $configuracion["puerto"],
            'auth' => true,
            'username' => $configuracion["correo"],
            'password' => $configuracion["password"]
        ));

        $mail = $smtp->send($to, $headers, $body);

        if (PEAR::isError($mail)) {
            echo('<p>' . $mail->getMessage() . '</p>');
        } else {
            ?>
                <script type="text/javascript">
                    alert("Correo Electronico Enviado satisfactoriamente.");
                    parent.window.close();
                </script>
            <?php
        }        
        
    }                
?>