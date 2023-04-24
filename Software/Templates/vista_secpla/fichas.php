

<?php
    session_start();
    if(empty($_SESSION['nombre'])and empty($_SESSION['apellido'] ) ){
      
      header('location:../login.php');
    }
    if (isset($_SESSION['id_direccion'])) {
      $id_direccionSession=$_SESSION['id_direccion'];
      $id_direccion = htmlspecialchars($id_direccionSession); 

    }
    if (isset($_SESSION['id'])) {
      $id_usuarioSession=$_SESSION['id'];
      $id_usaurio = htmlspecialchars($id_usuarioSession); 


    }
    if (!isset($_SESSION['id_tipo_usuario'])) {
      header('location:../login.php');

    }
    else {
        if ($_SESSION['id_tipo_usuario'] !=2) {
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../../css/Inicio.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="../../js/function.js"></script>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <a class="navbar-brand" href="home_secpla.php">  SECPLA</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="fichas.php">Fichas recibidas</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="crear_ficha.php">Fichas revisadas</a>
          </li>  
          <li class="nav-item">
            <a class="nav-link" href="fichas_aceptadas_secpla.php">Fichas aceptadas</a>
          </li>

        </ul>
      </div>
      
      <a href="../../controlador/controlador_cerrar_sesion.php">
      <button type="button" class="btn btn-dark">Cerrar sesión</button>
        </a>
     </nav>


  </head><br><br>



  <body  class='fondo'>
  <h1 style="text-align: center;">Fichas</h1>

    <?php    
        include("../../modelo/conexion_bd.php");
        include("../../controlador/controlador_fichas/controlador_eliminar_fichas.php"); 
    ?>
    <?php
      include "../../modelo/conexion_bd.php";
      $sql = $conexion->query("SELECT ficha.id_ficha,
      ficha.nombre_ficha,
      tipo_ficha.desc_tipo_ficha,
      direccion.desc_direccion,
      DATE_FORMAT(fecha_presentacion, '%d/%m/%Y') AS fecha ,
      FORMAT(financiamiento_solicitado, 'N')as financiamiento_soli,
      usuario.nombre, 
      usuario.apellido,
      estado_ficha.desc_estado_ficha
      FROM `ficha` 
      INNER JOIN direccion  ON ficha.id_direccion=direccion.id_direccion 
      INNER JOIN tipo_ficha ON ficha.id_tipo_ficha=tipo_ficha.id_tipo_ficha
      INNER JOIN usuario    ON ficha.id=usuario.id
      INNER JOIN estado_ficha    ON ficha.id_estado_ficha=estado_ficha.id_estado_ficha
      WHERE estado_ficha.id_estado_ficha!= 1 and estado_ficha.id_estado_ficha!=5
      order by ficha.id_ficha DESC");
    ?>

    <div class='tabla'>
  <table class="table table-striped table-dark" >
  <thead>
    <tr>
      <th scope="col">Nombre ficha</th>
      <th scope="col">Tipo ficha</th>
      <th scope="col">
      <select id="buscar_direccion" class="custom-select"   name="buscar_direccion" >
              <option value="0">Dirección</option>
              <?php
                $query = $conexion -> query ("SELECT * FROM direccion");
                        
                while ($valores = mysqli_fetch_array($query)) {
                                        
                  echo '<option value="'.$valores['id_direccion'].'">'.$valores['desc_direccion'].'</option>';
                }
                  
              ?>
              </select>
 
      </th>
      <th scope="col">Fecha envio</th>
      <th scope="col">Nombre responsable</th>
      <th scope="col">Estado</th>
      <th scope="col">Monto solicitado</th>
      <th scope="col">Acciones</th>

    </tr>
  </thead>
  <tbody>
    <?php
    while($datos = $sql ->fetch_object()){ ?>
    
      <tr>
      <td><?= $datos->nombre_ficha ?></td>
      <td><?= $datos->desc_tipo_ficha ?></td>
      <td><?= $datos->desc_direccion ?></td>
      <td><?= $datos->fecha ?></td>
      <td><?= $datos->nombre?> <?= $datos->apellido?></td>
      <td><?= $datos->desc_estado_ficha ?></td>
      <td>$ <?= $datos->financiamiento_soli ?></td>
      <td>
      <a href="ver_ficha.php?id_ficha=<?=$datos->id_ficha?>"><button type="button" class="btn btn-success">Revisar</button></a>
      </td>
     
 
    <?php } ?>
    <?php
      include "../../modelo/conexion_bd.php";
      $sql = $conexion->query("SELECT FORMAT(SUM(financiamiento_solicitado), 'N') as total FROM `ficha` 
                                INNER JOIN direccion ON ficha.id_direccion=direccion.id_direccion      
                                INNER JOIN estado_ficha ON ficha.id_estado_ficha=estado_ficha.id_estado_ficha
                                WHERE estado_ficha.id_estado_ficha!= 1 and estado_ficha.id_estado_ficha!=5
                                
     ");
?>
    <?php
    while($datos = $sql ->fetch_object()){ ?>
    </tr> 
      <tr>
     
      <td colspan="2">Monto total solicitado</td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td><?= $datos->total ?></td>
      <td></td>
      </tr> 

      <?php } ?>
  </tbody>
</div>
</body>
<script>
  function advertencia() {
    var not=confirm("¿Estas seguro que quieres eliminar?");
    return not;
    
  }

  
</script>

</html>