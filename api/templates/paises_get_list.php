<?php
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://localhost:5000/api/pais/');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$data = curl_exec($ch);
$data = json_decode($data,true);
$jsonarray = $data['paises'];
$final_string = "";

foreach($jsonarray as $datos){
   $final_string .= '
   <option value='.$datos['cod_pais'].'>'.$datos['nombre'].'</option>
   ';
}
?>