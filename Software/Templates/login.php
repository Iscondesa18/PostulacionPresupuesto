

<!doctype html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Presupuesto SECPLA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../css/Inicio.css">

  </head><br><br>
<body class='fondo'>

<div class="container_sesion">
<form id="login-form" action="" method="post" role="form" style="display: block;">
    <h1 ><center>Presupuesto municipal</center></h1><br>

    <div class="row">
        <div class="col-md-6">
            <div class="panel-body">
                <div class="col-md">
                    <?php
                    include("../modelo/conexion_bd.php");
                    include("../controlador/controlador.php");
                    ?>    
                    <div class="form-group">
                        <input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="Usuario" value="" required= required >
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Contraseña" required= required>
                    </div>
                    <div class="form-group">
                    <div class="btn-iniciar-sesion">
                        <input type="submit"  name="login-submit" id="login-submit" tabindex="4" class="btn btn-success"  value="Iniciar sesión">
                    </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>

</html>