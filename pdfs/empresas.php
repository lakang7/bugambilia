<?php

require_once('../recursos/tcpdf/tcpdf.php');
require_once('../recursos/funciones.php');

$pagina = 1;
$con = Conexion();
$sql_empresa = "select * from empresa join pais on empresa.idpais=pais.idpais  where idempresa=2";
$result_empresa = mysql_query($sql_empresa, $con) or die(mysql_error());
if (mysql_num_rows($result_empresa) > 0) {
    $empresa = mysql_fetch_assoc($result_empresa);
}


$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Bugambilia');
$pdf->SetTitle('Reporte de Empresa ');

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
$pdf->Image('../imagenes/apariencia/logobugambilia.png', 10, 14, 53, 14, 'PNG', 'http://www.gaagdesarrolloempresarial.com', '', true, 150, '', false, false, 0, false, false, false);
$pdf->SetFont('courier', 'B', 10);
$pdf->Line(10, 29, 200, 29);

$suma = 30;
$pdf->SetXY(10, $suma);
$pdf->SetFont('courier', 'B', 13);
$pdf->Cell(105, 10, $empresa["nombreempresa"], 0, 1, "L", 0, '', 0);

$pdf->SetXY(10, $suma+=10);
$pdf->SetFont('courier', 'N', 10);
$pdf->Cell(105, 5, $empresa["codigo"] . " - " . $empresa["nombrecomercial"], 0, 1, "L", 0, '', 0);


$pdf->SetXY(10, $suma+=3);
$pdf->SetFont('courier', 'N', 10);
$pdf->Cell(105, 5, "Identificador: " . $empresa["identificador"], 0, 1, "L", 0, '', 0);

$pdf->SetXY(10, $suma+=3);
$pdf->SetFont('courier', 'N', 10);
$pdf->Cell(105, 5, "Telefono: " . $empresa["telefonoprincipal"], 0, 1, "L", 0, '', 0);

$pdf->SetXY(10, $suma+=3);
$pdf->SetFont('courier', 'N', 10);
$pdf->Cell(105, 5, "Direccion Fiscal:", 0, 1, "L", 0, '', 0);
$pdf->SetXY(10, $suma+=3);
$pdf->SetFont('courier', 'N', 10);
$pdf->Cell(105, 5, $empresa["fiscalcalle"] . " " . $empresa["fiscalexterior"] . " " . $empresa["fiscalinterior"] . " " . $empresa["fiscalpostal"], 0, 1, "L", 0, '', 0);
$pdf->SetXY(10, $suma+=3);
$pdf->Cell(105, 5, $empresa["fiscalcolonia"] . ", " . $empresa["fiscalciudad"] . ", " . $empresa["fiscalestado"] . ", " . $empresa["nombre"], 0, 1, "L", 0, '', 0);


$pdf->SetXY(10, $suma+=4);
$pdf->SetFont('courier', 'N', 10);
$pdf->Cell(105, 5, "Direccion Entrega:", 0, 1, "L", 0, '', 0);
$pdf->SetXY(10, $suma+=3);
$pdf->SetFont('courier', 'N', 10);
$pdf->Cell(105, 5, $empresa["entregacalle"] . " " . $empresa["entregaexterior"] . " " . $empresa["entregainterior"] . " " . $empresa["entregapostal"], 0, 1, "L", 0, '', 0);
$pdf->SetXY(10, $suma+=3);
$pdf->Cell(105, 5, $empresa["entregacolonia"] . ", " . $empresa["entregaciudad"] . ", " . $empresa["entregaestado"] . ", " . $empresa["nombre"], 0, 1, "L", 0, '', 0);


$pdf->SetFont('courier', '', 9);
$pdf->Line(10, 72, 200, 72);
/* * *****SUCURSALES**** */
$pdf->SetXY(10, $suma+=12);
$pdf->SetFont('courier', 'B', 11);
$pdf->Cell(105, 4, "Sucursales", 0, 1, "L", 0, '', 0);

