<?php

require_once('../recursos/tcpdf/tcpdf.php');
require_once('../recursos/funciones.php');

$con = Conexion();

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Bugambilia');
$pdf->SetTitle('Reporte Detallado de Ventas Por Empresa y Sucursal');

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

$pagina=1;
$pdf->AddPage('P', 'A4');
$pdf->Image('../imagenes/apariencia/logobugambilia.png', 10, 14, 53, 14, 'PNG', 'http://www.gaagdesarrolloempresarial.com', '', true, 150, '', false, false, 0, false, false, false);

$altura=22;
$pdf->SetXY(120,$altura); $altura+=7;
$pdf->SetFont('courier', 'I', 10);
$pdf->Cell(80, 6, "Informe de Ventas Detallado Por Empresas y Sucursales", 0, 1, "R", 0, '', 0);

$pdf->SetFont('courier', '', 10);
$pdf->Line(10,$altura, 200, $altura);//$altura+=10;
$altura+=4;
$pdf->Line(10,280, 200,280);
$pdf->SetXY(120,280);
$pdf->Cell(80, 6, "Página 0".$pagina, 0, 1, "R", 0, '', 0);

$con = Conexion();

$acumulaTotal=0;
$sqlVentas="select * from ordendecompra where estatus=1 and conpago=1 and fechaderegistro>='".$_POST["id-date-picker-1"]."' and fechaderegistro<='".$_POST["id-date-picker-2"]."' ";
$resultVentas = mysql_query($sqlVentas, $con) or die(mysql_error());
$numeroElementos=  mysql_num_rows($resultVentas);
while ($venta = mysql_fetch_assoc($resultVentas)) {
    $acumulaTotal+=$venta["total"];
}
    


$meses=array();
    
$meses[0]="Enero";
$meses[1]="Febrero";
$meses[2]="Marzo";
$meses[3]="Abril";
$meses[4]="Mayo";
$meses[5]="Junio";
$meses[6]="Julio";
$meses[7]="Agosto";
$meses[8]="Septiembre";
$meses[9]="Octubre";
$meses[10]="Noviembre";
$meses[11]="Diciembre";
$dia=date("d");
$mes=date("m");
$ano=date("Y");    

$date01 = new DateTime($_POST["id-date-picker-1"]);
$date02 = new DateTime($_POST["id-date-picker-2"]);
$pdf->writeHTMLCell(190,4,10,$altura,"<b>Reporte Emitido desde: </b>".$date01->format('d-m-Y'), 1, 0, false, true, "L");
$altura+=4.5;
$pdf->writeHTMLCell(190,4,10,$altura,"<b>Reporte Emitido hasta: </b>".$date02->format('d-m-Y'), 1, 0, false, true, "L");
$altura+=4.5;
$pdf->writeHTMLCell(190,4,10,$altura,"<b>Total de Ventas en el perido: </b>".$numeroElementos, 1, 0, false, true, "L");
$altura+=4.5;
$pdf->writeHTMLCell(190,4,10,$altura,"<b>Monto de Ventas en el perido: </b>$".$acumulaTotal, 1, 0, false, true, "L");
$altura+=9.5;

