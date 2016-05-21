<?php

    require_once('../recursos/phpexcel/Classes/PHPExcel.php');
    require_once('../recursos/funciones.php');
 
    $objPHPExcel = new PHPExcel();
    $objPHPExcel->getProperties()->setCreator("Sistema Bugambilia") // Nombre del autor
    ->setLastModifiedBy("Sistema Bugambilia") //Ultimo usuario que lo modificó
    ->setTitle("Lista de Precios") // Titulo
    ->setSubject("Lista de Precios") //Asunto
    ->setDescription("Lista de Precios");
    
    
$estiloTituloColumnas = array(
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN
        )
    )
);

    $objPHPExcel->getActiveSheet()->getStyle('B8:T8')->applyFromArray($estiloTituloColumnas);
    
    $fila=2;
    $columna=2;
    
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.$fila.':G2');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$fila,"Lista de Precios");$fila++;
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.$fila.':G3');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3',"Empresa: Coca-Cola / RFC GAAG35467");$fila++;
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.$fila.':G4');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B4',"Generada: 19/05/2016 22:16");$fila+=2;
    
    
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$fila,"Catalogo");$fila++;
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$fila,"Redondo");$fila++;
    
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
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$fila,"Precio Fabrica ($)");   
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('P'.$fila.':Q'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$fila,"Regalias 10%");   
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('R'.$fila.':S'.$fila);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.$fila,"Costo Estandar");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T'.$fila,"Precio");
    

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="listadeprecios.xlsx"');
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

