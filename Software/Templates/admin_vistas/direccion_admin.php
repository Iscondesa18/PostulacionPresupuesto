



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
<h1 style="text-align: center;">Administrador de direcciones</h1>
        <?php
    
    include("../../modelo/conexion_bd.php");
    include("../../controlador/controlador_direccion/controlador_eliminar_direccion.php"); 
    ?>
      <?php
      include "../../modelo/conexion_bd.php";
      $sql = $conexion->query("SELECT id_direccion,desc_direccion,codigo_direccion FROM `direccion` ORDER BY id_direccion;");


  ?>
    <div class='tabla'>
  <table class="table table-striped table-dark" >
  <thead>
    <tr>
      <th scope="col">Id</th>
      <th scope="col">Nombre dirección</th>
      <th scope="col">Codigo dirección</th>
      <th scope="col">Acciones</th>

    </tr>
  </thead>
  <tbody>
    <?php
    while($datos = $sql ->fetch_object()){ ?>
    
      <tr>
      <td><?= $datos->id_direccion ?></td>
      <td><?= $datos->desc_direccion ?></td>
      <td><?= $datos->codigo_direccion ?></td>
      
      <td><a href="direccion_admin.php?id_direccion=<?=$datos->id_direccion ?>" onclick="return advertencia()"><button type="button" class="btn btn-danger">Eliminar</button></a>


     <a href="modificar_direccion.php?id_direccion=<?=$datos->id_direccion ?>"> <button type="button" class="btn btn-warning">Modificar</button></a></td>
      </tr> 

    <?php } ?>

  </tbody>
</table><a href="crear_direccion.php">
<button type="button" class="btn btn-success" style="float : right;">Agregar dirección</button>
</a>
</div>





</body>

<script>
  function advertencia() {
    var not=confirm("¿Estas seguro que quieres eliminar?");
    return not;
    
  }
</script>

</html>