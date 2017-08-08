<?php

include("conexion.php");
$cn = Conectarse();

$query = getQueryClientesCaptacion();

$results = sqlsrv_query($cn, $query);
$data = array();

$data['sources'] = array();
while ($row = sqlsrv_fetch_array($results, SQLSRV_FETCH_ASSOC)) {
    $data['sources'][] = $row;
}

print (json_encode($data));
CerrarConexion($cn);

function getQueryClientesCaptacion()
{
    $query = "SELECT count(1) as quantity, 
                tc.TIC_Descripcion as source
                
                from CLIENTE c
                inner join TIPO_CAPTACION tc on c.TIC_Id=tc.TIC_Id
                group by tc.TIC_Descripcion";
    return $query;
}
