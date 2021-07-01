<?php
/* Este archivo debe manejar la lógica de cerrar una sesión */
session_start();
//Matamos la sesion
session_destroy();
header( "Location: ../index.html" );
//echo 'Haz cerrado sesión con éxito.<br /><br />';
//echo 'Serás redireccionado en 2 segundos.';
?>