$sqlEMPRESAS="select * from empresa order by nombreempresa";
$resultEMPRESAS = mysql_query($sqlEMPRESAS, $con) or die(mysql_error());
while ($EMP = mysql_fetch_assoc($resultEMPRESAS)) {
    $sqlVentasEMP="select * from ordendecompra where estatus=1 and conpago=1 and fechaderegistro>='".$_POST["id-date-picker-1"]."' and fechaderegistro<='".$_POST["id-date-picker-2"]."' and idempresa='".$EMP["idempresa"]."' order by fechaderegistro ";
    $resultVentasEMP = mysql_query($sqlVentasEMP, $con) or die(mysql_error());
    $numeroElementosEMP=  mysql_num_rows($resultVentasEMP);
    
    if($numeroElementosEMP>0){ /*Imprimo el nombre de la empresa*/
        $sql_SucursalesEmpresa="select * from sucursal where idempresa='".$EMP["idempresa"]."'";
        $result_SucursalesEmpresa= mysql_query($sql_SucursalesEmpresa, $con) or die(mysql_error());
        
                if($altura>260){
                    $pdf->AddPage('P', 'A4');
                    $pdf->Image('../imagenes/apariencia/logobugambilia.png', 10, 14, 53, 14, 'PNG', 'http://www.gaagdesarrolloempresarial.com', '', true, 150, '', false, false, 0, false, false, false);
                    $pagina++;
                    $altura=22;
                    $pdf->SetXY(120,$altura); $altura+=7;
                    $pdf->SetFont('courier', 'I', 10);
                    $pdf->Cell(80, 6, "Informe de Ventas Detallado Por Empresas y Sucursales", 0, 1, "R", 0, '', 0);

                    $pdf->SetFont('courier', '', 10);
                    $pdf->Line(10,$altura, 200, $altura);//$altura+=10;
                    $altura+=4; 
                    $pdf->Line(10,280, 200,280);
                    $pdf->SetXY(120,280);
                    $pdf->Cell(80, 6, "Página 0".$pagina, 0, 1, "R", 0, '', 0);        
                }        
        
        $pdf->SetFont('courier', 'B', 11);
        $pdf->SetXY(10,$altura);
        $pdf->Cell(100, 4,$EMP["nombreempresa"], 0, 1, "L", 0, '', 0);        
        $altura+=6;        
        
        while ($SUC = mysql_fetch_assoc($result_SucursalesEmpresa)) {
            $sqlVentasSUC="select * from ordendecompra where estatus=1 and conpago=1 and fechaderegistro>='".$_POST["id-date-picker-1"]."' and fechaderegistro<='".$_POST["id-date-picker-2"]."' and idempresa='".$EMP["idempresa"]."' and idsucursal='".$SUC["idsucursal"]."' order by fechaderegistro ";
            $resultVentasSUC = mysql_query($sqlVentasSUC, $con) or die(mysql_error());
            $numeroElementosSUC=  mysql_num_rows($resultVentasSUC);            
            
            if($numeroElementosSUC>0){ /*Imprimo el nombre de las sucursales*/
                
                $pdf->SetFont('courier', '', 10);
                $pdf->SetXY(10,$altura);
                $pdf->Cell(100, 4,$SUC["nombrecomercial"], 0, 1, "L", 0, '', 0);        
                $altura+=6; 
                
                if($altura>260){
                    $pdf->AddPage('P', 'A4');
                    $pdf->Image('../imagenes/apariencia/logobugambilia.png', 10, 14, 53, 14, 'PNG', 'http://www.gaagdesarrolloempresarial.com', '', true, 150, '', false, false, 0, false, false, false);
                    $pagina++;
                    $altura=22;
                    $pdf->SetXY(120,$altura); $altura+=7;
                    $pdf->SetFont('courier', 'I', 10);
                    $pdf->Cell(80, 6, "Informe de Ventas Detallado Por Empresas y Sucursales", 0, 1, "R", 0, '', 0);

                    $pdf->SetFont('courier', '', 10);
                    $pdf->Line(10,$altura, 200, $altura);//$altura+=10;
                    $altura+=4; 
                    $pdf->Line(10,280, 200,280);
                    $pdf->SetXY(120,280);
                    $pdf->Cell(80, 6, "Página 0".$pagina, 0, 1, "R", 0, '', 0);        
                }                
                
                $pdf->SetFont('courier', 'B', 10);
                $pdf->SetXY(10,$altura);
                $pdf->Cell(25, 4,"Fecha", 1, 1, "C", 0, '', 0);
                $pdf->SetXY(35,$altura);
                $pdf->Cell(25, 4,"O.Compra", 1, 1, "C", 0, '', 0);
                $pdf->SetXY(60,$altura);
                $pdf->Cell(28, 4,"O.Produccion", 1, 1, "C", 0, '', 0);
                $pdf->SetXY(88,$altura);
                $pdf->Cell(30, 4,"Factura", 1, 1, "C", 0, '', 0);
                $pdf->SetXY(118,$altura);
                $pdf->Cell(60, 4,"Empresa", 1, 1, "C", 0, '', 0);
                $pdf->SetXY(178,$altura);
                $pdf->Cell(22, 4,"Monto", 1, 1, "C", 0, '', 0);
                $pdf->SetFont('courier', '', 9);                
                //$altura+=4.5;
                
                $acumulaEmpresa=0;
                while ($venta = mysql_fetch_assoc($resultVentasSUC)) {
                    
                if($altura>260){
                    $pdf->AddPage('P', 'A4');
                    $pdf->Image('../imagenes/apariencia/logobugambilia.png', 10, 14, 53, 14, 'PNG', 'http://www.gaagdesarrolloempresarial.com', '', true, 150, '', false, false, 0, false, false, false);
                    $pagina++;
                    $altura=22;
                    $pdf->SetXY(120,$altura); $altura+=7;
                    $pdf->SetFont('courier', 'I', 10);
                    $pdf->Cell(80, 6, "Informe de Ventas Detallado Por Empresas y Sucursales", 0, 1, "R", 0, '', 0);

                    $pdf->SetFont('courier', '', 10);
                    $pdf->Line(10,$altura, 200, $altura);//$altura+=10;
                    $altura+=4; 
                    $pdf->Line(10,280, 200,280);
                    $pdf->SetXY(120,280);
                    $pdf->Cell(80, 6, "Página 0".$pagina, 0, 1, "R", 0, '', 0);        
                }                               
                    $sqlEmpresa="select * from empresa where idempresa='".$venta["idempresa"]."'";
                    $resultEmpresa = mysql_query($sqlEmpresa, $con) or die(mysql_error());
                    $empresa = mysql_fetch_assoc($resultEmpresa);
                    $sqlFactura="select * from factura where idordendecompra='".$venta["idordendecompra"]."' and estatus=1";
                    $resultFactura = mysql_query($sqlFactura, $con) or die(mysql_error());
        
                    $altura+=4.5;
                    $pdf->SetXY(10,$altura);
                    $date = new DateTime($venta["fechaderegistro"]);
                    $pdf->Cell(25, 4,$date->format('d-m-Y'), 1, 1, "C", 0, '', 0);
                    $pdf->SetXY(35,$altura);
                    $pdf->Cell(25, 4,$venta["codigoexterno"], 1, 1, "C", 0, '', 0);
                    $pdf->SetXY(60,$altura);
                    $pdf->Cell(28, 4,$venta["codigoop"], 1, 1, "C", 0, '', 0);
                    $pdf->SetXY(88,$altura);    
    
                    if(mysql_num_rows($resultFactura)>0){
                        $factura = mysql_fetch_assoc($resultFactura);
                        $pdf->Cell(30, 4,$factura["serie"]."-".$factura["folio"], 1, 1, "C", 0, '', 0);
                    }else{
                        $pdf->Cell(30, 4,"Sin Emitir", 1, 1, "C", 0, '', 0);
                    }            
                    $pdf->SetXY(118,$altura);
                    $pdf->Cell(60, 4,$empresa["nombreempresa"], 1, 1, "L", 0, '', 0);
                    $pdf->SetXY(178,$altura);
                    $pdf->Cell(22, 4,"$".$venta["total"], 1, 1, "R", 0, '', 0);
                    $acumulaEmpresa+=$venta["total"];
                }
        $altura+=4.5;
        if($altura>260){
            $pdf->AddPage('P', 'A4');
            $pdf->Image('../imagenes/apariencia/logobugambilia.png', 10, 14, 53, 14, 'PNG', 'http://www.gaagdesarrolloempresarial.com', '', true, 150, '', false, false, 0, false, false, false);
            $pagina++;
            $altura=22;
            $pdf->SetXY(120,$altura); $altura+=7;
            $pdf->SetFont('courier', 'I', 10);
            $pdf->Cell(80, 6, "Informe de Ventas Detallado Por Empresas y Sucursales", 0, 1, "R", 0, '', 0);

            $pdf->SetFont('courier', '', 10);
            $pdf->Line(10,$altura, 200, $altura);//$altura+=10;
            $altura+=4; 
            $pdf->Line(10,280, 200,280);
            $pdf->SetXY(120,280);
            $pdf->Cell(80, 6, "Página 0".$pagina, 0, 1, "R", 0, '', 0);        
        }           
        
        $pdf->SetXY(178,$altura);
        $pdf->Cell(22, 4,"$".$acumulaEmpresa, 1, 1, "R", 0, '', 0);
        $altura+=6;                
               
            }
        }
    }
    
    $altura+=4;
}

$pdf->Output('Reporte de Ventas por Empresas y Sucursales.pdf', 'I');

?>