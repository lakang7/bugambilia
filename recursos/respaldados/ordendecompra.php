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
    
    $pdf->SetXY(100,10);
    $pdf->Cell(100, 4,"Orden de Compra: ".$orden["codigooc"], 0, 1,"R", 0, '', 0);
    $pdf->SetFont('courier', '', 10);
    $pdf->SetXY(100,14);
    $pdf->Cell(100, 4,"Cliente: ".$empresa["nombreempresa"], 0, 1,"R", 0, '', 0);  
    $pdf->SetXY(100,18);
    $pdf->Cell(100, 4,"Fecha de Pedido: ".$orden["fechaderegistro"], 0, 1,"R", 0, '', 0);  
    $pdf->SetXY(100,22);
    $pdf->Cell(100, 4,"Fecha de Entrega: ".$orden["fechadeentrega"], 0, 1,"R", 0, '', 0);     
    $pdf->Line(10, 29, 200, 29);
    
    /*Datos del Cliente*/
    $suma=35;
    $pdf->SetFont('courier', 'B', 12);
    $pdf->SetXY(10,$suma-1);$suma+=4.6;
    $pdf->Cell(144, 4,"Contacto de Compra", 0, 1,"L", 0, '', 0); 
    $pdf->SetFont('courier', 'B', 9);
    $pdf->SetXY(10,$suma);$suma+=4.6;
    $pdf->Cell(42, 4,"Codigo del Cliente:", 0, 1,"L", 0, '', 0);      
    $pdf->SetXY(10,$suma);$suma+=4.6;
    $pdf->Cell(42, 4,"Empresa:", 0, 1,"L", 0, '', 0);
    $pdf->SetXY(10,$suma);$suma+=4.6;
    $pdf->Cell(42, 4,"Contacto:", 0, 1,"L", 0, '', 0);
    $pdf->SetXY(10,$suma);$suma+=4.6;
    $pdf->Cell(42, 4,"Puesto:", 0, 1,"L", 0, '', 0);
    $pdf->SetXY(10,$suma);$suma+=4.6;
    $pdf->Cell(42, 4,"Email:", 0, 1,"L", 0, '', 0);
    $pdf->SetXY(10,$suma);$suma+=4.6;
    $pdf->Cell(42, 4,"Telefono:", 0, 1,"L", 0, '', 0);    
    $suma=35+4.6;
    $pdf->SetFont('courier', '', 9);
    $pdf->SetXY(52,$suma);$suma+=4.6;
    $pdf->Cell(102, 4,$empresa["codigo"], 0, 1,"L", 0, '', 0);    
    $pdf->SetXY(52,$suma);$suma+=4.6;
    $pdf->Cell(102, 4,$empresa["nombreempresa"], 0, 1,"L", 0, '', 0); 
    $pdf->SetXY(52,$suma);$suma+=4.6;
    $pdf->Cell(102, 4,$agenda01["nombre"], 0, 1,"L", 0, '', 0);  
    $pdf->SetXY(52,$suma);$suma+=4.6;
    $pdf->Cell(102, 4,$agenda01["referencia"], 0, 1,"L", 0, '', 0); 
    $pdf->SetXY(52,$suma);$suma+=4.6;
    $pdf->Cell(102, 4,$agenda01["email"], 0, 1,"L", 0, '', 0);
    $pdf->SetXY(52,$suma);$suma+=4.6;
    $pdf->Cell(102, 4,$agenda01["telefono1"], 0, 1,"L", 0, '', 0);             
    
    $aux=$suma;
    $suma+=5;
    $pdf->SetFont('courier', 'B', 12);
    $pdf->SetXY(10,$suma-1);$suma+=4.6;
    $pdf->Cell(144, 4,"Contacto de Cuentas por Pagar", 0, 1,"L", 0, '', 0); 
    $pdf->SetFont('courier', 'B', 9);
    $pdf->SetXY(10,$suma);$suma+=4.6;
    $pdf->Cell(42, 4,"Contacto:", 0, 1,"L", 0, '', 0);
    $pdf->SetXY(10,$suma);$suma+=4.6;
    $pdf->Cell(42, 4,"Puesto:", 0, 1,"L", 0, '', 0);
    $pdf->SetXY(10,$suma);$suma+=4.6;
    $pdf->Cell(42, 4,"Email:", 0, 1,"L", 0, '', 0);
    $pdf->SetXY(10,$suma);$suma+=4.6;
    $pdf->Cell(42, 4,"Telefono:", 0, 1,"L", 0, '', 0);    
    $suma=$aux+9.6;
    $pdf->SetFont('courier', '', 9);
    $pdf->SetXY(52,$suma);$suma+=4.6;
    $pdf->Cell(102, 4,$agenda02["nombre"], 0, 1,"L", 0, '', 0);  
    $pdf->SetXY(52,$suma);$suma+=4.6;
    $pdf->Cell(102, 4,$agenda02["referencia"], 0, 1,"L", 0, '', 0); 
    $pdf->SetXY(52,$suma);$suma+=4.6;
    $pdf->Cell(102, 4,$agenda02["email"], 0, 1,"L", 0, '', 0);
    $pdf->SetXY(52,$suma);$suma+=4.6;
    $pdf->Cell(102, 4,$agenda02["telefono1"], 0, 1,"L", 0, '', 0);     
    
    $aux=$suma;
    $suma+=5;
    $pdf->SetFont('courier', 'B', 12);
    $pdf->SetXY(10,$suma-1);$suma+=4.6;
    $pdf->Cell(144, 4,"Contacto de Entrega", 0, 1,"L", 0, '', 0); 
    $pdf->SetFont('courier', 'B', 9);
    $pdf->SetXY(10,$suma);$suma+=4.6;
    $pdf->Cell(42, 4,"Contacto:", 0, 1,"L", 0, '', 0);
    $pdf->SetXY(10,$suma);$suma+=4.6;
    $pdf->Cell(42, 4,"Puesto:", 0, 1,"L", 0, '', 0);
    $pdf->SetXY(10,$suma);$suma+=4.6;
    $pdf->Cell(42, 4,"Email:", 0, 1,"L", 0, '', 0);
    $pdf->SetXY(10,$suma);$suma+=4.6;
    $pdf->Cell(42, 4,"Telefono:", 0, 1,"L", 0, '', 0);    
    $suma=$aux+9.6;
    $pdf->SetFont('courier', '', 9);
    $pdf->SetXY(52,$suma);$suma+=4.6;
    $pdf->Cell(102, 4,$agenda03["nombre"], 0, 1,"L", 0, '', 0);  
    $pdf->SetXY(52,$suma);$suma+=4.6;
    $pdf->Cell(102, 4,$agenda03["referencia"], 0, 1,"L", 0, '', 0); 
    $pdf->SetXY(52,$suma);$suma+=4.6;
    $pdf->Cell(102, 4,$agenda03["email"], 0, 1,"L", 0, '', 0);
    $pdf->SetXY(52,$suma);$suma+=4.6;
    $pdf->Cell(102, 4,$agenda03["telefono1"], 0, 1,"L", 0, '', 0);     
    
    $aux=$suma;
    $suma+=5;
    
    $pdf->SetFont('courier', 'B', 12);
    $pdf->SetXY(10,$suma-1);$suma+=4.6;
    $pdf->Cell(144, 4,"Datos de Facturación", 0, 1,"L", 0, '', 0); 
    $pdf->SetFont('courier', 'B', 9);
    $pdf->SetXY(10,$suma);$suma+=4.6;
    $pdf->Cell(42, 4,"Nombre:", 0, 1,"L", 0, '', 0);      
    $pdf->SetXY(10,$suma);$suma+=4.6;
    $pdf->Cell(42, 4,"Calle:", 0, 1,"L", 0, '', 0);
    $pdf->SetXY(10,$suma);$suma+=4.6;
    $pdf->Cell(42, 4,"Numero Exterior::", 0, 1,"L", 0, '', 0);
    $pdf->SetXY(10,$suma);$suma+=4.6;
    $pdf->Cell(42, 4,"Numero Interior:", 0, 1,"L", 0, '', 0);
    $pdf->SetXY(10,$suma);$suma+=4.6;
    $pdf->Cell(42, 4,"Colonia:", 0, 1,"L", 0, '', 0);
    $pdf->SetXY(10,$suma);$suma+=4.6;
    $pdf->Cell(42, 4,"Codigo Postal:", 0, 1,"L", 0, '', 0);     
    $pdf->SetXY(10,$suma);$suma+=4.6;
    $pdf->Cell(42, 4,"Estado y País:", 0, 1,"L", 0, '', 0);
    $pdf->SetXY(10,$suma);$suma+=4.6;
    $pdf->Cell(42, 4,"RFC:", 0, 1,"L", 0, '', 0);  
    
    $suma=$aux+5+4.6;
    $pdf->SetFont('courier', '', 9);
    $pdf->SetXY(52,$suma);$suma+=4.6;
    $pdf->Cell(102, 4,$empresa["nombreempresa"], 0, 1,"L", 0, '', 0);    
    $pdf->SetXY(52,$suma);$suma+=4.6;
    $pdf->Cell(102, 4,$empresa["fiscalcalle"], 0, 1,"L", 0, '', 0); 
    $pdf->SetXY(52,$suma);$suma+=4.6;
    $pdf->Cell(102, 4,$empresa["fiscalexterior"], 0, 1,"L", 0, '', 0);  
    $pdf->SetXY(52,$suma);$suma+=4.6;
    $pdf->Cell(102, 4,$empresa["fiscalinterior"], 0, 1,"L", 0, '', 0); 
    $pdf->SetXY(52,$suma);$suma+=4.6;
    $pdf->Cell(102, 4,$empresa["fiscalcolonia"], 0, 1,"L", 0, '', 0);
    $pdf->SetXY(52,$suma);$suma+=4.6;
    $pdf->Cell(102, 4,$empresa["fiscalpostal"], 0, 1,"L", 0, '', 0);    
    $pdf->SetXY(52,$suma);$suma+=4.6;
    $pdf->Cell(102, 4,$empresa["fiscalestado"].", ".$pais["nombre"], 0, 1,"L", 0, '', 0);
    $pdf->SetXY(52,$suma);$suma+=4.6;
    $pdf->Cell(102, 4,$empresa["identificador"], 0, 1,"L", 0, '', 0);    
    
    
    
    
    $aux=$suma;
    $suma+=5;
    $pdf->SetFont('courier', 'B', 12);
    $pdf->SetXY(10,$suma-1);$suma+=4.6;
    $pdf->Cell(144, 4,"Datos de Entrega", 0, 1,"L", 0, '', 0); 
    $pdf->SetFont('courier', 'B', 9);
    $pdf->SetXY(10,$suma);$suma+=4.6;
    $pdf->Cell(42, 4,"Nombre:", 0, 1,"L", 0, '', 0);      
    $pdf->SetXY(10,$suma);$suma+=4.6;
    $pdf->Cell(42, 4,"Calle:", 0, 1,"L", 0, '', 0);
    $pdf->SetXY(10,$suma);$suma+=4.6;
    $pdf->Cell(42, 4,"Numero Exterior::", 0, 1,"L", 0, '', 0);
    $pdf->SetXY(10,$suma);$suma+=4.6;
    $pdf->Cell(42, 4,"Numero Interior:", 0, 1,"L", 0, '', 0);
    $pdf->SetXY(10,$suma);$suma+=4.6;
    $pdf->Cell(42, 4,"Colonia:", 0, 1,"L", 0, '', 0);
    $pdf->SetXY(10,$suma);$suma+=4.6;
    $pdf->Cell(42, 4,"Codigo Postal:", 0, 1,"L", 0, '', 0);     
    $pdf->SetXY(10,$suma);$suma+=4.6;
    $pdf->Cell(42, 4,"Estado y País:", 0, 1,"L", 0, '', 0);
    $pdf->SetXY(10,$suma);$suma+=4.6;
    $pdf->Cell(42, 4,"Punto de Referencia:", 0, 1,"L", 0, '', 0);  
    
    
    $suma=$aux+5+4.6;
    $pdf->SetFont('courier', '', 9);
    $pdf->SetXY(52,$suma);$suma+=4.6;
    $pdf->Cell(102, 4,$empresa["nombreempresa"], 0, 1,"L", 0, '', 0);    
    $pdf->SetXY(52,$suma);$suma+=4.6;
    $pdf->Cell(102, 4,$empresa["entregacalle"], 0, 1,"L", 0, '', 0); 
    $pdf->SetXY(52,$suma);$suma+=4.6;
    $pdf->Cell(102, 4,$empresa["entregaexterior"], 0, 1,"L", 0, '', 0);  
    $pdf->SetXY(52,$suma);$suma+=4.6;
    $pdf->Cell(102, 4,$empresa["entregainterior"], 0, 1,"L", 0, '', 0); 
    $pdf->SetXY(52,$suma);$suma+=4.6;
    $pdf->Cell(102, 4,$empresa["entregacolonia"], 0, 1,"L", 0, '', 0);
    $pdf->SetXY(52,$suma);$suma+=4.6;
    $pdf->Cell(102, 4,$empresa["entregapostal"], 0, 1,"L", 0, '', 0);    
    $pdf->SetXY(52,$suma);$suma+=4.6;
    $pdf->Cell(102, 4,$empresa["entregaestado"].", ".$pais["nombre"], 0, 1,"L", 0, '', 0);
    $pdf->SetXY(52,$suma);$suma+=4.6;
    $pdf->Cell(102, 4,$empresa["entregareferencia"], 0, 1,"L", 0, '', 0);                              
    
    $pdf->SetFont('courier', '', 9);
    $pdf->Line(10, 285, 200, 285);
    $pdf->SetXY(170,287);
    $pdf->Cell(30, 4,"Página Nro. 0".$pagina, 0, 1,"R", 0, '', 0);  $pagina++;     
    
    
    $pdf->AddPage('P', 'A4');
    $pdf->Image('../imagenes/apariencia/logobugambilia.png', 10, 14, 53,14, 'PNG', 'http://www.gaagdesarrolloempresarial.com', '', true, 150, '', false, false, 0, false, false, false);    
    $pdf->SetFont('courier', 'B', 10);     
    
    $pdf->SetXY(100,10);
    $pdf->Cell(100, 4,"Orden de Compra: ".$orden["codigooc"], 0, 1,"R", 0, '', 0);
    $pdf->SetFont('courier', '', 10);
    $pdf->SetXY(100,14);
    $pdf->Cell(100, 4,"Cliente: ".$empresa["nombreempresa"], 0, 1,"R", 0, '', 0);  
    $pdf->SetXY(100,18);
    $pdf->Cell(100, 4,"Fecha de Pedido: ".$orden["fechaderegistro"], 0, 1,"R", 0, '', 0);  
    $pdf->SetXY(100,22);
    $pdf->Cell(100, 4,"Fecha de Entrega: ".$orden["fechadeentrega"], 0, 1,"R", 0, '', 0);     
    $pdf->Line(10, 29, 200, 29);      
    
                                            
    $suma=35;
    $pdf->SetFont('courier', 'B', 12);
    $pdf->SetXY(10,$suma);$suma+=2;
    $pdf->Cell(144, 4,"Productos en la Orden de Compra", 0, 1,"L", 0, '', 0);     
            
    /*Cabecera de la tabla*/
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
    
        
    /*fila de la tabla*/
    
    $sql_pro="select * from productosordencompra where idordendecompra='".$orden["idordendecompra"]."'";
    $result_pro=mysql_query($sql_pro,$con) or die(mysql_error());
    $numerproductos=mysql_num_rows($result_pro);
    $cuenta=1;
    if($numerproductos<=57){
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
    if($numerproductos>57){
        if($cuenta<57){
            while (($proorden = mysql_fetch_assoc($result_pro)) && $cuenta<57) {            
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
            $pdf->SetFont('courier', '', 9);
            $pdf->Line(10, 285, 200, 285);
            $pdf->SetXY(170,287);
            $pdf->Cell(30, 4,"Página Nro. 0".$pagina, 0, 1,"R", 0, '', 0);  $pagina++;           
            
        }
        if($cuenta>=57){
            $pdf->AddPage('P', 'A4');
            $pdf->Image('../imagenes/apariencia/logobugambilia.png', 10, 14, 53,14, 'PNG', 'http://www.gaagdesarrolloempresarial.com', '', true, 150, '', false, false, 0, false, false, false);    
            $pdf->SetFont('courier', 'B', 10); 
    
            $pdf->SetXY(100,10);
            $pdf->Cell(100, 4,"Orden de Compra: ".$orden["codigooc"], 0, 1,"R", 0, '', 0);
            $pdf->SetFont('courier', '', 10);
            $pdf->SetXY(100,14);
            $pdf->Cell(100, 4,"Cliente: ".$empresa["nombreempresa"], 0, 1,"R", 0, '', 0);  
            $pdf->SetXY(100,18);
            $pdf->Cell(100, 4,"Fecha de Pedido: ".$orden["fechaderegistro"], 0, 1,"R", 0, '', 0);  
            $pdf->SetXY(100,22);
            $pdf->Cell(100, 4,"Fecha de Entrega: ".$orden["fechadeentrega"], 0, 1,"R", 0, '', 0);     
            $pdf->Line(10, 29, 200, 29);            
            
            
            
            
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
    
         
    
    
    /*Finalizacion de la tabla*/
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
    
    
   
                       
    $pdf->SetFont('courier', '', 9);
    $pdf->Line(10, 285, 200, 285);
    $pdf->SetXY(170,287);
    $pdf->Cell(30, 4,"Página Nro. 0".$pagina, 0, 1,"R", 0, '', 0);    
    
    
    $pdf->Output('Orden de Compra.pdf', 'I');
    /*Agregado desde origen externo*/
    
    
    
?>