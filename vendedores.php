<?php

include("conexion.php");
$cn = Conectarse();

$query = getQueryVendedor();
$resultSet = sqlsrv_query($cn, $query);

$data = array();
$sellers = array();

while ($row = sqlsrv_fetch_array($resultSet, SQLSRV_FETCH_ASSOC)) {
    $sellers[] = $row;
}

$data['sellers'] = $sellers;
print (json_encode($data));
CerrarConexion($cn);

function getQueryVendedor()
{
    $query = "SELECT DISTINCT v.VEN_Id as id,
                v.VEN_Apellidos as name
                from CLIENTE c
                inner join VENDEDOR v on v.VEN_Id=c.VEN_Id";
    return $query;
}
