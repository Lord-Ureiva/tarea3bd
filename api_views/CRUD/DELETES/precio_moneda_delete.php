<?php 
$id_moneda = isset($_GET['id_moneda']) ? $_GET['id_moneda'] : '';
$fecha = isset($_GET['fecha']) ? $_GET['fecha'] : '';

$fecha = str_replace(" ","%20",$fecha);
$url = 'http://localhost:5000/api/precio_moneda/'.$id_moneda.'/'.$fecha;
$conexion = curl_init();
curl_setopt($conexion, CURLOPT_CUSTOMREQUEST, 'DELETE');
curl_setopt($conexion, CURLOPT_URL ,$url);
curl_setopt($conexion, CURLOPT_HTTPGET, false);
$respuesta = curl_exec($conexion);
curl_close($conexion);
header('Location: ../../../api/templates/precio_moneda.html');
?>