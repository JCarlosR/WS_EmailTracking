<?php

include("../conexion.php");
$cn = Conectarse();

$query = "SELECT CLI_Id as id, 
            CLI_Nombre as first_name,
            CLI_Apellidos as last_name,
            CLI_Correo as email
            FROM CLIENTE";

$results = sqlsrv_query($cn, $query);
$data = array();

$data['clients'] = array();
while ($row = sqlsrv_fetch_array($results, SQLSRV_FETCH_ASSOC)) {
    $data['clients'][] = $row;
}

print (json_encode($data));
CerrarConexion($cn);
