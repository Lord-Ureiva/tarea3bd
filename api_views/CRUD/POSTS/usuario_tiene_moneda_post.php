<?php

$idusuario = isset($_POST['idusuario']) ? $_POST['idusuario'] : '';
$idmoneda = isset($_POST['idmoneda']) ? $_POST['idmoneda'] : '';
$balance = isset($_POST['balance']) ? $_POST['balance'] : '';

$url = 'http://localhost:5000/api/usuario_tiene_moneda/';

$ch = curl_init($url);

$data = array(
    'balance' => $balance,
    'id_moneda' => $idmoneda,
    'id_usuario' => $idusuario,
);

$payload = json_encode($data);

curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type>application/json'));
///curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_exec($ch);
curl_close($ch);
header('Location: ../../../api/templates/usuario_tiene_moneda.html');

?>