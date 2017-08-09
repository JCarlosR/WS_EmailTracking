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
    $query = getQueryClientsBySellerAt($year, $month);
else
    $query = getQueryLinksPercent();

$resultSet = sqlsrv_query($cn, $query);

$data = array();
$data["links"] = array();

while ($row = sqlsrv_fetch_array($resultSet, SQLSRV_FETCH_ASSOC)) {
    $data["links"][] = $row;
}

print (json_encode($data));
CerrarConexion($cn);

function getQueryLinksPercent() {
    $query = "SELECT 
                L.LINK_Nombre as name,
                count(1) as quantity	
            FROM CLICK C
            JOIN LINK L on C.LINK_Id=L.LINK_Id
            GROUP BY L.LINK_Id, L.LINK_Nombre";
    return $query;
}
function getQueryClientsBySellerAt($year, $month) {
    $query = "SELECT 
                L.LINK_Nombre as name,
                count(1) as quantity	
            FROM CLICK C
            JOIN LINK L on C.LINK_Id=L.LINK_Id
            WHERE MONTH(L.LINK_create)=$month AND YEAR(L.LINK_create)=$year
            GROUP BY L.LINK_Id, L.LINK_Nombre";
    return $query;
}
