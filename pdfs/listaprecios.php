<?php

require_once("../recursos/funciones.php");
require_once('../recursos/tcpdf/tcpdf.php');
$con = Conexion();
$pagina = 1;
$con = Conexion();

/* * *****CABECERA DEL PDF*************** */

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Bugambilia');
$pdf->SetTitle('Reporte de Patron Producto'); //revisar titulo 
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
/* * *************FIN CABECERA PDF*********************** */

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


$altura=18;
$pdf->SetXY(120,$altura); $altura+=5;
$pdf->SetFont('courier', 'I', 10);
$pdf->Cell(80, 6, "Lista de Precios", 0, 1, "R", 0, '', 0);

$pdf->SetXY(120,$altura); 
$pdf->SetFont('courier', 'I', 10);
$pdf->Cell(80, 6, "Emitida el ".$dia." de ".$meses[($mes-1)]." de ".$ano, 0, 1, "R", 0, '', 0);




$colum = 10;
$suma = 35;

$con = Conexion();
$sql_LISTA = "select * from listadeprecios where idlistadeprecios='" . $_GET["id"] . "'";
$result_LISTA = mysql_query($sql_LISTA, $con) or die(mysql_error());
if (mysql_num_rows($result_LISTA) > 0) {
    $lista = mysql_fetch_assoc($result_LISTA);
    /*$sqlEMPRESA = "select * from empresa where idempresa='" . $lista["idempresa"] . "'";
    $resultEMPRESA = mysql_query($sqlEMPRESA, $con) or die(mysql_error());
    if (mysql_num_rows($resultEMPRESA) > 0) {
        $empresa = mysql_fetch_assoc($resultEMPRESA);
    }*/
}

$sqlConfiguracion = "select * from configuracionsistema where idconfiguracionsistema=1";
$result_Configuracion = mysql_query($sqlConfiguracion, $con) or die(mysql_error());
if (mysql_num_rows($result_Configuracion) > 0) {
    $configuracion = mysql_fetch_assoc($result_Configuracion);
}

$pdf->SetXY($colum, $suma);
$pdf->SetFont('courier', 'B', 14);
$pdf->Cell(62, 8, $lista["nombre"] , 0, 1, "L", 0, '', 0);