$sql_sucursal = "select nombrecomercial,regiones from sucursal where idempresa='" . $empresa["idempresa"] . "'";
$result_sucursal = mysql_query($sql_sucursal, $con) or die(mysql_error());
$numersucursales = mysql_num_rows($result_sucursal);
$cuenta = 1;

$bool = 0;
while ($sucursales = mysql_fetch_assoc($result_sucursal)) {
    if ($suma > 250 && $bool == 0) {
        $bool = 1;
        $pdf->AddPage('P', 'A4');
        $pdf->Image('../imagenes/apariencia/logobugambilia.png', 10, 14, 53, 14, 'PNG', 'http://www.gaagdesarrolloempresarial.com', '', true, 150, '', false, false, 0, false, false, false);
        $pdf->SetFont('courier', 'B', 10);
        $suma = 30;
    }
    $pdf->SetXY(10, $suma+=4);
    $pdf->SetFont('courier', 'N', 10);
    $pdf->Cell(10, 4, $sucursales["nombrecomercial"], 0, 1, "L", 0, '', 0);

    $pdf->SetXY(10, $suma+=3);
    $pdf->SetFont('courier', 'N', 10);
    $pdf->Cell(10, 4, $sucursales["regiones"], 0, 1, "L", 0, '', 0);
    $suma++;
}

/* * *****CONTACTOS**** */
$pdf->SetXY(10, $suma+=10);
$pdf->SetFont('courier', 'B', 11);
$pdf->Cell(105, 4, "Contactos", 0, 1, "L", 0, '', 0);

//suma may>250

$sql_contacto = "select age.nombre NOMBREAGENDA,age.referencia AGENDAREFERENCIA,age.email AGENDAEMAIL,age.telefono1 AGENDATELEFONO1,age.telefono2 AGENDATELEFONO2 from agenda age join asociacionagenda asa on age.idagenda=asa.idagenda join sucursal suc on suc.idsucursal=asa.idsucursal  where suc.idempresa='" . $empresa["idempresa"] . "' order by suc.idsucursal";
$result_contacto = mysql_query($sql_contacto, $con) or die(mysql_error());
$numersucursales = mysql_num_rows($result_contacto);
$cuenta = 1;
$bool = 0;
while ($contactos = mysql_fetch_assoc($result_contacto)) {
    if ($suma > 250 && $bool == 0) {
        $bool = 1;
        $pdf->AddPage('P', 'A4');
        $pdf->Image('../imagenes/apariencia/logobugambilia.png', 10, 14, 53, 14, 'PNG', 'http://www.gaagdesarrolloempresarial.com', '', true, 150, '', false, false, 0, false, false, false);
        $pdf->SetFont('courier', 'B', 10);
        $suma = 30;
    }
    $pdf->SetXY(10, $suma+=5);
    $pdf->SetFont('courier', 'N', 10);
    $pdf->Cell(10, 4, $contactos["NOMBREAGENDA"], 0, 1, "L", 0, '', 0);

    $pdf->SetXY(10, $suma+=4);
    $pdf->SetFont('courier', 'N', 10);
    $pdf->Cell(10, 4, $contactos["AGENDAREFERENCIA"], 0, 1, "L", 0, '', 0);

    $pdf->SetXY(10, $suma+=4);
    $pdf->SetFont('courier', 'N', 10);
    $pdf->Cell(10, 4, $contactos["AGENDAEMAIL"], 0, 1, "L", 0, '', 0);

    $pdf->SetXY(10, $suma+=4);
    $pdf->SetFont('courier', 'N', 10);
    $pdf->Cell(10, 4, $contactos["AGENDATELEFONO1"], 0, 1, "L", 0, '', 0);
    if ($contactos["AGENDATELEFONO2"] != "") {
        $pdf->SetXY(40, $suma);
        $pdf->SetFont('courier', 'N', 10);
        $pdf->Cell(10, 4, "/ " . $contactos["AGENDATELEFONO2"], 0, 1, "L", 0, '', 0);
    }
    $suma++;
}



$pdf->Output('Listado Empresas.pdf', 'I');
/* Agregado desde origen externo */
?>
