<?php

include("conexion.php");
$cn = Conectarse();

$query = getQueryVendedorCliente();
$resultSet = sqlsrv_query($cn, $query);

$data = array();
$data["sellers"] = array();

while ($row = sqlsrv_fetch_array($resultSet, SQLSRV_FETCH_ASSOC)) {
    $data["sellers"][] = $row;
}

print (json_encode($data));
CerrarConexion($cn);

function getQueryVendedorCliente()
{
    $query = "SELECT v.VEN_Id as id,
                count(1) as quantity              
                from CLIENTE c
                inner join VENDEDOR v on v.VEN_Id=c.VEN_Id
                group by v.VEN_Id";
    return $query;
}
