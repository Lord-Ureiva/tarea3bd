<?php
/* Este archivo debe manejar la lógica de obtener los datos de todos los usuarios */
$consulta = pg_query($dbconn, "SELECT id, nombre, apellido, correo, admin FROM usuario ORDER BY id");
/* Comprobar la consulta */
if(!$consulta){
    echo "Error al realizar la consulta.\n";

}else{
    while($fila = pg_fetch_row($consulta)){
        if($fila[0] == $_SESSION["id"]){
            echo '<tr>';
        echo '<td>'. $fila[0]. '</td>';
        echo '<td>'. $fila[1]. '</td>';
        echo '<td>'. $fila[2]. '</td>';
        echo '<td>'. $fila[3]. '</td>';
        echo '<td><a href="/admin/users/read.html?id='.$fila[0].'" class="btn btn-primary">Ver <i
                            class="fas fa-search"></i></a>
                    <a href="/admin/users/update.html?id='.$fila[0].'" class="btn btn-warning">Editar <i
                            class="fas fa-edit"></i></a>
                    </td>';

        echo '</tr>';
        }else{
            echo '<tr>';
        
        echo '<td>'. $fila[0]. '</td>';
        echo '<td>'. $fila[1]. '</td>';
        echo '<td>'. $fila[2]. '</td>';
        echo '<td>'. $fila[3]. '</td>';
        echo '<td><a href="/admin/users/read.html?id='.$fila[0].'" class="btn btn-primary">Ver <i
                            class="fas fa-search"></i></a>
                    <a href="/admin/users/update.html?id='.$fila[0].'" class="btn btn-warning">Editar <i
                            class="fas fa-edit"></i></a>

                    
                    
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal'.$fila[0].'">
                            Borrar <i
                            class="fas fa-trash-alt"></i>
                          </button>
                          
                          <!-- The Modal -->
                          <div class="modal fade" id="myModal'.$fila[0].'">
                            <div class="modal-dialog">
                              <div class="modal-content">
                          
                                <!-- Modal Header -->
                                <div class="modal-header">
                                  <h4 class="modal-title">Borrar Usuario</h4>
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                          
                                <!-- Modal body -->
                                <div class="modal-body">
                                  ¿Estás seguro de que deseas borrar al usuario?
                                </div>
                          
                                <!-- Modal footer -->
                                <div class="btn right" >
                                    <a href="/admin/users/CRUD/delete.php?id='.$fila[0].'" class="btn btn-danger">Borrar <i
                                    class="fas fa-trash-alt"></i></a>
                                  <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                                </div>
                          
                              </div>
                            </div>
                          </div>

                    </td>';

        echo '</tr>';

        }
    }
}
pg_close($dbconn);
?>