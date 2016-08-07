<?php
    require_once('../recursos/phpexcel/Classes/PHPExcel.php');
    require_once('../recursos/funciones.php');
    $con= Conexion();
    $XLFileType = PHPExcel_IOFactory::identify('../recursos/listadeprecios/MASTER Lista Sistema Lak.xlsx');  
    $objReader = PHPExcel_IOFactory::createReader($XLFileType);  
    $objReader->setLoadSheetsOnly('Hoja1');  
    $objPHPExcel = $objReader->load('../recursos/listadeprecios/MASTER Lista Sistema Lak.xlsx');  

    //Aqui viene lo que te interesa 
    $limitefilas=800;
    $objWorksheet = $objPHPExcel->setActiveSheetIndexByName('Hoja1');  
    for($i=11;$i<$limitefilas;$i++){
        $codigoproducto=  trim($objPHPExcel->getActiveSheet()->getCell('B'.$i)->getFormattedValue());
        $tipoproducto=trim($objPHPExcel->getActiveSheet()->getCell('E'.$i)->getFormattedValue());
        $formaproducto=trim($objPHPExcel->getActiveSheet()->getCell('F'.$i)->getFormattedValue());
        $patronproductoesp=trim($objPHPExcel->getActiveSheet()->getCell('G'.$i)->getFormattedValue());
        $patronproductoing=trim($objPHPExcel->getActiveSheet()->getCell('H'.$i)->getFormattedValue());
        $nompreproductoesp=trim($objPHPExcel->getActiveSheet()->getCell('J'.$i)->getFormattedValue());
        $nompreproductoing=trim($objPHPExcel->getActiveSheet()->getCell('I'.$i)->getFormattedValue());
        $largoproducto=trim($objPHPExcel->getActiveSheet()->getCell('P'.$i)->getFormattedValue());
        $anchoproducto=trim($objPHPExcel->getActiveSheet()->getCell('Q'.$i)->getFormattedValue());
        $altoproducto=trim($objPHPExcel->getActiveSheet()->getCell('R'.$i)->getFormattedValue());
        $capacidadproducto=trim($objPHPExcel->getActiveSheet()->getCell('S'.$i)->getFormattedValue());
        $pesoproducto=trim($objPHPExcel->getActiveSheet()->getCell('T'.$i)->getFormattedValue());
        $precioproducto=trim($objPHPExcel->getActiveSheet()->getCell('U'.$i)->getFormattedValue());
        $regaliasproducto=trim($objPHPExcel->getActiveSheet()->getCell('V'.$i)->getFormattedValue());
        $estandarizadoproducto=trim($objPHPExcel->getActiveSheet()->getCell('W'.$i)->getFormattedValue());
        
        if($codigoproducto!="" && $tipoproducto!="" && $formaproducto!="" && $patronproductoesp!="" && is_numeric($precioproducto) && is_numeric($largoproducto) && is_numeric($anchoproducto) && is_numeric($altoproducto)){
            $materiales="";
            $idmaterial="";
            if($tipoproducto=="CATVIEJO15" || $tipoproducto=="CATNUEVO16" || $tipoproducto=="ESPECIALES"){
                $materiales="Clasico";
                $idmaterial=1;
            }else if($tipoproducto=="ANODIZADOA"){
                $materiales="Anodizado";
                $idmaterial=2;
            }            
            $sqlpatronproducto="select * from patronproducto where nombreespanol='".$patronproductoesp."'";
            $resultpatronproducto=mysql_query($sqlpatronproducto,$con) or die(mysql_error());
            $IDPATRON=-1;
            if(mysql_num_rows($resultpatronproducto)==0){ /*Patron de producto no existe*/
                $sqlformaproducto="select * from categoriaproducto where nombreespanol='".$formaproducto."'";
                $resultformaproducto=mysql_query($sqlformaproducto,$con) or die(mysql_error());
                if(mysql_num_rows($resultformaproducto)>0){
                    $forma=mysql_fetch_assoc($resultformaproducto);
                    $sqlinsertpatron="insert into patronproducto (idcategoriaproducto,nombreespanol,nombreingles,materiales,registro) values('".$forma["idcategoriaproducto"]."','".$patronproductoesp."','".$patronproductoing."','".$materiales."',now());";
                    $resultinsertpatron=mysql_query($sqlinsertpatron,$con) or die(mysql_error());                
                    $sql_ultimopatron= "SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'bugambiliasis' AND TABLE_NAME = 'patronproducto';";
                    $result_ultimopatron = mysql_query($sql_ultimopatron, $con) or die(mysql_error());
                    $fila = mysql_fetch_assoc($result_ultimopatron);
                    $indice = intval($fila["AUTO_INCREMENT"]);
                    $indice--;                
                    $IDPATRON=$indice;
                    $sqlinsertmatpatron="insert into materialespatron (idpatronproducto,idmaterial) values('".$indice."','".$idmaterial."')";
                    $resultinsertmatpatron = mysql_query($sqlinsertmatpatron, $con) or die(mysql_error());                                                            
                }            
            }else if(mysql_num_rows($resultpatronproducto)>0){ /*Patron producto existe*/
                $patron=mysql_fetch_assoc($resultpatronproducto);
                $IDPATRON=$patron["idpatronproducto"];
            }
            
            $sqlBuscaProducto="select * from producto where codigo='".$codigoproducto."'";
            $resultBuscaProducto=mysql_query($sqlBuscaProducto,$con) or die(mysql_error());
            if(mysql_num_rows($resultBuscaProducto)==0){ /*Producto NO Existe*/
                $sqltipoproducto="select * from tipoproducto where codig='".$tipoproducto."'";
                $result_tipoproducto=mysql_query($sqltipoproducto,$con) or die(mysql_error());
                $tipo=mysql_fetch_assoc($result_tipoproducto);                
                
                $sql_insertProducto="insert into producto (idtipoproducto,idpatronproducto,idmaterial,codigo,descripcion,descripcioning,dimensionlargo,dimensionancho,dimensionalto,peso,capacidad,preciofabrica,registro,regalias,estandarizado) values('".$tipo["idtipoproducto"]."','".$IDPATRON."','".$idmaterial."','".$codigoproducto."','".$nompreproductoesp."','".$nompreproductoing."','".$largoproducto."','".$anchoproducto."','".$altoproducto."','".$pesoproducto."','".$capacidadproducto."','".$precioproducto."',now(),'".$regaliasproducto."','".$estandarizadoproducto."')";
                $result_insertProducto=mysql_query($sql_insertProducto,$con) or die(mysql_error());                
                $sql_ultimoproducto= "SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'bugambiliasis' AND TABLE_NAME = 'producto';";
                $result_ultimoproducto = mysql_query($sql_ultimoproducto, $con) or die(mysql_error());
                $fila = mysql_fetch_assoc($result_ultimoproducto);
                $indice = intval($fila["AUTO_INCREMENT"]);
                $indice--;
                
                if($capacidadproducto==NULL || $capacidadproducto==""){
                    $sqlUpdateProducto="update producto set capacidad=NULL where idproducto='".$indice."'";
                    $resultUpdateProducto=mysql_query($sqlUpdateProducto,$con) or die(mysql_error());  
                }
                if($pesoproducto==NULL || $pesoproducto==""){
                    $sqlUpdateProducto="update producto set peso=NULL where idproducto='".$indice."'";
                    $resultUpdateProducto=mysql_query($sqlUpdateProducto,$con) or die(mysql_error());                     
                }                
                
                $sql_insertHistoricoPF="insert into historicopreciofabrica (idproducto,preciofabrica,desde,hasta) values('".$indice."','".$precioproducto."',now(),null)";
                $result_ultimoproducto = mysql_query($sql_insertHistoricoPF, $con) or die(mysql_error());
            }else if(mysql_num_rows($resultBuscaProducto)>0){ /*Producto SI Existe*/
                $producto=mysql_fetch_assoc($resultBuscaProducto);                
                if($producto["preciofabrica"]!=$precioproducto){
                    $sql_cierraprefa = "update historicopreciofabrica set hasta = now() where hasta is null and idproducto='".$producto["idproducto"]."'";
                    $result_cierraprefa = mysql_query($sql_cierraprefa, $con) or die(mysql_error());
                    $sql_insertprefa = "insert into historicopreciofabrica (idproducto,preciofabrica,desde,hasta) values ('" . $producto["idproducto"] . "','" . $precioproducto . "',now(),NULL)";
                    $result_insertprefa = mysql_query($sql_insertprefa, $con) or die(mysql_error());
                    $sql_updateProducto = "update producto set preciofabrica='" . $precioproducto . "' where idproducto='" . $producto["idproducto"] . "'";
                    $result_updateProducto = mysql_query($sql_updateProducto, $con) or die(mysql_error());
                }
                $sqlUpdateProducto="update producto set descripcion='".$nompreproductoesp."', descripcioning='".$nompreproductoing."', dimensionlargo='".$largoproducto."', dimensionancho='".$altoproducto."', dimensionalto='".$altoproducto."', peso='".$pesoproducto."', capacidad='".$capacidadproducto."', regalias='".$regaliasproducto."', estandarizado='".$estandarizadoproducto."' where idproducto='".$producto["idproducto"]."'";
                $result_updateProducto = mysql_query($sqlUpdateProducto, $con) or die(mysql_error());
                if($capacidadproducto==NULL || $capacidadproducto==""){
                    $sqlUpdateProducto="update producto set capacidad=NULL where idproducto='".$producto["idproducto"]."'";
                    $resultUpdateProducto=mysql_query($sqlUpdateProducto,$con) or die(mysql_error());  
                }
                if($pesoproducto==NULL || $pesoproducto==""){
                    $sqlUpdateProducto="update producto set peso=NULL where idproducto='".$producto["idproducto"]."'";
                    $resultUpdateProducto=mysql_query($sqlUpdateProducto,$con) or die(mysql_error());                     
                }                 
            }
        }
    }
    
    $sql_Listas="select * from listadeprecios";
    $result_listas= mysql_query($sql_Listas, $con) or die(mysql_error());
    if(mysql_num_rows($result_listas)>0){        
        while($lista=mysql_fetch_assoc($result_listas)){        
            for($i=11;$i<$limitefilas;$i++){    
                $codigoproducto=  trim($objPHPExcel->getActiveSheet()->getCell('B'.$i)->getFormattedValue());
                $tipoproducto=trim($objPHPExcel->getActiveSheet()->getCell('E'.$i)->getFormattedValue());
                $formaproducto=trim($objPHPExcel->getActiveSheet()->getCell('F'.$i)->getFormattedValue());
                $patronproductoesp=trim($objPHPExcel->getActiveSheet()->getCell('G'.$i)->getFormattedValue());
                $patronproductoing=trim($objPHPExcel->getActiveSheet()->getCell('H'.$i)->getFormattedValue());
                $nompreproductoesp=trim($objPHPExcel->getActiveSheet()->getCell('J'.$i)->getFormattedValue());
                $nompreproductoing=trim($objPHPExcel->getActiveSheet()->getCell('I'.$i)->getFormattedValue());
                $largoproducto=trim($objPHPExcel->getActiveSheet()->getCell('P'.$i)->getFormattedValue());
                $anchoproducto=trim($objPHPExcel->getActiveSheet()->getCell('Q'.$i)->getFormattedValue());
                $altoproducto=trim($objPHPExcel->getActiveSheet()->getCell('R'.$i)->getFormattedValue());
                $capacidadproducto=trim($objPHPExcel->getActiveSheet()->getCell('S'.$i)->getFormattedValue());
                $pesoproducto=trim($objPHPExcel->getActiveSheet()->getCell('T'.$i)->getFormattedValue());
                $precioproducto=trim($objPHPExcel->getActiveSheet()->getCell('U'.$i)->getFormattedValue());
                $regaliasproducto=trim($objPHPExcel->getActiveSheet()->getCell('V'.$i)->getFormattedValue());
                $estandarizadoproducto=trim($objPHPExcel->getActiveSheet()->getCell('W'.$i)->getFormattedValue());
                $columnalistaprecio=trim($objPHPExcel->getActiveSheet()->getCell($lista["columnaprecios"].$i)->getFormattedValue());
            
                if($codigoproducto!="" && $tipoproducto!="" && $formaproducto!="" && $patronproductoesp!="" && is_numeric($precioproducto) && is_numeric($largoproducto) && is_numeric($anchoproducto) && is_numeric($altoproducto) && is_numeric($columnalistaprecio)){
                    $sqlproducto="select * from producto where codigo='".$codigoproducto."'";
                    $resultproducto= mysql_query($sqlproducto, $con) or die(mysql_error());
                    $producto=mysql_fetch_assoc($resultproducto);
                    
                    $sql_buscaregistro="select * from productoslista where idlistadeprecios='".$lista["idlistadeprecios"]."' and idproducto='".$producto["idproducto"]."'";
                    $result_buscaregistro= mysql_query($sql_buscaregistro, $con) or die(mysql_error());
                    if(mysql_num_rows($result_buscaregistro)==0){                    
                        $precio=number_format(round($columnalistaprecio,2),2);
                        $excepcion="";                
                        $sql_insertlisp="insert into productoslista (idlistadeprecios,idproducto,precio) values('".$lista["idlistadeprecios"]."','".$producto["idproducto"]."','".$precio."')";
                        if($lista["columnaexcepcion"]!=""){
                            $excepcion=number_format(round(trim($objPHPExcel->getActiveSheet()->getCell($lista["columnaexcepcion"].$i)->getFormattedValue()),2),2);
                            $sql_insertlisp="insert into productoslista (idlistadeprecios,idproducto,precio,excepcion) values('".$lista["idlistadeprecios"]."','".$producto["idproducto"]."','".$precio."','".$excepcion."')";
                        }                                
                        $result_insertlisp= mysql_query($sql_insertlisp, $con) or die(mysql_error());                                        
                    }else if(mysql_num_rows($result_buscaregistro)>0){
                        $registroencontrado=mysql_fetch_assoc($result_buscaregistro);
                        $precio=number_format(round($columnalistaprecio,2),2);  
                        $sqlUpdate="update productoslista set precio='".$precio."' where idlistadeprecios='".$registroencontrado["idproductoslista"]."'";
                        if($lista["columnaexcepcion"]!=""){
                            $excepcion=number_format(round(trim($objPHPExcel->getActiveSheet()->getCell($lista["columnaexcepcion"].$i)->getFormattedValue()),2),2);
                            $sqlUpdate="update productoslista set precio='".$precio."', excepcion='".$excepcion."' where idproductoslista='".$registroencontrado["idproductoslista"]."'";                        
                        }
                        $result_update= mysql_query($sqlUpdate, $con) or die(mysql_error());
                    }                                                                               
                }                                    
            }/*fin del for*/
        }
    }
          

?>