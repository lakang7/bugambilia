<?php
    //echo $_GET["id"];
    require_once("../recursos/funciones.php");
    $con=Conexion();
    
    $sql_orden="select * from ordendecompra where idordendecompra='".$_GET["id"]."'";
    $result_orden=mysql_query($sql_orden,$con) or die(mysql_error());
    if(mysql_num_rows($result_orden)>0){
       $orden = mysql_fetch_assoc($result_orden);                                
    }    
    
    $sql_empresa="select * from empresa where idempresa='".$orden["idempresa"]."'";
    $result_empresa=mysql_query($sql_empresa,$con) or die(mysql_error()); 
    if(mysql_num_rows($result_empresa)>0){
       $empresa = mysql_fetch_assoc($result_empresa);                                
    }
    
    $sql_pais="select * from pais where idpais='".$empresa["idpais"]."'";
    $result_pais=mysql_query($sql_pais,$con) or die(mysql_error());
    if(mysql_num_rows($result_pais)>0){
       $pais = mysql_fetch_assoc($result_pais);                                
    }    
    
    $sql_configuracion="select * from configuracionsistema where idconfiguracionsistema=1";
    $result_configuracion=mysql_query($sql_configuracion,$con) or die(mysql_error()); 
    if(mysql_num_rows($result_configuracion)>0){
       $configuracion = mysql_fetch_assoc($result_configuracion);                                
    }    
    
    $iva=0;
    if($empresa["iva"]==1){
        $iva=round($configuracion["poriva"],2);
    }
    
    $archivosPDF = array();
    $directorio = opendir("salidapdf/".$configuracion["carpetabusqueda"]."/"); //ruta actual
    while ($archivo = readdir($directorio)) //obtenemos un archivo y luego otro sucesivamente
    {   
        if($archivo!="." && $archivo!=".."){
             $archivosPDF[count($archivosPDF)]=$archivo;          
        }        
    } 
    
    $archivosXML = array();    
    $directorio = opendir("salidaxml/".$configuracion["carpetabusqueda"]."/"); //ruta actual
    while ($archivo = readdir($directorio)) //obtenemos un archivo y luego otro sucesivamente
    {   
        if($archivo!="." && $archivo!=".."){
            $principal = explode(".",$archivo);
            if($principal[1]=="xml"){
                $archivosXML[count($archivosXML)]=$archivo;             
            }
        }                
    }    
    
    $RFCfacturacion="GOYA780416GM0";
    $RFCReceptor="";
    if($empresa["idpais"]==1){
        $RFCReceptor=$empresa["identificador"];
    }else{
        $RFCReceptor=$configuracion["rfcextranjero"];
    }
    
    $file = fopen("temporal/".$_GET["id"].".txt", "w");
    fwrite($file, "|EMISOR|".$RFCfacturacion."|Regimen General de Ley Personas Morales|" . PHP_EOL);
    fwrite($file, "|RECEPTOR|".$RFCReceptor."|".$empresa["nombreempresa"]."|".$empresa["fiscalcalle"]."|".$empresa["fiscalexterior"]."|".$empresa["fiscalinterior"]."|".$empresa["fiscalcolonia"]."|||".$empresa["fiscalciudad"]."|".$empresa["fiscalestado"]."|".$pais["nombre"]."|".$empresa["fiscalpostal"]."|" . PHP_EOL);
    fwrite($file, "|COMPROBANTE|3.2|Sin Serie|".date("Y")."-".date("m")."-".date("d")." ".  date("H").":".date("i").":".date("s")."|Pago en Una Sola Exhibicion|".$orden["subtotal"]."|".$orden["total"]."|Transferencia Electrónica|Ingreso|USD|".$configuracion["cambio"]."||".$iva."||100|El cambio de Dolares Americanos a Pesos Mexicanos es ".$configuracion["cambio"].", Orden de Compra: ".$orden["codigoexterno"].", Orden de Producción: ".$orden["codigoop"]."|FALSE|micorreo@pruebascorreo.com|||FACTURA|".$empresa["ultimos"]."|" . PHP_EOL);
    fwrite($file, "|EXPEDIDOEN|01|Desconocida|".$configuracion["facturacioncalle"]."|".$configuracion["facturacionext"]."|".$configuracion["facturacionint"]."|".$configuracion["facturacioncolonia"]."|||".$configuracion["facturacionestpais"]."||MEXICO|".$configuracion["facturacionpostal"]."|" . PHP_EOL);
    
    $sqlProductos="select * from productosordencompra where idordendecompra='".$_GET["id"]."'";
    $resultProductos=mysql_query($sqlProductos,$con) or die(mysql_error());    
    if(mysql_num_rows($resultProductos)>0){
        while ($producto = mysql_fetch_assoc($resultProductos)) {
            $sqlproducto="select * from producto where idproducto='".$producto["idproducto"]."'";
            $resultproducto=mysql_query($sqlproducto,$con) or die(mysql_error());             
            $prod = mysql_fetch_assoc($resultproducto);
            
            $sqlcolor="select * from color where idcolor='".$producto["idcolor"]."'";
            $resultcolor=mysql_query($sqlcolor,$con) or die(mysql_error());             
            $color = mysql_fetch_assoc($resultcolor);            
            
            
            fwrite($file,"|CONCEPTO|".$producto["numerodeunidades"]."|Pieza|".$prod["codigo"]."|".$prod["codigo"]." ".$color["codigo"]." ".$prod["descripcion"]."|".round($producto["precioventa"],2)."|".round(($producto["numerodeunidades"]*$producto["precioventa"]),2)."|IVA|".$iva."|".round((($producto["numerodeunidades"]*$producto["precioventa"])*($iva/100)),2)."|||" . PHP_EOL);
        }
    }                
    fclose($file);   
    
    copy("temporal/".$_GET["id"].".txt","paraprocesar/".$_GET["id"].".txt");

    
    
    $band1=0;
    for($h=0;$h<40;$h++){
        if($band1==0){
            sleep(6);
    
            $archivosPDF2 = array();
            $directorio = opendir("salidapdf/".$configuracion["carpetabusqueda"]."/"); //ruta actual
            while ($archivo = readdir($directorio)) //obtenemos un archivo y luego otro sucesivamente
            {   
                if($archivo!="." && $archivo!=".."){
                     $archivosPDF2[count($archivosPDF2)]=$archivo;          
                }        
            } 
    
            $archivosXML2 = array();    
            $directorio = opendir("salidaxml/".$configuracion["carpetabusqueda"]."/"); //ruta actual
            while ($archivo = readdir($directorio)) //obtenemos un archivo y luego otro sucesivamente
            {       
                if($archivo!="." && $archivo!=".."){
                    $principal = explode(".",$archivo);
                    if($principal[1]=="xml"){
                        $archivosXML2[count($archivosXML2)]=$archivo;             
                    }
                }                
            }
        
            $aux01="";
            $aux02="";
            $posicion01=-1;
            $posicion02=-1;
            if(count($archivosPDF2)>count($archivosPDF)){
                for($i=0;$i<count($archivosPDF2);$i++){
                    if($posicion01==-1){
                        $encuentra=0;
                        for($j=0;$j<count($archivosPDF);$j++){
                            if($archivosPDF2[$i]==$archivosPDF[$j]){
                                $encuentra=1;
                            }
                        }            
                        if($encuentra==0){
                            $posicion01=$i;
                        }
                    }
                }        
            }
    
            if(count($archivosXML2)>count($archivosXML)){
                for($i=0;$i<count($archivosXML2);$i++){
                    if($posicion02==-1){
                        $encuentra=0;
                        for($j=0;$j<count($archivosXML);$j++){
                            if($archivosXML2[$i]==$archivosXML[$j]){
                                $encuentra=1;
                            }
                        }            
                        if($encuentra==0){
                            $posicion02=$i;
                        }
                    }
                }        
            }    
            
            echo "El valor de la posicion01 es: ".$posicion01." y el de la posicion02 es: ".$posicion02."</br>";
            if($posicion01>=0 && $posicion02>=0){
                $band1=1;
            }            
        }
    }
    
    echo "</br>El valor de la band1 es: ".$band1;

    
    if($band1==1){
    
        $listaBusca=explode("-",$archivosPDF2[$posicion01]);
        $serieEncontrada=$listaBusca[1];
        $folioEncontrado=$listaBusca[2];
    
        echo "Archivo 01: ".$archivosPDF2[$posicion01]."</br>";
        echo "Archivo 02: ".$archivosXML2[$posicion02]."</br>";
        echo "Serie: ".$serieEncontrada."</br>";
        echo "Folio: ".$folioEncontrado."</br>";
    
        $sql_insertFactura="insert into factura (idagenda,idempresa,idordendecompra,emision,serie,folio,subtotal,poriva,iva,total,pdf,xml,resta,estatus) values('".$orden["idagenda01"]."','".$orden["idempresa"]."','".$orden["idordendecompra"]."',now(),'".$serieEncontrada."','".$folioEncontrado."','".$orden["subtotal"]."','".$orden["poriva"]."','".$orden["iva"]."','".$orden["total"]."','".$archivosPDF2[$posicion01]."','".$archivosXML2[$posicion02]."','".$orden["total"]."','1')";
        $result_insertFactura=mysql_query($sql_insertFactura,$con) or die(mysql_error());
        
        $sql_update="update configuracionsistema set folio='".$folioEncontrado."' where idconfiguracionsistema=1";
        $result_update=mysql_query($sql_update,$con) or die(mysql_error()); 
        ?>
            <script language="javascript">
                window.open('descargapdf.php?folio=<?php echo ($folioEncontrado) ?>', '_blank');
                window.open('descargaxml.php?folio=<?php echo ($folioEncontrado) ?>', '_blank');
                window.close();
            </script>
        <?php         
    
    
    }
    
