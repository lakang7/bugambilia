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
    
    
    $file = fopen("temporal/".$_GET["id"].".txt", "w");
    fwrite($file, "|EMISOR|".$configuracion["facturacionrfc"]."|Regimen de pequeño contribuyente|" . PHP_EOL);
    fwrite($file, "|RECEPTOR|".$empresa["identificador"]."|".$empresa["nombreempresa"]."|".$empresa["fiscalcalle"]."|".$empresa["fiscalexterior"]."|".$empresa["fiscalinterior"]."|".$empresa["fiscalcolonia"]."|||".$empresa["fiscalciudad"]."|".$empresa["fiscalestado"]."|".$pais["nombre"]."|".$empresa["fiscalpostal"]."|" . PHP_EOL);
    fwrite($file, "|COMPROBANTE|3.2|Sin Serie|".date("Y")."-".date("m")."-".date("d")." ".  date("H").":".date("i").":".date("s")."|PAGO EN UNA SOLA EXHIBICION|810.00|939.60|Tarjeta de débito|Ingreso|PESOS|1.00||16||100|Factura con descuento|FALSE|micorreo@pruebascorreo.com|||FACTURA|0123|" . PHP_EOL);
    fwrite($file, "|EXPEDIDOEN|01|Desconocida|".$configuracion["facturacioncalle"]."|".$configuracion["facturacionext"]."|".$configuracion["facturacionint"]."|".$configuracion["facturacioncolonia"]."|||Monterrey|Nuevo León|MEXICO|".$configuracion["facturacionpostal"]."|" . PHP_EOL);
    
    $sqlProductos="select * from productosordencompra where idordendecompra='".$_GET["id"]."'";
    $resultProductos=mysql_query($sqlProductos,$con) or die(mysql_error());    
    if(mysql_num_rows($resultProductos)>0){
        while ($producto = mysql_fetch_assoc($resultProductos)) {
            $sqlproducto="select * from producto where idproducto='".$producto["idproducto"]."'";
            $resultproducto=mysql_query($sqlproducto,$con) or die(mysql_error());             
            $prod = mysql_fetch_assoc($resultproducto);
            fwrite($file,"|CONCEPTO|".$producto["numerodeunidades"]."|Pieza|".$prod["codigo"]."|".$prod["descripcion"]."|900.00|900.00|IVA|16|129.60|||" . PHP_EOL);
        }
    }
    
    
    
    
    fclose($file);   

?>