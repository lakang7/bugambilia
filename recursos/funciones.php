<?php

    function Conexion(){        
        $conexion = mysql_connect("localhost", "root", "");
	mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'", $conexion);
        mysql_select_db("bugambiliasis", $conexion);	        
	return $conexion;
    }               
    
    function listlevel01($tipocategoria){
        $con=  Conexion();
        $acumula=0;
        $sql_tipoproducto="select * from tipoproducto where idcategoriatipo='".$tipocategoria."'";
        $result_tipoproducto=mysql_query($sql_tipoproducto,$con) or die(mysql_error());
        if(mysql_num_rows($result_tipoproducto)>0){
            while ($tipoproducto = mysql_fetch_assoc($result_tipoproducto)) {
                    $sql_count="select count(*) as total from producto where idtipoproducto='".$tipoproducto["idtipoproducto"]."'";                                        
                    $result_count=mysql_query($sql_count,$con) or die(mysql_error());
                    $cuenta = mysql_fetch_assoc($result_count);
                    $acumula+=$cuenta["total"];
            }
        }
        //mysql_close($con);
        return $acumula;
    }
    
    function listlevel02($tipocategoria,$idcategoriaproducto){
        $con=  Conexion();
        $acumula=0;
        $sql_patrones="select * from patronproducto where idcategoriaproducto='".$idcategoriaproducto."'";                                        
        $result_patrones=mysql_query($sql_patrones,$con) or die(mysql_error());
        while ($patron = mysql_fetch_assoc($result_patrones)) {            
            $sql_tipoproducto="select * from tipoproducto where idcategoriatipo='".$tipocategoria."'";
            $result_tipoproducto=mysql_query($sql_tipoproducto,$con) or die(mysql_error());  
            while ($tipoproducto = mysql_fetch_assoc($result_tipoproducto)) {
                $sql_cuenta="select count(*) as total from producto where idtipoproducto='".$tipoproducto["idtipoproducto"]."' and idpatronproducto='".$patron["idpatronproducto"]."'";
                $result_cuenta=mysql_query($sql_cuenta,$con) or die(mysql_error());
                $cuenta = mysql_fetch_assoc($result_cuenta);
                $acumula+=$cuenta["total"];                
            }            
        }       
        //echo "el valor es: ".$acumula;
       // mysql_close($con);
        return $acumula;
    }
    
    
?>