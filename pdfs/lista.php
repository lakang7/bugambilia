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


$colum = 10;
$suma = 35;

$sql_categoriatipo = "select ct.idcategoriatipo IDCT,ct.tipocategoria TIPOCAT from categoriatipo ct order by ct.idcategoriatipo";
$result_categoriatipo = mysql_query($sql_categoriatipo, $con) or die(mysql_error());
while ($categoriatipo = mysql_fetch_assoc($result_categoriatipo)) {
    if (listlevel01($categoriatipo["IDCT"]) > 0) {
        $pdf->SetXY($colum, $suma);
        $pdf->SetFont('courier', 'B', 12);
        $pdf->Cell(62, 8, $categoriatipo["TIPOCAT"], 0, 1, "L", 0, '', 0);
//        echo "------------------------------------------------>".$categoriatipo["TIPOCAT"]."</br>";
        $concatena = " ( ";
        $sql_sub = "select * from tipoproducto where idcategoriatipo='" . $categoriatipo["IDCT"] . "'";
        $result_sub = mysql_query($sql_sub, $con) or die(mysql_error());
        $indice = 0;
        while ($sub = mysql_fetch_assoc($result_sub)) {
            if ($indice == 0) {
                $concatena = $concatena . " idtipoproducto=" . $sub["idtipoproducto"] . " ";
            } else {
                $concatena = $concatena . " or idtipoproducto=" . $sub["idtipoproducto"] . " ";
            }

            $indice++;
        }

        $concatena = $concatena . " ) ";

//        $sql_forma="select * from categoriaproducto order by idcategoriaproducto";
        $sql_forma = "select cp.idcategoriaproducto IDCP,cp.nombreespanol NOM from categoriaproducto cp order by cp.idcategoriaproducto";

        $result_formas = mysql_query($sql_forma, $con) or die(mysql_error());
        while ($forma = mysql_fetch_assoc($result_formas)) {
            if (listlevel02($categoriatipo["IDCT"], $forma["IDCP"]) > 0) {
//                echo ">>>>>>>>>>>>>>>>>>>>>>>".$forma["NOM"]."</br>";
                $pdf->SetXY($colum, $suma+=6);
                $pdf->SetFont('courier', 'N', 10);
                $pdf->Cell(58, 8, $forma["NOM"], 0, 1, "L", 0, '', 0);

                /*                 * *****************Cabecera de la tabla*********************** */
                $pdf->SetFont('courier', 'B', 7);
                $pdf->SetXY($colum, $suma+=8);
                $pdf->Cell(12, 8, "Codigo", 1, 1, "C", 0, '', 0);

                $pdf->SetXY($colum+=12, $suma);
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


                /*                 * ****************************FIN CABECERA TABLA ************ */



                $sqlConfiguracion = "select * from configuracionsistema where idconfiguracionsistema=1";
                $result_Configuracion = mysql_query($sqlConfiguracion, $con) or die(mysql_error());
                if (mysql_num_rows($result_Configuracion) > 0) {
                    $configuracion = mysql_fetch_assoc($result_Configuracion);
                }

                $sql_pat = "select pp.idpatronproducto IDPP from patronproducto pp where pp.idpatronproducto='" . $forma["IDCP"] . "' ";
                $result_pat = mysql_query($sql_pat, $con) or die(mysql_error());
                $concatena2 = " ( ";
                $indice2 = 0;
                while ($pat = mysql_fetch_assoc($result_pat)) {
                    if ($indice2 == 0) {
                        $concatena2 = $concatena2 . " idpatronproducto=" . $pat["IDPP"] . " ";
                    } else {
                        $concatena2 = $concatena2 . " or idpatronproducto=" . $pat["IDPP"] . " ";
                    }
                    $indice2++;
                }
                $concatena2 = $concatena2 . " ) ";
                $colum = 10;
                $sql_pro = "select * from producto where " . $concatena . " and " . $concatena2 . " order by codigo  ";
                $result_pro = mysql_query($sql_pro, $con) or die(mysql_error());
                while ($pro = mysql_fetch_assoc($result_pro)) {
                    $sql_tipo = "select * from tipoproducto where idtipoproducto='" . $pro["idtipoproducto"] . "'";
                    $result_tipo = mysql_query($sql_tipo, $con) or die(mysql_error());
                    $tipo = mysql_fetch_assoc($result_tipo);
                    $sqlBUSCA = "select * from listatipos where idlistadeprecios='" . $_GET["id"] . "' and idtipoproducto='" . $pro["idtipoproducto"] . "'";
                    $resultBUSCA = mysql_query($sqlBUSCA, $con) or die(mysql_error());
                    if (mysql_num_rows($resultBUSCA) > 0) {
                        $busca = mysql_fetch_assoc($resultBUSCA);
                    }
                    $pdf->SetFont('courier', '', 7);
                    $pdf->SetXY($colum, $suma+=4);
                    $pdf->Cell(12, 4, $pro["codigo"], 1, 1, "L", 0, '', 0);

                    $pdf->SetFont('courier', '', 7);
                    $pdf->SetXY($colum+=12, $suma);
                    $pdf->Cell(50, 4, $pro["descripcion"], 1, 1, "L", 0, '', 0);

                    $pdf->SetFont('courier', '', 7);
                    $pdf->SetXY($colum+=50, $suma);
                    $pdf->Cell(32, 4, $pro["dimensionlargo"] . " x " . $pro["dimensionancho"] . " x " . $pro["dimensionalto"], 1, 1, "L", 0, '', 0);

                    $pdf->SetFont('courier', '', 7);
                    $pdf->SetXY($colum+=32, $suma);
                    $pdf->Cell(16, 4, $pro["capacidad"], 1, 1, "C", 0, '', 0);

                    $pdf->SetFont('courier', '', 7);
                    $pdf->SetXY($colum+=16, $suma);
                    $pdf->Cell(8, 4, $pro["peso"], 1, 1, "C", 0, '', 0);

                    $pdf->SetFont('courier', '', 7);
                    $pdf->SetXY($colum+=8, $suma);
                    $pdf->Cell(24, 4, $pro["preciofabrica"], 1, 1, "C", 0, '', 0);
                    $acumulado = $pro["preciofabrica"];
                    $acumulado = $acumulado + $acumulado * ($configuracion["regalias"] / 100);


                    $colum = 10;
                }
            }
        }
    }
}
$pdf->Output('Orden de Compra.pdf', 'I');
?>