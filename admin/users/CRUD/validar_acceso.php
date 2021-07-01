<?php
include $_SERVER['DOCUMENT_ROOT'].'/db_config.php';
if(!isset($_SESSION['user'])){
    header("Location: ../../index.html" );
}

$idt = $_SESSION["id"];
$result = pg_query_params	($dbconn,'SELECT admin FROM usuario WHERE id=$1',array($idt));
$row = pg_fetch_array($result);

if($row["admin"] == 'f'){
    header("Location: ../../index.html" );
}
?>