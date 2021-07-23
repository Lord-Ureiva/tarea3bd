<?php 

$id_numero_cuenta = isset($_GET['id']) ? $_GET['id'] : '';
$balance = isset($_POST['balance']) ? $_POST['balance'] : '';
$id_usuario = isset($_GET['id_usuario']) ? $_GET['id_usuario'] : '';


$url = 'http://localhost:5000/api/cuenta_bancaria/'.$id_numero_cuenta;

$ch = curl_init($url);

$data = array(
    'balance' => $balance,
    'id_usuario' => $id_usuario
);


$payload = json_encode($data);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($payload)));
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
curl_setopt($ch, CURLOPT_POSTFIELDS,$payload);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response  = curl_exec($ch);
curl_close($ch);

header('Location: ../../../api/templates/cuenta_bancaria.html');

?>