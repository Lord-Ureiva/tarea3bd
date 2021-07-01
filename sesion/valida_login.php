<?php 
/* Este archivo debe manejar la lógica de iniciar sesión */
include '../db_config.php';
session_start();
$sesion = 0;

if($_SERVER["REQUEST_METHOD"] == "POST") {

if(!empty($_POST["email"]) && !empty($_POST["pwd"])){
 $email = $_POST["email"];
 $password = $_POST["pwd"];
 $result = pg_query_params($dbconn,'SELECT id, nombre, apellido, correo, contraseña, "admin" FROM usuario WHERE correo=$1',array($email));
 if($row = pg_fetch_array($result)){
  if(password_verify($password,$row[4])){
      //Llenar de datos el array $_SESSION para su uso posterior.
   $_SESSION["user"] = $row["nombre"];
   $_SESSION["id"] = $row['id'];
   $_SESSION["admin"] = $row['admin'];

   echo 'Has sido logueado correctamente '.$_SESSION['user'].' <p>';
   $sesion= 1;
  }else{
   echo 'Password incorrecto';
  }
 }else{
  echo 'Email no existente en la base de datos';
 }
 pg_free_result($result);
}else{
 echo 'Debe especificar un email y password';
 
}
if($sesion == 1) {
  header( "Location: ../index.html" );
  //echo 'Serás redireccionado en 3 segundos. Si no quieres esperar, haz click <a href="../index.html">aquí</a>.';
}else{
    header("Location: log-in.html");
}

pg_close();

}

?>