<?php session_start(); ?>
<meta charset="UTF-8">
<?php
require_once("funciones.php");
$con = Conexion();
$tarea = $_GET["tarea"];

if ($tarea == -1) {
    session_destroy();
    ?>
    <script type="text/javascript" language="JavaScript" >
        location.href = "../index.php";
    </script>
    <?php    
}


/* Validar Login */
if ($tarea == 0) {
    $sql_validaUsuario = "select * from usuario where usuario='" . $_POST["usuario"] . "' and contraseña='" . $_POST["password"] . "'";
    $result_validaUsuario = mysql_query($sql_validaUsuario, $con) or die(mysql_error());
    if (mysql_num_rows($result_validaUsuario) > 0) {
        $usuario = mysql_fetch_assoc($result_validaUsuario);
        $_SESSION['usuario'] = $usuario["idusuario"];
        ?>
        <script type="text/javascript" language="JavaScript" >
            location.href = "../listarempresas.php";
        </script>
        <?php
    } else {
        ?>
        <script type="text/javascript" language="JavaScript" >
            alert("Los datos que proporciono no son correctos, por favor veirifique su usuario y contraseña.");
            location.href = "../index.php";
        </script>
        <?php
    }
}

function showRegistro($sql) {
    echo $sql;
    echo "<br>";
}

/* Insertar Empresa */
if ($tarea == 1) {
    $sql_insertEmpresa = "insert into empresa (nombreempresa,nombrecomercial,telefonoprincipal,identificador,idpais,fiscalcalle,fiscalexterior,fiscalinterior,fiscalcolonia,fiscalciudad,fiscalestado,fiscalpostal,entregacalle,entregaexterior,entregainterior,entregacolonia,entregaciudad,entregaestado,entregapostal,entregareferencia,registro,iva,metododepago,banco,ultimos) values ('" . $_POST["nombre"] . "','" . $_POST["comercial"] . "','" . $_POST["telefono"] . "','" . $_POST["rfc"] . "','" . $_POST["pais"] . "','" . $_POST["fiscalavenida"] . "','" . $_POST["fiscalexterior"] . "','" . $_POST["fiscalinterior"] . "','" . $_POST["fiscalcolonia"] . "','" . $_POST["fiscalciudad"] . "','" . $_POST["fiscalestado"] . "','" . $_POST["fiscalpostal"] . "','" . $_POST["entregaavenida"] . "','" . $_POST["entregaexterior"] . "','" . $_POST["entregainterior"] . "','" . $_POST["entregacolonia"] . "','" . $_POST["entregaciudad"] . "','" . $_POST["entregaestado"] . "','" . $_POST["entregapostal"] . "','" . $_POST["entregareferencia"] . "',now(),'" . $_POST["iva"] . "', '".$_POST["metodo"]."', '".$_POST["banco"]."', '".$_POST["ultimos"]."');";
    $result_insertEmpresa = mysql_query($sql_insertEmpresa, $con) or die(mysql_error());
    if ($result_insertEmpresa) {
        $sql_ultimaEMPRESA = "SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'bugambiliasis' AND TABLE_NAME = 'empresa';";
        $result_ultimaEMPRESA = mysql_query($sql_ultimaEMPRESA, $con) or die(mysql_error());
        $fila = mysql_fetch_assoc($result_ultimaEMPRESA);
        $indice = intval($fila["AUTO_INCREMENT"]);
        $indice--;

        $sql_pais = "select * from pais where idpais='" . $_POST["pais"] . "'";
        $result_pais = mysql_query($sql_pais, $con) or die(mysql_error());
        $pais = mysql_fetch_assoc($result_pais);

        $codigo = "CL";
        if ($indice < 10) {
            $codigo = $codigo . "00" . $indice;
        } else if ($indice >= 10 && $indice < 100) {
            $codigo = $codigo . "0" . $indice;
        } else if ($indice >= 100) {
            $codigo = $codigo . $indice;
        }
        $codigo = $codigo . $pais["identificador"];

        $sql_updateCodigo = "update empresa set codigo='" . $codigo . "' where idempresa='" . $indice . "'";
        $result_updateCodigo = mysql_query($sql_updateCodigo, $con) or die(mysql_error());

        /*         * *******insercion a bitacora****** */
        /**
         * idtabla =1 -> empresa
         * idaccion =3 -> creacion
         */
        $descripcion = "'Se creo la Empresa: " . $_POST["nombre"] . ", con las siguientes caracteristicas; Identificador: " . $_POST["rfc"] . ", Nombre Comercial: " . $_POST["comercial"] . ", Telefono: " . $_POST["telefono"] . ", Pais: " . $pais["nombre"] . ", Direccion Fiscal Calle: " . $_POST["fiscalavenida"] . ", Numero Fiscal Exterior: " . $_POST["fiscalexterior"] . ", Numero Fiscal Interior: " . $_POST["fiscalinterior"] . ", Nombre Colonia: " . $_POST["fiscalcolonia"] . ", Ciudad: " . $_POST["fiscalciudad"] . ", Estado: " . $_POST["fiscalestado"] . ", Codigo Postal: " . $_POST["fiscalpostal"] . ", Calle de Entrega: " . $_POST["entregaavenida"] . ", Numero Entrega Exterior: " . $_POST["entregaexterior"] . ", Numero de Entrega Interior: " . $_POST["entregainterior"] . ", Colonia de Entrega: " . $_POST["entregacolonia"] . ", Ciudad de Entrega: " . $_POST["entregaciudad"] . ", Estado de Entrega: " . $_POST["entregaestado"] . ", Codigo Postal de Entrega: " . $_POST["entregapostal"] . ", Direccion de Referencia: " . $_POST["entregareferencia"] . ", Impuesto: " . $_POST["iva"] . "'";
        $sql_insertBitacora = "insert into bitacora(idusuario,idaccion,idtabla,momento,descripcion) values('" . $_SESSION["usuario"] . "',3,1,now()," . $descripcion . ")";
        $result_insertBitacora = mysql_query($sql_insertBitacora, $con) or die(mysql_error());
        /*         * ******fin insercion bitacora ******** */
        //echo "Registro Satisfactorio de empresa";
    }    
    ?>
        <script type="text/javascript">
            alert("Empresa Registrada Satisfactoriamente.");
            document.location="../listarempresas.php";
        </script>
    <?php    
}

/* Insertar Sucursal */
if ($tarea == 2) {

    $sql_insertSucursal = "insert into sucursal (idempresa,nombrecomercial) values(" . $_POST["matriz"] . ",'" . $_POST["nombresucursal"] . "')";
    $result_insertSucursal = mysql_query($sql_insertSucursal, $con) or die(mysql_error());
    if ($result_insertSucursal == 1) {
        $sql_ultimaSUCURSAL = "SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'bugambiliasis' AND TABLE_NAME = 'sucursal';";
        $result_ultimaSUCURSAL = mysql_query($sql_ultimaSUCURSAL, $con) or die(mysql_error());
        $fila = mysql_fetch_assoc($result_ultimaSUCURSAL);
        $indice = intval($fila["AUTO_INCREMENT"]);
        $indice--;

        $regiones = "";
        for ($i = 0; $i < count($_POST["regiones"]); $i++) {
            $sqlinsertESTADOENSUCURSAL = "insert into estadosensucursal (idsucursal,idestado) values(" . $indice . "," . $_POST["regiones"][$i] . ")";
            $result_insertESTADOENSUCURSAL = mysql_query($sqlinsertESTADOENSUCURSAL, $con) or die(mysql_error());

            $sql_consultaRegion = "select * from estado where idestado='" . $_POST["regiones"][$i] . "'";
            $result_consultaRegion = mysql_query($sql_consultaRegion, $con) or die(mysql_error());
            $region = mysql_fetch_assoc($result_consultaRegion);
            if ($i < (count($_POST["regiones"]) - 1)) {
                $regiones = $regiones . $region["nombre"] . ", ";
            } else {
                $regiones = $regiones . $region["nombre"];
            }
        }

        $sql_update = "update sucursal set regiones='" . $regiones . "' where idsucursal='" . $indice . "'";
        $result_update = mysql_query($sql_update, $con) or die(mysql_error());

        /*         * *******insercion a bitacora****** */
        /**
         * idtabla =2 -> sucursal
         * idaccion =3 -> creacion
         */
        $sql_Emp = "select emp.nombreempresa NOMEM,emp.nombrecomercial NOMCOM from empresa emp where emp.idempresa='" . $_POST["matriz"] . "'";
        $result_emp = mysql_query($sql_Emp, $con) or die(mysql_error());
        $empresa = mysql_fetch_assoc($result_emp);

        $descripcion = "'Se creo la sucursal:  " . $_POST["nombresucursal"] . ", en las siguiente regiones: " . $regiones . "; de la Empresa: " . $empresa["NOMEM"] . ", de nombre comercial: " . $empresa["NOMCOM"] . "'";
        $sql_insertBitacora = "insert into bitacora(idusuario,idaccion,idtabla,momento,descripcion) values('" . $_SESSION["usuario"] . "',3,2,now()," . $descripcion . ")";

//        showRegistro($sql_insertBitacora);
        $result_insertBitacora = mysql_query($sql_insertBitacora, $con) or die(mysql_error());
        /*         * ******fin insercion bitacora ******** */


        //echo "Registro Satisfactorio de sucursal";
    }
    ?>
        <script type="text/javascript">
            alert("Sucursal Registrada Satisfactoriamente.");
            document.location="../listarsucursales.php";
        </script>
    <?php    
}

/* Insertar Contacto */
if ($tarea == 3) {

    $sql_insertContacto = "insert into agenda (referencia,nombre,telefono1,telefono2,email) values('" . $_POST["referencia"] . "','" . $_POST["nombre"] . "','" . $_POST["telefonouno"] . "','" . $_POST["telefonodos"] . "','" . $_POST["correo"] . "')";
    $result_insertContacto = mysql_query($sql_insertContacto, $con) or die(mysql_error());

    if ($result_insertContacto == 1) {

        $sql_ultimoAGENDA = "SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'bugambiliasis' AND TABLE_NAME = 'agenda';";
        $result_ultimoAGENDA = mysql_query($sql_ultimoAGENDA, $con) or die(mysql_error());
        $fila = mysql_fetch_assoc($result_ultimoAGENDA);
        $indice = intval($fila["AUTO_INCREMENT"]);
        $indice--;

        /* Asociado a Empresa */
        if ($_POST["tipodeasociacion"] == "AE") {
            $sql_insertAsocia = "insert into asociacionagenda (tipo,idagenda,idempresa) values(1," . $indice . "," . $_POST["empresa"] . ")";
            $result_insertAsocia = mysql_query($sql_insertAsocia, $con) or die(mysql_error());
        }
        /* Asociado a Sucursal */
        if ($_POST["tipodeasociacion"] == "AS") {
            $sql_insertAsocia = "insert into asociacionagenda (tipo,idagenda,idempresa,idsucursal) values(2," . $indice . "," . $_POST["empresa"] . "," . $_POST["sucursal"] . ")";
            $result_insertAsocia = mysql_query($sql_insertAsocia, $con) or die(mysql_error());
        }
        /* Asociado a Región */
        if ($_POST["tipodeasociacion"] == "AR") {
            $sql_insertAsocia = "insert into asociacionagenda (tipo,idagenda,idempresa,idsucursal,idestado) values(3," . $indice . "," . $_POST["empresa"] . "," . $_POST["sucursal"] . "," . $_POST["region"] . ")";
            $result_insertAsocia = mysql_query($sql_insertAsocia, $con) or die(mysql_error());
        }

        /*         * *******insercion a bitacora****** */
        /**
         * idtabla =3 -> agenda
         * idaccion =3 -> creacion
         */
        $sql_Emp = "select emp.nombreempresa NOMEM,emp.nombrecomercial NOMCOM from empresa emp where emp.idempresa='" . $_POST["empresa"] . "'";
        $result_emp = mysql_query($sql_Emp, $con) or die(mysql_error());
        $empresa = mysql_fetch_assoc($result_emp);



        $descripcion = "'Se creo el contacto:  " . $_POST["nombre"] . ", de la empresa: " . $empresa["NOMEM"] . ", y de nombre comercial: " . $empresa["NOMCOM"] . ", con los telefonos: " . $_POST["telefonouno"] . " - " . $_POST["telefonodos"] . ", y con el correo: " . $_POST["correo"] . "'";
        $sql_insertBitacora = "insert into bitacora(idusuario,idaccion,idtabla,momento,descripcion) values('" . $_SESSION["usuario"] . "',3,3,now()," . $descripcion . ")";

//        showRegistro($sql_insertBitacora);
        $result_insertBitacora = mysql_query($sql_insertBitacora, $con) or die(mysql_error());
        /*         * ******fin insercion bitacora ******** */

//        showRegistro($sql_insertBitacora);
        echo "Registro de Contacto Satisfactorio";
    }
    ?>
        <script type="text/javascript">
            alert("Contacto Registrado Satisfactoriamente.");
            document.location="../listarcontactos.php";
        </script>
    <?php    
}

