
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
    include("../../controlador/controlador_usuarios/controlador_registrar_usuario.php"); 
  ?>
      <div class="container_user"><center>
          <h1 >Crear usuario</h1><br></center>
          <div class="row">
            <div class="col">
                <label for="exampleFormControlTextarea1">Nombre </label>
                <input type="text" name="name" id="name" tabindex="1" class="form-control"  onkeypress="return check(event)" minlength="3" maxlength="15" placeholder="Nombre" value="" required= required >
            </div>
            <div class="col">
                <label for="exampleFormControlTextarea1">Apellido </label>
                <input type="text" name="apellido" id="apellido" tabindex="1" class="form-control" onkeypress="return check(event)" minlength="3" maxlength="15" placeholder="Apellido" value="" required= required >
            </div>
          </div>
          <div class="row">
            <div class="col">
                <label for="exampleFormControlTextarea1">Nombre de usuario </label>
                <input type="text" name="username" id="username" tabindex="1" class="form-control"  minlength="5" maxlength="15" placeholder="Usuario" value="" required= required >
            </div>
            <div class="col">
                <label for="exampleFormControlTextarea1">Contraseña</label>
                <input type="password" name="clave" id="clave" tabindex="1" class="form-control"  minlength="5" maxlength="15" placeholder="Contraseña" value="" required= required >
            </div>
          </div>
          <br>
        <div class="row">
        
          <div class="col">
          <label for="exampleFormControlTextarea1">Tipo de usuario </label><br>
              <select id="show" class="custom-select"   name="tipousu"required= required  >
              <option value="0">Seleccione tipo de usuario:</option>
              <?php
                $query = $conexion -> query ("SELECT * FROM tipo_usuario");
                        
                while ($valores = mysqli_fetch_array($query)) {
                                        
                  echo '<option value="'.$valores['id_tipo_usuario'].'">'.$valores['descripcion'].'</option>';
                }
                  
              ?>
              </select>
          </div>

          <div class="col">
          <label for="exampleFormControlTextarea1">Dirección </label><br>
              <select id="element"  class="custom-select" name="direccion">
              <option value="22">Seleccione la direccion a la que pertenece:</option>
              <?php
                $query = $conexion -> query ("SELECT * FROM direccion");
                        
                while ($valores = mysqli_fetch_array($query)) {
                                        
                  echo '<option value="'.$valores['id_direccion'].'">'.$valores['desc_direccion'].'</option>';
                }
                  
              ?>

              </select>
          </div> 
        </div><br>
          <div class="btn-admi-post">
            <a href="usu_admin.php"> <input type="submit" name="adminusu"tabindex="4" class="btn btn-success" style="float : right;"  value="Registrar"></a>
          </div>

      </div>
</form>


</body>

</html>


<script>
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