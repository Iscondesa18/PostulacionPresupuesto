<?php
    
if(!empty($_POST["recomendar_bien_secpla"])){
    if (empty($_POST["id_servicio_secpla"]) ) {
        echo '<div class="alert alert-danger" style="text-align: center;" >POR FAVOR COMPLETE TODOS LOS CAMPOS</div>';
    } else {
        $id_servicio_secpla =$_POST["id_servicio_secpla"];
        $bi_serv          =$_POST["bi_serv"];
        $cantidad         =$_POST["cantidad"];
        $valor_unitario   =$_POST["valor_unitario"];
        $clasif_pres      =$_POST["clasif_pres"];
        $observaciones    =$_POST["observaciones"];
        $a_gestion        =$_POST["a_gestion"];
        
        $sql=$conexion->query("UPDATE bien_servicio_secpla SET bien_servi_secpla = '$bi_serv', cantidad_bien_sec = '$cantidad', valor_unitario = '$valor_unitario', observaciones = '$observaciones', id_area_gestion = '$a_gestion',clasi_presu = '$clasif_pres' WHERE bien_servicio_secpla.id_servicio_secpla ='$id_servicio_secpla'");
        if ($sql==1) {
            
            echo '<div class="alert alert-success" >Fila añadida correctamente</div>';
        } else {
            echo '<div class="alert alert-danger" >ERROR</div>';
        }   
    }

}
?>