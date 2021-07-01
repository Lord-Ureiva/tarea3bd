<?php
include $_SERVER['DOCUMENT_ROOT'].'/db_config.php';
session_start();
$id_user = $_SESSION["id"];
$result = pg_query_params($dbconn,'SELECT admin FROM usuario WHERE id=$1',array($id_user));
$row = pg_fetch_array($result);

$id = isset($_GET['id']) ? $_GET['id'] : '';
if($row["admin"]== 't'){
    if($id == $id_user){
        header('Location: ../all.html');
    }else{
        $consulta = "DELETE
        FROM usuario
        WHERE id = $1";
        $enviar = pg_query_params($dbconn,$consulta ,array($id));
        
        header('Location: ../all.html');
    }}
else{
    header('Location: ../all.html');
}
pg_close($dbconn);
?>