/* Insertar Material */
if ($tarea == 4) {

    $sql_insertMaterial = "insert into material (codigo,nombre,dias) values('" . $_POST["codigomaterial"] . "','" . $_POST["nombrematerial"] . "','" . $_POST["dias"] . "')";
    $result_insertMaterial = mysql_query($sql_insertMaterial, $con) or die(mysql_error());

    if ($result_insertMaterial == 1) {

        $sql_ultimoMATERIAL = "SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'bugambiliasis' AND TABLE_NAME = 'material';";
        $result_ultimoMATERIAL = mysql_query($sql_ultimoMATERIAL, $con) or die(mysql_error());
        $fila = mysql_fetch_assoc($result_ultimoMATERIAL);
        $indice = intval($fila["AUTO_INCREMENT"]);
        $indice--;

        $colores = "";
        for ($i = 0; $i < count($_POST["colores"]); $i++) {
            $sqlinsertCOLORENMATERIAL = "insert into colorenmaterial (idmaterial,idcolor) values(" . $indice . "," . $_POST["colores"][$i] . ")";
            $result_insertCOLORENMATERIAL = mysql_query($sqlinsertCOLORENMATERIAL, $con) or die(mysql_error());

            $sql_consultaColor = "select * from color where idcolor='" . $_POST["colores"][$i] . "'";
            $result_consultaColor = mysql_query($sql_consultaColor, $con) or die(mysql_error());
            $color = mysql_fetch_assoc($result_consultaColor);
            if ($i < (count($_POST["colores"]) - 1)) {
                $colores = $colores . $color["nombre"] . ", ";
            } else {
                $colores = $colores . $color["nombre"];
            }
        }

        $sql_update = "update material set colores='" . $colores . "' where idmaterial='" . $indice . "'";
        $result_update = mysql_query($sql_update, $con) or die(mysql_error());

        /*         * *******insercion a bitacora****** */
        /**
         * idtabla =4 -> material
         * idaccion =3 -> creacion
         */
        $descripcion = "'Se creo el material:  " . $_POST["nombrematerial"] . ", con el codigo:  " . $_POST["codigomaterial"] . ", con los siguientes colores disponibles:  " . $colores . ", y con una duracion en dias: " . $_POST["dias"] . "'";
        $sql_insertBitacora = "insert into bitacora(idusuario,idaccion,idtabla,momento,descripcion) values('" . $_SESSION["usuario"] . "',3,4,now()," . $descripcion . ")";

//        showRegistro($sql_insertBitacora);
        $result_insertBitacora = mysql_query($sql_insertBitacora, $con) or die(mysql_error());
        /*         * ******fin insercion bitacora ******** */


        //echo "Registro de Material Satisfactorio";
    }
    
    ?>
        <script type="text/javascript">
            alert("Material Registrado Satisfactoriamente.");
            document.location="../listarmateriales.php";
        </script>
    <?php     
}

/* Insertar Producto */
if ($tarea == 5) {

    $capacidad = "NULL";
    $peso = "NULL";

    if ($_POST["capacidad"] == "") {
        $capacidad = "NULL";
    } else {
        $capacidad = $_POST["capacidad"];
    }

    if ($_POST["peso"] == "") {
        $peso = "NULL";
    } else {
        $peso = $_POST["peso"];
    }
    $sql_insertProducto = "insert into producto (idtipoproducto,idpatronproducto,idmaterial,codigo,descripcion,dimensionlargo,dimensionancho,dimensionalto,peso,capacidad,preciofabrica) values(" . $_POST["temporada"] . "," . $_POST["patron"] . "," . $_POST["material"] . ",'" . $_POST["codigoproducto"] . "','" . $_POST["descripcion"] . "'," . $_POST["largo"] . "," . $_POST["ancho"] . "," . $_POST["alto"] . "," . $peso . "," . $capacidad . "," . $_POST["precio"] . ")";
    $result_insertProducto = mysql_query($sql_insertProducto, $con) or die(mysql_error());

    if ($result_insertProducto == 1) {

        $sql_ultimoPRODUCTO = "SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'bugambiliasis' AND TABLE_NAME = 'producto';";
        $result_ultimoPRODUCTO = mysql_query($sql_ultimoPRODUCTO, $con) or die(mysql_error());
        $fila = mysql_fetch_assoc($result_ultimoPRODUCTO);
        $indice = intval($fila["AUTO_INCREMENT"]);
        $indice--;

        $sql_insertHistorico = "insert into historicopreciofabrica (idproducto,preciofabrica,desde,hasta) values(" . $indice . ",'" . $_POST["precio"] . "',now(),NULL);";
        $result_insertHistorico = mysql_query($sql_insertHistorico, $con) or die(mysql_error());

        /*         * *******insercion a bitacora****** */
        /**
         * idtabla =6 -> producto
         * idaccion =3 -> creacion
         */
        $sql_tipoProducto = "select tp.codig TPCOD,tp.nombre TPNOM,tp.portipo TPPORC from tipoproducto tp where tp.idtipoproducto='" . $_POST["temporada"] . "'";
        $result_tipoprod = mysql_query($sql_tipoProducto, $con) or die(mysql_error());
        $producto = mysql_fetch_assoc($result_tipoprod);

        $sql_patronProd = "select pp.nombreespanol PPNOM,pp.materiales PPMAT from patronproducto pp where pp.idpatronproducto='" . $_POST["patron"] . "'";
        $result_patronProd = mysql_query($sql_patronProd, $con) or die(mysql_error());
        $patron = mysql_fetch_assoc($result_patronProd);

        $sql_MATERIAL = "select mat.codigo MATCOD,mat.nombre MATNOM,mat.colores MATCOL from material mat where mat.idmaterial='" . $_POST["material"] . "'";
        $result_material = mysql_query($sql_MATERIAL, $con) or die(mysql_error());
        $material = mysql_fetch_assoc($result_material);


        $descripcion = "'Se creo el producto:  " . $_POST["descripcion"] . ", con el codigo:  " . $_POST["codigoproducto"] . ", con las caracteristicas siguientes; ( Largo: " . $_POST["largo"] . ", Ancho: " . $_POST["ancho"] . ", Alto: " . $_POST["alto"] . ", Peso: " . $peso . ", Capacidad: " . $capacidad . ", Precio: " . $_POST["precio"] . "), asociado al tipo de producto:  " . $producto["TPNOM"] . ", de codigo de tipo: " . $producto["TPCOD"] . " y con  un porcentaje de tipo de producto:  " . $producto["TPPORC"] . ", asociado al patron de producto: " . $patron["PPNOM"] . ", con  el material de patron: " . $patron["PPMAT"] . ", asociado al material: " . $material["MATNOM"] . ", con el codigo de material: " . $material["MATCOD"] . ", con los colores: " . $material["MATCOL"] . "'";
        $sql_insertBitacora = "insert into bitacora(idusuario,idaccion,idtabla,momento,descripcion) values('" . $_SESSION["usuario"] . "',3,6,now()," . $descripcion . ")";

//        showRegistro($sql_insertBitacora);
        $result_insertBitacora = mysql_query($sql_insertBitacora, $con) or die(mysql_error());
        /*         * ******fin insercion bitacora ******** */

//        showRegistro($sql_insertBitacora);

       // echo "Registro de Producto Satisfactorio";
    }
    ?>
        <script type="text/javascript">
            alert("Producto Registrado Satisfactoriamente.");
            document.location="../listarproductos.php";
        </script>
    <?php    
}

/* Insertar Patron */
if ($tarea == 6) {

    $sql_insertPatron = "insert into patronproducto (idcategoriaproducto,nombreespanol,nombreingles) values(" . $_POST["tipo"] . ",'" . $_POST["espanol"] . "','" . $_POST["ingles"] . "')";
    $result_insertPatron = mysql_query($sql_insertPatron, $con) or die(mysql_error());

    if ($result_insertPatron == 1) {

        $sql_ultimoPRODUCTO = "SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'bugambiliasis' AND TABLE_NAME = 'patronproducto';";
        $result_ultimoPRODUCTO = mysql_query($sql_ultimoPRODUCTO, $con) or die(mysql_error());
        $fila = mysql_fetch_assoc($result_ultimoPRODUCTO);
        $indice = intval($fila["AUTO_INCREMENT"]);
        $indice--;

        $materiales = "";
        for ($i = 0; $i < count($_POST["lineas"]); $i++) {
            $sqlinsertPRODUCTOENLINEA = "insert into materialespatron (idpatronproducto,idmaterial) values(" . $indice . "," . $_POST["lineas"][$i] . ")";
            $result_insertPRODUCTOENLINEA = mysql_query($sqlinsertPRODUCTOENLINEA, $con) or die(mysql_error());

            $sql_consultaMaterial = "select * from material where idmaterial='" . $_POST["lineas"][$i] . "'";
            $result_consultaMaterial = mysql_query($sql_consultaMaterial, $con) or die(mysql_error());
            $material = mysql_fetch_assoc($result_consultaMaterial);
            if ($i < (count($_POST["lineas"]) - 1)) {
                $materiales = $materiales . $material["nombre"] . ", ";
            } else {
                $materiales = $materiales . $material["nombre"];
            }
        }

        $sql_update = "update patronproducto set materiales='" . $materiales . "' where idpatronproducto='" . $indice . "'";
        $result_update = mysql_query($sql_update, $con) or die(mysql_error());

        if ($_FILES['imagenpatron']['name']) {
            $target_path = "C:\\xampp\\htdocs\\bugambilia\\imagenes\\productos\\";
            $target_path = $target_path . basename($_FILES['imagenpatron']['name']);
            if (move_uploaded_file($_FILES['imagenpatron']['tmp_name'], $target_path)) {
                $sql_updatePRODUCTO = "update patronproducto set foto='" . $_FILES['imagenpatron']['name'] . "' where idpatronproducto='" . $indice . "'";
                $result_updatePRODUCTO = mysql_query($sql_updatePRODUCTO, $con) or die(mysql_error());
            }
        }
        /*         * *******insercion a bitacora****** */
        /**
         * idtabla =5 -> patron
         * idaccion =3 -> creacion
         */
        $sql_catProd = "select cp.nombreespanol NOMES from categoriaproducto cp where cp.idcategoriaproducto='" . $_POST["tipo"] . "'";
        $result_catronprod = mysql_query($sql_catProd, $con) or die(mysql_error());
        $catprod = mysql_fetch_assoc($result_catronprod);



        $descripcion = "'Se creo el patron con el nombre en Español: " . $_POST["espanol"] . ", el nomrbe en Ingles: " . $_POST["ingles"] . ", asociado a la categoria de producto: " . $catprod["NOMES"] . ", y asociado a los siguientes materiales: " . $materiales . "'";
        $sql_insertBitacora = "insert into bitacora(idusuario,idaccion,idtabla,momento,descripcion) values('" . $_SESSION["usuario"] . "',3,5,now()," . $descripcion . ")";

//        showRegistro($sql_insertBitacora);
        $result_insertBitacora = mysql_query($sql_insertBitacora, $con) or die(mysql_error());
        /*         * ******fin insercion bitacora ******** */

//        showRegistro($sql_insertBitacora);
        //echo "Registro de Patron Satisfactorio";
    }
    ?>
        <script type="text/javascript">
            alert("Patrón Registrado Satisfactoriamente.");
            document.location="../listarpatrones.php";
        </script>
    <?php     
}

