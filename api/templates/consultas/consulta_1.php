<?php 
include '../../../include/navbar.html';
include '../../../user/sesion_iniciada.php';

echo '<div class="container shadow-sm rounded m-auto p-2">
<div>
   <h1>Descripción Consulta 1</h1>
   <p>
   Obtener todos los usuarios registrados durante el año X.
   </p>
</div>
<form action="consulta_1.php" method="post">
    <div class="form-group">
        <label for="año">Año</label>
        <input type="text" class="form-control" placeholder="Año" name="año" required>
    </div>
    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-primary">Consultar</button>
    </div>
  </form>
</div>';

if(isset($_POST['año'])){

   $ch = curl_init();
   $año = $_POST['año'];

   curl_setopt($ch, CURLOPT_URL, 'localhost:5000/api/consultas/1/'.$año);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   $data = curl_exec($ch);
   curl_close($ch);
   $data = json_decode($data,true);

   $jsonarray = $data["personas"];
   if($jsonarray  != NULL){
      echo '
      <div class="container shadow-sm rounded m-auto p-10 table-hover table-responsive-md">
      <div class="table-responsive">
      <div class="m-auto p-10 text-left">
      <h5 class="p-3">Los usuarios registrados el año <b>'.$año.'</b> son:</h5>
      </div>
      <table class="table">
          <thead>
            <tr>
              <th scope="col">Nombre</th>
              <th scope="col">Apellido</th>
              <th scope="col">Fecha Registro</th>
            </tr>
          </thead>
          <tbody>';
      foreach($jsonarray as $dato){
         echo '
            <tr>
               <td>'.$dato['Nombre'].'</td>
               <td>'.$dato['Apellido'].'</td>
               <td>'.$dato['Fecha Registro'].'</td>
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
      <h5 class="p-3">No hay panas registrados el año <b>'.$año.'</b></h5>
      </div>';
   }
}
?>
