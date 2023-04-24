

<?php
  $id= $_GET["id"];
if(!empty($_POST["usupdate"])){
    if (empty($_POST["name"]) or empty($_POST["apellido"]) or empty($_POST["username"]) or empty($_POST["clave"])or empty($_POST["tipousu"])) {
        echo '<div class="alert alert-danger" style="text-align: center;" >POR FAVOR COMPLETE TODOS LOS CAMPOS</div>';
    } else {
        $nombre=$_POST["name"];
        $apellido=$_POST["apellido"];
        $username=$_POST["username"];
        $clave=$_POST["clave"];
        $idusu=$_POST["tipousu"];
        $iddireccion=$_POST["direccion"];
        $sql=$conexion->query("UPDATE usuario set usuario='$username', clave='$clave', nombre='$nombre', apellido='$apellido',id_tipo_usuario=$idusu, id_direccion=$iddireccion  where id =$id");
        if ($sql==1) {
            echo '<div class="alert alert-success" >Usuario modificado correctamente</div>';
        } else {
            echo '<div class="alert alert-danger" >ERROR</div>';
        }   
    }
}
?>