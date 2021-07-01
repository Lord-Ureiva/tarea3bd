<?php
if($_SESSION['admin'] == 't'){
    header("Location: ../../index.html" );
}
include $_SERVER['DOCUMENT_ROOT'].'/db_config.php';
/* Este archivo debe manejar la lógica para obtener la información de la billetera */
$id = $_SESSION['id'];
$sql = "SELECT DISTINCT ON (a.sigla) a.sigla, a.nombre, a.balance, precio_moneda.valor
        FROM (SELECT usuario_tiene_moneda.id_usuario, moneda.id, moneda.sigla, moneda.nombre, usuario_tiene_moneda.balance
            FROM usuario_tiene_moneda INNER JOIN moneda
            ON usuario_tiene_moneda.id_moneda = moneda.id) as a INNER JOIN precio_moneda
        ON a.id = precio_moneda.id_moneda
        WHERE a.id_usuario = $1
        ORDER BY a.sigla, precio_moneda.fecha DESC NULLS LAST";
$consulta = pg_query_params($dbconn, $sql,array($id));
/* Comprobar la consulta */

if(!$consulta){
    echo "Error al realizar la consulta.\n";

}else{
    while($fila = pg_fetch_row($consulta)){
        echo '<tr>';
        echo '<td>'. $fila[0]. '</td>';
        echo '<td>'. $fila[1]. '</td>';
        echo '<td>'. $fila[2]. '</td>';
        echo '<td>'. $fila[3]. ' USD </td>';
        echo '<td>'. $fila[3] * $fila[2]. ' USD </td>';
        echo '</tr>';
    }
}
pg_close($dbconn);
?>