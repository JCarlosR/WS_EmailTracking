<?php
if (isset($_GET['usuario']) && isset($_GET['clave']))
{
    getIniciarSesion($_GET['usuario'], $_GET['clave']);
}

function getIniciarSesion($usuario, $clave)
{

    include("conexion.php");
    $cn = Conectarse();

    $query = getQueryIniciarSesion($usuario, $clave);
    $resultSet = sqlsrv_query($cn, $query);

    $data = array();
    $data['success'] = false;
    while ($row = sqlsrv_fetch_array($resultSet, SQLSRV_FETCH_ASSOC)) {
        $data['success'] = true;
        $data['user'] = $row;
    }

    print (json_encode($data));

    CerrarConexion($cn);
}

function getQueryIniciarSesion($usuario, $clave)
{
    $query = "SELECT u.USE_Usuario,u.USE_Password from USUARIO u where u.USE_Usuario='$usuario' and u.USE_Password='$clave'";
    return $query;
}
