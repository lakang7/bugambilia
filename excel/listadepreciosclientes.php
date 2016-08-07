<?php

    require_once('../recursos/phpexcel/Classes/PHPExcel.php');
    require_once('../recursos/funciones.php');
 
    $objPHPExcel = new PHPExcel();
    $objPHPExcel->getProperties()->setCreator("Sistema Bugambilia") // Nombre del autor
    ->setLastModifiedBy("Sistema Bugambilia") //Ultimo usuario que lo modificó
    ->setTitle("Lista de Precios") // Titulo
    ->setSubject("Lista de Precios") //Asunto
    ->setDescription("Lista de Precios");
    
$estiloSuperior = array(
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN
        )
    ),
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => 'ffcb2b')
    )    
); 
    
$estiloTitulo = array(
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN
        )
    ),
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => 'FFFF00')
    )    
);    
    
    
$estiloTituloColumnas = array(
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN
        )
    )
);
                  
    $con= Conexion();
     
    $sql_LISTA="select * from listadeprecios where idlistadeprecios='".$_GET["id"]."'";
    $result_LISTA=mysql_query($sql_LISTA,$con) or die(mysql_error());
    if(mysql_num_rows($result_LISTA)>0){
        $lista = mysql_fetch_assoc($result_LISTA);
    }    
    
    $sqlConfiguracion="select * from configuracionsistema where idconfiguracionsistema=1";
    $result_Configuracion=mysql_query($sqlConfiguracion,$con) or die(mysql_error());
    if(mysql_num_rows($result_Configuracion)>0){
         $configuracion = mysql_fetch_assoc($result_Configuracion);
    }
    
    $objPHPExcel->getActiveSheet()->getStyle('B8:O8')->applyFromArray($estiloTituloColumnas);
    
    $fila=2;
    $columna=2;
    
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.$fila.':G2');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$fila,$lista["nombre"]);$fila++;
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.$fila.':G3');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3',"Empresa: ".$lista["texto"]);$fila++;
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.$fila.':G4');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B4',"Generada: ".date("d")."/".date("m")."/".date("Y")." ".date("H").":".date("i"));$fila+=2;    
     
    $sql_categoriatipo="select * from categoriatipo order by idcategoriatipo";
    $result_categoriatipo=mysql_query($sql_categoriatipo,$con) or die(mysql_error());
    while ($categoriatipo = mysql_fetch_assoc($result_categoriatipo)) {
         if(listlevel01($categoriatipo["idcategoriatipo"])>0){            
            $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':O'.$fila)->applyFromArray($estiloSuperior);
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.$fila.':O'.$fila);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$fila,$categoriatipo["tipocategoria"]);$fila+=2;
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
                    
                    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.$fila.':O'.$fila);
                    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':O'.$fila)->applyFromArray($estiloTitulo);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$fila,$forma["nombreespanol"]);$fila++;                    
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
                    
                    
                    
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$fila,"Codigo");
                    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C'.$fila.':F'.$fila);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$fila,"Nombre");
                    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('G'.$fila.':I'.$fila);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$fila,"Largo x Ancho x Alto (cm)");
                    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('J'.$fila.':K'.$fila);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$fila,"Capacidad (lts)");
                    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('L'.$fila.':M'.$fila);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$fila,"Peso (Kgs)");    
                    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('N'.$fila.':O'.$fila);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$fila,"Precio de Venta ($)");   
                    $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':O'.$fila)->applyFromArray($estiloTitulo);
                    $fila++;                    
                    
                    $sql_pro="select * from producto where ".$concatena." and ".$concatena2." order by codigo  ";
                    $result_pro=mysql_query($sql_pro,$con) or die(mysql_error());
                    while ($pro = mysql_fetch_assoc($result_pro)) {      
                        $sql_tipo="select * from tipoproducto where idtipoproducto='".$pro["idtipoproducto"]."'";
                        $result_tipo=mysql_query($sql_tipo,$con) or die(mysql_error());
                        $tipo=mysql_fetch_assoc($result_tipo); 
                        /*$sqlBUSCA="select * from listatipos where idlistadeprecios='".$_GET["id"]."' and idtipoproducto='".$pro["idtipoproducto"]."'";
                        $resultBUSCA=mysql_query($sqlBUSCA,$con) or die(mysql_error());
                        if(mysql_num_rows($resultBUSCA)>0){
                            $busca=mysql_fetch_assoc($resultBUSCA);                                                                                    
                        } */                                               
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$fila,$pro["codigo"]);
                        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C'.$fila.':F'.$fila);
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$fila,$pro["descripcion"]);
                        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('G'.$fila.':I'.$fila);
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$fila,$pro["dimensionlargo"]." x ".$pro["dimensionancho"]." x ".$pro["dimensionalto"]);
                        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('J'.$fila.':K'.$fila);
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$fila,$pro["capacidad"]);
                        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('L'.$fila.':M'.$fila);
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$fila,$pro["peso"]);    
                        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('N'.$fila.':O'.$fila);
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$fila,  calcularprecio($pro["idproducto"], $_GET["id"]));
                        $objPHPExcel->getActiveSheet()->getStyle('N'.$fila)->getNumberFormat()->setFormatCode('#,##0.00');
                                                                           
                        $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':O'.$fila)->applyFromArray($estiloTituloColumnas);
                        $fila++;
                                                
                    }                    
                    $fila++;
                }
                
            }              

             
         }         
     }    
                       
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="'.$lista["nombre"].'.xlsx"');
    header('Cache-Control: max-age=0');
    // If you're serving to IE 9, then the following may be needed
    header('Cache-Control: max-age=1');

    // If you're serving to IE over SSL, then the following may be needed
    header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
    header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header ('Pragma: public'); // HTTP/1.0

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');
    exit;

?>

