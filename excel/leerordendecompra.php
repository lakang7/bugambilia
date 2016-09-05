<?php
    require_once('../recursos/phpexcel/Classes/PHPExcel.php');
    require_once('../recursos/funciones.php');
    $con= Conexion();
    $XLFileType = PHPExcel_IOFactory::identify('../ordenesdecompra/'.$_POST["archivo"]);  
    $objReader = PHPExcel_IOFactory::createReader($XLFileType);  
    $objReader->setLoadSheetsOnly('OC Interna');  
    $objPHPExcel = $objReader->load('../ordenesdecompra/'.$_POST["archivo"]);  
    $contador=0;
    $limitefilas=200;
    $con=  Conexion();
    
    $cuenta=0;
    $listaIDS="";
    $listaCODIGOS="";
    $listaDESCRIPCIONES="";
    $listaCOLORES="";
    $listaPRECIOS="";
    $listaUNIDADES="";
    $objWorksheet = $objPHPExcel->setActiveSheetIndexByName('OC Interna');                          
    for($i=17;$i<$limitefilas;$i++){
        $numero=trim($objPHPExcel->getActiveSheet()->getCell('B'.$i)->getFormattedValue());
        $modelo=trim($objPHPExcel->getActiveSheet()->getCell('C'.$i)->getFormattedValue());              
        $clave=trim($objPHPExcel->getActiveSheet()->getCell('D'.$i)->getFormattedValue());  
        $descripcion=trim($objPHPExcel->getActiveSheet()->getCell('E'.$i)->getFormattedValue()); 
        $color=trim($objPHPExcel->getActiveSheet()->getCell('F'.$i)->getFormattedValue()); 
        $largo=trim($objPHPExcel->getActiveSheet()->getCell('G'.$i)->getFormattedValue()); 
        $ancho=trim($objPHPExcel->getActiveSheet()->getCell('H'.$i)->getFormattedValue()); 
        $alto=trim($objPHPExcel->getActiveSheet()->getCell('I'.$i)->getFormattedValue()); 
        $piezas=trim($objPHPExcel->getActiveSheet()->getCell('J'.$i)->getFormattedValue()); 
        $precio=trim($objPHPExcel->getActiveSheet()->getCell('K'.$i)->getFormattedValue());
        
        if(is_numeric($numero) && $modelo!="" && $clave!="" && $descripcion!="" && $color!="" && is_numeric($piezas) && is_numeric($precio)){
            
            $sqlProducto="select * from producto where codigo='".$clave."'";
            $resultProducto=mysql_query($sqlProducto,$con) or die(mysql_error());
            
            $sqlColor="select * from color where codigo='".$color."'";
            $resultColor=mysql_query($sqlColor,$con) or die(mysql_error());            
            
            if(mysql_num_rows($resultProducto)==1 && mysql_num_rows($resultColor)==1){
                $producto = mysql_fetch_assoc($resultProducto);
                $color = mysql_fetch_assoc($resultColor);
                $listaIDS=$listaIDS."_".$producto["idproducto"];
                $listaCODIGOS=$listaCODIGOS."_".$producto["codigo"];
                $listaDESCRIPCIONES=$listaDESCRIPCIONES."_".$producto["descripcion"];
                $listaCOLORES=$listaCOLORES."_".$color["nombre"];
                if($_POST["tipo"]==1){
                    $listaPRECIOS=$listaPRECIOS."_".$precio; 
                }else{
                    $listaPRECIOS=$listaPRECIOS."_0"; 
                }
                $listaUNIDADES=$listaUNIDADES."_".$piezas;                
                $cuenta++;                
            } else{
                echo "------------------>".$i."</br>";
            }            
        }                   
    }
    echo "<input type='hidden' name='oculto01' id='oculto01' value='".$cuenta."'/>";
    echo "<input type='hidden' name='oculto02' id='oculto02' value='".$listaIDS."'/>";
    echo "<input type='hidden' name='oculto03' id='oculto03' value='".$listaCODIGOS."'/>";
    echo "<input type='hidden' name='oculto04' id='oculto04' value='".$listaDESCRIPCIONES."'/>";
    echo "<input type='hidden' name='oculto05' id='oculto05' value='".$listaCOLORES."'/>";
    echo "<input type='hidden' name='oculto06' id='oculto06' value='".$listaPRECIOS."'/>";
    echo "<input type='hidden' name='oculto07' id='oculto07' value='".$listaUNIDADES."'/>";
?>