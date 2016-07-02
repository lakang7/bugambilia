<?php

/*echo $_POST["anno"]."</br>";
echo $_POST["tipo"]."</br>";
echo $_POST["unidades"]."</br>";
echo $_POST["elementos"]."</br>";*/

require_once('../recursos/tcpdf/tcpdf.php');
require_once('../recursos/funciones.php');
$con = Conexion();
$listaProductos=array();
$listaPorMeses=array();
$listaMeses=array(1,2,3,4,5,6,7,8,9,10,11,12);

for($m=0;$m<count($listaMeses);$m++){
    $sqlOrdenes="select * FROM ordendecompra where extract(month from fechaderegistro)=".$listaMeses[$m]." and extract(year from fechaderegistro)=".$_POST["anno"];
    $resultOrdenes = mysql_query($sqlOrdenes, $con) or die(mysql_error());
    if (mysql_num_rows($resultOrdenes) > 0) {
        while ($orden = mysql_fetch_assoc($resultOrdenes)) {
            $sqlProductos="select * from productosordencompra where idordendecompra='".$orden["idordendecompra"]."'";
            $resultProductos = mysql_query($sqlProductos, $con) or die(mysql_error());
            if (mysql_num_rows($resultProductos) > 0) {
                while ($producto = mysql_fetch_assoc($resultProductos)) {
                    $band=0;
                    for($i=0;$i<count($listaProductos);$i++){
                        if($listaProductos[$i]==$producto["idproducto"]){
                            $band=1;
                        }
                    }
                    if($band==0){
                        $listaProductos[count($listaProductos)]=$producto["idproducto"];
                        $listaPorMeses[$producto["idproducto"]][0]=0;
                        $listaPorMeses[$producto["idproducto"]][1]=0;
                        $listaPorMeses[$producto["idproducto"]][2]=0;
                        $listaPorMeses[$producto["idproducto"]][3]=0;
                        $listaPorMeses[$producto["idproducto"]][4]=0;
                        $listaPorMeses[$producto["idproducto"]][5]=0;
                        $listaPorMeses[$producto["idproducto"]][6]=0;
                        $listaPorMeses[$producto["idproducto"]][7]=0;
                        $listaPorMeses[$producto["idproducto"]][8]=0;
                        $listaPorMeses[$producto["idproducto"]][9]=0;
                        $listaPorMeses[$producto["idproducto"]][10]=0;
                        $listaPorMeses[$producto["idproducto"]][11]=0;
                        if($_POST["unidades"]==1){
                            $listaPorMeses[$producto["idproducto"]][$m]+=$producto["numerodeunidades"];
                        }else{
                            $listaPorMeses[$producto["idproducto"]][$m]+=($producto["precioventa"]*$producto["numerodeunidades"]);
                        }
                        
                    }else if($band==1){
                        if($_POST["unidades"]==1){
                            $listaPorMeses[$producto["idproducto"]][$m]+=$producto["numerodeunidades"];
                        }else{
                            $listaPorMeses[$producto["idproducto"]][$m]+=($producto["precioventa"]*$producto["numerodeunidades"]);
                        }                        
                    }
                }
            }
        }    
    }
}

/*for($i=0;$i<count($listaProductos);$i++){
    echo $listaProductos[$i]."-".$listaPorMeses[$listaProductos[$i]][0]."-".$listaPorMeses[$listaProductos[$i]][1]."-".$listaPorMeses[$listaProductos[$i]][2]."-".$listaPorMeses[$listaProductos[$i]][3]."-".$listaPorMeses[$listaProductos[$i]][4]."-".$listaPorMeses[$listaProductos[$i]][5]."-".$listaPorMeses[$listaProductos[$i]][6]."-".$listaPorMeses[$listaProductos[$i]][7]."-".$listaPorMeses[$listaProductos[$i]][8]."-".$listaPorMeses[$listaProductos[$i]][9]."-".$listaPorMeses[$listaProductos[$i]][10]."-".$listaPorMeses[$listaProductos[$i]][11]."</br>";
}

echo "</br></br>";*/

