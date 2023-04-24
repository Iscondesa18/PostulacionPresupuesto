
<?php

    $_SESSION['id_direccion'];
    $id_direccionSession=$_SESSION['id_direccion'];
    $id_direccion = htmlspecialchars($id_direccionSession);
    $_SESSION['id'];
    $id_usuarioSession=$_SESSION['id'];
    $id_usuario = htmlspecialchars($id_usuarioSession);
#SE GUARDA EL ENCABEZADO DE LA FICHA Y SE GENERA EL DETALLE DE LA FICHA
if(!empty($_POST["gastos_corrientes"])){
    if (empty($_POST["name_ficha"]) or empty($_POST["monto_soli"])or empty($_POST["justificacion"])) {
        echo '<div class="alert alert-danger" style="text-align: center;" >POR FAVOR COMPLETE TODOS LOS CAMPOS</div>';
    } else {
        $name_ficha         =$_POST["name_ficha"];
        $monto_soli         =$_POST["monto_soli"];
        $justificacion      =$_POST["justificacion"];
        $descripcion        =$_POST["desc_ficha"];
        $id_ficha           =$_POST["id_ficha"];
        $id_detalle_ficha   =$_POST["id_detalle"];
        $id_direccion       =$_SESSION["id_direccion"];
        $id_usuario         =$_SESSION["id"];
        
        $sql=$conexion->query("INSERT INTO `ficha`(`id_ficha`, `nombre_ficha`, `id_tipo_ficha`, `fecha_presentacion`, `id_direccion`, `justificacion_gasto`, `financiamiento_solicitado`,`id`,`id_estado_ficha`) VALUES ($id_ficha ,'$name_ficha',1,NOW(),$id_direccion,'$justificacion','$monto_soli',$id_usuario, 1)");
        if ($sql==1) {
            $sql=$conexion->query("INSERT INTO `detalle_ficha`(`id_detalle_ficha`, `id_ficha`, `desc_prod_resul`) VALUES ($id_detalle_ficha,$id_ficha,'$descripcion')");
            echo '<div class="alert alert-success" >Ficha registrada correctamente</div>';
            header("location:ficha_gastos_corrientes2.php?id_detalle=$id_detalle_ficha");
        } else {
            echo '<div class="alert alert-danger" >ERROR</div>';
        }
        
    }
}


# DESTINO DE FONDOS AQUI ES DONDE SE GUARDAN LOS SERVICIOS O BIENES 
if(!empty($_POST["gastos_corrientes_bien"])){
    if (empty($_POST["bi_serv"]) or empty($_POST["cantidad"])or empty($_POST["valor_unitario"])) {
        echo '<div class="alert alert-danger" style="text-align: center;" >POR FAVOR COMPLETE TODOS LOS CAMPOS</div>';
    } else {
        $id_detalle_ficha   =$_POST["id_detalle_ficha"];
        $bi_serv            =$_POST["bi_serv"];
        $cantidad           =$_POST["cantidad"];
        $valor_unitario     =$_POST["valor_unitario"];
        $id_bi_serv         =$_POST["id_bien_serv"];
        $sql=$conexion->query("INSERT INTO `bien_servicio`(`id_bien_servicio`,`id_detalle_ficha`,`desc_bien_servi`,`cantidad_bien`,`valor_unitario`, `total_bien`, `enero`, `febrero`, `marzo`, `abril`, `mayo`, `junio`, `julio`, `agosto`, `septiembre`, `octubre`, `noviembre`, `diciembre`) VALUES ($id_bi_serv,$id_detalle_ficha,'$bi_serv',$cantidad ,$valor_unitario,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL )");
        $sql=$conexion->query("INSERT INTO `bien_servicio_secpla`(`id_servicio_secpla`, `bien_servi_secpla`, `cantidad_bien_sec`, `valor_unitario`,`id_area_gestion`,`id_detalle_ficha`,`id_bien_servicio`) VALUES ('','$bi_serv',$cantidad ,$valor_unitario,7,$id_detalle_ficha,$id_bi_serv)");
        if ($sql==1) {
            echo '<div class="alert alert-success" >Bien y servicio registrado correctamente</div>';
        } else {
            echo '<div class="alert alert-danger" >ERROR</div>';
        }
    }
}


# DESTINO DE FONDOS AQUI ES DONDE SE GUARDAN LOS DATOS DEL CALENDARIO DE FINANCIAMIENTO

if(!empty($_POST["calendario_gastos_corrientes"])){
    if (empty($_POST["id_bien"])) {
        echo '<div class="alert alert-danger" style="text-align: center;" >POR FAVOR COMPLETE TODOS LOS CAMPOS</div>';
    } else {
        $id_bien_servicio   =$_POST["id_bien"];
        $enero              =$_POST["enero"];
        $febrero            =$_POST["febrero"];
        $marzo              =$_POST["marzo"];
        $abril              =$_POST["abril"];
        $mayo               =$_POST["mayo"];
        $junio              =$_POST["junio"];
        $julio              =$_POST["julio"];
        $agosto             =$_POST["agosto"];
        $septiembre         =$_POST["septiembre"];
        $octubre            =$_POST["octubre"];
        $noviembre          =$_POST["noviembre"];
        $diciembre          =$_POST["diciembre"];
        $sql=$conexion->query("UPDATE bien_servicio SET enero = '$enero', febrero = '$febrero', marzo = '$marzo', abril = '$abril', mayo = '$mayo', junio = '$junio', julio = '$julio', agosto = '$agosto', septiembre = '$septiembre', octubre = '$octubre', noviembre = '$noviembre', diciembre = '$diciembre' WHERE id_bien_servicio =$id_bien_servicio");
        if ($sql==1) {
            echo '<div class="alert alert-success" >FIla añadida correctamente</div>';
        } else {
            echo '<div class="alert alert-danger" >ERROR</div>';
        }   
    }

}
?>