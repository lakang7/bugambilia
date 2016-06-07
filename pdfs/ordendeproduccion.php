<?php
    require_once('../recursos/tcpdf/tcpdf.php');
    require_once('../recursos/funciones.php');
    
    $pagina=1;
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
    $pdf->Cell(25, 4,$ordenpro["codigoexterno"],0, 1,"L", 0, '', 0); $suma+=4;
    
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
    
    $pdf->SetFont('courier', 'B', 12);
    $pdf->SetXY(140,30);
    $pdf->Cell(60, 4,"ORDEN DE PRODUCCIÓN", 0, 1,"C", 0, '', 0);
    
    $suma=35;
    $pdf->SetFont('courier', 'B', 8);
    $pdf->SetXY(10,$suma);
    $pdf->Cell(35, 4,"Empresa", 1, 1,"L", 0, '', 0);
    $pdf->SetXY(45,$suma);
    $pdf->SetFont('courier', 'N', 8);
    $pdf->Cell(70, 4,"IMMANTI, S.A. DE C.V.", 1, 1,"L", 0, '', 0); $suma+=4;
    
    $pdf->SetFont('courier', 'B', 8);
    $pdf->SetXY(10,$suma);
    $pdf->Cell(35, 4,"Contacto", 1, 1,"L", 0, '', 0);
    $pdf->SetXY(45,$suma);
    $pdf->SetFont('courier', 'N', 8);
    $pdf->Cell(70, 4,$responsable["nombre"], 1, 1,"L", 0, '', 0); $suma+=4;  
    
    $pdf->SetFont('courier', 'B', 8);
    $pdf->SetXY(10,$suma);
    $pdf->Cell(35, 4,"Puesto", 1, 1,"L", 0, '', 0);
    $pdf->SetXY(45,$suma);
    $pdf->SetFont('courier', 'N', 8);
    $pdf->Cell(70, 4,$responsable["puesto"], 1, 1,"L", 0, '', 0); $suma+=4; 
    
    $pdf->SetFont('courier', 'B', 8);
    $pdf->SetXY(10,$suma);
    $pdf->Cell(35, 4,"Mail", 1, 1,"L", 0, '', 0);
    $pdf->SetXY(45,$suma);
    $pdf->SetFont('courier', 'N', 8);
    $pdf->Cell(70, 4,$responsable["correo"], 1, 1,"L", 0, '', 0); $suma+=4;     
   
    $pdf->SetFont('courier', 'B', 8);
    $pdf->SetXY(10,$suma);
    $pdf->Cell(35, 4,"Teléfono", 1, 1,"L", 0, '', 0);
    $pdf->SetXY(45,$suma);
    $pdf->SetFont('courier', 'N', 8);
    $pdf->Cell(70, 4,$responsable["telefono"], 1, 1,"L", 0, '', 0); $suma+=4;     
    
    $pdf->SetFont('courier', 'B', 9);
    $pdf->SetXY(10,$suma);
    $pdf->Cell(105, 5,"Datos de Facturación", 1, 1,"C", 0, '', 0); $suma+=5; 
    
    $pdf->SetFont('courier', 'B', 8);
    $pdf->SetXY(10,$suma);
    $pdf->Cell(35, 4,"Nombre", 1, 1,"L", 0, '', 0);
    $pdf->SetXY(45,$suma);
    $pdf->SetFont('courier', 'N', 8);
    $pdf->Cell(70, 4,$configuracion["facturacionempresa"], 1, 1,"L", 0, '', 0); $suma+=4; 
    
    $pdf->SetFont('courier', 'B', 8);
    $pdf->SetXY(10,$suma);
    $pdf->Cell(35, 4,"Calle", 1, 1,"L", 0, '', 0);
    $pdf->SetXY(45,$suma);
    $pdf->SetFont('courier', 'N', 8);
    $pdf->Cell(70, 4,$configuracion["facturacioncalle"], 1, 1,"L", 0, '', 0); $suma+=4;
    
    $pdf->SetFont('courier', 'B', 8);
    $pdf->SetXY(10,$suma);
    $pdf->Cell(35, 4,"Número Exterior", 1, 1,"L", 0, '', 0);
    $pdf->SetXY(45,$suma);
    $pdf->SetFont('courier', 'N', 8);
    $pdf->Cell(70, 4,$configuracion["facturacionext"], 1, 1,"L", 0, '', 0); $suma+=4;  
    
    $pdf->SetFont('courier', 'B', 8);
    $pdf->SetXY(10,$suma);
    $pdf->Cell(35, 4,"Número Interior", 1, 1,"L", 0, '', 0);
    $pdf->SetXY(45,$suma);
    $pdf->SetFont('courier', 'N', 8);
    $pdf->Cell(70, 4,$configuracion["facturacionint"], 1, 1,"L", 0, '', 0); $suma+=4;
    
    $pdf->SetFont('courier', 'B', 8);
    $pdf->SetXY(10,$suma);
    $pdf->Cell(35, 4,"Colonia", 1, 1,"L", 0, '', 0);
    $pdf->SetXY(45,$suma);
    $pdf->SetFont('courier', 'N', 8);
    $pdf->Cell(70, 4,$configuracion["facturacioncolonia"], 1, 1,"L", 0, '', 0); $suma+=4;   
    
    $pdf->SetFont('courier', 'B', 8);
    $pdf->SetXY(10,$suma);
    $pdf->Cell(35, 4,"Código Postal", 1, 1,"L", 0, '', 0);
    $pdf->SetXY(45,$suma);
    $pdf->SetFont('courier', 'N', 8);
    $pdf->Cell(70, 4,$configuracion["facturacionpostal"], 1, 1,"L", 0, '', 0); $suma+=4; 
    
    $pdf->SetFont('courier', 'B', 8);
    $pdf->SetXY(10,$suma);
    $pdf->Cell(35, 4,"Estado y País", 1, 1,"L", 0, '', 0);
    $pdf->SetXY(45,$suma);
    $pdf->SetFont('courier', 'N', 8);
    $pdf->Cell(70, 4,$configuracion["facturacionestpais"], 1, 1,"L", 0, '', 0); $suma+=4; 
    
    $pdf->SetFont('courier', 'B', 8);
    $pdf->SetXY(10,$suma);
    $pdf->Cell(35, 4,"RFC", 1, 1,"L", 0, '', 0);
    $pdf->SetXY(45,$suma);
    $pdf->SetFont('courier', 'N', 8);
    $pdf->Cell(70, 4,$configuracion["facturacionrfc"], 1, 1,"L", 0, '', 0); $suma+=4; 
    
    
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
    
    $sql_pro="select * from productosordenproduccion where idordendeproduccion='".$_GET["id"]."'";
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
            $pdf->Cell(14, 4,"$".$proorden["preciofabrica"], 1, 1,"C", 0, '', 0); 
            $pdf->SetXY(186,$suma);
            $pdf->Cell(17, 4,"$".($proorden["preciofabrica"]*$proorden["numerodeunidades"]), 1, 1,"R", 0, '', 0);
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
                $pdf->Cell(14, 4,"$".$proorden["preciofabrica"], 1, 1,"C", 0, '', 0); 
                $pdf->SetXY(186,$suma);
                $pdf->Cell(17, 4,"$".($proorden["preciofabrica"]*$proorden["numerodeunidades"]), 1, 1,"R", 0, '', 0);
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
            $pdf->Cell(25, 4,$ordenpro["codigoexterno"],0, 1,"L", 0, '', 0); $suma+=4;
    
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
                $pdf->Cell(14, 4,"$".$proorden["preciofabrica"], 1, 1,"C", 0, '', 0); 
                $pdf->SetXY(186,$suma);
                $pdf->Cell(17, 4,"$".($proorden["preciofabrica"]*$proorden["numerodeunidades"]), 1, 1,"R", 0, '', 0);
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
        
    
    /*------------------------------------------------------------------------*/
    $suma+=10;
    $observaciones="";
    if($orden["tipoempaque"]==1){
        $observaciones="Empaque Normal";
    }else if($orden["tipoempaque"]==2){
        $observaciones="Empaque Separado";
    }
    
    $pdf->SetFont('courier', 'B', 8);
    $pdf->SetXY(10,$suma);
    $pdf->Cell(193, 4,"Observaciones", 1, 1,"C", 0, '', 0); $suma+=4; 
    
    $pdf->SetFont('courier', 'N', 8);
    $pdf->MultiCell(193, 4,$observaciones, 1, "L", 0, 0, 10, $suma, true); 
    
    
    
    
    
    
    $pdf->Output('Orden de Compra.pdf', 'I');    
    
    
    
?>