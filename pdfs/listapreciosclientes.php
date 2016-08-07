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



$sql_LISTA = "select * from listadeprecios where idlistadeprecios='" . $_GET["id"] . "'";
$result_LISTA = mysql_query($sql_LISTA, $con) or die(mysql_error());
if (mysql_num_rows($result_LISTA) > 0) {
    $lista = mysql_fetch_assoc($result_LISTA);
}

$sqlConfiguracion = "select * from configuracionsistema where idconfiguracionsistema=1";
$result_Configuracion = mysql_query($sqlConfiguracion, $con) or die(mysql_error());
if (mysql_num_rows($result_Configuracion) > 0) {
    $configuracion = mysql_fetch_assoc($result_Configuracion);
}

$pdf->SetXY($colum, $suma);
$pdf->SetFont('courier', 'B', 14);
$pdf->Cell(62, 8, $lista["nombre"], 0, 1, "L", 0, '', 0);



    $pagina=1;
    $con= Conexion();
    $sql_categoriatipo="select * from categoriatipo order by idcategoriatipo";
    $result_categoriatipo=mysql_query($sql_categoriatipo,$con) or die(mysql_error());
    while ($categoriatipo = mysql_fetch_assoc($result_categoriatipo)) {
        if(listlevel01($categoriatipo["idcategoriatipo"])>0){
            //echo "------------------------------------------------>".$categoriatipo["tipocategoria"]."</br>";
            
            $pdf->SetXY($colum, $suma+=10);
            $pdf->SetFont('courier', 'B', 12);
            $pdf->Cell(62, 8, $categoriatipo["tipocategoria"], 0, 1, "L", 0, '', 0);             
             
            $concatena=" ( ";
            $sql_sub="select * from tipoproducto where idcategoriatipo='".$categoriatipo["idcategoriatipo"]."'";
            $result_sub=mysql_query($sql_sub,$con) or die(mysql_error());
            $indice=0;
            while ($sub = mysql_fetch_assoc($result_sub)) {
                if($indice==0){
                    $concatena= $concatena." idtipoproducto=".$sub["idtipoproducto"]." ";
                }else{
                    $concatena= $concatena." or idtipoproducto=".$sub["idtipoproducto"]." ";
                }
                
                $indice++;
            }
            
            $concatena=$concatena." ) ";
            
            
            $sql_forma="select * from categoriaproducto order by idcategoriaproducto";
            $result_formas=mysql_query($sql_forma,$con) or die(mysql_error());            
            while ($forma = mysql_fetch_assoc($result_formas)) {
                if(listlevel02($categoriatipo["idcategoriatipo"], $forma["idcategoriaproducto"])>0){
                    //echo ">>>>>>>>>>>>>>>>>>>>>>>".$forma["nombreespanol"]."</br>";
                    $pdf->SetXY($colum, $suma+=6);
                    $pdf->SetFont('courier', 'N', 10);
                    $pdf->Cell(58, 8, $forma["nombreespanol"], 0, 1, "L", 0, '', 0);                    
                    $suma+=7;
                    
                    $pdf->SetFont('courier', 'B', 8);                        
                    $pdf->SetXY($colum, $suma);
                    $pdf->Cell(14, 5.5, "Codigo", 1, 1, "C", 0, '', 0);
                       
                    $pdf->SetXY($colum+=14, $suma);
                    $pdf->Cell(63, 5.5, "Nombre", 1, 1, "C", 0, '', 0);
                        
                    $pdf->SetXY($colum+=63, $suma);
                    $pdf->Cell(17, 5.5, "Largo(cm)", 1, 1, "C", 0, '', 0);  
                        
                    $pdf->SetXY($colum+=17, $suma);
                    $pdf->Cell(17, 5.5, "Ancho(cm)", 1, 1, "C", 0, '', 0); 
                        
                    $pdf->SetXY($colum+=17, $suma);
                    $pdf->Cell(17, 5.5, "Alto(cm)", 1, 1, "C", 0, '', 0); 
                        
                    $pdf->SetXY($colum+=17, $suma);
                    $pdf->Cell(24, 5.5, "Capacidad(l)", 1, 1, "C", 0, '', 0);
                        
                    $pdf->SetXY($colum+=24, $suma);
                    $pdf->Cell(17, 5.5, "Peso(kg)", 1, 1, "C", 0, '', 0);
                        
                    $pdf->SetXY($colum+=17, $suma);
                    $pdf->Cell(19, 5.5, "Precio", 1, 1, "C", 0, '', 0);                        
                        
                    $suma+=5.5;
                    $colum=10;                                                            
                    
                    $sql_pat="select * from patronproducto where idcategoriaproducto='".$forma["idcategoriaproducto"]."' ";
                    $result_pat=mysql_query($sql_pat,$con) or die(mysql_error()); 
                    $concatena2=" ( ";
                    $indice2=0;
                    while ($pat = mysql_fetch_assoc($result_pat)) {
                        if($indice2==0){
                            $concatena2= $concatena2." idpatronproducto=".$pat["idpatronproducto"]." ";
                        }else{
                            $concatena2= $concatena2." or idpatronproducto=".$pat["idpatronproducto"]." ";
                        }                
                        $indice2++;                        
                    }
                    $concatena2=$concatena2." ) ";
                    
                    $sql_pro="select * from producto where ".$concatena." and ".$concatena2." order by codigo  ";
                    $result_pro=mysql_query($sql_pro,$con) or die(mysql_error());
                    while ($pro = mysql_fetch_assoc($result_pro)) {
                                                
                        if ($suma > 270) {
                            $pdf->SetFont('courier', '', 9);
                            $pdf->Line(10, 285, 200, 285);
                            $pdf->SetXY(170,287);
                            $pdf->Cell(30, 4,"Página Nro. 0".$pagina, 0, 1,"R", 0, '', 0);  $pagina++;                            
                            $pdf->AddPage('P', 'A4');
                            $pdf->Image('../imagenes/apariencia/logobugambilia.png', 10, 14, 53, 14, 'PNG', 'http://www.gaagdesarrolloempresarial.com', '', true, 150, '', false, false, 0, false, false, false);
                            $pdf->SetFont('courier', 'B', 10);
                            $suma = 30;
                        }                        
                        
                        $pdf->SetFont('courier', 'B', 8);                        
                        $pdf->SetXY($colum, $suma);
                        $pdf->Cell(14, 5.5, $pro["codigo"], 1, 1, "C", 0, '', 0);
                       
                        $pdf->SetXY($colum+=14, $suma);
                        $pdf->Cell(63, 5.5, $pro["descripcion"], 1, 1, "L", 0, '', 0);
                        
                        $pdf->SetXY($colum+=63, $suma);
                        $pdf->Cell(17, 5.5, $pro["dimensionlargo"], 1, 1, "C", 0, '', 0);  
                        
                        $pdf->SetXY($colum+=17, $suma);
                        $pdf->Cell(17, 5.5, $pro["dimensionancho"], 1, 1, "C", 0, '', 0); 
                        
                        $pdf->SetXY($colum+=17, $suma);
                        $pdf->Cell(17, 5.5, $pro["dimensionalto"], 1, 1, "C", 0, '', 0); 
                        
                        $pdf->SetXY($colum+=17, $suma);
                        $pdf->Cell(24, 5.5, $pro["capacidad"], 1, 1, "C", 0, '', 0);
                        
                        $pdf->SetXY($colum+=24, $suma);
                        $pdf->Cell(17, 5.5, $pro["peso"], 1, 1, "C", 0, '', 0);
                        
                        $pdf->SetXY($colum+=17, $suma);
                        $pdf->Cell(19, 5.5, number_format(round(calcularprecio($pro["idproducto"], $_GET["id"]),2),2), 1, 1, "C", 0, '', 0);                        
                        
                        $suma+=5.5;
                        $colum=10;
                    }                                        
                }                                
            }                          
         }
     }
     

    $pdf->SetFont('courier', '', 9);
    $pdf->Line(10, 285, 200, 285);
    $pdf->SetXY(170,287);
    $pdf->Cell(30, 4,"Página Nro. 0".$pagina, 0, 1,"R", 0, '', 0);  $pagina++;


    $pdf->Output($lista["nombre"].'.pdf', 'I');
?>