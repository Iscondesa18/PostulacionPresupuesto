
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
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
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

    <STYLE>
      ul{
        list-style-type: none ;


      }
    </STYLE>
</head><br><br>
<?php    #conexion controladores
  include("../../modelo/conexion_bd.php");
  include("../../controlador/controlador_fichas/controlador_registrar_ficha_gc.php");
  include("../../controlador/controlador_fichas/controlador_eliminar_bi_serv.php");  
  include("../../controlador/controlador_fichas/controlador_recomendado_ficha.php");  
  
?>
<?php #id_ficha              
  $id_ficha=$_GET['id_ficha'];
  $sql = $conexion -> query("SELECT * FROM ficha INNER JOIN direccion ON ficha.id_direccion =direccion.id_direccion INNER JOIN usuario on ficha.id = usuario.id INNER JOIN detalle_ficha on ficha.id_ficha=detalle_ficha.id_ficha where ficha.id_ficha=$id_ficha ");
  $datos= $sql ->fetch_object();
?>
<?php  #id_detalle_ficha
  
  $ficha = $conexion -> query("SELECT * FROM ficha INNER JOIN detalle_ficha ON ficha.id_ficha=detalle_ficha.id_ficha  where ficha.id_ficha = $id_ficha");
  $id_detalle_ficha=$ficha->fetch_object();
  $id_detalle_ficha=$id_detalle_ficha->id_detalle_ficha;
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

    $suma_sinformat =$conexion->query ("SELECT sum(cantidad_bien*valor_unitario) as total FROM `bien_servicio` where id_detalle_ficha =$id_detalle_ficha"); 
    $total_sinformat=$suma_sinformat->fetch_object();
    $total_sinformat=$total_sinformat->total;
