

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
  <h1 style="text-align: center;">Fichas aceptadas</h1>

    <?php    
        include("../../modelo/conexion_bd.php");
        include("../../controlador/controlador_fichas/controlador_eliminar_fichas.php"); 
    ?>
    <?php
      include "../../modelo/conexion_bd.php";
      $sql = $conexion->query("SELECT 	direccion.codigo_direccion, 
                                        ficha.nombre_ficha, 
                                        ficha.id_ficha, 
                                        tipo_ficha.desc_tipo_ficha, 
                                        areas_gestion.desc_area_gestion, 
                                        bien_servicio_secpla.bien_servi_secpla, 
                                        clasificador_presupuestario.clasificacion_presu,
                                        clasificador_presupuestario.nombre_cuenta,
                                        (bien_servicio.cantidad_bien*bien_servicio.valor_unitario) AS monto_solicitado,
                                        (bien_servicio_secpla.cantidad_bien_sec*bien_servicio_secpla.valor_unitario) AS monto_recomendado 
                                    FROM ficha 
                                    INNER JOIN direccion on ficha.id_direccion=direccion.id_direccion 
                                    INNER JOIN tipo_ficha on ficha.id_tipo_ficha=tipo_ficha.id_tipo_ficha 
                                    INNER JOIN detalle_ficha on ficha.id_ficha = detalle_ficha.id_ficha 
                                    INNER JOIN bien_servicio_secpla on detalle_ficha.id_detalle_ficha = bien_servicio_secpla.id_detalle_ficha 
                                    INNER JOIN areas_gestion on bien_servicio_secpla.id_area_gestion =areas_gestion.id_area_gestion
                                    INNER JOIN clasificador_presupuestario ON bien_servicio_secpla.clasi_presu=clasificador_presupuestario.clasificacion_presu
                                    INNER JOIN estado_ficha ON ficha.id_estado_ficha=estado_ficha.id_estado_ficha
                                    INNER JOIN bien_servicio ON bien_servicio_secpla.id_bien_servicio=bien_servicio.id_bien_servicio
                                    WHERE estado_ficha.id_estado_ficha = 5
                                    ORDER by ficha.id_ficha desc ");
    ?>
 <div style="padding-left: 5%;"><a href="../../controlador/controlador_fichas/exportar_fichas.php"><button type="button" class="btn btn-success">Exportar tabla a excel</button></a></div>
    <div class='tabla'>
  <table class="table table-striped table-dark" >
    <thead>
      <tr>
        <th scope="col">Dirección</th>
        <th scope="col">Código ficha</th>
        <th scope="col">Nombre ficha</th>
        <th scope="col">Tipo de gasto</th>
        <th scope="col">Área de gestión</th>
        <th scope="col">Nombre de la cuenta</th>
        <th scope="col">Codigo PPTO</th>
        <th scope="col">Detalle de la glosa</th>
        <th scope="col">Monto postulado</th>
        <th scope="col">Recomendado SECPLA</th>

      </tr>
    </thead>
    <tbody>
      <?php
      while($datos = $sql ->fetch_object()){ ?>
      
        <tr>
        <td><?= $datos->codigo_direccion?></td>
        <td><?= $datos->id_ficha?></td>
        <td><?= $datos->nombre_ficha?></td>
        <td><?= $datos->desc_tipo_ficha?></td>
        <td><?= $datos->desc_area_gestion?></td>
        <td><?= $datos->nombre_cuenta?></td>
        <td><?= $datos->clasificacion_presu?></td>
        <td><?= $datos->bien_servi_secpla?></td>
        <td><?= $datos->monto_solicitado?></td>
        <td><?= $datos->monto_recomendado?></td>
      
  
      <?php } ?>
      <?php
        include "../../modelo/conexion_bd.php";
        $sql = $conexion->query("SELECT SUM(bien_servicio.cantidad_bien*bien_servicio.valor_unitario) as total_solicitado,
                                        SUM(bien_servicio_secpla.cantidad_bien_sec*bien_servicio_secpla.valor_unitario) as total_recomendado
                                  FROM `bien_servicio_secpla` 
                                  INNER JOIN bien_servicio ON bien_servicio_secpla.id_bien_servicio=bien_servicio.id_bien_servicio
                                  INNER JOIN detalle_ficha ON bien_servicio_secpla.id_detalle_ficha=detalle_ficha.id_detalle_ficha
                                  INNER JOIN ficha ON detalle_ficha.id_ficha=ficha.id_ficha
                                  WHERE ficha.id_estado_ficha=5
                                        ");
      ?>
      <?php
      while($datos = $sql ->fetch_object()){ ?>
      </tr> 
        <tr>
      
        <td colspan="2">Monto total </td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td><?= $datos->total_solicitado ?></td>
        <td><?= $datos->total_recomendado ?></td>
        </tr> 

        <?php } ?>
    </tbody>
  </table>
 
</div>
</body>
<script>
  function advertencia() {
    var not=confirm("¿Estas seguro que quieres eliminar?");
    return not;
    
  }

  
</script>

</html>