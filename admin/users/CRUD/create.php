<?php
/* Este archivo debe manejar la lógica para crear un usuario como admin */
include $_SERVER['DOCUMENT_ROOT'].'/db_config.php';

$nombre = isset($_POST['name']) ? $_POST['name'] : '';
$apellido = isset($_POST['surname']) ? $_POST['surname'] : '';
$correo = isset($_POST['email']) ? $_POST['email'] : '';
$pwd = isset($_POST['pwd']) ? $_POST['pwd'] : '';
$pais = isset($_POST['country']) ? $_POST['country'] : '';

$opciones = array('cost'=>12);
$pwd = password_hash($pwd,PASSWORD_BCRYPT,$opciones);

$consulta = "INSERT 
    INTO usuario(nombre,apellido,correo,contraseña,pais,fecha_registro,admin)
    VALUES(
        $1,
        $2,
        $3,
        $4,
        $5,
        (SELECT NOW()),
        false)";

$envio = pg_query_params($dbconn, $consulta, array($nombre,$apellido,$correo,$pwd,$pais));
pg_close($dbconn);
header('Location: ../all.html');
?>