?>
<?php //bien servicio secpla
  $bien = $conexion->query("SELECT bien_servicio_secpla.id_servicio_secpla,
                                bien_servicio_secpla.id_detalle_ficha,
                                bien_servicio_secpla.bien_servi_secpla,
                                bien_servicio_secpla.cantidad_bien_sec,
                                bien_servicio_secpla.valor_unitario,
                                format(bien_servicio_secpla.cantidad_bien_sec*bien_servicio_secpla.valor_unitario, 'G','en-US') as total_bien,
                                bien_servicio_secpla.observaciones,
                                bien_servicio_secpla.monto_recomendado,
                                bien_servicio_secpla.id_area_gestion,
                                areas_gestion.desc_area_gestion,
                                clasificador_presupuestario.clasificacion_presu, 
                                clasificador_presupuestario.nombre_cuenta 
                                FROM `bien_servicio_secpla` inner join areas_gestion on bien_servicio_secpla.id_area_gestion=areas_gestion.id_area_gestion inner join clasificador_presupuestario on clasificador_presupuestario.clasificacion_presu=bien_servicio_secpla.clasi_presu where id_detalle_ficha = $id_detalle_ficha ");
?>

<?php //bien servicio direccion
  $bien_direccion = $conexion->query("SELECT id_bien_servicio
                                id_detalle_ficha,
                                desc_bien_servi,
                                cantidad_bien,
                                format(valor_unitario, 'G','en-US') as valor_unitario,
                                format(cantidad_bien*valor_unitario, 'G','en-US') as total_bien
                              
                                FROM `bien_servicio` where id_detalle_ficha = $id_detalle_ficha ");
?>
<?php //suma_monto_recomendado
  $sum_recom = $conexion-> query("SELECT SUM(cantidad_bien_sec*valor_unitario) as total_recomendado FROM `bien_servicio_secpla` where id_detalle_ficha= $id_detalle_ficha");
  $suma_rec= $sum_recom->fetch_object();
  $suma_recomendada=$suma_rec->total_recomendado;
?>

<?php //monto solicitado
  $monto_soli = $conexion->query("SELECT ficha.id_ficha,
                                  format(ficha.financiamiento_solicitado, 'G','en-US') as financiamiento_soli,
                                  ficha.financiamiento_solicitado as financiamiento_solicitado
                                  FROM `detalle_ficha` 
                                  INNER JOIN ficha ON detalle_ficha.id_ficha=ficha.id_ficha
                                  WHERE detalle_ficha.id_detalle_ficha= $id_detalle_ficha");

  $solicitado= $monto_soli ->fetch_object();  

?>

<body  class='fondo'>
  <div  class="container_ver_ficha_aprobada">
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
          </div>
              <br><br>
        <center><h3>Destino de fondos (solicitados por la dirección)</h3></center>
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
                    while($bien_dire = $bien_direccion ->fetch_object()){ ?>
                <tr>
                <td><?= $bien_dire->desc_bien_servi ?></td>
                <td><?= $bien_dire->cantidad_bien ?></td>
                <td><?= $bien_dire->valor_unitario?> </td>
                <td><?= $bien_dire->total_bien?> </td>
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
        
        <center><h3>Destino de fondos (recomendados)</h3></center>
        <br><br><br>
          <div>
            <table class="table table-hover">
              <thead>
                <tr>
                  <th scope="col">Bien o servicio a adquirir</th>
                  <th scope="col">Cantidad</th>
                  <th scope="col">Valor unitario M$</th>
                  <th scope="col">Clasificación</th>
                  <th scope="col">Observaciones</th>
                  <th scope="col">Área de gestión</th>
                  <th scope="col">TOTAL</th>
                  <th scope="col">Acciones</th>
                </tr>
              </thead>
              <tbody>
   
                <?php
              while($bienes = $bien ->fetch_object()){ ?>
                <form action="" method="POST" autocomplete="off">
                  <tr>
                    <td style="display: none;"><input type="text"          id="id_servicio_secpla"name="id_servicio_secpla"       value="<?=  $bienes->id_servicio_secpla  ?>" ></td>
                    <td><textarea class="form-control form-control--edita" id="bi_serv"           name="bi_serv"          rows="3"><?= $bienes->bien_servi_secpla ?></textarea></td>
                    <td><input type="text"                                 id="cantidad"          name="cantidad"         onkeypress="return event.charCode>=48 && event.charCode<=57" size="2"value="<?= $bienes->cantidad_bien_sec ?>"></td>
                    <td><input type="text"                                 id="valor_unitario"    name="valor_unitario"   onkeypress="return event.charCode>=48 && event.charCode<=57" size="4"value="<?= $bienes->valor_unitario?>"></td>
                    <td>
                      <select class="custom-select"   name="clasif_pres" required= required  >
                        <option value="<?= $bienes->clasificacion_presu ?>"><?= $bienes->clasificacion_presu ?></option>
                          <?php
                            $query = $conexion -> query ("SELECT * FROM clasificador_presupuestario;");
                            while ($valores = mysqli_fetch_array($query)) {                       
                              echo '<option value="'.$valores['clasificacion_presu'].'">'.$valores['clasificacion_presu'].'</option>';
                            }
                          ?>
                      </select>
                    </td>
                    <td><textarea class="form-control form-control--edita" id="observaciones"     name="observaciones"    rows="3" ><?= $bienes->observaciones?> </textarea></td>
                    <td>
                      <select class="custom-select"   name="a_gestion" required= required  >
                        <option value="<?= $bienes->id_area_gestion ?>"><?= $bienes->desc_area_gestion ?></option>
                          <?php
                            $query = $conexion -> query ("SELECT * FROM areas_gestion;");
                            while ($area = mysqli_fetch_array($query)) {                       
                              echo '<option value="'.$area['id_area_gestion'].'">'.$area['desc_area_gestion'].'</option>';
                            }
                          ?>
                      </select>
                    </td>
                    <td><?= $bienes->total_bien?></td>
                    <td>
                  <input type="submit" name="recomendar_bien_secpla" tabindex="4" class="btn btn-success"  value="Guardar">
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
                  <td><?=$suma_recomendada?></td>
                  <td></td>
                </tr>
              </tbody>
            </table>
          </div>
  </div>
</body>
</html>



<script>//Mensaje de eiminar 
  function advertencia() {
    var not=confirm("¿Estas seguro que quieres eliminar?");
    return not;
    
  }
</script>
<script src="../../js/function.js"></script>

<script>//Validacion suma numeros para el total (Aún no funciona)
  $(function() {
    var suma = 0;
    var financiamiento_solicitado= 0;
    $("#calcula").click(function(){
      suma = <?=$total_sinformat?>;
      financiamiento_solicitado=<?=$solicitado->financiamiento_solicitado?>;
      if (suma != financiamiento_solicitado) {
        
    alert(financiamiento_solicitado );  
        
      }
    });

  });
  </script>
<script>
  function prueba(){
                var datos = $('#clasif_pres').val();
                var prueba = new String(datos);
 
                 if (prueba.length==16){
                    $('#clasif_pres').val(prueba.substring(0,3)+"-"+prueba.substring(3,5)+"-"+prueba.substring(5,7)+"-"+prueba.substring(7,10)+"-"+prueba.substring(10,13)+"-"+prueba.substring(13,16));
                }
            }
</script>
