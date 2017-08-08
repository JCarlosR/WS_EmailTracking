<?php

include("../conexion.php");
$cn = Conectarse();

$data = array();
$data['subCategories'] = array();

if (isset($_GET['category_id']))
    $category_id = $_GET['category_id'];
else
    die(json_encode($data));

$query =
"SELECT 
    SUBC_Id as id,
	SUBC_Descripcion as name
FROM SUBCATEGORIA WHERE TC_Id=$category_id";

$results = sqlsrv_query($cn, $query);

while ($row = sqlsrv_fetch_array($results, SQLSRV_FETCH_ASSOC)) {
    $data['subCategories'][] = $row;
}

print (json_encode($data));
CerrarConexion($cn);
