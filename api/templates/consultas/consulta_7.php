<?php 
include '../../../include/navbar.html';
include '../../../user/sesion_iniciada.php';
echo '<div class="container shadow-sm rounded m-auto p-2">
<div>
   <h1>Descripción Consulta 7</h1>
   <p>
   Obtener la moneda que más cambió su valor durante el mes X.
   </p>
</div>
<form action="consulta_7.php" method="post">
    <div class="form-group">
        <label for="mes">Mes</label>
        <select class="form-control" name="mes"><option value="Enero">Enero</option>
        <option value="Febrero">Febrero</option>
        <option value="Marzo">Marzo</option>
        <option value="Abril">Abril</option>
        <option value="Mayo">Mayo</option>
        <option value="Junio">Junio</option>
        <option value="Julio">Julio</option>
        <option value="Agosto">Agosto</option>
        <option value="Septiembre">Septiembre</option>
        <option value="Octubre">Octubre</option>
        <option value="Noviembre">Noviembre</option>
        <option value="Diciembre">Diciembre</option>
        </select>
        </div>
    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-primary">Consultar</button>
    </div>
  </form>
</div>';

if(isset($_POST['mes'])){

   $year = array(
      'Enero' => 1,
      'Febrero' => 2,
      'Marzo' => 3,
      'Abril' => 4,
      'Mayo' => 5,
      'Junio' => 6,
      'Julio' => 7,
      'Agosto' => 8,
      'Septiembre' => 9,
      'Octubre' => 10,
      'Noviembre' => 11,
      'Diciembre' => 12,
   );
   $ch = curl_init();
   $mes = $_POST['mes'];

   curl_setopt($ch, CURLOPT_URL, 'localhost:5000/api/consultas/7/'.$year[$mes]);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   $data = curl_exec($ch);
   curl_close($ch);
   $data = json_decode($data,true);

   $jsonarray = $data["cambio"];
   if($jsonarray  != NULL){
      echo '
      <div class="container shadow-sm rounded m-auto p-10 table-hover table-responsive-md">
      <div class="m-auto p-10 text-left">
      <h5 class="p-3">En el mes de <b>'.$mes.'</b> la moneda que mas cambió su valor fue:</h5>
      </div>
      <div class="table-responsive">
      <table class="table">
          <thead>
            <tr>
              <th scope="col">Nombre</th>
              <th scope="col">Veces que cambió</th>
            </tr>
          </thead>
          <tbody>';
      foreach($jsonarray as $dato){
         echo '
            <tr>
               <td>'.$dato['Moneda'].'</td>
               <td>'.$dato['changes'].'</td>
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
      <h5 class="p-3">No hay cambios en el mes de '.$mes.'</h5>
      </div>';
   }
}

?>