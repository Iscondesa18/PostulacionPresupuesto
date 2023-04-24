<?php
if (!empty($_GET["id_direccion"])) {
    $id_direccion=$_GET["id_direccion"];
    $sql=$conexion->query("delete from direccion where id_direccion = $id_direccion");
    if ($sql==true) {
        echo '<div class="alert alert-success" >Usuario eliminado correctamente</div>';
    
    } else { 
    
    echo '<div class="alert alert-danger" >ERROR</div>';
    
    
    
     }
     ?>
  <script>
    setTimeout(()=>{
        window.history.replaceState(null,null,window.location.pathname);
    }, 0);
  </script>
<?php


}