<?php
    header('Content-Type: text/html; charset=UTF-8');        
    require_once("recursos/funciones.php");    
    $con = Conexion();
    
    $sql_ordenes="select * from ordendecompra order by idordendecompra";
    $result_ordenes=mysql_query($sql_ordenes,$con) or die(mysql_error());
    if(mysql_num_rows($result_ordenes)>0){                                                
        while ($orden = mysql_fetch_assoc($result_ordenes)){
            $sql_busca="select * from controlfechas where idordendecompra='".$orden["idordendecompra"]."'";
            $result_busca=mysql_query($sql_busca,$con) or die(mysql_error());
            if(mysql_num_rows($result_busca)==0){
                
                $fechaentregac= new DateTime($orden["fechadeentrega"]);
                $diaenlasemanac=date_format($fechaentregac, 'w');        
                if($diaenlasemanac==0){          /*Domingo*/
                    $fechaentregac->modify('+ 5 day');
                }else if($diaenlasemanac==1){    /*Lunes*/
                    $fechaentregac->modify('+ 4 day');
                }else if($diaenlasemanac==2){    /*Martes*/
                    $fechaentregac->modify('+ 3 day');
                }else if($diaenlasemanac==3){    /*Miercoles*/
                    $fechaentregac->modify('+ 2 day');
                }else if($diaenlasemanac==4){    /*Jueves*/
                    $fechaentregac->modify('+ 1 day');
                }else if($diaenlasemanac==5){    /*Viernes*/
                    $fechaentregac->modify('+ 7 day');
                }else if($diaenlasemanac==6){    /*Sabado*/
                    $fechaentregac->modify('+ 6 day');
                }
                
                $sqlUpdateOrdendecompra="update ordendecompra set fechadeentrega='".$fechaentregac->format('Y-m-d')."' where idordendecompra='".$orden["idordendecompra"]."'";
                $result_updateOrdenCompra=mysql_query($sqlUpdateOrdendecompra,$con) or die(mysql_error());
                
                $sql_insertControl="insert into controlfechas (idordendecompra,fechadecreacion,fechaderegistro,fechadeentrega,nuevafechaoc) values('".$orden["idordendecompra"]."','".$orden["fechadecreacion"]."','".$orden["fechaderegistro"]."','".$orden["fechadeentrega"]."','".$fechaentregac->format('Y-m-d')."')";
                $result_insertControl=mysql_query($sql_insertControl,$con) or die(mysql_error());
                
                $sql_buscaop="select * from ordendeproduccion where idordendecompra='".$orden["idordendecompra"]."'";
                $result_buscaop=mysql_query($sql_buscaop,$con) or die(mysql_error());
                if(mysql_num_rows($result_buscaop)>0){
                    
                    $nuevafechar = new DateTime($orden["fechadeentrega"]);
                    $diaenlasemanar=date_format($nuevafechar, 'w');
                    if($diaenlasemanar==0){          /*Domingo*/
                        $nuevafechar->modify('- 2 day');
                    }else if($diaenlasemanar==1){    /*Lunes*/
                        $nuevafechar->modify('- 3 day');
                    }else if($diaenlasemanar==2){    /*Martes*/
                        $nuevafechar->modify('- 4 day');
                    }else if($diaenlasemanar==3){    /*Miercoles*/
                        $nuevafechar->modify('- 5 day');
                    }else if($diaenlasemanar==4){    /*Jueves*/
                        $nuevafechar->modify('- 6 day');
                    }else if($diaenlasemanar==5){    /*Viernes*/
                        $nuevafechar->modify('- 7 day');
                    }else if($diaenlasemanar==6){    /*Sabado*/
                        $nuevafechar->modify('- 1 day');
                    }                     
                    
                    $sqlUpdateOrdendeproduccion="update ordendeproduccion set fechadeentrega='".$nuevafechar->format('Y-m-d')."' where idordendecompra='".$orden["idordendecompra"]."'";
                    $result_updateOrdenProduccion=mysql_query($sqlUpdateOrdendeproduccion,$con) or die(mysql_error());
                    
                    $sqlUpdatefechas="update controlfechas set nuevafechaop='".$nuevafechar->format('Y-m-d')."' where idordendecompra='".$orden["idordendecompra"]."'";
                    $resultUpdateFechas=mysql_query($sqlUpdatefechas,$con) or die(mysql_error());
                    
                }                
                
            }
            
        }   
    }
                   




?>
