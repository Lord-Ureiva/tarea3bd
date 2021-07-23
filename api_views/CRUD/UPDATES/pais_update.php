<?php 

$nombre = isset($_POST['name']) ? $_POST['name'] : '';
$id = isset($_GET['id']) ? $_GET['id'] : '';

$url = 'http://localhost:5000/api/pais/'.$id;

$ch = curl_init($url);

$data = array(
    'nombre' => $nombre
);


$payload = json_encode($data);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($payload)));
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
curl_setopt($ch, CURLOPT_POSTFIELDS,$payload);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response  = curl_exec($ch);
curl_close($ch);

header('Location: ../../../api/templates/pais.html');

?>