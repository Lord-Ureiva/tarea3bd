<?php
include '../../user/sesion_iniciada.php';
include "paises_get_list.php";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'localhost:5000/api/usuario/');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$data = curl_exec($ch);

//$data = json_decode(file_get_contents('http://localhost:5000/api/usuario/'));
$data = json_decode($data,true);
$jsonarray = $data["usuarios"];

//$paises_list = include "paises_get_list.php";
$html_text = "";
$cont = 0;
foreach($jsonarray as $datos){
   $contraseña_a_mostrar = $datos['contraseña'];
   #If solo para diferencias contraseñas que esten hasheadas y las que no de los datos previamente cargados sin hash
   if(strlen($contraseña_a_mostrar) >=20){
      $contraseña_a_mostrar = substr($contraseña_a_mostrar,0,20)."...";
   }
   $html_text.= '<tr>
    <td>'.$datos['id'].'</td>
    <td>'.$datos['nombre'].'</td>
    <td>'.$datos['apellido'].'</td>
    <td>'.$datos['pais'].'</td>
    <td>'.$datos['correo'].'</td>
    <td>'.$contraseña_a_mostrar.'</td>
    <td>'.$datos['fecha_registro'].'</td>
      <td>
      <div class="contaner">
         <div class="btn-group btn-group-xs">
         <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#myModal'.$datos['id'].'">Editar 
         <i>
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-counterclockwise" viewBox="0 0 16 16">
          <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z"/>
          <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z"/>
          </svg>
         </i>
        </button>
        
        <!-- The Modal -->
        <div class="modal fade" id="myModal'.$datos['id'].'">
          <div class="modal-dialog">
            <div class="modal-content">
        
              <!-- Modal Header -->
              <div class="modal-header">
                <h4 class="modal-title">Editar Usuario</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
        
              <!-- Modal body -->
              <div class="modal-body">
              <div class="container shadow-sm rounded m-auto p-2">
              
              <form action="../../api_views/CRUD/UPDATES/usuarios_update.php?id='.$datos['id'].'" method="post">
              <div class="form-group">
              <label for="name">Nombre</label>
              <input type="text" class="form-control" placeholder="Nombre" name="name" required>
          </div>
          <div class="form-group">
              <label for="surname">Apellido</label>
              <input type="text" class="form-control" placeholder="Apellido" name="surname">
          </div>
          <div class="form-group">
              <label for="email">Correo Electrónico</label>
              <input type="email" class="form-control" placeholder="correo@electronico.com" name="email" required>
          </div>
          <div class="form-group">
              <label for="pwd">Contraseña</label>
              <input type="password" class="form-control" placeholder="Contraseña" name="pwd" required>
          </div>
          <div class="form-group">
              <label for="country">País</label>
              <select class="form-control" name="country"> '.$final_string.'
              </select>
            </div>
          <!-- NOTA: Los valores están en duro para esta tarea. -->
          
          <div class="d-flex justify-content-end">
              <button type="submit" class="btn btn-primary">Editar Usuario</button>
          </div>
        </form>
</div>
</div>              
</div>
</div>
</div>


            <a href="../../api_views/CRUD/DELETES/usuarios_delete.php?id='.$datos['id'].'"><button value="Borrar" title="Borrar" class="btn btn-danger">
            <i>
                     <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                     <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                     <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                     </svg>
          </i>
          </button></a>
         </div>
      </div>
      </td>
   </tr>';
   $cont +=1;
}

echo $html_text;
curl_close($ch);
?>