/* Editar Empresa */
if ($tarea == 7) {
    /*     * *********EXTRACCION ANTES DE MODIFICAR************** */
    $sql_beforeupdate = "select nombreempresa, nombrecomercial, telefonoprincipal, identificador, idpais, fiscalcalle, fiscalexterior, fiscalinterior, fiscalcolonia, fiscalciudad, fiscalestado, fiscalpostal, entregacalle, entregaexterior, entregainterior, entregacolonia, entregaciudad, entregaestado, entregapostal, entregareferencia, codigo, registro, iva from empresa where idempresa='" . $_GET["id"] . "'";
    $result_beforeupdate = mysql_query($sql_beforeupdate, $con) or die(mysql_error());
    /*     * ************************************************** */


    $sql_updateEmpresa = "update empresa set nombreempresa='" . $_POST["nombre"] . "', nombrecomercial='" . $_POST["comercial"] . "', telefonoprincipal='" . $_POST["telefono"] . "', identificador='" . $_POST["rfc"] . "', fiscalcalle='" . $_POST["fiscalavenida"] . "',fiscalexterior='" . $_POST["fiscalexterior"] . "',fiscalinterior='" . $_POST["fiscalinterior"] . "',fiscalcolonia='" . $_POST["fiscalcolonia"] . "',fiscalciudad='" . $_POST["fiscalciudad"] . "',fiscalestado='" . $_POST["fiscalestado"] . "',fiscalpostal='" . $_POST["fiscalpostal"] . "',entregacalle='" . $_POST["entregaavenida"] . "',entregaexterior='" . $_POST["entregaexterior"] . "',entregainterior='" . $_POST["entregainterior"] . "',entregacolonia='" . $_POST["entregacolonia"] . "',entregaciudad='" . $_POST["entregaciudad"] . "',entregaestado='" . $_POST["entregaestado"] . "',entregapostal='" . $_POST["entregapostal"] . "',entregareferencia='" . $_POST["entregareferencia"] . "',iva='" . $_POST["iva"] . "', metododepago='".$_POST["metodo"]."', banco='".$_POST["banco"]."', ultimos='".$_POST["ultimos"]."' where idempresa='" . $_GET["id"] . "'";
    $result_updateEmpresa = mysql_query($sql_updateEmpresa, $con) or die(mysql_error());

    /*     * *********EXTRACCION DESPUES DE MODIFICAR************** */
    $sql_afterupdate = "select nombreempresa, nombrecomercial, telefonoprincipal, identificador, idpais, fiscalcalle, fiscalexterior, fiscalinterior, fiscalcolonia, fiscalciudad, fiscalestado, fiscalpostal, entregacalle, entregaexterior, entregainterior, entregacolonia, entregaciudad, entregaestado, entregapostal, entregareferencia, codigo, registro, iva from empresa where idempresa='" . $_GET["id"] . "'";
    $result_afterupdate = mysql_query($sql_afterupdate, $con) or die(mysql_error());
    /*     * ************************************************** */

    if ($result_updateEmpresa == 1) {
        /*         * **************SLQ BITACORA DE UPDATE DE REGISTRO ***************** */
        $oldregistro = mysql_fetch_row($result_beforeupdate);
        $news = mysql_fetch_row($result_afterupdate);

        $campos = array("nombre empresa", "nombre comercial", "telefono principal", " Nro identificador", "idpais", "Nro fiscal calle", "Nro fiscal exterior", "Nro fiscal interior", "Nro fiscal colonia", "ciudad", "estado", "codigo postal", "Nro entrega calle", "Nro entrega exterior", "Nro entrega interior", "Nro entrega colonia", "ciudad de entrega", "estado de entrega", "codigo postal de entrega", "punto de referencia", "codigo", "registro", "iva");
        $descripcion = "'Edición de la Empresa codigo (" . $_GET["id"] . ") ha  presentado cambios en los siguientes atributos: ";
        $linea = "";

        for ($index = 0; $index < count($oldregistro); $index++) {
            if (strcmp(md5($oldregistro[$index]), md5($news[$index])) != 0) {//si son diferentes en su valro calculado md5 entonces cambio 
                if ($index > 4 && $index < 9) {
                    if (strcmp(md5($news[$index]), md5("null")) == 0 || strcmp($news[$index],"")==0) {
                        $news[$index] = "calle unica";
                    }                   
                }
                $linea = $linea . " Cambio en el atributo: " . $campos[$index] . " Valor Original (" . $oldregistro[$index] . "), Valor Nuevo (" . $news[$index] . ") -";
            }
        }
        $descripcion = $descripcion . " " . $linea . "'";
        $sql_insertBitacora = "insert into bitacora(idusuario,idaccion,idtabla,momento,descripcion) values('" . $_SESSION["usuario"] . "',4,1,now()," . $descripcion . ")";
//        showRegistro($sql_insertBitacora);
        $result_insertBitacora = mysql_query($sql_insertBitacora, $con) or die(mysql_error());
        /*         * *****************FIN SQL UPDATE REGISTRO ******************* */
        //echo "Actualización Satisfactoria de Empresa";
    }
    
    ?>
        <script type="text/javascript">
            alert("Empresa Editada Satisfactoriamente.");
            document.location="../listarempresas.php";
        </script>
    <?php    
    
}

/* Editar Sucursal */
if ($tarea == 8) {
    /*     * *********EXTRACCION ANTES DE MODIFICAR************** */
    $sql_beforeupdate = "select nombrecomercial,regiones from sucursal where idsucursal='" . $_GET["id"] . "'";
    $result_beforeupdate = mysql_query($sql_beforeupdate, $con) or die(mysql_error());
   
    
    /*     * ************************************************** */

    $sql_updateSucursal = "update sucursal set nombrecomercial='" . $_POST["nombresucursal"] . "' where idsucursal='" . $_GET["id"] . "'";
    $result_updateSucursal = mysql_query($sql_updateSucursal, $con) or die(mysql_error());

    
    if ($result_updateSucursal == 1) {


        $sql_eliminarREGIONES = "delete from estadosensucursal where idsucursal='" . $_GET["id"] . "'";
        $result_eliminarREGIONES = mysql_query($sql_eliminarREGIONES, $con) or die(mysql_error());

        $regiones = "";
        for ($i = 0; $i < count($_POST["regiones"]); $i++) {
            $sqlinsertESTADOENSUCURSAL = "insert into estadosensucursal (idsucursal,idestado) values(" . $_GET["id"] . "," . $_POST["regiones"][$i] . ")";
            $result_insertESTADOENSUCURSAL = mysql_query($sqlinsertESTADOENSUCURSAL, $con) or die(mysql_error());

            $sql_consultaRegion = "select * from estado where idestado='" . $_POST["regiones"][$i] . "'";
            $result_consultaRegion = mysql_query($sql_consultaRegion, $con) or die(mysql_error());
            $region = mysql_fetch_assoc($result_consultaRegion);
            if ($i < (count($_POST["regiones"]) - 1)) {
                $regiones = $regiones . $region["nombre"] . ", ";
            } else {
                $regiones = $regiones . $region["nombre"];
            }
        }

        $sql_update = "update sucursal set regiones='" . $regiones . "' where idsucursal='" . $_GET["id"] . "'";
        $result_update = mysql_query($sql_update, $con) or die(mysql_error());

        /*         * *********EXTRACCION DESPUES DE MODIFICAR************** */
        $sql_afterupdate = "select nombrecomercial,regiones from sucursal where idsucursal='" . $_GET["id"] . "'";
        $result_afterupdate = mysql_query($sql_afterupdate, $con) or die(mysql_error());
        /*         * ************************************************** */

        $oldregistro = mysql_fetch_row($result_beforeupdate);
        $news = mysql_fetch_row($result_afterupdate);
        
        $vecOldRegiones=array();
        

        $campos = array("nombrecomercial", "regiones");
        $descripcion = "'Registro de sucursal de Empresa codigo (" . $_GET["id"] . ") ha sido modificado con los siguientes valores ";
        $linea = "";
        for ($index = 0; $index < count($oldregistro); $index++) {
            if (strcmp(md5($oldregistro[$index]), md5($news[$index])) != 0) {//si son diferentes en su valro calculado md5 entonces cambio 
                $linea = $linea . $campos[$index] . " Valor Original (" . $oldregistro[$index] . "), Valor Nuevo (" . $news[$index] . ") -";
            }
        }
        $descripcion = $descripcion . " " . $linea . "'";
        $sql_insertBitacora = "insert into bitacora(idusuario,idaccion,idtabla,momento,descripcion) values('" . $_SESSION["usuario"] . "',4,2,now()," . $descripcion . ")";
//        showRegistro($sql_insertBitacora);
        $result_insertBitacora = mysql_query($sql_insertBitacora, $con) or die(mysql_error());
        /*         * *****************FIN SQL UPDATE REGISTRO ******************* */

        //echo "Actualización Satisfactoria de Sucursal";
    }
    ?>
        <script type="text/javascript">
            alert("Sucursal Editada Satisfactoriamente.");
            document.location="../listarsucursales.php";
        </script>
    <?php    
}

/* Editar Contacto */
if ($tarea == 9) {
    //echo "Editar Contacto";

    /*     * *********EXTRACCION ANTES DE MODIFICAR************** */
    $sql_beforeupdate = "select referencia, nombre, telefono1, telefono2, email from agenda where idagenda='" . $_GET["id"] . "' ";
    $result_beforeupdate = mysql_query($sql_beforeupdate, $con) or die(mysql_error());
    /*     * ************************************************** */

    $sql_updateContacto = "update agenda set referencia='" . $_POST["referencia"] . "',nombre='" . $_POST["nombre"] . "',telefono1='" . $_POST["telefonouno"] . "',telefono2='" . $_POST["telefonodos"] . "',email='" . $_POST["correo"] . "' where idagenda='" . $_GET["id"] . "' ";
    $result_updateContacto = mysql_query($sql_updateContacto, $con) or die(mysql_error());

    $sql_eliminarASOCIACION = "delete from asociacionagenda where idagenda='" . $_GET["id"] . "'";
    $result_eliminarASOCIACION = mysql_query($sql_eliminarASOCIACION, $con) or die(mysql_error());

    /*     * *********EXTRACCION DESPUES DE MODIFICAR************** */
    $sql_afterupdate = "select referencia, nombre, telefono1, telefono2, email from agenda where idagenda='" . $_GET["id"] . "' ";
    $result_afterupdate = mysql_query($sql_afterupdate, $con) or die(mysql_error());
    /*     * ************************************************** */
    $oldregistro = mysql_fetch_row($result_beforeupdate);
    $news = mysql_fetch_row($result_afterupdate);

    $campos = array("referencia", " nombre", " telefono1", " telefono2", " email");
    $descripcion = "'Registro de Contacto  de Empresa codigo (" . $_GET["id"] . ") ha sido modificado con los siguientes valores ";
    $linea = "";

    for ($index = 0; $index < count($oldregistro); $index++) {
        if (strcmp(md5($oldregistro[$index]), md5($news[$index])) != 0) {//si son diferentes en su valro calculado md5 entonces cambio 
            $linea = $linea . $campos[$index] . " Valor Original (" . $oldregistro[$index] . "), Valor Nuevo (" . $news[$index] . ") -";
        }
    }
    $descripcion = $descripcion . " " . $linea . "'";
    $sql_insertBitacora = "insert into bitacora(idusuario,idaccion,idtabla,momento,descripcion) values('" . $_SESSION["usuario"] . "',4,3,now()," . $descripcion . ")";
//        showRegistro($sql_insertBitacora);
    $result_insertBitacora = mysql_query($sql_insertBitacora, $con) or die(mysql_error());
    /*     * *****************FIN SQL UPDATE REGISTRO ******************* */


    /* Asociado a Empresa */
    if ($_POST["tipodeasociacion"] == "AE") {
        $sql_insertAsocia = "insert into asociacionagenda (tipo,idagenda,idempresa) values(1," . $_GET["id"] . "," . $_POST["empresa"] . ")";
        $result_insertAsocia = mysql_query($sql_insertAsocia, $con) or die(mysql_error());
    }
    /* Asociado a Sucursal */
    if ($_POST["tipodeasociacion"] == "AS") {
        $sql_insertAsocia = "insert into asociacionagenda (tipo,idagenda,idempresa,idsucursal) values(2," . $_GET["id"] . "," . $_POST["empresa"] . "," . $_POST["sucursal"] . ")";
        $result_insertAsocia = mysql_query($sql_insertAsocia, $con) or die(mysql_error());
    }
    /* Asociado a Región */
    if ($_POST["tipodeasociacion"] == "AR") {
        $sql_insertAsocia = "insert into asociacionagenda (tipo,idagenda,idempresa,idsucursal,idestado) values(3," . $_GET["id"] . "," . $_POST["empresa"] . "," . $_POST["sucursal"] . "," . $_POST["region"] . ")";
        $result_insertAsocia = mysql_query($sql_insertAsocia, $con) or die(mysql_error());
    }
    //echo "Actualización Satisfactoria de Contacto";
    
    ?>
        <script type="text/javascript">
            alert("Contacto Editado Satisfactoriamente.");
            document.location="../listarcontactos.php";
        </script>
    <?php     
}

/* Editar Material */
if ($tarea == 10) {

    /*     * *********EXTRACCION ANTES DE MODIFICAR************** */
    $sql_beforeupdate = "select codigo, nombre, colores, registro, dias from material where idmaterial='" . $_GET["id"] . "'";
    $result_beforeupdate = mysql_query($sql_beforeupdate, $con) or die(mysql_error());
    /*     * ************************************************** */


    $sql_updateMaterial = "update material set codigo='" . $_POST["codigomaterial"] . "',nombre='" . $_POST["nombrematerial"] . "',dias='" . $_POST["dias"] . "' where idmaterial='" . $_GET["id"] . "'";
    $result_updateMaterial = mysql_query($sql_updateMaterial, $con) or die(mysql_error());

    $sql_eliminaColores = "delete from colorenmaterial where idmaterial='" . $_GET["id"] . "'";
    $result_eliminaColores = mysql_query($sql_eliminaColores, $con) or die(mysql_error());

    $colores = "";
    for ($i = 0; $i < count($_POST["colores"]); $i++) {
        $sqlinsertCOLORENMATERIAL = "insert into colorenmaterial (idmaterial,idcolor) values(" . $_GET["id"] . "," . $_POST["colores"][$i] . ")";
        $result_insertCOLORENMATERIAL = mysql_query($sqlinsertCOLORENMATERIAL, $con) or die(mysql_error());

        $sql_consultaColor = "select * from color where idcolor='" . $_POST["colores"][$i] . "'";
        $result_consultaColor = mysql_query($sql_consultaColor, $con) or die(mysql_error());
        $color = mysql_fetch_assoc($result_consultaColor);
        if ($i < (count($_POST["colores"]) - 1)) {
            $colores = $colores . $color["nombre"] . ", ";
        } else {
            $colores = $colores . $color["nombre"];
        }
    }

    $sql_update = "update material set colores='" . $colores . "' where idmaterial='" . $_GET["id"] . "'";
    $result_update = mysql_query($sql_update, $con) or die(mysql_error());


    /*     * *******NO SE PARA QUE***** */
    $sql_selmaterial = "select * from material where idmaterial='" . $_GET["id"] . "'";
    $result_selmaterial = mysql_query($sql_selmaterial, $con) or die(mysql_error());

    if (mysql_num_rows($result_selmaterial) > 0) {
        $material = mysql_fetch_assoc($result_selmaterial);
    }

    /*     * *****FIN DEL NO SABER********* */


    /*     * *********EXTRACCION DESPUES DE MODIFICAR************** */
    $sql_afterupdate = "select codigo, nombre, colores, registro, dias from material where idmaterial='" . $_GET["id"] . "'";
    $result_afterupdate = mysql_query($sql_afterupdate, $con) or die(mysql_error());
    /*     * ************************************************** */
    $oldregistro = mysql_fetch_row($result_beforeupdate);
    $news = mysql_fetch_row($result_afterupdate);

    $campos = array("codigo", " nombre", " colores", " registro", " dias");
    $descripcion = "'Registro de Material con el codigo (" . $_GET["id"] . ") ha sido modificado con los siguientes valores ";
    $linea = "";

    for ($index = 0; $index < count($oldregistro); $index++) {
        if (strcmp(md5($oldregistro[$index]), md5($news[$index])) != 0) {//si son diferentes en su valro calculado md5 entonces cambio 
            $linea = $linea . $campos[$index] . " Valor Original (" . $oldregistro[$index] . "), Valor Nuevo (" . $news[$index] . ") -";
        }
    }
    $descripcion = $descripcion . " " . $linea . "'";
    $sql_insertBitacora = "insert into bitacora(idusuario,idaccion,idtabla,momento,descripcion) values('" . $_SESSION["usuario"] . "',4,4,now()," . $descripcion . ")";
//        showRegistro($sql_insertBitacora);
    $result_insertBitacora = mysql_query($sql_insertBitacora, $con) or die(mysql_error());
    /*     * *****************FIN SQL UPDATE REGISTRO ******************* */



    //echo "Actualización Satisfactoria de Material";
    ?>
        <script type="text/javascript">
            alert("Material Editado Satisfactoriamente.");
            document.location="../listarmateriales.php";
        </script>
    <?php    
}

