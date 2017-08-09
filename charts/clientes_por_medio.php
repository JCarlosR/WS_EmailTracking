<?php

include("../conexion.php");
$cn = Conectarse();

if (isset($_GET['month']))
    $month = $_GET['month'];
else $month = 0;

if (isset($_GET['year']))
    $year = $_GET['year'];
else $year = null;

if ($year)
    $query = getQueryClientsBySourceAt($year, $month);
else
    $query = getQueryClientsBySource();

$results = sqlsrv_query($cn, $query);
$data = array();

$data['sources'] = array();
while ($row = sqlsrv_fetch_array($results, SQLSRV_FETCH_ASSOC)) {
    $data['sources'][] = $row;
}

print (json_encode($data));
CerrarConexion($cn);

function getQueryClientsBySource()
{
    $query = "SELECT count(1) as quantity, 
                tc.TIC_Descripcion as source
                
                from CLIENTE c
                inner join TIPO_CAPTACION tc on c.TIC_Id=tc.TIC_Id
                group by tc.TIC_Descripcion";
    return $query;
}

function getQueryClientsBySourceAt($year, $month)
{
    $query = "SELECT count(1) as quantity, 
                tc.TIC_Descripcion as source
                
                from CLIENTE c
                inner join TIPO_CAPTACION tc on c.TIC_Id=tc.TIC_Id
                where MONTH(c.CLI_create)=$month and YEAR(c.CLI_create)=$year
                group by tc.TIC_Descripcion";
    return $query;
}
