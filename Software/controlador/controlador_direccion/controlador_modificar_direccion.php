

<?php
  $id_direccion= $_GET["id_direccion"];
if(!empty($_POST["direccion-update"])){
    if (empty($_POST["name_direccion"]) or empty($_POST["codigo_direccion"])) {
        echo '<div class="alert alert-danger" style="text-align: center;" >POR FAVOR COMPLETE TODOS LOS CAMPOS</div>';
    } else {
        $nombre_direccion=$_POST["name_direccion"];
        $codigo_direccion=$_POST["codigo_direccion"];
        $sql=$conexion->query("UPDATE direccion set desc_direccion='$nombre_direccion', codigo_direccion='$codigo_direccion'  where id_direccion=$id_direccion ");
        if ($sql==1) {
            echo '<div class="alert alert-success" >Direccion modificada correctamente</div>';
        } else {
            echo '<div class="alert alert-danger" >ERROR</div>';
        }
        
    }
    



}


?>