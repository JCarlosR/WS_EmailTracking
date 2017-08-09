<?php

include("../conexion.php");
$cn = Conectarse();

if (isset($_GET['month']))
    $month = $_GET['month'];
else $month = 0;

if (isset($_GET['year']))
    $year = $_GET['year'];
else $year = null;

$data = array();

if ($year)
    $querySent = getQuerySentAt($year, $month);
else
    $querySent = getQuerySent();

$resultSet = sqlsrv_query($cn, $querySent);
if ($row = sqlsrv_fetch_array($resultSet, SQLSRV_FETCH_ASSOC)) {
    $data['sent'] = $row['sent'];
}

if ($year)
    $queryOpened = getQueryOpenedAt($year, $month);
else
    $queryOpened = getQueryOpened();

$resultSet = sqlsrv_query($cn, $queryOpened);
if ($row = sqlsrv_fetch_array($resultSet, SQLSRV_FETCH_ASSOC)) {
    $data['opened'] = $row['opened'];
}

print (json_encode($data));
CerrarConexion($cn);

function getQuerySent() {
    $query = "SELECT 
                count(ENV_Id) as sent 
            FROM DETALLE_ENVIO";
    return $query;
}
function getQuerySentAt($year, $month) {
    $query = "SELECT 
                count(ENV_Id) as sent 
            FROM DETALLE_ENVIO 
            WHERE MONTH(DEN_Create)=$month AND YEAR(DEN_Create)=$year";
    return $query;
}

function getQueryOpened() {
    $query = "SELECT 
                count(TIP_Valor) as opened 
            FROM CLICK 
            WHERE TIP_Valor=1";
    return $query;
}
function getQueryOpenedAt($year, $month) {
    $query = "SELECT 
                count(TIP_Valor) as opened 
            FROM CLICK 
            WHERE TIP_Valor=1 AND MONTH(CLIC_Fecha)=$month AND YEAR(CLIC_Fecha)=$year";
    return $query;
}
