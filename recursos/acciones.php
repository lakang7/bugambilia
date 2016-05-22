<?php session_start(); ?>
<meta charset="UTF-8">
<?php 
    require_once("funciones.php");
    $con=Conexion();
    $tarea=$_GET["tarea"];
    
    /*Validar Login*/
    if($tarea==0){ 
        $sql_validaUsuario = "select * from usuario where usuario='".$_POST["usuario"]."' and contraseña='".$_POST["password"]."'";
	$result_validaUsuario = mysql_query($sql_validaUsuario,$con) or die(mysql_error());	
        if(mysql_num_rows($result_validaUsuario)>0){
            $usuario = mysql_fetch_assoc($result_validaUsuario);
            $_SESSION['usuario']=$usuario["idusuario"];            
            ?>
                <script type="text/javascript" language="JavaScript" >                    
                    location.href="../listarempresas.php";
                </script>
            <?php
        }else{
            ?>
                <script type="text/javascript" language="JavaScript" >
                    alert("Los datos que proporciono no son correctos, por favor veirifique su usuario y contraseña.");
                    location.href="../login.php";
                </script>
            <?php 
        }
        
    }    
    
    
    /*Insertar Empresa*/
    if($tarea==1){  
        $sql_insertEmpresa = "insert into empresa (nombreempresa,nombrecomercial,telefonoprincipal,identificador,idpais,fiscalcalle,fiscalexterior,fiscalinterior,fiscalcolonia,fiscalciudad,fiscalestado,fiscalpostal,entregacalle,entregaexterior,entregainterior,entregacolonia,entregaciudad,entregaestado,entregapostal,entregareferencia,registro,iva) values ('".$_POST["nombre"]."','".$_POST["comercial"]."','".$_POST["telefono"]."','".$_POST["rfc"]."','".$_POST["pais"]."','".$_POST["fiscalavenida"]."','".$_POST["fiscalexterior"]."','".$_POST["fiscalinterior"]."','".$_POST["fiscalcolonia"]."','".$_POST["fiscalciudad"]."','".$_POST["fiscalestado"]."','".$_POST["fiscalpostal"]."','".$_POST["entregaavenida"]."','".$_POST["entregaexterior"]."','".$_POST["entregainterior"]."','".$_POST["entregacolonia"]."','".$_POST["entregaciudad"]."','".$_POST["entregaestado"]."','".$_POST["entregapostal"]."','".$_POST["entregareferencia"]."',now(),'".$_POST["iva"]."');";
	$result_insertEmpresa = mysql_query($sql_insertEmpresa,$con) or die(mysql_error());	
        if($result_insertEmpresa){            
            $sql_ultimaEMPRESA="SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'bugambiliasis' AND TABLE_NAME = 'empresa';";
            $result_ultimaEMPRESA=mysql_query($sql_ultimaEMPRESA,$con) or die(mysql_error());	
            $fila = mysql_fetch_assoc($result_ultimaEMPRESA);
            $indice=intval($fila["AUTO_INCREMENT"]);    
            $indice--;             
            
            $sql_pais="select * from pais where idpais='".$_POST["pais"]."'";
            $result_pais=mysql_query($sql_pais,$con) or die(mysql_error());
            $pais = mysql_fetch_assoc($result_pais);            
            
            $codigo="CL";
            if($indice<10){
                $codigo=$codigo."00".$indice;
            }else if($indice>=10 && $indice<100){
                $codigo=$codigo."0".$indice;
            }else if($indice>=100){
                $codigo=$codigo.$indice;
            }
            $codigo=$codigo.$pais["identificador"];
            
            $sql_updateCodigo="update empresa set codigo='".$codigo."' where idempresa='".$indice."'";
            $result_updateCodigo=mysql_query($sql_updateCodigo,$con) or die(mysql_error());
            
            echo "Registro Satisfactorio de empresa";
        }
    }
    
    /*Insertar Sucursal*/
    if($tarea==2){
        
        $sql_insertSucursal = "insert into sucursal (idempresa,nombrecomercial) values(".$_POST["matriz"].",'".$_POST["nombresucursal"]."')";
        $result_insertSucursal = mysql_query($sql_insertSucursal,$con) or die(mysql_error());
        if($result_insertSucursal==1){                                    
            $sql_ultimaSUCURSAL="SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'bugambiliasis' AND TABLE_NAME = 'sucursal';";
            $result_ultimaSUCURSAL=mysql_query($sql_ultimaSUCURSAL,$con) or die(mysql_error());	
            $fila = mysql_fetch_assoc($result_ultimaSUCURSAL);
            $indice=intval($fila["AUTO_INCREMENT"]);    
            $indice--; 
            
            $regiones="";
            for($i=0;$i<count($_POST["regiones"]);$i++){
                $sqlinsertESTADOENSUCURSAL="insert into estadosensucursal (idsucursal,idestado) values(".$indice.",".$_POST["regiones"][$i].")";
                $result_insertESTADOENSUCURSAL = mysql_query($sqlinsertESTADOENSUCURSAL,$con) or die(mysql_error());
                
                $sql_consultaRegion="select * from estado where idestado='".$_POST["regiones"][$i]."'";
                $result_consultaRegion = mysql_query($sql_consultaRegion,$con) or die(mysql_error());
                $region = mysql_fetch_assoc($result_consultaRegion);
                if($i<(count($_POST["regiones"])-1)){
                    $regiones=$regiones.$region["nombre"].", ";
                }else{
                    $regiones=$regiones.$region["nombre"];
                }
                
            }
            
            $sql_update="update sucursal set regiones='".$regiones."' where idsucursal='".$indice."'";
            $result_update = mysql_query($sql_update,$con) or die(mysql_error());
            
            
            echo "Registro Satisfactorio de sucursal";
        }                     
    }
    
    /*Insertar Contacto*/
    if($tarea==3){
       
        $sql_insertContacto="insert into agenda (referencia,nombre,telefono1,telefono2,email) values('".$_POST["referencia"]."','".$_POST["nombre"]."','".$_POST["telefonouno"]."','".$_POST["telefonodos"]."','".$_POST["correo"]."')";
        $result_insertContacto = mysql_query($sql_insertContacto,$con) or die(mysql_error());
        
        if($result_insertContacto==1){ 
            
            $sql_ultimoAGENDA="SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'bugambiliasis' AND TABLE_NAME = 'agenda';";
            $result_ultimoAGENDA=mysql_query($sql_ultimoAGENDA,$con) or die(mysql_error());	
            $fila = mysql_fetch_assoc($result_ultimoAGENDA);
            $indice=intval($fila["AUTO_INCREMENT"]);            
            $indice--;
            
            /*Asociado a Empresa*/
            if($_POST["tipodeasociacion"]=="AE"){
                $sql_insertAsocia="insert into asociacionagenda (tipo,idagenda,idempresa) values(1,".$indice.",".$_POST["empresa"].")";
                $result_insertAsocia=mysql_query($sql_insertAsocia,$con) or die(mysql_error());
            }
            /*Asociado a Sucursal*/
            if($_POST["tipodeasociacion"]=="AS"){
                $sql_insertAsocia="insert into asociacionagenda (tipo,idagenda,idempresa,idsucursal) values(2,".$indice.",".$_POST["empresa"].",".$_POST["sucursal"].")";
                $result_insertAsocia=mysql_query($sql_insertAsocia,$con) or die(mysql_error());            
            }
            /*Asociado a Región*/
            if($_POST["tipodeasociacion"]=="AR"){
                $sql_insertAsocia="insert into asociacionagenda (tipo,idagenda,idempresa,idsucursal,idestado) values(3,".$indice.",".$_POST["empresa"].",".$_POST["sucursal"].",".$_POST["region"].")";
                $result_insertAsocia=mysql_query($sql_insertAsocia,$con) or die(mysql_error());            
            }            
            echo "Registro de Contacto Satisfactorio";
        }                                       
    } 
    
    /*Insertar Material*/
    if($tarea==4){
       
        $sql_insertMaterial="insert into material (codigo,nombre,dias) values('".$_POST["codigomaterial"]."','".$_POST["nombrematerial"]."','".$_POST["dias"]."')";
        $result_insertMaterial = mysql_query($sql_insertMaterial,$con) or die(mysql_error());
        
        if($result_insertMaterial==1){
            
            $sql_ultimoMATERIAL="SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'bugambiliasis' AND TABLE_NAME = 'material';";
            $result_ultimoMATERIAL=mysql_query($sql_ultimoMATERIAL,$con) or die(mysql_error());	
            $fila = mysql_fetch_assoc($result_ultimoMATERIAL);
            $indice=intval($fila["AUTO_INCREMENT"]);            
            $indice--;
                        
            $colores="";
            for($i=0;$i<count($_POST["colores"]);$i++){
                $sqlinsertCOLORENMATERIAL="insert into colorenmaterial (idmaterial,idcolor) values(".$indice.",".$_POST["colores"][$i].")";
                $result_insertCOLORENMATERIAL = mysql_query($sqlinsertCOLORENMATERIAL,$con) or die(mysql_error());
                
                $sql_consultaColor="select * from color where idcolor='".$_POST["colores"][$i]."'";
                $result_consultaColor = mysql_query($sql_consultaColor,$con) or die(mysql_error());
                $color = mysql_fetch_assoc($result_consultaColor);
                if($i<(count($_POST["colores"])-1)){
                    $colores=$colores.$color["nombre"].", ";
                }else{
                    $colores=$colores.$color["nombre"];
                }                                                
            } 
            
            $sql_update="update material set colores='".$colores."' where idmaterial='".$indice."'";
            $result_update = mysql_query($sql_update,$con) or die(mysql_error());
            
            echo "Registro de Material Satisfactorio";                       
        }                        
    }

    /*Insertar Producto*/
    if($tarea==5){
        
        $capacidad="NULL";
        $peso="NULL";
        
        if($_POST["capacidad"]==""){
            $capacidad="NULL";
        }else{
            $capacidad=$_POST["capacidad"];
        }
        
        if($_POST["peso"]==""){
            $peso="NULL";
        }else{
            $peso=$_POST["peso"];
        }        
        $sql_insertProducto="insert into producto (idtipoproducto,idpatronproducto,idmaterial,codigo,descripcion,dimensionlargo,dimensionancho,dimensionalto,peso,capacidad,preciofabrica) values(".$_POST["temporada"].",".$_POST["patron"].",".$_POST["material"].",'".$_POST["codigoproducto"]."','".$_POST["descripcion"]."',".$_POST["largo"].",".$_POST["ancho"].",".$_POST["alto"].",".$peso.",".$capacidad.",".$_POST["precio"].")";        
        $result_insertProducto = mysql_query($sql_insertProducto,$con) or die(mysql_error());
        
        if($result_insertProducto==1){
            
            $sql_ultimoPRODUCTO="SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'bugambiliasis' AND TABLE_NAME = 'producto';";
            $result_ultimoPRODUCTO=mysql_query($sql_ultimoPRODUCTO,$con) or die(mysql_error());	
            $fila = mysql_fetch_assoc($result_ultimoPRODUCTO);
            $indice=intval($fila["AUTO_INCREMENT"]);            
            $indice--;
            
            $sql_insertHistorico="insert into historicopreciofabrica (idproducto,preciofabrica,desde,hasta) values(".$indice.",'".$_POST["precio"]."',now(),NULL);";
            $result_insertHistorico=mysql_query($sql_insertHistorico,$con) or die(mysql_error());                          
            
            echo "Registro de Producto Satisfactorio";
        }
    }
    
    /*Insertar Patron*/
    if($tarea==6){
        
        $sql_insertPatron="insert into patronproducto (idcategoriaproducto,nombreespanol,nombreingles) values(".$_POST["tipo"].",'".$_POST["espanol"]."','".$_POST["ingles"]."')";
        $result_insertPatron = mysql_query($sql_insertPatron,$con) or die(mysql_error());
        
        if($result_insertPatron==1){
            
            $sql_ultimoPRODUCTO="SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'bugambiliasis' AND TABLE_NAME = 'patronproducto';";
            $result_ultimoPRODUCTO=mysql_query($sql_ultimoPRODUCTO,$con) or die(mysql_error());	
            $fila = mysql_fetch_assoc($result_ultimoPRODUCTO);
            $indice=intval($fila["AUTO_INCREMENT"]);            
            $indice--;
            
            $materiales="";
            for($i=0;$i<count($_POST["lineas"]);$i++){
                $sqlinsertPRODUCTOENLINEA="insert into materialespatron (idpatronproducto,idmaterial) values(".$indice.",".$_POST["lineas"][$i].")";
                $result_insertPRODUCTOENLINEA = mysql_query($sqlinsertPRODUCTOENLINEA,$con) or die(mysql_error());  
                
                $sql_consultaMaterial="select * from material where idmaterial='".$_POST["lineas"][$i]."'";
                $result_consultaMaterial = mysql_query($sql_consultaMaterial,$con) or die(mysql_error());
                $material = mysql_fetch_assoc($result_consultaMaterial);
                if($i<(count($_POST["lineas"])-1)){
                    $materiales=$materiales.$material["nombre"].", ";
                }else{
                    $materiales=$materiales.$material["nombre"];
                }                                                                
            }
            
            $sql_update="update patronproducto set materiales='".$materiales."' where idpatronproducto='".$indice."'";
            $result_update = mysql_query($sql_update,$con) or die(mysql_error());            
            
            if($_FILES['imagenpatron']['name']){
                $target_path = "C:\\xampp\\htdocs\\bugambilia\\imagenes\\productos\\";
                $target_path = $target_path . basename( $_FILES['imagenpatron']['name']); 
                if(move_uploaded_file($_FILES['imagenpatron']['tmp_name'], $target_path)) 
                {             
                    $sql_updatePRODUCTO="update patronproducto set foto='".$_FILES['imagenpatron']['name']."' where idpatronproducto='".$indice."'";
                    $result_updatePRODUCTO = mysql_query($sql_updatePRODUCTO,$con) or die(mysql_error());            
                }                 
            }                       
            
            echo "Registro de Patron Satisfactorio";
        }        
    }

    /*Editar Empresa*/
    if($tarea==7){ 	        
        $sql_updateEmpresa="update empresa set nombreempresa='".$_POST["nombre"]."', nombrecomercial='".$_POST["comercial"]."', telefonoprincipal='".$_POST["telefono"]."', identificador='".$_POST["rfc"]."', fiscalcalle='".$_POST["fiscalavenida"]."',fiscalexterior='".$_POST["fiscalexterior"]."',fiscalinterior='".$_POST["fiscalinterior"]."',fiscalcolonia='".$_POST["fiscalcolonia"]."',fiscalciudad='".$_POST["fiscalciudad"]."',fiscalestado='".$_POST["fiscalestado"]."',fiscalpostal='".$_POST["fiscalpostal"]."',entregacalle='".$_POST["entregaavenida"]."',entregaexterior='".$_POST["entregaexterior"]."',entregainterior='".$_POST["entregainterior"]."',entregacolonia='".$_POST["entregacolonia"]."',entregaciudad='".$_POST["entregaciudad"]."',entregaestado='".$_POST["entregaestado"]."',entregapostal='".$_POST["entregapostal"]."',entregareferencia='".$_POST["entregareferencia"]."',iva='".$_POST["iva"]."' where idempresa='".$_GET["id"]."'";
        $result_updateEmpresa = mysql_query($sql_updateEmpresa,$con) or die(mysql_error());
        if($result_updateEmpresa==1){
            echo "Actualización Satisfactoria de Empresa";
        }
    }    
    
    /*Editar Sucursal*/
    if($tarea==8){ 
        $sql_updateSucursal="update sucursal set nombrecomercial='".$_POST["nombresucursal"]."' where idsucursal='".$_GET["id"]."'";
        $result_updateSucursal = mysql_query($sql_updateSucursal,$con) or die(mysql_error());
        if($result_updateSucursal==1){                        
            $sql_eliminarREGIONES="delete from estadosensucursal where idsucursal='".$_GET["id"]."'";
            $result_eliminarREGIONES=mysql_query($sql_eliminarREGIONES,$con) or die(mysql_error());	            
            
            $regiones="";
            for($i=0;$i<count($_POST["regiones"]);$i++){
                $sqlinsertESTADOENSUCURSAL="insert into estadosensucursal (idsucursal,idestado) values(".$_GET["id"].",".$_POST["regiones"][$i].")";
                $result_insertESTADOENSUCURSAL = mysql_query($sqlinsertESTADOENSUCURSAL,$con) or die(mysql_error());
                
                $sql_consultaRegion="select * from estado where idestado='".$_POST["regiones"][$i]."'";
                $result_consultaRegion = mysql_query($sql_consultaRegion,$con) or die(mysql_error());
                $region = mysql_fetch_assoc($result_consultaRegion);
                if($i<(count($_POST["regiones"])-1)){
                    $regiones=$regiones.$region["nombre"].", ";
                }else{
                    $regiones=$regiones.$region["nombre"];
                }
                
            }
            
            $sql_update="update sucursal set regiones='".$regiones."' where idsucursal='".$_GET["id"]."'";
            $result_update = mysql_query($sql_update,$con) or die(mysql_error());                                    
            echo "Actualización Satisfactoria de Sucursal";
        }
    }
    
    /*Editar Contacto*/
    if($tarea==9){ 
        echo "Editar Contacto";
        $sql_updateContacto="update agenda set referencia='".$_POST["referencia"]."',nombre='".$_POST["nombre"]."',telefono1='".$_POST["telefonouno"]."',telefono2='".$_POST["telefonodos"]."',email='".$_POST["correo"]."' where idagenda='".$_GET["id"]."' ";
        $result_updateContacto = mysql_query($sql_updateContacto,$con) or die(mysql_error());
        
        $sql_eliminarASOCIACION="delete from asociacionagenda where idagenda='".$_GET["id"]."'";
        $result_eliminarASOCIACION=mysql_query($sql_eliminarASOCIACION,$con) or die(mysql_error());
        
        /*Asociado a Empresa*/
        if($_POST["tipodeasociacion"]=="AE"){
            $sql_insertAsocia="insert into asociacionagenda (tipo,idagenda,idempresa) values(1,".$_GET["id"].",".$_POST["empresa"].")";
            $result_insertAsocia=mysql_query($sql_insertAsocia,$con) or die(mysql_error());
        }
        /*Asociado a Sucursal*/
        if($_POST["tipodeasociacion"]=="AS"){
            $sql_insertAsocia="insert into asociacionagenda (tipo,idagenda,idempresa,idsucursal) values(2,".$_GET["id"].",".$_POST["empresa"].",".$_POST["sucursal"].")";
            $result_insertAsocia=mysql_query($sql_insertAsocia,$con) or die(mysql_error());            
        }
        /*Asociado a Región*/
        if($_POST["tipodeasociacion"]=="AR"){
            $sql_insertAsocia="insert into asociacionagenda (tipo,idagenda,idempresa,idsucursal,idestado) values(3,".$_GET["id"].",".$_POST["empresa"].",".$_POST["sucursal"].",".$_POST["region"].")";
            $result_insertAsocia=mysql_query($sql_insertAsocia,$con) or die(mysql_error());            
        }
        echo "Actualización Satisfactoria de Contacto";
    }  
    
    /*Editar Material*/
    if($tarea==10){         
        $sql_updateMaterial="update material set codigo='".$_POST["codigomaterial"]."',nombre='".$_POST["nombrematerial"]."',dias='".$_POST["dias"]."' where idmaterial='".$_GET["id"]."'";
        $result_updateMaterial = mysql_query($sql_updateMaterial,$con) or die(mysql_error());
        
        $sql_eliminaColores="delete from colorenmaterial where idmaterial='".$_GET["id"]."'";
        $result_eliminaColores = mysql_query($sql_eliminaColores,$con) or die(mysql_error());
        
        $colores="";
        for($i=0;$i<count($_POST["colores"]);$i++){
            $sqlinsertCOLORENMATERIAL="insert into colorenmaterial (idmaterial,idcolor) values(".$_GET["id"].",".$_POST["colores"][$i].")";
            $result_insertCOLORENMATERIAL = mysql_query($sqlinsertCOLORENMATERIAL,$con) or die(mysql_error());
                
            $sql_consultaColor="select * from color where idcolor='".$_POST["colores"][$i]."'";
            $result_consultaColor = mysql_query($sql_consultaColor,$con) or die(mysql_error());
            $color = mysql_fetch_assoc($result_consultaColor);
            if($i<(count($_POST["colores"])-1)){
                $colores=$colores.$color["nombre"].", ";
            }else{
                $colores=$colores.$color["nombre"];
            }                                                
        } 
            
        $sql_update="update material set colores='".$colores."' where idmaterial='".$_GET["id"]."'";
        $result_update = mysql_query($sql_update,$con) or die(mysql_error()); 
        
        $sql_selmaterial="select * from material where idmaterial='".$_GET["id"]."'";
        $result_selmaterial = mysql_query($sql_selmaterial,$con) or die(mysql_error()); 
        
        if(mysql_num_rows($result_selmaterial)>0){
            $material = mysql_fetch_assoc($result_selmaterial);                                                                                                                            
        }        
                        
        echo "Actualización Satisfactoria de Material";
        
    }
    
    /*Editar Patrón*/
    if($tarea==11){ 
        $sql_updatePatron="update patronproducto set idcategoriaproducto='".$_POST["tipo"]."',nombreespanol='".$_POST["espanol"]."',nombreingles='".$_POST["ingles"]."' where idpatronproducto='".$_GET["id"]."'";
        $result_updatePatron = mysql_query($sql_updatePatron,$con) or die(mysql_error());  
                
        $sql_eliminaMATPatron="delete from materialespatron where idpatronproducto='".$_GET["id"]."'";
        $result_eliminaMATPatron = mysql_query($sql_eliminaMATPatron,$con) or die(mysql_error());
        
        $materiales="";
        for($i=0;$i<count($_POST["lineas"]);$i++){
            $sqlinsertPRODUCTOENLINEA="insert into materialespatron (idpatronproducto,idmaterial) values(".$_GET["id"].",".$_POST["lineas"][$i].")";
            $result_insertPRODUCTOENLINEA = mysql_query($sqlinsertPRODUCTOENLINEA,$con) or die(mysql_error());  
                
            $sql_consultaMaterial="select * from material where idmaterial='".$_POST["lineas"][$i]."'";
            $result_consultaMaterial = mysql_query($sql_consultaMaterial,$con) or die(mysql_error());
            $material = mysql_fetch_assoc($result_consultaMaterial);
            if($i<(count($_POST["lineas"])-1)){
                $materiales=$materiales.$material["nombre"].", ";
            }else{
                $materiales=$materiales.$material["nombre"];
            }                                                                
        }
            
        $sql_update="update patronproducto set materiales='".$materiales."' where idpatronproducto='".$_GET["id"]."'";
        $result_update = mysql_query($sql_update,$con) or die(mysql_error());        
        
        
        echo "Actualización Satisfactoria de Patrón";                
    }    
    
    /*Editar producto*/
    if($tarea==12){
        $capacidad="NULL";
        $peso="NULL";
        
        if($_POST["capacidad"]==""){
            $capacidad="NULL";
        }else{
            $capacidad=$_POST["capacidad"];
        }
        
        if($_POST["peso"]==""){
            $peso="NULL";
        }else{
            $peso=$_POST["peso"];
        }        
        
        //$sql_insertProducto="insert into producto (idtipoproducto,idpatronproducto,idmaterial,codigo,descripcion,dimensionlargo,dimensionancho,dimensionalto,peso,capacidad,preciofabrica) values(".$_POST["temporada"].",".$_POST["patron"].",".$_POST["material"].",'".$_POST["codigoproducto"]."','".$_POST["descripcion"]."',".$_POST["largo"].",".$_POST["ancho"].",".$_POST["alto"].",".$peso.",".$capacidad.",".$_POST["precio"].")";        
        
        $sql_updateProducto="update producto set idtipoproducto='".$_POST["temporada"]."', idpatronproducto='".$_POST["patron"]."', idmaterial='".$_POST["material"]."', codigo='".$_POST["codigoproducto"]."',descripcion='".$_POST["descripcion"]."',dimensionlargo='".$_POST["largo"]."',dimensionancho='".$_POST["ancho"]."',dimensionalto='".$_POST["alto"]."',peso='".$peso."',capacidad='".$capacidad."' where idproducto='".$_GET["id"]."'";      
        $result_updateProducto = mysql_query($sql_updateProducto,$con) or die(mysql_error());
        
        $sql_producto="select * from producto where idproducto='".$_GET["id"]."'";
        $result_producto= mysql_query($sql_producto,$con) or die(mysql_error()); 
        
        if(mysql_num_rows($result_producto)>0){
            $producto = mysql_fetch_assoc($result_producto);                                                                                                                            
        }
        
        if($producto["preciofabrica"]!=$_POST["precio"]){
            $sql_buscaprefa="select * from historicopreciofabrica where idproducto='".$_GET["id"]."' and hasta is null";
            $result_buscaprefa = mysql_query($sql_buscaprefa,$con) or die(mysql_error());
            if(mysql_num_rows($result_buscaprefa)>0){
                $historico = mysql_fetch_assoc($result_buscaprefa);
                $sql_cierraprefa="update historicopreciofabrica set hasta = now(), desde='".$historico["desde"]."' where idhistoricopreciofabrica='".$historico["idhistoricopreciofabrica"]."'";
                $result_cierraprefa = mysql_query($sql_cierraprefa,$con) or die(mysql_error());   
                $sql_insertprefa="insert into historicopreciofabrica (idproducto,preciofabrica,desde) values ('".$_GET["id"]."','".$_POST["precio"]."',now())";
                $result_insertprefa = mysql_query($sql_insertprefa,$con) or die(mysql_error());
                $sql_updateProducto="update producto set preciofabrica='".$_POST["precio"]."' where idproducto='".$_GET["id"]."'";
                $result_updateProducto = mysql_query($sql_updateProducto,$con) or die(mysql_error());                
            }
        } 
        
        echo "Producto Editado Satisfactoriamente";
        
    }
        
    /*insertar lista de precios */
    if($tarea==13){        
        $sql_insertLista="insert into listadeprecios (idempresa,nombre) values('".$_POST["empresa"]."','".$_POST["nombre"]."')";
        $result_insertLista = mysql_query($sql_insertLista,$con) or die(mysql_error());
        
        if($result_insertLista==1){            
            $sql_ultimaLISTA="SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'bugambiliasis' AND TABLE_NAME = 'listadeprecios';";
            $result_ultimaLISTA=mysql_query($sql_ultimaLISTA,$con) or die(mysql_error());	
            $fila = mysql_fetch_assoc($result_ultimaLISTA);
            $indice=intval($fila["AUTO_INCREMENT"]);            
            $indice--;
            
            $sql_tipos="select * from tipoproducto";
            $result_tipos=mysql_query($sql_tipos,$con) or die(mysql_error());
            if(mysql_num_rows($result_tipos)>0){
                while ($tipo = mysql_fetch_assoc($result_tipos)) {
                    $sql_insertGANANCIA="insert into listatipos (idlistadeprecios,idtipoproducto,porcentajeganancia) values(".$indice.",".$tipo["idtipoproducto"].",".$_POST["ganancia".$tipo["idtipoproducto"]].")";                                                   
                    $result_insertGANANCIA=mysql_query($sql_insertGANANCIA,$con) or die(mysql_error());
                    
                    $sql_ultimaASOCIACION="SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'bugambiliasis' AND TABLE_NAME = 'listatipos';";
                    $result_ultimaASOCIACION=mysql_query($sql_ultimaASOCIACION,$con) or die(mysql_error());	
                    $fila2 = mysql_fetch_assoc($result_ultimaASOCIACION);
                    $indice2=intval($fila2["AUTO_INCREMENT"]);            
                    $indice2--;  
                    
                    $sql_insertHistorico="insert into historicoporcentajeganancia (idlistatipos,porcentajeganancia,desde,hasta) values(".$indice2.",'".$_POST["ganancia".$tipo["idtipoproducto"]]."',now(),NULL);";
                    $result_insertHistorico=mysql_query($sql_insertHistorico,$con) or die(mysql_error());                                        
                }   
            }
            
 
            echo "Registro Satisfactorio de la lista de precios";
        }
    } 
    
    /*editar lista de precios */
    if($tarea==14){ 
        $sql_updateListadePrecios="update listadeprecios set nombre='".$_POST["nombre"]."',idempresa='".$_POST["empresa"]."' where idlistadeprecios='".$_GET["id"]."'";
        $result_updateListadePrecios = mysql_query($sql_updateListadePrecios,$con) or die(mysql_error()); 
        
        $sql_tipos="select * from tipoproducto";
        $result_tipos=mysql_query($sql_tipos,$con) or die(mysql_error());
        if(mysql_num_rows($result_tipos)>0){
            while ($tipo = mysql_fetch_assoc($result_tipos)) {
                $sql_actual="select * from listatipos where idtipoproducto='".$tipo["idtipoproducto"]."' and idlistadeprecios='".$_GET["id"]."'";
                $result_actual=mysql_query($sql_actual,$con) or die(mysql_error());
                if(mysql_num_rows($result_actual)>0){
                    while ($actual = mysql_fetch_assoc($result_actual)) {
                        if($_POST["ganancia".$tipo["idtipoproducto"]]!=$actual["porcentajeganancia"]){
                            $sql_update="update listatipos set porcentajeganancia='".$_POST["ganancia".$tipo["idtipoproducto"]]."' where idlistatipos='".$actual["idlistatipos"]."'";
                            $result_update=mysql_query($sql_update,$con) or die(mysql_error());
                            $sql_update2="update historicoporcentajeganancia set hasta = now() where idlistatipos='".$actual["idlistatipos"]."' and  hasta is null";
                            $result_update2=mysql_query($sql_update2,$con) or die(mysql_error());
                            $sql_insertNuevo="insert into historicoporcentajeganancia (idlistatipos,porcentajeganancia,desde) values('".$actual["idlistatipos"]."','".$_POST["ganancia".$tipo["idtipoproducto"]]."',now())";
                            $result_insertNuevo=mysql_query($sql_insertNuevo,$con) or die(mysql_error());                            
                        }                
                    }
                }
            }                
                
        }
        mysql_close($con);            
    }
    
    /*insertar excepcion de la regla */
    if($tarea==15){  
        $sql_insertExcepcion="insert into excepcionlista (idlistadeprecios,idproducto,preciofinal,registro,estatus) values('".$_GET["id"]."','".$_POST["producto"]."','".$_POST["precio"]."',now(),0)";  
        $result_insertExcepcion = mysql_query($sql_insertExcepcion,$con) or die(mysql_error());
        $sql_ultimaExcepcion="SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'bugambiliasis' AND TABLE_NAME = 'excepcionlista';";
        $result_ultimaExcepcion=mysql_query($sql_ultimaExcepcion,$con) or die(mysql_error());	
        $fila = mysql_fetch_assoc($result_ultimaExcepcion);
        $indice=intval($fila["AUTO_INCREMENT"]);            
        $indice--;            
        $sql_insertHistorico="insert into historicoexcepcionlista (idexcepcionlista,preciofinal,desde,hasta) values(".$indice.",'".$_POST["precio"]."',now(),NULL);";
        $result_insertHistorico=mysql_query($sql_insertHistorico,$con) or die(mysql_error());                         
    }
    
    /*insertar orden de compra dolor de cabeza */
    if($tarea==16){ 
        $sql_insertOrden="";
        if(isset($_POST["sucursal"]) && isset($_POST["region"])){
            $sql_insertOrden="insert into ordendecompra (codigoexterno,tipo,fechadecreacion,fechaderegistro,idempresa,idsucursal,idestado,idagenda01,idagenda02,idagenda03,idlistadeprecios,idusuario,codigointerno,subtotal,poriva,iva,total,prioridad,fechadeentrega) values('".$_POST["codigoext"]."','".$_POST["tipoorden"]."',now(),'".$_POST["id-date-picker-1"]."','".$_POST["empresa"]."','".$_POST["sucursal"]."','".$_POST["region"]."','".$_POST["contacto01"]."','".$_POST["contacto02"]."','".$_POST["contacto03"]."','".$_POST["lista"]."',1,'".$_POST["codigoint"]."',0,0,0,0,'".$_POST["prioridad"]."',now())";
        }else{
            $sql_insertOrden="insert into ordendecompra (codigoexterno,tipo,fechadecreacion,fechaderegistro,idempresa,idagenda01,idagenda02,idagenda03,idlistadeprecios,idusuario,codigointerno,subtotal,poriva,iva,total,prioridad,fechadeentrega) values('".$_POST["codigoext"]."','".$_POST["tipoorden"]."',now(),'".$_POST["id-date-picker-1"]."','".$_POST["empresa"]."','".$_POST["contacto01"]."','".$_POST["contacto02"]."','".$_POST["contacto03"]."','".$_POST["lista"]."',1,'".$_POST["codigoint"]."',0,0,0,0,'".$_POST["prioridad"]."',now())";
        }
              
        $result_insertOrden = mysql_query($sql_insertOrden,$con) or die(mysql_error());
        
        $aux=explode("-",$_POST["codigoint"]);
        $nuevoCodigo=($aux[1]+1);
        
        $sqlupdateConfiguracion="update configuracionsistema set secuenciaoc='".$nuevoCodigo."' where idconfiguracionsistema=1";
        $resultupdateConfiguracion=mysql_query($sqlupdateConfiguracion,$con) or die(mysql_error());
        
        $sql_ultimaOrden="SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'bugambiliasis' AND TABLE_NAME = 'ordendecompra';";
        $result_ultimaOrden=mysql_query($sql_ultimaOrden,$con) or die(mysql_error());	
        $fila = mysql_fetch_assoc($result_ultimaOrden);
        $indice=intval($fila["AUTO_INCREMENT"]);            
        $indice--;
        

        
        $productos=$_POST["oculto01"];
        $listaIds=explode("_",$_POST["oculto02"]);
        $listaCodigos=explode("_",$_POST["oculto03"]);
        $listaDescripciones=explode("_",$_POST["oculto04"]);
        $listaColores=explode("_",$_POST["oculto05"]);
        $listaPrecios=explode("_",$_POST["oculto06"]);
        $listaUnidades=explode("_",$_POST["oculto07"]);
        
        
        $subTotal=0;
        $poriva=0;
        $total=0;
        $iva=0;
        
        $materiales = array();
        
        for($i=0;$i<count($listaIds);$i++){
            if($listaIds[$i]!=""){
                $sql_precio="select preciofabrica,idmaterial from producto where idproducto='".$listaIds[$i]."'";
                $result_precio=mysql_query($sql_precio,$con) or die(mysql_error());
                if(mysql_num_rows($result_precio)>0){
                    $precio = mysql_fetch_assoc($result_precio);
                    $banderina=0;
                    for($j=0;$j<count($materiales);$j++){
                        if($materiales[$j]==$precio["idmaterial"]){
                            $banderina=1;
                        }
                    }
                    if($banderina==0){
                        $materiales[count($materiales)]=$precio["idmaterial"];
                    }
                    $sql_color="select * from color where nombre='".$listaColores[$i]."'";
                    $result_color=mysql_query($sql_color,$con) or die(mysql_error());
                    $color = mysql_fetch_assoc($result_color);
                    $subTotal+=($listaUnidades[$i]*$listaPrecios[$i]);
                    $sql_insProducto="insert into productosordencompra (idordendecompra,idproducto,idcolor,preciofabrica,precioventa,numerodeunidades) values('".$indice."','".$listaIds[$i]."','".$color["idcolor"]."','".$precio["preciofabrica"]."','".$listaPrecios[$i]."','".$listaUnidades[$i]."')";
                    $result_insProducto=mysql_query($sql_insProducto,$con) or die(mysql_error());
                }
            }
        }
        
        if($_POST["appiva"]=="S"){
            $poriva=$_POST["poriva"];
            $iva=$subTotal*($poriva/100);
            $total=$subTotal+$iva;
        }else if($_POST["appiva"]=="N"){
            $total=$subTotal;
        }
        
        $sql_updateOrdenCompra="update ordendecompra set subtotal='".$subTotal."',poriva='".$poriva."',iva='".$iva."',total='".$total."' where idordendecompra='".$indice."'";
        $result_updateOrdenCompra=mysql_query($sql_updateOrdenCompra,$con) or die(mysql_error());
        

        
        /*Se suman de 28 a 42 días dependiendo de los tipos de productos*/
        if($_POST["prioridad"]==1){
            $mayor=-999999;
            for($j=0;$j<count($materiales);$j++){
                $sqlSelMaterial="select * from material where idmaterial='".$materiales[$j]."'";
                $resultSelMaterial=mysql_query($sqlSelMaterial,$con) or die(mysql_error());
                $material = mysql_fetch_assoc($resultSelMaterial);
                if($material["dias"]>$mayor){
                    $mayor=$material["dias"];
                }
            }           
            $nuevafecha = new DateTime($_POST["id-date-picker-1"]);
            $nuevafecha->modify('+'.$mayor.' day');
            
            $sql_updateOrdenCompra="update ordendecompra set fechadeentrega='".$nuevafecha->format('Y-m-d')."' where idordendecompra='".$indice."'";
            $result_updateOrdenCompra=mysql_query($sql_updateOrdenCompra,$con) or die(mysql_error());            
            
        }else if($_POST["prioridad"]==2){ /*Se establece una fecha fija de entrega*/
            $sql_updateOrdenCompra="update ordendecompra set fechadeentrega='".$_POST["id-date-picker-2"]."' where idordendecompra='".$indice."'";
            $result_updateOrdenCompra=mysql_query($sql_updateOrdenCompra,$con) or die(mysql_error());            
        }        
        
    }    
?>