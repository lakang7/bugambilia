<?php session_start(); 
    
    if(!isset($_SESSION["usuario"])){
        ?>
        <script type="text/javascript" language="JavaScript" >
            alert("Debe Iniciar Sesión para poder accesar a esta pantalla.");
            location.href = "index.php";
        </script>        
        <?php
    }

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>Bugambilia Buffets - Edición de Orden de Compra</title>
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
							Bugambilia Buffet
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
                                                <?php
                                                    $con=  Conexion();
                                                    $sqlUsuario="select * from usuario where idusuario='".$_SESSION["usuario"]."'";
                                                    $resultUsuario=mysql_query($sqlUsuario,$con) or die(mysql_error());
                                                    if(mysql_num_rows($resultUsuario)>0){
                                                        $usuario = mysql_fetch_assoc($resultUsuario);
                                                    }
                                                ?>
						<li class="light-blue user-min">
							<a data-toggle="dropdown" href="#" class="dropdown-toggle">
								<img class="nav-user-photo" src="assets/avatars/<?php echo $usuario["avatar"] ?>" alt="Jason's Photo" />
								<span class="user-info">
									<small>Bienvenid@,</small>
									<?php echo $usuario["usuario"]; ?>
								</span>
                                                                <i class="ace-icon fa fa-caret-down"></i>
							</a>
							<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                                                            <li onclick="salir()"><a href="#"><i class="ace-icon fa fa-power-off"></i>Logout</a></li>
							</ul>
						</li>
					</ul>
                                    <script type="text/javascript">
                                        function salir(){
                                            location.href = "recursos/acciones.php?tarea=-1";
                                        }
                                    </script>
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
                                            $sql_uno="select menualto.idmenualto, menualto.idmenu, menualto.idusuario, menu.posicion from menualto, menu where idusuario='".$_SESSION["usuario"]."' and menu.idmenu = menualto.idmenu order by menu.posicion";
                                            $result_uno=mysql_query($sql_uno,$con) or die(mysql_error());
                                            if(mysql_num_rows($result_uno)>0){
                                                
                                                while ($uno = mysql_fetch_assoc($result_uno)) {
                                                    $banderaGeneral=0;
                                                    $sql_dos="select * from menu where idmenu='".$uno["idmenu"]."'";
                                                    $result_dos=mysql_query($sql_dos,$con) or die(mysql_error());
                                                    $dos = mysql_fetch_assoc($result_dos);
                                                    
                                                    $sql_auxtres="select * from privilegio where idmenualto='".$uno["idmenualto"]."'";
                                                    $result_auxtres=mysql_query($sql_auxtres,$con) or die(mysql_error());
                                                    if(mysql_num_rows($result_auxtres)>0){
                                                        while ($auxtres = mysql_fetch_assoc($result_auxtres)) {
                                                            if($auxtres["accion01"]!=0 || $auxtres["accion02"]!=0 || $auxtres["accion03"]!=0 ||$auxtres["accion04"]!=0 ||$auxtres["accion05"]!=0 || $auxtres["accion06"]!=0 || $auxtres["accion07"]!=0 || $auxtres["accion08"]!=0 || $auxtres["accion09"]!=0 || $auxtres["accion10"]!=0){
                                                                $banderaGeneral=1;
                                                            }
                                                        }            
                                                    }                                                    
                                                    
                                                    if($banderaGeneral==1){
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
                                                                                if($tres["accion01"]!=0 || $tres["accion02"]!=0 ||$tres["accion03"]!=0 ||$tres["accion04"]!=0 ||$tres["accion05"]!=0 ||$tres["accion06"]!=0 ||$tres["accion07"]!=0 ||$tres["accion08"]!=0 ||$tres["accion09"]!=0 ||$tres["accion10"]!=0){
                                                                                    $sql_cuatro="select * from submenu where idsubmenu='".$tres["idsubmenu"]."'";
                                                                                    $result_cuatro=mysql_query($sql_cuatro,$con) or die(mysql_error());
                                                                                    $cuatro = mysql_fetch_assoc($result_cuatro);
                                                                                    echo "<li class='hover'>";
                                                                                    if($cuatro["abre"]==0){
                                                                                        echo "<a href='".$cuatro["pagina"]."'>";
                                                                                    }else if($cuatro["abre"]==1){
                                                                                        echo "<a href='".$cuatro["pagina"]."' target='_blank'>";
                                                                                    }
                                                                                    echo "<i class='menu-icon fa fa-caret-right'></i>";
                                                                                    echo $cuatro["nombre"];
                                                                                    echo "</a>";                                                          
                                                                                    echo "<b class='arrow'></b>";
                                                                                    echo "</li>";                                                                                     
                                                                                }                                                             
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
                                            }
                                        ?>                                                        	                                                                                			
				</ul><!-- /.nav-list -->

				<script type="text/javascript">
					try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
				</script>
			</div>
                        
			<div class="main-content">
                            
				<div class="main-content-inner">
					<div class="page-content">
                                                    <?php
                                                        /*Acción Registrar Empresa*/
                                                        if(habilitaMenu($_SESSION["usuario"],4,8,1)==1){
                                                            echo "<a href='insertordendecompra.php'><button class='btn btn-white btn-info btn-bold'>";
                                                            echo "<i class='ace-icon fa fa-floppy-o bigger-120 blue'></i>";
                                                            echo "Agregar Nuevo Registro";
                                                            echo "</button></a>";                                                            
                                                        }
                                                        
                                                        /*Listar Empresas*/
                                                        if(habilitaMenu($_SESSION["usuario"],4,8,2)==1){
                                                            echo "<a href='listarordenesdecompra.php'><button class='btn btn-white btn-info btn-bold' style='margin-left: 8px;'>";
                                                            echo "<i class='ace-icon fa fa-list-alt bigger-120 blue'></i>";
                                                            echo "Listar Registros";
                                                            echo "</button></a>";                                                            
                                                        }                                                        
                                                    ?>
                                            
                                                        <?php
                                                            $con=Conexion();
                                                            $sql_ORDEN="select * from ordendecompra where idordendecompra='".$_GET["id"]."'";
                                                            $result_ORDEN=mysql_query($sql_ORDEN,$con) or die(mysql_error());
                                                            if(mysql_num_rows($result_ORDEN)>0){
                                                                $orden = mysql_fetch_assoc($result_ORDEN);                                                                                                                                           
                                                            }
                                                            mysql_close($con);
                                            
                                                            
                                                if(isset($_GET["campofiltro"])){
                                                ?>
                                                    <form method="post" id="form_crearEmpresa" action="recursos/acciones.php?tarea=22&id=<?php echo $_GET["id"]; ?>&pagina=<?php echo $_GET["pagina"] ?>&elementos=<?php echo $_GET["elementos"] ?>&campoordena=<?php echo $_GET["campoordena"] ?>&orden=<?php echo $_GET["orden"] ?>&campofiltro=<?php echo $_GET["campofiltro"] ?>&filtro=<?php echo $_GET["filtro"] ?>">
                                                <?php
                                                }else{
                                                ?>
                                                    <form method="post" id="form_crearEmpresa" action="recursos/acciones.php?tarea=22&id=<?php echo $_GET["id"]; ?>&pagina=<?php echo $_GET["pagina"] ?>&elementos=<?php echo $_GET["elementos"] ?>&campoordena=<?php echo $_GET["campoordena"] ?>&orden=<?php echo $_GET["orden"] ?>">
                                                <?php
                                                }
                                                            
                                                ?>    
                                                                                                                                                                                
						<div class="page-header"><h1>Orden de Compra<small><i class="ace-icon fa fa-angle-double-right"></i> Registro</small></h1></div>
						<div class="row">
                                                    <div class="col-md-6" style="border: 0px solid #CCC">
                                                        <div style="width: 70%">                                                             
                                                            <label>(*) Fecha de Registro (Fecha en que se recibio el pedido del cliente)</label>
                                                            <div class="row">
                                                                <div class="col-xs-8 col-sm-11">
                                                                    <div class="input-group">
                                                                        <input class="form-control date-picker" id="id-date-picker-1" name="id-date-picker-1" type="text" data-date-format="yyyy-mm-dd" value="<?php echo $orden["fechaderegistro"]; ?>" disabled="disabled" />
                                                                        <span class="input-group-addon">
                                                                            <i class="fa fa-calendar bigger-110"></i>
                                                                        </span>
								    </div>
                                                                </div>
                                                            </div>                                                                                                                                                                                        
                                                        </div>
                                                        <div style="width: 100%; margin-top: 10px">                                                             
                                                            <label>(*) Codigo externo orden de compra</label>
                                                            <div style="width: 100%">
                                                                <input type="text" id="codigoext" name="codigoext" value="<?php echo $orden["codigoexterno"]; ?>" placeholder="Codigo externo orden de compra"  maxlength="20" style="width: 100%" />
                                                            </div>                                                                                                                                                                                        
                                                        </div>                                                                                                                                                                          
                                                        
                                                        <div style="width: 100%; margin-top: 10px"> 
                                                            <label>(*) Codigo interno orden de Producción (Auto Generado)</label>
                                                            <div style="width: 100%">
                                                                <input type="text" readonly value="<?php echo $orden["codigoop"]; ?>" id="codigo02" name="codigo02" placeholder="Codigo interno orden de producción"  maxlength="20" style="width: 100%" />
                                                            </div>                                                                                                                                                                                        
                                                        </div>                                                        
                                                        
                                                        <div style="width: 100%; margin-top: 10px">                                                                                                                       
                                                            <label>(*) Tipo de Orden</label>
                                                            <div style="width: 100%;">
                                                            <select class="chosen-select form-control" id="tipoorden" name="tipoorden" data-placeholder="Seleccione el tipo de orden" required="required">
                                                                <option value="">  </option>
                                                                <option value="1" selected="selected">Registro Manual</option>
                                                                <option value="2">Registro Automatizado</option>													
                                                            </select>                                                                                                                         
                                                            </div>                                                                                                                                                                                                                                                                                                                                                                          
                                                        </div>
                                                        
                                                        <div style="width: 100%; margin-top: 10px">                                                                                                                       
                                                            <label>(*) Prioridad</label>
                                                            <div style="width: 100%;">
                                                            <select class="chosen-select form-control" id="prioridad" name="prioridad" data-placeholder="Seleccione la prioridad de la orden" required="required">                                                                
                                                                <?php
                                                                    if($orden["prioridad"]==1){
                                                                        echo "<option value='1' selected='selected'>Normal - de 28 a 42 días</option>";
                                                                        echo "<option value='2'>Urgente - asignacion manual de la fecha</option>";
                                                                    }else if($orden["prioridad"]==2){
                                                                        echo "<option value='1'>Normal - de 28 a 42 días</option>";
                                                                        echo "<option value='2' selected='selected'>Urgente - asignacion manual de la fecha</option>";                                                                        
                                                                    }
                                                                ?>													
                                                            </select>                                                                                                                         
                                                            </div>                                                                                                                                                                                                                                                                                                                                                                          
                                                        </div>                                                        
                                                        <div id="contenedorprioridad" > 
                                                        <?php
                                                            if($orden["prioridad"]==2){
                                                                echo "<div style='width: 70%;margin-top: 10px'>";                                                            
                                                                echo "<label>(*) Fecha de Entrega</label>";
                                                                echo "<div class='row'>";
                                                                echo "<div class='col-xs-8 col-sm-11'>";
                                                                echo "<div class='input-group'>";
                                                                echo "<input class='form-control date-picker' id='id-date-picker-2' name='id-date-picker-2' type='text' data-date-format='yyyy-mm-dd' value='".$orden["fechadeentrega"]."' />";
                                                                echo "<span class='input-group-addon'>";
                                                                echo "<i class='fa fa-calendar bigger-110'></i>";
                                                                echo "</span>";
                                                                echo "</div>";
                                                                echo "</div>";
                                                                echo "</div>";                                                                                                                                                                                      
                                                                echo "</div>"; 
                                                            }
                                                        ?>
                                                        </div>                                                        
                                                        <div style="width: 100%; margin-top: 10px">
                                                            <label>(*) Empresa</label>                                                             
                                                            <div id="capaiva">
                                                            <?php
                                                                $con=Conexion();
                                                                $sqlEmpresa="select * from empresa where idempresa='".$orden["idempresa"]."'";
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
                                                                mysql_close($con); 
                                                            ?>
                                                            </div>
                                                            <select class="chosen-select form-control" disabled="true" id="empresa" name="empresa" data-placeholder="Elija la empresa solicitante" required="required">
                                                            <option value="">  </option>
                                                            <?php
                                                                $con=Conexion();
                                                                $sql_listaEMPRESA="select * from empresa order by nombrecomercial";
                                                                $result_listaEMPRESA=mysql_query($sql_listaEMPRESA,$con) or die(mysql_error());
                                                                if(mysql_num_rows($result_listaEMPRESA)>0){
                                                                    while ($fila = mysql_fetch_assoc($result_listaEMPRESA)) {
                                                                        if($orden["idempresa"]==$fila["idempresa"]){
                                                                            echo "<option value='".$fila["idempresa"]."' selected='selected'>".$fila["nombrecomercial"]."</option>";
                                                                        }  else {
                                                                            echo "<option value='".$fila["idempresa"]."'>".$fila["nombrecomercial"]."</option>";
                                                                        }
                                                                    
                                                                    }
                                                                }
                                                                mysql_close($con);                                                                
                                                            ?>
                                                            </select>                                                        
                                                        </div>
                                                        <div style="width: 100%; margin-top: 10px">
                                                            <div id="contenedor01">
                                                                <?php
                                                                    $con=Conexion();
                                                                    if($orden["idsucursal"]!=NULL){                                                                        
                                                                        $sql_cuenta="select count(*) as total from sucursal where idempresa='".$orden["idempresa"]."' order by nombrecomercial";
                                                                        $result_cuenta=mysql_query($sql_cuenta,$con) or die(mysql_error());
                                                                        $total = mysql_fetch_assoc($result_cuenta);
                                                                        if($total["total"]>0){
                                                                            echo "<div style='width: 100%; float: left; margin-right: 10px'>";
                                                                            echo "<label>Sucursal</label>";
                                                                            echo "<select class='chosen-select form-control' disabled='true' id='sucursal' name='sucursal' data-placeholder='Elija la sucursal solicitante'>";
                                                                            echo "<option value=''></option>";
                                                                            $sql_listaSucursal="select * from sucursal where idempresa='".$orden["idempresa"]."' order by nombrecomercial";
                                                                            $result_listaSucursal=mysql_query($sql_listaSucursal,$con) or die(mysql_error());
                                                                            if(mysql_num_rows($result_listaSucursal)>0){
                                                                                while ($sucursal = mysql_fetch_assoc($result_listaSucursal)) {
                                                                                    if($orden["idsucursal"]==$sucursal["idsucursal"]){
                                                                                        echo "<option value='".$sucursal["idsucursal"]."' selected='selected'>".$sucursal["nombrecomercial"]."</option>";
                                                                                    }else{
                                                                                        echo "<option value='".$sucursal["idsucursal"]."'>".$sucursal["nombrecomercial"]."</option>";
                                                                                    }                                                                                    
                                                                                }
                                                                            }
                                                                            echo "</select>";
                                                                            echo "</div>";
                                                                            echo "<div id='contenedor02' style='margin-top: 10px'>";
                                                                            if($orden["idestado"]!=NULL){                                                                                                                                                                
                                                                                $sql_cuenta="select count(*) as total from estadosensucursal where idsucursal='".$orden["idsucursal"]."'";
                                                                                $result_cuenta=mysql_query($sql_cuenta,$con) or die(mysql_error());
                                                                                $total = mysql_fetch_assoc($result_cuenta);         
                                                                                echo "<div style='width: 100%; margin-top: 10px'>";
                                                                                echo "<label style='margin-top: 10px'>Región</label>";
                                                                                echo "<select class='chosen-select form-control' disabled='true' id='region' name='region' data-placeholder='Elija la región solicitante'>";
                                                                                echo "<option value=''></option>";
                                                                                $sql_listaESTSUCURSAL="select * from estadosensucursal where idsucursal='".$orden["idsucursal"]."'";
                                                                                $result_listaESTSUCURSAL=mysql_query($sql_listaESTSUCURSAL,$con) or die(mysql_error());
                                                                                if(mysql_num_rows($result_listaESTSUCURSAL)>0){
                                                                                    while ($fila = mysql_fetch_assoc($result_listaESTSUCURSAL)) {
                                                                                        $sql_estado="select * from estado where idestado='".$fila["idestado"]."'";
                                                                                        $result_estado=mysql_query($sql_estado,$con) or die(mysql_error());
                                                                                        $fila02 = mysql_fetch_assoc($result_estado);
                                                                                        if($fila02["idestado"]==$orden["idestado"]){
                                                                                           echo "<option value='".$fila["idestado"]."' selected='selected'>".$fila02["nombre"]."</option>"; 
                                                                                        }else {
                                                                                           echo "<option value='".$fila["idestado"]."'>".$fila02["nombre"]."</option>"; 
                                                                                        }
                                                                                                            
                                                                                    }
                                                                                }
                                                                                echo "</select>"; 
                                                                                echo "</div>";                                                                                                                                                                                                                                                                                                                                
                                                                            }                                                                                                                                                        
                                                                            echo "</div>";            
                                                                        }                                                                                                                                                                                                                        
                                                                    }
                                                                    mysql_close($con);
                                                                ?>
                                                            </div>
                                                        </div>
                                                        <div id="contenedor03" >
                                                        <?php    
                                                        $con=Conexion();    
                                                        echo "<div style='width: 100%; margin-top: 10px'>";
                                                        echo "<label style='margin-top: 10px'>Contacto de Compra</label>";
                                                        echo "<select class='chosen-select form-control' id='contacto01' name='contacto01' data-placeholder='Elija el contacto asociado' required='required'>";
                                                        $sql_listaASOCIACION="select * from asociacionagenda where idempresa='".$orden["idempresa"]."'";
                                                        $result_listaASOCIACION=mysql_query($sql_listaASOCIACION,$con) or die(mysql_error());
                                                        if(mysql_num_rows($result_listaASOCIACION)>0){
                                                            while ($fila = mysql_fetch_assoc($result_listaASOCIACION)) {
                                                                $sql_agenda="select * from agenda where idagenda='".$fila["idagenda"]."'";
                                                                $result_agenda=mysql_query($sql_agenda,$con) or die(mysql_error());
                                                                $fila02 = mysql_fetch_assoc($result_agenda);
                                                                if($fila02["idagenda"]==$orden["idagenda01"]){
                                                                    echo "<option value='".$fila02["idagenda"]."' selected='selected'>".$fila02["nombre"]."</option>";
                                                                }else{
                                                                    echo "<option value='".$fila02["idagenda"]."'>".$fila02["nombre"]."</option>";
                                                                }                                                                                    
                                                            }
                                                        }
                                                        echo "</select>";                               
                                                        echo "</div>";
        
                                                        echo "<div style='width: 100%; margin-top: 10px'>";
                                                        echo "<label>Contacto de Cuentas por Pagar</label>";
                                                        echo "<select class='chosen-select form-control' id='contacto02' name='contacto02' data-placeholder='Elija el contacto asociado' required='required'>";
                                                        $sql_listaASOCIACION="select * from asociacionagenda where idempresa='".$orden["idempresa"]."'";
                                                        $result_listaASOCIACION=mysql_query($sql_listaASOCIACION,$con) or die(mysql_error());
                                                        if(mysql_num_rows($result_listaASOCIACION)>0){
                                                            while ($fila = mysql_fetch_assoc($result_listaASOCIACION)) {
                                                                $sql_agenda="select * from agenda where idagenda='".$fila["idagenda"]."'";
                                                                $result_agenda=mysql_query($sql_agenda,$con) or die(mysql_error());
                                                                $fila02 = mysql_fetch_assoc($result_agenda);
                                                                if($fila02["idagenda"]==$orden["idagenda02"]){
                                                                    echo "<option value='".$fila02["idagenda"]."' selected='selected'>".$fila02["nombre"]."</option>";                    
                                                                }else{
                                                                    echo "<option value='".$fila02["idagenda"]."'>".$fila02["nombre"]."</option>";                    
                                                                }                                                                
                                                            }
                                                        }
                                                        echo "</select>";                               
                                                        echo "</div>";
        
                                                        echo "<div style='width: 100%; margin-top: 10px'>";
                                                        echo "<label>Contacto de Entrega</label>";
                                                        echo "<select class='chosen-select form-control' id='contacto03' name='contacto03' data-placeholder='Elija el contacto asociado' required='required'>";
                                                        $sql_listaASOCIACION="select * from asociacionagenda where idempresa='".$orden["idempresa"]."'";
                                                        $result_listaASOCIACION=mysql_query($sql_listaASOCIACION,$con) or die(mysql_error());
                                                        if(mysql_num_rows($result_listaASOCIACION)>0){
                                                            while ($fila = mysql_fetch_assoc($result_listaASOCIACION)) {
                                                                $sql_agenda="select * from agenda where idagenda='".$fila["idagenda"]."'";
                                                                $result_agenda=mysql_query($sql_agenda,$con) or die(mysql_error());
                                                                $fila02 = mysql_fetch_assoc($result_agenda);
                                                                if($fila02["idagenda"]==$orden["idagenda03"]){
                                                                    echo "<option value='".$fila02["idagenda"]."' selected='selected'>".$fila02["nombre"]."</option>";
                                                                }else{
                                                                    echo "<option value='".$fila02["idagenda"]."'>".$fila02["nombre"]."</option>";
                                                                }                                                                                    
                                                            }
                                                        }
                                                        echo "</select>";                               
                                                        echo "</div>";                                                            
                                                        mysql_close($con);    
                                                        ?>  
                                                        </div>
                                                        <div id="contenedor04" >
                                                            <?php
                                                                $con=Conexion();
                                                                echo "<div style='width: 100%; margin-top: 10px'>";
                                                                echo "<label>Lista de Precios</label>";        
                                                                echo "<select class='chosen-select form-control' disabled='true' id='lista' name='lista' data-placeholder='Elija la lista de precios' required='required'>";
                                                                $sql_listaLISTAPRECIOS="select * from listadeprecios where idlistadeprecios='".$orden["idlistadeprecios"]."'";
                                                                $result_listaLISTAPRECIOS=mysql_query($sql_listaLISTAPRECIOS,$con) or die(mysql_error());
                                                                if(mysql_num_rows($result_listaLISTAPRECIOS)>0){
                                                                    while ($fila = mysql_fetch_assoc($result_listaLISTAPRECIOS)) {
                                                                        if($orden["idlistadeprecios"]==$fila["idlistadeprecios"]){
                                                                            echo "<option value='".$fila["idlistadeprecios"]."' selected='selected'>".$fila["nombre"]."</option>";
                                                                        }else{
                                                                            echo "<option value='".$fila["idlistadeprecios"]."'>".$fila["nombre"]."</option>";
                                                                        }
                                                                                            
                                                                    }
                                                                }
                                                                echo "</select>";
                                                                echo "</div>";
                                                                mysql_close($con); 
                                                           ?> 
                                                        </div>
                                                        
                                                        <div style="width: 100%; margin-top: 10px">                                                                                                                       
                                                            <label>(*) Condiciones de Pago</label>
                                                            <div style="width: 100%;">
                                                            <select class="chosen-select form-control" id="condiciones" name="condiciones" data-placeholder="Seleccione la prioridad de la orden" required="required">                                                                
                                                                <?php
                                                                    if($orden["condiciones"]==1){
                                                                        echo "<option value='1' selected='selected'>50% Anticipo 50% Contra Aviso de Entrega</option>";
                                                                        echo "<option value='2'>100% Contra Aviso de Entrega</option>";	
                                                                        echo "<option value='3'>50% Anticipo 15 dias de Credito</option>";
                                                                        echo "<option value='4'>50% Anticipo 30 dias de Credito</option>";
                                                                        echo "<option value='5'>Credito de 15 días</option>";
                                                                        echo "<option value='6'>Credito de 30 días</option>";                                                                        
                                                                    }
                                                                    if($orden["condiciones"]==2){
                                                                        echo "<option value='1'>50% Anticipo 50% Contra Aviso de Entrega</option>";
                                                                        echo "<option value='2' selected='selected'>100% Contra Aviso de Entrega</option>";	
                                                                        echo "<option value='3'>50% Anticipo 15 dias de Credito</option>";
                                                                        echo "<option value='4'>50% Anticipo 30 dias de Credito</option>";
                                                                        echo "<option value='5'>Credito de 15 días</option>";
                                                                        echo "<option value='6'>Credito de 30 días</option>";                                                                        
                                                                    }
                                                                    if($orden["condiciones"]==3){
                                                                        echo "<option value='1'>50% Anticipo 50% Contra Aviso de Entrega</option>";
                                                                        echo "<option value='2'>100% Contra Aviso de Entrega</option>";	
                                                                        echo "<option value='3' selected='selected'>50% Anticipo 15 dias de Credito</option>";
                                                                        echo "<option value='4'>50% Anticipo 30 dias de Credito</option>";
                                                                        echo "<option value='5'>Credito de 15 días</option>";
                                                                        echo "<option value='6'>Credito de 30 días</option>";                                                                        
                                                                    }
                                                                    if($orden["condiciones"]==4){
                                                                        echo "<option value='1'>50% Anticipo 50% Contra Aviso de Entrega</option>";
                                                                        echo "<option value='2'>100% Contra Aviso de Entrega</option>";	
                                                                        echo "<option value='3'>50% Anticipo 15 dias de Credito</option>";
                                                                        echo "<option value='4' selected='selected'>50% Anticipo 30 dias de Credito</option>";
                                                                        echo "<option value='5'>Credito de 15 días</option>";
                                                                        echo "<option value='6'>Credito de 30 días</option>";                                                                        
                                                                    }
                                                                    if($orden["condiciones"]==5){
                                                                        echo "<option value='1'>50% Anticipo 50% Contra Aviso de Entrega</option>";
                                                                        echo "<option value='2'>100% Contra Aviso de Entrega</option>";	
                                                                        echo "<option value='3'>50% Anticipo 15 dias de Credito</option>";
                                                                        echo "<option value='4'>50% Anticipo 30 dias de Credito</option>";
                                                                        echo "<option value='5' selected='selected'>Credito de 15 días</option>";
                                                                        echo "<option value='6'>Credito de 30 días</option>";                                                                        
                                                                    }
                                                                    if($orden["condiciones"]==6){
                                                                        echo "<option value='1'>50% Anticipo 50% Contra Aviso de Entrega</option>";
                                                                        echo "<option value='2'>100% Contra Aviso de Entrega</option>";	
                                                                        echo "<option value='3'>50% Anticipo 15 dias de Credito</option>";
                                                                        echo "<option value='4'>50% Anticipo 30 dias de Credito</option>";
                                                                        echo "<option value='5'>Credito de 15 días</option>";
                                                                        echo "<option value='6' selected='selected'>Credito de 30 días</option>";                                                                        
                                                                    }                                                                                                                                                                                                    
                                                                ?>                                                                
                                                            </select>                                                                                                                         
                                                            </div>                                                                                                                                                                                                                                                                                                                                                                          
                                                        </div> 
                                                        
                                                        <div style="width: 100%; margin-top: 10px">                                                             
                                                            <label>Paqueteria</label>
                                                            <div style="width: 100%">
                                                                <input type="text" id="paqueteria" value="<?php echo $orden["paqueteria"]; ?>" name="paqueteria" placeholder="Paqueteria para el envio de la orden"  maxlength="30" style="width: 100%" />
                                                            </div>                                                                                                                                                                                        
                                                        </div>  
                                                        
                                                        <div style="width: 100%; margin-top: 10px">                                                             
                                                            <label>Observaciones</label>
                                                            <div style="width: 100%">
                                                                <input type="text" id="observaciones" value="<?php echo $orden["observaciones"]; ?>" name="observaciones" placeholder="Observaciones para esta orden de compra"  maxlength="300" style="width: 100%" />
                                                            </div>                                                                                                                                                                                        
                                                        </div>  
                                                        
                                                        <div style="width: 100%; margin-top: 10px">                                                                                                                       
                                                            <label>(*) Tipo de Orden de Compra</label>
                                                            <div style="width: 100%;">
                                                            <select disabled="" class="chosen-select form-control" id="tipoordenc" name="tipoordenc" data-placeholder="Seleccione el tipo de orden" required="required">                                                                
                                                                <?php
                                                                    if($orden["conpago"]==1){
                                                                        echo "<option value='1' selected='selected'>Orden de compra paga</option>";
                                                                        echo "<option value='2'>Orden de compra de muestra</option>";
                                                                    }else if($orden["conpago"]==2){
                                                                        echo "<option value='1' >Orden de compra paga</option>";
                                                                        echo "<option value='2' selected='selected'>Orden de compra de muestra</option>";                                                                        
                                                                    }
                                                                ?>
	
                                                            </select>                                                                                                                         
                                                            </div>                                                                                                                                                                                                                                                                                                                                                                          
                                                        </div>  
                                                        
                                                        <div style="width: 100%; margin-top: 10px">                                                             
                                                            <label>Comentarios de facturación</label>
                                                            <div style="width: 100%">
                                                                <input type="text" id="comentarios" value="<?php echo $orden["comfacturacion"]; ?>" name="comentarios" placeholder="Comentarios para la factura"  maxlength="1200" style="width: 100%" />
                                                            </div>                                                                                                                                                                                        
                                                        </div>                                                          
                                                        
                                                        <div style="width: 100%; margin-top: 10px; margin-bottom: 5px">
                                                            <label>Productos en la Orden de Compra</label>
                                                        </div>
                                                        <div id="oculto00"></div>
                                                            <?php
                                                                $con=Conexion();
                                                                $listaIDS="";
                                                                $listaCODIGOS="";
                                                                $listaDESCRIPCIONES="";
                                                                $listaCOLORES="";
                                                                $listaPRECIOS="";
                                                                $listaUNIDADES="";
                                                                $sql_listaPro="select * from productosordencompra where idordendecompra='".$_GET["id"]."'";
                                                                $result_listaPro=mysql_query($sql_listaPro,$con) or die(mysql_error());
                                                                $cuenta=1;
                                                                if(mysql_num_rows($result_listaPro)>0){
                                                                    while ($pr = mysql_fetch_assoc($result_listaPro)) {
                                                                        $listaIDS=$listaIDS."_".$pr["idproducto"];
                                                                        $sqlPro="select * from producto where idproducto='".$pr["idproducto"]."'";
                                                                        $resultPro=mysql_query($sqlPro,$con) or die(mysql_error());
                                                                        $p = mysql_fetch_assoc($resultPro);
                                                                        $listaCODIGOS=$listaCODIGOS."_".$p["codigo"];
                                                                        $listaDESCRIPCIONES=$listaDESCRIPCIONES."_".$p["descripcion"];
                                                                        $listaPRECIOS=$listaPRECIOS."_".$pr["precioventa"];
                                                                        $listaUNIDADES=$listaUNIDADES."_".$pr["numerodeunidades"];
                                                                        $sqlCol="select * from color where idcolor='".$pr["idcolor"]."'";
                                                                        $resultCol=mysql_query($sqlCol,$con) or die(mysql_error());
                                                                        $color = mysql_fetch_assoc($resultCol);
                                                                        $listaCOLORES=$listaCOLORES."_".$color["nombre"];                                                                        
                                                                        $cuenta++;                                                                        
                                                                    }                                                                            
                                                                }
                                                                $cuenta--;
                                                                mysql_close($con); 
                                                            ?>                                                         
                                                        <input type="hidden" name="oculto01" id="oculto01" value="<?php echo $cuenta; ?>"/><!-- numero de la unidad -->
                                                        <input type="hidden" name="oculto02" id="oculto02" value="<?php echo $listaIDS; ?>"/> <!-- id productos -->
                                                        <input type="hidden" name="oculto03" id="oculto03" value="<?php echo $listaCODIGOS; ?>"/> <!-- codigo productos -->
                                                        <input type="hidden" name="oculto04" id="oculto04" value="<?php echo $listaDESCRIPCIONES; ?>"/> <!-- descripcion productos -->
                                                        <input type="hidden" name="oculto05" id="oculto05" value="<?php echo $listaCOLORES; ?>"/> <!-- colores producto -->
                                                        <input type="hidden" name="oculto06" id="oculto06" value="<?php echo $listaPRECIOS; ?>"/> <!-- precio productos -->
                                                        <input type="hidden" name="oculto07" id="oculto07" value="<?php echo $listaUNIDADES; ?>"/> <!-- unidades por producto -->
                                                        <div id="productosenorden">
                                                            <?php
                                                                $con=Conexion();
                                                                $sql_listaPro="select * from productosordencompra where idordendecompra='".$_GET["id"]."'";
                                                                $result_listaPro=mysql_query($sql_listaPro,$con) or die(mysql_error());
                                                                $cuenta=1;
                                                                if(mysql_num_rows($result_listaPro)>0){
                                                                    while ($pr = mysql_fetch_assoc($result_listaPro)) {
                                                                        $sqlPro="select * from producto where idproducto='".$pr["idproducto"]."'";
                                                                        $resultPro=mysql_query($sqlPro,$con) or die(mysql_error());
                                                                        $p = mysql_fetch_assoc($resultPro);
                                                                        
                                                                        $sqlCol="select * from color where idcolor='".$pr["idcolor"]."'";
                                                                        $resultCol=mysql_query($sqlCol,$con) or die(mysql_error());
                                                                        $color = mysql_fetch_assoc($resultCol);                                                                        
                                                                        echo "<div style='width: 100%; margin-bottom: 5px; border-bottom: 1px solid #CCC; font-size: 12px'><div style='width: 100%'><label style='font-weight: bold; margin-bottom: 0px; font-size: 12px'>Item Numero:</label> ".$cuenta."</div><div style='width: 100%'><label style='font-weight: bold; margin-bottom: 0px; font-size: 12px'>Codigo:</label> ".$p["codigo"]." / <label style='font-weight: bold; margin-bottom: 0px; font-size: 12px'>Color:</label> ".$color["nombre"]." / <label style='font-weight: bold; margin-bottom: 0px; font-size: 12px'>Descripcion:</label> ".$p["descripcion"]."</div><div style='width: 100%'><label style='font-weight: bold; margin-bottom: 0px; font-size: 12px'>Numero de Unidades:</label> ".$pr["numerodeunidades"]." / <label style='font-weight: bold; margin-bottom: 0px; font-size: 12px'>Costo Unitario:</label> $".$pr["precioventa"]." / <label style='font-weight: bold; margin-bottom: 0px; font-size: 12px'>Costo Total:</label> $".round(($pr["precioventa"]*$pr["numerodeunidades"]),2)."</div><div style='width: 100%'><div class='btn btn-minier btn-warning' href='#my-modal2' data-toggle='modal' style='margin-bottom: 5px; margin-right:5px; margin-top: 1px' onclick='editar(".$cuenta.")'>Editar</div><div class='btn btn-minier btn-danger' style='margin-bottom: 5px; margin-top: 1px' onclick='eliminar(".$cuenta.")'>Eliminar</div></div></div>";
                                                                        $cuenta++;                                                                        
                                                                    }                                                                            
                                                                } 
                                                                mysql_close($con); 
                                                            ?>                                                                                                                                                                                   
                                                        </div>
                                                        <div id="totalizacion" style="background-color: #eaeaea; font-size: 16px; padding: 1ex; width: 100%; height: 125px">
                                                            <div class="left" style="width: 50%; float: left">Productos: <label style="font-size: 22px; font-weight: bold"><?php echo ($cuenta-1); ?></label></div>
                                                            <div class="right" style="width: 50%; float: left; text-align: right">Subtotal:   <label style="font-size: 22px; font-weight: bold">$<?php echo round($orden["subtotal"],2); ?></label></div>
                                                            <div class="right" style="width: 100%; float: left; text-align: right">Iva:   <label style="font-size: 22px; font-weight: bold">$<?php echo round($orden["iva"],2); ?></label></div>
                                                            <div class="right" style="width: 100%; float: left; text-align: right">Total:   <label style="font-size: 22px; font-weight: bold">$<?php echo round($orden["total"],2); ?></label></div>
                                                        </div>
                                                        <div style="width: 100%; margin-top: 10px;">
                                                            <div id="agrega01" style="visibility: visible">Seleccione una empresa para poder agregar productos a la orden de compra</div>
                                                            <a id="agrega02" href="#my-modal" role="button" class="btn btn-sm btn-primary" data-toggle="modal" style="visibility: visible">Agregar Productos a la Orden de Compra</a>                                                            
                                                        </div>
                                                        
                                                                                                                                                                        
                                                    </div>
						</div>
                                                <button class="btn btn-info" type="submit" style="margin-top: 15px"><i class="ace-icon fa fa-check "></i>Registrar</button>                                                
					</div>
				</div>
                            </form>
                            
                            
                                                        <div id="my-modal2" class="modal fade" tabindex="-1" onshow="hola()">
                                                            <div class="modal-dialog">
								<div class="modal-content">
                                                                    <div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                        <h3 class="smaller lighter blue no-margin" >Editar Producto</h3>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div id="capacambio" style="width: 100%;">
                                                                            
                                                                        </div>                                                                        
                                                                    </div>                                                        
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                            
                            
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
                                                                        <div style="width: 100%;"><input type="number" min="0" id="unidades" name="unidades" placeholder="Número de unidades" style="width: 100%; font-size: 1.8ex; margin-bottom: 10px" maxlength="3" /></div>
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
                                                                    $("#oculto00").load("recursos/ajax.php", {tarea:19, idproducto: document.getElementById("producto").value, idcolor:document.getElementById("color").value, idlista:document.getElementById("lista").value, tipoorden:document.getElementById("tipoordenc").value  }, function(){
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
                                                                        
                                                                        $("#productosenorden").append("<div style='width: 100%; margin-bottom: 5px; border-bottom: 1px solid #CCC; font-size: 12px'><div style='width: 100%'><label style='font-weight: bold; margin-bottom: 0px; font-size: 12px'>Item Numero:</label> "+unidad+"</div><div style='width: 100%'><label style='font-weight: bold; margin-bottom: 0px; font-size: 12px'>Codigo:</label> "+procodigo+" / <label style='font-weight: bold; margin-bottom: 0px; font-size: 12px'>Color:</label> "+procolor+" / <label style='font-weight: bold; margin-bottom: 0px; font-size: 12px'>Descripcion:</label> "+prodescripcion+"</div><div style='width: 100%'><label style='font-weight: bold; margin-bottom: 0px; font-size: 12px'>Numero de Unidades:</label> "+prounidades+" / <label style='font-weight: bold; margin-bottom: 0px; font-size: 12px'>Costo Unitario:</label> $"+proprecio+" / <label style='font-weight: bold; margin-bottom: 0px; font-size: 12px'>Costo Total:</label> $"+parseFloat(proprecio*prounidades).toFixed(2)+"</div><div style='width: 100%'><div class='btn btn-minier btn-warning' style='margin-bottom: 5px; margin-right:5px; margin-top: 1px' href='#my-modal2' data-toggle='modal' onclick='editar("+unidad+")'>Editar</div><div class='btn btn-minier btn-danger' style='margin-bottom: 5px; margin-top: 1px' onclick='eliminar("+unidad+")'>Eliminar</div></div></div>");                                                                                                                                                
                                                                        
                                                                        $("#totalizacion").html("<div class='left' style='width: 50%; float: left'>Productos: <label style='font-size: 22px; font-weight: bold'>"+unidad+"</label></div><div class='right' style='width: 50%; float: left; text-align: right'>Subtotal:   <label style='font-size: 22px; font-weight: bold'>$"+parseFloat(acumulado).toFixed(2)+"</label></div><div class='right' style='width: 100%; float: left; text-align: right'>Iva:   <label style='font-size: 22px; font-weight: bold'>$"+iva.toFixed(2)+"</label></div><div class='right' style='width: 100%; float: left; text-align: right'>Total:   <label style='font-size: 22px; font-weight: bold'>$"+total.toFixed(2)+"</label></div>");
                                                                    });                                                                                                                                        
                                                                }else{
                                                                    alert("Debe seleccionar un producto, un color y un número de unidades para ser agregadas a la orden de compra.");
                                                                }
                                                            }
                                                            
                                                            function editar(id){
                                                                //alert(id);
                                                                $("#capacambio").load("recursos/ajax.php", {tarea:24, posicion: id, numeroelementos: document.getElementById("oculto01").value, identificadores: document.getElementById("oculto02").value, codigos: document.getElementById("oculto03").value, descripciones: document.getElementById("oculto04").value, colores: document.getElementById("oculto05").value, precios: document.getElementById("oculto06").value, unidades:document.getElementById("oculto07").value}, function(){
                                                                    
                                                                });
                                                            }   
                                                            
                                                            function actelemento(){                                                                                                                                
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
                                                                            $("#productosenorden").html("<div style='width: 100%; margin-bottom: 5px; border-bottom: 1px solid #CCC; font-size: 12px'><div style='width: 100%'><label style='font-weight: bold; margin-bottom: 0px; font-size: 12px'>Item Numero:</label> "+cuenta+"</div><div style='width: 100%'><label style='font-weight: bold; margin-bottom: 0px; font-size: 12px'>Codigo:</label> "+listacodigos[i]+" / <label style='font-weight: bold; margin-bottom: 0px; font-size: 12px'>Color:</label> "+listacolores[i]+" / <label style='font-weight: bold; margin-bottom: 0px; font-size: 12px'>Descripcion:</label> "+listadescripciones[i]+"</div><div style='width: 100%'><label style='font-weight: bold; margin-bottom: 0px; font-size: 12px'>Numero de Unidades:</label> "+listaunidades[i]+" / <label style='font-weight: bold; margin-bottom: 0px; font-size: 12px'>Costo Unitario:</label> $"+listaprecios[i]+" / <label style='font-weight: bold; margin-bottom: 0px; font-size: 12px'>Costo Total:</label> $"+parseFloat(listaprecios[i]*listaunidades[i]).toFixed(2)+"</div><div style='width: 100%'><div class='btn btn-minier btn-warning' style='margin-bottom: 5px; margin-top: 1px; margin-right:5px' href='#my-modal2' data-toggle='modal' onclick='editar("+cuenta+")'>Editar</div><div class='btn btn-minier btn-danger' style='margin-bottom: 5px; margin-top: 1px' onclick='eliminar("+cuenta+")'>Eliminar</div></div></div>");
                                                                        }else{
                                                                            $("#productosenorden").append("<div style='width: 100%; margin-bottom: 5px; border-bottom: 1px solid #CCC; font-size: 12px'><div style='width: 100%'><label style='font-weight: bold; margin-bottom: 0px; font-size: 12px'>Item Numero:</label> "+cuenta+"</div><div style='width: 100%'><label style='font-weight: bold; margin-bottom: 0px; font-size: 12px'>Codigo:</label> "+listacodigos[i]+" / <label style='font-weight: bold; margin-bottom: 0px; font-size: 12px'>Color:</label> "+listacolores[i]+" / <label style='font-weight: bold; margin-bottom: 0px; font-size: 12px'>Descripcion:</label> "+listadescripciones[i]+"</div><div style='width: 100%'><label style='font-weight: bold; margin-bottom: 0px; font-size: 12px'>Numero de Unidades:</label> "+listaunidades[i]+" / <label style='font-weight: bold; margin-bottom: 0px; font-size: 12px'>Costo Unitario:</label> $"+listaprecios[i]+" / <label style='font-weight: bold; margin-bottom: 0px; font-size: 12px'>Costo Total:</label> $"+parseFloat(listaprecios[i]*listaunidades[i]).toFixed(2)+"</div><div style='width: 100%'><div class='btn btn-minier btn-warning' style='margin-bottom: 5px; margin-top: 1px; margin-right:5px' href='#my-modal2' data-toggle='modal' onclick='editar("+cuenta+")'>Editar</div><div class='btn btn-minier btn-danger' style='margin-bottom: 5px; margin-top: 1px' onclick='eliminar("+cuenta+")'>Eliminar</div></div></div>");
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
                                                            
                                                            function semodifica(){
                                                                var evalu=document.getElementById("campos").value;
                                                                var listacolores=document.getElementById("oculto05").value.split("_");
                                                                var listaprecios=document.getElementById("oculto06").value.split("_");
                                                                var listaunidades=document.getElementById("oculto07").value.split("_");
                                                                var nuevoprecios="";
                                                                var nuevounidade="";
                                                                var nuevocolores="";
                                                                for(var j=0;j<listaprecios.length;j++){
                                                                    if(listaprecios[j]!==""){
                                                                        if(j==evalu){
                                                                            nuevoprecios=nuevoprecios+"_"+document.getElementById("campre").value;
                                                                            nuevounidade=nuevounidade+"_"+document.getElementById("camuni").value;                                                                            
                                                                            nuevocolores=nuevocolores+"_"+document.getElementById("camcol").value; 
                                                                        }else{
                                                                            nuevoprecios=nuevoprecios+"_"+listaprecios[j];
                                                                            nuevounidade=nuevounidade+"_"+listaunidades[j];                                                                            
                                                                            nuevocolores=nuevocolores+"_"+listacolores[j];
                                                                        }
                                                                    }
                                                                }
                                                                document.getElementById("camcos").value = (Math.round((document.getElementById("camuni").value * document.getElementById("campre").value)*100)/100);
                                                                document.getElementById("oculto05").value = nuevocolores;
                                                                document.getElementById("oculto06").value = nuevoprecios;
                                                                document.getElementById("oculto07").value = nuevounidade;                                                                
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
                                                                            $("#productosenorden").html("<div style='width: 100%; margin-bottom: 5px; border-bottom: 1px solid #CCC; font-size: 12px'><div style='width: 100%'><label style='font-weight: bold; margin-bottom: 0px; font-size: 12px'>Item Numero:</label> "+cuenta+"</div><div style='width: 100%'><label style='font-weight: bold; margin-bottom: 0px; font-size: 12px'>Codigo:</label> "+listacodigos[i]+" / <label style='font-weight: bold; margin-bottom: 0px; font-size: 12px'>Color:</label> "+listacolores[i]+" / <label style='font-weight: bold; margin-bottom: 0px; font-size: 12px'>Descripcion:</label> "+listadescripciones[i]+"</div><div style='width: 100%'><label style='font-weight: bold; margin-bottom: 0px; font-size: 12px'>Numero de Unidades:</label> "+listaunidades[i]+" / <label style='font-weight: bold; margin-bottom: 0px; font-size: 12px'>Costo Unitario:</label> $"+listaprecios[i]+" / <label style='font-weight: bold; margin-bottom: 0px; font-size: 12px'>Costo Total:</label> $"+parseFloat(listaprecios[i]*listaunidades[i]).toFixed(2)+"</div><div style='width: 100%'><div class='btn btn-minier btn-warning' style='margin-bottom: 5px; margin-right:5px; margin-top: 1px' href='#my-modal2' data-toggle='modal' onclick='editar("+cuenta+")'>Editar</div><div class='btn btn-minier btn-danger' style='margin-bottom: 5px; margin-top: 1px' onclick='eliminar("+cuenta+")'>Eliminar</div></div></div>");
                                                                        }else{
                                                                            $("#productosenorden").append("<div style='width: 100%; margin-bottom: 5px; border-bottom: 1px solid #CCC; font-size: 12px'><div style='width: 100%'><label style='font-weight: bold; margin-bottom: 0px; font-size: 12px'>Item Numero:</label> "+cuenta+"</div><div style='width: 100%'><label style='font-weight: bold; margin-bottom: 0px; font-size: 12px'>Codigo:</label> "+listacodigos[i]+" / <label style='font-weight: bold; margin-bottom: 0px; font-size: 12px'>Color:</label> "+listacolores[i]+" / <label style='font-weight: bold; margin-bottom: 0px; font-size: 12px'>Descripcion:</label> "+listadescripciones[i]+"</div><div style='width: 100%'><label style='font-weight: bold; margin-bottom: 0px; font-size: 12px'>Numero de Unidades:</label> "+listaunidades[i]+" / <label style='font-weight: bold; margin-bottom: 0px; font-size: 12px'>Costo Unitario:</label> $"+listaprecios[i]+" / <label style='font-weight: bold; margin-bottom: 0px; font-size: 12px'>Costo Total:</label> $"+parseFloat(listaprecios[i]*listaunidades[i]).toFixed(2)+"</div><div style='width: 100%'><div class='btn btn-minier btn-warning' style='margin-bottom: 5px; margin-right:5px; margin-top: 1px' href='#my-modal2' data-toggle='modal' onclick='editar("+cuenta+")'>Editar</div><div class='btn btn-minier btn-danger' style='margin-bottom: 5px; margin-top: 1px' onclick='eliminar("+cuenta+")'>Eliminar</div></div></div>");
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
							<span class="blue bolder">Bugambilia Buffet</span>
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
                                    
                                    $("#capaiva").load("recursos/ajax.php", {tarea:20, idempresa: selectedValue}, function(){
                                        
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
 