/* Editar Patrón */
if ($tarea == 11) {

    /*     * *********EXTRACCION ANTES DE MODIFICAR************** */
    $sql_beforeupdate = "select idcategoriaproducto,nombreespanol, nombreingles,  materiales from patronproducto where idpatronproducto='" . $_GET["id"] . "'";
    $result_beforeupdate = mysql_query($sql_beforeupdate, $con) or die(mysql_error());
    /*     * ************************************************** */

    $sql_updatePatron = "update patronproducto set idcategoriaproducto='" . $_POST["tipo"] . "',nombreespanol='" . $_POST["espanol"] . "',nombreingles='" . $_POST["ingles"] . "' where idpatronproducto='" . $_GET["id"] . "'";
    $result_updatePatron = mysql_query($sql_updatePatron, $con) or die(mysql_error());

    $sql_eliminaMATPatron = "delete from materialespatron where idpatronproducto='" . $_GET["id"] . "'";
    $result_eliminaMATPatron = mysql_query($sql_eliminaMATPatron, $con) or die(mysql_error());

    $materiales = "";
    for ($i = 0; $i < count($_POST["lineas"]); $i++) {
        $sqlinsertPRODUCTOENLINEA = "insert into materialespatron (idpatronproducto,idmaterial) values(" . $_GET["id"] . "," . $_POST["lineas"][$i] . ")";
        $result_insertPRODUCTOENLINEA = mysql_query($sqlinsertPRODUCTOENLINEA, $con) or die(mysql_error());

        $sql_consultaMaterial = "select * from material where idmaterial='" . $_POST["lineas"][$i] . "'";
        $result_consultaMaterial = mysql_query($sql_consultaMaterial, $con) or die(mysql_error());
        $material = mysql_fetch_assoc($result_consultaMaterial);
        if ($i < (count($_POST["lineas"]) - 1)) {
            $materiales = $materiales . $material["nombre"] . ", ";
        } else {
            $materiales = $materiales . $material["nombre"];
        }
    }

    $sql_update = "update patronproducto set materiales='" . $materiales . "' where idpatronproducto='" . $_GET["id"] . "'";
    $result_update = mysql_query($sql_update, $con) or die(mysql_error());


    /*     * *********EXTRACCION DESPUES DE MODIFICAR************** */
    $sql_afterupdate = "select idcategoriaproducto,nombreespanol, nombreingles,  materiales from patronproducto where idpatronproducto='" . $_GET["id"] . "'";
    $result_afterupdate = mysql_query($sql_afterupdate, $con) or die(mysql_error());
    /*     * ************************************************** */
    $oldregistro = mysql_fetch_row($result_beforeupdate);
    $news = mysql_fetch_row($result_afterupdate);

    $campos = array("idcategoriaproducto", " nombreespanol", " nombreingles", " materiales");
    $descripcion = "'Registro de Material con el codigo (" . $_GET["id"] . ") ha sido modificado con los siguientes valores ";
    $linea = "";
    for ($index = 0; $index < count($oldregistro); $index++) {
        if (strcmp(md5($oldregistro[$index]), md5($news[$index])) != 0) {//si son diferentes en su valro calculado md5 entonces cambio 
            $linea = $linea . $campos[$index] . " Valor Original (" . $oldregistro[$index] . "), Valor Nuevo (" . $news[$index] . ") -";
        }
    }
    $descripcion = $descripcion . " " . $linea . "'";
    $sql_insertBitacora = "insert into bitacora(idusuario,idaccion,idtabla,momento,descripcion) values('" . $_SESSION["usuario"] . "',4,5,now()," . $descripcion . ")";
//        showRegistro($sql_insertBitacora);
    $result_insertBitacora = mysql_query($sql_insertBitacora, $con) or die(mysql_error());
    /*     * *****************FIN SQL UPDATE REGISTRO ******************* */

    //echo "Actualización Satisfactoria de Patrón";
    ?>
        <script type="text/javascript">
            alert("Patrón Editado Satisfactoriamente.");
            document.location="../listarpatrones.php";
        </script>
    <?php    
}

/* Editar producto */
if ($tarea == 12) {
    $capacidad = "NULL";
    $peso = "NULL";

    if ($_POST["capacidad"] == "") {
        $capacidad = "NULL";
    } else {
        $capacidad = $_POST["capacidad"];
    }

    if ($_POST["peso"] == "") {
        $peso = "NULL";
    } else {
        $peso = $_POST["peso"];
    }
    /*     * *********EXTRACCION ANTES DE MODIFICAR************** */
    $sql_beforeupdate = "select idtipoproducto, idpatronproducto, idmaterial, codigo, descripcion, dimensionlargo, dimensionancho, dimensionalto, peso, capacidad, preciofabrica from producto where idproducto='" . $_GET["id"] . "'";
    $result_beforeupdate = mysql_query($sql_beforeupdate, $con) or die(mysql_error());
    /*     * ************************************************** */


    $sql_updateProducto = "update producto set idtipoproducto='" . $_POST["temporada"] . "', idpatronproducto='" . $_POST["patron"] . "', idmaterial='" . $_POST["material"] . "', codigo='" . $_POST["codigoproducto"] . "',descripcion='" . $_POST["descripcion"] . "',dimensionlargo='" . $_POST["largo"] . "',dimensionancho='" . $_POST["ancho"] . "',dimensionalto='" . $_POST["alto"] . "',peso='" . $peso . "',capacidad='" . $capacidad . "' where idproducto='" . $_GET["id"] . "'";
    $result_updateProducto = mysql_query($sql_updateProducto, $con) or die(mysql_error());

    $sql_producto = "select * from producto where idproducto='" . $_GET["id"] . "'";
    $result_producto = mysql_query($sql_producto, $con) or die(mysql_error());

    if (mysql_num_rows($result_producto) > 0) {
        $producto = mysql_fetch_assoc($result_producto);
    }

    if ($producto["preciofabrica"] != $_POST["precio"]) {
        $sql_buscaprefa = "select * from historicopreciofabrica where idproducto='" . $_GET["id"] . "' and hasta is null";
        $result_buscaprefa = mysql_query($sql_buscaprefa, $con) or die(mysql_error());
        if (mysql_num_rows($result_buscaprefa) > 0) {
            $historico = mysql_fetch_assoc($result_buscaprefa);
            $sql_cierraprefa = "update historicopreciofabrica set hasta = now(), desde='" . $historico["desde"] . "' where idhistoricopreciofabrica='" . $historico["idhistoricopreciofabrica"] . "'";
            $result_cierraprefa = mysql_query($sql_cierraprefa, $con) or die(mysql_error());
            $sql_insertprefa = "insert into historicopreciofabrica (idproducto,preciofabrica,desde) values ('" . $_GET["id"] . "','" . $_POST["precio"] . "',now())";
            $result_insertprefa = mysql_query($sql_insertprefa, $con) or die(mysql_error());
            $sql_updateProducto = "update producto set preciofabrica='" . $_POST["precio"] . "' where idproducto='" . $_GET["id"] . "'";
            $result_updateProducto = mysql_query($sql_updateProducto, $con) or die(mysql_error());
        }
    }

    /*     * *********EXTRACCION DESPUES DE MODIFICAR************** */
    $sql_afterupdate = "select idtipoproducto, idpatronproducto, idmaterial, codigo, descripcion, dimensionlargo, dimensionancho, dimensionalto, peso, capacidad, preciofabrica from producto where idproducto='" . $_GET["id"] . "'";
    $result_afterupdate = mysql_query($sql_afterupdate, $con) or die(mysql_error());
    /*     * ************************************************** */
    $oldregistro = mysql_fetch_row($result_beforeupdate);
    $news = mysql_fetch_row($result_afterupdate);

    $campos = array("idtipoproducto", " idpatronproducto", " idmaterial", " codigo", " descripcion", " dimensionlargo", " dimensionancho", " dimensionalto", " peso", " capacidad", " preciofabrica");
    $descripcion = "'Registro de Producto con el codigo (" . $_GET["id"] . ") ha sido modificado con los siguientes valores ";
    $linea = "";
    for ($index = 0; $index < count($oldregistro); $index++) {
        if (strcmp(md5($oldregistro[$index]), md5($news[$index])) != 0) {//si son diferentes en su valro calculado md5 entonces cambio 
            $linea = $linea . $campos[$index] . " Valor Original (" . $oldregistro[$index] . "), Valor Nuevo (" . $news[$index] . ") -";
        }
    }
    $descripcion = $descripcion . " " . $linea . "'";
    $sql_insertBitacora = "insert into bitacora(idusuario,idaccion,idtabla,momento,descripcion) values('" . $_SESSION["usuario"] . "',4,6,now()," . $descripcion . ")";
//        showRegistro($sql_insertBitacora);
    $result_insertBitacora = mysql_query($sql_insertBitacora, $con) or die(mysql_error());
    /*     * *****************FIN SQL UPDATE REGISTRO ******************* */


    //echo "Producto Editado Satisfactoriamente";
    ?>
        <script type="text/javascript">
            alert("Producto Editado Satisfactoriamente.");
            document.location="../listarproductos.php";
        </script>
    <?php    
}

/* insertar lista de precios */
if ($tarea == 13) {
    $sql_insertLista = "insert into listadeprecios (idempresa,nombre) values('" . $_POST["empresa"] . "','" . $_POST["nombre"] . "')";
    $result_insertLista = mysql_query($sql_insertLista, $con) or die(mysql_error());

    if ($result_insertLista == 1) {
        $sql_ultimaLISTA = "SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'bugambiliasis' AND TABLE_NAME = 'listadeprecios';";
        $result_ultimaLISTA = mysql_query($sql_ultimaLISTA, $con) or die(mysql_error());
        $fila = mysql_fetch_assoc($result_ultimaLISTA);
        $indice = intval($fila["AUTO_INCREMENT"]);
        $indice--;

        $sql_tipos = "select * from tipoproducto";
        $result_tipos = mysql_query($sql_tipos, $con) or die(mysql_error());
        if (mysql_num_rows($result_tipos) > 0) {
            while ($tipo = mysql_fetch_assoc($result_tipos)) {
                $sql_insertGANANCIA = "insert into listatipos (idlistadeprecios,idtipoproducto,porcentajeganancia) values(" . $indice . "," . $tipo["idtipoproducto"] . "," . $_POST["ganancia" . $tipo["idtipoproducto"]] . ")";
                $result_insertGANANCIA = mysql_query($sql_insertGANANCIA, $con) or die(mysql_error());

                $sql_ultimaASOCIACION = "SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'bugambiliasis' AND TABLE_NAME = 'listatipos';";
                $result_ultimaASOCIACION = mysql_query($sql_ultimaASOCIACION, $con) or die(mysql_error());
                $fila2 = mysql_fetch_assoc($result_ultimaASOCIACION);
                $indice2 = intval($fila2["AUTO_INCREMENT"]);
                $indice2--;

                $sql_insertHistorico = "insert into historicoporcentajeganancia (idlistatipos,porcentajeganancia,desde,hasta) values(" . $indice2 . ",'" . $_POST["ganancia" . $tipo["idtipoproducto"]] . "',now(),NULL);";
                $result_insertHistorico = mysql_query($sql_insertHistorico, $con) or die(mysql_error());
            }
        }
        //echo "Registro Satisfactorio de la lista de precios";
    ?>
        <script type="text/javascript">
            alert("Lista de Precios Registrada Satisfactoriamente.");
            document.location="../listarlistadeprecios.php";
        </script>
    <?php          
    }
}