$sql_cattipo = "select * from categoriatipo order by idcategoriatipo";
$result_cattipo = mysql_query($sql_cattipo, $con) or die(mysql_error());
if (mysql_num_rows($result_cattipo) > 0) {
    $bool = 0;
    while ($cattipo = mysql_fetch_assoc($result_cattipo)) {

        $cuenta = 0;
        $sql_tipopro = "select * from tipoproducto where idcategoriatipo='" . $cattipo["idcategoriatipo"] . "'";
        $result_tipopro = mysql_query($sql_tipopro, $con) or die(mysql_error());
        $tipos = mysql_num_rows($result_tipopro);
        $tiposdeproducto = array();
        if (mysql_num_rows($result_tipopro) > 0) {
            while ($tipopro = mysql_fetch_assoc($result_tipopro)) {
                $tiposdeproducto[count($tiposdeproducto)] = $tipopro["idtipoproducto"];
                $sql_cuentapro = "select count(*) as elementos from producto where idtipoproducto='" . $tipopro["idtipoproducto"] . "'";
                $result_cuentapro = mysql_query($sql_cuentapro, $con) or die(mysql_error());
                $elementos = mysql_fetch_assoc($result_cuentapro);
                $cuenta+=$elementos["elementos"];
            }
        }
        if ($cuenta > 0) {

//                echo "<div class='namematerial2'>" . $cattipo["tipocategoria"] . "</div>";
            $pdf->SetXY($colum, $suma+=10);
            $pdf->SetFont('courier', 'B', 12);
            $pdf->Cell(62, 8, $cattipo["tipocategoria"], 0, 1, "L", 0, '', 0);

            $sql_formas = "select * from categoriaproducto";
            $result_formas = mysql_query($sql_formas, $con) or die(mysql_error());
            if (mysql_num_rows($result_formas) > 0) {
                $bandera02 = 0;
                while ($forma = mysql_fetch_assoc($result_formas)) {

                    $concatena = " ( ";
                    for ($i = 0; $i < count($tiposdeproducto); $i++) {
                        if ($i == 0) {
                            $concatena = $concatena . " producto.idtipoproducto = " . $tiposdeproducto[$i];
                        } else {
                            $concatena = $concatena . " or producto.idtipoproducto = " . $tiposdeproducto[$i];
                        }
                    }
                    $concatena = $concatena . " )";
                    $sql_producto = "select producto.idproducto, tipoproducto.codig, producto.codigo, producto.descripcion, material.nombre, producto.dimensionlargo, producto.dimensionancho, producto.dimensionalto, producto.peso, producto.capacidad, producto.preciofabrica, patronproducto.idcategoriaproducto, producto.idtipoproducto, producto.regalias, producto.estandarizado from producto, tipoproducto, material, patronproducto where producto.idtipoproducto = tipoproducto.idtipoproducto and producto.idmaterial = material.idmaterial and producto.idpatronproducto = patronproducto.idpatronproducto and patronproducto.idcategoriaproducto='" . $forma["idcategoriaproducto"] . "' and " . $concatena . " order by producto.codigo";
                    $result_producto = mysql_query($sql_producto, $con) or die(mysql_error());
                    if (mysql_num_rows($result_producto) > 0) {
//                         echo "<div class='namecategoria'>" . $forma["nombreespanol"] . "</div>";
                        $pdf->SetXY($colum, $suma+=6);
                        $pdf->SetFont('courier', 'N', 10);
                        $pdf->Cell(58, 8, $forma["nombreespanol"], 0, 1, "L", 0, '', 0);



                        /*                         * ****************Cabecera de la tabla*********************** */
                        $pdf->SetFont('courier', 'B', 7);                        
                        $pdf->SetXY($colum, $suma+=8);
                        $pdf->Cell(14, 8, "Codigo", 1, 1, "C", 0, '', 0);

                        $pdf->SetXY($colum+=14, $suma);
                        $pdf->Cell(50, 8, "Nombre", 1, 1, "C", 0, '', 0);

                        $pdf->SetXY($colum+=50, $suma);
                        $pdf->Cell(32, 4, "Largo x Ancho x Alto", 1, 1, "C", 0, '', 0);
                        $pdf->SetXY($colum, $suma+=4);
                        $pdf->Cell(32, 4, "(cm)", 1, 1, "C", 0, '', 0);

                        $pdf->SetXY($colum+=32, $suma-=4);
                        $pdf->Cell(16, 4, "Capacidad", 1, 1, "C", 0, '', 0);
                        $pdf->SetXY($colum, $suma+=4);
                        $pdf->Cell(16, 4, "(lts)", 1, 1, "C", 0, '', 0);


                        $pdf->SetXY($colum+=16, $suma-=4);
                        $pdf->Cell(8, 4, "Peso", 1, 1, "C", 0, '', 0);
                        $pdf->SetXY($colum, $suma+=4);
                        $pdf->Cell(8, 4, "(Kgs)", 1, 1, "C", 0, '', 0);


                        $pdf->SetXY($colum+=8, $suma-=4);
                        $pdf->Cell(24, 4, "Precio Fabrica", 1, 1, "C", 0, '', 0);
                        $pdf->SetXY($colum, $suma+=4);
                        $pdf->Cell(24, 4, "($)", 1, 1, "C", 0, '', 0);


                        $pdf->SetXY($colum+=24, $suma-=4);
                        $pdf->Cell(14, 4, "Regalias", 1, 1, "C", 0, '', 0);
                        $pdf->SetXY($colum, $suma+=4);
                        $pdf->Cell(14, 4, "10%", 1, 1, "C", 0, '', 0);

                        $pdf->SetXY($colum+=14, $suma-=4);
                        $pdf->Cell(22, 4, "Costo", 1, 1, "C", 0, '', 0);
                        $pdf->SetXY($colum, $suma+=4);
                        $pdf->Cell(22, 4, "Estandarizado", 1, 1, "C", 0, '', 0);

                        $pdf->SetXY($colum+=22, $suma-=4);
                        $pdf->Cell(12, 4, "Precio", 1, 1, "C", 0, '', 0);
                        $pdf->SetXY($colum, $suma+=4);
                        $pdf->Cell(12, 4, "($)", 1, 1, "C", 0, '', 0);


                        /**                         * ***************************FIN CABECERA TABLA ************ */
                        $colum = 10;
                        while ($pro = mysql_fetch_assoc($result_producto)) {
                            if ($suma > 250 && $bool == 0) {
                                $bool = 1;
                                $pdf->AddPage('P', 'A4');
                                $pdf->Image('../imagenes/apariencia/logobugambilia.png', 10, 14, 53, 14, 'PNG', 'http://www.gaagdesarrolloempresarial.com', '', true, 150, '', false, false, 0, false, false, false);
                                $pdf->SetFont('courier', 'B', 10);
                                $suma = 30;
                            }
                            $sql_tipo = "select * from tipoproducto where idtipoproducto='" . $pro["idtipoproducto"] . "'";
                            $result_tipo = mysql_query($sql_tipo, $con) or die(mysql_error());
                            $tipo = mysql_fetch_assoc($result_tipo);

                            $pdf->SetFont('courier', '', 7);
                            $pdf->SetXY($colum, $suma+=4);
                            $pdf->Cell(14, 4, $pro["codigo"], 1, 1, "L", 0, '', 0);

                            $pdf->SetFont('courier', '', 7);
                            $pdf->SetXY($colum+=14, $suma);
                            $pdf->Cell(50, 4, $pro["descripcion"], 1, 1, "L", 0, '', 0);

                            $pdf->SetFont('courier', '', 7);
                            $pdf->SetXY($colum+=50, $suma);
                            $pdf->Cell(32, 4, number_format(round($pro["dimensionlargo"],1),1) . " x " .  number_format(round($pro["dimensionancho"],1),1) . " x " . number_format(round($pro["dimensionalto"],1),1), 1, 1, "L", 0, '', 0);

                            $pdf->SetFont('courier', '', 7);
                            $pdf->SetXY($colum+=32, $suma);
                            $pdf->Cell(16, 4, $pro["capacidad"], 1, 1, "C", 0, '', 0);

                            $pdf->SetFont('courier', '', 7);
                            $pdf->SetXY($colum+=16, $suma);
                            $pdf->Cell(8, 4, $pro["peso"], 1, 1, "C", 0, '', 0);

                            $pdf->SetFont('courier', '', 7);
                            $pdf->SetXY($colum+=8, $suma);
                            $pdf->Cell(24, 4, number_format(round($pro["preciofabrica"],2),2,".",","), 1, 1, "C", 0, '', 0);

                            $pdf->SetXY($colum+=24, $suma);
                            $pdf->Cell(14, 4, number_format(round($pro["regalias"],2), 2, ".", ","), 1, 1, "C", 0, '', 0);
                          
                            $pdf->SetXY($colum+=14, $suma);
                            $pdf->Cell(22, 4, number_format(round($pro["estandarizado"],2), 2, ".", ","), 1, 1, "C", 0, '', 0);

                            
                            $sql_buscaprecio="select * from productoslista where idproducto='".$pro["idproducto"]."' and idlistadeprecios='".$_GET["id"]."'";
                            $result_precio = mysql_query($sql_buscaprecio, $con) or die(mysql_error());
                            $preciobuscado = mysql_fetch_assoc($result_precio); 

                            $pdf->SetXY($colum+=22, $suma);
                            if($preciobuscado["excepcion"]!=0){
                                //echo "<div class='col-xs-1' style='background-color: #ff0'>".$preciobuscado["excepcion"]."</div>";
                                $pdf->SetFillColor(255,255,0);
                                $pdf->Cell(12, 4, number_format(round($preciobuscado["excepcion"],2), 2, ".", ","), 1, 1, "C", 1, '', 0);
                            }else {
                                //echo "<div class='col-xs-1'>".$preciobuscado["precio"]."</div>";
                                $pdf->Cell(12, 4, number_format(round($preciobuscado["precio"],2), 2, ".", ","), 1, 1, "C", 0, '', 0);
                            }                             

                            $colum = 10;
                        }
                        $bool = 0;
                    }
                }
            }
        }
    }
}












$pdf->Output($lista["nombre"].'.pdf', 'I');
?>