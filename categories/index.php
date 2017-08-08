<?php

include("../conexion.php");
$cn = Conectarse();

$query = "SELECT TC_Id as id, TC_Descripcion as name FROM TIPO_CONTENIDO";

$results = sqlsrv_query($cn, $query);
$data = array();

$data['categories'] = array();
while ($row = sqlsrv_fetch_array($results, SQLSRV_FETCH_ASSOC)) {
    $data['categories'][] = $row;
}

print (json_encode($data));
CerrarConexion($cn);