/* editar lista de precios */
if ($tarea == 14) {
    /*     * *********EXTRACCION ANTES DE MODIFICAR************** */
    $sql_beforeupdate = "select idempresa, nombre from listadeprecios where idlistadeprecios='" . $_GET["id"] . "'";
    $result_beforeupdate = mysql_query($sql_beforeupdate, $con) or die(mysql_error());

    $sql_beforesubtipo = "select lt.porcentajeganancia from listadeprecios lp join listatipos lt on lp.idlistadeprecios=lt.idlistadeprecios join tipoproducto tp on tp.idtipoproducto=lt.idtipoproducto where lp.idlistadeprecios='" . $_GET["id"] . "'";
    $result_beforesubtipo = mysql_query($sql_beforesubtipo, $con) or die(mysql_error());
    /*     * ************************************************** */


    $sql_updateListadePrecios = "update listadeprecios set nombre='" . $_POST["nombre"] . "',idempresa='" . $_POST["empresa"] . "' where idlistadeprecios='" . $_GET["id"] . "'";
    $result_updateListadePrecios = mysql_query($sql_updateListadePrecios, $con) or die(mysql_error());

    $sql_tipos = "select * from tipoproducto";
    $result_tipos = mysql_query($sql_tipos, $con) or die(mysql_error());
    if (mysql_num_rows($result_tipos) > 0) {
        while ($tipo = mysql_fetch_assoc($result_tipos)) {
            $sql_actual = "select * from listatipos where idtipoproducto='" . $tipo["idtipoproducto"] . "' and idlistadeprecios='" . $_GET["id"] . "'";
            $result_actual = mysql_query($sql_actual, $con) or die(mysql_error());
            if (mysql_num_rows($result_actual) > 0) {
                while ($actual = mysql_fetch_assoc($result_actual)) {
                    if ($_POST["ganancia" . $tipo["idtipoproducto"]] != $actual["porcentajeganancia"]) {
                        $sql_update = "update listatipos set porcentajeganancia='" . $_POST["ganancia" . $tipo["idtipoproducto"]] . "' where idlistatipos='" . $actual["idlistatipos"] . "'";
                        $result_update = mysql_query($sql_update, $con) or die(mysql_error());
                        $sql_update2 = "update historicoporcentajeganancia set hasta = now() where idlistatipos='" . $actual["idlistatipos"] . "' and  hasta is null";
                        $result_update2 = mysql_query($sql_update2, $con) or die(mysql_error());
                        $sql_insertNuevo = "insert into historicoporcentajeganancia (idlistatipos,porcentajeganancia,desde) values('" . $actual["idlistatipos"] . "','" . $_POST["ganancia" . $tipo["idtipoproducto"]] . "',now())";
                        $result_insertNuevo = mysql_query($sql_insertNuevo, $con) or die(mysql_error());
                    }
                }
            }
        }

        /*         * *********EXTRACCION DESPUES DE MODIFICAR************** */
        $sql_afterupdate = "select idempresa, nombre from listadeprecios where idlistadeprecios='" . $_GET["id"] . "'";
        $result_afterupdate = mysql_query($sql_afterupdate, $con) or die(mysql_error());


        $sql_aftersubtipo = "select lt.porcentajeganancia PORCENTAJE from listadeprecios lp join listatipos lt on lp.idlistadeprecios=lt.idlistadeprecios join tipoproducto tp on tp.idtipoproducto=lt.idtipoproducto where lp.idlistadeprecios='" . $_GET["id"] . "'";
        $result_aftersubtipo = mysql_query($sql_aftersubtipo, $con) or die(mysql_error());

//
        /*         * ************************************************** */
        $oldregistro = mysql_fetch_row($result_beforeupdate);
        $news = mysql_fetch_row($result_afterupdate);

        $oldsubtipo = mysql_fetch_row($result_beforesubtipo);
        $newsubtipo = mysql_fetch_row($result_aftersubtipo);


        $campos = array("idempresa", "nombre");
        $descripcion = "'Registro de Producto con el codigo (" . $_GET["id"] . ") ha sido modificado con los siguientes valores ";
        $linea = "";
        for ($index = 0; $index < count($oldregistro); $index++) {
            if (strcmp(md5($oldregistro[$index]), md5($news[$index])) != 0) {//si son diferentes en su valro calculado md5 entonces cambio 
                $linea = $linea . $campos[$index] . " Valor Original (" . $oldregistro[$index] . "), Valor Nuevo (" . $news[$index] . ") -";
            }
        }


        for ($index1 = 0; $index1 < count($oldsubtipo); $index1++) {

//            echo $oldsubtipo[$index1]." - ".$newsubtipo[$index1];
            if (strcmp(md5($oldsubtipo[$index1]), md5($newsubtipo[$index1])) != 0) {//si son diferentes en su valro calculado md5 entonces cambio 
                $linea = $linea . " Porcentaje " . " Valor Original (" . $oldsubtipo[$index1] . "), Valor Nuevo (" . $newsubtipo[$index1] . ") -";
//                echo $linea;
            }
        }

        $descripcion = $descripcion . " " . $linea . "'";
        $sql_insertBitacora = "insert into bitacora(idusuario,idaccion,idtabla,momento,descripcion) values('" . $_SESSION["usuario"] . "',4,6,now()," . $descripcion . ")";
        showRegistro($sql_insertBitacora);
        $result_insertBitacora = mysql_query($sql_insertBitacora, $con) or die(mysql_error());
        /*         * *****************FIN SQL UPDATE REGISTRO ******************* */
    }
    mysql_close($con);
    ?>
        <script type="text/javascript">
            alert("Lista de Precios Editada Satisfactoriamente.");
            document.location="../listarlistadeprecios.php";
        </script>
    <?php     
}

/* insertar excepcion de la regla */
if ($tarea == 15) {
    $sql_insertExcepcion = "insert into excepcionlista (idlistadeprecios,idproducto,preciofinal,registro,estatus) values('" . $_GET["id"] . "','" . $_POST["producto"] . "','" . $_POST["precio"] . "',now(),0)";
    $result_insertExcepcion = mysql_query($sql_insertExcepcion, $con) or die(mysql_error());
    $sql_ultimaExcepcion = "SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'bugambiliasis' AND TABLE_NAME = 'excepcionlista';";
    $result_ultimaExcepcion = mysql_query($sql_ultimaExcepcion, $con) or die(mysql_error());
    $fila = mysql_fetch_assoc($result_ultimaExcepcion);
    $indice = intval($fila["AUTO_INCREMENT"]);
    $indice--;
    $sql_insertHistorico = "insert into historicoexcepcionlista (idexcepcionlista,preciofinal,desde,hasta) values(" . $indice . ",'" . $_POST["precio"] . "',now(),NULL);";
    $result_insertHistorico = mysql_query($sql_insertHistorico, $con) or die(mysql_error());
    ?>
        <script type="text/javascript">
            alert("Excepción en la Lista de Precios Registrada Satisfactoriamente.");
            document.location="../excepcioneslistadeprecios.php?id=<?php echo $_GET["id"]; ?>";
        </script>
    <?php     
}

/* insertar orden de compra dolor de cabeza */
if ($tarea == 16) {
    $sql_insertOrden = "";
           
    if(isset($_POST["sucursal"]) && $_POST["sucursal"]!=NULL && $_POST["sucursal"]!=""){
        if(isset($_POST["region"]) && $_POST["region"]!=NULL && $_POST["region"]!=""){
            $sql_insertOrden = "insert into ordendecompra (codigoexterno,tipo,fechadecreacion,fechaderegistro,idempresa,idsucursal,idestado,idagenda01,idagenda02,idagenda03,idlistadeprecios,idusuario,codigoop,subtotal,poriva,iva,total,prioridad,fechadeentrega,condiciones,paqueteria,observaciones,estatus,conpago) values('" . $_POST["codigoext"] . "','" . $_POST["tipoorden"] . "',now(),'" . $_POST["id-date-picker-1"] . "','" . $_POST["empresa"] . "','" . $_POST["sucursal"] . "','" . $_POST["region"] . "','" . $_POST["contacto01"] . "','" . $_POST["contacto02"] . "','" . $_POST["contacto03"] . "','" . $_POST["lista"] . "',1,'" . $_POST["codigo02"] . "',0,0,0,0,'" . $_POST["prioridad"] . "',now(),'".$_POST["condiciones"]."','".$_POST["paqueteria"]."','".$_POST["observaciones"]."','1','".$_POST["tipoordenc"]."')";
        }else {
            $sql_insertOrden = "insert into ordendecompra (codigoexterno,tipo,fechadecreacion,fechaderegistro,idempresa,idsucursal,idagenda01,idagenda02,idagenda03,idlistadeprecios,idusuario,codigoop,subtotal,poriva,iva,total,prioridad,fechadeentrega,condiciones,paqueteria,observaciones,estatus,conpago) values('" . $_POST["codigoext"] . "','" . $_POST["tipoorden"] . "',now(),'" . $_POST["id-date-picker-1"] . "','" . $_POST["empresa"] . "','" . $_POST["sucursal"] . "','" . $_POST["contacto01"] . "','" . $_POST["contacto02"] . "','" . $_POST["contacto03"] . "','" . $_POST["lista"] . "',1,'" . $_POST["codigo02"] . "',0,0,0,0,'" . $_POST["prioridad"] . "',now(),'".$_POST["condiciones"]."','".$_POST["paqueteria"]."','".$_POST["observaciones"]."','1','".$_POST["tipoordenc"]."')";
        }
    }else{
        $sql_insertOrden = "insert into ordendecompra (codigoexterno,tipo,fechadecreacion,fechaderegistro,idempresa,idagenda01,idagenda02,idagenda03,idlistadeprecios,idusuario,codigoop,subtotal,poriva,iva,total,prioridad,fechadeentrega,condiciones,paqueteria,observaciones,estatus,conpago) values('" . $_POST["codigoext"] . "','" . $_POST["tipoorden"] . "',now(),'" . $_POST["id-date-picker-1"] . "','" . $_POST["empresa"] . "','" . $_POST["contacto01"] . "','" . $_POST["contacto02"] . "','" . $_POST["contacto03"] . "','" . $_POST["lista"] . "',1,'" . $_POST["codigo02"] . "',0,0,0,0,'" . $_POST["prioridad"] . "',now(),'".$_POST["condiciones"]."','".$_POST["paqueteria"]."','".$_POST["observaciones"]."','1','".$_POST["tipoordenc"]."')";
    }

    //echo $sql_insertOrden."</br>";
    $result_insertOrden = mysql_query($sql_insertOrden, $con) or die(mysql_error());

    $aux = explode("-", $_POST["codigo02"]);
    $nuevoCodigo = ($aux[1] + 1);

    $sqlupdateConfiguracion = "update configuracionsistema set secuenciaop='" . $nuevoCodigo . "' where idconfiguracionsistema=1";
    $resultupdateConfiguracion = mysql_query($sqlupdateConfiguracion, $con) or die(mysql_error());

    $sql_ultimaOrden = "SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'bugambiliasis' AND TABLE_NAME = 'ordendecompra';";
    $result_ultimaOrden = mysql_query($sql_ultimaOrden, $con) or die(mysql_error());
    $fila = mysql_fetch_assoc($result_ultimaOrden);
    $indice = intval($fila["AUTO_INCREMENT"]);
    $indice--;

    $productos = $_POST["oculto01"];
    $listaIds = explode("_", $_POST["oculto02"]);
    $listaCodigos = explode("_", $_POST["oculto03"]);
    $listaDescripciones = explode("_", $_POST["oculto04"]);
    $listaColores = explode("_", $_POST["oculto05"]);
    $listaPrecios = explode("_", $_POST["oculto06"]);
    $listaUnidades = explode("_", $_POST["oculto07"]);

    $subTotal = 0;
    $poriva = 0;
    $total = 0;
    $iva = 0;

    $materiales = array();

    for ($i = 0; $i < count($listaIds); $i++) {
        if ($listaIds[$i] != "") {
            $sql_precio = "select preciofabrica,idmaterial from producto where idproducto='" . $listaIds[$i] . "'";
            $result_precio = mysql_query($sql_precio, $con) or die(mysql_error());
            if (mysql_num_rows($result_precio) > 0) {
                $precio = mysql_fetch_assoc($result_precio);
                $banderina = 0;
                for ($j = 0; $j < count($materiales); $j++) {
                    if ($materiales[$j] == $precio["idmaterial"]) {
                        $banderina = 1;
                    }
                }
                if ($banderina == 0) {
                    $materiales[count($materiales)] = $precio["idmaterial"];
                }
                $sql_color = "select * from color where nombre='" . $listaColores[$i] . "'";
                $result_color = mysql_query($sql_color, $con) or die(mysql_error());
                $color = mysql_fetch_assoc($result_color);
                $subTotal+=($listaUnidades[$i] * $listaPrecios[$i]);
                $sql_insProducto = "insert into productosordencompra (idordendecompra,idproducto,idcolor,preciofabrica,precioventa,numerodeunidades) values('" . $indice . "','" . $listaIds[$i] . "','" . $color["idcolor"] . "','" . $precio["preciofabrica"] . "','" . $listaPrecios[$i] . "','" . $listaUnidades[$i] . "')";
                $result_insProducto = mysql_query($sql_insProducto, $con) or die(mysql_error());
            }
        }
    }

    if ($_POST["appiva"] == "S") {
        $poriva = $_POST["poriva"];
        $iva = $subTotal * ($poriva / 100);
        $total = $subTotal + $iva;
    } else if ($_POST["appiva"] == "N") {
        $total = $subTotal;
    }

    $sql_updateOrdenCompra = "update ordendecompra set subtotal='" . $subTotal . "',poriva='" . $poriva . "',iva='" . $iva . "',total='" . $total . "' where idordendecompra='" . $indice . "'";
    $result_updateOrdenCompra = mysql_query($sql_updateOrdenCompra, $con) or die(mysql_error());



    /* Se suman de 28 a 42 días dependiendo de los tipos de productos */
    if ($_POST["prioridad"] == 1) {
        $mayor = -999999;
        for ($j = 0; $j < count($materiales); $j++) {
            $sqlSelMaterial = "select * from material where idmaterial='" . $materiales[$j] . "'";
            $resultSelMaterial = mysql_query($sqlSelMaterial, $con) or die(mysql_error());
            $material = mysql_fetch_assoc($resultSelMaterial);
            if ($material["dias"] > $mayor) {
                $mayor = $material["dias"];
            }
        }
        $nuevafecha = new DateTime($_POST["id-date-picker-1"]);
        $nuevafecha->modify('+' . $mayor . ' day');

        $sql_updateOrdenCompra = "update ordendecompra set fechadeentrega='" . $nuevafecha->format('Y-m-d') . "' where idordendecompra='" . $indice . "'";
        $result_updateOrdenCompra = mysql_query($sql_updateOrdenCompra, $con) or die(mysql_error());
    } else if ($_POST["prioridad"] == 2) { /* Se establece una fecha fija de entrega */
        $sql_updateOrdenCompra = "update ordendecompra set fechadeentrega='" . $_POST["id-date-picker-2"] . "' where idordendecompra='" . $indice . "'";
        $result_updateOrdenCompra = mysql_query($sql_updateOrdenCompra, $con) or die(mysql_error());
    }
    
    ?>
        <script type="text/javascript">
            alert("Orden de Compra Registrada Satisfactoriamente.");
            document.location="../listarordenesdecompra.php";
        </script>
    <?php     
}

