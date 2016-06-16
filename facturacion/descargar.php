<?php    
    require_once("../recursos/funciones.php");
    $con=Conexion();    
    $sql_factura="select * from factura where idfactura='".$_GET["idfactura"]."'";
    $result_factura=mysql_query($sql_factura,$con) or die(mysql_error());
    $factura = mysql_fetch_assoc($result_factura);     
     
    ?>
        <script language="javascript">
            window.open('descargapdf.php?folio=<?php echo ($factura["folio"]) ?>', '_blank');
            window.open('descargaxml.php?folio=<?php echo ($factura["folio"]) ?>', '_blank');
            window.close();
        </script>
    <?php                                                                           
