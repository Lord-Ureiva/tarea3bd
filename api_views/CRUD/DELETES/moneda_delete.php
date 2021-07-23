<?php 
$id = isset($_GET['id']) ? $_GET['id'] : '';
$url = 'http://localhost:5000/api/moneda/'.$id;
$conexion = curl_init();
curl_setopt($conexion, CURLOPT_CUSTOMREQUEST, 'DELETE');
curl_setopt($conexion, CURLOPT_URL ,$url);
curl_setopt($conexion, CURLOPT_HTTPGET, false);
$respuesta = curl_exec($conexion);
curl_close($conexion);
header('Location: ../../../api/templates/moneda.html');

?>