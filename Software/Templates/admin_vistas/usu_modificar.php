
<?php
    session_start();
    if(empty($_SESSION['nombre'])and empty($_SESSION['apellido'])){
        header('location:../login.php');
    }
    if (!isset($_SESSION['id_tipo_usuario'])) {
      header('location:../login.php');
    }else {
        if ($_SESSION['id_tipo_usuario'] != 1) {
          header('location:../login.php');
        }
      }

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Presupuesto SECPLA</title>
    <script src="https://code.jquery.com/jquery-3.2.1.js"></script>
    <script type="text/javascript">
          $(document).ready(function(){
        $("#hide").on('click', function() {
            $("#element").hide();
            return false;
        });
    
        $("#show").on('click',function() {
            $("#element").show();
            return false;
        });
    });
    </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../../css/Inicio.css">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <a class="navbar-brand" href="home_admin.php">  Administrador</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="usu_admin.php">Administrador de usuarios</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="direccion_admin.php">Administrador de direcciones</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="postu_admin.php">Administrador de fichas y postulaciones</a>
          </li>

        </ul>
      </div>
      
      <a href="../../controlador/controlador_cerrar_sesion.php">
      <button type="button" class="btn btn-dark">Cerrar sesión</button>
        </a>
  </nav>


</head><br><br>
<body  class='fondo'>

<form action="" method="POST">
    
<?php
    
    include("../../modelo/conexion_bd.php");
    include("../../controlador/controlador_usuarios/controlador_modificar_usuario.php"); 
    $id= $_GET["id"];
    $sql = $conexion->query("SELECT * FROM usuario INNER JOIN tipo_usuario ON usuario.id_tipo_usuario=tipo_usuario.id_tipo_usuario INNER JOIN direccion ON usuario.id_direccion=direccion.id_direccion where id =$id");
    $datos= $sql ->fetch_object();


    ?>
    <div class="container_user"><center>
    <h1 >Modificar usuario</h1><br></center>
        <div class="row">
          <div class="col">
              <input type="text" name="name" id="name" tabindex="1" class="form-control" placeholder="Nombre" onkeypress="return check(event)" minlength="3" maxlength="15" value="<?= $datos->nombre ?>" required= required >
          </div>
          <div class="col">
              <input type="text" name="apellido" id="apellido" tabindex="1" class="form-control" placeholder="Apellido" onkeypress="return check(event)" minlength="3" maxlength="15" value="<?= $datos->apellido ?>" required= required >
          </div>
        </div>
        <div class="row">
          <div class="col">
              <input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="Usuario" minlength="5" maxlength="15" value="<?= $datos->usuario ?>" required= required >
          </div>
          <div class="col">
              <input type="password" name="clave" id="clave" tabindex="1" class="form-control" placeholder="Contraseña" minlength="5" maxlength="15" value="<?= $datos->clave ?>" required= required >
          </div>
        </div>

      <div class="row">
        <div class=" col input-group mb-3">
            <select class="custom-select"   name="tipousu"required= required  >
            <option value="<?= $datos->id_tipo_usuario ?>"><?= $datos->descripcion ?></option>
            <?php

            
            $query = $conexion -> query ("SELECT * FROM tipo_usuario");
                    
            while ($valores = mysqli_fetch_array($query)) {
                                    
              echo '<option value="'.$valores['id_tipo_usuario'].'">'.$valores['descripcion'].'</option>';
            }
                
            ?>
            </select>
        </div>

        <div class=" col input-group mb-3">
            <select id="element" class="custom-select" name="direccion">
            <option value="<?= $datos->id_direccion ?>"><?= $datos->desc_direccion ?></option>
            <?php

            
            $query = $conexion -> query ("SELECT * FROM direccion");
                    
            while ($valores = mysqli_fetch_array($query)) {
                                    
              echo '<option value="'.$valores['id_direccion'].'">'.$valores['desc_direccion'].'</option>';
            }
                
            ?>

            </select>
        </div> 
      </div>
        <div class="btn-admi-update">
           <a href="usu_admin.php" > <input type="submit" onclick="return advertencia()" name="usupdate"tabindex="4" class="btn btn-success" style="float : right;"  value="Modificar"></a>
        </div>

    </div>
</form>


</body>

<script>
  function advertencia() {
    var not=confirm("¿Quieres guardar los cambios?");
    return not;
    
  }
  function check(e) {
    tecla = (document.all) ? e.keyCode : e.which;

    //Tecla de retroceso para borrar, siempre la permite
    if (tecla == 8) {
        return true;
    }

    // Patrón de entrada, en este caso solo acepta numeros y letras
    patron = /[A-Za-z]/;
    tecla_final = String.fromCharCode(tecla);
    return patron.test(tecla_final);
  }

</script>

</html>