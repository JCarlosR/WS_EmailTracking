<?php

include("conexion.php");
$cn = Conectarse();

$query = "SELECT count(ENV_Id) as cantidad from DETALLE_ENVIO";
$resultSet = sqlsrv_query($cn, $query);

$data = array();
$data['success'] = false;
$data["quantity"] = 0;
while ($row = sqlsrv_fetch_array($resultSet, SQLSRV_FETCH_ASSOC)) {
    $data["success"] = true;
    $data["quantity"] = $row['cantidad'];
}

print (json_encode($data));
CerrarConexion($cn);
