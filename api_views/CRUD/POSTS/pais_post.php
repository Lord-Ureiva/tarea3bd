<?php 
$url = 'http://localhost:5000/api/pais/';

$nombre = isset($_POST['name']) ? $_POST['name'] : '';

$ch = curl_init($url);

$data = array(
    'nombre' => $nombre,
);

$payload = json_encode($data);

curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type>application/json'));
///curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_exec($ch);
curl_close($ch);
header('Location: ../../../api/templates/pais.html');


?>