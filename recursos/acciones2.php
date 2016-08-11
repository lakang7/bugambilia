<?php session_start(); ?>
<meta charset="UTF-8">
<?php 
    require_once("funciones.php");
    $con=Conexion();
    $tarea=$_GET["tarea"];
    
    /*Insertar orden de produccion desde una Orden de comrpa*/
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
        if($ORDEN["conpago"]==2){
            $subTotal=0;
        }
        $poriva=$configuracion["poriva"];
        $iva=$subTotal*($poriva/100);
        $total=$subTotal+$iva;
                        
        $auxSucursal="";
        $auxEstado="";
        $sql_insertProduccion = "";
        
        if($ORDEN["idsucursal"]!=NULL && $ORDEN["idsucursal"]!=""){
            if($ORDEN["idestado"]!=NULL && $ORDEN["idestado"]!="" ){
                $sql_insertProduccion = "insert into ordendeproduccion (idordendecompra,codigoop,fechadecreacion,fechaderegistro,idempresa,idsucursal,idestado,idagenda01,idagenda02,idagenda03,idlistadeprecios,idusuariocrea,idusuarioresponsable,subtotal,poriva,iva,total,prioridad,fechadeentrega,tipoempaque,estatus) values ('".$_GET["idorden"]."','".$ORDEN["codigoop"]."',now(),now(),'".$ORDEN["idempresa"]."','".$ORDEN["idsucursal"]."','".$ORDEN["idestado"]."','".$ORDEN["idagenda01"]."','".$ORDEN["idagenda02"]."','".$ORDEN["idagenda03"]."','".$ORDEN["idlistadeprecios"]."','".$_SESSION["usuario"]."','".$_GET["idcontacto"]."','".$subTotal."','".$poriva."','".$iva."','".$total."','".$ORDEN["prioridad"]."','".$ORDEN["fechadeentrega"]."','".$_GET["tipo"]."','1');";
            }else{
                $sql_insertProduccion = "insert into ordendeproduccion (idordendecompra,codigoop,fechadecreacion,fechaderegistro,idempresa,idsucursal,idagenda01,idagenda02,idagenda03,idlistadeprecios,idusuariocrea,idusuarioresponsable,subtotal,poriva,iva,total,prioridad,fechadeentrega,tipoempaque,estatus) values ('".$_GET["idorden"]."','".$ORDEN["codigoop"]."',now(),now(),'".$ORDEN["idempresa"]."','".$ORDEN["idsucursal"]."','".$ORDEN["idagenda01"]."','".$ORDEN["idagenda02"]."','".$ORDEN["idagenda03"]."','".$ORDEN["idlistadeprecios"]."','".$_SESSION["usuario"]."','".$_GET["idcontacto"]."','".$subTotal."','".$poriva."','".$iva."','".$total."','".$ORDEN["prioridad"]."','".$ORDEN["fechadeentrega"]."','".$_GET["tipo"]."','1');";
            }
        }else{
            $sql_insertProduccion = "insert into ordendeproduccion (idordendecompra,codigoop,fechadecreacion,fechaderegistro,idempresa,idagenda01,idagenda02,idagenda03,idlistadeprecios,idusuariocrea,idusuarioresponsable,subtotal,poriva,iva,total,prioridad,fechadeentrega,tipoempaque,estatus) values ('".$_GET["idorden"]."','".$ORDEN["codigoop"]."',now(),now(),'".$ORDEN["idempresa"]."','".$ORDEN["idagenda01"]."','".$ORDEN["idagenda02"]."','".$ORDEN["idagenda03"]."','".$ORDEN["idlistadeprecios"]."','".$_SESSION["usuario"]."','".$_GET["idcontacto"]."','".$subTotal."','".$poriva."','".$iva."','".$total."','".$ORDEN["prioridad"]."','".$ORDEN["fechadeentrega"]."','".$_GET["tipo"]."','1');";
        }
           	
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
                $sql_insertProducto = "";
                if($ORDEN["conpago"]==1){
                    $sql_insertProducto = "insert into productosordenproduccion (idordendeproduccion,idproducto,idcolor,preciofabrica,numerodeunidades) values('".$indice."','".$producto["idproducto"]."','".$producto["idcolor"]."','".$producto["preciofabrica"]."','".$producto["numerodeunidades"]."')";
                }else if($ORDEN["conpago"]==2){
                    $sql_insertProducto = "insert into productosordenproduccion (idordendeproduccion,idproducto,idcolor,preciofabrica,numerodeunidades) values('".$indice."','".$producto["idproducto"]."','".$producto["idcolor"]."','0','".$producto["numerodeunidades"]."')";        
                }                
                $result_Producto = mysql_query($sql_insertProducto,$con) or die(mysql_error());
            }
        } 
        
        $sql_insertRegalias="insert into regalias (idordendeproduccion,monto,cancelado,resta,fechadecreacion,idempresa) values('".$indice."','".number_format(round(($total*0.10),2),2)."','0','".number_format(round(($total*0.10),2),2)."',now(),'".$ORDEN["idempresa"]."')";
        $result_insertRegalias=mysql_query($sql_insertRegalias,$con) or die(mysql_error());
        
    ?>
        <script type="text/javascript">
            alert("Orden de Producción Generada Satisfactoriamente desde la Orden de Compra <?php echo $ORDEN["codigoexterno"]; ?>.");
            document.location="../listarordenesdeproduccion.php";
        </script>
    <?php         
        
    }
    
    /*insertar orden de prodcucción desde el formulario*/
    if($tarea==18){ 
        $sql_insertOrden = "";
        if (isset($_POST["sucursal"]) && isset($_POST["region"])) {
            $sql_insertOrden = "insert into ordendeproduccion (fechadecreacion,fechaderegistro,idempresa,idsucursal,idestado,idagenda01,idagenda02,idagenda03,idlistadeprecios,idusuariocrea,idusuarioresponsable,codigoop,subtotal,poriva,iva,total,prioridad,fechadeentrega) values(now(),'" . $_POST["id-date-picker-1"] . "','" . $_POST["empresa"] . "','" . $_POST["sucursal"] . "','" . $_POST["region"] . "','" . $_POST["contacto01"] . "','" . $_POST["contacto02"] . "','" . $_POST["contacto03"] . "','" . $_POST["lista"] . "','".$_SESSION["usuario"]."','".$_POST["contacto"]."','" . $_POST["codigo02"] . "',0,0,0,0,'" . $_POST["prioridad"] . "',now())";
        } else {
            $sql_insertOrden = "insert into ordendeproduccion (fechadecreacion,fechaderegistro,idempresa,idagenda01,idagenda02,idagenda03,idlistadeprecios,idusuariocrea,idusuarioresponsable,codigoop,subtotal,poriva,iva,total,prioridad,fechadeentrega) values(now(),'" . $_POST["id-date-picker-1"] . "','" . $_POST["empresa"] . "','" . $_POST["contacto01"] . "','" . $_POST["contacto02"] . "','" . $_POST["contacto03"] . "','" . $_POST["lista"] . "','".$_SESSION["usuario"]."','".$_POST["contacto"]."','" . $_POST["codigo02"] . "',0,0,0,0,'" . $_POST["prioridad"] . "',now())";
        }
        
        $result_insertOrden = mysql_query($sql_insertOrden, $con) or die(mysql_error());  
        
        $aux = explode("-", $_POST["codigo02"]);
        $nuevoCodigo = ($aux[1] + 1);
        
        $sqlupdateConfiguracion = "update configuracionsistema set secuenciaop='" . $nuevoCodigo . "' where idconfiguracionsistema=1";
        $resultupdateConfiguracion = mysql_query($sqlupdateConfiguracion, $con) or die(mysql_error()); 
        
        $sql_ultimaOrden = "SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'bugambiliasis' AND TABLE_NAME = 'ordendeproduccion';";
        $result_ultimaOrden = mysql_query($sql_ultimaOrden, $con) or die(mysql_error());
        $fila = mysql_fetch_assoc($result_ultimaOrden);
        $indice = intval($fila["AUTO_INCREMENT"]);
        $indice--;
        
        $productos = $_POST["oculto01"];
        $listaIds = explode("_", $_POST["oculto02"]);
        $listaCodigos = explode("_", $_POST["oculto03"]);
        $listaDescripciones = explode("_", $_POST["oculto04"]);
        $listaColores = explode("_", $_POST["oculto05"]);
        $listaPrecios = explode("_", $_POST["oculto06"]);
        $listaUnidades = explode("_", $_POST["oculto07"]);


        $subTotal = 0;
        $poriva = 0;
        $total = 0;
        $iva = 0;

        $materiales = array();

        for ($i = 0; $i < count($listaIds); $i++) {
            if ($listaIds[$i] != "") {
                $sql_precio = "select preciofabrica,idmaterial from producto where idproducto='" . $listaIds[$i] . "'";
                $result_precio = mysql_query($sql_precio, $con) or die(mysql_error());
                if (mysql_num_rows($result_precio) > 0) {
                    $precio = mysql_fetch_assoc($result_precio);
                    $banderina = 0;
                    for ($j = 0; $j < count($materiales); $j++) {
                        if ($materiales[$j] == $precio["idmaterial"]) {
                            $banderina = 1;
                        }
                    }
                        if ($banderina == 0) {
                        $materiales[count($materiales)] = $precio["idmaterial"];
                    }
                    $sql_color = "select * from color where nombre='" . $listaColores[$i] . "'";
                    $result_color = mysql_query($sql_color, $con) or die(mysql_error());
                    $color = mysql_fetch_assoc($result_color);
                    $subTotal+=($listaUnidades[$i] * $listaPrecios[$i]);
                    $sql_insProducto = "insert into productosordenproduccion (idordendeproduccion,idproducto,idcolor,preciofabrica,numerodeunidades) values('" . $indice . "','" . $listaIds[$i] . "','" . $color["idcolor"] . "','" . $precio["preciofabrica"] . "','" . $listaUnidades[$i] . "')";
                    $result_insProducto = mysql_query($sql_insProducto, $con) or die(mysql_error());
                }
            }
        }
        
        if ($_POST["appiva"] == "S") {
            $poriva = $_POST["poriva"];
            $iva = $subTotal * ($poriva / 100);
            $total = $subTotal + $iva;
        } else if ($_POST["appiva"] == "N") {
            $total = $subTotal;
        }

        $sql_updateOrdenCompra = "update ordendeproduccion set subtotal='" . $subTotal . "',poriva='" . $poriva . "',iva='" . $iva . "',total='" . $total . "' where idordendeproduccion='" . $indice . "'";
        $result_updateOrdenCompra = mysql_query($sql_updateOrdenCompra, $con) or die(mysql_error());  
        
    /* Se suman de 28 a 42 días dependiendo de los tipos de productos */
    if ($_POST["prioridad"] == 1) {
        $mayor = -999999;
        for ($j = 0; $j < count($materiales); $j++) {
            $sqlSelMaterial = "select * from material where idmaterial='" . $materiales[$j] . "'";
            $resultSelMaterial = mysql_query($sqlSelMaterial, $con) or die(mysql_error());
            $material = mysql_fetch_assoc($resultSelMaterial);
            if ($material["dias"] > $mayor) {
                $mayor = $material["dias"];
            }
        }
        $nuevafecha = new DateTime($_POST["id-date-picker-1"]);
        $nuevafecha->modify('+' . $mayor . ' day');

        $sql_updateOrdenCompra = "update ordendeproduccion set fechadeentrega='" . $nuevafecha->format('Y-m-d') . "' where idordendeproduccion='" . $indice . "'";
        $result_updateOrdenCompra = mysql_query($sql_updateOrdenCompra, $con) or die(mysql_error());
    } else if ($_POST["prioridad"] == 2) { /* Se establece una fecha fija de entrega */
        $sql_updateOrdenCompra = "update ordendeproduccion set fechadeentrega='" . $_POST["id-date-picker-2"] . "' where idordendeproduccion='" . $indice . "'";
        $result_updateOrdenCompra = mysql_query($sql_updateOrdenCompra, $con) or die(mysql_error());
    }        
        
    
        
    }    
    
?>