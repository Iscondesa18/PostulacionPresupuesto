<?php

session_start();

if(isset($_SESSION['id_tipo_usuario'])){
    switch ($_SESSION['id_tipo_usuario']) {
        case 1:
            header("location:admin_vistas/home_admin.php");
            break;
        case 2:
            header("location:vista_secpla/home_secpla.php");
            break;
        case 3:
            header("location:vista_direccion/home_direccion.php");
            break;        
        default:
            # code...
            break;
    }


}


if (!empty($_POST["login-submit"])){
    if (empty($_POST["username"]) and empty($_POST["password"])) {
        echo '<div class="alert alert-danger" >LOS CAMPOS ESTAN VACIOS</div>';
    } else {
        $usuario=$_POST["username"];
        $clave=$_POST["password"];
        $sql=$conexion->query(" select * from usuario where usuario='$usuario' and clave='$clave' ");
        if ($datos=$sql->fetch_object()) {
            $_SESSION["nombre"]=$datos->nombre;
            $_SESSION["apellido"]=$datos->apellido;
            $_SESSION["id"]=$datos->id;
            $_SESSION["id_direccion"]=$datos->id_direccion;
            $_SESSION['id_tipo_usuario']=$datos->id_tipo_usuario;
            switch ($_SESSION['id_tipo_usuario']) {
                case 1:
                    header("location:admin_vistas/home_admin.php");
                    break;
                case 2:
                    header("location:vista_secpla/home_secpla.php");
                    break;
                case 3:
                    header("location:vista_direccion/home_direccion.php");
                    break;        
                default:
                    # code...
                    break;
            }
            
        } else {
            echo '<div class="alert alert-danger" >ACCESO DENEGADO</div>';
        }
        
    }
}
?>