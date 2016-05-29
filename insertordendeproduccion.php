<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>Top Menu Style - Ace Admin</title>
		<meta name="description" content="top menu &amp; navigation" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
		<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
		<link rel="stylesheet" href="assets/font-awesome/4.2.0/css/font-awesome.min.css" />
                
		<!-- page specific plugin styles -->
		<link rel="stylesheet" href="assets/css/jquery-ui.custom.min.css" />
		<link rel="stylesheet" href="assets/css/chosen.min.css" />
		<link rel="stylesheet" href="assets/css/datepicker.min.css" />
		<link rel="stylesheet" href="assets/css/bootstrap-timepicker.min.css" />
		<link rel="stylesheet" href="assets/css/daterangepicker.min.css" />
		<link rel="stylesheet" href="assets/css/bootstrap-datetimepicker.min.css" />
		<link rel="stylesheet" href="assets/css/colorpicker.min.css" />                
                
		<link rel="stylesheet" href="assets/fonts/fonts.googleapis.com.css" />
		<link rel="stylesheet" href="assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />
		<script src="assets/js/ace-extra.min.js"></script>
                <style type="text/css">
                    .element.style {
                        width: 100%;                        
                    }               
                    .chosen-container-single {
                        width: 100%;
                    }
                    .chosen-container {
                        width: 100%;
                    }
                </style>
                <?php
                    header('Content-Type: text/html; charset=UTF-8');        
                    require_once("recursos/funciones.php");
                    Conexion();
                ?>                 
	</head>

	<body class="no-skin">
		<div id="navbar" class="navbar navbar-default navbar-collapse h-navbar navbar-fixed-top">
			<script type="text/javascript">
				try{ace.settings.check('navbar' , 'fixed')}catch(e){}
			</script>

			<div class="navbar-container" id="navbar-container">
				<div class="navbar-header pull-left">
					<a href="index.php" class="navbar-brand">
						<small>
							<i class="fa fa-leaf"></i>
							Bugambilia
						</small>
					</a>

					<button class="pull-right navbar-toggle navbar-toggle-img collapsed" type="button" data-toggle="collapse" data-target=".navbar-buttons,.navbar-menu">
						<span class="sr-only">Toggle user menu</span>

						<img src="assets/avatars/user.jpg" alt="Jason's Photo" />
					</button>

					<button class="pull-right navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#sidebar">
						<span class="sr-only">Toggle sidebar</span>

						<span class="icon-bar"></span>

						<span class="icon-bar"></span>

						<span class="icon-bar"></span>
					</button>
				</div>

				<div class="navbar-buttons navbar-header pull-right  collapse navbar-collapse" role="navigation">
					<ul class="nav ace-nav">

						<li class="light-blue user-min">
							<a data-toggle="dropdown" href="#" class="dropdown-toggle">
								<img class="nav-user-photo" src="assets/avatars/user.jpg" alt="Jason's Photo" />
								<span class="user-info">
									<small>Welcome,</small>
									Jason
								</span>
								<i class="ace-icon fa fa-caret-down"></i>
							</a>
							<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
								<li><a href="#"><i class="ace-icon fa fa-cog"></i>Settings</a></li>
								<li><a href="profile.html"><i class="ace-icon fa fa-user"></i>Profile</a></li>
								<li class="divider"></li>
								<li><a href="#"><i class="ace-icon fa fa-power-off"></i>Logout</a></li>
							</ul>
						</li>
					</ul>
				</div>

				<nav role="navigation" class="navbar-menu pull-left collapse navbar-collapse">
					<ul class="nav navbar-nav">
					</ul>
				</nav>
			</div><!-- /.navbar-container -->
		</div>

		<div class="main-container" id="main-container">
			<script type="text/javascript">
				try{ace.settings.check('main-container' , 'fixed')}catch(e){}
			</script>

			<div id="sidebar" class="sidebar h-sidebar navbar-collapse collapse">
				<script type="text/javascript">
					try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
				</script>

				<ul class="nav nav-list">
                                        <?php 
                                            $con=  Conexion();
                                            $sql_uno="select * from menualto where idusuario='".$_SESSION["usuario"]."'";
                                            $result_uno=mysql_query($sql_uno,$con) or die(mysql_error());
                                            if(mysql_num_rows($result_uno)>0){
                                                while ($uno = mysql_fetch_assoc($result_uno)) {
                                                    $sql_dos="select * from menu where idmenu='".$uno["idmenu"]."'";
                                                    $result_dos=mysql_query($sql_dos,$con) or die(mysql_error());
                                                    $dos = mysql_fetch_assoc($result_dos);
                                                     ?>
                                                        <li class="hover">
                                                            <a href="#" class="dropdown-toggle"><i class="<?php echo $dos["icono"]; ?>"></i><span class="menu-text"><?php echo $dos["nombre"]; ?></span></a>                                                            
                                                            <b class="arrow"></b>
                                                            <?php
                                                                $sql_tres="select * from privilegio where idmenualto='".$uno["idmenualto"]."'";
                                                                $result_tres=mysql_query($sql_tres,$con) or die(mysql_error());
                                                                if(mysql_num_rows($result_tres)>0){
                                                                    ?>
                                                                    <ul class="submenu">
                                                                        <?php
                                                                            while ($tres = mysql_fetch_assoc($result_tres)) {
                                                                                $sql_cuatro="select * from submenu where idsubmenu='".$tres["idsubmenu"]."'";
                                                                                $result_cuatro=mysql_query($sql_cuatro,$con) or die(mysql_error());
                                                                                $cuatro = mysql_fetch_assoc($result_cuatro);
                                                                                echo "<li class='hover'>";
                                                                                echo "<a href='".$cuatro["pagina"]."'>";
                                                                                echo "<i class='menu-icon fa fa-caret-right'></i>";
                                                                                echo $cuatro["nombre"];
                                                                                echo "</a>";                                                          
                                                                                echo "<b class='arrow'></b>";
                                                                                echo "</li>";                                                              
                                                                            }
                                                                        ?>
                                                                    </ul>                 
                                                                   <?php                                                   
                                                                }
                                                            ?>
                                                        </li>                                    
                                                    <?php
                                                }   
                                            }
                                        ?>                                                        	                                                                                			
				</ul><!-- /.nav-list -->

				<script type="text/javascript">
					try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
				</script>
			</div>
                        
			<div class="main-content">
                            <form method="post" id="form_crearEmpresa" action="recursos/acciones2.php?tarea=18">
				<div class="main-content-inner">
					<div class="page-content">                                            
						<div class="page-header"><h1>Orden de Producción<small><i class="ace-icon fa fa-angle-double-right"></i> Registro</small></h1></div>
						<div class="row">
                                                    <div class="col-md-6" style="border: 0px solid #CCC">
                                                        <div style="width: 70%">                                                             
                                                            <label>(*) Fecha de Registro (Fecha en que se recibio el pedido del cliente)</label>
                                                            <div class="row">
                                                                <div class="col-xs-8 col-sm-11">
                                                                    <div class="input-group">
                                                                        <input class="form-control date-picker" id="id-date-picker-1" name="id-date-picker-1" type="text" data-date-format="yyyy-mm-dd" value="<?php echo date("Y")."-".date("m")."-".date("d"); ?>" />
                                                                        <span class="input-group-addon">
                                                                            <i class="fa fa-calendar bigger-110"></i>
                                                                        </span>
								    </div>
                                                                </div>
                                                            </div>                                                                                                                                                                                        
                                                        </div>                                                                                                                                                                                                                                
                                                        <div style="width: 100%; margin-top: 10px"> 
                                                            <?php
                                                                $con=Conexion();
                                                                $sqlConfiguracion="select * from configuracionsistema where idconfiguracionsistema=1";
                                                                $resultConfiguracion=mysql_query($sqlConfiguracion,$con) or die(mysql_error());
                                                                $configuracion = mysql_fetch_assoc($resultConfiguracion);
                                                                $codigo="POMX-".$configuracion["secuenciaop"];
                                                            ?>
                                                            <label>(*) Codigo interno orden de Producción (Auto Generado)</label>
                                                            <div style="width: 100%">
                                                                <input type="text" readonly value="<?php echo $codigo ?>" id="codigo02" name="codigo02" placeholder="Codigo interno orden de producción"  maxlength="20" style="width: 100%" />
                                                            </div>                                                                                                                                                                                        
                                                        </div>                                                                                                                                                                        
                                                        <div style="width: 100%; margin-top: 10px">                                                                                                                       
                                                            <label>(*) Prioridad</label>
                                                            <div style="width: 100%;">
                                                            <select class="chosen-select form-control" id="prioridad" name="prioridad" data-placeholder="Seleccione la prioridad de la orden" required="required">                                                                
                                                                <option value="1" selected="selected">Normal - de 28 a 42 días</option>
                                                                <option value="2">Urgente - asignacion manual de la fecha</option>													
                                                            </select>                                                                                                                         
                                                            </div>                                                                                                                                                                                                                                                                                                                                                                          
                                                        </div>                                                        
                                                        <div id="contenedorprioridad" >                                                                                                                                                                                                                                                
                                                        </div>
                                                        <div style="width: 100%; margin-top: 10px">
                                                            <label>(*) Persona Interna de Contacto para la orden de produccion</label> <div id="capaiva"></div>
                                                            <select class="chosen-select form-control" id="contacto" name="contacto" data-placeholder="Elija el contacto interno" required="required">
                                                            <option value="">  </option>
                                                            <?php
                                                                $con=Conexion();
                                                                $sql_listaUSUARIO="select * from usuario order by nombre";
                                                                $result_listaUSUARIO=mysql_query($sql_listaUSUARIO,$con) or die(mysql_error());
                                                                if(mysql_num_rows($result_listaUSUARIO)>0){
                                                                    while ($fila = mysql_fetch_assoc($result_listaUSUARIO)) {
                                                                    echo "<option value='".$fila["idusuario"]."'>".$fila["nombre"]."</option>";
                                                                    }
                                                                }
                                                                mysql_close($con);                                                                
                                                            ?>
                                                            </select>                                                        
                                                        </div>                                                        
                                                        <div style="width: 100%; margin-top: 10px">
                                                            <label>(*) Empresa</label> <div id="capaiva"></div>
                                                            <select class="chosen-select form-control" id="empresa" name="empresa" data-placeholder="Elija la empresa solicitante" required="required">
                                                            <option value="">  </option>
                                                            <?php
                                                                $con=Conexion();
                                                                $sql_listaEMPRESA="select * from empresa order by nombrecomercial";
                                                                $result_listaEMPRESA=mysql_query($sql_listaEMPRESA,$con) or die(mysql_error());
                                                                if(mysql_num_rows($result_listaEMPRESA)>0){
                                                                    while ($fila = mysql_fetch_assoc($result_listaEMPRESA)) {
                                                                    echo "<option value='".$fila["idempresa"]."'>".$fila["nombrecomercial"]."</option>";
                                                                    }
                                                                }
                                                                mysql_close($con);                                                                
                                                            ?>
                                                            </select>                                                        
                                                        </div>
                                                        <div style="width: 100%; margin-top: 10px">
                                                            <div id="contenedor01">
                                                                
                                                            </div>
                                                        </div>
                                                        <div id="contenedor03" ></div>
                                                        <div id="contenedor04" ></div>  
                                                        <div style="width: 100%; margin-top: 10px; margin-bottom: 5px">
                                                            <label>Productos en la Orden de Compra</label>
                                                        </div>
                                                        <div id="oculto00"></div>
                                                        <input type="hidden" name="oculto01" id="oculto01" value="0"/><!-- numero de la unidad -->
                                                        <input type="hidden" name="oculto02" id="oculto02" value=""/> <!-- id productos -->
                                                        <input type="hidden" name="oculto03" id="oculto03" value=""/> <!-- codigo productos -->
                                                        <input type="hidden" name="oculto04" id="oculto04" value=""/> <!-- descripcion productos -->
                                                        <input type="hidden" name="oculto05" id="oculto05" value=""/> <!-- colores producto -->
                                                        <input type="hidden" name="oculto06" id="oculto06" value=""/> <!-- precio productos -->
                                                        <input type="hidden" name="oculto07" id="oculto07" value=""/> <!-- unidades por producto -->
                                                        <div id="productosenorden">
                                                        </div>
                                                        <div id="totalizacion" style="background-color: #eaeaea; font-size: 16px; padding: 1ex; width: 100%; height: 125px">
                                                            <div class="left" style="width: 50%; float: left">Productos: <label style="font-size: 22px; font-weight: bold">0</label></div>
                                                            <div class="right" style="width: 50%; float: left; text-align: right">Subtotal:   <label style="font-size: 22px; font-weight: bold">$0</label></div>
                                                            <div class="right" style="width: 100%; float: left; text-align: right">Iva:   <label style="font-size: 22px; font-weight: bold">$0</label></div>
                                                            <div class="right" style="width: 100%; float: left; text-align: right">Total:   <label style="font-size: 22px; font-weight: bold">$0</label></div>
                                                        </div>
                                                        <div style="width: 100%; margin-top: 10px;">
                                                            <div id="agrega01" style="visibility: visible">Seleccione una empresa para poder agregar productos a la orden de compra</div>
                                                            <a id="agrega02" href="#my-modal" role="button" class="btn btn-sm btn-primary" data-toggle="modal" style="visibility: hidden">Agregar Productos a la Orden de Compra</a>                                                            
                                                        </div>
                                                        
                                                                                                                                                                        
                                                    </div>
						</div>
                                                <button class="btn btn-info" type="submit" style="margin-top: 15px"><i class="ace-icon fa fa-check "></i>Registrar</button>                                                
					</div>
				</div>
                            </form>
                            
                            
                            
                            
                                                        <div id="my-modal" class="modal fade" tabindex="-1" onshow="hola()">
                                                            <div class="modal-dialog">
								<div class="modal-content">
                                                                    <div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                        <h3 class="smaller lighter blue no-margin" >Busqueda de Productos</h3>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div style="width: 100%;">
                                                                            Forma del Producto
                                                                        </div>
                                                                        <div style="width: 100%;">
                                                                            <select class="chosen-select form-control" style="width: 100%" id="forma" name="forma" data-placeholder="Seleccione la forma del producto" required="required">
                                                                                <option value="">  </option>
                                                                                <?php
                                                                                    $con=Conexion();
                                                                                    $sql_listaFORMA="select * from categoriaproducto order by nombreespanol";
                                                                                    $result_listaFORMA=mysql_query($sql_listaFORMA,$con) or die(mysql_error());
                                                                                    if(mysql_num_rows($result_listaFORMA)>0){
                                                                                        while ($forma = mysql_fetch_assoc($result_listaFORMA)) {
                                                                                            $sql_cuenta01="select count(*) as total from patronproducto where idcategoriaproducto='".$forma["idcategoriaproducto"]."'";
                                                                                            $result_cuenta01=mysql_query($sql_cuenta01,$con) or die(mysql_error());
                                                                                            $total01 = mysql_fetch_assoc($result_cuenta01);
                                                                                            if($total01["total"]>0){
                                                                                                echo "<option value='".$forma["idcategoriaproducto"]."'>".$forma["nombreespanol"]."</option>";
                                                                                            }                                                                                            
                                                                                        }
                                                                                    }
                                                                                    mysql_close($con);                                                                
                                                                                ?>
                                                                            </select>                                                         
                                                                        </div>                                                                                                                                                                                                                        
                                                                        <div id="seleccion01">
                                                                        <div style="width: 100%;">
                                                                            Patrón del Producto
                                                                        </div>
                                                                        <div style="width: 100%;">
                                                                            <select class="chosen-select form-control" style="width: 100%" id="patron" name="patron" data-placeholder="Seleccione el patron del producto" required="required">
                                                                                <option value="">  </option>
                                                                                <?php
                                                                                    $con=Conexion();
                                                                                    $sql_listaPATRON="select * from patronproducto order by nombreespanol";
                                                                                    $result_listaPATRON=mysql_query($sql_listaPATRON,$con) or die(mysql_error());
                                                                                    if(mysql_num_rows($result_listaPATRON)>0){
                                                                                        while ($patron = mysql_fetch_assoc($result_listaPATRON)) {
                                                                                            $sql_cuenta02="select count(*) as total from producto where idpatronproducto='".$patron["idpatronproducto"]."'";
                                                                                            $result_cuenta02=mysql_query($sql_cuenta02,$con) or die(mysql_error());
                                                                                            $total02 = mysql_fetch_assoc($result_cuenta02); 
                                                                                            if($total02["total"]>0){
                                                                                                echo "<option value='".$patron["idpatronproducto"]."'>".$patron["nombreespanol"]."</option>";
                                                                                            }                                                                                            
                                                                                        }
                                                                                    }
                                                                                    mysql_close($con);                                                                
                                                                                ?>
                                                                            </select>                                                         
                                                                        </div>
                                                                        <div id="seleccion02">
                                                                        <div style="width: 100%;">
                                                                            (*) Producto 
                                                                        </div>
                                                                        <div style="width: 100%;">
                                                                            <select class="chosen-select form-control" style="width: 100%" id="producto" name="producto" data-placeholder="Seleccione el producto" required="required">
                                                                                <option value="">  </option>
                                                                                <?php
                                                                                    $con=Conexion();
                                                                                    $sql_listaPRODUCTO="select * from producto order by descripcion";
                                                                                    $result_listaPRODUCTO=mysql_query($sql_listaPRODUCTO,$con) or die(mysql_error());
                                                                                    if(mysql_num_rows($result_listaPRODUCTO)>0){
                                                                                        while ($producto = mysql_fetch_assoc($result_listaPRODUCTO)) {
                                                                                            echo "<option value='".$producto["idproducto"]."'>".$producto["codigo"]." ".$producto["descripcion"]."</option>";
                                                                                        }
                                                                                    }
                                                                                    mysql_close($con);                                                                
                                                                                ?>
                                                                            </select>                                                         
                                                                        </div>
                                                                        <div id="seleccion03">    
                                                                        <div style="width: 100%;">
                                                                           (*) Color
                                                                        </div>
                                                                        <div style="width: 100%;">
                                                                            <select class="chosen-select form-control" style="width: 100%" id="color" name="color" data-placeholder="Seleccione el color" required="required">
                                                                                <option value="">  </option>
                                                                                <?php
                                                                                    $con=Conexion();
                                                                                    $sql_listaCOLOR="select * from color order by nombre";
                                                                                    $result_listaCOLOR=mysql_query($sql_listaCOLOR,$con) or die(mysql_error());
                                                                                    if(mysql_num_rows($result_listaCOLOR)>0){
                                                                                        while ($color = mysql_fetch_assoc($result_listaCOLOR)) {
                                                                                            echo "<option value='".$color["idcolor"]."'>".$color["codigo"]." ".$color["nombre"]."</option>";
                                                                                        }
                                                                                    }
                                                                                    mysql_close($con);                                                                
                                                                                ?>
                                                                            </select>                                                         
                                                                        </div>
                                                                        </div> <!-- fin seleccion03 -->
                                                                        </div> <!-- fin seleccion02 -->
                                                                        </div> <!-- fin seleccion01 -->
                                                                        <div style="width: 100%;">
                                                                           Número de Unidades
                                                                        </div>
                                                                        <div style="width: 100%;"><input type="text" id="unidades" name="unidades" placeholder="Número de unidades" style="width: 100%; font-size: 1.8ex; margin-bottom: 10px" maxlength="3" /></div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button class="btn btn-sm btn-danger pull-right" data-dismiss="modal"><i class="ace-icon fa fa-times"></i>Cerrar</button>
                                                                        <button class="btn btn-sm btn-warning pull-right" style="margin-right: 10px" onclick="agregar()"><i class="ace-icon fa fa-plus"></i>Agregar Producto</button>
                                                                    </div>
								</div><!-- /.modal-content -->
                                                            </div><!-- /.modal-dialog -->
                                                            <script type="text/javascript">
                                                            function hola(){                                                                
                                                                $("#forma_chosen").width("100%");
                                                                $("#patron_chosen").width("100%");
                                                                $("#producto_chosen").width("100%");
                                                                $("#color_chosen").width("100%");
                                                            }
                                                            
                                                            function agregar(){                                                                
                                                                if(document.getElementById("producto").value!=="" && document.getElementById("color").value!=="" && document.getElementById("unidades").value!==""){                                                                    
                                                                    $("#oculto00").load("recursos/ajax.php", {tarea:22, idproducto: document.getElementById("producto").value, idcolor:document.getElementById("color").value, idlista:document.getElementById("lista").value }, function(){
                                                                        var resultado=document.getElementById("devuelve").value;
                                                                        var resp = resultado.split("_"); 
                                                                        var proid = resp[0];
                                                                        var procodigo = resp[1];
                                                                        var prodescripcion = resp[2];
                                                                        var procolor = resp[3];
                                                                        var proprecio = parseFloat(resp[4]).toFixed(2);
                                                                        var prounidades = parseFloat(document.getElementById("unidades").value).toFixed(0);
                                                                        var unidad = parseInt(document.getElementById("oculto01").value);
                                                                        unidad++;
                                                                        document.getElementById("oculto01").value=unidad;
                                                                        document.getElementById("oculto02").value=document.getElementById("oculto02").value+"_"+proid;
                                                                        document.getElementById("oculto03").value=document.getElementById("oculto03").value+"_"+procodigo;
                                                                        document.getElementById("oculto04").value=document.getElementById("oculto04").value+"_"+prodescripcion;
                                                                        document.getElementById("oculto05").value=document.getElementById("oculto05").value+"_"+procolor;
                                                                        document.getElementById("oculto06").value=document.getElementById("oculto06").value+"_"+proprecio;
                                                                        document.getElementById("oculto07").value=document.getElementById("oculto07").value+"_"+prounidades;
                                                                        var listaprecios = document.getElementById("oculto06").value.split("_");
                                                                        var listaunidades = document.getElementById("oculto07").value.split("_");
                                                                        var acumulado=parseFloat("0");
                                                                        for(var j=0;j<listaprecios.length;j++){
                                                                            if(listaprecios[j]!==""){
                                                                               acumulado+=parseFloat(listaprecios[j])*parseFloat(listaunidades[j]); 
                                                                            }                                                                            
                                                                        } 
                                                                        
                                                                        var iva=0;
                                                                        var total=0;                                                                        
                                                                        if(document.getElementById("appiva").value==="S"){
                                                                            var porcentaje=(parseFloat(document.getElementById("poriva").value)/100);
                                                                            iva = acumulado*porcentaje;
                                                                            total = acumulado + iva;
                                                                        }else{
                                                                            iva = 0;
                                                                            total = acumulado + iva;                                                                            
                                                                        }

                                                                        $("#productosenorden").append("<div style='width: 100%; margin-bottom: 5px; border-bottom: 1px solid #CCC; font-size: 12px'><div style='width: 100%'><label style='font-weight: bold; margin-bottom: 0px; font-size: 12px'>Item Numero:</label> "+unidad+"</div><div style='width: 100%'><label style='font-weight: bold; margin-bottom: 0px; font-size: 12px'>Numero de Unidades:</label> "+prounidades+"</div><div style='width: 100%'><label style='font-weight: bold; margin-bottom: 0px; font-size: 12px'>Codigo:</label> "+procodigo+" / <label style='font-weight: bold; margin-bottom: 0px; font-size: 12px'>Color:</label> "+procolor+" / <label style='font-weight: bold; margin-bottom: 0px; font-size: 12px'>Descripcion:</label> "+prodescripcion+"</div><div style='width: 100%'><label style='font-weight: bold; margin-bottom: 0px; font-size: 12px'>Costo Unitario:</label> $"+proprecio+" / <label style='font-weight: bold; margin-bottom: 0px; font-size: 12px'>Costo Total:</label> $"+parseFloat(proprecio*prounidades).toFixed(2)+"</div><div style='width: 100%'><div class='btn btn-minier btn-danger' style='margin-bottom: 5px; margin-top: 1px' onclick='eliminar("+unidad+")'>Eliminar</div></div></div>");                                                                                                                                                
                                                                        $("#totalizacion").html("<div class='left' style='width: 50%; float: left'>Productos: <label style='font-size: 22px; font-weight: bold'>"+unidad+"</label></div><div class='right' style='width: 50%; float: left; text-align: right'>Subtotal:   <label style='font-size: 22px; font-weight: bold'>$"+parseFloat(acumulado).toFixed(2)+"</label></div><div class='right' style='width: 100%; float: left; text-align: right'>Iva:   <label style='font-size: 22px; font-weight: bold'>$"+iva.toFixed(2)+"</label></div><div class='right' style='width: 100%; float: left; text-align: right'>Total:   <label style='font-size: 22px; font-weight: bold'>$"+total.toFixed(2)+"</label></div>");
                                                                    });                                                                                                                                        
                                                                }else{
                                                                    alert("Debe seleccionar un producto, un color y un número de unidades para ser agregadas a la orden de compra.");
                                                                }
                                                            }
                                                            
                                                            function eliminar(id){
                                                                //alert(id);                                                                
                                                                var items=document.getElementById("oculto01").value;
                                                                var ids=document.getElementById("oculto02").value;
                                                                var codigos=document.getElementById("oculto03").value;
                                                                var descripciones=document.getElementById("oculto04").value;
                                                                var colores=document.getElementById("oculto05").value;
                                                                var precios=document.getElementById("oculto06").value;
                                                                var unidades=document.getElementById("oculto07").value;
                                                                
                                                                var listaids = ids.split("_");
                                                                var listacodigos = codigos.split("_");
                                                                var listadescripciones = descripciones.split("_");
                                                                var listacolores = colores.split("_");
                                                                var listaprecios = precios.split("_");
                                                                var listaunidades = unidades.split("_");
                                                                
                                                                document.getElementById("oculto02").value="";
                                                                var misids = [];
                                                                for(var i=0;i<listaids.length;i++){
                                                                    if(listaids[i]!==""){
                                                                        misids[misids.length]=listaids[i];
                                                                    }
                                                                }
                                                                
                                                                document.getElementById("oculto03").value="";
                                                                var miscodigos = [];
                                                                for(var i=0;i<listacodigos.length;i++){
                                                                    if(listacodigos[i]!==""){
                                                                        miscodigos[miscodigos.length]=listacodigos[i];
                                                                    }
                                                                }
                                                                
                                                                document.getElementById("oculto04").value="";
                                                                var misdescripciones = [];
                                                                for(var i=0;i<listadescripciones.length;i++){
                                                                    if(listadescripciones[i]!==""){
                                                                        misdescripciones[misdescripciones.length]=listadescripciones[i];
                                                                    }
                                                                }   
                                                                
                                                                document.getElementById("oculto05").value="";
                                                                var miscolores = [];
                                                                for(var i=0;i<listacolores.length;i++){
                                                                    if(listacolores[i]!==""){
                                                                        miscolores[miscolores.length]=listacolores[i];
                                                                    }
                                                                }  
                                                                
                                                                document.getElementById("oculto06").value="";
                                                                var misprecios = [];
                                                                for(var i=0;i<listaprecios.length;i++){
                                                                    if(listaprecios[i]!==""){
                                                                        misprecios[misprecios.length]=listaprecios[i];
                                                                    }
                                                                } 
                                                                
                                                                document.getElementById("oculto07").value="";
                                                                var misunidades = [];
                                                                for(var i=0;i<listaunidades.length;i++){
                                                                    if(listaunidades[i]!==""){
                                                                        misunidades[misunidades.length]=listaunidades[i];
                                                                    }
                                                                }                                                                
                                                                                                                                                                                                                                                                
                                                                for(i=0;i<misids.length;i++){
                                                                    if((i+1)!==id){
                                                                        document.getElementById("oculto02").value=document.getElementById("oculto02").value+"_"+misids[i];
                                                                    }                                                                    
                                                                }
                                                                
                                                                for(i=0;i<miscodigos.length;i++){
                                                                    if((i+1)!==id){
                                                                        document.getElementById("oculto03").value=document.getElementById("oculto03").value+"_"+miscodigos[i];
                                                                    }                                                                    
                                                                } 
                                                                
                                                                for(i=0;i<misdescripciones.length;i++){
                                                                    if((i+1)!==id){
                                                                        document.getElementById("oculto04").value=document.getElementById("oculto04").value+"_"+misdescripciones[i];
                                                                    }                                                                    
                                                                } 
                                                                
                                                                for(i=0;i<miscolores.length;i++){
                                                                    if((i+1)!==id){
                                                                        document.getElementById("oculto05").value=document.getElementById("oculto05").value+"_"+miscolores[i];
                                                                    }                                                                    
                                                                } 
                                                                
                                                                for(i=0;i<misprecios.length;i++){
                                                                    if((i+1)!==id){
                                                                        document.getElementById("oculto06").value=document.getElementById("oculto06").value+"_"+misprecios[i];
                                                                    }                                                                    
                                                                }
                                                                
                                                                for(i=0;i<misunidades.length;i++){
                                                                    if((i+1)!==id){
                                                                        document.getElementById("oculto07").value=document.getElementById("oculto07").value+"_"+misunidades[i];
                                                                    }                                                                    
                                                                }                                                                                                                                
                                                                document.getElementById("oculto01").value=(items-1);
                                                                
                                                                var ids=document.getElementById("oculto02").value;
                                                                var codigos=document.getElementById("oculto03").value;
                                                                var descripciones=document.getElementById("oculto04").value;
                                                                var colores=document.getElementById("oculto05").value;
                                                                var precios=document.getElementById("oculto06").value;
                                                                var unidades=document.getElementById("oculto07").value;                                                                
                                                                var listaids = ids.split("_");
                                                                var listacodigos = codigos.split("_");
                                                                var listadescripciones = descripciones.split("_");
                                                                var listacolores = colores.split("_");
                                                                var listaprecios = precios.split("_");
                                                                var listaunidades = unidades.split("_");                                                                
                                                                var cuenta=1;
                                                                $("#productosenorden").html("");
                                                                for(var i=0;i<listaids.length;i++){
                                                                    if(listaids[i]!==""){
                                                                        if(cuenta===1){
                                                                            $("#productosenorden").html("<div style='width: 100%; margin-bottom: 5px; border-bottom: 1px solid #CCC; font-size: 12px'><div style='width: 100%'><label style='font-weight: bold; margin-bottom: 0px; font-size: 12px'>Item Numero:</label> "+cuenta+"</div><div style='width: 100%'><label style='font-weight: bold; margin-bottom: 0px; font-size: 12px'>Numero de Unidades:</label> "+listaunidades[i]+"</div><div style='width: 100%'><label style='font-weight: bold; margin-bottom: 0px; font-size: 12px'>Codigo:</label> "+listacodigos[i]+" / <label style='font-weight: bold; margin-bottom: 0px; font-size: 12px'>Color:</label> "+listacolores[i]+" / <label style='font-weight: bold; margin-bottom: 0px; font-size: 12px'>Descripcion:</label> "+listadescripciones[i]+"</div><div style='width: 100%'><label style='font-weight: bold; margin-bottom: 0px; font-size: 12px'>Costo Unitario:</label> $"+listaprecios[i]+" / <label style='font-weight: bold; margin-bottom: 0px; font-size: 12px'>Costo Total:</label> $"+parseFloat(listaprecios[i]*listaunidades[i]).toFixed(2)+"</div><div style='width: 100%'><div class='btn btn-minier btn-danger' style='margin-bottom: 5px; margin-top: 1px' onclick='eliminar("+cuenta+")'>Eliminar</div></div></div>");
                                                                        }else{
                                                                            $("#productosenorden").append("<div style='width: 100%; margin-bottom: 5px; border-bottom: 1px solid #CCC; font-size: 12px'><div style='width: 100%'><label style='font-weight: bold; margin-bottom: 0px; font-size: 12px'>Item Numero:</label> "+cuenta+"</div><div style='width: 100%'><label style='font-weight: bold; margin-bottom: 0px; font-size: 12px'>Numero de Unidades:</label> "+listaunidades[i]+"</div><div style='width: 100%'><label style='font-weight: bold; margin-bottom: 0px; font-size: 12px'>Codigo:</label> "+listacodigos[i]+" / <label style='font-weight: bold; margin-bottom: 0px; font-size: 12px'>Color:</label> "+listacolores[i]+" / <label style='font-weight: bold; margin-bottom: 0px; font-size: 12px'>Descripcion:</label> "+listadescripciones[i]+"</div><div style='width: 100%'><label style='font-weight: bold; margin-bottom: 0px; font-size: 12px'>Costo Unitario:</label> $"+listaprecios[i]+" / <label style='font-weight: bold; margin-bottom: 0px; font-size: 12px'>Costo Total:</label> $"+parseFloat(listaprecios[i]*listaunidades[i]).toFixed(2)+"</div><div style='width: 100%'><div class='btn btn-minier btn-danger' style='margin-bottom: 5px; margin-top: 1px' onclick='eliminar("+cuenta+")'>Eliminar</div></div></div>");
                                                                        }
                                                                        cuenta++;
                                                                    }                                                                        
                                                                }
                                                                
                                                                var acumulado=parseFloat("0");
                                                                for(var j=0;j<listaprecios.length;j++){
                                                                    if(listaprecios[j]!==""){
                                                                        acumulado+=parseFloat(listaprecios[j])*parseFloat(listaunidades[j]); 
                                                                    }                                                                            
                                                                }
                                                                
                                                                var iva=0;
                                                                var total=0;                                                                        
                                                                if(document.getElementById("appiva").value==="S"){
                                                                    var porcentaje=(parseFloat(document.getElementById("poriva").value)/100);
                                                                    iva = acumulado*porcentaje;
                                                                    total = acumulado + iva;
                                                                }else{
                                                                    iva = 0;
                                                                    total = acumulado + iva;                                                                            
                                                                }                                                                
                                                                
                                                                $("#totalizacion").html("<div class='left' style='width: 50%; float: left'>Productos: <label style='font-size: 22px; font-weight: bold'>"+document.getElementById("oculto01").value+"</label></div><div class='right' style='width: 50%; float: left; text-align: right'>Subtotal:   <label style='font-size: 22px; font-weight: bold'>$"+parseFloat(acumulado).toFixed(2)+"</label></div><div class='right' style='width: 100%; float: left; text-align: right'>Iva:   <label style='font-size: 22px; font-weight: bold'>$"+iva.toFixed(2)+"</label></div><div class='right' style='width: 100%; float: left; text-align: right'>Total:   <label style='font-size: 22px; font-weight: bold'>$"+total.toFixed(2)+"</label></div>");
                                                            }
                                                            </script>
							</div>                             
                            
                            
                            
                            
                            
                            
                            
			</div>
                        
                       
			
                        <div class="footer">
				<div class="footer-inner">
					<div class="footer-content">
						<span class="bigger-120">
							<span class="blue bolder">Bugambilia</span>
							Application &copy; 2016
						</span>

						&nbsp; &nbsp;
					</div>
				</div>
			</div>

			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
			</a>
		</div><!-- /.main-container -->

		<!-- basic scripts -->

		<!--[if !IE]> -->
		<script src="assets/js/jquery.2.1.1.min.js"></script>

		<!-- <![endif]-->

		<!--[if IE]>
