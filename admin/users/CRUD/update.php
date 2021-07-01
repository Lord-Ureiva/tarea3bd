<?php
include $_SERVER['DOCUMENT_ROOT'].'/db_config.php';

$id = isset($_POST['id']) ? $_POST['id'] : '';
$nombre = isset($_POST['name']) ? $_POST['name'] : '';
$apellido = isset($_POST['surname']) ? $_POST['surname'] : '';
$correo = isset($_POST['email']) ? $_POST['email'] : '';
$pwd = isset($_POST['pwd']) ? $_POST['pwd'] : '';
$pais = isset($_POST['country']) ? $_POST['country'] : '';

$opciones = array('cost'=>12);
$pwd = password_hash($pwd,PASSWORD_BCRYPT,$opciones);

$consulta = 
"UPDATE usuario
SET nombre = $1, apellido = $2, correo = $3, contraseña = $4, pais = $5
WHERE id =$6";
$enviar = pg_query_params($dbconn,$consulta, array($nombre, $apellido, $correo, $pwd, $pais, $id));

pg_close($dbconn);
header('Location: ../all.html');

?>