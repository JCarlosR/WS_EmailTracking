<?php

include("../conexion.php");
$cn = Conectarse();

$data = array();
$data['success'] = false;

$firstName = getPostParameter('first_name');
$lastName = getPostParameter('last_name');
$email = getPostParameter('email');
// $categoryId = getPostParameter('category_id');
$subCategoryId = getPostParameter('sub_category_id');

if (!$firstName || !$lastName || !$email || !$subCategoryId) {
    $data['error_message'] = 'No se enviaron todos los datos requeridos.';
    die(json_encode($data));
}

// insert client
$queryInsertClient =
    "INSERT INTO CLIENTE (CLI_Nombre, CLI_Apellidos, CLI_Correo, TIC_Id, VEN_Id) 
    VALUES ('$firstName', '$lastName', '$email', 1, 1)";

$clientInserted = sqlsrv_query($cn, $queryInsertClient);
if (!$clientInserted) {
    $data['error_message'] = 'Error al registrar al nuevo cliente.';
    die(json_encode($data));
}


// get id of the newest client
$results = sqlsrv_query($cn, "SELECT TOP 1 CLI_Id FROM CLIENTE ORDER BY CLI_Id DESC");
if ($row = sqlsrv_fetch_array($results, SQLSRV_FETCH_NUMERIC)) {
    $idClient = $row[0];
} else die(json_encode($data));

// insert interests
$queryInsertInterests =
    "INSERT INTO INTERES_CLIENTE (CLI_ID, SUBC_Id) 
    VALUES ('$idClient', '$subCategoryId')";
$inserted = sqlsrv_query($cn, $queryInsertInterests);

// JSON response
if ($inserted) {
    $data['success'] = true;
    print(json_encode($data));
} else {
    $data['error_message'] = 'Se registró el cliente pero no sus intereses.';
    die(json_encode($data));
}


CerrarConexion($cn);

// helper method
function getPostParameter($name) {
    if (isset($_POST[$name]))
        return $_POST[$name];
    else
        return null;
}
