<?php
include '../../user/sesion_iniciada.php';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'localhost:5000/api/precio_moneda/');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$data = curl_exec($ch);
$data = json_decode($data,true);

$jsonarray = $data['precio_moneda'];
//Contador para hacer que los modals sean distintos unos de otros.
$i=0;
foreach($jsonarray as $datos){
   echo '<tr>
      <td>'.$datos['id_moneda'].'</td>
      <td>'.$datos['fecha'].'</td>
      <td>'.$datos['valor'].'</td>
      <td>
      <div class="contaner">
         <div class="btn-group btn-group-xs">
         <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#myModal'.$datos['id_moneda'].'-'.$i.'">Editar 
         <i>
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-counterclockwise" viewBox="0 0 16 16">
          <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z"/>
          <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z"/>
          </svg>
         </i>
        </button>
        
        <!-- The Modal -->
        <div class="modal fade" id="myModal'.$datos['id_moneda'].'-'.$i.'">
          <div class="modal-dialog">
            <div class="modal-content">
        
              <!-- Modal Header -->
              <div class="modal-header">
                <h4 class="modal-title">Editar Valor</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
        
              <!-- Modal body -->
              <div class="modal-body">
              <div class="container shadow-sm rounded m-auto p-2">
                  <form action="../../api_views/CRUD/UPDATES/precio_moneda_update.php?id_moneda='.$datos['id_moneda'].'&fecha='.$datos['fecha'].'" method="post">
                     <div class="form-group">
                        <label for="name">Valor</label>
                        <input type="text" class="form-control" placeholder="Valor" name="valor" required>
                     </div>
               <div class="d-flex justify-content-end">
                  <button type="submit" class="btn btn-primary">Editar Valor</button>
        </div>
      </form>
</div>
</div>              
</div>
</div>
</div>

            <a href="../../api_views/CRUD/DELETES/precio_moneda_delete.php?id_moneda='.$datos['id_moneda'].'&fecha='.$datos['fecha'].'"><button value="Borrar" title="Borrar" class="btn btn-danger">
            <i>
                     <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                     <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                     <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                     </svg>
          </i>
          </button>
         </div>
      </div>
      </td>
   </tr>';
   $i+=1;
}
?>