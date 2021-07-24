<?php 
include '../../../include/navbar.html';
include '../../../user/sesion_iniciada.php';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://localhost:5000/api/moneda/');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$data = curl_exec($ch);
$data = json_decode($data,true);
$jsonarray = $data['monedas'];
$final_string = "";

foreach($jsonarray as $datos){
   $final_string .= '
   <option value="'.$datos['nombre'].'">'.$datos['nombre'].'</option>
   ';
}

echo '<div class="container shadow-sm rounded m-auto p-3">
<div>
   <h1>Descripción Consulta 4</h1>
   <p>
   Obtener el máximo valor histórico de la moneda X.
   </p>
</div>
<form action="consulta_4.php" method="post">
    <!-- NOTA: Los valores están en duro para esta tarea. -->
    <div class="form-group">
        <label for="moneda">Moneda</label>
        <select class="form-control" name="moneda">'.$final_string.'
        </select>
      </div>
    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-primary">Consultar</button>
    </div>
  </form>
</div>';

if(isset($_POST['moneda'])){

   $ch = curl_init();
   $moneda = $_POST['moneda'];
   $moneda_replace = str_replace(" ","%20",$moneda);

   curl_setopt($ch, CURLOPT_URL, 'localhost:5000/api/consultas/4/'.$moneda_replace);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   $data = curl_exec($ch);
   curl_close($ch);
   $data = json_decode($data,true);

   $jsonarray = $data["valores"];
   if($jsonarray  != NULL){
      foreach($jsonarray as $dato){
         echo '
         <div class="container shadow-sm rounded m-auto p-10 table-hover table-responsive-md">
            <div class="m-auto p-10 text-center">
            <h5 class="p-3">La moneda <b>'.$moneda.'</b> tiene un valor historico de: <b>'.$dato['max_valor'].'.</b></h5>
            </div>
         </div>';
      }
   }  
   else{
      echo
      '
      <div class="container shadow-sm rounded m-auto p-10 text-center">
      <h5 class="p-3">La moneda <b>'.$moneda.'</b> no tiene valores.</h5>
      </div>';
   }
}



?>