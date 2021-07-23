<?php 
$id = isset($_GET['id']) ? $_GET['id'] : '';
$nombre = isset($_POST['name']) ? $_POST['name'] : '';
$apellido = isset($_POST['surname']) ? $_POST['surname'] : '';
$correo = isset($_POST['email']) ? $_POST['email'] : '';
$pwd = isset($_POST['pwd']) ? $_POST['pwd'] : '';
$pais = isset($_POST['country']) ? $_POST['country'] : '';

$opciones = array('cost'=>12);
$password = password_hash($pwd,PASSWORD_BCRYPT,$opciones);

$url = 'http://localhost:5000/api/usuario/'.$id;

$ch = curl_init($url);

$data = array(
    'apellido' => $apellido,
    'contraseña' => $password,
    'correo' => $correo,
    'nombre' => $nombre,
    'pais' => $pais
);


$payload = json_encode($data);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($payload)));
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
curl_setopt($ch, CURLOPT_POSTFIELDS,$payload);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response  = curl_exec($ch);
curl_close($ch);
header('Location: ../../../api/templates/usuarios.html');
?>