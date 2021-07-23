<?php

$nombre = isset($_POST['name']) ? $_POST['name'] : '';
$sigla = isset($_POST['sigla']) ? $_POST['sigla'] : '';


$url = 'http://localhost:5000/api/moneda/';

$ch = curl_init($url);

$data = array(
    'nombre' => $nombre,
    'sigla' => $sigla,
);

$payload = json_encode($data);

curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type>application/json'));
///curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_exec($ch);
curl_close($ch);
header('Location: ../../../api/templates/moneda.html');

?>