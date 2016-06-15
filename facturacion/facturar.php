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
    
    $RFCfacturacion="GOYA780416GM0";
    
    $file = fopen("temporal/".$_GET["id"].".txt", "w");
    fwrite($file, "|EMISOR|".$RFCfacturacion."|Regimen General de Ley Personas Morales|" . PHP_EOL);
    fwrite($file, "|RECEPTOR|".$empresa["identificador"]."|".$empresa["nombreempresa"]."|".$empresa["fiscalcalle"]."|".$empresa["fiscalexterior"]."|".$empresa["fiscalinterior"]."|".$empresa["fiscalcolonia"]."|||".$empresa["fiscalciudad"]."|".$empresa["fiscalestado"]."|".$pais["nombre"]."|".$empresa["fiscalpostal"]."|" . PHP_EOL);
    fwrite($file, "|COMPROBANTE|3.2|Sin Serie|".date("Y")."-".date("m")."-".date("d")." ".  date("H").":".date("i").":".date("s")."|Pago en Una Sola Exhibicion|".$orden["subtotal"]."|".$orden["total"]."|Transferencia Electrónica|Ingreso|USD|".$configuracion["cambio"]."||".$iva."||100|El cambio de Dolares Americanos a Pesos Mexicanos es ".$configuracion["cambio"]."|FALSE|micorreo@pruebascorreo.com|||FACTURA|".$empresa["ultimos"]."|" . PHP_EOL);
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

    $aux1="";
    $band1=0;
    for($i=0;$i<20;$i++){
        if($band1==0){
            sleep(6);
            $directorio = opendir("salidapdf/GOYA780416GM0/"); //ruta actual
            while ($archivo = readdir($directorio)) //obtenemos un archivo y luego otro sucesivamente
            {   
                if($band1==0){
                    if($archivo!="." && $archivo!=".."){
                        $divide =  explode("-",$archivo);
                        if($divide[2]==($configuracion["folio"]+1)){
                            $aux1=$archivo;
                            $band1=1;                            
                        }                        
                    }
                }
            }
        }
    }
    
    $aux2="";
    $band2=0;
    for($i=0;$i<20;$i++){
        if($band2==0){
            sleep(6);
            $directorio = opendir("salidaxml/GOYA780416GM0/"); //ruta actual
            while ($archivo = readdir($directorio)) //obtenemos un archivo y luego otro sucesivamente
            {   
                if($band2==0){
                    if($archivo!="." && $archivo!=".."){
                        $principal = explode(".",$archivo);
                        if($principal[1]=="xml"){
                            $divide = explode("-",$archivo);
                            if($divide[2]==($configuracion["folio"]+1)){
                                $aux2=$archivo;
                                $band2=1;                           
                            } 
                        }
                    }
                }
            }
        }
    } 
    
    if($band1==1 && $band2==1){       
        $sql_insertFactura="insert into factura (idagenda,idempresa,idordendecompra,emision,serie,folio,subtotal,poriva,iva,total,pdf,xml) values('".$orden["idagenda01"]."','".$orden["idempresa"]."','".$orden["idordendecompra"]."',now(),'".$configuracion["serie"]."','".($configuracion["folio"]+1)."','".$orden["subtotal"]."','".$orden["poriva"]."','".$orden["iva"]."','".$orden["total"]."','".$aux1."','".$aux2."')";
        $result_insertFactura=mysql_query($sql_insertFactura,$con) or die(mysql_error());
        
        $sql_update="update configuracionsistema set folio='".($configuracion["folio"]+1)."' where idconfiguracionsistema=1";
        $result_update=mysql_query($sql_update,$con) or die(mysql_error()); 
        ?>
            <script language="javascript">
                window.open('descargapdf.php?folio=<?php echo ($configuracion["folio"]+1) ?>', '_blank');
                window.open('descargaxml.php?folio=<?php echo ($configuracion["folio"]+1) ?>', '_blank');
                window.close();
            </script>
        <?php                                                                           
    }