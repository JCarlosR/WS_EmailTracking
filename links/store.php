<?php

include("../conexion.php");
$cn = Conectarse();

$data = array();
$data['success'] = false;

$name = getPostParameter('name');
$url = getPostParameter('url');
$typeId = getPostParameter('type_id');

if (!$name || !$url || !$typeId) {
    $data['error_message'] = 'No se enviaron todos los datos requeridos.';
    die(json_encode($data));
}

// insert link
$queryInsertLink =
    "INSERT INTO LINK (LINK_Nombre, LINK_URL, TIP_Valor) 
    VALUES ('$name', '$url', '$typeId')";

$linkInserted = sqlsrv_query($cn, $queryInsertLink);
if (!$linkInserted) {
    $data['error_message'] = 'Error al registrar el nuevo link.';
    die(json_encode($data));
}

// JSON response
$data['success'] = true;
print(json_encode($data));

CerrarConexion($cn);

// helper method
function getPostParameter($name) {
    if (isset($_POST[$name]))
        return $_POST[$name];
    else
        return null;
}
