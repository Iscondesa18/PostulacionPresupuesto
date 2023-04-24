<?php
if (!empty($_GET["id"])) {
    $id_bien_servicio=$_GET["id"];
    $sql=$conexion->query("delete from bien_servicio where id_bien_servicio = $id_bien_servicio");
    if ($sql==true) {
    
    } else { 
    
    echo '<div class="alert alert-danger" >ERROR</div>';
     }

}