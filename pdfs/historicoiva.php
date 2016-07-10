<?php

require_once('../recursos/tcpdf/tcpdf.php');
require_once('../recursos/funciones.php');

$con = Conexion();

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Bugambilia');
$pdf->SetTitle('Reporte Historico de Iva');

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

$altura=16;
$pdf->SetXY(120,$altura); $altura+=4;
$pdf->SetFont('courier', 'I', 10);
$pdf->Cell(80, 6, "Informe Historico de Iva", 0, 1, "R", 0, '', 0);
//$altura+=4;

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

$pdf->SetXY(120,$altura);
$pdf->Cell(80, 6, "Emitido el: ".$dia." de ".$meses[($mes-1)]." de ".$ano, 0, 1, "R", 0, '', 0);
$altura+=10;
$pdf->SetFont('courier', '', 10);
$pdf->Line(10,$altura, 200, $altura);//$altura+=10;
$altura+=4;
$pdf->Line(10,280, 200,280);
$pdf->SetXY(120,280);
$pdf->Cell(80, 6, "Página 0".$pagina, 0, 1, "R", 0, '', 0);

$con = Conexion();

$altura+=5;
$pdf->SetXY(13,$altura);
$pdf->Cell(60, 4,"Porcentaje de Iva", 1, 1, "C", 0, '', 0);
$pdf->SetXY(73,$altura);
$pdf->Cell(60, 4,"Valor Valido Desde", 1, 1, "C", 0, '', 0);
$pdf->SetXY(133,$altura);
$pdf->Cell(60, 4,"Valor Valido Hasta", 1, 1, "C", 0, '', 0);

$acumulaTotal=0;
$sqlHistorico="select * from historicoporiva order by idhistoricoporiva";
$resultHistorico = mysql_query($sqlHistorico, $con) or die(mysql_error());
while ($historico = mysql_fetch_assoc($resultHistorico)) {
   
    
    $altura+=4.5;
    $pdf->SetXY(13,$altura);
    $pdf->Cell(60, 4,round($historico["porcentajeiva"],0)."% ", 1, 1, "C", 0, '', 0);
    $pdf->SetXY(73,$altura);
    $pdf->Cell(60, 4,$historico["desde"], 1, 1, "C", 0, '', 0);
    $pdf->SetXY(133,$altura);
    $pdf->Cell(60, 4,$historico["hasta"], 1, 1, "C", 0, '', 0); 
    if($altura>250){
        $pagina++;
        $pdf->AddPage('P', 'A4');
        $pdf->Image('../imagenes/apariencia/logobugambilia.png', 10, 14, 53, 14, 'PNG', 'http://www.gaagdesarrolloempresarial.com', '', true, 150, '', false, false, 0, false, false, false);

        $altura=16;
        $pdf->SetXY(120,$altura); $altura+=4;
        $pdf->SetFont('courier', 'I', 10);
        $pdf->Cell(80, 6, "Informe Historico de Iva", 0, 1, "R", 0, '', 0); 
        $pdf->SetXY(120,$altura);
        $pdf->Cell(80, 6, "Emitido el: ".$dia." de ".$meses[($mes-1)]." de ".$ano, 0, 1, "R", 0, '', 0);
        $altura+=10;
        $pdf->SetFont('courier', '', 10);
        $pdf->Line(10,$altura, 200, $altura);//$altura+=10;
        $altura+=4;
        $pdf->Line(10,280, 200,280);
        $pdf->SetXY(120,280);
        $pdf->Cell(80, 6, "Página 0".$pagina, 0, 1, "R", 0, '', 0);        
    }    
    
}  

$pdf->Output('Historico porcentaje de Iva.pdf', 'I');

?>