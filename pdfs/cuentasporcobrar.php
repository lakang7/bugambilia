<?php

require_once('../recursos/tcpdf/tcpdf.php');
require_once('../recursos/funciones.php');

$con = Conexion();

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Bugambilia');
$pdf->SetTitle('Reporte de Cuentas por Cobrar');

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
$pdf->Cell(80, 6, "Informe de Cuentas por Cobrar", 0, 1, "R", 0, '', 0);

$pdf->SetFont('courier', '', 10);
$pdf->Line(10,$altura, 200, $altura);//$altura+=10;
$altura+=4;
$pdf->Line(10,280, 200,280);
$pdf->SetXY(120,280);
$pdf->Cell(80, 6, "Página 0".$pagina, 0, 1, "R", 0, '', 0);

$con = Conexion();

$acumulaTotal=0;
$sqlFacturas2="select * from factura where resta>0 and estatus=1 order by emision";
$resultFacturas2 = mysql_query($sqlFacturas2, $con) or die(mysql_error());
while ($factura2 = mysql_fetch_assoc($resultFacturas2)) {
    $acumulaTotal+=$factura2["resta"];
}
$sqlFacturas="select * from factura where resta>0 and estatus=1 order by emision";
$resultFacturas = mysql_query($sqlFacturas, $con) or die(mysql_error());
$numeroElementos=  mysql_num_rows($resultFacturas);

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

$pdf->writeHTMLCell(193,4,10,$altura,"<b>Número de Cuentas por Cobrar: </b>".$numeroElementos, 1, 0, false, true, "L");
$altura+=4.5;
$pdf->writeHTMLCell(193,4,10,$altura,"<b>Total &nbsp;de Cuentas por Cobrar: </b>$".$acumulaTotal, 1, 0, false, true, "L");
$altura+=4.5;
$pdf->writeHTMLCell(193,4,10,$altura,"<b>Fecha de Emisión del Reporte: </b>".$dia." de ".$meses[($mes-1)]." de ".$ano, 1, 0, false, true, "L");
$altura+=14;

