<?php
$url = 'http://localhost:5000/api/cuenta_bancaria/';

$id_usuario = isset($_POST['id_usuario']) ? $_POST['id_usuario'] : '';
$balance = isset($_POST['balance']) ? $_POST['balance'] : '';

$ch = curl_init($url);

$data = array(
    'id_usuario' => $id_usuario,
    'balance' => $balance
);

$payload = json_encode($data);

curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type>application/json'));
///curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_exec($ch);
curl_close($ch);
header('Location: ../../../api/templates/cuenta_bancaria.html');


?>