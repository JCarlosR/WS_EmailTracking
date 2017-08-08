<?php

include("../conexion.php");
$cn = Conectarse();

$query = "SELECT L.LINK_Id as id, 
            L.LINK_Nombre as name,
            L.LINK_URL as url,
            L.TIP_Valor as type_id,
            T.TIP_Descripcion as type
            FROM LINK L
            JOIN TIPO T ON L.TIP_Valor=T.TIP_Valor AND T.TIP_DepId=1";

$results = sqlsrv_query($cn, $query);
$data = array();

$data['links'] = array();
while ($row = sqlsrv_fetch_array($results, SQLSRV_FETCH_ASSOC)) {
    $data['links'][] = $row;
}

print (json_encode($data));
CerrarConexion($cn);
