<?php 
include '../../../include/navbar.html';
include '../../../user/sesion_iniciada.php';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://localhost:5000/api/usuario/');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$data = curl_exec($ch);
curl_close($ch);
$data = json_decode($data,true);
$jsonarray = $data['usuarios'];
$final_string = "";

foreach($jsonarray as $datos){
   $final_string .= '
   <option value="'.$datos['id'].'">'.$datos['id'].' - '.$datos['nombre'].' '.$datos['apellido'].'</option>
   ';
}

echo '<div class="container shadow-sm rounded m-auto p-3">
<div>
   <h1>Descripción Consulta 8</h1>
   <p>
   Obtener la criptomoneda más abundante del usuario X.
   </p>
</div>
<form action="consulta_8.php" method="post">
    <!-- NOTA: Los valores están en duro para esta tarea. -->
    <div class="form-group">
        <label for="Id Usuario">Id Usuario</label>
        <select class="form-control" name="id">'.$final_string.'
        </select>
      </div>
    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-primary">Consultar</button>
    </div>
  </form>
</div>';

if(isset($_POST['id'])){

   $ch = curl_init();
   $id = $_POST['id'];


   curl_setopt($ch, CURLOPT_URL, 'localhost:5000/api/consultas/8/'.$id);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   $data = curl_exec($ch);
   curl_close($ch);
   $data = json_decode($data,true);

   $jsonarray = $data["abundant"];
   if($jsonarray  != NULL){
      foreach($jsonarray as $dato){
         echo '
         <div class="container shadow-sm rounded m-auto p-10 table-hover table-responsive-md">
            <div class="m-auto p-10 text-center">
            <h5 class="p-3">La moneda  más abundante del usuario <b>'.$dato['Nombre'].' '.$dato['Apellido'].'</b> es: <b>'.$dato['Nombre Moneda'].'</b> con una cantidad de <b>'.$dato["Cantidad"].'.</b></h5>
            </div>
         </div>';
      }
   }  
   else{
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, 'http://localhost:5000/api/usuario/'.$id);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      $data = curl_exec($ch);
      curl_close($ch);
      $data = json_decode($data,true);
      $jsonarray = $data['usuario'];
      echo
      '
      <div class="container shadow-sm rounded m-auto p-10 text-center">
      <h5 class="p-3">El usuario <b>'.$jsonarray['nombre'].' '.$jsonarray['apellido'].'</b> no tiene monedas.</h5>
      </div>';
   }
}

?>