/*Cancelar orden de compra lo que implica cancelar la orden de producción en caso de existir*/
if ($tarea == 17) {
    
    $sqlCancelarOC="update ordendecompra set estatus='2' where idordendecompra='".$_GET["id"]."'";
    $resultCancelarOC = mysql_query($sqlCancelarOC, $con) or die(mysql_error());  
    
    $sqlCancelarOP="update ordendeproduccion set estatus='2' where idordendecompra='".$_GET["id"]."'";
    $resultCancelarOP = mysql_query($sqlCancelarOP, $con) or die(mysql_error());     
            
    $sqlFactura="select * from factura where idordendecompra='".$_GET["id"]."' and estatus=1";
    $resultFactura = mysql_query($sqlFactura, $con) or die(mysql_error());
    if (mysql_num_rows($resultFactura) > 0) {
        $factura = mysql_fetch_assoc($resultFactura);
        $sqlCancelarFA="update factura set estatus='2' where idordendecompra='".$_GET["id"]."' and estatus=1";
        $resultCancelarFA = mysql_query($sqlCancelarFA, $con) or die(mysql_error()); 
        /*Emision Automatica de Nota de Credito*/
        ?>
            <script type="text/javascript">
                location.target='_blank';                
                document.location="../facturacion/notadecredito.php?idfactura=<?php echo $factura["idfactura"]; ?>";
            </script>
        <?php        
        
    }else{
        ?>
            <script type="text/javascript">
                alert("Orden de Compra Cancelada Satisfactoriamente.");
                document.location="../listarordenesdecompra.php";
            </script>
        <?php          
    }           
}

if ($tarea == 18) {
    $sqlConsulta="select * from excepcionlista where idexcepcionlista='".$_GET["id"]."'";
    $resultConsulta=mysql_query($sqlConsulta, $con) or die(mysql_error());
    $excepcion = mysql_fetch_assoc($resultConsulta);
    
    $sqlupdateexcepcion = "update excepcionlista set estatus='1' where idexcepcionlista='".$_GET["id"]."'";
    $resultupdateexcepcion = mysql_query($sqlupdateexcepcion, $con) or die(mysql_error());           
    ?>
        <script type="text/javascript">
            alert("Excepción en la Lista de Precios Eliminada Satisfactoriamente.");
            document.location="../excepcioneslistadeprecios.php?id=<?php echo $excepcion["idlistadeprecios"]; ?>";
        </script>
    <?php        
}

if ($tarea == 19) {
    //echo $_GET["idexcepcion"]." ".$_GET["newprecio"];
    $sql_excepcion = "select * from excepcionlista where idexcepcionlista='" . $_GET["idexcepcion"] . "'";
    $result_excepcion = mysql_query($sql_excepcion, $con) or die(mysql_error());
    
    $sqlConsulta="select * from excepcionlista where idexcepcionlista='".$_GET["idexcepcion"]."'";
    $resultConsulta=mysql_query($sqlConsulta, $con) or die(mysql_error());
    $excepcion = mysql_fetch_assoc($resultConsulta);    
    
    if (mysql_num_rows($result_excepcion) > 0) {
        $excepcion = mysql_fetch_assoc($result_excepcion);
    }

    if ($excepcion["preciofinal"] != $_GET["newprecio"]) {
        $sql_buscaprefi = "select * from historicoexcepcionlista where idexcepcionlista='" . $_GET["idexcepcion"] . "' and hasta is null";
        $result_buscaprefi = mysql_query($sql_buscaprefi, $con) or die(mysql_error());
        if (mysql_num_rows($result_buscaprefi) > 0) {
            $historico = mysql_fetch_assoc($result_buscaprefi);
            $sql_cierraprefa = "update historicoexcepcionlista set hasta = now(), desde='" . $historico["desde"] . "' where idhistoricoexcepcionlista='" . $historico["idhistoricoexcepcionlista"] . "'";
            $result_cierraprefa = mysql_query($sql_cierraprefa, $con) or die(mysql_error());
            $sql_insertprefa = "insert into historicoexcepcionlista (idexcepcionlista,preciofinal,desde) values ('" . $_GET["idexcepcion"] . "','" . $_GET["newprecio"] . "',now())";
            $result_insertprefa = mysql_query($sql_insertprefa, $con) or die(mysql_error());
            $sql_updateExcepcion = "update excepcionlista set preciofinal='" . $_GET["newprecio"] . "' where idexcepcionlista='" . $_GET["idexcepcion"] . "'";
            $result_updateExcepcion = mysql_query($sql_updateExcepcion, $con) or die(mysql_error());
        }
    }
    ?>
        <script type="text/javascript">
            alert("Precio en la Excepción Cambiado Satisfactoriamente.");
            document.location="../excepcioneslistadeprecios.php?id=<?php echo $excepcion["idlistadeprecios"]; ?>";
        </script>
    <?php    
}

if ($tarea == 20) {
    $sqlUsuario = "insert into usuario (nombre,usuario,contraseña,correo,puesto,telefono,registro) values('".$_POST["nombre"]."','".$_POST["usuario"]."','".$_POST["contrasena"]."','".$_POST["correo"]."','".$_POST["puesto"]."','".$_POST["telefono"]."',now())";
    $resultUsuario = mysql_query($sqlUsuario, $con) or die(mysql_error()); 
        
    $sql_ultimaEMPRESA = "SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'bugambiliasis' AND TABLE_NAME = 'usuario';";
    $result_ultimaEMPRESA = mysql_query($sql_ultimaEMPRESA, $con) or die(mysql_error());
    $fila = mysql_fetch_assoc($result_ultimaEMPRESA);
    $indice = intval($fila["AUTO_INCREMENT"]);
    $indice--; 
    
    $sqlMENU="select * from menu order by idmenu";
    $resultMENU=mysql_query($sqlMENU,$con) or die(mysql_error());
    while ($menu = mysql_fetch_assoc($resultMENU)) {  
        $sqlMenuAlto="insert into menualto (idmenu,idusuario) values('".$menu["idmenu"]."','".$indice."')";
        $resultMenuAlto = mysql_query($sqlMenuAlto, $con) or die(mysql_error());
        
        $sql_ultimoMenuAlto = "SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'bugambiliasis' AND TABLE_NAME = 'menualto';";
        $result_ultimoMenuAlto = mysql_query( $sql_ultimoMenuAlto, $con) or die(mysql_error());
        $fila = mysql_fetch_assoc($result_ultimoMenuAlto);
        $indice2 = intval($fila["AUTO_INCREMENT"]);
        $indice2--;        
        
        $sqlSubMenu="select * from submenu where idmenu='".$menu["idmenu"]."' order by idsubmenu";
        $resultSUBMENU=mysql_query($sqlSubMenu,$con) or die(mysql_error());
        while ($submenu = mysql_fetch_assoc($resultSUBMENU)) {
            $sqlInsertPrivilegio="insert into privilegio (idmenualto,idsubmenu,accion01,accion02,accion03,accion04,accion05,accion06,accion07,accion08,accion09,accion10) values('".$indice2."','".$submenu["idsubmenu"]."',0,0,0,0,0,0,0,0,0,0)";
            $resultInsertPrivilegio = mysql_query($sqlInsertPrivilegio, $con) or die(mysql_error());            
        }        
        
    }    
    
    /*Creación de Matriz Base*/   
    $sqlMENU="select * from menu order by idmenu";
    $resultMENU=mysql_query($sqlMENU,$con) or die(mysql_error());
    while ($menu = mysql_fetch_assoc($resultMENU)) {                                                                    
        $sqlSUBMENU="select * from submenu where idmenu='".$menu["idmenu"]."' order by idsubmenu";
        $resultSUBMENU=mysql_query($sqlSUBMENU,$con) or die(mysql_error());
        while ($submenu = mysql_fetch_assoc($resultSUBMENU)) {
            $sqlOPCION="select * from opsubmenu where idsubmenu='".$submenu["idsubmenu"]."' order by idopsubmenu";
            //echo $sqlOPCION."</br>";
            $resultOPCION=mysql_query($sqlOPCION,$con) or die(mysql_error());
            while ($opcion = mysql_fetch_assoc($resultOPCION)) {
                if(isset($_POST["checkbox-".$menu["idmenu"]."-".$submenu["idsubmenu"]."-".$opcion["indice"].""])){
                    $sqlMenuAlto="select * from menualto where idmenu='".$menu["idmenu"]."' and idusuario='".$indice."'";
                    $resultMenuAlto=mysql_query($sqlMenuAlto,$con) or die(mysql_error());
                    $menualto = mysql_fetch_assoc($resultMenuAlto);
                    if($opcion["indice"]==1){
                        $sqlUpdate="update privilegio set accion01=1 where idmenualto='".$menualto["idmenualto"]."' and idsubmenu='".$submenu["idsubmenu"]."'";
                        $resultUpdate=mysql_query($sqlUpdate,$con) or die(mysql_error());                        
                    } 
                    if($opcion["indice"]==2){
                        $sqlUpdate="update privilegio set accion02=1 where idmenualto='".$menualto["idmenualto"]."' and idsubmenu='".$submenu["idsubmenu"]."'";
                        $resultUpdate=mysql_query($sqlUpdate,$con) or die(mysql_error());                        
                    }                      
                    if($opcion["indice"]==3){
                        $sqlUpdate="update privilegio set accion03=1 where idmenualto='".$menualto["idmenualto"]."' and idsubmenu='".$submenu["idsubmenu"]."'";
                        $resultUpdate=mysql_query($sqlUpdate,$con) or die(mysql_error());                        
                    } 
                    if($opcion["indice"]==4){
                        $sqlUpdate="update privilegio set accion04=1 where idmenualto='".$menualto["idmenualto"]."' and idsubmenu='".$submenu["idsubmenu"]."'";
                        $resultUpdate=mysql_query($sqlUpdate,$con) or die(mysql_error());                        
                    }  
                    if($opcion["indice"]==5){
                        $sqlUpdate="update privilegio set accion05=1 where idmenualto='".$menualto["idmenualto"]."' and idsubmenu='".$submenu["idsubmenu"]."'";
                        $resultUpdate=mysql_query($sqlUpdate,$con) or die(mysql_error());                        
                    } 
                    if($opcion["indice"]==6){
                        $sqlUpdate="update privilegio set accion06=1 where idmenualto='".$menualto["idmenualto"]."' and idsubmenu='".$submenu["idsubmenu"]."'";
                        $resultUpdate=mysql_query($sqlUpdate,$con) or die(mysql_error());                        
                    } 
                    if($opcion["indice"]==7){
                        $sqlUpdate="update privilegio set accion07=1 where idmenualto='".$menualto["idmenualto"]."' and idsubmenu='".$submenu["idsubmenu"]."'";
                        $resultUpdate=mysql_query($sqlUpdate,$con) or die(mysql_error());                        
                    } 
                    if($opcion["indice"]==8){
                        $sqlUpdate="update privilegio set accion08=1 where idmenualto='".$menualto["idmenualto"]."' and idsubmenu='".$submenu["idsubmenu"]."'";
                        $resultUpdate=mysql_query($sqlUpdate,$con) or die(mysql_error());                        
                    } 
                    if($opcion["indice"]==9){
                        $sqlUpdate="update privilegio set accion09=1 where idmenualto='".$menualto["idmenualto"]."' and idsubmenu='".$submenu["idsubmenu"]."'";
                        $resultUpdate=mysql_query($sqlUpdate,$con) or die(mysql_error());                        
                    } 
                    if($opcion["indice"]==10){
                        $sqlUpdate="update privilegio set accion10=1 where idmenualto='".$menualto["idmenualto"]."' and idsubmenu='".$submenu["idsubmenu"]."'";
                        $resultUpdate=mysql_query($sqlUpdate,$con) or die(mysql_error());                        
                    }                     
                }                 
            }
        }                                                                                                                                                                                                       
    }    
    ?>
        <script type="text/javascript">
            alert("Usuario Registrado Satisfactoriamente.");
            document.location="../listarusuarios.php";
        </script>
    <?php         
}


