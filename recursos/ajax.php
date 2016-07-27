<?php session_start(); 
 
    require_once("funciones.php");
    $con=Conexion();

    if($_POST["tarea"]==1){
        $sql_empresa="select * from empresa where idempresa='".$_POST["id"]."'";
        $result_empresa=mysql_query($sql_empresa,$con) or die(mysql_error());
        if(mysql_num_rows($result_empresa)>0){
            $empresa = mysql_fetch_assoc($result_empresa);                       
            echo "<select class='chosen-select form-control' id='regiones' name='regiones[]' multiple='' data-placeholder='Elija las regiones asociadas a esta sucursal'>";
            $sql_listaESTADO="select * from estado where idpais='".$empresa["idpais"]."' order by nombre";
            $result_listaESTADO=mysql_query($sql_listaESTADO,$con) or die(mysql_error());
            if(mysql_num_rows($result_listaESTADO)>0){
                while ($fila = mysql_fetch_assoc($result_listaESTADO)) {
                    echo "<option value='".$fila["idestado"]."'>".$fila["nombre"]."</option>";
                    }
            }                                                                                                                           								
            echo "</select>";
        }                
    }
        
    if($_POST["tarea"]==2){        
        if($_POST["subtarea"]=="AE"){ 
            echo "<div style='width: 100%; margin-top: 10px;'>(*) Empresa a la que pertenece el contacto</div>";
            echo "<select class='chosen-select form-control' id='empresa' name='empresa' data-placeholder='Elija la empresa a la que pertenece el contacto' required='required'>";
            $sql_listaEMPRESA="select * from empresa order by nombrecomercial";
            $result_listaEMPRESA=mysql_query($sql_listaEMPRESA,$con) or die(mysql_error());
            if(mysql_num_rows($result_listaEMPRESA)>0){
                while ($fila = mysql_fetch_assoc($result_listaEMPRESA)) {
                    echo "<option value='".$fila["idempresa"]."'>".$fila["nombrecomercial"]."</option>";
                }
            }
            echo "</select>";
        }
        if($_POST["subtarea"]=="AS"){                                               
            $aux=-1;
            $cont=0;
            echo "<div style='width: 100%; margin-top: 10px;'>(*) Empresa a la que pertenece el contacto</div>";
            echo "<select class='chosen-select form-control' id='empresa' name='empresa' data-placeholder='Elija la empresa a la que pertenece el contacto' required='required'>";
            $sql_listaEMPRESA="select * from empresa order by nombrecomercial";
            $result_listaEMPRESA=mysql_query($sql_listaEMPRESA,$con) or die(mysql_error());
            if(mysql_num_rows($result_listaEMPRESA)>0){
                while ($fila = mysql_fetch_assoc($result_listaEMPRESA)) {
                    if($cont==0){
                        $aux=$fila["idempresa"];
                    }
                    echo "<option value='".$fila["idempresa"]."'>".$fila["nombrecomercial"]."</option>";
                    $cont++;
                }
            }
            echo "</select>";
            echo "<div id='contenedor02'>";
            echo "<div style='width: 100%; margin-top: 10px;'>(*) Sucursal a la que pertenece el contacto</div>";
            echo "<select class='chosen-select form-control' id='sucursal' name='sucursal' data-placeholder='Elija la sucursal a la que pertenece el contacto' required='required'>";
            $sql_listaSUCURSAL="select * from sucursal where idempresa='".$aux."' order by nombrecomercial";
            $result_listaSUCURSAL=mysql_query($sql_listaSUCURSAL,$con) or die(mysql_error());
            if(mysql_num_rows($result_listaSUCURSAL)>0){
                while ($fila = mysql_fetch_assoc($result_listaSUCURSAL)) {
                    echo "<option value='".$fila["idsucursal"]."'>".$fila["nombrecomercial"]."</option>";
                }
            }
            echo "</select>";
            echo "</div>";
            
        }
        if($_POST["subtarea"]=="AR"){                        
            $aux01=-1;
            $aux02=-1;
            $cont=0;
            echo "<div style='width: 100%; margin-top: 10px;'>(*) Empresa a la que pertenece el contacto</div>";
            echo "<select class='chosen-select form-control' id='empresa' name='empresa' data-placeholder='Elija la empresa a la que pertenece el contacto' required='required'>";
            $sql_listaEMPRESA="select * from empresa order by nombrecomercial";
            $result_listaEMPRESA=mysql_query($sql_listaEMPRESA,$con) or die(mysql_error());
            if(mysql_num_rows($result_listaEMPRESA)>0){
                while ($fila = mysql_fetch_assoc($result_listaEMPRESA)) {
                    if($cont==0){
                        $aux01=$fila["idempresa"];
                    }
                    echo "<option value='".$fila["idempresa"]."'>".$fila["nombrecomercial"]."</option>";
                    $cont++;
                }
            }
            echo "</select>";
            echo "<div id='contenedor02'>";
            echo "<div style='width: 100%; margin-top: 10px;'>(*) Sucursal a la que pertenece el contacto</div>";
            echo "<select class='chosen-select form-control' id='sucursal' name='sucursal' data-placeholder='Elija la sucursal a la que pertenece el contacto' required='required'>";
            $sql_listaSUCURSAL="select * from sucursal where idempresa='".$aux01."' order by nombrecomercial";
            $result_listaSUCURSAL=mysql_query($sql_listaSUCURSAL,$con) or die(mysql_error());
            $cont=0;
            if(mysql_num_rows($result_listaSUCURSAL)>0){
                while ($fila = mysql_fetch_assoc($result_listaSUCURSAL)) {
                    if($cont==0){
                        $aux02=$fila["idsucursal"];
                    }
                    echo "<option value='".$fila["idsucursal"]."'>".$fila["nombrecomercial"]."</option>";
                    $cont++;
                }
            }
            echo "</select>"; 
            echo "<div id='contenedor03'>";                                    
            echo "<div style='width: 100%; margin-top: 10px;'>(*) Región a la que pertenece el contacto</div>";
            echo "<select class='chosen-select form-control' id='region' name='region' data-placeholder='Elija la región a la que pertenece el contacto' required='required'>";
            $sql_listaESTSUCURSAL="select * from estadosensucursal where idsucursal='".$aux02."'";
            $result_listaESTSUCURSAL=mysql_query($sql_listaESTSUCURSAL,$con) or die(mysql_error());
            if(mysql_num_rows($result_listaESTSUCURSAL)>0){
                while ($fila = mysql_fetch_assoc($result_listaESTSUCURSAL)) {
                    $sql_estado="select * from estado where idestado='".$fila["idestado"]."'";
                    $result_estado=mysql_query($sql_estado,$con) or die(mysql_error());
                    $fila02 = mysql_fetch_assoc($result_estado);
                    echo "<option value='".$fila["idestado"]."'>".$fila02["nombre"]."</option>";                    
                }
            }
            echo "</select>"; 
            echo "</div>";              
            echo "</div>";                         
        }                
     }
     
    if($_POST["tarea"]==3){ 
        
        if($_POST["tipodeasociacion"]=="AS"){ /*Asociado a Sucursal*/
            
            echo "<div style='width: 100%; margin-top: 10px;'>(*) Sucursal a la que pertenece el contacto</div>";
            echo "<select class='chosen-select form-control' id='sucursal' name='sucursal' data-placeholder='Elija la sucursal a la que pertenece el contacto' required='required'>";
            $sql_listaSUCURSAL="select * from sucursal where idempresa='".$_POST["empresa"]."' order by nombrecomercial";
            $result_listaSUCURSAL=mysql_query($sql_listaSUCURSAL,$con) or die(mysql_error());
            if(mysql_num_rows($result_listaSUCURSAL)>0){
                while ($fila = mysql_fetch_assoc($result_listaSUCURSAL)) {
                    echo "<option value='".$fila["idsucursal"]."'>".$fila["nombrecomercial"]."</option>";
                }
            }
            echo "</select>";            
            
        }else if($_POST["tipodeasociacion"]=="AR"){ /*Asociado a Región*/
            
            $aux01=0;
            $cont=0;
            echo "<div style='width: 100%; margin-top: 10px;'>(*) Sucursal a la que pertenece el contacto</div>";
            echo "<select class='chosen-select form-control' id='sucursal' name='sucursal' data-placeholder='Elija la sucursal a la que pertenece el contacto' required='required'>";
            $sql_listaSUCURSAL="select * from sucursal where idempresa='".$_POST["empresa"]."' order by nombrecomercial";
            $result_listaSUCURSAL=mysql_query($sql_listaSUCURSAL,$con) or die(mysql_error());
            if(mysql_num_rows($result_listaSUCURSAL)>0){
                while ($fila = mysql_fetch_assoc($result_listaSUCURSAL)) {
                    if($cont==0){
                        $aux01=$fila["idsucursal"];
                    }
                    echo "<option value='".$fila["idsucursal"]."'>".$fila["nombrecomercial"]."</option>";
                    $cont++;
                }
            }
            echo "</select>";             
            
            echo "<div id='contenedor03'>";                                    
            echo "<div style='width: 100%; margin-top: 10px;'>(*) Región a la que pertenece el contacto</div>";
            echo "<select class='chosen-select form-control' id='region' name='region' data-placeholder='Elija la región a la que pertenece el contacto' required='required'>";
            $sql_listaESTSUCURSAL="select * from estadosensucursal where idsucursal='".$aux01."'";
            $result_listaESTSUCURSAL=mysql_query($sql_listaESTSUCURSAL,$con) or die(mysql_error());
            if(mysql_num_rows($result_listaESTSUCURSAL)>0){
                while ($fila = mysql_fetch_assoc($result_listaESTSUCURSAL)) {
                    $sql_estado="select * from estado where idestado='".$fila["idestado"]."'";
                    $result_estado=mysql_query($sql_estado,$con) or die(mysql_error());
                    $fila02 = mysql_fetch_assoc($result_estado);
                    echo "<option value='".$fila["idestado"]."'>".$fila02["nombre"]."</option>";                    
                }
            }
            echo "</select>"; 
            echo "</div>";            
            
        }
                
    }   
    
    if($_POST["tarea"]==4){
        
        if($_POST["tipodeasociacion"]=="AR"){
            echo "<div style='width: 100%; margin-top: 10px;'>(*) Región a la que pertenece el contacto</div>";
            echo "<select class='chosen-select form-control' id='region' name='region' data-placeholder='Elija la región a la que pertenece el contacto' required='required'>";
            $sql_listaESTSUCURSAL="select * from estadosensucursal where idsucursal='".$_POST["sucursal"]."'";
            $result_listaESTSUCURSAL=mysql_query($sql_listaESTSUCURSAL,$con) or die(mysql_error());
            if(mysql_num_rows($result_listaESTSUCURSAL)>0){
                while ($fila = mysql_fetch_assoc($result_listaESTSUCURSAL)) {
                    $sql_estado="select * from estado where idestado='".$fila["idestado"]."'";
                    $result_estado=mysql_query($sql_estado,$con) or die(mysql_error());
                    $fila02 = mysql_fetch_assoc($result_estado);
                    echo "<option value='".$fila["idestado"]."'>".$fila02["nombre"]."</option>";                    
                }
            }
            echo "</select>";             
        }                                        
    }
    
    if($_POST["tarea"]==5){

        $con=Conexion();
        $sql_listaAGENDA="select idagenda, nombre, referencia, email, telefono1, telefono2 from agenda where nombre LIKE '%".$_POST["letras"]."%' or referencia LIKE '%".$_POST["letras"]."%' or email LIKE '%".$_POST["letras"]."%' or referencia LIKE '%".$_POST["letras"]."%' order by nombre asc";
        $result_listaAGENDA=mysql_query($sql_listaAGENDA,$con) or die(mysql_error());
        if(mysql_num_rows($result_listaAGENDA)>0){                                                        
            while ($fila = mysql_fetch_assoc($result_listaAGENDA)) {                
                echo "<div class='row contacto'>";
                echo "<div class='col-xs-12' title='Nombre'><i class='ace-icon glyphicon glyphicon-user' style='margin-right: 1ex'></i>".$fila["nombre"]."</div>";
                echo "<div class='col-xs-12' title='Puesto'><i class='ace-icon glyphicon fa fa-users' style='margin-right: 1ex'></i>".$fila["referencia"]."</div>";
                echo "<div class='col-xs-12' title='Teléfono'><i class='ace-icon glyphicon fa fa-phone' style='margin-right: 1ex'></i>".$fila["telefono1"]."</div>";
                echo "<div class='col-xs-12' title='Correo Electronico'><i class='ace-icon glyphicon fa fa-envelope-o' style='margin-right: 1ex'></i>".$fila["email"]."</div>";
                $sql_asocia="select * from asociacionagenda where idagenda='".$fila["idagenda"]."'";
                $result_asocia=mysql_query($sql_asocia,$con) or die(mysql_error());
                $asocia = mysql_fetch_assoc($result_asocia);
                $trabajo="";
                $band=0;
                if($asocia["idempresa"]!=""){
                    $sql_empresa="select * from empresa where idempresa='".$asocia["idempresa"]."'";
                    $result_empresa=mysql_query($sql_empresa,$con) or die(mysql_error());
                    $empresa = mysql_fetch_assoc($result_empresa);                                                                                                                                
                    $trabajo=$trabajo.$empresa["nombreempresa"];
                    $band=1;
                }
                if($asocia["idsucursal"]!=""){
                    $sql_sucursal="select * from sucursal where idsucursal='".$asocia["idsucursal"]."'";
                    $result_sucursal=mysql_query($sql_sucursal,$con) or die(mysql_error());
                    $sucursal = mysql_fetch_assoc($result_sucursal); 
                    $trabajo=$trabajo." / ".$sucursal["nombrecomercial"];
                    $band=1;
                }
                if($asocia["idestado"]!=""){
                    $sql_estado="select * from estado where idestado='".$asocia["idestado"]."'";
                    $result_estado=mysql_query($sql_estado,$con) or die(mysql_error());
                    $estado = mysql_fetch_assoc($result_estado); 
                    $trabajo=$trabajo." / ".$estado["nombre"];
                    $band=1;
                }
                if($band==1){
                    echo "<div class='col-xs-12' title='Empresa'><i class='ace-icon glyphicon fa fa-building' style='margin-right: 1ex'></i>".$trabajo."</div>";
                }
                if(habilitaMenu($_SESSION["usuario"],1,3,3)==1){
                    echo "<div class='col-xs-12'><a href='editarcontacto.php?id=".$fila["idagenda"]."' ><span class='label label-warning'>Editar</span></a></div>";
                }
                echo "</div>";
            }
            if(mysql_num_rows($result_listaAGENDA)==1){
                echo "<div class='row contacto'>".mysql_num_rows($result_listaAGENDA)." Contacto Encontrado</div>";
            }  else {
                echo "<div class='row contacto'>".mysql_num_rows($result_listaAGENDA)." Contactos Encontrados</div>";
            }            
        }        
    }
    
    
        if($_POST["tarea"]==6){

        $con=Conexion();
        $sql_listaAGENDA="select idagenda, nombre, referencia, email, telefono1, telefono2 from agenda where nombre LIKE '".$_POST["letras"]."%' order by nombre asc";
        $result_listaAGENDA=mysql_query($sql_listaAGENDA,$con) or die(mysql_error());
        if(mysql_num_rows($result_listaAGENDA)>0){                                                        
            while ($fila = mysql_fetch_assoc($result_listaAGENDA)) {                
                echo "<div class='row contacto'>";
                echo "<div class='col-xs-12' title='Nombre'><i class='ace-icon glyphicon glyphicon-user' style='margin-right: 1ex'></i>".$fila["nombre"]."</div>";
                echo "<div class='col-xs-12' title='Puesto'><i class='ace-icon glyphicon fa fa-users' style='margin-right: 1ex'></i>".$fila["referencia"]."</div>";
                echo "<div class='col-xs-12' title='Teléfono'><i class='ace-icon glyphicon fa fa-phone' style='margin-right: 1ex'></i>".$fila["telefono1"]."</div>";
                echo "<div class='col-xs-12' title='Correo Electronico'><i class='ace-icon glyphicon fa fa-envelope-o' style='margin-right: 1ex'></i>".$fila["email"]."</div>";
                $sql_asocia="select * from asociacionagenda where idagenda='".$fila["idagenda"]."'";
                $result_asocia=mysql_query($sql_asocia,$con) or die(mysql_error());
                $asocia = mysql_fetch_assoc($result_asocia);
                $trabajo="";
                $band=0;
                if($asocia["idempresa"]!=""){
                    $sql_empresa="select * from empresa where idempresa='".$asocia["idempresa"]."'";
                    $result_empresa=mysql_query($sql_empresa,$con) or die(mysql_error());
                    $empresa = mysql_fetch_assoc($result_empresa);                                                                                                                                
                    $trabajo=$trabajo.$empresa["nombreempresa"];
                    $band=1;
                }
                if($asocia["idsucursal"]!=""){
                    $sql_sucursal="select * from sucursal where idsucursal='".$asocia["idsucursal"]."'";
                    $result_sucursal=mysql_query($sql_sucursal,$con) or die(mysql_error());
                    $sucursal = mysql_fetch_assoc($result_sucursal); 
                    $trabajo=$trabajo." / ".$sucursal["nombrecomercial"];
                    $band=1;
                }
                if($asocia["idestado"]!=""){
                    $sql_estado="select * from estado where idestado='".$asocia["idestado"]."'";
                    $result_estado=mysql_query($sql_estado,$con) or die(mysql_error());
                    $estado = mysql_fetch_assoc($result_estado); 
                    $trabajo=$trabajo." / ".$estado["nombre"];
                    $band=1;
                }
                if($band==1){
                    echo "<div class='col-xs-12' title='Empresa'><i class='ace-icon glyphicon fa fa-building' style='margin-right: 1ex'></i>".$trabajo."</div>";
                }  
                if(habilitaMenu($_SESSION["usuario"],1,3,3)==1){
                    echo "<div class='col-xs-12'><a href='editarcontacto.php?id=".$fila["idagenda"]."' ><span class='label label-warning'>Editar</span></a></div>";
                }
                echo "</div>";
            }
            if(mysql_num_rows($result_listaAGENDA)==1){
                echo "<div class='row contacto'>".mysql_num_rows($result_listaAGENDA)." Contacto Encontrado</div>";
            }  else {
                echo "<div class='row contacto'>".mysql_num_rows($result_listaAGENDA)." Contactos Encontrados</div>";
            }            
        }        
    }
     
    if($_POST["tarea"]==7){
        $band=0;
        $patronaux=-1;
        echo "<div style='width: 100%; margin-top: 10px;'>(*) Patrón del Producto</div>";
        echo "<select class='chosen-select form-control' id='patron' name='patron' data-placeholder='Seleccione el Patrón del Producto' required='required'>";
        $sql_listaESTSUCURSAL="select * from patronproducto where idcategoriaproducto='".$_POST["id"]."'";
        $result_listaESTSUCURSAL=mysql_query($sql_listaESTSUCURSAL,$con) or die(mysql_error());
        if(mysql_num_rows($result_listaESTSUCURSAL)>0){
            while ($fila = mysql_fetch_assoc($result_listaESTSUCURSAL)) {
                if($band==0){
                    $patronaux=$fila["idpatronproducto"];
                }
                echo "<option value='".$fila["idpatronproducto"]."'>".$fila["nombreespanol"]."</option>";                    
                $band=1;
            }
        }
        echo "</select>";
        if($patronaux!=-1){
            echo "<div style='width: 100%; margin-top: 10px;'>(*) Material del Producto</div>";
            echo "<div id='contenedor02'>";            
            echo "<select class='chosen-select form-control' id='material' name='material' data-placeholder='Seleccione el Patrón del Producto' required='required'>";
            $sql_listaESTSUCURSAL="select * from materialespatron where idpatronproducto='".$patronaux."'";
            $result_listaESTSUCURSAL=mysql_query($sql_listaESTSUCURSAL,$con) or die(mysql_error());
            if(mysql_num_rows($result_listaESTSUCURSAL)>0){
                while ($fila = mysql_fetch_assoc($result_listaESTSUCURSAL)) {
                    $sqlMaterial="select * from material where idmaterial='".$fila["idmaterial"]."'";
                    $resultMaterial=mysql_query($sqlMaterial,$con) or die(mysql_error());
                    $material = mysql_fetch_assoc($resultMaterial);
                    echo "<option value='".$material["idmaterial"]."'>".$material["nombre"]."</option>";                    
                }
            }
            echo "</select>";                        
            echo "</div>"; 
        }               
    }    
    
    if($_POST["tarea"]==8){
            echo "<select class='chosen-select form-control' id='material' name='material' data-placeholder='Seleccione el Patrón del Producto' required='required'>";
            $sql_listaESTSUCURSAL="select * from materialespatron where idpatronproducto='".$_POST["id"]."'";
            $result_listaESTSUCURSAL=mysql_query($sql_listaESTSUCURSAL,$con) or die(mysql_error());
            if(mysql_num_rows($result_listaESTSUCURSAL)>0){
                while ($fila = mysql_fetch_assoc($result_listaESTSUCURSAL)) {
                    $sqlMaterial="select * from material where idmaterial='".$fila["idmaterial"]."'";
                    $resultMaterial=mysql_query($sqlMaterial,$con) or die(mysql_error());
                    $material = mysql_fetch_assoc($resultMaterial);
                    echo "<option value='".$material["idmaterial"]."'>".$material["nombre"]."</option>";                    
                }
            }
            echo "</select>";
    }
    
    if($_POST["tarea"]==9){
            echo $_POST["producto"];
            echo "<select class='chosen-select form-control' id='material' name='material' data-placeholder='Seleccione el Patrón del Producto' required='required'>";
            $sql_listaESTSUCURSAL="select * from materialespatron where idpatronproducto='".$_POST["id"]."'";
            $result_listaESTSUCURSAL=mysql_query($sql_listaESTSUCURSAL,$con) or die(mysql_error());
            if(mysql_num_rows($result_listaESTSUCURSAL)>0){
                while ($fila = mysql_fetch_assoc($result_listaESTSUCURSAL)) {
                    $sqlMaterial="select * from material where idmaterial='".$fila["idmaterial"]."'";
                    $resultMaterial=mysql_query($sqlMaterial,$con) or die(mysql_error());
                    $material = mysql_fetch_assoc($resultMaterial);
                    echo "<option value='".$material["idmaterial"]."'>".$material["nombre"]."</option>";                    
                }
            }
            echo "</select>";
    }   
    
    if($_POST["tarea"]==10){
    $bandera=0;
    $aux01=-1;
    echo "<div class='col-md-3' style='border: 0px solid #CCC'>";
    echo "<div style='width: 100%;'>";                                                        
    echo "<select class='chosen-select form-control' id='patron' name='patron' data-placeholder='Seleccione el patron del producto' required='required'>";                                                             
    $sql_listaPATRON="select * from patronproducto where idcategoriaproducto='".$_POST["id"]."' order by nombreespanol";
    $result_listaPATRON=mysql_query($sql_listaPATRON,$con) or die(mysql_error());
    if(mysql_num_rows($result_listaPATRON)>0){
        while ($patron = mysql_fetch_assoc($result_listaPATRON)) {
            if($bandera==0){
                $aux01=$patron["idpatronproducto"];
            }            
            echo "<option value='".$patron["idpatronproducto"]."'>".$patron["nombreespanol"]."</option>";
            $bandera=1;
        }
    }                                                                                                                            															
    echo "</select>";                                                   
    echo "</div>";                                                   
    echo "</div>";
    echo "<div id='contenedor02'>";
    echo "<div class='col-md-3' style='border: 0px solid #CCC'>";
    echo "<div style='width: 100%;'>";                           
    echo "<select class='chosen-select form-control' id='producto' name='producto' data-placeholder='Seleccione el producto' required='required'>";
    $sql_listaPRODUCTO="select * from producto where idpatronproducto='".$aux01."' order by codigo";
    $result_listaPRODUCTO=mysql_query($sql_listaPRODUCTO,$con) or die(mysql_error());
    if(mysql_num_rows($result_listaPRODUCTO)>0){
        while ($producto = mysql_fetch_assoc($result_listaPRODUCTO)) {
            echo "<option value='".$producto["idproducto"]."'>".$producto["codigo"]." ".$producto["descripcion"]."</option>";                                                                   
        }
    }                                                               
    echo "</select>";                                                       
    echo "</div>";                                                   
    echo "</div>";
    echo "</div>";      
          
    }
    
    if($_POST["tarea"]==11){
        echo "<div class='col-md-3' style='border: 0px solid #CCC'>";
        echo "<div style='width: 100%;'>";                           
        echo "<select class='chosen-select form-control' id='producto' name='producto' data-placeholder='Seleccione el producto' required='required'>";
        $sql_listaPRODUCTO="select * from producto where idpatronproducto='".$_POST["id"]."' order by codigo";
        $result_listaPRODUCTO=mysql_query($sql_listaPRODUCTO,$con) or die(mysql_error());
        if(mysql_num_rows($result_listaPRODUCTO)>0){
            while ($producto = mysql_fetch_assoc($result_listaPRODUCTO)) {
                echo "<option value='".$producto["idproducto"]."'>".$producto["codigo"]." ".$producto["descripcion"]."</option>";                                                                   
            }
        }                                                               
        echo "</select>";                                                       
        echo "</div>";                                                   
        echo "</div>";
    } 
    
    if($_POST["tarea"]==12){
        $sql_cuenta="select count(*) as total from sucursal where idempresa='".$_POST["idempresa"]."' order by nombrecomercial";
        $result_cuenta=mysql_query($sql_cuenta,$con) or die(mysql_error());
        $total = mysql_fetch_assoc($result_cuenta);
        if($total["total"]>0){
            echo "<div style='width: 100%; float: left; margin-right: 10px'>";
            echo "<label>Sucursal</label>";
            echo "<select class='chosen-select form-control' id='sucursal' name='sucursal' data-placeholder='Elija la sucursal solicitante'>";
            echo "<option value=''></option>";
            $sql_listaSucursal="select * from sucursal where idempresa='".$_POST["idempresa"]."' order by nombrecomercial";
            $result_listaSucursal=mysql_query($sql_listaSucursal,$con) or die(mysql_error());
            if(mysql_num_rows($result_listaSucursal)>0){
                while ($sucursal = mysql_fetch_assoc($result_listaSucursal)) {
                    echo "<option value='".$sucursal["idsucursal"]."'>".$sucursal["nombrecomercial"]."</option>";
                }
            }
            echo "</select>";
            echo "</div>";
            echo "<div id='contenedor02' style='margin-top: 10px'>";
            echo "</div>";            
        }
    } 
    
    if($_POST["tarea"]==13){
        $sql_cuenta="select count(*) as total from estadosensucursal where idsucursal='".$_POST["idsucursal"]."'";
        $result_cuenta=mysql_query($sql_cuenta,$con) or die(mysql_error());
        $total = mysql_fetch_assoc($result_cuenta);         
        echo "<div style='width: 100%; margin-top: 10px'>";
        echo "<label style='margin-top: 10px'>Región</label>";
        echo "<select class='chosen-select form-control' id='region' name='region' data-placeholder='Elija la región solicitante'>";
        echo "<option value=''></option>";
        $sql_listaESTSUCURSAL="select * from estadosensucursal where idsucursal='".$_POST["idsucursal"]."'";
        $result_listaESTSUCURSAL=mysql_query($sql_listaESTSUCURSAL,$con) or die(mysql_error());
        if(mysql_num_rows($result_listaESTSUCURSAL)>0){
            while ($fila = mysql_fetch_assoc($result_listaESTSUCURSAL)) {
                $sql_estado="select * from estado where idestado='".$fila["idestado"]."'";
                $result_estado=mysql_query($sql_estado,$con) or die(mysql_error());
                $fila02 = mysql_fetch_assoc($result_estado);
                echo "<option value='".$fila["idestado"]."'>".$fila02["nombre"]."</option>";                    
            }
        }
        echo "</select>"; 
        echo "</div>";
    }
    
    /*Actualiza el contacto asociado*/
    if($_POST["tarea"]==14){
        echo "<div style='width: 100%; margin-top: 10px'>";
        echo "<label style='margin-top: 10px'>Contacto de Compra</label>";
        echo "<select class='chosen-select form-control' id='contacto01' name='contacto01' data-placeholder='Elija el contacto asociado' required='required'>";
        $sql_listaASOCIACION="select * from asociacionagenda where idempresa='".$_POST["idempresa"]."'";
        $result_listaASOCIACION=mysql_query($sql_listaASOCIACION,$con) or die(mysql_error());
        if(mysql_num_rows($result_listaASOCIACION)>0){
            while ($fila = mysql_fetch_assoc($result_listaASOCIACION)) {
                $sql_agenda="select * from agenda where idagenda='".$fila["idagenda"]."'";
                $result_agenda=mysql_query($sql_agenda,$con) or die(mysql_error());
                $fila02 = mysql_fetch_assoc($result_agenda);
                echo "<option value='".$fila02["idagenda"]."'>".$fila02["nombre"]."</option>";                    
            }
        }
        echo "</select>";                               
        echo "</div>";
        
        echo "<div style='width: 100%; margin-top: 10px'>";
        echo "<label>Contacto de Cuentas por Pagar</label>";
        echo "<select class='chosen-select form-control' id='contacto02' name='contacto02' data-placeholder='Elija el contacto asociado' required='required'>";
        $sql_listaASOCIACION="select * from asociacionagenda where idempresa='".$_POST["idempresa"]."'";
        $result_listaASOCIACION=mysql_query($sql_listaASOCIACION,$con) or die(mysql_error());
        if(mysql_num_rows($result_listaASOCIACION)>0){
            while ($fila = mysql_fetch_assoc($result_listaASOCIACION)) {
                $sql_agenda="select * from agenda where idagenda='".$fila["idagenda"]."'";
                $result_agenda=mysql_query($sql_agenda,$con) or die(mysql_error());
                $fila02 = mysql_fetch_assoc($result_agenda);
                echo "<option value='".$fila02["idagenda"]."'>".$fila02["nombre"]."</option>";                    
            }
        }
        echo "</select>";                               
        echo "</div>";
        
        echo "<div style='width: 100%; margin-top: 10px'>";
        echo "<label>Contacto de Entrega</label>";
        echo "<select class='chosen-select form-control' id='contacto03' name='contacto03' data-placeholder='Elija el contacto asociado' required='required'>";
        $sql_listaASOCIACION="select * from asociacionagenda where idempresa='".$_POST["idempresa"]."'";
        $result_listaASOCIACION=mysql_query($sql_listaASOCIACION,$con) or die(mysql_error());
        if(mysql_num_rows($result_listaASOCIACION)>0){
            while ($fila = mysql_fetch_assoc($result_listaASOCIACION)) {
                $sql_agenda="select * from agenda where idagenda='".$fila["idagenda"]."'";
                $result_agenda=mysql_query($sql_agenda,$con) or die(mysql_error());
                $fila02 = mysql_fetch_assoc($result_agenda);
                echo "<option value='".$fila02["idagenda"]."'>".$fila02["nombre"]."</option>";                    
            }
        }
        echo "</select>";                               
        echo "</div>";        
    } 
    
    /*Actualiza el contacto asociado*/
    if($_POST["tarea"]==15){
        echo "<div style='width: 100%; margin-top: 10px'>";
        echo "<label>Lista de Precios</label>";        
        echo "<select class='chosen-select form-control' id='lista' name='lista' data-placeholder='Elija la lista de precios' required='required'>";
        $sql_listaLISTAPRECIOS="select * from listadeprecios where idempresa='".$_POST["idempresa"]."'";
        $result_listaLISTAPRECIOS=mysql_query($sql_listaLISTAPRECIOS,$con) or die(mysql_error());
        if(mysql_num_rows($result_listaLISTAPRECIOS)>0){
            while ($fila = mysql_fetch_assoc($result_listaLISTAPRECIOS)) {
                echo "<option value='".$fila["idlistadeprecios"]."'>".$fila["nombre"]."</option>";                    
            }
        }
        echo "</select>";
        echo "</div>";
    } 
    
    /*Cambia la forma del producto*/
    if($_POST["tarea"]==16){ 
        $aux01=-1;
        $aux02=-1;
        echo "<div style='width: 100%;'>";
        echo "Patrón del Producto";
        echo "</div>";
        echo "<div style='width: 100%;'>";
        echo "<select class='chosen-select form-control' style='width: 100%' id='patron' name='patron' data-placeholder='Seleccione el patron del producto' required='required'>";       
        $sql_listaPATRON="select * from patronproducto where idcategoriaproducto='".$_POST["idforma"]."' order by nombreespanol";
        $result_listaPATRON=mysql_query($sql_listaPATRON,$con) or die(mysql_error());
        if(mysql_num_rows($result_listaPATRON)>0){
            while ($patron = mysql_fetch_assoc($result_listaPATRON)) {
                $sql_cuenta02="select count(*) as total from producto where idpatronproducto='".$patron["idpatronproducto"]."'";
                $result_cuenta02=mysql_query($sql_cuenta02,$con) or die(mysql_error());
                $total02 = mysql_fetch_assoc($result_cuenta02); 
                if($total02["total"]>0){
                    if($aux01==-1){
                        $aux01=$patron["idpatronproducto"];
                    }
                    echo "<option value='".$patron["idpatronproducto"]."'>".$patron["nombreespanol"]."</option>";
                }                                                                                            
            }
        }                                                                                                                                                                                                                                
        echo "</select>";
        echo "</div>";
        echo "<div id='seleccion02'>";   
        echo "<div style='width: 100%;'>";
        echo "(*) Producto";
        echo "</div>";
        echo "<div style='width: 100%;'>";
        echo "<select class='chosen-select form-control' style='width: 100%' id='producto' name='producto' data-placeholder='Seleccione el producto' required='required'>";        
        $sql_listaPRODUCTO="select * from producto where idpatronproducto='".$aux01."' order by descripcion";
        $result_listaPRODUCTO=mysql_query($sql_listaPRODUCTO,$con) or die(mysql_error());
        if(mysql_num_rows($result_listaPRODUCTO)>0){
            while ($producto = mysql_fetch_assoc($result_listaPRODUCTO)) {
                if($aux02==-1){
                    $aux02=$producto["idproducto"];
                }                
                echo "<option value='".$producto["idproducto"]."'>".$producto["codigo"]." ".$producto["descripcion"]."</option>";
            }
        }
        echo "</select>";
        echo "</div>";        
        echo "<div id='seleccion03'>";
        $sqlTproducto="select * from producto where idproducto='".$aux02."'";
        $resiltTproducto=mysql_query($sqlTproducto,$con) or die(mysql_error());
        $Tprodcuto = mysql_fetch_assoc($resiltTproducto);
        
        echo "<div style='width: 100%;'>";
        echo "(*) Color";
        echo "</div>";
        echo "<div style='width: 100%;'>";
        echo "<select class='chosen-select form-control' style='width: 100%' id='color' name='color' data-placeholder='Seleccione el color' required='required'>";
        $sql_listaCOLORMAT="select * from colorenmaterial where idmaterial='".$Tprodcuto["idmaterial"]."'";
        $result_listaCOLORMAT=mysql_query($sql_listaCOLORMAT,$con) or die(mysql_error());
        if(mysql_num_rows($result_listaCOLORMAT)>0){
            while ($colormat = mysql_fetch_assoc($result_listaCOLORMAT)) {
                $sql_color="select * from color where idcolor='".$colormat["idcolor"]."'";
                $result_color=mysql_query($sql_color,$con) or die(mysql_error());
                $color = mysql_fetch_assoc($result_color);
                echo "<option value='".$color["idcolor"]."'>".$color["codigo"]." ".$color["nombre"]."</option>";
            }
        }
        echo "</select>";
        echo "</div>";           
        echo "</div>";
        echo "</div>";
    }    
    
    /*Cambia el patron del producto*/
    if($_POST["tarea"]==17){               
        $aux02=-1;
        echo "<div style='width: 100%;'>";
        echo "(*) Producto";
        echo "</div>";
        echo "<div style='width: 100%;'>";
        echo "<select class='chosen-select form-control' style='width: 100%' id='producto' name='producto' data-placeholder='Seleccione el producto' required='required'>";        
        $sql_listaPRODUCTO="select * from producto where idpatronproducto='".$_POST["idpatron"]."' order by descripcion";
        $result_listaPRODUCTO=mysql_query($sql_listaPRODUCTO,$con) or die(mysql_error());
        if(mysql_num_rows($result_listaPRODUCTO)>0){
            while ($producto = mysql_fetch_assoc($result_listaPRODUCTO)) {
                if($aux02==-1){
                    $aux02=$producto["idproducto"];
                }                
                echo "<option value='".$producto["idproducto"]."'>".$producto["codigo"]." ".$producto["descripcion"]."</option>";
            }
        }
        echo "</select>";
        echo "</div>";        
        echo "<div id='seleccion03'>";
        $sqlTproducto="select * from producto where idproducto='".$aux02."'";
        $resiltTproducto=mysql_query($sqlTproducto,$con) or die(mysql_error());
        $Tprodcuto = mysql_fetch_assoc($resiltTproducto);
        
        echo "<div style='width: 100%;'>";
        echo "(*) Color";
        echo "</div>";
        echo "<div style='width: 100%;'>";
        echo "<select class='chosen-select form-control' style='width: 100%' id='color' name='color' data-placeholder='Seleccione el color' required='required'>";
        $sql_listaCOLORMAT="select * from colorenmaterial where idmaterial='".$Tprodcuto["idmaterial"]."'";
        $result_listaCOLORMAT=mysql_query($sql_listaCOLORMAT,$con) or die(mysql_error());
        if(mysql_num_rows($result_listaCOLORMAT)>0){
            while ($colormat = mysql_fetch_assoc($result_listaCOLORMAT)) {
                $sql_color="select * from color where idcolor='".$colormat["idcolor"]."'";
                $result_color=mysql_query($sql_color,$con) or die(mysql_error());
                $color = mysql_fetch_assoc($result_color);
                echo "<option value='".$color["idcolor"]."'>".$color["codigo"]." ".$color["nombre"]."</option>";
            }
        }
        echo "</select>";
        echo "</div>";                                
    }    
    
    /*Cambia el patron del producto*/
    if($_POST["tarea"]==18){
        $sqlTproducto="select * from producto where idproducto='".$_POST["idproducto"]."'";
        $resiltTproducto=mysql_query($sqlTproducto,$con) or die(mysql_error());
        $Tprodcuto = mysql_fetch_assoc($resiltTproducto);        
        echo "<div style='width: 100%;'>";
        echo "(*) Color";
        echo "</div>";
        echo "<div style='width: 100%;'>";
        echo "<select class='chosen-select form-control' style='width: 100%' id='color' name='color' data-placeholder='Seleccione el color' required='required'>";
        $sql_listaCOLORMAT="select * from colorenmaterial where idmaterial='".$Tprodcuto["idmaterial"]."'";
        $result_listaCOLORMAT=mysql_query($sql_listaCOLORMAT,$con) or die(mysql_error());
        if(mysql_num_rows($result_listaCOLORMAT)>0){
            while ($colormat = mysql_fetch_assoc($result_listaCOLORMAT)) {
                $sql_color="select * from color where idcolor='".$colormat["idcolor"]."'";
                $result_color=mysql_query($sql_color,$con) or die(mysql_error());
                $color = mysql_fetch_assoc($result_color);
                echo "<option value='".$color["idcolor"]."'>".$color["codigo"]." ".$color["nombre"]."</option>";
            }
        }
        echo "</select>";
    } 
    
    if($_POST["tarea"]==19){
        $sqlProducto="select * from producto where idproducto='".$_POST["idproducto"]."'";
        $resultProducto=mysql_query($sqlProducto,$con) or die(mysql_error());
        $concatena="";
        if(mysql_num_rows($resultProducto)>0){
            while ($producto = mysql_fetch_assoc($resultProducto)) {
                $sqlcolor="select * from color where idcolor='".$_POST["idcolor"]."'";
                $resultcolor=mysql_query($sqlcolor,$con) or die(mysql_error());
                if(mysql_num_rows($resultcolor)>0){
                    $color = mysql_fetch_assoc($resultcolor);
                }
                if($_POST["tipoorden"]==1){
                    $precio=calcularprecio($producto["idproducto"], $_POST["idlista"]);
                }else if($_POST["tipoorden"]==2){
                    $precio=0;
                }
                
                $concatena=$producto["idproducto"]."_".$producto["codigo"]."_".$producto["descripcion"]."_".$color["nombre"]."_".$precio;
                echo "<input type='hidden' id='devuelve' value='".$concatena."' />";
            }   
        }
    }    
    
    if($_POST["tarea"]==20){
        $sqlEmpresa="select * from empresa where idempresa='".$_POST["idempresa"]."'";
        $resultEmpresa=mysql_query($sqlEmpresa,$con) or die(mysql_error());  
        $empresa = mysql_fetch_assoc($resultEmpresa);
        if($empresa["iva"]==0){
            echo "<input type='hidden' name='appiva' id='appiva' value='N'/>";
        }else if($empresa["iva"]==1){
            $sqlConfiguracion="select * from configuracionsistema where idconfiguracionsistema='1'";
            $resultConfiguracion=mysql_query($sqlConfiguracion,$con) or die(mysql_error());
            $configuracion = mysql_fetch_assoc($resultConfiguracion);            
            echo "<input type='hidden' name='appiva' id='appiva' value='S'/>";
            echo "<input type='hidden' name='poriva' id='poriva' value='".$configuracion["poriva"]."'/>";
        }
    }
    
    if($_POST["tarea"]==21){
        
        if($_POST["prioridad"]==2){
            echo "<div style='width: 70%;margin-top: 10px'>";                                                            
            echo "<label>(*) Fecha de Entrega</label>";
            echo "<div class='row'>";
            echo "<div class='col-xs-8 col-sm-11'>";
            echo "<div class='input-group'>";
            echo "<input class='form-control date-picker' id='id-date-picker-2' name='id-date-picker-2' type='text' data-date-format='yyyy-mm-dd' value='".date("Y")."-".date("m")."-".date("d")."' />";
            echo "<span class='input-group-addon'>";
            echo "<i class='fa fa-calendar bigger-110'></i>";
            echo "</span>";
            echo "</div>";
            echo "</div>";
            echo "</div>";                                                                                                                                                                                      
            echo "</div>";            
        }
        
             
    }
    
    if($_POST["tarea"]==22){
        $sqlProducto="select * from producto where idproducto='".$_POST["idproducto"]."'";
        $resultProducto=mysql_query($sqlProducto,$con) or die(mysql_error());
        $concatena="";
        if(mysql_num_rows($resultProducto)>0){
            while ($producto = mysql_fetch_assoc($resultProducto)) {
                $sqlcolor="select * from color where idcolor='".$_POST["idcolor"]."'";
                $resultcolor=mysql_query($sqlcolor,$con) or die(mysql_error());
                if(mysql_num_rows($resultcolor)>0){
                    $color = mysql_fetch_assoc($resultcolor);
                }
                $precio=$producto["preciofabrica"];
                $concatena=$producto["idproducto"]."_".$producto["codigo"]."_".$producto["descripcion"]."_".$color["nombre"]."_".$precio;
                echo "<input type='hidden' id='devuelve' value='".$concatena."' />";
            }   
        }
    }
    
    if($_POST["tarea"]==23){
        $sqlConfiguracion="select * from configuracionsistema where idconfiguracionsistema='1'";
        $resultConfiguracion=mysql_query($sqlConfiguracion,$con) or die(mysql_error());
        $configuracion = mysql_fetch_assoc($resultConfiguracion);            
        echo "<input type='hidden' name='appiva' id='appiva' value='S'/>";
        echo "<input type='hidden' name='poriva' id='poriva' value='".$configuracion["poriva"]."'/>";        
    }    
    
    mysql_close($con);    
?>