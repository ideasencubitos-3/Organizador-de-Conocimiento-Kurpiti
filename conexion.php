<?php
$conexion = mysqli_connect("localhost", "root", "")or die("No se pudo conectar: ".mysqli_connect_error()); //local 
mysqli_set_charset($conexion, "utf8");
mysqli_select_db($conexion, "kurpiti")or die("No se encontro base de datos: ".mysqli_error($conexion));
?>
