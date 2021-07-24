<?php 
include '../../../include/navbar.html';
include '../../../user/sesion_iniciada.php';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://localhost:5000/api/pais/');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$data = curl_exec($ch);
$data = json_decode($data,true);
$jsonarray = $data['paises'];
$final_string = "";

foreach($jsonarray as $datos){
   $final_string .= '
   <option value="'.$datos['nombre'].'">'.$datos['nombre'].'</option>
   ';
}

echo '<div class="container shadow-sm rounded m-auto p-3">
<div>
   <h1>Descripción Consulta 3</h1>
   <p>
   Obtener todos los usuarios que pertenecen al país X.
   </p>
</div>
<form action="consulta_3.php" method="post">
    <!-- NOTA: Los valores están en duro para esta tarea. -->
    <div class="form-group">
        <label for="pais">País</label>
        <select class="form-control" name="pais">'.$final_string.'
        </select>
      </div>
    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-primary">Consultar</button>
    </div>
  </form>
</div>';

if(isset($_POST['pais'])){

   $ch = curl_init();
   $pais = $_POST['pais'];
   $pais_replace = str_replace(" ","%20",$pais);

   curl_setopt($ch, CURLOPT_URL, 'localhost:5000/api/consultas/3/'.$pais_replace);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   $data = curl_exec($ch);
   curl_close($ch);
   $data = json_decode($data,true);

   $jsonarray = $data["cuentas"];
   if($jsonarray  != NULL){
      echo '

      <div class="container shadow-sm rounded m-auto p-10 table-hover table-responsive-md">
         <div class="m-auto p-10 text-left">
         <h5 class="p-3">En el pais <b>'.$pais.'</b> están:</h5>
         </div>
      <div class="table-responsive">
      <table class="table">
          <thead>
            <tr>
              <th scope="col">Nombre</th>
              <th scope="col">Apellido</th>
              <th scope="col">Pais</th>
            </tr>
          </thead>
          <tbody>';
      foreach($jsonarray as $dato){
         echo '
            <tr>
               <td>'.$dato['Nombre'].'</td>
               <td>'.$dato['Apellido'].'</td>
               <td>'.$dato['Pais'].'</td>
            </tr>';
      }
      echo '</tbody>
      </table>
</div>
</div>';
   }
   else{
      echo
      '
      <div class="container shadow-sm rounded m-auto p-10 text-center">
      <h5 class="p-3">No hay panas en <b>'.$pais.'</b></h5>
      </div>';
   }
}


?>