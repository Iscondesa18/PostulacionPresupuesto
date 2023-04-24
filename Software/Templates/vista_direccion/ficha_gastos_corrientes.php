
<?php #validacion sesion
    session_start();
    if(empty($_SESSION['nombre'])and empty($_SESSION['apellido'])){
        header('location:../../login.php');
    }
    if (!isset($_SESSION['id_tipo_usuario'])) {
      header('location:../../login.php');
    }else {
        if ($_SESSION['id_tipo_usuario'] != 3) {
          header('location:../../login.php');
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script type="text/javascript" src="dist/jquery.tabledit.js"></script>
    <script type="text/javascript" src="custom_table_edit.js"></script>
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


<?php    #conexion controladores
  include("../../modelo/conexion_bd.php");
  include("../../controlador/controlador_fichas/controlador_registrar_ficha_gc.php");
  include("../../controlador/controlador_fichas/controlador_eliminar_bi_serv.php");  
?>
<?php #id_ficha              
  $sql = $conexion -> query("SELECT MAX(id_ficha) as id_ficha FROM ficha");
  $datos= $sql ->fetch_object();  
?>
<?php  #id_detalle_ficha
  $consulta = $conexion -> query("SELECT MAX(id_detalle_ficha) as id_detalle_ficha FROM detalle_ficha");     
  $id_detalle= $consulta ->fetch_object();  
  $id_ficha=$datos->id_ficha +1 ;
  $id_detalle_ficha= $id_detalle->id_detalle_ficha +1 ;
?>

<body  class='fondo'>
  <div  class="container_ficha_encabezado">
    <center><h1>Ficha Gastos corrientes</h1></center>
      <div>
        <form action="" id="formulario_gastos_corriente" method="POST">
            
            <br>
            <div class="row">
              <div class="col">
                <label for="exampleFormControlTextarea1">Nombre Ficha </label>
                <input type="text" name="name_ficha" id="name_ficha"  minlength="6" tabindex="1" class="form-control"  value="" required= required >
              </div>
              <div class="col">
                <label for="exampleFormControlTextarea1">Financiamiento solicitado  en miles de pesos (M$)</label>
                <input type="text" name="monto_soli" id="monto_soli" onkeypress="return event.charCode>=48 && event.charCode<=57" tabindex="1"  minlength="2" maxlength="10" class="form-control" value=""  pattern="[0-9]{1,15}" required= required >
              </div>
              
              <div style="display: none;">
                <input type="text" name="id_ficha" id="id_ficha" tabindex="1" class="form-control" value=" <?= $id_ficha ?>" >
              </div>
            </div>
            <div style="display: none;">
                <input type="text" name="id_detalle" id="id_detalle" tabindex="1" class="form-control" value=" <?= $id_detalle_ficha?>" >
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col">
                <label for="exampleFormControlTextarea1">Descripción de los producto o los resultados a obtener</label>
                <textarea class="form-control form-control--edit"id="desc_ficha"    minlength="10" name="desc_ficha" rows="3" required= required ></textarea>
              </div>
              <div class="col">
                <label for="exampleFormControlTextarea1">Justificación del gasto</label>
                <textarea class="form-control form-control--edit" id="justificacion"  minlength="10" name="justificacion" rows="3" required= required ></textarea>
              </div>
            </div>
            <div class="btn-admi-post">
              <a href="ficha_gastos_corrientes2.php?id_detalle=<?= $id_detalle->id_detalle_ficha +1 ?>"><input type="submit" name="gastos_corrientes" id="gastos_corrientes" tabindex="4" class="btn btn-success" style="float : right;"  value="Guardar"></a>
          </div>
      
        </form>
      </div> 
      <br><br><br>

  </div>
</body>

</html>