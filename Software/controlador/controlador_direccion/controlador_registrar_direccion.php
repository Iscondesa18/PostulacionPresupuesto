


<?php
if(!empty($_POST["direccion-submit"])){
    if (empty($_POST["name_direccion"]) or empty($_POST["codigo_direccion"])) {
        echo '<div class="alert alert-danger" style="text-align: center;" >POR FAVOR COMPLETE TODOS LOS CAMPOS</div>';
    } else {
        $nombre_direccion=$_POST["name_direccion"];
        $codigo_direccion=$_POST["codigo_direccion"];
        $sql=$conexion->query("INSERT INTO `direccion`(`id_direccion`, `desc_direccion`, `codigo_direccion`) VALUES ('','$nombre_direccion','$codigo_direccion')");
        if ($sql==1) {
            echo '<div class="alert alert-success" >Dirección registrada correctamente</div>';
        } else {
            echo '<div class="alert alert-danger" >ERROR</div>';
        }
        
    }
    



}


?>