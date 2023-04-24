
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


  </head>
  <body class='fondo' >

    

<div class="container">
    
    <div class="row row-cols-2">
        <div class="col" >
            <h4> Fecha Inicio postulaciones:</h4>
            <input type="date" id="start" name="trip-start"
            value="2022-11-25"
            min="2022-11-01" max="2024-12-31"> 
        </div><br>
        <div class="col">
            <h4> Fecha termino postulaciones:</h4>
            <input type="date" id="start" name="trip-start"
            value="2022-11-25"
            min="2022-11-01" max="2024-12-31"> 
        </div><br><br><br><br>
    </div>
    <div>
    <h4> Fichas:</h4>
    <div id="checkboxes1" style="display:inline-block">
        <ul>
        <li> <input type="checkbox" name="hobbies" id="leer" value="leer"> <label for="leer">Ficha gastos corrientes.</label> </li>
        <li> <input type="checkbox" name="hobbies" id="internet" value="internet"> <label for="internet">Ficha contratos.</label> </li>
        <li> <input type="checkbox" name="hobbies" id="radio" value="radio"> <label for="radio">Ficha Proyectos inversión.</label> </li>
        
        </ul>
    </div>
    <div id="checkboxes2" style="display:inline-block">
        <ul>
        <li> <input type="checkbox" name="hobbies" id="playstation" value="playstation"> <label for="playstation">Ficha programas sociales.</label> </li>
        <li> <input type="checkbox" name="hobbies" id="tv" value="tv"> <label for="tv">Ficha Actividades municipales.</label> </li>
        <li> <input type="checkbox" name="hobbies" id="callofduty" value="callofduty"> <label for="callofduty">Ficha servicios comunitarios.</label> </li>
        </ul>
    </div>
    <div id="checkboxes3" style="display:inline-block">
        <ul>
        <li> <input type="checkbox" name="hobbies" id="leer" value="leer"> <label for="leer">Ficha estudios.</label> </li>
        <li> <input type="checkbox" name="hobbies" id="internet" value="internet"> <label for="internet">Ficha transferencias, subvenciones o convenios.</label> </li>
        <li> <input type="checkbox" name="hobbies" id="radio" value="radio"> <label for="radio">Programas asistenciales.</label> </li>
        </ul>
    </div><br><br>
    <div class="btn-admi-post">
        <input type="submit" name="adminpost-submit" id="adminpost-submit" tabindex="4" class="btn btn-success" style="float : right;"  value="Guardar cambios">
    </div>

    </div>


</div>
</body>

</html>