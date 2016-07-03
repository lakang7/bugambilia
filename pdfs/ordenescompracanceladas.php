<?php

require_once('../recursos/tcpdf/tcpdf.php');
require_once('../recursos/funciones.php');

$con = Conexion();

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Bugambilia');
$pdf->SetTitle('Reporte Ordenes de Compra Canceladas');

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
$pdf->SetXY(120,$altura);
$pdf->SetFont('courier', 'I', 10);
$pdf->Cell(80, 6, "Informe Ordenes de Compra Canceladas", 0, 1, "R", 0, '', 0);
$altura+=4.50;

$pdf->SetXY(120,$altura); 
$pdf->SetFont('courier', 'I', 10);
$pdf->Cell(80, 6, "Ordenes Canceladas a Partir del: ".$_POST["id-date-picker-1"], 0, 1, "R", 0, '', 0);
$altura+=4.50;

$pdf->SetXY(120,$altura); 
$pdf->SetFont('courier', 'I', 10);
if($_POST["empresa"]==0){
    $pdf->Cell(80, 6,"Todas las Empresas", 0, 1, "R", 0, '', 0);
}else{
    $con = Conexion();
    $sqlEmpresa="select * from empresa where idempresa='".$_POST["empresa"]."'";
    $resultEmpresa = mysql_query($sqlEmpresa, $con) or die(mysql_error());
    $empresa = mysql_fetch_assoc($resultEmpresa);
    $pdf->Cell(80, 6,"Reporte Emitido Para: ".$empresa["nombreempresa"], 0, 1, "R", 0, '', 0);
}

$altura+=7.50;

$pdf->SetFont('courier', '', 10);
$pdf->Line(10,$altura, 200, $altura);
$pdf->Line(10,280, 200,280);
$altura+=5;

$pdf->SetXY(120,280);
$pdf->Cell(80, 6, "Página 0".$pagina, 0, 1, "R", 0, '', 0);

$con = Conexion();
$sqlOrdenes="";
if($_POST["empresa"]==0){
    $sqlOrdenes="select * from ordendecompra where estatus=2 and fechaderegistro >= '".$_POST["id-date-picker-1"]."' order by fechaderegistro DESC";
}else{
    $sqlOrdenes="select * from ordendecompra where estatus=2 and fechaderegistro >= '".$_POST["id-date-picker-1"]."' and idempresa='".$_POST["empresa"]."' order by fechaderegistro DESC";
}

$resultOrdenes = mysql_query($sqlOrdenes, $con) or die(mysql_error());
$numeroElementos=  mysql_num_rows($resultOrdenes);

while ($orden = mysql_fetch_assoc($resultOrdenes)) {
    $fecha01 = explode(" ", $orden["fechaderegistro"]);
    $fecha02 = explode("-", $fecha01[0]);
    
    $sqlEmpresa="select * from empresa where idempresa='".$orden["idempresa"]."'";
    $resultEmpresa = mysql_query($sqlEmpresa, $con) or die(mysql_error());
    $empresa = mysql_fetch_assoc($resultEmpresa);
    
    $sqlAgenda="select * from agenda where idagenda='".$orden["idagenda01"]."'";
    $resultAgenda = mysql_query($sqlAgenda, $con) or die(mysql_error());
    $agenda = mysql_fetch_assoc($resultAgenda);
    
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
    $pdf->writeHTMLCell(193,4,10,$altura,"<b>Fecha de Emisión: </b>".$fecha02[2]." de ".$meses[intval($fecha02[1])]." de ".$fecha02[0]." <b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Código Orden de Compra:</b> ".$orden["codigoexterno"], 1, 0, false, true, "L");
    $pdf->SetXY(10,$altura); $altura+=4.5;
    $pdf->Line(10,$altura,10, $altura+20);
    $pdf->Line(203,$altura,203, $altura+20);
    $pdf->writeHTMLCell(193,3.5,10,$altura,"<b>Empresa: </b>".$empresa["nombreempresa"], 0, 0, false, true, "L");
    $pdf->SetXY(10,$altura); $altura+=3.5;
    $pdf->writeHTMLCell(193,3.5,10,$altura,"<b>Persona de Contacto: </b>".$agenda["nombre"]." (".$agenda["referencia"].")", 0, 0, false, true, "L");
    $pdf->SetXY(10,$altura); $altura+=3.5;
    $pdf->writeHTMLCell(193,4,10,$altura,"<b>Telefono: </b> ".$agenda["telefono1"]." / <b>Correo: </b>".$agenda["email"], 0, 0, false, true, "L");
    $x=10;
    $pdf->SetXY($x,$altura); $altura+=4.5; 
    $pdf->writeHTMLCell(48.25,4,$x,$altura,"<b>Subtotal </b>", 1, 0, false, true, "C"); $x+=48.25;
    $pdf->writeHTMLCell(48.25,4,$x,$altura,"<b>Por Iva </b>", 1, 0, false, true, "C"); $x+=48.25;
    $pdf->writeHTMLCell(48.25,4,$x,$altura,"<b>Iva </b>", 1, 0, false, true, "C"); $x+=48.25;
    $pdf->writeHTMLCell(48.25,4,$x,$altura,"<b>Total </b>", 1, 0, false, true, "C"); $x+=48.25;
    $x=10;
    $pdf->SetXY($x,$altura); $altura+=4.5; 
    $pdf->writeHTMLCell(48.25,4,$x,$altura,"$".$orden["subtotal"], 1, 0, false, true, "C"); $x+=48.25;
    $pdf->writeHTMLCell(48.25,4,$x,$altura,$orden["poriva"]."%", 1, 0, false, true, "C"); $x+=48.25;
    $pdf->writeHTMLCell(48.25,4,$x,$altura,"$".$orden["iva"], 1, 0, false, true, "C"); $x+=48.25;
    $pdf->writeHTMLCell(48.25,4,$x,$altura,"$".$orden["total"], 1, 0, false, true, "C"); $x+=48.25;
    $altura+=14.5;  
    
    if($altura>250){
        $pagina++;
        $pdf->AddPage('P', 'A4');
        $pdf->Image('../imagenes/apariencia/logobugambilia.png', 10, 14, 53, 14, 'PNG', 'http://www.gaagdesarrolloempresarial.com', '', true, 150, '', false, false, 0, false, false, false);

        $altura=16;
        $pdf->SetXY(120,$altura);
        $pdf->SetFont('courier', 'I', 10);
        $pdf->Cell(80, 6, "Informe Ordenes de Compra Canceladas", 0, 1, "R", 0, '', 0);
        $altura+=4.50;
        
        $pdf->SetXY(120,$altura); 
        $pdf->SetFont('courier', 'I', 10);
        $pdf->Cell(80, 6, "Ordenes Canceladas a Partir del: ".$_POST["id-date-picker-1"], 0, 1, "R", 0, '', 0);
        $altura+=4.50;

        $pdf->SetXY(120,$altura); 
        $pdf->SetFont('courier', 'I', 10);
        $pdf->Cell(80, 6,"Empresas en el Reporte: ", 0, 1, "R", 0, '', 0);
        $altura+=7.50;

        $pdf->SetFont('courier', '', 10);
        $pdf->Line(10,$altura, 200, $altura);
        $pdf->Line(10,280, 200,280);
        $altura+=5;

        $pdf->SetXY(120,280);
        $pdf->Cell(80, 6, "Página 0".$pagina, 0, 1, "R", 0, '', 0);        
    }    
}

$pdf->Output('Ordenes de Compra Canceladas.pdf', 'I');

?>