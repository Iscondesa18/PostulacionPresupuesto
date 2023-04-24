

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
    <?php    
    include("../../modelo/conexion_bd.php");
    include("../../controlador/controlador_direccion/controlador_modificar_direccion.php"); 
    
    $id_direccion= $_GET["id_direccion"];
    $sql = $conexion->query("SELECT * FROM direccion where id_direccion =$id_direccion");
    $datos= $sql ->fetch_object();
    ?>

<form action="" method="POST">
    

    
<div class="container_sesion"><center>
    <h1>Modificar Dirección</h1><br></center>
        <div class="row">
          <div class="col">
              <input type="text" name="name_direccion" id="codigo_direccion" tabindex="1" class="form-control" placeholder="Nombre Dirección" onkeypress="return check(event)" minlength="5" maxlength="50" value="<?= $datos->desc_direccion ?>" required= required >
          </div>
          <div class="col">
              <input type="text" name="codigo_direccion" id="codigo_direccion" tabindex="1" class="form-control" placeholder="Codigo dirección" onkeypress="return check(event)" minlength="2" maxlength="4" value="<?= $datos->codigo_direccion ?>" required= required >
          </div>
        </div>
        <br>
        
        <div class="btn-iniciar-sesion">
            <input type="submit" onclick="return advertencia()" name="direccion-update" id="direccion-update" tabindex="4" class="btn btn-success"  value="Modificar dirección">
        </div>
    </div>
    
</form>
</body>

<script>
  function advertencia() {
    var not=confirm("¿Quieres guaradr los cambios?");
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