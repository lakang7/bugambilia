<?php
    require_once("../recursos/funciones.php");
    $con=Conexion();
    
    $sql_nota="select * from notadecredito where folio='".$_GET["folio"]."'";
    $result_nota=mysql_query($sql_nota,$con) or die(mysql_error());
    if(mysql_num_rows($result_nota)>0){
       $nota = mysql_fetch_assoc($result_nota);                                
    }     
        ignore_user_abort(true);
        set_time_limit(0); // disable the time limit for this script        
                
        $fullPath="salidaxml/GOYA780416GM0/".$nota["xml"];
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