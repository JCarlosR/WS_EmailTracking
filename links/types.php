<?php

include("../conexion.php");
$cn = Conectarse();

$query =
    "SELECT 
        [TIP_Valor] as value,
        [TIP_Descripcion] as name
  FROM [TIPO]
  WHERE TIP_DepId=1";

$results = sqlsrv_query($cn, $query);
$data = array();

$data['link_types'] = array();
while ($row = sqlsrv_fetch_array($results, SQLSRV_FETCH_ASSOC)) {
    $data['link_types'][] = $row;
}

print (json_encode($data));
CerrarConexion($cn);
