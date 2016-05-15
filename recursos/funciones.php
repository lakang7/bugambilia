<?php

    function Conexion(){        
        $conexion = mysql_connect("localhost", "root", "");
	mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'", $conexion);
        mysql_select_db("bugambiliasis", $conexion);	        
	return $conexion;
    }

    
    function Menu($usuario){
        $con= Conexion();
        $nivel01= array();
        $nivel02= array();  //diferentes submenu
        $nivel03= array();  //diferentes opciones submenus
        $sql_privilegios="select * from privilegio where idusuario='".$usuario."'";
        $result_privilegios=mysql_query($sql_privilegios,$con) or die(mysql_error());
        if(mysql_num_rows($result_privilegios)>0){
            while ($privilegio = mysql_fetch_assoc($result_privilegios)) {
                $band=0; 
                for($i=0;$i<count($nivel03);$i++){
                     if($nivel03[$i]==$privilegio["idopcionessubmenu"]){
                         $band=1;
                     }
                }
                if($band==0){
                    $nivel03[count($nivel03)]=$privilegio["idopcionessubmenu"];
                }
            } 
        }
        
        for($i=0;$i<count($nivel03);$i++){
            $sql_opcionessubmenu="select * from opcionessubmenu where idopcionessubmenu='".$nivel03[$i]."'";
            $result_opcionessubmenu=mysql_query($sql_opcionessubmenu,$con) or die(mysql_error());
            if(mysql_num_rows($result_opcionessubmenu)>0){
                while ($submenu = mysql_fetch_assoc($result_opcionessubmenu)) {
                    $band=0; 
                    for($j=0;$j<count($nivel02);$j++){
                         if($nivel02[$j]==$submenu["idsubmenu"]){
                             $band=1;
                         }
                    }
                    if($band==0){
                        $nivel02[count($nivel02)]=$submenu["idsubmenu"];
                    }                    
                }
            }
        }
        
        for($i=0;$i<count($nivel02);$i++){
            $sql_submenu="select * from submenu where idsubmenu='".$nivel02[$i]."'";
            $result_submenu=mysql_query($sql_submenu,$con) or die(mysql_error());
            if(mysql_num_rows($result_submenu)>0){
                while ($sub = mysql_fetch_assoc($result_submenu)) {
                    $band=0; 
                    for($j=0;$j<count($nivel01);$j++){
                         if($nivel01[$j]==$sub["idmenu"]){
                             $band=1;
                         }
                    }
                    if($band==0){
                        $nivel01[count($nivel01)]=$sub["idmenu"];
                    }                     
                }   
            }
        }               
        
     ?>
			<div id="sidebar" class="sidebar h-sidebar navbar-collapse collapse sidebar-fixed">
				<script type="text/javascript">
					try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
				</script>

				<ul class="nav nav-list">
                                    <?php
                                        for($i=0;$i<count($nivel01);$i++){
                                            $sql_menu="select * from menu where idmenu='".$nivel01[$i]."'";
                                            $result_menu=mysql_query($sql_menu,$con) or die(mysql_error());
                                            $menu = mysql_fetch_assoc($result_menu);
                                            echo "<li class='hover'>";
                                            echo "<a href='#'>";
                                            echo "<i class='".$menu["icono"]."'></i>";
                                            echo "<span class='menu-text'>".$menu["nombre"]."</span>";
                                            echo "</a>";
                                            echo "<b class='arrow'></b>";
                                            $cuenta=0;
                                            for($j=0;$j<count($nivel02);$j++){
                                                $sql_submenu="select * from submenu where idsubmenu='".$nivel02[$j]."' and idmenu='".$nivel01[$i]."'";
                                                $result_submenu=mysql_query($sql_submenu,$con) or die(mysql_error());
                                                if(mysql_num_rows($result_submenu)>0){
                                                    $cuenta++;
                                                }
                                            }
                                            if($cuenta>0){
                                                echo "<ul class='submenu'>";
                                                
                                                for($j=0;$j<count($nivel02);$j++){
                                                    $sql_submenu="select * from submenu where idsubmenu='".$nivel02[$j]."' and idmenu='".$nivel01[$i]."'";
                                                    $result_submenu=mysql_query($sql_submenu,$con) or die(mysql_error());
                                                    if(mysql_num_rows($result_submenu)>0){
                                                       $sub = mysql_fetch_assoc($result_submenu);                                                        
							echo "<li class='hover'>";
							echo "<a href='".$sub["pagina"]."'>";
							echo "<i class='menu-icon fa fa-caret-right'></i>";
							echo $sub["nombre"];
							echo "</a>";
							echo "<b class='arrow'></b>";
							echo "</li>";                                                                                                                                                   
                                                    }
                                                }                                                
                                                
                                                echo "</ul>";
                                            }
                                            echo "</li>";                                                                      
                                        }                                    
                                    ?>										
				</ul>
				<script type="text/javascript">
					try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
				</script>
			</div>

     <?php
    }
?>