<script src="assets/js/jquery.1.11.1.min.js"></script>
<![endif]-->

		<!--[if !IE]> -->
		<script type="text/javascript">
			window.jQuery || document.write("<script src='assets/js/jquery.min.js'>"+"<"+"/script>");
		</script>

		<!-- <![endif]-->

		<!--[if IE]>
<script type="text/javascript">
 window.jQuery || document.write("<script src='assets/js/jquery1x.min.js'>"+"<"+"/script>");
</script>
<![endif]-->
		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script src="assets/js/bootstrap.min.js"></script>

		<!-- page specific plugin scripts -->

		<!--[if lte IE 8]>
		  <script src="assets/js/excanvas.min.js"></script>
		<![endif]-->
		<script src="assets/js/jquery-ui.custom.min.js"></script>
		<script src="assets/js/jquery.ui.touch-punch.min.js"></script>
		<script src="assets/js/chosen.jquery.min.js"></script>
		<script src="assets/js/fuelux.spinner.min.js"></script>
		<script src="assets/js/bootstrap-datepicker.min.js"></script>
		<script src="assets/js/bootstrap-timepicker.min.js"></script>
		<script src="assets/js/moment.min.js"></script>
		<script src="assets/js/daterangepicker.min.js"></script>
		<script src="assets/js/bootstrap-datetimepicker.min.js"></script>
		<script src="assets/js/bootstrap-colorpicker.min.js"></script>
		<script src="assets/js/jquery.knob.min.js"></script>
		<script src="assets/js/jquery.autosize.min.js"></script>
		<script src="assets/js/jquery.inputlimiter.1.3.1.min.js"></script>
		<script src="assets/js/jquery.maskedinput.min.js"></script>
		<script src="assets/js/bootstrap-tag.min.js"></script>

		<!-- ace scripts -->
		<script src="assets/js/ace-elements.min.js"></script>
		<script src="assets/js/ace.min.js"></script>

		<!-- inline scripts related to this page -->
		<script type="text/javascript">
			jQuery(function($) {
				$('#id-disable-check').on('click', function() {
					var inp = $('#form-input-readonly').get(0);
					if(inp.hasAttribute('disabled')) {
						inp.setAttribute('readonly' , 'true');
						inp.removeAttribute('disabled');
						inp.value="This text field is readonly!";
					}
					else {
						inp.setAttribute('disabled' , 'disabled');
						inp.removeAttribute('readonly');
						inp.value="This text field is disabled!";
					}
				});
			
			
				if(!ace.vars['touch']) {
					$('.chosen-select').chosen({allow_single_deselect:true}); 
					//resize the chosen on window resize
			
					$(window)
					.off('resize.chosen')
					.on('resize.chosen', function() {
						$('.chosen-select').each(function() {
							 var $this = $(this);
							 $this.next().css({'width': $this.parent().width()});
						})
					}).trigger('resize.chosen');
					//resize chosen on sidebar collapse/expand
					$(document).on('settings.ace.chosen', function(e, event_name, event_val) {
						if(event_name != 'sidebar_collapsed') return;
						$('.chosen-select').each(function() {
							 var $this = $(this);
							 $this.next().css({'width': $this.parent().width()});
						})
					});
			
			
					$('#chosen-multiple-style .btn').on('click', function(e){
						var target = $(this).find('input[type=radio]');
						var which = parseInt(target.val());
						if(which == 2) $('#form-field-select-4').addClass('tag-input-style');
						 else $('#form-field-select-4').removeClass('tag-input-style');
					});
				}
			
			
				$('[data-rel=tooltip]').tooltip({container:'body'});
				$('[data-rel=popover]').popover({container:'body'});
				
				$('textarea[class*=autosize]').autosize({append: "\n"});
				$('textarea.limited').inputlimiter({
					remText: '%n character%s remaining...',
					limitText: 'max allowed : %n.'
				});
			
				$.mask.definitions['~']='[+-]';
				$('.input-mask-date').mask('99/99/9999');
				$('.input-mask-phone').mask('(999) 999-9999');
				$('.input-mask-eyescript').mask('~9.99 ~9.99 999');
				$(".input-mask-product").mask("a*-999-a999",{placeholder:" ",completed:function(){alert("You typed the following: "+this.val());}});
			
			
			
				$( "#input-size-slider" ).css('width','200px').slider({
					value:1,
					range: "min",
					min: 1,
					max: 8,
					step: 1,
					slide: function( event, ui ) {
						var sizing = ['', 'input-sm', 'input-lg', 'input-mini', 'input-small', 'input-medium', 'input-large', 'input-xlarge', 'input-xxlarge'];
						var val = parseInt(ui.value);
						$('#form-field-4').attr('class', sizing[val]).val('.'+sizing[val]);
					}
				});
			
				$( "#input-span-slider" ).slider({
					value:1,
					range: "min",
					min: 1,
					max: 12,
					step: 1,
					slide: function( event, ui ) {
						var val = parseInt(ui.value);
						$('#form-field-5').attr('class', 'col-xs-'+val).val('.col-xs-'+val);
					}
				});
			
			
				
				//"jQuery UI Slider"
				//range slider tooltip example
				$( "#slider-range" ).css('height','200px').slider({
					orientation: "vertical",
					range: true,
					min: 0,
					max: 100,
					values: [ 17, 67 ],
					slide: function( event, ui ) {
						var val = ui.values[$(ui.handle).index()-1] + "";
			
						if( !ui.handle.firstChild ) {
							$("<div class='tooltip right in' style='display:none;left:16px;top:-6px;'><div class='tooltip-arrow'></div><div class='tooltip-inner'></div></div>")
							.prependTo(ui.handle);
						}
						$(ui.handle.firstChild).show().children().eq(1).text(val);
					}
				}).find('span.ui-slider-handle').on('blur', function(){
					$(this.firstChild).hide();
				});
				
				
				$( "#slider-range-max" ).slider({
					range: "max",
					min: 1,
					max: 10,
					value: 2
				});
				
				$( "#slider-eq > span" ).css({width:'90%', 'float':'left', margin:'15px'}).each(function() {
					// read initial values from markup and remove that
					var value = parseInt( $( this ).text(), 10 );
					$( this ).empty().slider({
						value: value,
						range: "min",
						animate: true
						
					});
				});
				
				$("#slider-eq > span.ui-slider-purple").slider('disable');//disable third item
			
				
				$('#id-input-file-1 , #id-input-file-2').ace_file_input({
					no_file:'No File ...',
					btn_choose:'Choose',
					btn_change:'Change',
					droppable:false,
					onchange:null,
					thumbnail:false //| true | large
					//whitelist:'gif|png|jpg|jpeg'
					//blacklist:'exe|php'
					//onchange:''
					//
				});
				//pre-show a file name, for example a previously selected file
				//$('#id-input-file-1').ace_file_input('show_file_list', ['myfile.txt'])
			
			
				$('#id-input-file-3').ace_file_input({
					style:'well',
					btn_choose:'Drop files here or click to choose',
					btn_change:null,
					no_icon:'ace-icon fa fa-cloud-upload',
					droppable:true,
					thumbnail:'small'//large | fit
					//,icon_remove:null//set null, to hide remove/reset button
					/**,before_change:function(files, dropped) {
						//Check an example below
						//or examples/file-upload.html
						return true;
					}*/
					/**,before_remove : function() {
						return true;
					}*/
					,
					preview_error : function(filename, error_code) {
						//name of the file that failed
						//error_code values
						//1 = 'FILE_LOAD_FAILED',
						//2 = 'IMAGE_LOAD_FAILED',
						//3 = 'THUMBNAIL_FAILED'
						//alert(error_code);
					}
			
				}).on('change', function(){
					//console.log($(this).data('ace_input_files'));
					//console.log($(this).data('ace_input_method'));
				});
				
				
				//$('#id-input-file-3')
				//.ace_file_input('show_file_list', [
					//{type: 'image', name: 'name of image', path: 'http://path/to/image/for/preview'},
					//{type: 'file', name: 'hello.txt'}
				//]);
			
				
				
			
				//dynamically change allowed formats by changing allowExt && allowMime function
				$('#id-file-format').removeAttr('checked').on('change', function() {
					var whitelist_ext, whitelist_mime;
					var btn_choose
					var no_icon
					if(this.checked) {
						btn_choose = "Drop images here or click to choose";
						no_icon = "ace-icon fa fa-picture-o";
			
						whitelist_ext = ["jpeg", "jpg", "png", "gif" , "bmp"];
						whitelist_mime = ["image/jpg", "image/jpeg", "image/png", "image/gif", "image/bmp"];
					}
					else {
						btn_choose = "Drop files here or click to choose";
						no_icon = "ace-icon fa fa-cloud-upload";
						
						whitelist_ext = null;//all extensions are acceptable
						whitelist_mime = null;//all mimes are acceptable
					}
					var file_input = $('#id-input-file-3');
					file_input
					.ace_file_input('update_settings',
					{
						'btn_choose': btn_choose,
						'no_icon': no_icon,
						'allowExt': whitelist_ext,
						'allowMime': whitelist_mime
					})
					file_input.ace_file_input('reset_input');
					
					file_input
					.off('file.error.ace')
					.on('file.error.ace', function(e, info) {
						//console.log(info.file_count);//number of selected files
						//console.log(info.invalid_count);//number of invalid files
						//console.log(info.error_list);//a list of errors in the following format
						
						//info.error_count['ext']
						//info.error_count['mime']
						//info.error_count['size']
						
						//info.error_list['ext']  = [list of file names with invalid extension]
						//info.error_list['mime'] = [list of file names with invalid mimetype]
						//info.error_list['size'] = [list of file names with invalid size]
						
						
						/**
						if( !info.dropped ) {
							//perhapse reset file field if files have been selected, and there are invalid files among them
							//when files are dropped, only valid files will be added to our file array
							e.preventDefault();//it will rest input
						}
						*/
						
						
						//if files have been selected (not dropped), you can choose to reset input
						//because browser keeps all selected files anyway and this cannot be changed
						//we can only reset file field to become empty again
						//on any case you still should check files with your server side script
						//because any arbitrary file can be uploaded by user and it's not safe to rely on browser-side measures
					});
				
				});
			
				$('#spinner1').ace_spinner({value:0,min:0,max:200,step:10, btn_up_class:'btn-info' , btn_down_class:'btn-info'})
				.closest('.ace-spinner')
				.on('changed.fu.spinbox', function(){
					//alert($('#spinner1').val())
				}); 
				$('#spinner2').ace_spinner({value:0,min:0,max:10000,step:100, touch_spinner: true, icon_up:'ace-icon fa fa-caret-up bigger-110', icon_down:'ace-icon fa fa-caret-down bigger-110'});
				$('#spinner3').ace_spinner({value:0,min:-100,max:100,step:10, on_sides: true, icon_up:'ace-icon fa fa-plus bigger-110', icon_down:'ace-icon fa fa-minus bigger-110', btn_up_class:'btn-success' , btn_down_class:'btn-danger'});
				$('#spinner4').ace_spinner({value:0,min:-100,max:100,step:10, on_sides: true, icon_up:'ace-icon fa fa-plus', icon_down:'ace-icon fa fa-minus', btn_up_class:'btn-purple' , btn_down_class:'btn-purple'});
		
				$('.date-picker').datepicker({
					autoclose: true,
					todayHighlight: true
				})
				//show datepicker when clicking on the icon
				.next().on(ace.click_event, function(){
					$(this).prev().focus();
				});
			
				//or change it into a date range picker
				$('.input-daterange').datepicker({autoclose:true});
			
			
				//to translate the daterange picker, please copy the "examples/daterange-fr.js" contents here before initialization
				$('input[name=date-range-picker]').daterangepicker({
					'applyClass' : 'btn-sm btn-success',
					'cancelClass' : 'btn-sm btn-default',
					locale: {
						applyLabel: 'Apply',
						cancelLabel: 'Cancel',
					}
				})
				.prev().on(ace.click_event, function(){
					$(this).next().focus();
				});
			
			
				$('#timepicker1').timepicker({
					minuteStep: 1,
					showSeconds: true,
					showMeridian: false
				}).next().on(ace.click_event, function(){
					$(this).prev().focus();
				});
				
				$('#date-timepicker1').datetimepicker().next().on(ace.click_event, function(){
					$(this).prev().focus();
				});
				
			
				$('#colorpicker1').colorpicker();
			
				$('#simple-colorpicker-1').ace_colorpicker();
						
				$(".knob").knob();
				
				
				var tag_input = $('#form-field-tags');
				try{
					tag_input.tag(
					  {
						placeholder:tag_input.attr('placeholder'),
						//enable typeahead by specifying the source array
						source: ace.vars['US_STATES'],//defined in ace.js >> ace.enable_search_ahead
						/**
						//or fetch data from database, fetch those that match "query"
						source: function(query, process) {
						  $.ajax({url: 'remote_source.php?q='+encodeURIComponent(query)})
						  .done(function(result_items){
							process(result_items);
						  });
						}
						*/
					  }
					)
			
					//programmatically add a new
					var $tag_obj = $('#form-field-tags').data('tag');
					$tag_obj.add('Programmatically Added');
				}
				catch(e) {
					//display a textarea for old IE, because it doesn't support this plugin or another one I tried!
					tag_input.after('<textarea id="'+tag_input.attr('id')+'" name="'+tag_input.attr('name')+'" rows="3">'+tag_input.val()+'</textarea>').remove();
					//$('#form-field-tags').autosize({append: "\n"});
				}
				
				
				/////////
				$('#modal-form input[type=file]').ace_file_input({
					style:'well',
					btn_choose:'Drop files here or click to choose',
					btn_change:null,
					no_icon:'ace-icon fa fa-cloud-upload',
					droppable:true,
					thumbnail:'large'
				})
				

				$('#modal-form').on('shown.bs.modal', function () {
					if(!ace.vars['touch']) {
						$(this).find('.chosen-container').each(function(){
							$(this).find('a:first-child').css('width' , '210px');
							$(this).find('.chosen-drop').css('width' , '210px');
							$(this).find('.chosen-search input').css('width' , '200px');
						});
					}
				})

				$(document).one('ajaxloadstart.page', function(e) {
					$('textarea[class*=autosize]').trigger('autosize.destroy');
					$('.limiterBox,.autosizejs').remove();
					$('.daterangepicker.dropdown-menu,.colorpicker.dropdown-menu,.bootstrap-datetimepicker-widget.dropdown-menu').remove();
				});                                                              
			
                                $('#prioridad').change(function(){                        
                                    var $selectedOption = $(this).find('option:selected');
                                    var selectedValue = $selectedOption.val();
                                    $("#contenedorprioridad").load("recursos/ajax.php", {tarea:21, prioridad: selectedValue}, function(){
                                    	$('.date-picker').datepicker({
                                            autoclose: true,
                                            todayHighlight: true
                                        });                                       
                                        
                                    });                                    
                                    
                                });
                        
                        
                                $('#empresa').change(function(){


                                    var $selectedOption = $(this).find('option:selected');
                                    var selectedValue = $selectedOption.val();
                                    
                                    $("#capaiva").load("recursos/ajax.php", {tarea:23, idempresa: selectedValue}, function(){
                                        
                                    });
                                    $("#contenedor01").load("recursos/ajax.php", {tarea:12, idempresa: selectedValue}, function(){
                                        $('.chosen-select').chosen({allow_single_deselect:true});                                        
                                        $('#sucursal').change(function(){                                            
                                            var $selectedOption = $(this).find('option:selected');
                                            var selectedValue = $selectedOption.val();                                            
                                            $("#contenedor02").load("recursos/ajax.php", {tarea:13, idsucursal: selectedValue}, function(){
                                                $('.chosen-select').chosen({allow_single_deselect:true});
                                            });                                            
                                        });                                                                                
                                    });
                                    
                                    $("#contenedor03").load("recursos/ajax.php", {tarea:14, idempresa: selectedValue}, function(){
                                        $('.chosen-select').chosen({allow_single_deselect:true}); 
                                    });
                                    
                                    $("#contenedor04").load("recursos/ajax.php", {tarea:15, idempresa: selectedValue}, function(){
                                        $('.chosen-select').chosen({allow_single_deselect:true});
                                        $('#lista').change(function(){
                                            
                                            
                                            document.getElementById("oculto01").value="0";
                                            document.getElementById("oculto02").value="";
                                            document.getElementById("oculto03").value="";
                                            document.getElementById("oculto04").value="";
                                            document.getElementById("oculto05").value="";
                                            document.getElementById("oculto06").value="";
                                            document.getElementById("oculto07").value="";                                            
                                            
                                            $("#productosenorden").html("");
                                            var acumulado=0;
                                            //$("#totalizacion").html("<div class='left' style='width: 50%; float: left'>Productos: <label style='font-size: 22px; font-weight: bold'>"+document.getElementById("oculto01").value+"</label></div><div class='right' style='width: 50%; float: left; text-align: right'>Total:   <label style='font-size: 22px; font-weight: bold'>$"+parseFloat(acumulado).toFixed(2)+"</label></div>");
                                            $("#totalizacion").html("<div class='left' style='width: 50%; float: left'>Productos: <label style='font-size: 22px; font-weight: bold'>"+document.getElementById("oculto01").value+"</label></div><div class='right' style='width: 50%; float: left; text-align: right'>Subtotal:   <label style='font-size: 22px; font-weight: bold'>$"+parseFloat(acumulado).toFixed(2)+"</label></div><div class='right' style='width: 100%; float: left; text-align: right'>Iva:   <label style='font-size: 22px; font-weight: bold'>$"+0.00+"</label></div><div class='right' style='width: 100%; float: left; text-align: right'>Total:   <label style='font-size: 22px; font-weight: bold'>$"+0.00+"</label></div>");
                                            
                                        });                                         
                                        
                                    }); 
                                    
                                    $('#agrega01').css('visibility', 'hidden');
                                    $('#agrega02').css('visibility', 'visible');                                                                                                           
                                });  
                                
                                $('#forma').change(function(){
                                    var $selectedOption = $(this).find('option:selected');
                                    var selectedValue = $selectedOption.val();                                    
                                    $("#seleccion01").load("recursos/ajax.php", {tarea:16, idforma: selectedValue}, function(){
                                        $('.chosen-select').chosen({allow_single_deselect:true}); 
                                        
                                        $('#patron').change(function(){
                                            var $selectedOption = $(this).find('option:selected');
                                            var selectedValue = $selectedOption.val(); 
                                            $("#seleccion02").load("recursos/ajax.php", {tarea:17, idpatron: selectedValue}, function(){
                                                $('.chosen-select').chosen({allow_single_deselect:true});
                                                 
                                                $('#producto').change(function(){
                                                    var $selectedOption = $(this).find('option:selected');
                                                    var selectedValue = $selectedOption.val();                                                      
                                                    $("#seleccion03").load("recursos/ajax.php", {tarea:18, idproducto: selectedValue}, function(){
                                                        $('.chosen-select').chosen({allow_single_deselect:true});
                                                    });
                                                });                                                 
                                            });                                                                                        
                                        });                                                                                                                        
                                    });
                                });
                                
                                $('#patron').change(function(){
                                    var $selectedOption = $(this).find('option:selected');
                                    var selectedValue = $selectedOption.val(); 
                                    $("#seleccion02").load("recursos/ajax.php", {tarea:17, idpatron: selectedValue}, function(){
                                        $('.chosen-select').chosen({allow_single_deselect:true});
                                                 
                                        $('#producto').change(function(){
                                            var $selectedOption = $(this).find('option:selected');
                                            var selectedValue = $selectedOption.val();                                                      
                                            $("#seleccion03").load("recursos/ajax.php", {tarea:18, idproducto: selectedValue}, function(){
                                                $('.chosen-select').chosen({allow_single_deselect:true});
                                            });
                                        });                                                 
                                    });                                                                                        
                                });                                
                                
                                $('#producto').change(function(){
                                    var $selectedOption = $(this).find('option:selected');
                                    var selectedValue = $selectedOption.val();                                                      
                                    $("#seleccion03").load("recursos/ajax.php", {tarea:18, idproducto: selectedValue}, function(){
                                        $('.chosen-select').chosen({allow_single_deselect:true});
                                    });
                                }); 
                                

			});
		</script>
	</body>
</html>
