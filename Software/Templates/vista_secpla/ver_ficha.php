
<?php #validacion sesion
    session_start();
    if(empty($_SESSION['nombre'])and empty($_SESSION['apellido'])){
        header('location:../login.php');
    }
    if (!isset($_SESSION['id_tipo_usuario'])) {
      header('location:../login.php');
    }else {
        if ($_SESSION['id_tipo_usuario'] != 2) {
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script type="text/javascript" src="dist/jquery.tabledit.js"></script>
    <script type="text/javascript" src="custom_table_edit.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../../css/Inicio.css">

      
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

</head>
<br>


<?php    #conexion controladores
  include("../../modelo/conexion_bd.php");
  include("../../controlador/controlador_fichas/controlador_registrar_ficha_gc.php");
  include("../../controlador/controlador_fichas/controlador_actualizar_ficha_gc.php");
  include("../../controlador/controlador_fichas/controlador_eliminar_bi_serv.php");  
  $id_ficha=$_GET['id_ficha']
?>
<?php #id_ficha              
  $sql = $conexion -> query("SELECT * FROM ficha INNER JOIN direccion ON ficha.id_direccion =direccion.id_direccion INNER JOIN usuario on ficha.id = usuario.id INNER JOIN detalle_ficha on ficha.id_ficha=detalle_ficha.id_ficha where ficha.id_ficha=$id_ficha ");
  $datos= $sql ->fetch_object();  
  $id_detalle_ficha=$datos->id_detalle_ficha
?>
<?php #tablas bien servicio (Falta recuperar id_detalleficha)
  include "../../modelo/conexion_bd.php";
  $calendario = $conexion->query("SELECT id_bien_servicio,
                                  id_detalle_ficha,
                                  desc_bien_servi,
                                  cantidad_bien,
                                  valor_unitario,
                                  format(cantidad_bien*valor_unitario, 'g') as total_bien,
                                  format(enero, 'g')      as enero,
                                  format(febrero, 'g')    as febrero,
                                  format(marzo, 'g')      as marzo,
                                  format(abril, 'g')      as abril,
                                  format(mayo, 'g')       as mayo,
                                  format(junio, 'g')      as junio,
                                  format(julio, 'g')      as julio,
                                  format(agosto, 'g')     as agosto,
                                  format(septiembre, 'g') as septiembre,
                                  format(octubre, 'g')    as octubre,
                                  format(noviembre, 'g')  as noviembre,
                                  format(diciembre, 'g')  as diciembre
                                   FROM `bien_servicio` where id_detalle_ficha = $id_detalle_ficha ");  

    $suma =$conexion->query ("SELECT format(sum(cantidad_bien*valor_unitario),'G','en-US') as total FROM `bien_servicio` where id_detalle_ficha =$id_detalle_ficha"); 
    $total=$suma->fetch_object();
    $total_suma=$total->total;
?>
<?php //bien servicio tablas
  $bien = $conexion->query("SELECT id_bien_servicio,
                                id_detalle_ficha,
                                desc_bien_servi,
                                cantidad_bien,
                                format(valor_unitario, 'G','en-US') as valor_unitario,
                                format(cantidad_bien*valor_unitario, 'G','en-US') as total_bien
                                FROM `bien_servicio` where id_detalle_ficha = $id_detalle_ficha ");
?>
<?php //monto solicitado
  $monto_soli = $conexion->query("SELECT ficha.id_ficha,
                                  format(ficha.financiamiento_solicitado, 'G','en-US') as financiamiento_soli
                                  FROM `detalle_ficha` 
                                  INNER JOIN ficha ON detalle_ficha.id_ficha=ficha.id_ficha
                                  WHERE detalle_ficha.id_detalle_ficha= $id_detalle_ficha");

  $solicitado= $monto_soli ->fetch_object();  

?>

<body  class='fondo'>
<div style="padding-left: 80%;">
      <input type="text" value="<?=$datos->desc_direccion?> "readonly >
    </div>
  <div  class="container_ficha_ver_gc">
    <center><h1>Ficha Gastos corrientes</h1></center>
      <div>
        <form action="" id="formulario_gastos_corriente" method="POST">
            <br>
            <div class="row">
              <div class="col">
                <label for="exampleFormControlTextarea1">Nombre Ficha </label>
                <input type="text" name="name_ficha" id="name_ficha"  minlength="6" tabindex="1" class="form-control"  value="<?=$datos->nombre_ficha?>"  readonly>
              </div>
              <div class="col">
                <label for="exampleFormControlTextarea1">Financiamiento solicitado  en miles de pesos (M$)</label>
                <input type="text" name="monto_soli" id="monto_soli" onkeypress="return event.charCode>=48 && event.charCode<=57" tabindex="1"  minlength="2" maxlength="10" class="form-control" value="<?=$datos->financiamiento_solicitado?>"  pattern="[0-9]{1,15}" readonly >
              </div>
              
              
            </div>
            
            </div>
            <br>
            <div class="row">
              <div class="col">
                <label for="exampleFormControlTextarea1">Descripción de los producto o los resultados a obtener</label>
                <textarea class="form-control form-control--edit"id="desc_ficha"    value="<?=$datos->desc_prod_resul?>"name="desc_ficha" rows="3" readonly><?=$datos->desc_prod_resul?></textarea>
              </div>
              <div class="col">
                <label for="exampleFormControlTextarea1">Justificación del gasto</label>
                <textarea class="form-control form-control--edit" id="justificacion"  value="<?=$datos->justificacion_gasto?>"  name="justificacion" rows="3" readonly><?=$datos->justificacion_gasto?></textarea>
              </div>
            </div>
      
        </form>
        <div>
            <br><br>
      <center><h3>Destino de fondos</h3></center>
        <br><br><br>
        <div>
          <table class="table table-hover">
            <thead>
              <tr>
                <th scope="col">Bien o servicio a adquirir</th>
                <th scope="col">Cantidad</th>
                <th scope="col">Valor unitario M$</th>
                <th scope="col">TOTAL</th>
              </tr>
            </thead>
            <tbody>
              <?php
                  while($bienes = $bien ->fetch_object()){ ?>
              <tr>
              <td><?= $bienes->desc_bien_servi ?></td>
              <td><?= $bienes->cantidad_bien ?></td>
              <td><?= $bienes->valor_unitario?> </td>
              <td><?= $bienes->total_bien?> </td>
              </tr>
              <?php } ?>
              <tr>
                <th scope="row">TOTAL</th>
                <td></td>
                <td></td>
                <td><?=$total_suma?></td>
              </tr>
            </tbody>
          </table>
        </div>
        <br><br><br>
      <center><h3>Calendario de financiamiento (en miles de pesos)</h3></center>
      <br><br>
        <table class="table table-hover">
          <thead>
              <tr>
                <th scope="col">Bien o servicio a adquirir</th>
                <th scope="col">ENE</th>
                <th scope="col">FEB</th>
                <th scope="col">MAR</th>
                <th scope="col">ABR</th>
                <th scope="col">MAY</th>
                <th scope="col">JUN</th>
                <th scope="col">JUL</th>
                <th scope="col">AGO</th>
                <th scope="col">SEP</th>
                <th scope="col">OCT</th>
                <th scope="col">NOV</th>
                <th scope="col">DIC</th>
                <th scope="col">TOTAL</th>
                <th scope="col"></th>
              </tr>
          </thead>
          <tbody>
          
              <?php while($valores = $calendario ->fetch_object()){ ?>
                <form action=""  method="POST">
              <tr>
                <td><?= $valores->desc_bien_servi ?> </td>
                <td style="display: none;"><input type="text" onkeypress="return event.charCode>=48 && event.charCode<=57" id="id_bien"    name="id_bien"  value="<?= $valores->id_bien_servicio ?> "size="2"></td>
                <td><input type="text" onkeypress="return event.charCode>=48 && event.charCode<=57" id="enero"      name="enero"      value="<?= $valores->enero ?>"      size="3" readonly></td>
                <td><input type="text" onkeypress="return event.charCode>=48 && event.charCode<=57" id="febrero"    name="febrero"    value="<?= $valores->febrero ?>"    size="3" readonly></td>
                <td><input type="text" onkeypress="return event.charCode>=48 && event.charCode<=57" id="marzo"      name="marzo"      value="<?= $valores->marzo ?>"      size="3" readonly></td>
                <td><input type="text" onkeypress="return event.charCode>=48 && event.charCode<=57" id="abril"      name="abril"      value="<?= $valores->abril ?>"      size="3" readonly></td>
                <td><input type="text" onkeypress="return event.charCode>=48 && event.charCode<=57" id="mayo"       name="mayo"       value="<?= $valores->mayo ?>"       size="3" readonly></td>
                <td><input type="text" onkeypress="return event.charCode>=48 && event.charCode<=57" id="junio"      name="junio"      value="<?= $valores->junio ?>"      size="3" readonly></td>
                <td><input type="text" onkeypress="return event.charCode>=48 && event.charCode<=57" id="julio"      name="julio"      value="<?= $valores->julio ?>"      size="3" readonly></td>
                <td><input type="text" onkeypress="return event.charCode>=48 && event.charCode<=57" id="agosto"     name="agosto"     value="<?= $valores->agosto ?>"     size="3" readonly></td>
                <td><input type="text" onkeypress="return event.charCode>=48 && event.charCode<=57" id="septiembre" name="septiembre" value="<?= $valores->septiembre ?>" size="3" readonly></td>
                <td><input type="text" onkeypress="return event.charCode>=48 && event.charCode<=57" id="octubre"    name="octubre"    value="<?= $valores->octubre ?>"    size="3" readonly></td>
                <td><input type="text" onkeypress="return event.charCode>=48 && event.charCode<=57" id="noviembre"  name="noviembre"  value="<?= $valores->noviembre ?>"  size="3" readonly></td>
                <td><input type="text" onkeypress="return event.charCode>=48 && event.charCode<=57" id="diciembre"  name="diciembre"  value="<?= $valores->diciembre ?>"  size="3" readonly></td>
                <td><?= $valores->total_bien ?> </td>
                <td>
                
              </form>
                </td> 
              </tr>
              <?php } ?>

          
              <tr>
                <th scope="row">TOTAL</th>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td><?=$total_suma?></td>
                <td></td>
              </tr>
          </tbody>
        </table>
        <br><br>
        <center><h2>Correcciones u observaciones a destacar</h2></center>
        <form action="" method="POST">
          <textarea class="form-control form-control--edit2"id="observacion_ficha"    value="<?=$datos->observacion_secpla?>" name="observacion_ficha" rows="3" required=required ><?=$datos->observacion_secpla?></textarea>
           <input type="text" id="id_estado_s"  style="display: none;"  name="id_estado_s"  value="3" size="2">
           <br><br>
          <div class="row">
              <div class="col">
                  <div class="btn-admi-post">
                      <input type="submit" name="corregir_ficha" id="corregir_ficha" tabindex="4" class="btn btn-warning"  style="float : left;" value="Enviar a corrección">
                  </div>
              </div>
        </form>
        
          <div class="col">
          <td><form action="" method="POST">
              <input type="text" id="id_detalle_ficha"  style="display: none;"  name="id_detalle_ficha"  value="<?=$id_detalle_ficha?>" size="2" >  
              <input type="text" id="ficha_estado_aprobado"  style="display: none;"  name="ficha_estado_aprobado"  value="5" size="2">
              <a href="ficha_aprobada.php?id_ficha=<?=$datos->id_ficha?>"><input type="submit" name="ficha_aceptada" id="ficha_aceptada" onclick="return advertencia()" tabindex="4" class="btn btn-success"  style="float : right;" value="Aceptar ficha"></a>
              </form>
          </td>
     
          </div>
              
              
            </div>


               
      </div>   
      </div> 
      <br><br><br>

  </div>
</body>

</html>
<script>
    function advertencia() {
    var not=confirm("¿Quiere aceptar esta ficha?");
    return not; 
  }
</script>