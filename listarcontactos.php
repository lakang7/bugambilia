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
		<title>Bugambilia Buffets - Listado de Contactos</title>
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
                <link rel="stylesheet" href="recursos/agenda.css" />
		<script src="assets/js/ace-extra.min.js"></script>
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
                                            <div class="container-fluid">
                                                    <?php
                                                        /*Acción Registrar Contacto*/
                                                        if(habilitaMenu($_SESSION["usuario"],1,1,1)==1){
                                                            echo "<a href='insertcontacto.php'><button class='btn btn-white btn-info btn-bold'>";
                                                            echo "<i class='ace-icon fa fa-floppy-o bigger-120 blue'></i>";
                                                            echo "Agregar Nuevo Registro";
                                                            echo "</button></a>";                                                            
                                                        }
                                                        
                                                        /*Listar Contactos*/
                                                        if(habilitaMenu($_SESSION["usuario"],1,1,2)==1){
                                                            echo "<a href='listarcontactos.php'><button class='btn btn-white btn-info btn-bold' style='margin-left: 8px;'>";
                                                            echo "<i class='ace-icon fa fa-list-alt bigger-120 blue'></i>";
                                                            echo "Listar Registros";
                                                            echo "</button></a>";                                                            
                                                        }                                                        
                                                    ?>                                                
                                                
						<div class="page-header"><h1>Contactos<small><i class="ace-icon fa fa-angle-double-right"></i> Agenda</small></h1></div>
                                                <div class="row contienefiltros">                                                    
                                                    <div style="width: 30%; float: right; margin-right: 1ex" >
                                                        <input type="text" onkeyup=filtrar() id="filtro" name="filtro" placeholder="Ingresa al menos tres letras" style="width: 100%;" maxlength="40" />
                                                    </div>  
                                                    <label style="float: right; margin-right: 1ex; line-height: 4ex">Filtrar</label>
                                                </div>
                                                <div class="row contieneletras">
                                                    <div id="A" class="letra" onclick=porletra("A") >A</div>
                                                    <div id="B" class="letra" onclick=porletra("B") >B</div>
                                                    <div id="C" class="letra" onclick=porletra("C") >C</div>
                                                    <div id="D" class="letra" onclick=porletra("D") >D</div>
                                                    <div id="E" class="letra" onclick=porletra("E") >E</div>
                                                    <div id="F" class="letra" onclick=porletra("F") >F</div>
                                                    <div id="G" class="letra" onclick=porletra("G") >G</div>
                                                    <div id="H" class="letra" onclick=porletra("H") >H</div>
                                                    <div id="I" class="letra" onclick=porletra("I") >I</div>
                                                    <div id="J" class="letra" onclick=porletra("J") >J</div>
                                                    <div id="K" class="letra" onclick=porletra("K") >K</div>
                                                    <div id="L" class="letra" onclick=porletra("L") >L</div>
                                                    <div id="M" class="letra" onclick=porletra("M") >M</div>
                                                    <div id="N" class="letra" onclick=porletra("N") >N</div>
                                                    <div id="Ñ" class="letra" onclick=porletra("Ñ") >Ñ</div>
                                                    <div id="O" class="letra" onclick=porletra("O") >O</div>
                                                    <div id="P" class="letra" onclick=porletra("P") >P</div>
                                                    <div id="Q" class="letra" onclick=porletra("Q") >Q</div>
                                                    <div id="R" class="letra" onclick=porletra("R") >R</div>
                                                    <div id="S" class="letra" onclick=porletra("S") >S</div>
                                                    <div id="T" class="letra" onclick=porletra("T") >T</div>
                                                    <div id="U" class="letra" onclick=porletra("U") >U</div>
                                                    <div id="V" class="letra" onclick=porletra("V") >V</div>
                                                    <div id="W" class="letra" onclick=porletra("W") >W</div>
                                                    <div id="X" class="letra" onclick=porletra("X") >X</div>
                                                    <div id="Y" class="letra" onclick=porletra("Y") >Y</div>
                                                    <div id="Z" class="letra" onclick=porletra("Z") >Z</div>                                                                                                        
                                                </div>
                                                <div id="contenedor">
                                                <?php
                                                    $con=Conexion();
                                                    $sql_listaAGENDA="select idagenda, nombre, referencia, email, telefono1, telefono2 from agenda order by nombre asc";
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
                                                        echo "<div class='row contacto'>".mysql_num_rows($result_listaAGENDA)." Contactos Encontrados</div>";
                                                    }
                                                ?>
                                                </div>
                                            </div>
					</div>
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
                                
	/*$("#filtro").keydown(function(event){
            alert(document.getElementById("filtro").value);
	});*/                                
                                
                                
			
			});
                        
                        function filtrar(){
                            var entrada = document.getElementById("filtro").value;
                            var n = entrada.length;  
                            var letras = new Array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","Ñ","O","P","Q","R","S","T","U","V","W","X","Y","Z");
                            for(var i=0;i<27;i++){
                                $("#"+letras[i]).removeClass("letra_selecciona");
                            }                            
                            $("#contenedor").load("recursos/ajax.php", {tarea:5,letras:document.getElementById("filtro").value}, function(){});                            
                        }
                        
                        function porletra(letra){
                            var letras = new Array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","Ñ","O","P","Q","R","S","T","U","V","W","X","Y","Z");
                            for(var i=0;i<27;i++){
                                $("#"+letras[i]).removeClass("letra_selecciona");
                            }
                            $("#"+letra).addClass("letra_selecciona");
                            $("#contenedor").load("recursos/ajax.php", {tarea:6,letras:letra}, function(){});                            
                        }
                        
		</script>
	</body>
</html>
