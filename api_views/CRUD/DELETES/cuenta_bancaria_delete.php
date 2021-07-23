<?php 
$numero_cuenta = isset($_GET['numero_cuenta']) ? $_GET['numero_cuenta'] : '';
$url = 'http://localhost:5000/api/cuenta_bancaria/'.$numero_cuenta;
$conexion = curl_init();
curl_setopt($conexion, CURLOPT_CUSTOMREQUEST, 'DELETE');
curl_setopt($conexion, CURLOPT_URL ,$url);
curl_setopt($conexion, CURLOPT_HTTPGET, false);
$respuesta = curl_exec($conexion);
curl_close($conexion);
header('Location: ../../../api/templates/cuenta_bancaria.html');
?>