function bubbleSort($array1,$array2, $n) {
    for ($i = 1; $i < $n; $i++) {
      for ($j = 0; $j < $n - $i; $j++) {
        if ($array1[$j] < $array1[$j + 1]) {
          $k = $array1[$j + 1]; 
          $array1[$j + 1] = $array1[$j]; 
          $array1[$j] = $k;
          
          $a = $array2[$j + 1]; 
          $array2[$j + 1] = $array2[$j]; 
          $array2[$j] = $a;          
        }
      }
    }
    $devuelve=array();
    $devuelve[0]=$array1;
    $devuelve[1]=$array2;
    return $devuelve;
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



$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Bugambilia');
$pdf->SetTitle('Reporte de Ventas por Productos');

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

$pdf->Cell(80, 4, "Informe de Ventas por Productos", 0, 1, "R", 0, '', 0); $altura+=4.50;
$pdf->SetXY(120,$altura); 
if($_POST["tipo"]==1){
    $pdf->Cell(80, 4, "Agrupación por Meses", 0, 1, "R", 0, '', 0); $altura+=4.50;
}
if($_POST["tipo"]==2){
    $pdf->Cell(80, 4, "Agrupación por Trimestres", 0, 1, "R", 0, '', 0); $altura+=4.50;
}

if($_POST["tipo"]==3){
    $pdf->Cell(80, 4, "Agrupación Anualizada", 0, 1, "R", 0, '', 0); $altura+=4.50;
}
$pdf->SetXY(120,$altura); 
$pdf->Cell(80, 4, "Año: ".$_POST["anno"], 0, 1, "R", 0, '', 0); $altura+=4.50;

if($_POST["unidades"]==1){
    $pdf->SetXY(120,$altura); 
    $pdf->Cell(80, 4,"Reporte en Función de Unidades Vendidas", 0, 1, "R", 0, '', 0);     
}

if($_POST["unidades"]==2){
    $pdf->SetXY(120,$altura); 
    $pdf->Cell(80, 4,"Reporte en Función del Dinero Obtenido de las Ventas", 0, 1, "R", 0, '', 0);     
}



$altura+=7;


$pdf->SetFont('courier', '', 10);
$pdf->Line(10,$altura, 200, $altura);
$altura+=4;


if($_POST["tipo"]==1){ /*Agrupacion por meses*/

    for($m=0;$m<count($listaMeses);$m++){    
        $pdf->SetXY(10,$altura); 
        $pdf->SetFont('courier', 'B', 10);
        
            if($altura>270){
                $pdf->AddPage('P', 'A4');
                $pdf->Image('../imagenes/apariencia/logobugambilia.png', 10, 14, 53, 14, 'PNG', 'http://www.gaagdesarrolloempresarial.com', '', true, 150, '', false, false, 0, false, false, false);
                            
                $altura=16; 
                $pdf->SetXY(120,$altura); 
                $pdf->SetFont('courier', 'I', 10);
                            
                $pdf->Cell(80, 4, "Informe de Ventas por Productos", 0, 1, "R", 0, '', 0); $altura+=4.50;
                $pdf->SetXY(120,$altura); 
                if($_POST["tipo"]==1){
                    $pdf->Cell(80, 4, "Agrupación por Meses", 0, 1, "R", 0, '', 0); $altura+=4.50;
                }
                if($_POST["tipo"]==2){
                    $pdf->Cell(80, 4, "Agrupación por Trimestres", 0, 1, "R", 0, '', 0); $altura+=4.50;
                }
                $pdf->SetXY(120,$altura); 
                $pdf->Cell(80, 4, "Año: ".$_POST["anno"], 0, 1, "R", 0, '', 0); $altura+=7;
                if($_POST["unidades"]==1){
                    $pdf->SetXY(120,$altura); 
                    $pdf->Cell(80, 4,"Reporte en Función de Unidades Vendidas", 0, 1, "R", 0, '', 0);     
                }
                
                if($_POST["unidades"]==2){
                    $pdf->SetXY(120,$altura); 
                    $pdf->Cell(80, 4,"Reporte en Función del Dinero Obtenido de las Ventas", 0, 1, "R", 0, '', 0);     
                }                
                
                $pdf->SetFont('courier', '', 10);
                $pdf->Line(10,$altura, 200, $altura);
                $altura+=4;                        
            }        
        $pdf->Cell(80, 4, $meses[$m], 0, 1, "L", 0, '', 0); $altura+=7; 
        $pdf->SetFont('courier', '', 10);
        $productos=array();
        $unidades=array();
        for($i=0;$i<count($listaProductos);$i++){
            $productos[$i]=$listaProductos[$i];
            $unidades[$i]=$listaPorMeses[$listaProductos[$i]][$m];
        }
        
        $ordenado =  bubbleSort($unidades, $productos, count($unidades));
        $ordenado01 = $ordenado[0];
        $ordenado02 = $ordenado[1];
        
        $acumulaAUX=0;
        for($i=0;$i<count($ordenado01) && $i< $_POST["elementos"];$i++){
            $acumulaAUX+=$ordenado01[$i];
        }
        
        if($acumulaAUX==0){
            
            if($altura>270){
                $pdf->AddPage('P', 'A4');
                $pdf->Image('../imagenes/apariencia/logobugambilia.png', 10, 14, 53, 14, 'PNG', 'http://www.gaagdesarrolloempresarial.com', '', true, 150, '', false, false, 0, false, false, false);
                            
                $altura=16; 
                $pdf->SetXY(120,$altura); 
                $pdf->SetFont('courier', 'I', 10);
                            
                $pdf->Cell(80, 4, "Informe de Ventas por Productos", 0, 1, "R", 0, '', 0); $altura+=4.50;
                $pdf->SetXY(120,$altura); 
                if($_POST["tipo"]==1){
                    $pdf->Cell(80, 4, "Agrupación por Meses", 0, 1, "R", 0, '', 0); $altura+=4.50;
                }
                if($_POST["tipo"]==2){
                    $pdf->Cell(80, 4, "Agrupación por Trimestres", 0, 1, "R", 0, '', 0); $altura+=4.50;
                }
                $pdf->SetXY(120,$altura); 
                $pdf->Cell(80, 4, "Año: ".$_POST["anno"], 0, 1, "R", 0, '', 0); $altura+=4.50;
                
                if($_POST["unidades"]==1){
                    $pdf->SetXY(120,$altura); 
                    $pdf->Cell(80, 4,"Reporte en Función de Unidades Vendidas", 0, 1, "R", 0, '', 0);     
                }
                
                if($_POST["unidades"]==2){
                    $pdf->SetXY(120,$altura); 
                    $pdf->Cell(80, 4,"Reporte en Función del Dinero Obtenido de las Ventas", 0, 1, "R", 0, '', 0);     
                }                 
                $altura+=7;
                $pdf->SetFont('courier', '', 10);
                $pdf->Line(10,$altura, 200, $altura);
                $altura+=4;                        
            }            
            
            
            $altura-=3;
            $pdf->SetXY(10,$altura); 
            $pdf->Cell(80, 4,"No se registran ventas para este mes.", 0, 1, "L", 0, '', 0); $altura+=7;                 
        }        
        
        for($i=0;$i<count($ordenado01) && $i< $_POST["elementos"];$i++){
            if($acumulaAUX>0 && $ordenado01[$i]>0){
                $sqlproducto="select * from producto where idproducto='".$ordenado02[$i]."'";
                $resultProducto = mysql_query($sqlproducto, $con) or die(mysql_error());
                if (mysql_num_rows($resultProducto) > 0) {
                    while ($producto = mysql_fetch_assoc($resultProducto)) {
                        $pdf->SetXY(10,$altura); 
                        $pdf->Cell(18, 4,$producto["codigo"], 0, 1, "L", 0, '', 0); 
                        $pdf->SetXY(28,$altura); 
                        $pdf->Cell(60, 4,$producto["descripcion"], 0, 1, "L", 0, '', 0);   
                        $pdf->SetXY(88,$altura); 
                        $pdf->Cell(20, 4,$ordenado01[$i], 0, 1, "R", 0, '', 0); 
                        $pdf->SetXY(108,$altura); 
                        $x = (($ordenado01[$i]*90)/$ordenado01[0]);
                        $pdf->Cell($x, 4,"", 1, 1, "R", 0, '', 0);                     
                        $altura+=4.8;
                        
                        if($altura>270){
                            $pdf->AddPage('P', 'A4');
                            $pdf->Image('../imagenes/apariencia/logobugambilia.png', 10, 14, 53, 14, 'PNG', 'http://www.gaagdesarrolloempresarial.com', '', true, 150, '', false, false, 0, false, false, false);
                            
                            $altura=16; 
                            $pdf->SetXY(120,$altura); 
                            $pdf->SetFont('courier', 'I', 10);
                            
                            $pdf->Cell(80, 4, "Informe de Ventas por Productos", 0, 1, "R", 0, '', 0); $altura+=4.50;
                            $pdf->SetXY(120,$altura); 
                            if($_POST["tipo"]==1){
                                $pdf->Cell(80, 4, "Agrupación por Meses", 0, 1, "R", 0, '', 0); $altura+=4.50;
                            }
                            if($_POST["tipo"]==2){
                                $pdf->Cell(80, 4, "Agrupación por Trimestres", 0, 1, "R", 0, '', 0); $altura+=4.50;
                            }
                            $pdf->SetXY(120,$altura); 
                            $pdf->Cell(80, 4, "Año: ".$_POST["anno"], 0, 1, "R", 0, '', 0); $altura+=4.50;
                            
                            if($_POST["unidades"]==1){
                                $pdf->SetXY(120,$altura); 
                                $pdf->Cell(80, 4,"Reporte en Función de Unidades Vendidas", 0, 1, "R", 0, '', 0);     
                            }
                
                            if($_POST["unidades"]==2){
                                $pdf->SetXY(120,$altura); 
                                $pdf->Cell(80, 4,"Reporte en Función del Dinero Obtenido de las Ventas", 0, 1, "R", 0, '', 0);     
                            }   
                            
                            $altura+=7;
                            $pdf->SetFont('courier', '', 10);
                            $pdf->Line(10,$altura, 200, $altura);
                            $altura+=4;                        
                        }
                        
                    }   
                }
            }
        } 
        $altura+=5; 
    }    
    
    
}else if($_POST["tipo"]==2){ /*Agrupación por trimestres*/
    //$altura+=5;
    for($m=0;$m<3;$m++){
    
        //echo "----------------------Trimestre ".$m."----------------------------</br>";
        $pdf->SetXY(10,$altura);
        $pdf->SetFont('courier', 'B', 10); 
        $pdf->Cell(80, 4,"Trimestre ".($m+1), 0, 1, "L", 0, '', 0); $altura+=7; 
        $pdf->SetFont('courier', '', 10);        
        $productos=array();
        $unidades=array();
        for($i=0;$i<count($listaProductos);$i++){
            $productos[$i]=$listaProductos[$i];
            if($m==0){
                $unidades[$i]=$listaPorMeses[$listaProductos[$i]][0]+$listaPorMeses[$listaProductos[$i]][1]+$listaPorMeses[$listaProductos[$i]][2]+$listaPorMeses[$listaProductos[$i]][3];
            }
            if($m==1){
                $unidades[$i]=$listaPorMeses[$listaProductos[$i]][4]+$listaPorMeses[$listaProductos[$i]][5]+$listaPorMeses[$listaProductos[$i]][6]+$listaPorMeses[$listaProductos[$i]][7];
            }            
            if($m==2){
                $unidades[$i]=$listaPorMeses[$listaProductos[$i]][8]+$listaPorMeses[$listaProductos[$i]][9]+$listaPorMeses[$listaProductos[$i]][10]+$listaPorMeses[$listaProductos[$i]][11];
            }             
        }
        
        $ordenado =  bubbleSort($unidades, $productos, count($unidades));
        $ordenado01 = $ordenado[0];
        $ordenado02 = $ordenado[1];
        
        $acumulaAUX=0;
        for($i=0;$i<count($ordenado01) && $i< $_POST["elementos"];$i++){
            $acumulaAUX+=$ordenado01[$i];
            
            
        }
        
        if($acumulaAUX==0){
            
            
            if($altura>270){
                $pdf->AddPage('P', 'A4');
                $pdf->Image('../imagenes/apariencia/logobugambilia.png', 10, 14, 53, 14, 'PNG', 'http://www.gaagdesarrolloempresarial.com', '', true, 150, '', false, false, 0, false, false, false);
                            
                $altura=16; 
                $pdf->SetXY(120,$altura); 
                $pdf->SetFont('courier', 'I', 10);
                            
                $pdf->Cell(80, 4, "Informe de Ventas por Productos", 0, 1, "R", 0, '', 0); $altura+=4.50;
                $pdf->SetXY(120,$altura); 
                if($_POST["tipo"]==1){
                    $pdf->Cell(80, 4, "Agrupación por Meses", 0, 1, "R", 0, '', 0); $altura+=4.50;
                }
                if($_POST["tipo"]==2){
                    $pdf->Cell(80, 4, "Agrupación por Trimestres", 0, 1, "R", 0, '', 0); $altura+=4.50;
                }
                $pdf->SetXY(120,$altura); 
                $pdf->Cell(80, 4, "Año: ".$_POST["anno"], 0, 1, "R", 0, '', 0); $altura+=4.50;
                
                if($_POST["unidades"]==1){
                    $pdf->SetXY(120,$altura); 
                    $pdf->Cell(80, 4,"Reporte en Función de Unidades Vendidas", 0, 1, "R", 0, '', 0);     
                }
                
                if($_POST["unidades"]==2){
                    $pdf->SetXY(120,$altura); 
                    $pdf->Cell(80, 4,"Reporte en Función del Dinero Obtenido de las Ventas", 0, 1, "R", 0, '', 0);     
                }            
            }
            $altura-=3;
            $pdf->SetXY(10,$altura); 
            $pdf->Cell(80, 4,"No se registran ventas para este Trimestre.", 0, 1, "L", 0, '', 0); $altura+=7;                         
        }        
        
        for($i=0;$i<count($ordenado01) && $i< $_POST["elementos"];$i++){
            if($acumulaAUX>0 && $ordenado01[$i]>0){
                $sqlproducto="select * from producto where idproducto='".$ordenado02[$i]."'";
                $resultProducto = mysql_query($sqlproducto, $con) or die(mysql_error());
                if (mysql_num_rows($resultProducto) > 0) {
                    while ($producto = mysql_fetch_assoc($resultProducto)) {
                        $pdf->SetXY(10,$altura); 
                        $pdf->Cell(18, 4,$producto["codigo"], 0, 1, "L", 0, '', 0); 
                        $pdf->SetXY(28,$altura); 
                        $pdf->Cell(60, 4,$producto["descripcion"], 0, 1, "L", 0, '', 0);   
                        $pdf->SetXY(88,$altura); 
                        $pdf->Cell(20, 4,$ordenado01[$i], 0, 1, "R", 0, '', 0); 
                        $pdf->SetXY(108,$altura); 
                        $x = (($ordenado01[$i]*90)/$ordenado01[0]);
                        $pdf->Cell($x, 4,"", 1, 1, "R", 0, '', 0);                     
                        $altura+=4.8;
                        
                        if($altura>270){
                            $pdf->AddPage('P', 'A4');
                            $pdf->Image('../imagenes/apariencia/logobugambilia.png', 10, 14, 53, 14, 'PNG', 'http://www.gaagdesarrolloempresarial.com', '', true, 150, '', false, false, 0, false, false, false);
                            
                            $altura=16; 
                            $pdf->SetXY(120,$altura); 
                            $pdf->SetFont('courier', 'I', 10);
                            
                            $pdf->Cell(80, 4, "Informe de Ventas por Productos", 0, 1, "R", 0, '', 0); $altura+=4.50;
                            $pdf->SetXY(120,$altura); 
                            if($_POST["tipo"]==1){
                                $pdf->Cell(80, 4, "Agrupación por Meses", 0, 1, "R", 0, '', 0); $altura+=4.50;
                            }
                            if($_POST["tipo"]==2){
                                $pdf->Cell(80, 4, "Agrupación por Trimestres", 0, 1, "R", 0, '', 0); $altura+=4.50;
                            }
                            $pdf->SetXY(120,$altura); 
                            $pdf->Cell(80, 4, "Año: ".$_POST["anno"], 0, 1, "R", 0, '', 0); $altura+=4.50;
                            
                            if($_POST["unidades"]==1){
                                $pdf->SetXY(120,$altura); 
                                $pdf->Cell(80, 4,"Reporte en Función de Unidades Vendidas", 0, 1, "R", 0, '', 0);     
                            }
                
                            if($_POST["unidades"]==2){
                                $pdf->SetXY(120,$altura); 
                                $pdf->Cell(80, 4,"Reporte en Función del Dinero Obtenido de las Ventas", 0, 1, "R", 0, '', 0);     
                            }   
                            
                            $altura+=7;
                            $pdf->SetFont('courier', '', 10);
                            $pdf->Line(10,$altura, 200, $altura);
                            $altura+=4;                        
                        }
                        
                    }   
                }
            }
        } 
        
        $altura+=5;
        
        

    }      
    
}else if($_POST["tipo"]==3){ /*Agrupación Anual*/
        
        $pdf->SetXY(10,$altura);
        $pdf->SetFont('courier', 'B', 10); 
        $pdf->Cell(80, 4,"Año ".$_POST["anno"], 0, 1, "L", 0, '', 0); $altura+=7; 
        $pdf->SetFont('courier', '', 10);        
        $productos=array();
        $unidades=array();
        for($i=0;$i<count($listaProductos);$i++){
            $productos[$i]=$listaProductos[$i];
            $unidades[$i]=0;
            for($j=0;$j<12;$j++){
                $unidades[$i]+=$listaPorMeses[$listaProductos[$i]][$j];
            }
        }
        
        $ordenado =  bubbleSort($unidades, $productos, count($unidades));
        $ordenado01 = $ordenado[0];
        $ordenado02 = $ordenado[1];
        
        $acumulaAUX=0;
        for($i=0;$i<count($ordenado01) && $i< $_POST["elementos"];$i++){
            $acumulaAUX+=$ordenado01[$i];                        
        }
                
        for($i=0;$i<count($ordenado01) && $i< $_POST["elementos"];$i++){
            if($acumulaAUX>0 && $ordenado01[$i]>0){
                $sqlproducto="select * from producto where idproducto='".$ordenado02[$i]."'";
                $resultProducto = mysql_query($sqlproducto, $con) or die(mysql_error());
                if (mysql_num_rows($resultProducto) > 0) {
                    while ($producto = mysql_fetch_assoc($resultProducto)) {
                        $pdf->SetXY(10,$altura); 
                        $pdf->Cell(18, 4,$producto["codigo"], 0, 1, "L", 0, '', 0); 
                        $pdf->SetXY(28,$altura); 
                        $pdf->Cell(60, 4,$producto["descripcion"], 0, 1, "L", 0, '', 0);   
                        $pdf->SetXY(88,$altura); 
                        $pdf->Cell(20, 4,$ordenado01[$i], 0, 1, "R", 0, '', 0); 
                        $pdf->SetXY(108,$altura); 
                        $x = (($ordenado01[$i]*90)/$ordenado01[0]);
                        $pdf->Cell($x, 4,"", 1, 1, "R", 0, '', 0);                     
                        $altura+=4.8;                                                
                    }   
                }
            }
        }         
                
}


$pdf->Output('Informe de Ventas por Productos.pdf', 'I');

?>