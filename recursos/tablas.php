<?php session_start(); 
 
    require_once("funciones.php");
    $con=Conexion();

    if($_POST["tabla"]=="empresas"){            
        echo "<div class='row cabecera_tabla'>";       
        if($_POST["campo"]=="empresa.codigo"){
            if($_POST["orden"]=="desc"){
                echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('empresa.codigo')>Código<i class='ace-icon glyphicon glyphicon-upload' style='float: right'></i></div>";
            }else if($_POST["orden"]=="asc"){
                echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('empresa.codigo')>Código<i class='ace-icon glyphicon glyphicon-download' style='float: right'></i></div>";
            }
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('empresa.identificador')>Identificador</div>";
            echo "<div class='col-xs-3 columna_cabecera' onclick=ordena('empresa.nombreempresa')>Nombre de la Empresa</div>";
            echo "<div class='col-xs-3 columna_cabecera' onclick=ordena('empresa.nombrecomercial')>Nombre Comercial</div>";        
        }else
        if($_POST["campo"]=="empresa.identificador"){
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('empresa.codigo')>Código</div>";
            if($_POST["orden"]=="desc"){
                echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('empresa.identificador')>Identificador<i class='ace-icon glyphicon glyphicon-upload' style='float: right'></i></div>";
            }else if($_POST["orden"]=="asc"){
                echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('empresa.identificador')>Identificador<i class='ace-icon glyphicon glyphicon-download' style='float: right'></i></div>";
            } 
            echo "<div class='col-xs-3 columna_cabecera' onclick=ordena('empresa.nombreempresa')>Nombre de la Empresa</div>";
            echo "<div class='col-xs-3 columna_cabecera' onclick=ordena('empresa.nombrecomercial')>Nombre Comercial</div>";        
        }else
        if($_POST["campo"]=="empresa.nombreempresa"){
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('empresa.codigo')>Código</div>";
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('empresa.identificador')>Identificador</div>";        
            if($_POST["orden"]=="desc"){
                echo "<div class='col-xs-3 columna_cabecera' onclick=ordena('empresa.nombreempresa')>Nombre de la Empresa<i class='ace-icon glyphicon glyphicon-upload' style='float: right'></i></div>";
            }else if($_POST["orden"]=="asc"){
                echo "<div class='col-xs-3 columna_cabecera' onclick=ordena('empresa.nombreempresa')>Nombre de la Empresa<i class='ace-icon glyphicon glyphicon-download' style='float: right'></i></div>";
            }
            echo "<div class='col-xs-3 columna_cabecera' onclick=ordena('empresa.nombrecomercial')>Nombre Comercial</div>";
        }else
        if($_POST["campo"]=="empresa.nombrecomercial"){
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('empresa.codigo')>Código</div>";
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('empresa.identificador')>Identificador</div>";
            echo "<div class='col-xs-3 columna_cabecera' onclick=ordena('empresa.nombreempresa')>Nombre de la Empresa</div>";        
            if($_POST["orden"]=="desc"){
                echo "<div class='col-xs-3 columna_cabecera' onclick=ordena('empresa.nombrecomercial')>Nombre Comercial<i class='ace-icon glyphicon glyphicon-upload' style='float: right'></i></div>";
            }else if($_POST["orden"]=="asc"){
                echo "<div class='col-xs-3 columna_cabecera' onclick=ordena('empresa.nombrecomercial')>Nombre Comercial<i class='ace-icon glyphicon glyphicon-download' style='float: right'></i></div>";
            }        
        }                                                            
        echo "</div>"; 
        
        $sql_listaEMPRESA="";
        if($_POST["filtro"]==""){
            $sql_listaEMPRESA="select pais.nombre, empresa.idempresa, empresa.nombreempresa, empresa.nombrecomercial, empresa.identificador, empresa.codigo from empresa, pais where empresa.idpais = pais.idpais order by ".$_POST["campo"]." ".$_POST["orden"];
        }else{
            $sql_listaEMPRESA="select pais.nombre, empresa.idempresa, empresa.nombreempresa, empresa.nombrecomercial, empresa.identificador, empresa.codigo from empresa, pais where empresa.idpais = pais.idpais and ".$_POST["camfiltro"]." LIKE '%".$_POST["filtro"]."%' order by ".$_POST["campo"]." ".$_POST["orden"];
        }               
        
        //echo $sql_listaEMPRESA;
        
        $result_listaEMPRESA=mysql_query($sql_listaEMPRESA,$con) or die(mysql_error());
        if(mysql_num_rows($result_listaEMPRESA)>0){
            $cuenta=0;
            while ($fila = mysql_fetch_assoc($result_listaEMPRESA)) {
                if($cuenta<($_POST["elementos"]*$_POST["pagina"]) && ($cuenta >=(($_POST["pagina"]*$_POST["elementos"])-$_POST["elementos"]) && $cuenta<($_POST["pagina"]*$_POST["elementos"]))){
                    echo "<div class='row linea_tabla'>";
                    echo "<div class='col-xs-2 columna_linea'>".$fila["codigo"]."</div>";
                    echo "<div class='col-xs-2 columna_linea'>".$fila["identificador"]."</div>";
                    echo "<div class='col-xs-3 columna_linea'>".$fila["nombreempresa"]."</div>";
                    echo "<div class='col-xs-3 columna_linea'>".$fila["nombrecomercial"]."</div>";
                    echo "<div class='col-xs-2' >";
                    echo "<div class='btn-group'>";
                    echo "<button data-toggle='dropdown' class='btn btn-primary btn-sm btn-white dropdown-toggle'>";
                    echo "Acciones <span class='ace-icon fa fa-caret-down icon-on-right'></span>";
                    echo "</button>";
                    echo "<ul class='dropdown-menu dropdown-default'>";
                    if(habilitaMenu($_SESSION["usuario"],1,1,3)==1){
                        echo "<li><a href='editarempresa.php?id=".$fila["idempresa"]."'>Editar</a></li>";
                    }
                    if(habilitaMenu($_SESSION["usuario"],1,1,4)==1){
                        echo "<li><a href='pdfs/empresas.php?id=".$fila["idempresa"]."' target='_blank'>Informe en PDF</a></li>";
                    }
                    echo "</ul>";                                                                                                                                
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";  
                }
                $cuenta++;
            }
        }
                        
        echo "<div class='row pie_tabla' >";
                                                    
            $numeroelementos=mysql_num_rows($result_listaEMPRESA);   
            if($_POST["elementos"]>$numeroelementos){
                echo "Mostrando ".$numeroelementos." de ".$numeroelementos." elementos";
            }else{
                echo "Mostrando ".$_POST["elementos"]." de ".$numeroelementos." elementos";
            }
                               
                                                        
            $numeropaginas=  ceil($numeroelementos/$_POST["elementos"]);
            echo "<ul class='pagination pull-right' style='margin-right: 10px;margin-top: 0px;margin-bottom: 0px'>";
            echo "<li class='prev' onclick='pagina(1)'><a><i class='ace-icon fa fa-angle-double-left'></i></a></li>";
            for($i=($_POST["pagina"]-3);$i<$numeropaginas && $i<($_POST["pagina"]+2);$i++){
                if($i>-1){                    
                    if($i==($_POST["pagina"]-1)){
                        echo "<li onclick='pagina(".($i+1).")' class='active'><a>".($i+1)."</a></li>";
                    }else{
                        echo "<li onclick='pagina(".($i+1).")'><a>".($i+1)."</a></li>";
                    }                    
                }                                                            
            }
            echo "<li onclick='pagina(".($numeropaginas).")' class='next'><a><i class='ace-icon fa fa-angle-double-right'></i></a></li>";
            echo "</ul>";
                                                                                                    
        echo "</div>";                
    }
    
    
    
    
    
    if($_POST["tabla"]=="sucursales"){                       
        echo "<div class='row cabecera_tabla'>";
        if($_POST["campo"]=="pais.nombre"){
            if($_POST["orden"]=="desc"){
                echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('pais.nombre')>País<i class='ace-icon glyphicon glyphicon-upload' style='float: right'></i></div>";
            }else if($_POST["orden"]=="asc"){
                echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('pais.nombre')>País<i class='ace-icon glyphicon glyphicon-download' style='float: right'></i></div>";
            }
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('empresa.nombreempresa')>Empresa Matriz</div>";
            echo "<div class='col-xs-3 columna_cabecera' onclick=ordena('sucursal.nombrecomercial')>Nombre Sucursal</div>";
            echo "<div class='col-xs-3 columna_cabecera' onclick=ordena('sucursal.regiones')>Regiones</div>";        
        }else
        if($_POST["campo"]=="empresa.nombreempresa"){
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('pais.nombre')>País</div>";
            if($_POST["orden"]=="desc"){
                echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('empresa.nombreempresa')>Empresa Matriz<i class='ace-icon glyphicon glyphicon-upload' style='float: right'></i></div>";
            }else if($_POST["orden"]=="asc"){
                echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('empresa.nombreempresa')>Empresa Matriz<i class='ace-icon glyphicon glyphicon-download' style='float: right'></i></div>";
            } 
            echo "<div class='col-xs-3 columna_cabecera' onclick=ordena('sucursal.nombrecomercial')>Nombre Sucursal</div>";
            echo "<div class='col-xs-3 columna_cabecera' onclick=ordena('sucursal.regiones')>Regiones</div>";        
        }else
        if($_POST["campo"]=="sucursal.nombrecomercial"){
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('pais.nombre')>País</div>";
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('empresa.nombreempresa')>Empresa Matriz</div>";        
            if($_POST["orden"]=="desc"){
                echo "<div class='col-xs-3 columna_cabecera' onclick=ordena('sucursal.nombrecomercial')>Nombre Sucursal<i class='ace-icon glyphicon glyphicon-upload' style='float: right'></i></div>";
            }else if($_POST["orden"]=="asc"){
                echo "<div class='col-xs-3 columna_cabecera' onclick=ordena('sucursal.nombrecomercial')>Nombre Sucursal<i class='ace-icon glyphicon glyphicon-download' style='float: right'></i></div>";
            }
            echo "<div class='col-xs-3 columna_cabecera' onclick=ordena('sucursal.regiones')>Regiones</div>";
        }else
        if($_POST["campo"]=="sucursal.regiones"){
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('pais.nombre')>País</div>";
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('empresa.nombreempresa')>Empresa Matriz</div>";
            echo "<div class='col-xs-3 columna_cabecera' onclick=ordena('sucursal.nombrecomercial')>Nombre Sucursal</div>";        
            if($_POST["orden"]=="desc"){
                echo "<div class='col-xs-3 columna_cabecera' onclick=ordena('sucursal.regiones')>Regiones<i class='ace-icon glyphicon glyphicon-upload' style='float: right'></i></div>";
            }else if($_POST["orden"]=="asc"){
                echo "<div class='col-xs-3 columna_cabecera' onclick=ordena('sucursal.regiones')>Regiones<i class='ace-icon glyphicon glyphicon-download' style='float: right'></i></div>";
            }        
        }                                                            
        echo "</div>"; 
        
        $sql_listaEMPRESA="";
        if($_POST["filtro"]==""){            
            $sql_listaEMPRESA="select sucursal.idsucursal, pais.nombre, empresa.nombreempresa, sucursal.nombrecomercial, sucursal.regiones from pais, empresa, sucursal where sucursal.idempresa = empresa.idempresa and empresa.idpais = pais.idpais order by ".$_POST["campo"]." ".$_POST["orden"];
        }else{            
            $sql_listaEMPRESA="select sucursal.idsucursal, pais.nombre, empresa.nombreempresa, sucursal.nombrecomercial, sucursal.regiones from pais, empresa, sucursal where sucursal.idempresa = empresa.idempresa and empresa.idpais = pais.idpais and ".$_POST["camfiltro"]." LIKE '%".$_POST["filtro"]."%' order by ".$_POST["campo"]." ".$_POST["orden"];            
        }               
        
        //echo $sql_listaEMPRESA;
        
        $result_listaEMPRESA=mysql_query($sql_listaEMPRESA,$con) or die(mysql_error());
        if(mysql_num_rows($result_listaEMPRESA)>0){
            $cuenta=0;
            while ($fila = mysql_fetch_assoc($result_listaEMPRESA)) {
                //echo $cuenta." --> ".(($_POST["pagina"]*$_POST["elementos"])-$_POST["elementos"])."  --  ".($_POST["pagina"]*$_POST["elementos"])."</br>";
                if($cuenta<($_POST["elementos"]*$_POST["pagina"]) && ($cuenta >=(($_POST["pagina"]*$_POST["elementos"])-$_POST["elementos"]) && $cuenta<($_POST["pagina"]*$_POST["elementos"]))){
                    echo "<div class='row linea_tabla'>";
                    echo "<div class='col-xs-2 columna_linea'>".$fila["nombre"]."</div>";
                    echo "<div class='col-xs-2 columna_linea'>".$fila["nombreempresa"]."</div>";
                    echo "<div class='col-xs-3 columna_linea'>".$fila["nombrecomercial"]."</div>";
                    echo "<div class='col-xs-3 columna_linea'>".$fila["regiones"]."</div>";
                    echo "<div class='col-xs-2' >";
                    echo "<div class='btn-group'>";
                    echo "<button data-toggle='dropdown' class='btn btn-primary btn-sm btn-white dropdown-toggle'>";
                    echo "Acciones <span class='ace-icon fa fa-caret-down icon-on-right'></span>";
                    echo "</button>";
                    echo "<ul class='dropdown-menu dropdown-default'>";
                    if(habilitaMenu($_SESSION["usuario"],1,2,3)==1){
                        echo "<li><a href='editarsucursal.php?id=".$fila["idsucursal"]."'>Editar</a></li>";                                                                
                    }
                    echo "</ul>";                                                                                                                                
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";                    
                }
                $cuenta++;
            }
        }
                        
        echo "<div class='row pie_tabla' >";
                                                    
            $numeroelementos=mysql_num_rows($result_listaEMPRESA);   
            if($_POST["elementos"]>$numeroelementos){
                echo "Mostrando ".$numeroelementos." de ".$numeroelementos." elementos";
            }else{
                echo "Mostrando ".$_POST["elementos"]." de ".$numeroelementos." elementos";
            }
                               
                                                        
            $numeropaginas=  ceil($numeroelementos/$_POST["elementos"]);
            echo "<ul class='pagination pull-right' style='margin-right: 10px;margin-top: 0px;margin-bottom: 0px'>";
            echo "<li class='prev' onclick='pagina(1)'><a><i class='ace-icon fa fa-angle-double-left'></i></a></li>";
            for($i=($_POST["pagina"]-3);$i<$numeropaginas && $i<($_POST["pagina"]+2);$i++){
                if($i>-1){                    
                    if($i==($_POST["pagina"]-1)){
                        echo "<li onclick='pagina(".($i+1).")' class='active'><a>".($i+1)."</a></li>";
                    }else{
                        echo "<li onclick='pagina(".($i+1).")'><a>".($i+1)."</a></li>";
                    }                    
                }                                                            
            }
            echo "<li onclick='pagina(".($numeropaginas).")' class='next'><a><i class='ace-icon fa fa-angle-double-right'></i></a></li>";
            echo "</ul>";
                                                                                                    
        echo "</div>";                
    }  
    
    
    
    if($_POST["tabla"]=="materiales"){                       
        echo "<div class='row cabecera_tabla'>";
        if($_POST["campo"]=="material.codigo"){
            if($_POST["orden"]=="desc"){
                echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('material.codigo')>Código<i class='ace-icon glyphicon glyphicon-upload' style='float: right'></i></div>";
            }else if($_POST["orden"]=="asc"){
                echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('material.codigo')>Código<i class='ace-icon glyphicon glyphicon-download' style='float: right'></i></div>";
            }
            echo "<div class='col-xs-3 columna_cabecera' onclick=ordena('material.nombre')>Nombre</div>";
            echo "<div class='col-xs-5 columna_cabecera' onclick=ordena('material.colores')>Colores</div>";        
        }else
        if($_POST["campo"]=="material.nombre"){
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('material.codigo')>Código</div>";
            if($_POST["orden"]=="desc"){
                echo "<div class='col-xs-3 columna_cabecera' onclick=ordena('material.nombre')>Nombre<i class='ace-icon glyphicon glyphicon-upload' style='float: right'></i></div>";
            }else if($_POST["orden"]=="asc"){
                echo "<div class='col-xs-3 columna_cabecera' onclick=ordena('material.nombre')>Nombre<i class='ace-icon glyphicon glyphicon-download' style='float: right'></i></div>";
            } 
            echo "<div class='col-xs-5 columna_cabecera' onclick=ordena('material.colores')>Colores</div>";        
        }else
        if($_POST["campo"]=="material.colores"){
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('material.codigo')>Código</div>";
            echo "<div class='col-xs-3 columna_cabecera' onclick=ordena('material.nombre')>Nombre</div>";       
            if($_POST["orden"]=="desc"){
                echo "<div class='col-xs-5 columna_cabecera' onclick=ordena('material.colores')>Colores<i class='ace-icon glyphicon glyphicon-upload' style='float: right'></i></div>";
            }else if($_POST["orden"]=="asc"){
                echo "<div class='col-xs-5 columna_cabecera' onclick=ordena('material.colores')>Colores<i class='ace-icon glyphicon glyphicon-download' style='float: right'></i></div>";
            }        
        }                                                            
        echo "</div>"; 
        
        $sql_listaEMPRESA="";
        if($_POST["filtro"]==""){
            $sql_listaEMPRESA="select material.codigo, material.nombre, material.colores, material.idmaterial from material order by ".$_POST["campo"]." ".$_POST["orden"];
        }else{            
            $sql_listaEMPRESA="select material.codigo, material.nombre, material.colores, material.idmaterial from material where ".$_POST["camfiltro"]." LIKE '%".$_POST["filtro"]."%' order by ".$_POST["campo"]." ".$_POST["orden"];            
        }               
        
        //echo $sql_listaEMPRESA;
        
        $result_listaEMPRESA=mysql_query($sql_listaEMPRESA,$con) or die(mysql_error());
        if(mysql_num_rows($result_listaEMPRESA)>0){
            $cuenta=0;
            while ($fila = mysql_fetch_assoc($result_listaEMPRESA)) {
                if($cuenta<($_POST["elementos"]*$_POST["pagina"]) && ($cuenta >=(($_POST["pagina"]*$_POST["elementos"])-$_POST["elementos"]) && $cuenta<($_POST["pagina"]*$_POST["elementos"]))){
                    echo "<div class='row linea_tabla'>";
                    echo "<div class='col-xs-2 columna_linea'>".$fila["codigo"]."</div>";
                    echo "<div class='col-xs-3 columna_linea'>".$fila["nombre"]."</div>";
                    echo "<div class='col-xs-5 columna_linea'>".$fila["colores"]."</div>";
                    echo "<div class='col-xs-2' >";
                    echo "<div class='btn-group'>";
                    echo "<button data-toggle='dropdown' class='btn btn-primary btn-sm btn-white dropdown-toggle'>";
                    echo "Acciones <span class='ace-icon fa fa-caret-down icon-on-right'></span>";
                    echo "</button>";
                    echo "<ul class='dropdown-menu dropdown-default'>";
                    if(habilitaMenu($_SESSION["usuario"],2,4,3)==1){
                        echo "<li><a href='editarmaterial.php?id=".$fila["idmaterial"]."'>Editar</a></li>";                                                                
                    }
                    echo "</ul>";                                                                                                                                
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";  
                }
                $cuenta++;
            }
        }
                        
        echo "<div class='row pie_tabla' >";
                                                    
            $numeroelementos=mysql_num_rows($result_listaEMPRESA);   
            if($_POST["elementos"]>$numeroelementos){
                echo "Mostrando ".$numeroelementos." de ".$numeroelementos." elementos";
            }else{
                echo "Mostrando ".$_POST["elementos"]." de ".$numeroelementos." elementos";
            }
                               
                                                        
            $numeropaginas=  ceil($numeroelementos/$_POST["elementos"]);
            echo "<ul class='pagination pull-right' style='margin-right: 10px;margin-top: 0px;margin-bottom: 0px'>";
            echo "<li class='prev' onclick='pagina(1)'><a><i class='ace-icon fa fa-angle-double-left'></i></a></li>";
            for($i=($_POST["pagina"]-3);$i<$numeropaginas && $i<($_POST["pagina"]+2);$i++){
                if($i>-1){                    
                    if($i==($_POST["pagina"]-1)){
                        echo "<li onclick='pagina(".($i+1).")' class='active'><a>".($i+1)."</a></li>";
                    }else{
                        echo "<li onclick='pagina(".($i+1).")'><a>".($i+1)."</a></li>";
                    }                    
                }                                                            
            }
            echo "<li onclick='pagina(".($numeropaginas).")' class='next'><a><i class='ace-icon fa fa-angle-double-right'></i></a></li>";
            echo "</ul>";
                                                                                                    
        echo "</div>";                
    }
    
    
    
    
    
    
    
    if($_POST["tabla"]=="patrones"){                       
        echo "<div class='row cabecera_tabla'>";
        if($_POST["campo"]=="categoria"){
            if($_POST["orden"]=="desc"){
                echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('categoria')>Tipo de Producto<i class='ace-icon glyphicon glyphicon-upload' style='float: right'></i></div>";
            }else if($_POST["orden"]=="asc"){
                echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('categoria')>Tipo de Producto<i class='ace-icon glyphicon glyphicon-download' style='float: right'></i></div>";
            }
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('espanol')>Nombre en Español</div>";
            echo "<div class='col-xs-3 columna_cabecera' onclick=ordena('ingles')>Nombre en Ingles</div>";
            echo "<div class='col-xs-3 columna_cabecera' onclick=ordena('materiales')>Materiales</div>";        
        }else
        if($_POST["campo"]=="espanol"){
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('categoria')>Tipo de Producto</div>";
            if($_POST["orden"]=="desc"){
                echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('espanol')>Nombre en Español<i class='ace-icon glyphicon glyphicon-upload' style='float: right'></i></div>";
            }else if($_POST["orden"]=="asc"){
                echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('espanol')>Nombre en Español<i class='ace-icon glyphicon glyphicon-download' style='float: right'></i></div>";
            } 
            echo "<div class='col-xs-3 columna_cabecera' onclick=ordena('ingles')>Nombre en Ingles</div>";
            echo "<div class='col-xs-3 columna_cabecera' onclick=ordena('materiales')>Materiales</div>";        
        }else
        if($_POST["campo"]=="ingles"){
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('categoria')>Tipo de Producto</div>";
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('espanol')>Nombre en Español</div>";        
            if($_POST["orden"]=="desc"){
                echo "<div class='col-xs-3 columna_cabecera' onclick=ordena('ingles')>Nombre en Ingles<i class='ace-icon glyphicon glyphicon-upload' style='float: right'></i></div>";
            }else if($_POST["orden"]=="asc"){
                echo "<div class='col-xs-3 columna_cabecera' onclick=ordena('ingles')>Nombre en Ingles<i class='ace-icon glyphicon glyphicon-download' style='float: right'></i></div>";
            }
            echo "<div class='col-xs-3 columna_cabecera' onclick=ordena('materiales')>Materiales</div>";
        }else
        if($_POST["campo"]=="materiales"){
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('categoria')>Tipo de Producto</div>";
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('espanol')>Nombre en Español</div>";
            echo "<div class='col-xs-3 columna_cabecera' onclick=ordena('ingles')>Nombre en Ingles</div>";        
            if($_POST["orden"]=="desc"){
                echo "<div class='col-xs-3 columna_cabecera' onclick=ordena('materiales')>Materiales<i class='ace-icon glyphicon glyphicon-upload' style='float: right'></i></div>";
            }else if($_POST["orden"]=="asc"){
                echo "<div class='col-xs-3 columna_cabecera' onclick=ordena('materiales')>Materiales<i class='ace-icon glyphicon glyphicon-download' style='float: right'></i></div>";
            }        
        }                                                            
        echo "</div>"; 
        
        $sql_listaEMPRESA="";
        if($_POST["filtro"]==""){            
            $sql_listaEMPRESA="select categoriaproducto.nombreespanol as categoria,patronproducto.nombreespanol as espanol, patronproducto.nombreingles as ingles, patronproducto.materiales as materiales, patronproducto.idpatronproducto from categoriaproducto, patronproducto where patronproducto.idcategoriaproducto = categoriaproducto.idcategoriaproducto order by ".$_POST["campo"]." ".$_POST["orden"];            
        }else{            
            $sql_listaEMPRESA="select categoriaproducto.nombreespanol as categoria,patronproducto.nombreespanol as espanol, patronproducto.nombreingles as ingles, patronproducto.materiales as materiales, patronproducto.idpatronproducto from categoriaproducto, patronproducto where patronproducto.idcategoriaproducto = categoriaproducto.idcategoriaproducto and ".$_POST["camfiltro"]." LIKE '%".$_POST["filtro"]."%' order by ".$_POST["campo"]." ".$_POST["orden"];            
        }               
        
        //echo $sql_listaEMPRESA;
        
        $result_listaEMPRESA=mysql_query($sql_listaEMPRESA,$con) or die(mysql_error());
        if(mysql_num_rows($result_listaEMPRESA)>0){
            $cuenta=0;
            while ($fila = mysql_fetch_assoc($result_listaEMPRESA)) {
                if($cuenta<($_POST["elementos"]*$_POST["pagina"]) && ($cuenta >=(($_POST["pagina"]*$_POST["elementos"])-$_POST["elementos"]) && $cuenta<($_POST["pagina"]*$_POST["elementos"]))){
                    echo "<div class='row linea_tabla'>";
                    echo "<div class='col-xs-2 columna_linea'>".$fila["categoria"]."</div>";
                    echo "<div class='col-xs-2 columna_linea'>".$fila["espanol"]."</div>";
                    echo "<div class='col-xs-3 columna_linea'>".$fila["ingles"]."</div>";
                    echo "<div class='col-xs-3 columna_linea'>".$fila["materiales"]."</div>";
                    echo "<div class='col-xs-2' >";
                    echo "<div class='btn-group'>";
                    echo "<button data-toggle='dropdown' class='btn btn-primary btn-sm btn-white dropdown-toggle'>";
                    echo "Acciones <span class='ace-icon fa fa-caret-down icon-on-right'></span>";
                    echo "</button>";
                    echo "<ul class='dropdown-menu dropdown-default'>";
                    if(habilitaMenu($_SESSION["usuario"],2,5,3)==1){
                        echo "<li><a href='editarpatron.php?id=".$fila["idpatronproducto"]."'>Editar</a></li>"; 
                    }
                    if(habilitaMenu($_SESSION["usuario"],2,5,4)==1){
                        echo "<li><a href='pdfs/patronesproducto.php?id=".$fila["idpatronproducto"]."'  target='_blank'>Informe en PDF</a></li>";
                    }
                    echo "</ul>";                                                                                                                                
                    echo "</div>";                    
                    echo "</div>";
                    echo "</div>";  
                }
                $cuenta++;
            }
        }
                        
        echo "<div class='row pie_tabla' >";
                                                    
            $numeroelementos=mysql_num_rows($result_listaEMPRESA);   
            if($_POST["elementos"]>$numeroelementos){
                echo "Mostrando ".$numeroelementos." de ".$numeroelementos." elementos";
            }else{
                echo "Mostrando ".$_POST["elementos"]." de ".$numeroelementos." elementos";
            }
                               
                                                        
            $numeropaginas=  ceil($numeroelementos/$_POST["elementos"]);
            echo "<ul class='pagination pull-right' style='margin-right: 10px;margin-top: 0px;margin-bottom: 0px'>";
            echo "<li class='prev' onclick='pagina(1)'><a><i class='ace-icon fa fa-angle-double-left'></i></a></li>";
            for($i=($_POST["pagina"]-3);$i<$numeropaginas && $i<($_POST["pagina"]+2);$i++){
                if($i>-1){                    
                    if($i==($_POST["pagina"]-1)){
                        echo "<li onclick='pagina(".($i+1).")' class='active'><a>".($i+1)."</a></li>";
                    }else{
                        echo "<li onclick='pagina(".($i+1).")'><a>".($i+1)."</a></li>";
                    }                    
                }                                                            
            }
            echo "<li onclick='pagina(".($numeropaginas).")' class='next'><a><i class='ace-icon fa fa-angle-double-right'></i></a></li>";
            echo "</ul>";
                                                                                                    
        echo "</div>";                
    }    
    
    
    
    
    
    if($_POST["tabla"]=="productos"){                       
        echo "<div class='row cabecera_tabla'>";
        if($_POST["campo"]=="producto.codigo"){
            if($_POST["orden"]=="desc"){
                echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('producto.codigo')>Código<i class='ace-icon glyphicon glyphicon-upload' style='float: right'></i></div>";
            }else if($_POST["orden"]=="asc"){
                echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('producto.codigo')>Código<i class='ace-icon glyphicon glyphicon-download' style='float: right'></i></div>";
            }
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('material.nombre')>Material</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('tipoproducto.codig')>Tipo</div>";
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('producto.descripcion')>Producto</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('categoriaproducto.nombreespanol')>Forma del Producto</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('producto.dimensionlargo')>Largo (cm)</div>";        
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('producto.dimensionancho')>Ancho (cm)</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('producto.dimensionalto')>Alto (cm)</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('producto.preciofabrica')>Precio de Fabrica</div>";
        }else
        if($_POST["campo"]=="material.nombre"){
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('producto.codigo')>Código</div>";
            if($_POST["orden"]=="desc"){
                echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('material.nombre')>Material<i class='ace-icon glyphicon glyphicon-upload' style='float: right'></i></div>";
            }else if($_POST["orden"]=="asc"){
                echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('material.nombre')>Material<i class='ace-icon glyphicon glyphicon-download' style='float: right'></i></div>";
            }
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('tipoproducto.codig')>Tipo</div>";
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('producto.descripcion')>Producto</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('categoriaproducto.nombreespanol')>Forma del Producto</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('producto.dimensionlargo')>Largo (cm)</div>";        
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('producto.dimensionancho')>Ancho (cm)</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('producto.dimensionalto')>Alto (cm)</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('producto.preciofabrica')>Precio de Fabrica</div>";
        }else 
        if($_POST["campo"]=="tipoproducto.codig"){
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('producto.codigo')>Código</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('material.nombre')>Material</div>";            
            if($_POST["orden"]=="desc"){
                echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('tipoproducto.codig')>Tipo<i class='ace-icon glyphicon glyphicon-upload' style='float: right'></i></div>";
            }else if($_POST["orden"]=="asc"){
                echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('tipoproducto.codig')>Tipo<i class='ace-icon glyphicon glyphicon-download' style='float: right'></i></div>";
            }
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('producto.descripcion')>Producto</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('categoriaproducto.nombreespanol')>Forma del Producto</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('producto.dimensionlargo')>Largo (cm)</div>";        
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('producto.dimensionancho')>Ancho (cm)</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('producto.dimensionalto')>Alto (cm)</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('producto.preciofabrica')>Precio de Fabrica</div>";
        }else             
        if($_POST["campo"]=="producto.descripcion"){
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('producto.codigo')>Código</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('material.nombre')>Material</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('tipoproducto.codig')>Tipo</div>";
            if($_POST["orden"]=="desc"){
                echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('producto.descripcion')>Producto<i class='ace-icon glyphicon glyphicon-upload' style='float: right'></i></div>";
            }else if($_POST["orden"]=="asc"){
                echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('producto.descripcion')>Producto<i class='ace-icon glyphicon glyphicon-download' style='float: right'></i></div>";
            } 
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('categoriaproducto.nombreespanol')>Forma del Producto</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('producto.dimensionlargo')>Largo (cm)</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('producto.dimensionancho')>Ancho (cm)</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('producto.dimensionalto')>Alto (cm)</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('producto.preciofabrica')>Precio de Fabrica</div>";            
        }else
        if($_POST["campo"]=="categoriaproducto.nombreespanol"){
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('producto.codigo')>Código</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('material.nombre')>Material</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('tipoproducto.codig')>Tipo</div>";
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('producto.descripcion')>Producto</div>";        
            if($_POST["orden"]=="desc"){
                echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('categoriaproducto.nombreespanol')>Forma del Producto<i class='ace-icon glyphicon glyphicon-upload' style='float: right'></i></div>";
            }else if($_POST["orden"]=="asc"){
                echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('categoriaproducto.nombreespanol')>Forma del Producto<i class='ace-icon glyphicon glyphicon-download' style='float: right'></i></div>";
            }
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('producto.dimensionlargo')>Largo (cm)</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('producto.dimensionancho')>Ancho (cm)</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('producto.dimensionalto')>Alto (cm)</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('producto.preciofabrica')>Precio de Fabrica</div>";            
        }else
        if($_POST["campo"]=="producto.dimensionlargo"){
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('producto.codigo')>Código</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('material.nombre')>Material</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('tipoproducto.codig')>Tipo</div>";
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('producto.descripcion')>Producto</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('categoriaproducto.nombreespanol')>Forma del Producto</div>";        
            if($_POST["orden"]=="desc"){
                echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('producto.dimensionlargo')>Largo (cm)<i class='ace-icon glyphicon glyphicon-upload' style='float: right'></i></div>";
            }else if($_POST["orden"]=="asc"){
                echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('producto.dimensionlargo')>Largo (cm)<i class='ace-icon glyphicon glyphicon-download' style='float: right'></i></div>";
            } 
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('producto.dimensionancho')>Ancho (cm)</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('producto.dimensionalto')>Alto (cm)</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('producto.preciofabrica')>Precio de Fabrica</div>";            
        }else
        if($_POST["campo"]=="producto.dimensionancho"){
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('producto.codigo')>Código</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('material.nombre')>Material</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('tipoproducto.codig')>Tipo</div>";
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('producto.descripcion')>Producto</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('categoriaproducto.nombreespanol')>Forma del Producto</div>";        
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('producto.dimensionlargo')>Largo (cm)</div>";
            if($_POST["orden"]=="desc"){
                echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('producto.dimensionancho')>Ancho (cm)<i class='ace-icon glyphicon glyphicon-upload' style='float: right'></i></div>";
            }else if($_POST["orden"]=="asc"){
                echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('producto.dimensionancho')>Ancho (cm)<i class='ace-icon glyphicon glyphicon-download' style='float: right'></i></div>";
            } 
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('producto.dimensionalto')>Alto (cm)</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('producto.preciofabrica')>Precio de Fabrica</div>";            
        }else
        if($_POST["campo"]=="producto.dimensionalto"){
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('producto.codigo')>Código</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('material.nombre')>Material</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('tipoproducto.codig')>Tipo</div>";
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('producto.descripcion')>Producto</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('categoriaproducto.nombreespanol')>Forma del Producto</div>";        
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('producto.dimensionlargo')>Largo (cm)</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('producto.dimensionancho')>Ancho (cm)</div>";
            if($_POST["orden"]=="desc"){
                echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('producto.dimensionalto')>Alto (cm)<i class='ace-icon glyphicon glyphicon-upload' style='float: right'></i></div>";
            }else if($_POST["orden"]=="asc"){
                echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('producto.dimensionalto')>Alto (cm)<i class='ace-icon glyphicon glyphicon-download' style='float: right'></i></div>";
            }
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('producto.preciofabrica')>Precio de Fabrica</div>";            
        }else
        if($_POST["campo"]=="producto.preciofabrica"){
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('producto.codigo')>Código</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('material.nombre')>Material</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('tipoproducto.codig')>Tipo</div>";
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('producto.descripcion')>Producto</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('categoriaproducto.nombreespanol')>Forma del Producto</div>";        
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('producto.dimensionlargo')>Largo (cm)</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('producto.dimensionancho')>Ancho (cm)</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('producto.dimensionalto')>Alto (cm)</div>";
            if($_POST["orden"]=="desc"){
                echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('producto.preciofabrica')>Precio de Fabrica<i class='ace-icon glyphicon glyphicon-upload' style='float: right'></i></div>";
            }else if($_POST["orden"]=="asc"){
                echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('producto.preciofabrica')>Precio de Fabrica<i class='ace-icon glyphicon glyphicon-download' style='float: right'></i></div>";
            }            
        }              
        echo "</div>"; 
        
        $sql_listaEMPRESA="";
        if($_POST["filtro"]==""){            
            $sql_listaEMPRESA="select producto.codigo, producto.descripcion, categoriaproducto.nombreespanol, producto.dimensionlargo, producto.dimensionancho, producto.dimensionalto, producto.preciofabrica, producto.idproducto, material.nombre, tipoproducto.codig from producto, patronproducto, categoriaproducto, material, tipoproducto where producto.idpatronproducto = patronproducto.idpatronproducto and patronproducto.idcategoriaproducto = categoriaproducto.idcategoriaproducto and producto.idmaterial = material.idmaterial and producto.idtipoproducto = tipoproducto.idtipoproducto order by ".$_POST["campo"]." ".$_POST["orden"];
        }else{            
            $sql_listaEMPRESA="select producto.codigo, producto.descripcion, categoriaproducto.nombreespanol, producto.dimensionlargo, producto.dimensionancho, producto.dimensionalto, producto.preciofabrica, producto.idproducto, material.nombre, tipoproducto.codig from producto, patronproducto, categoriaproducto, material, tipoproducto where producto.idpatronproducto = patronproducto.idpatronproducto and patronproducto.idcategoriaproducto = categoriaproducto.idcategoriaproducto and producto.idmaterial = material.idmaterial and producto.idtipoproducto = tipoproducto.idtipoproducto and ".$_POST["camfiltro"]." LIKE '%".$_POST["filtro"]."%' order by ".$_POST["campo"]." ".$_POST["orden"];
        }               
        
        //echo $sql_listaEMPRESA;
        
        $result_listaEMPRESA=mysql_query($sql_listaEMPRESA,$con) or die(mysql_error());
        if(mysql_num_rows($result_listaEMPRESA)>0){
            $cuenta=0;
            while ($fila = mysql_fetch_assoc($result_listaEMPRESA)) {
                if($cuenta<($_POST["elementos"]*$_POST["pagina"]) && ($cuenta >=(($_POST["pagina"]*$_POST["elementos"])-$_POST["elementos"]) && $cuenta<($_POST["pagina"]*$_POST["elementos"]))){
                    echo "<div class='row linea_tabla'>";
                    echo "<div class='col-xs-1 columna_linea'>".$fila["codigo"]."</div>";
                    echo "<div class='col-xs-1 columna_linea'>".$fila["nombre"]."</div>";
                    echo "<div class='col-xs-1 columna_linea'>".$fila["codig"]."</div>";
                    echo "<div class='col-xs-2 columna_linea'>".$fila["descripcion"]."</div>";
                    echo "<div class='col-xs-1 columna_linea'>".$fila["nombreespanol"]."</div>";
                    echo "<div class='col-xs-1 columna_linea'>".$fila["dimensionlargo"]."</div>";
                    echo "<div class='col-xs-1 columna_linea'>".$fila["dimensionancho"]."</div>";
                    echo "<div class='col-xs-1 columna_linea'>".$fila["dimensionalto"]."</div>";                                                                
                    echo "<div class='col-xs-1 columna_linea'>".$fila["preciofabrica"]."</div>";
                    echo "<div class='col-xs-2' >";
                    echo "<div class='btn-group'>";
                    echo "<button data-toggle='dropdown' class='btn btn-primary btn-sm btn-white dropdown-toggle'>";
                    echo "Acciones <span class='ace-icon fa fa-caret-down icon-on-right'></span>";
                    echo "</button>";
                    echo "<ul class='dropdown-menu dropdown-default'>";
                    if(habilitaMenu($_SESSION["usuario"],2,6,3)==1){
                        echo "<li><a href='editarproducto.php?id=".$fila["idproducto"]."'>Editar</a></li>";                    
                    }
                    if(habilitaMenu($_SESSION["usuario"],2,6,4)==1){
                        echo "<li><a href='pdfs/producto.php?id=".$fila["idproducto"]."' target='_blank'>Informe en PDF</a></li>";                                                                                                                                
                    }
                    echo "</ul>";                                                                                                                                
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";  
                }
                $cuenta++;
            }
        }
                        
        echo "<div class='row pie_tabla' >";
                                                    
            $numeroelementos=mysql_num_rows($result_listaEMPRESA);   
            if($_POST["elementos"]>$numeroelementos){
                echo "Mostrando ".$numeroelementos." de ".$numeroelementos." elementos";
            }else{
                echo "Mostrando ".$_POST["elementos"]." de ".$numeroelementos." elementos";
            }
                               
                                                        
            $numeropaginas=  ceil($numeroelementos/$_POST["elementos"]);
            echo "<ul class='pagination pull-right' style='margin-right: 10px;margin-top: 0px;margin-bottom: 0px'>";
            echo "<li class='prev' onclick='pagina(1)'><a><i class='ace-icon fa fa-angle-double-left'></i></a></li>";
            for($i=($_POST["pagina"]-3);$i<$numeropaginas && $i<($_POST["pagina"]+2);$i++){
                if($i>-1){                    
                    if($i==($_POST["pagina"]-1)){
                        echo "<li onclick='pagina(".($i+1).")' class='active'><a>".($i+1)."</a></li>";
                    }else{
                        echo "<li onclick='pagina(".($i+1).")'><a>".($i+1)."</a></li>";
                    }                    
                }                                                            
            }
            echo "<li onclick='pagina(".($numeropaginas).")' class='next'><a><i class='ace-icon fa fa-angle-double-right'></i></a></li>";
            echo "</ul>";
                                                                                                    
        echo "</div>";                
    }
    
    
    
    
    
    if($_POST["tabla"]=="listas"){                       
        echo "<div class='row cabecera_tabla'>";
        if($_POST["campo"]=="empresa.nombrecomercial"){
            if($_POST["orden"]=="desc"){
                echo "<div class='col-xs-4 columna_cabecera' onclick=ordena('empresa.nombrecomercial')>Espresa<i class='ace-icon glyphicon glyphicon-upload' style='float: right'></i></div>";
            }else if($_POST["orden"]=="asc"){
                echo "<div class='col-xs-4 columna_cabecera' onclick=ordena('empresa.nombrecomercial')>Espresa<i class='ace-icon glyphicon glyphicon-download' style='float: right'></i></div>";
            }
            echo "<div class='col-xs-6 columna_cabecera' onclick=ordena('listadeprecios.nombre')>Nombre de la Lista</div>";            
        }else
        if($_POST["campo"]=="listadeprecios.nombre"){
            echo "<div class='col-xs-4 columna_cabecera' onclick=ordena('empresa.nombrecomercial')>Espresa</div>";
            if($_POST["orden"]=="desc"){
                echo "<div class='col-xs-6 columna_cabecera' onclick=ordena('listadeprecios.nombre')>Nombre de la Lista<i class='ace-icon glyphicon glyphicon-upload' style='float: right'></i></div>";
            }else if($_POST["orden"]=="asc"){
                echo "<div class='col-xs-6 columna_cabecera' onclick=ordena('listadeprecios.nombre')>Nombre de la Lista<i class='ace-icon glyphicon glyphicon-download' style='float: right'></i></div>";
            }             
        }                                                           
        echo "</div>"; 
        
        $sql_listaEMPRESA="";
        if($_POST["filtro"]==""){                                            
            $sql_listaEMPRESA="select listadeprecios.idlistadeprecios, listadeprecios.nombre, empresa.nombrecomercial from listadeprecios,empresa where listadeprecios.idempresa = empresa.idempresa order by ".$_POST["campo"]." ".$_POST["orden"]; 
        }else{                                    
            $sql_listaEMPRESA="select listadeprecios.idlistadeprecios, listadeprecios.nombre, empresa.nombrecomercial from listadeprecios,empresa where listadeprecios.idempresa = empresa.idempresa and ".$_POST["camfiltro"]." LIKE '%".$_POST["filtro"]."%' order by ".$_POST["campo"]." ".$_POST["orden"];            
        }               
        
        //echo $sql_listaEMPRESA;
        
        $result_listaEMPRESA=mysql_query($sql_listaEMPRESA,$con) or die(mysql_error());
        if(mysql_num_rows($result_listaEMPRESA)>0){
            $cuenta=0;
            while ($fila = mysql_fetch_assoc($result_listaEMPRESA)) {
                if($cuenta<($_POST["elementos"]*$_POST["pagina"]) && ($cuenta >=(($_POST["pagina"]*$_POST["elementos"])-$_POST["elementos"]) && $cuenta<($_POST["pagina"]*$_POST["elementos"]))){
                    echo "<div class='row linea_tabla'>";
                    echo "<div class='col-xs-4 columna_linea'>".$fila["nombrecomercial"]."</div>";
                    echo "<div class='col-xs-6 columna_linea'>".$fila["nombre"]."</div>";                    
                    echo "<div class='col-xs-2' >";
                    echo "<div class='btn-group'>";
                    echo "<button data-toggle='dropdown' class='btn btn-primary btn-sm btn-white dropdown-toggle'>";
                    echo "Acciones <span class='ace-icon fa fa-caret-down icon-on-right'></span>";
                    echo "</button>";
                    echo "<ul class='dropdown-menu dropdown-default'>";
                    if(habilitaMenu($_SESSION["usuario"],3,7,3)==1){
                        echo "<li><a href='editarlistadeprecios.php?id=".$fila["idlistadeprecios"]."'>Editar</a></li>";
                    }
                    if(habilitaMenu($_SESSION["usuario"],3,7,4)==1){
                        echo "<li><a href='visualizarlistadeprecios.php?id=".$fila["idlistadeprecios"]."'>Visualizar</a></li>";
                    }
                    if(habilitaMenu($_SESSION["usuario"],3,7,5)==1){
                        echo "<li><a href='excepcioneslistadeprecios.php?id=".$fila["idlistadeprecios"]."'>Excepciones</a></li>";
                    }
                    if(habilitaMenu($_SESSION["usuario"],3,7,6)==1){
                        echo "<li><a href='pdfs/listaprecios.php?id=".$fila["idlistadeprecios"]."' target='_blank'>Exportar en PDF</a></li>";
                    }
                    if(habilitaMenu($_SESSION["usuario"],3,7,7)==1){
                        echo "<li><a href='excel/listadeprecios.php?id=".$fila["idlistadeprecios"]."' target='_blank'>Exportar en Excel</a></li>";
                    }
                    echo "</ul>";                                                                                                                                
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";  
                }
                $cuenta++;
            }
        }
                        
        echo "<div class='row pie_tabla' >";
                                                    
            $numeroelementos=mysql_num_rows($result_listaEMPRESA);   
            if($_POST["elementos"]>$numeroelementos){
                echo "Mostrando ".$numeroelementos." de ".$numeroelementos." elementos";
            }else{
                echo "Mostrando ".$_POST["elementos"]." de ".$numeroelementos." elementos";
            }
                               
                                                        
            $numeropaginas=  ceil($numeroelementos/$_POST["elementos"]);
            echo "<ul class='pagination pull-right' style='margin-right: 10px;margin-top: 0px;margin-bottom: 0px'>";
            echo "<li class='prev' onclick='pagina(1)'><a><i class='ace-icon fa fa-angle-double-left'></i></a></li>";
            for($i=($_POST["pagina"]-3);$i<$numeropaginas && $i<($_POST["pagina"]+2);$i++){
                if($i>-1){                    
                    if($i==($_POST["pagina"]-1)){
                        echo "<li onclick='pagina(".($i+1).")' class='active'><a>".($i+1)."</a></li>";
                    }else{
                        echo "<li onclick='pagina(".($i+1).")'><a>".($i+1)."</a></li>";
                    }                    
                }                                                            
            }
            echo "<li onclick='pagina(".($numeropaginas).")' class='next'><a><i class='ace-icon fa fa-angle-double-right'></i></a></li>";
            echo "</ul>";
                                                                                                    
        echo "</div>";                
    }
    
    
    
    if($_POST["tabla"]=="ordenesdecompra"){                       
        echo "<div class='row cabecera_tabla'>";
        if($_POST["campo"]=="ordendecompra.codigoexterno"){
            if($_POST["orden"]=="desc"){
                echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('ordendecompra.codigoexterno')>Código<i class='ace-icon glyphicon glyphicon-upload' style='float: right'></i></div>";
            }else if($_POST["orden"]=="asc"){
                echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('ordendecompra.codigoexterno')>Código<i class='ace-icon glyphicon glyphicon-download' style='float: right'></i></div>";
            }
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('empresa.nombreempresa')>Empresa</div>";
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('agenda.nombre')>Contacto</div>";
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('listadeprecios.nombre')>Lista de Precios</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('ordendecompra.fechaderegistro')>Registro</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('ordendecompra.fechadeentrega')>Entrega</div>";        
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('ordendecompra.total')>Total</div>";
        }else
        if($_POST["campo"]=="empresa.nombreempresa"){
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('ordendecompra.codigoexterno')>Código</div>";
            if($_POST["orden"]=="desc"){
                echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('empresa.nombreempresa')>Empresa<i class='ace-icon glyphicon glyphicon-upload' style='float: right'></i></div>";
            }else if($_POST["orden"]=="asc"){
                echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('empresa.nombreempresa')>Empresa<i class='ace-icon glyphicon glyphicon-download' style='float: right'></i></div>";
            }
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('agenda.nombre')>Contacto</div>";
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('listadeprecios.nombre')>Lista de Precios</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('ordendecompra.fechaderegistro')>Registro</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('ordendecompra.fechadeentrega')>Entrega</div>";        
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('ordendecompra.total')>Total</div>";
        }else 
        if($_POST["campo"]=="agenda.nombre"){
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('ordendecompra.codigoexterno')>Código</div>";
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('empresa.nombreempresa')>Empresa</div>";            
            if($_POST["orden"]=="desc"){
                echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('agenda.nombre')>Contacto<i class='ace-icon glyphicon glyphicon-upload' style='float: right'></i></div>";
            }else if($_POST["orden"]=="asc"){
                echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('agenda.nombre')>Contacto<i class='ace-icon glyphicon glyphicon-download' style='float: right'></i></div>";
            }
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('listadeprecios.nombre')>Lista de Precios</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('ordendecompra.fechaderegistro')>Registro</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('ordendecompra.fechadeentrega')>Entrega</div>";        
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('ordendecompra.total')>Total</div>";
        }else             
        if($_POST["campo"]=="listadeprecios.nombre"){
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('ordendecompra.codigoexterno')>Código</div>";
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('empresa.nombreempresa')>Empresa</div>";
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('agenda.nombre')>Contacto</div>";
            if($_POST["orden"]=="desc"){
                echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('listadeprecios.nombre')>Lista de Precios<i class='ace-icon glyphicon glyphicon-upload' style='float: right'></i></div>";
            }else if($_POST["orden"]=="asc"){
                echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('listadeprecios.nombre')>Lista de Precios<i class='ace-icon glyphicon glyphicon-download' style='float: right'></i></div>";
            } 
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('ordendecompra.fechaderegistro')>Registro</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('ordendecompra.fechadeentrega')>Entrega</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('ordendecompra.total')>Total</div>";
        }else
        if($_POST["campo"]=="ordendecompra.fechaderegistro"){
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('ordendecompra.codigoexterno')>Código</div>";
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('empresa.nombreempresa')>Empresa</div>";
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('agenda.nombre')>Contacto</div>";
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('listadeprecios.nombre')>Lista de Precios</div>";        
            if($_POST["orden"]=="desc"){
                echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('ordendecompra.fechaderegistro')>Registro<i class='ace-icon glyphicon glyphicon-upload' style='float: right'></i></div>";
            }else if($_POST["orden"]=="asc"){
                echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('ordendecompra.fechaderegistro')>Registro<i class='ace-icon glyphicon glyphicon-download' style='float: right'></i></div>";
            }
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('ordendecompra.fechadeentrega')>Entrega</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('ordendecompra.total')>Total</div>";
        }else
        if($_POST["campo"]=="ordendecompra.fechadeentrega"){
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('ordendecompra.codigoexterno')>Código</div>";
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('empresa.nombreempresa')>Empresa</div>";
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('agenda.nombre')>Contacto</div>";
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('listadeprecios.nombre')>Lista de Precios</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('ordendecompra.fechaderegistro')>Registro</div>";        
            if($_POST["orden"]=="desc"){
                echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('ordendecompra.fechadeentrega')>Entrega<i class='ace-icon glyphicon glyphicon-upload' style='float: right'></i></div>";
            }else if($_POST["orden"]=="asc"){
                echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('ordendecompra.fechadeentrega')>Entrega<i class='ace-icon glyphicon glyphicon-download' style='float: right'></i></div>";
            } 
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('ordendecompra.total')>Total</div>";
        }else
        if($_POST["campo"]=="ordendecompra.total"){
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('ordendecompra.codigoexterno')>Código</div>";
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('empresa.nombreempresa')>Empresa</div>";
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('agenda.nombre')>Contacto</div>";
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('listadeprecios.nombre')>Lista de Precios</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('ordendecompra.fechaderegistro')>Registro</div>";        
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('ordendecompra.fechadeentrega')>Entrega</div>";
            if($_POST["orden"]=="desc"){
                echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('ordendecompra.total')>Total<i class='ace-icon glyphicon glyphicon-upload' style='float: right'></i></div>";
            }else if($_POST["orden"]=="asc"){
                echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('ordendecompra.total')>Total<i class='ace-icon glyphicon glyphicon-download' style='float: right'></i></div>";
            } 
        }             
        echo "</div>"; 
        
        $sql_listaEMPRESA="";
        if($_POST["filtro"]==""){                        
            $sql_listaEMPRESA="select ordendecompra.idordendecompra as idorden, ordendecompra.conpago as conpago, ordendecompra.codigoexterno as codigo, ordendecompra.fechadeentrega as fecha, ordendecompra.fechaderegistro as registro, ordendecompra.total as total, empresa.nombreempresa as empresa, agenda.nombre as contacto, listadeprecios.nombre as lista from ordendecompra, empresa, agenda, listadeprecios where ordendecompra.estatus = 1 and ordendecompra.idempresa = empresa.idempresa and ordendecompra.idagenda01 = agenda.idagenda and ordendecompra.idlistadeprecios = listadeprecios.idlistadeprecios order by ".$_POST["campo"]." ".$_POST["orden"];
        }else{                        
            $sql_listaEMPRESA="select ordendecompra.idordendecompra as idorden, ordendecompra.conpago as conpago, ordendecompra.codigoexterno as codigo, ordendecompra.fechadeentrega as fecha, ordendecompra.fechaderegistro as registro, ordendecompra.total as total, empresa.nombreempresa as empresa, agenda.nombre as contacto, listadeprecios.nombre as lista from ordendecompra, empresa, agenda, listadeprecios where ordendecompra.estatus = 1 and ordendecompra.idempresa = empresa.idempresa and ordendecompra.idagenda01 = agenda.idagenda and ordendecompra.idlistadeprecios = listadeprecios.idlistadeprecios and ".$_POST["camfiltro"]." LIKE '%".$_POST["filtro"]."%' order by ".$_POST["campo"]." ".$_POST["orden"];
        }               
        
        //echo $sql_listaEMPRESA;
        
        $result_listaEMPRESA=mysql_query($sql_listaEMPRESA,$con) or die(mysql_error());
        if(mysql_num_rows($result_listaEMPRESA)>0){
            $cuenta=0;
            while ($fila = mysql_fetch_assoc($result_listaEMPRESA)) {
                if($cuenta<($_POST["elementos"]*$_POST["pagina"]) && ($cuenta >=(($_POST["pagina"]*$_POST["elementos"])-$_POST["elementos"]) && $cuenta<($_POST["pagina"]*$_POST["elementos"]))){
                    $band=0;
                    $band1=0;
                    $sqlValida="select * from ordendeproduccion where idordendecompra='".$fila["idorden"]."'";
                    $resultValida=mysql_query($sqlValida,$con) or die(mysql_error());
                    if(mysql_num_rows($resultValida)==0){
                        $band=1;
                    } 
                                                                
                    $sqlValida2="select * from factura where idordendecompra='".$fila["idorden"]."'";
                    $resultValida2=mysql_query($sqlValida2,$con) or die(mysql_error());
                    if(mysql_num_rows($resultValida2)==0){
                        $band1=1;
                    } 

                    echo "<div class='row linea_tabla'>";                                                            
                    echo "<div class='col-xs-1 columna_linea'>".$fila["codigo"]."</div>";
                    echo "<div class='col-xs-2 columna_linea'>".$fila["empresa"]."</div>";
                    echo "<div class='col-xs-2 columna_linea'>".$fila["contacto"]."</div>";
                    echo "<div class='col-xs-2 columna_linea'>".$fila["lista"]."</div>";
                    echo "<div class='col-xs-1 columna_linea'>".$fila["registro"]."</div>";
                    echo "<div class='col-xs-1 columna_linea'>".$fila["fecha"]."</div>";
                    echo "<div class='col-xs-1 columna_linea'>".$fila["total"]."</div>";
                    echo "<div class='col-xs-2' >";
                    
                    echo "<div class='btn-group'>";
                    echo "<button data-toggle='dropdown' class='btn btn-primary btn-sm btn-white dropdown-toggle'>";
                    echo "Acciones <span class='ace-icon fa fa-caret-down icon-on-right'></span>";
                    echo "</button>";
                    echo "<ul class='dropdown-menu dropdown-default'>";
                    
                    if(habilitaMenu($_SESSION["usuario"],4,8,3)==1){
                        echo "<li><a href='editarordendecompra.php?id=".$fila["idorden"]."'>Editar</a></li>";
                    }
                                                                
                    if(habilitaMenu($_SESSION["usuario"],4,8,5)==1){                                                                    
                        echo "<li><a href='#my-modal2' role='button' data-toggle='modal' onclick=prueba2(".$fila["idorden"].")>Cancelar</a></li>"; 
                    }                   
                                                                
                    if(habilitaMenu($_SESSION["usuario"],4,8,4)==1){
                        echo "<li><a href='pdfs/ordendecompra.php?id=".$fila["idorden"]."' target='_blank'>Exportar PDF</a></li>";
                    }
                                                                
                    if($band==1){
                        if(habilitaMenu($_SESSION["usuario"],4,8,6)==1){
                            echo "<li><a href='#my-modal' role='button' data-toggle='modal' onclick=prueba(".$fila["idorden"].")>Generar Orden de Producción</a></li>";                                                                    
                        }
                    }
                                                                
                    if($band1==1){
                        if(habilitaMenu($_SESSION["usuario"],4,8,7)==1){ 
                            if($fila["conpago"]==1){
                                echo "<li><a href='facturacion/facturar.php?id=".$fila["idorden"]."' target='_blank'>Facturar Orden de Compra</a></li>";
                            }                            
                        }
                    }                                                               
                    echo "</ul>";                                                                                                                                
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";  
                }
                $cuenta++;
            }
        }
                        
        echo "<div class='row pie_tabla' >";
                                                    
            $numeroelementos=mysql_num_rows($result_listaEMPRESA);   
            if($_POST["elementos"]>$numeroelementos){
                echo "Mostrando ".$numeroelementos." de ".$numeroelementos." elementos";
            }else{
                echo "Mostrando ".$_POST["elementos"]." de ".$numeroelementos." elementos";
            }
                               
                                                        
            $numeropaginas=  ceil($numeroelementos/$_POST["elementos"]);
            echo "<ul class='pagination pull-right' style='margin-right: 10px;margin-top: 0px;margin-bottom: 0px'>";
            echo "<li class='prev' onclick='pagina(1)'><a><i class='ace-icon fa fa-angle-double-left'></i></a></li>";
            for($i=($_POST["pagina"]-3);$i<$numeropaginas && $i<($_POST["pagina"]+2);$i++){
                if($i>-1){                    
                    if($i==($_POST["pagina"]-1)){
                        echo "<li onclick='pagina(".($i+1).")' class='active'><a>".($i+1)."</a></li>";
                    }else{
                        echo "<li onclick='pagina(".($i+1).")'><a>".($i+1)."</a></li>";
                    }                    
                }                                                            
            }
            echo "<li onclick='pagina(".($numeropaginas).")' class='next'><a><i class='ace-icon fa fa-angle-double-right'></i></a></li>";
            echo "</ul>";
                                                                                                    
        echo "</div>";                
    }    
    
    
    
    
    
    
    if($_POST["tabla"]=="ordenesdeproduccion"){                       
        echo "<div class='row cabecera_tabla'>";
        if($_POST["campo"]=="ordendeproduccion.codigoop"){
            if($_POST["orden"]=="desc"){
                echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('ordendeproduccion.codigoop')>Código<i class='ace-icon glyphicon glyphicon-upload' style='float: right'></i></div>";
            }else if($_POST["orden"]=="asc"){
                echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('ordendeproduccion.codigoop')>Código<i class='ace-icon glyphicon glyphicon-download' style='float: right'></i></div>";
            }
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('empresa.nombreempresa')>Empresa</div>";
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('agenda.nombre')>Contacto</div>";
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('listadeprecios.nombre')>Lista de Precios</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('ordendeproduccion.fechaderegistro')>Registro</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('ordendeproduccion.fechadeentrega')>Entrega</div>";        
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('ordendeproduccion.total')>Total</div>";
        }else
        if($_POST["campo"]=="empresa.nombreempresa"){
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('ordendeproduccion.codigoop')>Código</div>";
            if($_POST["orden"]=="desc"){
                echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('empresa.nombreempresa')>Empresa<i class='ace-icon glyphicon glyphicon-upload' style='float: right'></i></div>";
            }else if($_POST["orden"]=="asc"){
                echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('empresa.nombreempresa')>Empresa<i class='ace-icon glyphicon glyphicon-download' style='float: right'></i></div>";
            }
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('agenda.nombre')>Contacto</div>";
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('listadeprecios.nombre')>Lista de Precios</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('ordendeproduccion.fechaderegistro')>Registro</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('ordendeproduccion.fechadeentrega')>Entrega</div>";        
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('ordendeproduccion.total')>Total</div>";
        }else 
        if($_POST["campo"]=="agenda.nombre"){
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('ordendeproduccion.codigoop')>Código</div>";
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('empresa.nombreempresa')>Empresa</div>";            
            if($_POST["orden"]=="desc"){
                echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('agenda.nombre')>Contacto<i class='ace-icon glyphicon glyphicon-upload' style='float: right'></i></div>";
            }else if($_POST["orden"]=="asc"){
                echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('agenda.nombre')>Contacto<i class='ace-icon glyphicon glyphicon-download' style='float: right'></i></div>";
            }
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('listadeprecios.nombre')>Lista de Precios</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('ordendeproduccion.fechaderegistro')>Registro</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('ordendeproduccion.fechadeentrega')>Entrega</div>";        
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('ordendeproduccion.total')>Total</div>";
        }else             
        if($_POST["campo"]=="listadeprecios.nombre"){
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('ordendeproduccion.codigoop')>Código</div>";
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('empresa.nombreempresa')>Empresa</div>";
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('agenda.nombre')>Contacto</div>";
            if($_POST["orden"]=="desc"){
                echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('listadeprecios.nombre')>Lista de Precios<i class='ace-icon glyphicon glyphicon-upload' style='float: right'></i></div>";
            }else if($_POST["orden"]=="asc"){
                echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('listadeprecios.nombre')>Lista de Precios<i class='ace-icon glyphicon glyphicon-download' style='float: right'></i></div>";
            } 
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('ordendeproduccion.fechaderegistro')>Registro</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('ordendeproduccion.fechadeentrega')>Entrega</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('ordendeproduccion.total')>Total</div>";
        }else
        if($_POST["campo"]=="ordendeproduccion.fechaderegistro"){
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('ordendeproduccion.codigoop')>Código</div>";
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('empresa.nombreempresa')>Empresa</div>";
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('agenda.nombre')>Contacto</div>";
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('listadeprecios.nombre')>Lista de Precios</div>";        
            if($_POST["orden"]=="desc"){
                echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('ordendeproduccion.fechaderegistro')>Registro<i class='ace-icon glyphicon glyphicon-upload' style='float: right'></i></div>";
            }else if($_POST["orden"]=="asc"){
                echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('ordendeproduccion.fechaderegistro')>Registro<i class='ace-icon glyphicon glyphicon-download' style='float: right'></i></div>";
            }
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('ordendeproduccion.fechadeentrega')>Entrega</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('ordendeproduccion.total')>Total</div>";
        }else
        if($_POST["campo"]=="ordendeproduccion.fechadeentrega"){
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('ordendeproduccion.codigoop')>Código</div>";
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('empresa.nombreempresa')>Empresa</div>";
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('agenda.nombre')>Contacto</div>";
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('listadeprecios.nombre')>Lista de Precios</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('ordendeproduccion.fechaderegistro')>Registro</div>";        
            if($_POST["orden"]=="desc"){
                echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('ordendeproduccion.fechadeentrega')>Entrega<i class='ace-icon glyphicon glyphicon-upload' style='float: right'></i></div>";
            }else if($_POST["orden"]=="asc"){
                echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('ordendeproduccion.fechadeentrega')>Entrega<i class='ace-icon glyphicon glyphicon-download' style='float: right'></i></div>";
            } 
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('ordendeproduccion.total')>Total</div>";
        }else
        if($_POST["campo"]=="ordendeproduccion.total"){
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('ordendeproduccion.codigoop')>Código</div>";
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('empresa.nombreempresa')>Empresa</div>";
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('agenda.nombre')>Contacto</div>";
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('listadeprecios.nombre')>Lista de Precios</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('ordendeproduccion.fechaderegistro')>Registro</div>";        
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('ordendeproduccion.fechadeentrega')>Entrega</div>";
            if($_POST["orden"]=="desc"){
                echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('ordendeproduccion.total')>Total<i class='ace-icon glyphicon glyphicon-upload' style='float: right'></i></div>";
            }else if($_POST["orden"]=="asc"){
                echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('ordendeproduccion.total')>Total<i class='ace-icon glyphicon glyphicon-download' style='float: right'></i></div>";
            } 
        }             
        echo "</div>"; 
        
        $sql_listaEMPRESA="";
        if($_POST["filtro"]==""){                                    
            $sql_listaEMPRESA="select ordendeproduccion.idordendeproduccion as idorden, ordendeproduccion.codigoop as codigo, ordendeproduccion.fechadeentrega as fecha, ordendeproduccion.fechaderegistro as registro, ordendeproduccion.total as total, empresa.nombreempresa as empresa, agenda.nombre as contacto, listadeprecios.nombre as lista from ordendeproduccion, empresa, agenda, listadeprecios where estatus=1 and ordendeproduccion.idempresa = empresa.idempresa and ordendeproduccion.idagenda01 = agenda.idagenda and ordendeproduccion.idlistadeprecios = listadeprecios.idlistadeprecios order by ".$_POST["campo"]." ".$_POST["orden"];            
        }else{                                    
            $sql_listaEMPRESA="select ordendeproduccion.idordendeproduccion as idorden, ordendeproduccion.codigoop as codigo, ordendeproduccion.fechadeentrega as fecha, ordendeproduccion.fechaderegistro as registro, ordendeproduccion.total as total, empresa.nombreempresa as empresa, agenda.nombre as contacto, listadeprecios.nombre as lista from ordendeproduccion, empresa, agenda, listadeprecios where estatus=1 and ordendeproduccion.idempresa = empresa.idempresa and ordendeproduccion.idagenda01 = agenda.idagenda and ordendeproduccion.idlistadeprecios = listadeprecios.idlistadeprecios and ".$_POST["camfiltro"]." LIKE '%".$_POST["filtro"]."%' order by ".$_POST["campo"]." ".$_POST["orden"];            
        }               
        
        //echo $sql_listaEMPRESA;
        
        $result_listaEMPRESA=mysql_query($sql_listaEMPRESA,$con) or die(mysql_error());
        if(mysql_num_rows($result_listaEMPRESA)>0){
            $cuenta=0;
            while ($fila = mysql_fetch_assoc($result_listaEMPRESA)) {
                if($cuenta<($_POST["elementos"]*$_POST["pagina"]) && ($cuenta >=(($_POST["pagina"]*$_POST["elementos"])-$_POST["elementos"]) && $cuenta<($_POST["pagina"]*$_POST["elementos"]))){
                    echo "<div class='row linea_tabla'>";
                    echo "<div class='col-xs-1 columna_linea'>".$fila["codigo"]."</div>";
                    echo "<div class='col-xs-2 columna_linea'>".$fila["empresa"]."</div>";
                    echo "<div class='col-xs-2 columna_linea'>".$fila["contacto"]."</div>";
                    echo "<div class='col-xs-2 columna_linea'>".$fila["lista"]."</div>";
                    echo "<div class='col-xs-1 columna_linea'>".$fila["registro"]."</div>";
                    echo "<div class='col-xs-1 columna_linea'>".$fila["fecha"]."</div>";
                    echo "<div class='col-xs-1 columna_linea'>".$fila["total"]."</div>";
                    echo "<div class='col-xs-2' >";
                    
                    echo "<div class='btn-group'>";
                    echo "<button data-toggle='dropdown' class='btn btn-primary btn-sm btn-white dropdown-toggle'>";
                    echo "Acciones <span class='ace-icon fa fa-caret-down icon-on-right'></span>";
                    echo "</button>";
                    echo "<ul class='dropdown-menu dropdown-default'>";
                    echo "<li><a href='#'>Editar</a></li>";
                    echo "<li><a href='pdfs/ordendeproduccion.php?id=".$fila["idorden"]."' target='_blank'>Exportar PDF</a></li>";
                    $sqlValida="select * from ordendeproduccion where idordendecompra='".$fila["idorden"]."'";
                    $resultValida=mysql_query($sqlValida,$con) or die(mysql_error());
                    if(mysql_num_rows($resultValida)==0){
                        echo "<li class='divider'></li>";
                        echo "<li><a href='#my-modal' role='button' data-toggle='modal' onclick=prueba(".$fila["idorden"].")>Generar Orden de Producción</a></li>";                                                                    
                    }                                                                
                    echo "</ul>";                                                                                                                                
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";  
                }
                $cuenta++;
            }
        }
                        
        echo "<div class='row pie_tabla' >";
                                                    
            $numeroelementos=mysql_num_rows($result_listaEMPRESA);   
            if($_POST["elementos"]>$numeroelementos){
                echo "Mostrando ".$numeroelementos." de ".$numeroelementos." elementos";
            }else{
                echo "Mostrando ".$_POST["elementos"]." de ".$numeroelementos." elementos";
            }
                               
                                                        
            $numeropaginas=  ceil($numeroelementos/$_POST["elementos"]);
            echo "<ul class='pagination pull-right' style='margin-right: 10px;margin-top: 0px;margin-bottom: 0px'>";
            echo "<li class='prev' onclick='pagina(1)'><a><i class='ace-icon fa fa-angle-double-left'></i></a></li>";
            for($i=($_POST["pagina"]-3);$i<$numeropaginas && $i<($_POST["pagina"]+2);$i++){
                if($i>-1){                    
                    if($i==($_POST["pagina"]-1)){
                        echo "<li onclick='pagina(".($i+1).")' class='active'><a>".($i+1)."</a></li>";
                    }else{
                        echo "<li onclick='pagina(".($i+1).")'><a>".($i+1)."</a></li>";
                    }                    
                }                                                            
            }
            echo "<li onclick='pagina(".($numeropaginas).")' class='next'><a><i class='ace-icon fa fa-angle-double-right'></i></a></li>";
            echo "</ul>";
                                                                                                    
        echo "</div>";                
    }    
    
    
    if($_POST["tabla"]=="usuarios"){            
        echo "<div class='row cabecera_tabla'>";       
        if($_POST["campo"]=="usuario"){
            if($_POST["orden"]=="desc"){
                echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('usuario')>Usuario<i class='ace-icon glyphicon glyphicon-upload' style='float: right'></i></div>";
            }else if($_POST["orden"]=="asc"){
                echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('usuario')>Usuario<i class='ace-icon glyphicon glyphicon-download' style='float: right'></i></div>";
            }
            echo "<div class='col-xs-3 columna_cabecera' onclick=ordena('nombre')>Nombre</div>";
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('correo')>Correo Electronico</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('telefono')>Teléfono</div>";
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('puesto')>Puesto</div>";
        }else
        if($_POST["campo"]=="nombre"){
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('usuario')>Usuario</div>";
            if($_POST["orden"]=="desc"){
                echo "<div class='col-xs-3 columna_cabecera' onclick=ordena('nombre')>Nombre<i class='ace-icon glyphicon glyphicon-upload' style='float: right'></i></div>";
            }else if($_POST["orden"]=="asc"){
                echo "<div class='col-xs-3 columna_cabecera' onclick=ordena('nombre')>Nombre<i class='ace-icon glyphicon glyphicon-download' style='float: right'></i></div>";
            } 
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('correo')>Correo Electronico</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('telefono')>Teléfono</div>";
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('puesto')>Puesto</div>";
        }else
        if($_POST["campo"]=="correo"){
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('usuario')>Usuario</div>";
            echo "<div class='col-xs-3 columna_cabecera' onclick=ordena('nombre')>Nombre</div>";        
            if($_POST["orden"]=="desc"){
                echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('correo')>Correo Electronico<i class='ace-icon glyphicon glyphicon-upload' style='float: right'></i></div>";
            }else if($_POST["orden"]=="asc"){
                echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('correo')>Correo Electronico<i class='ace-icon glyphicon glyphicon-download' style='float: right'></i></div>";
            }
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('telefono')>Teléfono</div>";
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('puesto')>Puesto</div>";
        }else
        if($_POST["campo"]=="telefono"){
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('usuario')>Usuario</div>";
            echo "<div class='col-xs-3 columna_cabecera' onclick=ordena('nombre')>Nombre</div>";
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('correo')>Correo Electronico</div>";        
            if($_POST["orden"]=="desc"){
                echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('telefono')>Teléfono<i class='ace-icon glyphicon glyphicon-upload' style='float: right'></i></div>";
            }else if($_POST["orden"]=="asc"){
                echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('telefono')>Teléfono<i class='ace-icon glyphicon glyphicon-download' style='float: right'></i></div>";
            }
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('puesto')>Puesto</div>";
        }else
        if($_POST["campo"]=="puesto"){
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('usuario')>Usuario</div>";
            echo "<div class='col-xs-3 columna_cabecera' onclick=ordena('nombre')>Nombre</div>";
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('correo')>Correo Electronico</div>";        
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('telefono')>Teléfono</div>";
            if($_POST["orden"]=="desc"){
                echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('puesto')>Puesto<i class='ace-icon glyphicon glyphicon-upload' style='float: right'></i></div>";
            }else if($_POST["orden"]=="asc"){
                echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('puesto')>Puesto<i class='ace-icon glyphicon glyphicon-download' style='float: right'></i></div>";
            }            
        }                                                             
        echo "</div>"; 
        
        $sql_listaEMPRESA="";
        if($_POST["filtro"]==""){            
            $sql_listaEMPRESA="select idusuario, usuario, nombre, correo, telefono, puesto from usuario order by ".$_POST["campo"]." ".$_POST["orden"];
        }else{
            $sql_listaEMPRESA="select idusuario, usuario, nombre, correo, telefono, puesto from where ".$_POST["camfiltro"]." LIKE '%".$_POST["filtro"]."%' order by ".$_POST["campo"]." ".$_POST["orden"];
        }               
        
        //echo $sql_listaEMPRESA;
        
        $result_listaEMPRESA=mysql_query($sql_listaEMPRESA,$con) or die(mysql_error());
        if(mysql_num_rows($result_listaEMPRESA)>0){
            $cuenta=0;
            while ($fila = mysql_fetch_assoc($result_listaEMPRESA)) {
                if($cuenta<($_POST["elementos"]*$_POST["pagina"]) && ($cuenta >=(($_POST["pagina"]*$_POST["elementos"])-$_POST["elementos"]) && $cuenta<($_POST["pagina"]*$_POST["elementos"]))){
                    echo "<div class='row linea_tabla'>";
                    echo "<div class='col-xs-2 columna_linea'>".$fila["usuario"]."</div>";
                    echo "<div class='col-xs-3 columna_linea'>".$fila["nombre"]."</div>";
                    echo "<div class='col-xs-2 columna_linea'>".$fila["correo"]."</div>";
                    echo "<div class='col-xs-1 columna_linea'>".$fila["telefono"]."</div>";
                    echo "<div class='col-xs-2 columna_linea'>".$fila["puesto"]."</div>";
                    echo "<div class='col-xs-2' >";
                    echo "<div class='btn-group'>";
                    echo "<button data-toggle='dropdown' class='btn btn-primary btn-sm btn-white dropdown-toggle'>";
                    echo "Acciones <span class='ace-icon fa fa-caret-down icon-on-right'></span>";
                    echo "</button>";
                    echo "<ul class='dropdown-menu dropdown-default'>";
                    if(habilitaMenu($_SESSION["usuario"],6,10,3)==1){
                        echo "<li><a href='editarusuario.php?id=".$fila["idusuario"]."'>Editar</a></li>";
                    }
                    echo "</ul>";                                                                                                                                
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";  
                }
                $cuenta++;
            }
        }
                        
        echo "<div class='row pie_tabla' >";
                                                    
            $numeroelementos=mysql_num_rows($result_listaEMPRESA);   
            if($_POST["elementos"]>$numeroelementos){
                echo "Mostrando ".$numeroelementos." de ".$numeroelementos." elementos";
            }else{
                echo "Mostrando ".$_POST["elementos"]." de ".$numeroelementos." elementos";
            }
                               
                                                        
            $numeropaginas=  ceil($numeroelementos/$_POST["elementos"]);
            echo "<ul class='pagination pull-right' style='margin-right: 10px;margin-top: 0px;margin-bottom: 0px'>";
            echo "<li class='prev' onclick='pagina(1)'><a><i class='ace-icon fa fa-angle-double-left'></i></a></li>";
            for($i=($_POST["pagina"]-3);$i<$numeropaginas && $i<($_POST["pagina"]+2);$i++){
                if($i>-1){                    
                    if($i==($_POST["pagina"]-1)){
                        echo "<li onclick='pagina(".($i+1).")' class='active'><a>".($i+1)."</a></li>";
                    }else{
                        echo "<li onclick='pagina(".($i+1).")'><a>".($i+1)."</a></li>";
                    }                    
                }                                                            
            }
            echo "<li onclick='pagina(".($numeropaginas).")' class='next'><a><i class='ace-icon fa fa-angle-double-right'></i></a></li>";
            echo "</ul>";
                                                                                                    
        echo "</div>";                
    }    
    
    
    
    
    if($_POST["tabla"]=="facturas"){            
        echo "<div class='row cabecera_tabla'>";       
        if($_POST["campo"]=="codigoexterno"){
            if($_POST["orden"]=="desc"){
                echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('codigoexterno')>Código<i class='ace-icon glyphicon glyphicon-upload' style='float: right'></i></div>";
            }else if($_POST["orden"]=="asc"){
                echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('codigoexterno')>Código<i class='ace-icon glyphicon glyphicon-download' style='float: right'></i></div>";
            }
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('nombreempresa')>Empresa</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('emision')>Fecha de Emisión</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('serie')>Serie</div>";        
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('folio')>Folio</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('subtotal')>Subtotal</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('iva')>Iva</div>";            
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('total')>Total</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('resta')>Resta</div>";
        }else
        if($_POST["campo"]=="nombreempresa"){
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('codigoexterno')>Código</div>";
            if($_POST["orden"]=="desc"){
                echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('nombreempresa')>Empresa<i class='ace-icon glyphicon glyphicon-upload' style='float: right'></i></div>";
            }else if($_POST["orden"]=="asc"){
                echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('nombreempresa')>Empresa<i class='ace-icon glyphicon glyphicon-download' style='float: right'></i></div>";
            }            
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('emision')>Fecha de Emisión</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('serie')>Serie</div>";        
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('folio')>Folio</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('subtotal')>Subtotal</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('iva')>Iva</div>";            
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('total')>Total</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('resta')>Resta</div>";
        }else
        if($_POST["campo"]=="emision"){
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('codigoexterno')>Código</div>";
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('nombreempresa')>Empresa</div>";
            if($_POST["orden"]=="desc"){
                echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('emision')>Fecha de Emisión<i class='ace-icon glyphicon glyphicon-upload' style='float: right'></i></div>";
            }else if($_POST["orden"]=="asc"){
                echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('emision')>Fecha de Emisión<i class='ace-icon glyphicon glyphicon-download' style='float: right'></i></div>";
            }
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('serie')>Serie</div>";        
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('folio')>Folio</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('subtotal')>Subtotal</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('iva')>Iva</div>";            
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('total')>Total</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('resta')>Resta</div>";
        }else
        if($_POST["campo"]=="serie"){
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('codigoexterno')>Código</div>";
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('nombreempresa')>Empresa</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('emision')>Fecha de Emisión</div>";
            if($_POST["orden"]=="desc"){
                echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('serie')>Serie<i class='ace-icon glyphicon glyphicon-upload' style='float: right'></i></div>";
            }else if($_POST["orden"]=="asc"){
                echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('serie')>Serie<i class='ace-icon glyphicon glyphicon-download' style='float: right'></i></div>";
            }                                           
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('folio')>Folio</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('subtotal')>Subtotal</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('iva')>Iva</div>";            
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('total')>Total</div>"; 
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('resta')>Resta</div>";
        }else
        if($_POST["campo"]=="folio"){
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('codigoexterno')>Código</div>";
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('nombreempresa')>Empresa</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('emision')>Fecha de Emisión</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('serie')>Serie</div>";            
            if($_POST["orden"]=="desc"){
                echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('folio')>Folio<i class='ace-icon glyphicon glyphicon-upload' style='float: right'></i></div>";
            }else if($_POST["orden"]=="asc"){
                echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('folio')>Folio<i class='ace-icon glyphicon glyphicon-download' style='float: right'></i></div>";
            }
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('subtotal')>Subtotal</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('iva')>Iva</div>";            
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('total')>Total</div>"; 
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('resta')>Resta</div>";
        }else
        if($_POST["campo"]=="subtotal"){
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('codigoexterno')>Código</div>";
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('nombreempresa')>Empresa</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('emision')>Fecha de Emisión</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('serie')>Serie</div>";        
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('folio')>Folio</div>";
            if($_POST["orden"]=="desc"){
                echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('subtotal')>Subtotal<i class='ace-icon glyphicon glyphicon-upload' style='float: right'></i></div>";
            }else if($_POST["orden"]=="asc"){
                echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('subtotal')>Subtotal<i class='ace-icon glyphicon glyphicon-download' style='float: right'></i></div>";
            }                        
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('iva')>Iva</div>";            
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('total')>Total</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('resta')>Resta</div>";
        }else
        if($_POST["campo"]=="iva"){
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('codigoexterno')>Código</div>";
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('nombreempresa')>Empresa</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('emision')>Fecha de Emisión</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('serie')>Serie</div>";        
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('folio')>Folio</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('subtotal')>Subtotal</div>";
            if($_POST["orden"]=="desc"){
                echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('iva')>Iva<i class='ace-icon glyphicon glyphicon-upload' style='float: right'></i></div>";
            }else if($_POST["orden"]=="asc"){
                echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('iva')>Iva<i class='ace-icon glyphicon glyphicon-download' style='float: right'></i></div>";
            }                        
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('total')>Total</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('resta')>Resta</div>";
        }else
        if($_POST["campo"]=="total"){
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('codigoexterno')>Código</div>";
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('nombreempresa')>Empresa</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('emision')>Fecha de Emisión</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('serie')>Serie</div>";        
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('folio')>Folio</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('subtotal')>Subtotal</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('iva')>Iva</div>";            
            if($_POST["orden"]=="desc"){
                echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('total')>Total<i class='ace-icon glyphicon glyphicon-upload' style='float: right'></i></div>";
            }else if($_POST["orden"]=="asc"){
                echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('total')>Total<i class='ace-icon glyphicon glyphicon-download' style='float: right'></i></div>";
            }
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('resta')>Resta</div>";
        } 
        if($_POST["campo"]=="resta"){
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('codigoexterno')>Código</div>";
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('nombreempresa')>Empresa</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('emision')>Fecha de Emisión</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('serie')>Serie</div>";        
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('folio')>Folio</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('subtotal')>Subtotal</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('iva')>Iva</div>";            
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('total')>Total</div>";
            if($_POST["orden"]=="desc"){
                echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('resta')>Resta<i class='ace-icon glyphicon glyphicon-upload' style='float: right'></i></div>";
            }else if($_POST["orden"]=="asc"){
                echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('resta')>Resta<i class='ace-icon glyphicon glyphicon-download' style='float: right'></i></div>";
            }            
        }        
        echo "</div>"; 
        
        $sql_listaEMPRESA="";
        if($_POST["filtro"]==""){            
            $sql_listaEMPRESA="select factura.idfactura, factura.resta, agenda.nombre, empresa.nombreempresa, ordendecompra.codigoexterno, factura.emision, factura.serie, factura.folio, factura.subtotal, factura.iva, factura.total from empresa, factura, agenda, ordendecompra where factura.estatus=1 and factura.idempresa = empresa.idempresa and factura.idordendecompra = ordendecompra.idordendecompra and factura.idagenda = agenda.idagenda order by ".$_POST["campo"]." ".$_POST["orden"];
        }else{            
            $sql_listaEMPRESA="select factura.idfactura, factura.resta, agenda.nombre, empresa.nombreempresa, ordendecompra.codigoexterno, factura.emision, factura.serie, factura.folio, factura.subtotal, factura.iva, factura.total from empresa, factura, agenda, ordendecompra where factura.estatus=1 and factura.idempresa = empresa.idempresa and factura.idordendecompra = ordendecompra.idordendecompra and factura.idagenda = agenda.idagenda and ".$_POST["camfiltro"]." LIKE '%".$_POST["filtro"]."%' order by ".$_POST["campo"]." ".$_POST["orden"];            
        }               
        
        //echo $sql_listaEMPRESA;
        
        $result_listaEMPRESA=mysql_query($sql_listaEMPRESA,$con) or die(mysql_error());
        if(mysql_num_rows($result_listaEMPRESA)>0){
            $cuenta=0;
            while ($fila = mysql_fetch_assoc($result_listaEMPRESA)) {
                if($cuenta<($_POST["elementos"]*$_POST["pagina"]) && ($cuenta >=(($_POST["pagina"]*$_POST["elementos"])-$_POST["elementos"]) && $cuenta<($_POST["pagina"]*$_POST["elementos"]))){
                    echo "<div class='row linea_tabla'>";
                    echo "<div class='col-xs-1 columna_linea'>".$fila["codigoexterno"]."</div>";
                    echo "<div class='col-xs-2 columna_linea'>".$fila["nombreempresa"]."</div>";                                                                
                    echo "<div class='col-xs-1 columna_linea'>".$fila["emision"]."</div>";
                    echo "<div class='col-xs-1 columna_linea'>".$fila["serie"]."</div>";
                    echo "<div class='col-xs-1 columna_linea'>".$fila["folio"]."</div>";
                    echo "<div class='col-xs-1 columna_linea'>".$fila["subtotal"]."</div>";
                    echo "<div class='col-xs-1 columna_linea'>".$fila["iva"]."</div>";
                    echo "<div class='col-xs-1 columna_linea'>".$fila["total"]."</div>";
                    echo "<div class='col-xs-1 columna_linea'>".$fila["resta"]."</div>";
                    echo "<div class='col-xs-2' >";
                    echo "<div class='btn-group'>";
                    echo "<button data-toggle='dropdown' class='btn btn-primary btn-sm btn-white dropdown-toggle'>";
                    echo "Acciones <span class='ace-icon fa fa-caret-down icon-on-right'></span>";
                    echo "</button>";
                    echo "<ul class='dropdown-menu dropdown-default'>";
                    if(habilitaMenu($_SESSION["usuario"],7,12,2)==1){
                        echo "<li><a href='facturacion/descargar.php?idfactura=".$fila["idfactura"]."' target='_blank'>Descargar</a></li>";
                    }
                    if(habilitaMenu($_SESSION["usuario"],7,12,3)==1){
                        echo "<li><a href='pagarfactura.php?id=".$fila["idfactura"]."'>Pagar</a></li>";
                    } 
                    echo "</ul>";                                                                                                                                
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";  
                }
                $cuenta++;
            }
        }
                        
        echo "<div class='row pie_tabla' >";
                                                    
            $numeroelementos=mysql_num_rows($result_listaEMPRESA);   
            if($_POST["elementos"]>$numeroelementos){
                echo "Mostrando ".$numeroelementos." de ".$numeroelementos." elementos";
            }else{
                echo "Mostrando ".$_POST["elementos"]." de ".$numeroelementos." elementos";
            }
                               
                                                        
            $numeropaginas=  ceil($numeroelementos/$_POST["elementos"]);
            echo "<ul class='pagination pull-right' style='margin-right: 10px;margin-top: 0px;margin-bottom: 0px'>";
            echo "<li class='prev' onclick='pagina(1)'><a><i class='ace-icon fa fa-angle-double-left'></i></a></li>";
            for($i=($_POST["pagina"]-3);$i<$numeropaginas && $i<($_POST["pagina"]+2);$i++){
                if($i>-1){                    
                    if($i==($_POST["pagina"]-1)){
                        echo "<li onclick='pagina(".($i+1).")' class='active'><a>".($i+1)."</a></li>";
                    }else{
                        echo "<li onclick='pagina(".($i+1).")'><a>".($i+1)."</a></li>";
                    }                    
                }                                                            
            }
            echo "<li onclick='pagina(".($numeropaginas).")' class='next'><a><i class='ace-icon fa fa-angle-double-right'></i></a></li>";
            echo "</ul>";
                                                                                                    
        echo "</div>";                
    }    
    
    
    
    
    if($_POST["tabla"]=="facturasc"){            
        echo "<div class='row cabecera_tabla'>";       
        if($_POST["campo"]=="codigoexterno"){
            if($_POST["orden"]=="desc"){
                echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('codigoexterno')>Código<i class='ace-icon glyphicon glyphicon-upload' style='float: right'></i></div>";
            }else if($_POST["orden"]=="asc"){
                echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('codigoexterno')>Código<i class='ace-icon glyphicon glyphicon-download' style='float: right'></i></div>";
            }
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('nombreempresa')>Empresa</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('emision')>Fecha de Emisión</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('serie')>Serie</div>";        
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('folio')>Folio</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('subtotal')>Subtotal</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('iva')>Iva</div>";            
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('total')>Total</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('resta')>Resta</div>";
        }else
        if($_POST["campo"]=="nombreempresa"){
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('codigoexterno')>Código</div>";
            if($_POST["orden"]=="desc"){
                echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('nombreempresa')>Empresa<i class='ace-icon glyphicon glyphicon-upload' style='float: right'></i></div>";
            }else if($_POST["orden"]=="asc"){
                echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('nombreempresa')>Empresa<i class='ace-icon glyphicon glyphicon-download' style='float: right'></i></div>";
            }            
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('emision')>Fecha de Emisión</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('serie')>Serie</div>";        
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('folio')>Folio</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('subtotal')>Subtotal</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('iva')>Iva</div>";            
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('total')>Total</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('resta')>Resta</div>";
        }else
        if($_POST["campo"]=="emision"){
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('codigoexterno')>Código</div>";
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('nombreempresa')>Empresa</div>";
            if($_POST["orden"]=="desc"){
                echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('emision')>Fecha de Emisión<i class='ace-icon glyphicon glyphicon-upload' style='float: right'></i></div>";
            }else if($_POST["orden"]=="asc"){
                echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('emision')>Fecha de Emisión<i class='ace-icon glyphicon glyphicon-download' style='float: right'></i></div>";
            }
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('serie')>Serie</div>";        
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('folio')>Folio</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('subtotal')>Subtotal</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('iva')>Iva</div>";            
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('total')>Total</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('resta')>Resta</div>";
        }else
        if($_POST["campo"]=="serie"){
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('codigoexterno')>Código</div>";
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('nombreempresa')>Empresa</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('emision')>Fecha de Emisión</div>";
            if($_POST["orden"]=="desc"){
                echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('serie')>Serie<i class='ace-icon glyphicon glyphicon-upload' style='float: right'></i></div>";
            }else if($_POST["orden"]=="asc"){
                echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('serie')>Serie<i class='ace-icon glyphicon glyphicon-download' style='float: right'></i></div>";
            }                                           
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('folio')>Folio</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('subtotal')>Subtotal</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('iva')>Iva</div>";            
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('total')>Total</div>"; 
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('resta')>Resta</div>";
        }else
        if($_POST["campo"]=="folio"){
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('codigoexterno')>Código</div>";
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('nombreempresa')>Empresa</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('emision')>Fecha de Emisión</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('serie')>Serie</div>";            
            if($_POST["orden"]=="desc"){
                echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('folio')>Folio<i class='ace-icon glyphicon glyphicon-upload' style='float: right'></i></div>";
            }else if($_POST["orden"]=="asc"){
                echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('folio')>Folio<i class='ace-icon glyphicon glyphicon-download' style='float: right'></i></div>";
            }
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('subtotal')>Subtotal</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('iva')>Iva</div>";            
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('total')>Total</div>"; 
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('resta')>Resta</div>";
        }else
        if($_POST["campo"]=="subtotal"){
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('codigoexterno')>Código</div>";
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('nombreempresa')>Empresa</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('emision')>Fecha de Emisión</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('serie')>Serie</div>";        
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('folio')>Folio</div>";
            if($_POST["orden"]=="desc"){
                echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('subtotal')>Subtotal<i class='ace-icon glyphicon glyphicon-upload' style='float: right'></i></div>";
            }else if($_POST["orden"]=="asc"){
                echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('subtotal')>Subtotal<i class='ace-icon glyphicon glyphicon-download' style='float: right'></i></div>";
            }                        
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('iva')>Iva</div>";            
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('total')>Total</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('resta')>Resta</div>";
        }else
        if($_POST["campo"]=="iva"){
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('codigoexterno')>Código</div>";
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('nombreempresa')>Empresa</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('emision')>Fecha de Emisión</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('serie')>Serie</div>";        
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('folio')>Folio</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('subtotal')>Subtotal</div>";
            if($_POST["orden"]=="desc"){
                echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('iva')>Iva<i class='ace-icon glyphicon glyphicon-upload' style='float: right'></i></div>";
            }else if($_POST["orden"]=="asc"){
                echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('iva')>Iva<i class='ace-icon glyphicon glyphicon-download' style='float: right'></i></div>";
            }                        
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('total')>Total</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('resta')>Resta</div>";
        }else
        if($_POST["campo"]=="total"){
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('codigoexterno')>Código</div>";
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('nombreempresa')>Empresa</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('emision')>Fecha de Emisión</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('serie')>Serie</div>";        
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('folio')>Folio</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('subtotal')>Subtotal</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('iva')>Iva</div>";            
            if($_POST["orden"]=="desc"){
                echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('total')>Total<i class='ace-icon glyphicon glyphicon-upload' style='float: right'></i></div>";
            }else if($_POST["orden"]=="asc"){
                echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('total')>Total<i class='ace-icon glyphicon glyphicon-download' style='float: right'></i></div>";
            }
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('resta')>Resta</div>";
        } 
        if($_POST["campo"]=="resta"){
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('codigoexterno')>Código</div>";
            echo "<div class='col-xs-2 columna_cabecera' onclick=ordena('nombreempresa')>Empresa</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('emision')>Fecha de Emisión</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('serie')>Serie</div>";        
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('folio')>Folio</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('subtotal')>Subtotal</div>";
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('iva')>Iva</div>";            
            echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('total')>Total</div>";
            if($_POST["orden"]=="desc"){
                echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('resta')>Resta<i class='ace-icon glyphicon glyphicon-upload' style='float: right'></i></div>";
            }else if($_POST["orden"]=="asc"){
                echo "<div class='col-xs-1 columna_cabecera' onclick=ordena('resta')>Resta<i class='ace-icon glyphicon glyphicon-download' style='float: right'></i></div>";
            }            
        }        
        echo "</div>"; 
        
        $sql_listaEMPRESA="";
        if($_POST["filtro"]==""){            
            $sql_listaEMPRESA="select factura.idfactura, factura.resta, agenda.nombre, empresa.nombreempresa, ordendecompra.codigoexterno, factura.emision, factura.serie, factura.folio, factura.subtotal, factura.iva, factura.total from empresa, factura, agenda, ordendecompra where factura.estatus=2 and factura.idempresa = empresa.idempresa and factura.idordendecompra = ordendecompra.idordendecompra and factura.idagenda = agenda.idagenda order by ".$_POST["campo"]." ".$_POST["orden"];
        }else{            
            $sql_listaEMPRESA="select factura.idfactura, factura.resta, agenda.nombre, empresa.nombreempresa, ordendecompra.codigoexterno, factura.emision, factura.serie, factura.folio, factura.subtotal, factura.iva, factura.total from empresa, factura, agenda, ordendecompra where factura.estatus=2 and factura.idempresa = empresa.idempresa and factura.idordendecompra = ordendecompra.idordendecompra and factura.idagenda = agenda.idagenda and ".$_POST["camfiltro"]." LIKE '%".$_POST["filtro"]."%' order by ".$_POST["campo"]." ".$_POST["orden"];            
        }               
        
        //echo $sql_listaEMPRESA;
        
        $result_listaEMPRESA=mysql_query($sql_listaEMPRESA,$con) or die(mysql_error());
        if(mysql_num_rows($result_listaEMPRESA)>0){
            $cuenta=0;
            while ($fila = mysql_fetch_assoc($result_listaEMPRESA)) {
                if($cuenta<($_POST["elementos"]*$_POST["pagina"]) && ($cuenta >=(($_POST["pagina"]*$_POST["elementos"])-$_POST["elementos"]) && $cuenta<($_POST["pagina"]*$_POST["elementos"]))){
                    echo "<div class='row linea_tabla'>";
                    echo "<div class='col-xs-1 columna_linea'>".$fila["codigoexterno"]."</div>";
                    echo "<div class='col-xs-2 columna_linea'>".$fila["nombreempresa"]."</div>";                                                                
                    echo "<div class='col-xs-1 columna_linea'>".$fila["emision"]."</div>";
                    echo "<div class='col-xs-1 columna_linea'>".$fila["serie"]."</div>";
                    echo "<div class='col-xs-1 columna_linea'>".$fila["folio"]."</div>";
                    echo "<div class='col-xs-1 columna_linea'>".$fila["subtotal"]."</div>";
                    echo "<div class='col-xs-1 columna_linea'>".$fila["iva"]."</div>";
                    echo "<div class='col-xs-1 columna_linea'>".$fila["total"]."</div>";
                    echo "<div class='col-xs-1 columna_linea'>".$fila["resta"]."</div>";
                    echo "<div class='col-xs-2' >";
                    echo "<div class='btn-group'>";
                    echo "<button data-toggle='dropdown' class='btn btn-primary btn-sm btn-white dropdown-toggle'>";
                    echo "Acciones <span class='ace-icon fa fa-caret-down icon-on-right'></span>";
                    echo "</button>";
                    echo "<ul class='dropdown-menu dropdown-default'>";
                    if(habilitaMenu($_SESSION["usuario"],7,12,2)==1){
                        echo "<li><a href='facturacion/descargar.php?idfactura=".$fila["idfactura"]."' target='_blank'>Descargar</a></li>";
                    }
                    if(habilitaMenu($_SESSION["usuario"],7,12,3)==1){
                        echo "<li><a href='pagarfactura.php?id=".$fila["idfactura"]."'>Pagar</a></li>";
                    } 
                    echo "</ul>";                                                                                                                                
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";  
                }
                $cuenta++;
            }
        }
                        
        echo "<div class='row pie_tabla' >";
                                                    
            $numeroelementos=mysql_num_rows($result_listaEMPRESA);   
            if($_POST["elementos"]>$numeroelementos){
                echo "Mostrando ".$numeroelementos." de ".$numeroelementos." elementos";
            }else{
                echo "Mostrando ".$_POST["elementos"]." de ".$numeroelementos." elementos";
            }
                               
                                                        
            $numeropaginas=  ceil($numeroelementos/$_POST["elementos"]);
            echo "<ul class='pagination pull-right' style='margin-right: 10px;margin-top: 0px;margin-bottom: 0px'>";
            echo "<li class='prev' onclick='pagina(1)'><a><i class='ace-icon fa fa-angle-double-left'></i></a></li>";
            for($i=($_POST["pagina"]-3);$i<$numeropaginas && $i<($_POST["pagina"]+2);$i++){
                if($i>-1){                    
                    if($i==($_POST["pagina"]-1)){
                        echo "<li onclick='pagina(".($i+1).")' class='active'><a>".($i+1)."</a></li>";
                    }else{
                        echo "<li onclick='pagina(".($i+1).")'><a>".($i+1)."</a></li>";
                    }                    
                }                                                            
            }
            echo "<li onclick='pagina(".($numeropaginas).")' class='next'><a><i class='ace-icon fa fa-angle-double-right'></i></a></li>";
            echo "</ul>";
                                                                                                    
        echo "</div>";                
    }    
    
    
?>