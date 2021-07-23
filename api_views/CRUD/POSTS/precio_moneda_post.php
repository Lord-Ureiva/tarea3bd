<?php
$id_moneda = isset($_POST['id_moneda']) ? $_POST['id_moneda'] : '';
$valor = isset($_POST['valor']) ? $_POST['valor'] : '';

$url = 'http://localhost:5000/api/precio_moneda/';


$ch = curl_init($url);

$data = array(
    'id_moneda' => $id_moneda,
    'valor' => $valor,
);

$payload = json_encode($data);

curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type>application/json'));
///curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_exec($ch);
curl_close($ch);
header('Location: ../../../api/templates/precio_moneda.html');


?>