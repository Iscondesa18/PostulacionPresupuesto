<?php 
header("Pragma: public");
header("Expires: 0");
$filename = "Fichas resumen gastos.xls";
header("Content-type: application/x-msdownload");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

?>
<head>
<meta charset="utf-8">
</head>
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
                                    WHERE estado_ficha.id_estado_ficha = 5");
                                        ?>

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