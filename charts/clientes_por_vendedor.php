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
    $query = getQueryClientsBySeller();

$resultSet = sqlsrv_query($cn, $query);

$data = array();
$data["sellers"] = array();

while ($row = sqlsrv_fetch_array($resultSet, SQLSRV_FETCH_ASSOC)) {
    $data["sellers"][] = $row;
}

print (json_encode($data));
CerrarConexion($cn);

function getQueryClientsBySeller() {
    $query = "SELECT v.VEN_Id as id,
                count(1) as quantity              
                from CLIENTE c
                inner join VENDEDOR v on v.VEN_Id=c.VEN_Id
                group by v.VEN_Id";
    return $query;
}
function getQueryClientsBySellerAt($year, $month) {
    $query = "SELECT v.VEN_Id as id,
                count(1) as quantity              
                from CLIENTE c
                inner join VENDEDOR v on v.VEN_Id=c.VEN_Id
                where MONTH(c.CLI_create)=$month and YEAR(c.CLI_create)=$year
                group by v.VEN_Id";
    return $query;
}