while ($factura = mysql_fetch_assoc($resultFacturas)) {
    $fecha01 = explode(" ", $factura["emision"]);
    $fecha02 = explode("-", $fecha01[0]);
    
    $sqlEmpresa="select * from empresa where idempresa='".$factura["idempresa"]."'";
    $resultEmpresa = mysql_query($sqlEmpresa, $con) or die(mysql_error());
    $empresa = mysql_fetch_assoc($resultEmpresa);
    
    $sqlAgenda="select * from agenda where idagenda='".$factura["idagenda"]."'";
    $resultAgenda = mysql_query($sqlAgenda, $con) or die(mysql_error());
    $agenda = mysql_fetch_assoc($resultAgenda);
    
    $sqlOrdenC="select * from ordendecompra where idordendecompra='".$factura["idordendecompra"]."'";
    $resultOrdenC = mysql_query($sqlOrdenC, $con) or die(mysql_error());
    $ordenC = mysql_fetch_assoc($resultOrdenC);    
    
    $meses[1]="Enero";
    $meses[2]="Febrero";
    $meses[3]="Marzo";
    $meses[4]="Abril";
    $meses[5]="Mayo";
    $meses[6]="Junio";
    $meses[7]="Julio";
    $meses[8]="Agosto";
    $meses[9]="Septiembre";
    $meses[10]="Octubre";
    $meses[11]="Noviembre";
    $meses[12]="Diciembre";    
    
    $pdf->SetXY(10,$altura);
    $pdf->writeHTMLCell(193,4,10,$altura,"<b>Fecha de Emisión: </b>".$fecha02[2]." de ".$meses[intval($fecha02[1])]." de ".$fecha02[0]." <b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Serie:</b> ".$factura["serie"]." &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b> Folio:</b> ".$factura["folio"], 1, 0, false, true, "L");
    $pdf->SetXY(10,$altura); $altura+=4.5;
    $pdf->Line(10,$altura,10, $altura+20);
    $pdf->Line(203,$altura,203, $altura+20);
    $pdf->writeHTMLCell(193,3.5,10,$altura,"<b>Orden de Producción: </b>".$ordenC["codigoop"], 0, 0, false, true, "L");
    $pdf->SetXY(10,$altura); $altura+=3.5;    
    $pdf->writeHTMLCell(193,3.5,10,$altura,"<b>Empresa: </b>".$empresa["nombreempresa"], 0, 0, false, true, "L");
    $pdf->SetXY(10,$altura); $altura+=3.5;
    $pdf->writeHTMLCell(193,3.5,10,$altura,"<b>Persona de Contacto: </b>".$agenda["nombre"]." (".$agenda["referencia"].")", 0, 0, false, true, "L");
    $pdf->SetXY(10,$altura); $altura+=3.5;
    $pdf->writeHTMLCell(193,4,10,$altura,"<b>Telefono: </b> ".$agenda["telefono1"]." / <b>Correo: </b>".$agenda["email"], 0, 0, false, true, "L");
    $x=10;
    $pdf->SetXY($x,$altura); $altura+=4.5; 
    $pdf->writeHTMLCell(38.6,4,$x,$altura,"<b>Subtotal </b>", 1, 0, false, true, "C"); $x+=38.6;
    $pdf->writeHTMLCell(38.6,4,$x,$altura,"<b>IVA </b>", 1, 0, false, true, "C"); $x+=38.6;
    $pdf->writeHTMLCell(38.6,4,$x,$altura,"<b>Total </b>", 1, 0, false, true, "C"); $x+=38.6;
    $pdf->writeHTMLCell(38.6,4,$x,$altura,"<b>Anticipado </b>", 1, 0, false, true, "C"); $x+=38.6;
    $pdf->writeHTMLCell(38.6,4,$x,$altura,"<b>Resta </b>", 1, 0, false, true, "C"); $x+=38.6;
    $x=10;
    $pdf->SetXY($x,$altura); $altura+=4.5; 
    $pdf->writeHTMLCell(38.6,4,$x,$altura,"$".$factura["subtotal"], 1, 0, false, true, "C"); $x+=38.6;
    $pdf->writeHTMLCell(38.6,4,$x,$altura,"$".$factura["iva"], 1, 0, false, true, "C"); $x+=38.6;
    $pdf->writeHTMLCell(38.6,4,$x,$altura,"$".$factura["total"], 1, 0, false, true, "C"); $x+=38.6;
    $pdf->writeHTMLCell(38.6,4,$x,$altura,"$".($factura["total"]-$factura["resta"]), 1, 0, false, true, "C"); $x+=38.6;
    $pdf->writeHTMLCell(38.6,4,$x,$altura,"$".$factura["resta"], 1, 0, false, true, "C"); $x+=38.6;
    $altura+=14.5; 
    
    if($altura>250){
        $pdf->AddPage('P', 'A4');
        $pdf->Image('../imagenes/apariencia/logobugambilia.png', 10, 14, 53, 14, 'PNG', 'http://www.gaagdesarrolloempresarial.com', '', true, 150, '', false, false, 0, false, false, false);
        $pagina++;
        $altura=22;
        $pdf->SetXY(120,$altura); $altura+=7;
        $pdf->SetFont('courier', 'I', 10);
        $pdf->Cell(80, 6, "Informe de Cuentas por Cobrar", 0, 1, "R", 0, '', 0);

        $pdf->SetFont('courier', '', 10);
        $pdf->Line(10,$altura, 200, $altura);//$altura+=10;
        $altura+=4; 
        $pdf->Line(10,280, 200,280);
        $pdf->SetXY(120,280);
        $pdf->Cell(80, 6, "Página 0".$pagina, 0, 1, "R", 0, '', 0);        
    }
    
}





$pdf->Output('Cuentas por Cobrar.pdf', 'I');

?>