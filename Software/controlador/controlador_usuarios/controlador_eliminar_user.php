<?php
if (!empty($_GET["id"])) {
    $id=$_GET["id"];
    $sql=$conexion->query("delete from usuario where id = $id");
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

