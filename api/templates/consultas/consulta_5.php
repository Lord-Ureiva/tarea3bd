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
   <h1>Descripción Consulta 5</h1>
   <p>
   Obtener la cantidad de moneda X en circulación (Es decir, la suma de todas las
cantidades de la moneda X que poseen todos los usuarios).
   </p>
</div>
<form action="consulta_5.php" method="post">
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

   curl_setopt($ch, CURLOPT_URL, 'localhost:5000/api/consultas/5/'.$moneda_replace);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   $data = curl_exec($ch);
   curl_close($ch);
   $data = json_decode($data,true);

   $jsonarray = $data["monedas"];
   if($jsonarray  != NULL){
      foreach($jsonarray as $dato){
         echo '
         <div class="container shadow-sm rounded m-auto p-10 table-hover table-responsive-md">
            <div class="m-auto p-10 text-center">
            <h5 class="p-3">La moneda <b>'.$moneda.'</b> tiene un total en circulacón de <b>'.$dato['Cantidad Total'].'.</b></h5>
            </div>
         </div>';
      }
   }  
   else{
      echo
      '
      <div class="container shadow-sm rounded m-auto p-10 text-center">
      <h5 class="p-3">La moneda <b>'.$moneda.'</b> no esta en circulación.</h5>
      </div>';
   }
}




?>