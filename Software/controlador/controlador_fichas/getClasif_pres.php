<?php

require '../../modelo/conexion_bd.php';
$codigo = $_POST["clasif_pres"];

$sql = $conexion -> query("SELECT clasificacion_presu, nombre_cuenta FROM clasificador_presupuestario WHERE clasificacion_presu LIKE ? ORDER BY clasificacion_presu ASC");

$query ->execute([$codigo . '%']);
$html ="";
while ($row = $query ->fetch(PDO::FETCH_ASSOC)) {
    $html.="<li>".$row["clasificacion_presu"]." - ".$row["nombre_cuenta"]. "</li>";
}
echo json_encode($html, JSON_UNESCAPE_UNICODE);




?>