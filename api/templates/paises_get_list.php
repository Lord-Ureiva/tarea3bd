<?php
$data = json_decode(file_get_contents('http://localhost:5000/api/pais/'));

$jsonarray = $data->paises;
$final_string = "";

foreach($jsonarray as $datos){
   $final_string .= '
   <option value='.$datos->cod_pais.'>'.$datos->nombre.'</option>
   ';
}
?>