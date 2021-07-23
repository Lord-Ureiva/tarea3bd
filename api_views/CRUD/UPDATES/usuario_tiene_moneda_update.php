<?php 
$idusuario = isset($_GET['idusuario']) ? $_GET['idusuario'] : '';
$idmoneda = isset($_GET['idmoneda']) ? $_GET['idmoneda'] : '';
$balance = isset($_POST['balance']) ? $_POST['balance'] : '';

$url = 'http://localhost:5000/api/usuario_tiene_moneda/'.$idusuario.'/'.$idmoneda;

$ch = curl_init($url);

$data = array(
    'balance' => $balance
);

$payload = json_encode($data);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($payload)));
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
curl_setopt($ch, CURLOPT_POSTFIELDS,$payload);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response  = curl_exec($ch);
curl_close($ch);
header('Location: ../../../api/templates/usuario_tiene_moneda.html');
?>