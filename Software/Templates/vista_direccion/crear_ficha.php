
<?php
    session_start();
    if(empty($_SESSION['nombre'])and empty($_SESSION['apellido'])){
        header('location:../login.php');
    }
    if (!isset($_SESSION['id_tipo_usuario'])) {
      header('location:../login.php');
    }else {
        if ($_SESSION['id_tipo_usuario'] != 3) {
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../../css/Inicio.css">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <a class="navbar-brand" href="home_direccion.php">  Dirección</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="home_direccion.php">Tus fichas</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="crear_ficha.php">Crear fichas</a>
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
    include("../../controlador/controlador_usuarios/controlador_eliminar_user.php"); 
    ?>
      <?php
      include "../../modelo/conexion_bd.php";
      $sql = $conexion->query("SELECT * FROM `tipo_ficha`");


  ?>
<div class='tabla'>
  <center><H1>Fichas disponibles</H1></center>
  <br><br>
  <table class="table table-striped table-dark" >
  <thead>
    <tr>
      <th scope="col">Id</th>
      <th scope="col">Nombre</th>
      <th scope="col">Acciones</th>
    </tr>
  </thead>
  <tbody>
    <?php
    while($datos = $sql ->fetch_object()){ ?>
    
      <tr>
      <td><?= $datos->id_tipo_ficha ?></td>
      <td><?= $datos->desc_tipo_ficha ?></td>
      <td><a href="<?=$datos->codigo_tipo_ficha ?>.php" ><button type="button" class="btn btn-success">Crear ficha</button></a></td>
  </tr> 

    <?php } ?>

  </tbody>
</table>

</body>

</html>