<?php
/* Este archivo debe manejar la lógica de obtener los datos de un determinado usuario */
$id = $_GET['id'];

$sql = "SELECT id, usuario.nombre, apellido, correo, pais.nombre, DATE(fecha_registro) 
        FROM usuario INNER JOIN pais ON usuario.pais = pais.cod_pais 
        WHERE id=$1";
$consulta = pg_query_params($dbconn,$sql,array($id));
$fila = pg_fetch_row($consulta);
echo "<p>ID: ". $fila[0]." </p>";
echo "<p>Nombre: ". $fila[1]." </p>";
echo "<p>Apellido: ". $fila[2]." </p>";
echo "<p>Correo: ". $fila[3]." </p>";
echo "<p>País: ". $fila[4]." </p>";
echo "<p>Fecha de Ingreso: ". $fila[5]." </p>";
if($fila[0] == $_SESSION["id"]){
  echo '<div class="d-flex justify-content-end">
         <a href="/admin/users/all.html" class="btn btn-secondary">Volver</a>
         <a href="/admin/users/update.html?id='. $fila[0].'" class="btn btn-warning mx-3">Editar <i class="fas fa-edit"></i></a>';  

}else{
  echo '<div class="d-flex justify-content-end">
         <a href="/admin/users/all.html" class="btn btn-secondary">Volver</a>
         <a href="/admin/users/update.html?id='. $fila[0].'" class="btn btn-warning mx-3">Editar <i class="fas fa-edit"></i></a>
         

         <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal">
                            Borrar <i
                            class="fas fa-trash-alt"></i>
                          </button>
                          
                          <!-- The Modal -->
                          <div class="modal fade" id="myModal">
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
         
     </div>';
}




pg_close($dbconn);
?>