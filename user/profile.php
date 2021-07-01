<?php
/* Este archivo debe manejar la lógica para obtener la información del perfil */
$id = $_SESSION['id'];

$consulta = pg_query("SELECT id, usuario.nombre, apellido, correo, pais.nombre, DATE(fecha_registro) FROM usuario INNER JOIN pais ON usuario.pais = pais.cod_pais WHERE id=".$id);
$fila = pg_fetch_row($consulta);
echo "<p>Nombre Completo: ".$fila[1]. " " .$fila[2]." </p>";
echo "<p>Correo: ". $fila[3]." </p>";
echo "<p>País: ". $fila[4]." </p>";
echo "<p>Fecha de Ingreso: ". $fila[5]." </p>";     
?>