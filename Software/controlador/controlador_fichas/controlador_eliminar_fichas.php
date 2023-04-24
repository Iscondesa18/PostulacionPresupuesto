<?php
if (!empty($_GET["id"])) {
    $id_ficha=$_GET["id"];
    $sql=$conexion->query("delete from ficha where id_ficha = $id_ficha");
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