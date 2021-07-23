<?php 
$id_usuario = isset($_GET['id_usuario']) ? $_GET['id_usuario'] : '';
$id_moneda = isset($_GET['id_moneda']) ? $_GET['id_moneda'] : '';
$url = 'http://localhost:5000/api/usuario_tiene_moneda/'.$id_usuario.'/'.$id_moneda;
$conexion = curl_init();
curl_setopt($conexion, CURLOPT_CUSTOMREQUEST, 'DELETE');
curl_setopt($conexion, CURLOPT_URL ,$url);
curl_setopt($conexion, CURLOPT_HTTPGET, false);
$respuesta = curl_exec($conexion);
curl_close($conexion);
header('Location: ../../../api/templates/usuario_tiene_moneda.html');
?>