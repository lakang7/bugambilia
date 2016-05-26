<?php session_start(); ?>
<meta charset="UTF-8">
<?php 
    require_once("funciones.php");
    $con=Conexion();
    $tarea=$_GET["tarea"];
    
    /*Validar Login*/
    if($tarea==17){ 
        
        $sqlConfiguracion = "select * from configuracionsistema where idconfiguracionsistema=1";
        $result_Configuracion = mysql_query($sqlConfiguracion, $con) or die(mysql_error());
        if (mysql_num_rows($result_Configuracion) > 0) {
             $configuracion = mysql_fetch_assoc($result_Configuracion);
        }        
        
        $sqlORDENCOMPRA = "select * from ordendecompra where idordendecompra='".$_GET["idorden"]."'";
        $resultORDENCOMPRA = mysql_query($sqlORDENCOMPRA, $con) or die(mysql_error());
        $ORDEN = mysql_fetch_assoc($resultORDENCOMPRA);
                   
        
        $subTotal=0;
        $sql_listaPRODUCTOS="select * from productosordencompra where idordendecompra='".$_GET["idorden"]."'";
        $result_listaPRODUCTOS=mysql_query($sql_listaPRODUCTOS,$con) or die(mysql_error());
        if(mysql_num_rows($result_listaPRODUCTOS)>0){
            while ($producto = mysql_fetch_assoc($result_listaPRODUCTOS)) {
                $subTotal+=$producto["preciofabrica"]*$producto["numerodeunidades"];
                
            }
        }
        $poriva=$configuracion["poriva"];
        $iva=$subTotal*($poriva/100);
        $total=$subTotal+$iva;
                        
        $sql_insertProduccion = "insert into ordendeproduccion (idordendecompra,idagenda,fechaderegistro,subtotal,poriva,iva,total,codigoop) values ('".$_GET["idorden"]."','".$_SESSION["usuario"]."',now(),'".$subTotal."','".$poriva."','".$iva."','".$total."','".$ORDEN["codigoop"]."');";
	$result_insertProduccion = mysql_query($sql_insertProduccion,$con) or die(mysql_error());  
        
        $sql_ultimoMATERIAL="SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'bugambiliasis' AND TABLE_NAME = 'ordendeproduccion';";
        $result_ultimoMATERIAL=mysql_query($sql_ultimoMATERIAL,$con) or die(mysql_error());	
        $fila = mysql_fetch_assoc($result_ultimoMATERIAL);
        $indice=intval($fila["AUTO_INCREMENT"]);            
        $indice--;        
        
        $sql_listaPRODUCTOS="select * from productosordencompra where idordendecompra='".$_GET["idorden"]."'";
        $result_listaPRODUCTOS=mysql_query($sql_listaPRODUCTOS,$con) or die(mysql_error());
        if(mysql_num_rows($result_listaPRODUCTOS)>0){
            while ($producto = mysql_fetch_assoc($result_listaPRODUCTOS)) {
                $sql_insertProducto = "insert into productosordenproduccion (idordendeproduccion,idproducto,idcolor,preciofabrica,numerodeunidades) values('".$indice."','".$producto["idproducto"]."','".$producto["idcolor"]."','".$producto["preciofabrica"]."','".$producto["numerodeunidades"]."')";
                $result_Producto = mysql_query($sql_insertProducto,$con) or die(mysql_error());
            }
        }        
        
    }
    
?>