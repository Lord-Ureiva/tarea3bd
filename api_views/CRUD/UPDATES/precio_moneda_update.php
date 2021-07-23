<?php 

$id_moneda = isset($_GET['id_moneda']) ? $_GET['id_moneda'] : '';
$fecha = isset($_GET['fecha']) ? $_GET['fecha'] : '';
$valor = isset($_POST['valor']) ? $_POST['valor'] : '';

$fecha = str_replace(" ","%20",$fecha);

$url = 'http://localhost:5000/api/precio_moneda/'.$id_moneda.'/'.$fecha;

$ch = curl_init($url);

$data = array(
    'valor' => $valor
);

$payload = json_encode($data);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($payload)));
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
curl_setopt($ch, CURLOPT_POSTFIELDS,$payload);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response  = curl_exec($ch);
curl_close($ch);
header('Location: ../../../api/templates/precio_moneda.html');
?>