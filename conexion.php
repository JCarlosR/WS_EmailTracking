<?php
ini_set('default_charset','utf8');
header("Content-Type: text/html; charset=UTF-8");

function Conectarse() {
	$serverName = "grtclalibertad.gob.pe";
    $dataBase = "dbEmail";
        $uid = "GRTCLL";
        $pwd = "grtcll2016";
        //$serverName = "localhost";
        //$dataBase = "dbEmail";
        //$uid = "sa";
        //$pwd = "123";
        $connectionInfo = array( "UID"=>$uid, "PWD"=>$pwd,"Database"=>$dataBase, 'ReturnDatesAsStrings'=> true, "CharacterSet" => 'utf-8');
        $conn = sqlsrv_connect( $serverName, $connectionInfo) or die ( print_r("<i>Error conectando a la base de datos </i> <br><br><p><b>ERROR: </b></p>", true). print_r(sqlsrv_errors(), true));
        return $conn;
    }

function CerrarConexion($conn){
    sqlsrv_close( $conn);
}

    include_once 'include/psl-config.php';   // Ya que functions.php no está incluido.
    // $HOST = "SERVERWEB";
    // $DATABASE = "GRTCLL";
    // $USER = "GRTCLL";
    // $PASSWORD = "grtcll2016";    
    $mysqli = new PDO('sqlsrv:Server='.HOST.';Database='.DATABASE,USER,PASSWORD);
    $mysqli->setAttribute(PDO::SQLSRV_ATTR_ENCODING, PDO::SQLSRV_ENCODING_UTF8);
    // $mysqli = new sqlsrv(HOST, USER, PASSWORD, DATABASE);




?>





