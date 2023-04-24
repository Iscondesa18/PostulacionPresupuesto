<?php
  $id_ficha= $_GET["id_ficha"];
  if(!empty($_POST["ficha_gc_update"])){
      if (empty($_POST["name_ficha"]) or empty($_POST["monto_soli"])or empty($_POST["justificacion"])) {
          echo '<div class="alert alert-danger" style="text-align: center;" >POR FAVOR COMPLETE TODOS LOS CAMPOS</div>';
      } else {
          $name_ficha         =$_POST["name_ficha"];
          $monto_soli         =$_POST["monto_soli"];
          $justificacion      =$_POST["justificacion"];
          $descripcion        =$_POST["desc_ficha"];
          $id_direccion       =$_SESSION["id_direccion"];
          $id_usuario         =$_SESSION["id"];
          $id_detalle_ficha   =$_POST["id_detalle"];
          $sql=$conexion->query("UPDATE ficha set nombre_ficha ='$name_ficha', financiamiento_solicitado='$monto_soli', justificacion_gasto ='$justificacion'  where id_ficha=$id_ficha");
          $sql=$conexion->query("UPDATE detalle_ficha set desc_prod_resul ='$descripcion' where id_detalle_ficha = $id_detalle_ficha");
          if ($sql==1) {
              echo '<div class="alert alert-success" >Ficha modificada correctamente</div>';
          } else {
              echo '<div class="alert alert-danger" >ERROR</div>';
          }   
      }
  }
  if(!empty($_POST["actualizar_estado"])){
    if (empty($_POST["id_estado"])) {
        echo '<div class="alert alert-danger" style="text-align: center;" >POR FAVOR COMPLETE TODOS LOS CAMPOS</div>';
    } else {
        $id_estado_ficha         =$_POST["id_estado"];
        $sql=$conexion->query("UPDATE ficha set id_estado_ficha=$id_estado_ficha, fecha_presentacion= NOW() where id_ficha=$id_ficha");
        if ($sql==1) {
            echo '<div class="alert alert-success" >Ficha enviada</div>';

        } else {
            echo '<div class="alert alert-danger" >ERROR</div>';
        }   
    }
}


if(!empty($_POST["corregir_ficha"])){
    if (empty($_POST["id_estado_s"])or empty($_POST["observacion_ficha"])) {
        echo '<div class="alert alert-danger" style="text-align: center;" >POR FAVOR COMPLETE TODOS LOS CAMPOS</div>';
    } else {
        $obs_secpla         =$_POST["observacion_ficha"];
        $id_estado_ficha         =$_POST["id_estado_s"];
        $sql=$conexion->query("UPDATE ficha set id_estado_ficha=$id_estado_ficha, observacion_secpla='$obs_secpla' where id_ficha=$id_ficha");
        if ($sql==1) {
            echo '<div class="alert alert-success" >Retroalimentación enviada</div>';

        } else {
            echo '<div class="alert alert-danger" >ERROR</div>';
        }   
    }
}


if(!empty($_POST["ficha_aceptada"])){
    if (empty($_POST["ficha_estado_aprobado"])) {
        echo '<div class="alert alert-danger" style="text-align: center;" >POR FAVOR COMPLETE TODOS LOS CAMPOS</div>';
    } else {
        $id_detalle_ficha         =$_POST["id_detalle_ficha"];
        $id_estado_ficha         =$_POST["ficha_estado_aprobado"];
        $sql=$conexion->query("UPDATE ficha set id_estado_ficha=$id_estado_ficha where id_ficha=$id_ficha");
        if ($sql==1) {

            header("location:ficha_aprobada.php?id_ficha=$id_ficha");
        } else {
            echo '<div class="alert alert-danger" >ERROR</div>';
        }   
    }
}


?>