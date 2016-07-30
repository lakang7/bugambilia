<?php

require_once('../recursos/funciones.php');
$con = Conexion();

$sqlFACTURA="select * from factura where idfactura='".$_GET["id"]."'";
$resultFACTURA=mysql_query($sqlFACTURA,$con) or die(mysql_error());
$factura = mysql_fetch_assoc($resultFACTURA);
        
$sql_CONFIGURACION="select * from configuracionsistema where idconfiguracionsistema=1";
$result_CONFIGURACION=mysql_query($sql_CONFIGURACION,$con) or die(mysql_error());
if(mysql_num_rows($result_CONFIGURACION)>0){
    $configuracion = mysql_fetch_assoc($result_CONFIGURACION);                                                                                                                                           
} 
        
$sqlAGENDA="select * from agenda where idagenda='".$factura["idagenda"]."'";
$resultAGENDA=mysql_query($sqlAGENDA,$con) or die(mysql_error());
$contacto = mysql_fetch_assoc($resultAGENDA);        
        
require_once "Mail.php";
include 'Mail/mime.php' ;

$from = '<'.$configuracion["correo"].'>';        
$to = $contacto["email"];
$subject = 'Factura '.$factura["serie"]." ".$factura["folio"];

$headers = array(
    'From' => $from,
    'To' => $to,
    'Subject' => $subject
); 
        
$mime = new Mail_mime();
$mime -> setHTMLBody("Estimado cliente, adjunto le estamos enviando su factura de Bugambilia, (Immanti SA de CV)  Serie: ".$factura["serie"]." Folio: ".$factura["folio"].".\n");        
$mime -> addAttachment("C:\\xampp\\htdocs\\bugambilia\\facturacion\\salidapdf\\GOYA780416GM0\\".$factura["pdf"],'pdf');
$mime -> addAttachment("C:\\xampp\\htdocs\\bugambilia\\facturacion\\salidaxml\\GOYA780416GM0\\".$factura["xml"],'xml');
$body = $mime->get();
$headers = $mime -> headers($headers);        
        
$smtp = Mail::factory('smtp', array(
    'host' => $configuracion["servidor"],
    'port' => $configuracion["puerto"],
    'auth' => true,
    'username' => $configuracion["correo"],
    'password' => $configuracion["seguridad"]
));

$mail = $smtp->send($to, $headers, $body);

if (PEAR::isError($mail)) {
    echo('<p>' . $mail->getMessage() . '</p>');
} else {
    ?>
    <script type="text/javascript">
        alert("Correo Electronico Enviado satisfactoriamente.");
        parent.window.close();
    </script>
    <?php
} 



?>