if ($tarea == 21) {
    $sqlUpdate = "update usuario set nombre='".$_POST["nombre"]."', usuario='".$_POST["usuario"]."', contraseña='".$_POST["contrasena"]."', correo='".$_POST["correo"]."', puesto='".$_POST["puesto"]."', telefono='".$_POST["telefono"]."' where idusuario='".$_GET["id"]."'";
    $resultUpdate = mysql_query($sqlUpdate, $con) or die(mysql_error()); 
    
    /*Actualización de Matriz Base*/   
    $sqlMENU="select * from menu order by idmenu";
    $resultMENU=mysql_query($sqlMENU,$con) or die(mysql_error());
    while ($menu = mysql_fetch_assoc($resultMENU)) {                                                                    
        $sqlSUBMENU="select * from submenu where idmenu='".$menu["idmenu"]."' order by idsubmenu";
        $resultSUBMENU=mysql_query($sqlSUBMENU,$con) or die(mysql_error());
        while ($submenu = mysql_fetch_assoc($resultSUBMENU)) {
            $sqlOPCION="select * from opsubmenu where idsubmenu='".$submenu["idsubmenu"]."' order by idopsubmenu";
            //echo $sqlOPCION."</br>";
            $resultOPCION=mysql_query($sqlOPCION,$con) or die(mysql_error());
            while ($opcion = mysql_fetch_assoc($resultOPCION)) {
                if(isset($_POST["checkbox-".$menu["idmenu"]."-".$submenu["idsubmenu"]."-".$opcion["indice"].""])){
                    $sqlMenuAlto="select * from menualto where idmenu='".$menu["idmenu"]."' and idusuario='".$_GET["id"]."'";
                    $resultMenuAlto=mysql_query($sqlMenuAlto,$con) or die(mysql_error());
                    $menualto = mysql_fetch_assoc($resultMenuAlto);
                    if($opcion["indice"]==1){
                        $sqlUpdate="update privilegio set accion01=1 where idmenualto='".$menualto["idmenualto"]."' and idsubmenu='".$submenu["idsubmenu"]."'";
                        $resultUpdate=mysql_query($sqlUpdate,$con) or die(mysql_error());                        
                    }                     
                    if($opcion["indice"]==2){
                        $sqlUpdate="update privilegio set accion02=1 where idmenualto='".$menualto["idmenualto"]."' and idsubmenu='".$submenu["idsubmenu"]."'";
                        $resultUpdate=mysql_query($sqlUpdate,$con) or die(mysql_error());                        
                    }                      
                    if($opcion["indice"]==3){
                        $sqlUpdate="update privilegio set accion03=1 where idmenualto='".$menualto["idmenualto"]."' and idsubmenu='".$submenu["idsubmenu"]."'";
                        $resultUpdate=mysql_query($sqlUpdate,$con) or die(mysql_error());                        
                    } 
                    if($opcion["indice"]==4){
                        $sqlUpdate="update privilegio set accion04=1 where idmenualto='".$menualto["idmenualto"]."' and idsubmenu='".$submenu["idsubmenu"]."'";
                        $resultUpdate=mysql_query($sqlUpdate,$con) or die(mysql_error());                        
                    }  
                    if($opcion["indice"]==5){
                        $sqlUpdate="update privilegio set accion05=1 where idmenualto='".$menualto["idmenualto"]."' and idsubmenu='".$submenu["idsubmenu"]."'";
                        $resultUpdate=mysql_query($sqlUpdate,$con) or die(mysql_error());                        
                    } 
                    if($opcion["indice"]==6){
                        $sqlUpdate="update privilegio set accion06=1 where idmenualto='".$menualto["idmenualto"]."' and idsubmenu='".$submenu["idsubmenu"]."'";
                        $resultUpdate=mysql_query($sqlUpdate,$con) or die(mysql_error());                        
                    } 
                    if($opcion["indice"]==7){
                        $sqlUpdate="update privilegio set accion07=1 where idmenualto='".$menualto["idmenualto"]."' and idsubmenu='".$submenu["idsubmenu"]."'";
                        $resultUpdate=mysql_query($sqlUpdate,$con) or die(mysql_error());                        
                    } 
                    if($opcion["indice"]==8){
                        $sqlUpdate="update privilegio set accion08=1 where idmenualto='".$menualto["idmenualto"]."' and idsubmenu='".$submenu["idsubmenu"]."'";
                        $resultUpdate=mysql_query($sqlUpdate,$con) or die(mysql_error());                        
                    } 
                    if($opcion["indice"]==9){
                        $sqlUpdate="update privilegio set accion09=1 where idmenualto='".$menualto["idmenualto"]."' and idsubmenu='".$submenu["idsubmenu"]."'";
                        $resultUpdate=mysql_query($sqlUpdate,$con) or die(mysql_error());                        
                    } 
                    if($opcion["indice"]==10){
                        $sqlUpdate="update privilegio set accion10=1 where idmenualto='".$menualto["idmenualto"]."' and idsubmenu='".$submenu["idsubmenu"]."'";
                        $resultUpdate=mysql_query($sqlUpdate,$con) or die(mysql_error());                        
                    }                     
                }else{
                    $sqlMenuAlto="select * from menualto where idmenu='".$menu["idmenu"]."' and idusuario='".$_GET["id"]."'";
                    $resultMenuAlto=mysql_query($sqlMenuAlto,$con) or die(mysql_error());
                    $menualto = mysql_fetch_assoc($resultMenuAlto);
                    if($opcion["indice"]==1){
                        $sqlUpdate="update privilegio set accion01=0 where idmenualto='".$menualto["idmenualto"]."' and idsubmenu='".$submenu["idsubmenu"]."'";
                        $resultUpdate=mysql_query($sqlUpdate,$con) or die(mysql_error());                        
                    }                     
                    if($opcion["indice"]==2){
                        $sqlUpdate="update privilegio set accion02=0 where idmenualto='".$menualto["idmenualto"]."' and idsubmenu='".$submenu["idsubmenu"]."'";
                        $resultUpdate=mysql_query($sqlUpdate,$con) or die(mysql_error());                        
                    }                      
                    if($opcion["indice"]==3){
                        $sqlUpdate="update privilegio set accion03=0 where idmenualto='".$menualto["idmenualto"]."' and idsubmenu='".$submenu["idsubmenu"]."'";
                        $resultUpdate=mysql_query($sqlUpdate,$con) or die(mysql_error());                        
                    } 
                    if($opcion["indice"]==4){
                        $sqlUpdate="update privilegio set accion04=0 where idmenualto='".$menualto["idmenualto"]."' and idsubmenu='".$submenu["idsubmenu"]."'";
                        $resultUpdate=mysql_query($sqlUpdate,$con) or die(mysql_error());                        
                    }  
                    if($opcion["indice"]==5){
                        $sqlUpdate="update privilegio set accion05=0 where idmenualto='".$menualto["idmenualto"]."' and idsubmenu='".$submenu["idsubmenu"]."'";
                        $resultUpdate=mysql_query($sqlUpdate,$con) or die(mysql_error());                        
                    } 
                    if($opcion["indice"]==6){
                        $sqlUpdate="update privilegio set accion06=0 where idmenualto='".$menualto["idmenualto"]."' and idsubmenu='".$submenu["idsubmenu"]."'";
                        $resultUpdate=mysql_query($sqlUpdate,$con) or die(mysql_error());                        
                    } 
                    if($opcion["indice"]==7){
                        $sqlUpdate="update privilegio set accion07=0 where idmenualto='".$menualto["idmenualto"]."' and idsubmenu='".$submenu["idsubmenu"]."'";
                        $resultUpdate=mysql_query($sqlUpdate,$con) or die(mysql_error());                        
                    } 
                    if($opcion["indice"]==8){
                        $sqlUpdate="update privilegio set accion08=0 where idmenualto='".$menualto["idmenualto"]."' and idsubmenu='".$submenu["idsubmenu"]."'";
                        $resultUpdate=mysql_query($sqlUpdate,$con) or die(mysql_error());                        
                    } 
                    if($opcion["indice"]==9){
                        $sqlUpdate="update privilegio set accion09=0 where idmenualto='".$menualto["idmenualto"]."' and idsubmenu='".$submenu["idsubmenu"]."'";
                        $resultUpdate=mysql_query($sqlUpdate,$con) or die(mysql_error());                        
                    } 
                    if($opcion["indice"]==10){
                        $sqlUpdate="update privilegio set accion10=0 where idmenualto='".$menualto["idmenualto"]."' and idsubmenu='".$submenu["idsubmenu"]."'";
                        $resultUpdate=mysql_query($sqlUpdate,$con) or die(mysql_error());                        
                    }                                                                                                                                                                                    
                }                 
            }
        }                                                                                                                                                                                                       
    }    
                
    ?>
        <script type="text/javascript">
            alert("Usuario Editado Satisfactoriamente.");
            document.location="../listarusuarios.php";
        </script>
    <?php     
}

