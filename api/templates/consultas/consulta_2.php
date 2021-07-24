<?php 
include '../../../include/navbar.html';
include '../../../user/sesion_iniciada.php';
echo '<div class="container shadow-sm rounded m-auto p-2">
<div>
<h1>Descripción Consulta 2</h1>
<p>
Obtener todas las cuentas bancarias con un balance superior a X.
</p>
</div>
<form action="consulta_2.php" method="post">
    <div class="form-group">
        <label for="valor">Valor</label>
        <input type="text" class="form-control" placeholder="Valor" name="valor" required>
    </div>
    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-primary">Consultar</button>
    </div>
  </form>
</div>';

if(isset($_POST['valor'])){

   $ch = curl_init();
   $valor = $_POST['valor'];

   curl_setopt($ch, CURLOPT_URL, 'localhost:5000/api/consultas/2/'.$valor);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   $data = curl_exec($ch);
   curl_close($ch);
   $data = json_decode($data,true);

   $jsonarray = $data["cuentas"];
   if($jsonarray  != NULL){
      echo '
      <div class="container shadow-sm rounded m-auto p-10 table-hover table-responsive-md">
      <div class="table-responsive">
      <table class="table">
          <thead>
            <tr>
              <th scope="col">Id Cuenta</th>
              <th scope="col">Balance</th>
            </tr>
          </thead>
          <tbody>';
      foreach($jsonarray as $dato){
         echo '
            <tr>
               <td>'.$dato['Id Cuenta'].'</td>
               <td>'.$dato['Balance'].'</td>
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
      <h5 class="p-3">No hay Cuentas</h5>
      </div>';
   }
}

?>