<?php
include $_SERVER['DOCUMENT_ROOT'].'/db_config.php';
session_start();

// Separa entre si estás conectado o no.
if(isset($_SESSION["user"])) {

    $id = $_SESSION["id"];
    $result = pg_query_params($dbconn,'SELECT admin FROM usuario WHERE id=$1',array($id));
    $row = pg_fetch_array($result);

   echo '<ul class="navbar-nav">
            <!-- Visible solo si hay una sesión iniciada -->
            <li class="nav-item">
                <a class="nav-link" href="/user/profile.html">Perfil</a>
            </li>';
   

    if($row["admin"] == 'f'){
            echo '<!-- Solo los usuarios tienen billetera -->
            <li class="nav-item">
                
                
                <a class="nav-link" href="/user/wallet.html">Billetera</a>
            </li>';
    }
    echo '   <!-- Visible solo si hay una sesión iniciada -->
            <li class="nav-item">
            <a class="nav-link" href="../../../api_views/center.html">API</a>
            </li>';

// Si el usuario en cuestión es Administrador, entonces podrá ver la página CRUD
    if($row["admin"] == 't'){
        echo '<!-- Solo el admin puede revisar los usuarios -->
            <li class="nav-item">
                <a class="nav-link" href="/admin/users/all.html">Usuarios</a>
            </li>';
    }
    
    echo    '</ul>
        <ul class="navbar-nav ml-auto">
            <!-- Visible solo si hay una sesión iniciada -->
            <li class="nav-item">
                <a class="nav-link" href="/sesion/logout.php">Cerrar Sesión</a>
            </li>
        </ul>' ;
}
else{
   echo '<ul class="navbar-nav ml-auto">
            <!-- Visible solo si NO hay una sesión iniciada -->
            <li class="nav-item">
                <a class="nav-link" href="/sesion/log-in.html">Iniciar Sesión</a>
            </li>
            <!-- Visible solo si NO hay una sesión iniciada -->
            <li class="nav-item">
                <a class="nav-link" href="/sesion/sign-up.html">Registrarse</a>
            </li>
        </ul>';
}
pg_close($dbconn)

/* Este archivo debe usarse para comprobar si existe una sesión válida 
   Considerar qué pasa cuando la sesión es válida/inválida para cada página:
   - Página principal
   - Mi perfil
   - Mi billetera
   - Administración de usuarios y todo el CRUD
   - Iniciar Sesión
   - Registrarse
*/
?>