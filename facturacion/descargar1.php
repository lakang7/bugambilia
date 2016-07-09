<?php    
    require_once("../recursos/funciones.php");
    $con=Conexion();    
    $sql_nota="select * from notadecredito where idfactura='".$_GET["idfactura"]."'";
    $result_nota=mysql_query($sql_nota,$con) or die(mysql_error());
    $nota = mysql_fetch_assoc($result_nota);     
     
    ?>
        <script language="javascript">
            window.open('descargapdf1.php?folio=<?php echo ($nota["folio"]) ?>', '_blank');
            window.open('descargaxml1.php?folio=<?php echo ($nota["folio"]) ?>', '_blank');
            window.close();
        </script>
    <?php                                                                           
