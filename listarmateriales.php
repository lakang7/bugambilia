<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>Bugambilia Buffets - Listado de Materiales</title>
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
                <link rel="stylesheet" href="recursos/tabla.css" />
                <script src="assets/js/ace-extra.min.js"></script>
                <?php
                    header('Content-Type: text/html; charset=UTF-8');        
                    require_once("recursos/funciones.php");
                    $con=Conexion();
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
                            
				<div class="main-content-inner">
					<div class="page-content">
                                            <div class="container-fluid">
                                                    <?php
                                                        /*Acción Registrar Empresa*/
                                                        if(habilitaMenu($_SESSION["usuario"],2,4,1)==1){
                                                            echo "<a href='insertmaterial.php'><button class='btn btn-white btn-info btn-bold'>";
                                                            echo "<i class='ace-icon fa fa-floppy-o bigger-120 blue'></i>";
                                                            echo "Agregar Nuevo Registro";
                                                            echo "</button></a>";                                                            
                                                        }
                                                        
                                                        /*Listar Empresas*/
                                                        if(habilitaMenu($_SESSION["usuario"],2,4,2)==1){
                                                            echo "<a href='listarmateriales.php'><button class='btn btn-white btn-info btn-bold' style='margin-left: 8px;'>";
                                                            echo "<i class='ace-icon fa fa-list-alt bigger-120 blue'></i>";
                                                            echo "Listar Registros";
                                                            echo "</button></a>";                                                            
                                                        }                                                        
                                                    ?> 
                                                
                                                <form method="post" id="form_crearEmpresa" action="recursos/acciones.php?tarea=1">
						<div class="page-header"><h1>Materiales<small><i class="ace-icon fa fa-angle-double-right"></i> Listado</small></h1></div>                                                                                                                                              
                                                <div class="row titulo_tabla">
                                                    Lista de Materiales
                                                </div>    
                                                <div class="row filtros_tabla">
                                                    <label style="float: left; margin-right: 1ex; color: #000; font-size: 1.8ex;line-height: 5ex">Mostrando</label>
                                                    <div style="width: 10%; float: left; margin-right: 1ex">
                                                        <select class="chosen-select form-control" onchange="limita()" id="elementos" name="elementos" data-placeholder="Número de elementos para mostrar">
                                                            <option value="10">10</option>
                                                            <option value="25">25</option>
                                                            <option value="50">50</option>
                                                            <option value="100">100</option>
                                                        </select>
                                                    </div>                                                    
                                                    <label style="float: left; margin-right: 1ex; color: #000; font-size: 1.8ex;line-height: 5ex">Registros</label>
                                                    <div style="width:auto; float: right; margin-right: 1.5ex">
                                                        <button class="btn btn-sm btn-success" type="button" onclick="filtrar()"><i class="ace-icon fa fa-check "></i>Filtrar</button>
                                                    </div>                                                            
                                                    <div style="width: 20%; float: right; margin-right: 1ex" >
                                                        <input type="text" id="filtro" name="filtro" placeholder="" style="width: 100%;" maxlength="40" />
                                                    </div>                                                            
                                                    <div style="width: 20%; float: right; margin-right: 1ex">
                                                        <select class="chosen-select form-control" id="camfiltro" name="camfiltro" data-placeholder="Escoja la columna para filtrar">
                                                            <option value="material.codigo">Código</option>
                                                            <option value="material.nombre">Nombre</option>
                                                            <option value="material.colores">Colores</option>
                                                        </select>
                                                    </div>                                                                                                        
                                                </div>
                                                <input type="hidden" id="campoordena" name="campoordena" value="material.codigo" >
                                                <input type="hidden" id="ordenordena" name="ordenordena" value="asc" >                                                
                                                <input type="hidden" id="pagina" name="pagina" value="1" >
                                                <div id="contenedortabla">
                                                <div class="row cabecera_tabla">
                                                    <div class="col-xs-2 columna_cabecera" onclick="ordena('material.codigo')">Código<i class="ace-icon glyphicon glyphicon-download" style="float: right"></i></div>
                                                    <div class="col-xs-3 columna_cabecera" onclick="ordena('material.nombre')">Nombre</div>
                                                    <div class="col-xs-5 columna_cabecera" onclick="ordena('material.colores')">Colores</div>                                                    
						</div>
                                                <?php 
                                                    $sql_listaEMPRESA="select material.codigo, material.nombre, material.colores, material.idmaterial from material order by material.codigo asc";
                                                    $result_listaEMPRESA=mysql_query($sql_listaEMPRESA,$con) or die(mysql_error());
                                                    if(mysql_num_rows($result_listaEMPRESA)>0){
                                                        $cuenta=0;
                                                        while ($fila = mysql_fetch_assoc($result_listaEMPRESA)) {
                                                            if($cuenta<10){
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
                                                    
                                                ?>                                                                                                 
                                                <div class="row pie_tabla" >
                                                    <?php
                                                    $numeroelementos=mysql_num_rows($result_listaEMPRESA);   
                                                    if(10>$numeroelementos){
                                                        echo "Mostrando ".$numeroelementos." de ".$numeroelementos." elementos";
                                                    }else{
                                                        echo "Mostrando 10 de ".$numeroelementos." elementos";
                                                    }
                               
                                                        
                                                    $numeropaginas=  ceil($numeroelementos/10);
                                                    $pagina=1;
                                                    echo "<ul class='pagination pull-right' style='margin-right: 10px;margin-top: 0px;margin-bottom: 0px'>";
                                                    echo "<li class='prev' onclick='pagina(1)'><a><i class='ace-icon fa fa-angle-double-left'></i></a></li>";
                                                    for($i=($pagina-3);$i<$numeropaginas && $i<($pagina+2);$i++){
                                                        if($i>-1){                    
                                                            if($i==($pagina-1)){
                                                                echo "<li onclick='pagina(".($i+1).")' class='active'><a>".($i+1)."</a></li>";
                                                            }else{
                                                                echo "<li onclick='pagina(".($i+1).")'><a>".($i+1)."</a></li>";
                                                            }                    
                                                        }                                                            
                                                    }
                                                    echo "<li onclick='pagina(".($numeropaginas).")' class='next'><a><i class='ace-icon fa fa-angle-double-right'></i></a></li>";
                                                    echo "</ul>";
                                                    ?>                                                    
                                                </div>
                                                </div>
					</div>
                                    </div>
				</div>
                            </form>
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
			});
		</script>
                <script type="text/javascript">
                    function ordena(columna){
                        var campoanterior = document.getElementById("campoordena").value;
                        var ordenanterior = document.getElementById("ordenordena").value;                        
                        if(campoanterior === columna){
                            if(ordenanterior === "desc"){
                                document.getElementById("ordenordena").value="asc";
                            }else{
                                document.getElementById("ordenordena").value="desc";
                            }
                        }else{
                            document.getElementById("campoordena").value=columna;
                            document.getElementById("ordenordena").value="desc";
                        }
                                                
                        $("#contenedortabla").load("recursos/tablas.php", {tabla:"materiales",campo:document.getElementById("campoordena").value,orden:document.getElementById("ordenordena").value,elementos:document.getElementById("elementos").value,camfiltro:document.getElementById("camfiltro").value,filtro:document.getElementById("filtro").value,pagina:document.getElementById("pagina").value}, function(){});                                                                                                        
                    }
                    
                    function limita(){
                        $("#contenedortabla").load("recursos/tablas.php", {tabla:"materiales",campo:document.getElementById("campoordena").value,orden:document.getElementById("ordenordena").value,elementos:document.getElementById("elementos").value,camfiltro:document.getElementById("camfiltro").value,filtro:document.getElementById("filtro").value,pagina:document.getElementById("pagina").value}, function(){});                        
                    }
                    
                    function filtrar(){
                        $("#contenedortabla").load("recursos/tablas.php", {tabla:"materiales",campo:document.getElementById("campoordena").value,orden:document.getElementById("ordenordena").value,elementos:document.getElementById("elementos").value,camfiltro:document.getElementById("camfiltro").value,filtro:document.getElementById("filtro").value,pagina:document.getElementById("pagina").value}, function(){});
                    }
                    
                    function pagina(pagina){
                        document.getElementById("pagina").value=pagina;
                        $("#contenedortabla").load("recursos/tablas.php", {tabla:"materiales",campo:document.getElementById("campoordena").value,orden:document.getElementById("ordenordena").value,elementos:document.getElementById("elementos").value,camfiltro:document.getElementById("camfiltro").value,filtro:document.getElementById("filtro").value,pagina:document.getElementById("pagina").value}, function(){});
                    }    
                    
                                     
                    $('#filtro').keypress(function (e) {
                        if(e.which ==13){
                           $("#contenedortabla").load("recursos/tablas.php", {tabla:"materiales",campo:document.getElementById("campoordena").value,orden:document.getElementById("ordenordena").value,elementos:document.getElementById("elementos").value,camfiltro:document.getElementById("camfiltro").value,filtro:document.getElementById("filtro").value,pagina:document.getElementById("pagina").value}, function(){});
                        }                        
                    });
                    
                </script>
	</body>
</html>
