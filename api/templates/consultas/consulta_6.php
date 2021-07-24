<?php 
include '../../../include/navbar.html';
include '../../../user/sesion_iniciada.php';
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'localhost:5000/api/consultas/6');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$data = curl_exec($ch);
curl_close($ch);
$data = json_decode($data,true);

$jsonarray = $data["top_monedas"];
echo '

<div class="container shadow-sm rounded m-auto p-10 table-hover table-responsive-md">
<div>
<h1>Descripción Consulta 6</h1>
<p>
Obtener el TOP 3 de monedas más populares, es decir, las que son poseídas
por la mayor cantidad de usuarios diferentes.
</p>
</div>';
if($jsonarray  != NULL){
   echo '
      <div class="m-auto p-10 text-left">
      <h5 class="p-3">El <b>top 3</b> monedas son:</h5>
      </div>
   <div class="table-responsive">
   <table class="table">
         <thead>
         <tr>
            <th scope="col">Nombre</th>
            <th scope="col">Usuarios</th>
         </tr>
         </thead>
         <tbody>';
   foreach($jsonarray as $dato){
      echo '
         <tr>
            <td>'.$dato['Nombre'].'</td>
            <td>'.$dato['Cantidad Usuarios'].'</td>
         </tr>';
   }
   echo '</tbody>
   </table>
</div>
</div>';
}
?>