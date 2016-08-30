<?php
    require_once("../recursos/funciones.php");
    $con=Conexion();
    
    $sql_configuracion="select * from configuracionsistema where idconfiguracionsistema=1";
    $result_configuracion=mysql_query($sql_configuracion,$con) or die(mysql_error()); 
    if(mysql_num_rows($result_configuracion)>0){
       $configuracion = mysql_fetch_assoc($result_configuracion);                                
    }    
    
    $sql_factura="select * from factura where folio='".$_GET["folio"]."'";
    $result_factura=mysql_query($sql_factura,$con) or die(mysql_error());
    if(mysql_num_rows($result_factura)>0){
       $factura = mysql_fetch_assoc($result_factura);                                
    }     
        ignore_user_abort(true);
        set_time_limit(0); // disable the time limit for this script        
                
        $fullPath="C:/xampp/htdocs/bugambilia/facturacion/salidaxml/".$configuracion["carpetabusqueda"]."/".$factura["xml"];
        if ($fd = fopen ($fullPath, "r")) {
            $fsize = filesize($fullPath);
            $path_parts = pathinfo($fullPath);
            $ext = strtolower($path_parts["extension"]);
            switch ($ext) {
                case "pdf":
                header("Content-type: application/pdf");
                header("Content-Disposition: attachment; filename=\"".$path_parts["basename"]."\""); // use 'attachment' to force a file download
                break;
                // add more headers for other content types here
                default;
                header("Content-type: application/octet-stream");
                header("Content-Disposition: filename=\"".$path_parts["basename"]."\"");
                break;
            }
            header("Content-length: $fsize");
            header("Cache-control: private"); //use this to open files directly
            while(!feof($fd)) {
                $buffer = fread($fd, 2048);
                echo $buffer;
            }
        }
        fclose ($fd); 
        exit();
?>