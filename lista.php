<?php
require_once("recursos/funciones.php");
//echo listlevel01(2);
//listlevel02(3,3);

     $con= Conexion();
     $sql_categoriatipo="select * from categoriatipo order by idcategoriatipo";
     $result_categoriatipo=mysql_query($sql_categoriatipo,$con) or die(mysql_error());
     while ($categoriatipo = mysql_fetch_assoc($result_categoriatipo)) {
         if(listlevel01($categoriatipo["idcategoriatipo"])>0){
            echo "------------------------------------------------>".$categoriatipo["tipocategoria"]."</br>";
            $concatena=" ( ";
            $sql_sub="select * from tipoproducto where idcategoriatipo='".$categoriatipo["idcategoriatipo"]."'";
            $result_sub=mysql_query($sql_sub,$con) or die(mysql_error());
            $indice=0;
            while ($sub = mysql_fetch_assoc($result_sub)) {
                if($indice==0){
                    $concatena= $concatena." idtipoproducto=".$sub["idtipoproducto"]." ";
                }else{
                    $concatena= $concatena." or idtipoproducto=".$sub["idtipoproducto"]." ";
                }
                
                $indice++;
            }
            
            $concatena=$concatena." ) ";
            
            
            $sql_forma="select * from categoriaproducto order by idcategoriaproducto";
            $result_formas=mysql_query($sql_forma,$con) or die(mysql_error());            
            while ($forma = mysql_fetch_assoc($result_formas)) {
                if(listlevel02($categoriatipo["idcategoriatipo"], $forma["idcategoriaproducto"])>0){
                    echo ">>>>>>>>>>>>>>>>>>>>>>>".$forma["nombreespanol"]."</br>";
                    
                    $sql_pat="select * from patronproducto where idcategoriaproducto='".$forma["idcategoriaproducto"]."' ";
                    $result_pat=mysql_query($sql_pat,$con) or die(mysql_error()); 
                    $concatena2=" ( ";
                    $indice2=0;
                    while ($pat = mysql_fetch_assoc($result_pat)) {
                        if($indice2==0){
                            $concatena2= $concatena2." idpatronproducto=".$pat["idpatronproducto"]." ";
                        }else{
                            $concatena2= $concatena2." or idpatronproducto=".$pat["idpatronproducto"]." ";
                        }                
                        $indice2++;                        
                    }
                    $concatena2=$concatena2." ) ";
                    
                    $sql_pro="select * from producto where ".$concatena." and ".$concatena2." order by codigo  ";
                    $result_pro=mysql_query($sql_pro,$con) or die(mysql_error());
                    while ($pro = mysql_fetch_assoc($result_pro)) {
                        echo $pro["codigo"]." ".$pro["descripcion"]."</br>";
                    }                    
                    
                }                                
            }              

             
         }
     }
     
    
     
     
?>