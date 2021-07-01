<?php
/* Este archivo debe validar los datos de registro y manejar la lógica de crear un usuario desde el formulario de registro */
include $_SERVER['DOCUMENT_ROOT'].'/db_config.php';


$nombre = isset($_POST['name']) ? $_POST['name'] : '';
$apellido = isset($_POST['surname']) ? $_POST['surname'] : '';
$correo = isset($_POST['email']) ? $_POST['email'] : '';
$password = isset($_POST['pwd']) ? $_POST['pwd'] : '';
$password2 = isset($_POST['pwd2']) ? $_POST['pwd2'] : '';
$pais = isset($_POST['country']) ? $_POST['country'] : '';

if($password == $password2){
  
    $comprobar_mail = pg_query_params($dbconn,"SELECT correo FROM usuario WHERE correo =$1",array($correo));
    $fila= pg_fetch_row($comprobar_mail);
    echo "aaaa";
    if(!$fila){
        $opciones = array('cost'=>12);
        $password = password_hash($password,PASSWORD_BCRYPT,$opciones);
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

        $envio = pg_query_params($dbconn, $consulta, array($nombre,$apellido,$correo,$password,$pais));
        if($envio){
            header("Location: log-in.html");
            //echo 'Tu cuenta ha sido creada, serás redireccionado en 5 segundos para que puedas logearte. Si no quieres esperar, haz click <a href="../index.html">aquí</a>.';
        }else{
            header("refresh:5;url=sign-up.html");
            echo "BAD ENDING Inténtalo nuevamente.";
        }

    }else{
        header("refresh:5;url=sign-up.html");
        echo "El Coreo ingresado Ya existe, por favor ingresa uno distinto.";
        }

}else{
    header("refresh:5;url=sign-up.html");
    echo "BAD Try Las Contraseñas no son iguales :/. Por Favor Reintenta";
}
pg_close($dbconn)

?>