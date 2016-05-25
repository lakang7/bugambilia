<?php

require_once('../recursos/tcpdf/tcpdf.php');
require_once('../recursos/funciones.php');

$pagina = 1;
$con = Conexion();
$sql_empresa = "select em.nombreempresa NOMEMP,em.nombrecomercial NCOMER,em.codigo CODEMP,em.identificador IDEMP,em.telefonoprincipal TELP,em.fiscalcalle FCALLE,
em.fiscalexterior FEXT, em.fiscalinterior FINT, em.fiscalpostal FPOST,em.fiscalcolonia FCOL, em.fiscalciudad FCIUD,
em.fiscalestado FEST,pa.nombre NOMPAIS,em.entregacalle ECALLE, em.entregaexterior EEXT,em.entregainterior EINT,em.entregapostal EPOST,
em.entregacolonia ECOL,em.entregaciudad ECIUD,em.entregaestado EEST, em.entregareferencia EREF
from empresa em join pais pa on em.idpais=pa.idpais
where em.idempresa='" . $_GET["id"] . "'";
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

//Informe Empresa
$pdf->SetXY(160, 18);
$pdf->SetFont('courier', 'I', 12);
$pdf->Cell(40, 10, "Informe Empresa", 0, 1, "L", 0, '', 0);


$pdf->SetFont('courier', 'B', 10);
$pdf->Line(10, 29, 200, 29);

$suma = 30;
$pdf->SetXY(10, $suma);
$pdf->SetFont('courier', 'B', 13);
$pdf->Cell(105, 10, $empresa["NOMEMP"], 0, 1, "L", 0, '', 0);

$pdf->SetXY(10, $suma+=8);
$pdf->SetFont('courier', 'N', 10);
$pdf->Cell(105, 5, $empresa["CODEMP"] . " - " . $empresa["NCOMER"], 0, 1, "L", 0, '', 0);


$pdf->SetXY(10, $suma+=4);
$pdf->SetFont('courier', 'N', 10);
$pdf->Cell(105, 5, "RFC: " . $empresa["IDEMP"], 0, 1, "L", 0, '', 0);

$pdf->SetXY(10, $suma+=4);
$pdf->SetFont('courier', 'N', 10);
$pdf->Cell(105, 5, "Telefono: " . $empresa["TELP"], 0, 1, "L", 0, '', 0);

$pdf->SetXY(10, $suma+=8);
$pdf->SetFont('courier', 'B', 10);
$pdf->Cell(105, 5, "Direccion Fiscal:", 0, 1, "L", 0, '', 0);
$pdf->SetXY(10, $suma+=5);
$pdf->SetFont('courier', 'N', 10);
$pdf->Cell(105, 5, "Calle " . $empresa["FCALLE"] . " Nro Exterior " . $empresa["FEXT"] . " Nro Interior " . $empresa["FINT"] . " Codigo Postal " . $empresa["FPOST"], 0, 1, "L", 0, '', 0);
$pdf->SetXY(10, $suma+=4);
$pdf->Cell(105, 5, "Colonia " . $empresa["FCOL"] . ", " . $empresa["FCIUD"] . ", " . $empresa["FEST"] . ", " . $empresa["NOMPAIS"], 0, 1, "L", 0, '', 0);


$pdf->SetXY(10, $suma+=7);
$pdf->SetFont('courier', 'B', 10);
$pdf->Cell(105, 5, "Direccion Entrega:", 0, 1, "L", 0, '', 0);
$pdf->SetXY(10, $suma+=5);
$pdf->SetFont('courier', 'N', 10);
$pdf->Cell(105, 5, "Calle " . $empresa["ECALLE"] . " Nro Exterior " . $empresa["EEXT"] . " Nro Interior " . $empresa["EINT"] . " Codigo Postal " . $empresa["EPOST"], 0, 1, "L", 0, '', 0);
$pdf->SetXY(10, $suma+=4);
$pdf->Cell(105, 5, "Colonia " . $empresa["ECOL"] . ", " . $empresa["ECIUD"] . ", " . $empresa["EEST"] . ", " . $empresa["NOMPAIS"], 0, 1, "L", 0, '', 0);

$pdf->SetFont('courier', 'N', 10);
$pdf->SetXY(10, $suma+=4);
if (strlen($empresa["EREF"]) < 70) {
    $pdf->Cell(175, 5, "Punto de Referencia " . $empresa["EREF"] , 0, 1, "L", 0, '', 0);
} else {
    $espacios = substr_count($empresa["EREF"],' ');
    $salida = explode(' ', $empresa["EREF"]);
    $linea1 = "";
    $linea2 = "";;
    for ($index = 0; $index < 9; $index++) {
        $linea1=$linea1." ".$salida[$index] . " ";
    }
    for ($index = 9; $index <= $espacios; $index++) {
        $linea2=$linea2." ".$salida[$index] . " ";
    }
    $pdf->Cell(175, 5, "Punto de Referencia " . $linea1, 0, 1, "L", 0, '', 0);
    $pdf->SetXY(10, $suma+=4);
    $pdf->Cell(175, 5, substr($linea2,1), 0, 1, "L", 0, '', 0);
    
}
$suma+=8;
$pdf->SetFont('courier', '', 9);
$pdf->Line(10, $suma, 200, $suma);
/* * *****SUCURSALES**** */
$pdf->SetXY(10, $suma+=8);
$pdf->SetFont('courier', 'B', 11);
$pdf->Cell(105, 4, "Sucursales", 0, 1, "L", 0, '', 0);
$suma+=2;

$sql_sucursal = "select nombrecomercial,regiones from sucursal where idempresa='" . $_GET["id"] . "'";
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

    $pdf->SetXY(10, $suma+=4);
    $pdf->SetFont('courier', 'N', 10);
    $pdf->Cell(10, 4, "Regiones ".$sucursales["regiones"], 0, 1, "L", 0, '', 0);
    $suma++;
}

/* * *****CONTACTOS**** */
$pdf->SetXY(10, $suma+=10);
$pdf->SetFont('courier', 'B', 11);
$pdf->Cell(105, 4, "Contactos", 0, 1, "L", 0, '', 0);

$suma++;

$sql_contacto = "select age.nombre NOMBREAGENDA,age.referencia AGENDAREFERENCIA,age.email AGENDAEMAIL,
age.telefono1 AGENDATELEFONO1,age.telefono2 AGENDATELEFONO2 
from agenda age join asociacionagenda asa on age.idagenda=asa.idagenda 
join empresa em on asa.idempresa=em.idempresa
where em.idempresa='" . $_GET["id"] . "'";
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
