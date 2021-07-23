<?php 

$id = isset($_GET['id']) ? $_GET['id'] : '';
$nombre = isset($_POST['name']) ? $_POST['name'] : '';
$sigla = isset($_POST['sigla']) ? $_POST['sigla'] : '';

$url = 'http://localhost:5000/api/moneda/'.$id;

$ch = curl_init($url);

$data = array(
    'nombre' => $nombre,
    'sigla' => $sigla
);


$payload = json_encode($data);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($payload)));
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
curl_setopt($ch, CURLOPT_POSTFIELDS,$payload);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response  = curl_exec($ch);
curl_close($ch);

header('Location: ../../../api/templates/moneda.html');

?>