if ($tarea == 22) {
    $sqlOrden="select * from ordendecompra where idordendecompra='".$_GET["id"]."'";
    $resultOrden=mysql_query($sqlOrden,$con) or die(mysql_error()); 
    $ord = mysql_fetch_assoc($resultOrden);
    
    $sqlUpdateBase="update ordendecompra set codigoexterno='".$_POST["codigoext"]."', idagenda01='".$_POST["contacto01"]."', idagenda02='".$_POST["contacto02"]."', idagenda03='".$_POST["contacto03"]."', condiciones='".$_POST["condiciones"]."', paqueteria='".$_POST["paqueteria"]."', observaciones='".$_POST["observaciones"]."' where idordendecompra='".$_GET["id"]."'";
    $resultUpdateBase=mysql_query($sqlUpdateBase,$con) or die(mysql_error());  
    
    $sqlDelete="delete from productosordencompra where idordendecompra='".$_GET["id"]."'";
    $resultDelete=mysql_query($sqlDelete,$con) or die(mysql_error());
    
    
    $productos = $_POST["oculto01"];
    $listaIds = explode("_", $_POST["oculto02"]);
    $listaCodigos = explode("_", $_POST["oculto03"]);
    $listaDescripciones = explode("_", $_POST["oculto04"]);
    $listaColores = explode("_", $_POST["oculto05"]);
    $listaPrecios = explode("_", $_POST["oculto06"]);
    $listaUnidades = explode("_", $_POST["oculto07"]);

    $subTotal = 0;
    $poriva = 0;
    $total = 0;
    $iva = 0;

    $materiales = array();

    for ($i = 0; $i < count($listaIds); $i++) {
        if ($listaIds[$i] != "") {
            $sql_precio = "select preciofabrica,idmaterial from producto where idproducto='" . $listaIds[$i] . "'";
            $result_precio = mysql_query($sql_precio, $con) or die(mysql_error());
            if (mysql_num_rows($result_precio) > 0) {
                $precio = mysql_fetch_assoc($result_precio);
                $banderina = 0;
                for ($j = 0; $j < count($materiales); $j++) {
                    if ($materiales[$j] == $precio["idmaterial"]) {
                        $banderina = 1;
                    }
                }
                if ($banderina == 0) {
                    $materiales[count($materiales)] = $precio["idmaterial"];
                }
                $sql_color = "select * from color where nombre='" . $listaColores[$i] . "'";
                $result_color = mysql_query($sql_color, $con) or die(mysql_error());
                $color = mysql_fetch_assoc($result_color);
                $subTotal+=($listaUnidades[$i] * $listaPrecios[$i]);
                $sql_insProducto = "insert into productosordencompra (idordendecompra,idproducto,idcolor,preciofabrica,precioventa,numerodeunidades) values('" . $_GET["id"] . "','" . $listaIds[$i] . "','" . $color["idcolor"] . "','" . $precio["preciofabrica"] . "','" . $listaPrecios[$i] . "','" . $listaUnidades[$i] . "')";
                $result_insProducto = mysql_query($sql_insProducto, $con) or die(mysql_error());
            }
        }
    }

    if ($_POST["appiva"] == "S") {
        $poriva = $_POST["poriva"];
        $iva = $subTotal * ($poriva / 100);
        $total = $subTotal + $iva;
    } else if ($_POST["appiva"] == "N") {
        $total = $subTotal;
    }

    $sql_updateOrdenCompra = "update ordendecompra set subtotal='" . $subTotal . "',poriva='" . $poriva . "',iva='" . $iva . "',total='" . $total . "' where idordendecompra='" .$_GET["id"]. "'";
    $result_updateOrdenCompra = mysql_query($sql_updateOrdenCompra, $con) or die(mysql_error()); 
    
    
    /* Se suman de 28 a 42 días dependiendo de los tipos de productos */
    if ($_POST["prioridad"] == 1) {
        $mayor = -999999;
        for ($j = 0; $j < count($materiales); $j++) {
            $sqlSelMaterial = "select * from material where idmaterial='" . $materiales[$j] . "'";
            $resultSelMaterial = mysql_query($sqlSelMaterial, $con) or die(mysql_error());
            $material = mysql_fetch_assoc($resultSelMaterial);
            if ($material["dias"] > $mayor) {
                $mayor = $material["dias"];
            }
        }
        $nuevafecha = new DateTime($ord["fechaderegistro"]);
        $nuevafecha->modify('+' . $mayor . ' day');

        $sql_updateOrdenCompra = "update ordendecompra set fechadeentrega='" . $nuevafecha->format('Y-m-d') . "' where idordendecompra='" . $_GET["id"] . "'";
        $result_updateOrdenCompra = mysql_query($sql_updateOrdenCompra, $con) or die(mysql_error());
    } else if ($_POST["prioridad"] == 2) { /* Se establece una fecha fija de entrega */
        $sql_updateOrdenCompra = "update ordendecompra set fechadeentrega='" . $_POST["id-date-picker-2"] . "' where idordendecompra='" . $_GET["id"] . "'";
        $result_updateOrdenCompra = mysql_query($sql_updateOrdenCompra, $con) or die(mysql_error());
    }    
    
    /*Actualiza la Orden de Producción*/
    $sqlOrden="select * from ordendeproduccion where idordendecompra='".$_GET["id"]."'";
    $resultOrden = mysql_query($sqlOrden, $con) or die(mysql_error());
    if (mysql_num_rows($resultOrden) > 0) {
        
        $ordenP = mysql_fetch_assoc($resultOrden);
        //echo "Encontro una orden de producción para editarse";
        
        $sqlConfiguracion = "select * from configuracionsistema where idconfiguracionsistema=1";
        $result_Configuracion = mysql_query($sqlConfiguracion, $con) or die(mysql_error());
        if (mysql_num_rows($result_Configuracion) > 0) {
             $configuracion = mysql_fetch_assoc($result_Configuracion);
        }         
        
        $sqlORDENCOMPRA = "select * from ordendecompra where idordendecompra='".$_GET["id"]."'";
        $resultORDENCOMPRA = mysql_query($sqlORDENCOMPRA, $con) or die(mysql_error());
        $ORDEN = mysql_fetch_assoc($resultORDENCOMPRA);
        
        $subTotal=0;
        $sql_listaPRODUCTOS="select * from productosordencompra where idordendecompra='".$_GET["id"]."'";
        $result_listaPRODUCTOS=mysql_query($sql_listaPRODUCTOS,$con) or die(mysql_error());
        if(mysql_num_rows($result_listaPRODUCTOS)>0){
            while ($producto = mysql_fetch_assoc($result_listaPRODUCTOS)) {
                $subTotal+=$producto["preciofabrica"]*$producto["numerodeunidades"];
                
            }
        }
        $poriva=$configuracion["poriva"];
        $iva=$subTotal*($poriva/100);
        $total=$subTotal+$iva;
                        
        $sql_insertProduccion = "";                        
        $sqlUpdateOrdenDeProduccion="update ordendeproduccion set idagenda01='".$_POST["contacto01"]."', idagenda02='".$_POST["contacto02"]."', idagenda03='".$_POST["contacto03"]."', subtotal='".$subTotal."', poriva='".$poriva."', iva='".$iva."', total='".$total."', prioridad='".$ORDEN["prioridad"]."', fechadeentrega='".$ORDEN["fechadeentrega"]."' where idordendeproduccion='".$ordenP["idordendeproduccion"]."'";
        $resultUpdateOrdenDeProduccion = mysql_query($sqlUpdateOrdenDeProduccion,$con) or die(mysql_error()); 
        
        $sqlDelete="delete from productosordenproduccion where idordendeproduccion='".$ordenP["idordendeproduccion"]."'";
        $resultDelete = mysql_query($sqlDelete,$con) or die(mysql_error());
        
        $sql_listaPRODUCTOS="select * from productosordencompra where idordendecompra='".$_GET["id"]."'";
        $result_listaPRODUCTOS=mysql_query($sql_listaPRODUCTOS,$con) or die(mysql_error());
        if(mysql_num_rows($result_listaPRODUCTOS)>0){
            while ($producto = mysql_fetch_assoc($result_listaPRODUCTOS)) {
                $sql_insertProducto = "insert into productosordenproduccion (idordendeproduccion,idproducto,idcolor,preciofabrica,numerodeunidades) values('".$ordenP["idordendeproduccion"]."','".$producto["idproducto"]."','".$producto["idcolor"]."','".$producto["preciofabrica"]."','".$producto["numerodeunidades"]."')";
                $result_Producto = mysql_query($sql_insertProducto,$con) or die(mysql_error());
            }
        }        
        
    }
    
    ?>
        <script type="text/javascript">
            alert("Orden de Compra Editada Satisfactoriamente.");
            document.location="../listarordenesdecompra.php";
        </script>
    <?php   
}


if ($tarea == 23) {
    $Sqlconfiguracion="select * from configuracionsistema where idconfiguracionsistema=1";
    $resultconfiguracion = mysql_query($Sqlconfiguracion, $con) or die(mysql_error());
    $configuracion = mysql_fetch_assoc($resultconfiguracion);
    
    if($configuracion["regalias"]!=$_POST["regalias"]){
        $sqlCierra="update historicoregalias set hasta = now() where hasta is null";
        $resultCierra = mysql_query($sqlCierra, $con) or die(mysql_error());
        $sqlInsert="insert into historicoregalias (porcentajeregalias,desde,hasta) values('".$_POST["regalias"]."',now(),NULL)";
        $resultInsert = mysql_query($sqlInsert, $con) or die(mysql_error());
        $sqlUpdate="update configuracionsistema set regalias='".$_POST["regalias"]."' where idconfiguracionsistema=1";
        $resultUpdate = mysql_query($sqlUpdate, $con) or die(mysql_error());
    }
    
    if($configuracion["poriva"]!=$_POST["iva"]){
        $sqlCierra="update historicoporiva set hasta = now() where hasta is null";
        $resultCierra = mysql_query($sqlCierra, $con) or die(mysql_error());
        $sqlInsert="insert into historicoporiva (porcentajeiva,desde,hasta) values('".$_POST["iva"]."',now(),NULL)";
        $resultInsert = mysql_query($sqlInsert, $con) or die(mysql_error());
        $sqlUpdate="update configuracionsistema set poriva='".$_POST["iva"]."' where idconfiguracionsistema=1";
        $resultUpdate = mysql_query($sqlUpdate, $con) or die(mysql_error());        
    } 
    
    if($configuracion["cambio"]!=$_POST["cambio"]){
        $sqlCierra="update historicocambiodolar set hasta = now() where hasta is null";
        $resultCierra = mysql_query($sqlCierra, $con) or die(mysql_error());
        $sqlInsert="insert into historicocambiodolar (cambio,desde,hasta) values('".$_POST["cambio"]."',now(),NULL)";
        $resultInsert = mysql_query($sqlInsert, $con) or die(mysql_error());
        $sqlUpdate="update configuracionsistema set cambio='".$_POST["cambio"]."' where idconfiguracionsistema=1";
        $resultUpdate = mysql_query($sqlUpdate, $con) or die(mysql_error());        
    }    
    
        
    $sqlUpdate="update configuracionsistema set secuenciaop='".$_POST["secuencia"]."', facturacionempresa='".$_POST["fiscalempresa"]."', facturacioncalle='".$_POST["fiscalavenida"]."', facturacionext='".$_POST["fiscalexterior"]."', facturacionint='".$_POST["fiscalinterior"]."', facturacioncolonia='".$_POST["fiscalcolonia"]."', facturacionpostal='".$_POST["fiscalpostal"]."', facturacionestpais='".$_POST["fiscalestpais"]."', facturacionrfc='".$_POST["fiscalrfc"]."', serie='".$_POST["serie"]."', folio='".$_POST["folio"]."' where idconfiguracionsistema=1";
    $resultUpdate = mysql_query($sqlUpdate, $con) or die(mysql_error());
    ?>
        <script type="text/javascript">
            alert("Parametros de Configuración Editados Satisfactoriamente.");
            document.location="../configuracionsistema.php";
        </script>
    <?php  
    
}

if ($tarea == 24) {
    $sqlInsertPago="insert into pago (idusuario,idfactura,fecharegistro,fechapago,monto,tipopago,referencia) values('".$_SESSION["usuario"]."','".$_GET["idfactura"]."',now(),'".$_POST["id-date-picker-1"]."','".$_POST["cantidad"]."','".$_POST["tipodepago"]."','".$_POST["referencia"]."')";
    $resultInsertPago = mysql_query($sqlInsertPago, $con) or die(mysql_error());
    
    $acumulaPagos=0;
    $sqlPagos="select * from pago where idfactura='".$_GET["idfactura"]."'";
    $resultPagos = mysql_query($sqlPagos, $con) or die(mysql_error());
    if (mysql_num_rows($resultPagos) > 0) {
        while ($pagos = mysql_fetch_assoc($resultPagos)) {
            $acumulaPagos+=$pagos["monto"];
        }
    }
    
    $sqlFactura="select * from factura where idfactura='".$_GET["idfactura"]."'";
    $resultFactura=mysql_query($sqlFactura, $con) or die(mysql_error());
    $factura = mysql_fetch_assoc($resultFactura);
    
    $sqlUpdate="update factura set resta='".($factura["total"]-round($acumulaPagos,3))."' where idfactura='".$_GET["idfactura"]."'";
    $resultUpdate=mysql_query($sqlUpdate, $con) or die(mysql_error());
    ?>
        <script type="text/javascript">
            alert("Pago Registrado Satisfactoriamente.");
            document.location="../registrodepago.php?idfactura=<?php echo $_GET["idfactura"]; ?>";
        </script>
    <?php     
    
}

if ($tarea == 25) {
    
}

if ($tarea == 26) {
    $sqlpago="select * from pago where idpago='".$_GET["id"]."'";
    $resultpago=mysql_query($sqlpago,$con) or die(mysql_error());
    $pago = mysql_fetch_assoc($resultpago);
    
    $sqlDelete="delete from pago where idpago='".$_GET["id"]."'";
    $resultDelete=mysql_query($sqlDelete,$con) or die(mysql_error());
    
    ?>
        <script type="text/javascript">
            alert("Pago Eliminado Satisfactoriamente.");
            document.location="../registrodepago.php?idfactura=<?php echo $pago["idfactura"]; ?>";
        </script>
    <?php        
}

/*Cancelar orden de Producción lo que implica cancelar la orden de compra*/
if ($tarea == 27) {
    $sqlORDENPRODUCCION = "select * from ordendeproduccion where idordendeproduccion='".$_GET["id"]."'";
    $resultORDENPRODUCCION = mysql_query($sqlORDENPRODUCCION, $con) or die(mysql_error());
    $ORDENP = mysql_fetch_assoc($resultORDENPRODUCCION);        
    
    $sqlCancelarOC="update ordendecompra set estatus='2' where idordendecompra='".$ORDENP["idordendecompra"]."'";
    $resultCancelarOC = mysql_query($sqlCancelarOC, $con) or die(mysql_error());
    
    $sqlCancelarOP="update ordendeproduccion set estatus='2' where idordendeproduccion='".$_GET["id"]."'";
    $resultCancelarOP = mysql_query($sqlCancelarOP, $con) or die(mysql_error());     
    
    $sqlFactura="select * from factura where idordendecompra='".$ORDENP["idordendecompra"]."' and estatus=1";
    $resultFactura = mysql_query($sqlFactura, $con) or die(mysql_error());
    if (mysql_num_rows($resultFactura) > 0) {
        $factura = mysql_fetch_assoc($resultFactura);
        $sqlCancelarFA="update factura set estatus='2' where idordendecompra='".$ORDENP["idordendecompra"]."' and estatus=1";
        $resultCancelarFA = mysql_query($sqlCancelarFA, $con) or die(mysql_error());
        /*Emision Automatica de Nota de Credito*/
        ?>
            <script type="text/javascript">
                location.target='_blank';                
                document.location="../facturacion/notadecredito.php?idfactura=<?php echo $factura["idfactura"]; ?>";
            </script>
        <?php          
    }else{
        ?>
            <script type="text/javascript">
                alert("Orden de Producción Cancelada Satisfactoriamente.");
                document.location="../listarordenesdeproduccion.php";
            </script>
        <?php        
    }                           
}



/*Cancelar orden de Producción lo que implica cancelar la orden de compra*/
if ($tarea == 28) {
    $sqlFactura = "select * from factura where idfactura='".$_GET["id"]."'";
    $resultFactura = mysql_query($sqlFactura, $con) or die(mysql_error());
    $FACT = mysql_fetch_assoc($resultFactura);    
    
    $sqlCancelarOP="update ordendeproduccion set estatus='2' where idordendecompra='".$FACT["idordendecompra"]."'";
    $resultCancelarOP = mysql_query($sqlCancelarOP, $con) or die(mysql_error());   
    
    $sqlCancelarOC="update ordendecompra set estatus='2' where idordendecompra='".$FACT["idordendecompra"]."'";
    $resultCancelarOC = mysql_query($sqlCancelarOC, $con) or die(mysql_error());
    
    $sqlCancelarFA="update factura set estatus='2' where idfactura='".$_GET["id"]."' and estatus=1";
    $resultCancelarFA = mysql_query($sqlCancelarFA, $con) or die(mysql_error());
        
        
    ?>
        <script type="text/javascript">
            location.target='_blank';                
            document.location="../facturacion/notadecredito.php?idfactura=<?php echo $_GET["id"]; ?>";
        </script>
    <?php          
                          
}
?>