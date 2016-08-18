<?php

require_once('../recursos/tcpdf/tcpdf.php');
require_once('../recursos/funciones.php');

$con = Conexion();

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Bugambilia');
$pdf->SetTitle('Reporte de Regalias por Pagar');

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
$pdf->Cell(80, 6, "Informe de Regalias por Pagar", 0, 1, "R", 0, '', 0);

$pdf->SetFont('courier', '', 10);
$pdf->Line(10,$altura, 200, $altura);//$altura+=10;
$altura+=4;
$pdf->Line(10,280, 200,280);
$pdf->SetXY(120,280);
$pdf->Cell(80, 6, "Página 0".$pagina, 0, 1, "R", 0, '', 0);

$con = Conexion();

$acumulaTotal=0;
$numeroElementos=0;
$sqlOrdenes="select * from regalias where estatus=1 and resta>0 order by fechadecreacion";
$resultOrdenes = mysql_query($sqlOrdenes, $con) or die(mysql_error());
while ($orden = mysql_fetch_assoc($resultOrdenes)) {
    $sqlPagos="select * from pagoregalias where idregalias='".$orden["idregalias"]."'";
    $resultPagos = mysql_query($sqlPagos, $con) or die(mysql_error());
    $acumulaPagos=0;
    while ($abonos = mysql_fetch_assoc($resultPagos)) {
        $acumulaPagos+=$abonos["monto"];
    }
    $acumulaTotal+=($orden["monto"]-$acumulaPagos);
    if(($orden["monto"]-$acumulaPagos)>0){
        $numeroElementos++;
    }
}
$sqlOrdenes="select * from regalias where estatus=1 and resta>0 order by fechadecreacion";
$resultOrdenes = mysql_query($sqlOrdenes, $con) or die(mysql_error());


//$numeroElementos=  mysql_num_rows($resultOrdenes);

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

$pdf->writeHTMLCell(193,4,10,$altura,"<b>Número de Regalias por Pagar: </b>".$numeroElementos, 1, 0, false, true, "L");
$altura+=4.5;
$pdf->writeHTMLCell(193,4,10,$altura,"<b>Total &nbsp;de Regalias por Pagar: </b>$".$acumulaTotal, 1, 0, false, true, "L");
$altura+=4.5;
$pdf->writeHTMLCell(193,4,10,$altura,"<b>Fecha de Emisión del Reporte: </b>".$dia." de ".$meses[($mes-1)]." de ".$ano, 1, 0, false, true, "L");
$altura+=10;

while ($orden = mysql_fetch_assoc($resultOrdenes)) {
    $fecha01 = explode(" ", $orden["fechadecreacion"]);
    $fecha02 = explode("-", $fecha01[0]);
    
    $sqlEmpresa="select * from empresa where idempresa='".$orden["idempresa"]."'";
    $resultEmpresa = mysql_query($sqlEmpresa, $con) or die(mysql_error());
    $empresa = mysql_fetch_assoc($resultEmpresa);    
    
    $sqlOP="select * from ordendeproduccion where idordendeproduccion='".$orden["idordendeproduccion"]."'";
    $resultOP = mysql_query($sqlOP, $con) or die(mysql_error());    
    $OP = mysql_fetch_assoc($resultOP);
    
    $sqlPagos="select * from pagoregalias where idregalias='".$orden["idregalias"]."'";
    $resultPagos = mysql_query($sqlPagos, $con) or die(mysql_error());
    $acumulaPagos=0;
    while ($abonos = mysql_fetch_assoc($resultPagos)) {
        $acumulaPagos+=$abonos["monto"];
    }    
    
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
    if(($orden["monto"]-$acumulaPagos)>0){
    $pdf->SetXY(10,$altura);
    $pdf->writeHTMLCell(193,4,10,$altura,"<b>Fecha de Registro: </b>".$fecha02[2]." de ".$meses[intval($fecha02[1])]." de ".$fecha02[0]." <b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Código de orden:</b> ".$OP["codigoop"], 1, 0, false, true, "L");
    $pdf->SetXY(10,$altura); $altura+=4.5;
    $x=10;
    $pdf->SetXY($x,$altura); //$altura+=4.5;     
    $pdf->writeHTMLCell(64.3,4,$x,$altura,"<b>Monto </b>", 1, 0, false, true, "C"); $x+=64.3;
    $pdf->writeHTMLCell(64.3,4,$x,$altura,"<b>Anticipo </b>", 1, 0, false, true, "C"); $x+=64.3;
    $pdf->writeHTMLCell(64.3,4,$x,$altura,"<b>Resta </b>", 1, 0, false, true, "C"); $x+=64.3;
    $x=10;
    $pdf->SetXY($x,$altura); $altura+=4.5; 
    $pdf->writeHTMLCell(64.3,4,$x,$altura,"$".$orden["monto"], 1, 0, false, true, "C"); $x+=64.3;
    $pdf->writeHTMLCell(64.3,4,$x,$altura,"$".$orden["cancelado"], 1, 0, false, true, "C"); $x+=64.3;
    $pdf->writeHTMLCell(64.3,4,$x,$altura,"$".$orden["resta"], 1, 0, false, true, "C"); $x+=64.3;
    $altura+=10; 
    
    
        if($altura>270){
            $pdf->AddPage('P', 'A4');
            $pdf->Image('../imagenes/apariencia/logobugambilia.png', 10, 14, 53, 14, 'PNG', 'http://www.gaagdesarrolloempresarial.com', '', true, 150, '', false, false, 0, false, false, false);
            $pagina++;
            $altura=22;
            $pdf->SetXY(120,$altura); $altura+=7;
            $pdf->SetFont('courier', 'I', 10);
            $pdf->Cell(80, 6, "Informe de Regalias por Pagar", 0, 1, "R", 0, '', 0);

            $pdf->SetFont('courier', '', 10);
            $pdf->Line(10,$altura, 200, $altura);//$altura+=10;
            $altura+=4; 
            $pdf->Line(10,280, 200,280);
            $pdf->SetXY(120,280);
            $pdf->Cell(80, 6, "Página 0".$pagina, 0, 1, "R", 0, '', 0);        
        } 
    
    
    
    }

    
    
    
}





$pdf->Output('Regalias por Pagar.pdf', 'I');

?>