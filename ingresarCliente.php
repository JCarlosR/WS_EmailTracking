<?php
if (isset($_GET['nombres']) && isset($_GET['apellidos']) && isset($_GET['email']) ){
        getGuardarCliente($_GET['nombres'],$_GET['apellidos'],$_GET['email']);
    }

    function getGuardarCliente($nombres,$apellidos,$email){

        include("conexion.php");
        $cn= Conectarse();
        $query = getQueryRegistrarCliente($nombres,$apellidos,$email);

        $res = sqlsrv_query($cn, $query);

        if($res) {
           $json_string = json_encode(array("estado" => 1,"mensaje" => "Creacion correcta"));
        echo $json_string;
        } else {
       $json_string = json_encode(array("estado" => 2,"mensaje" => "No se creo el registro"));
        echo $json_string;
        } 

        CerrarConexion($cn);
    }

    /* QUERYS  */
    function getQueryRegistrarCliente($nombres,$apellidos,$email){
        $query = "INSERT INTO CLIENTE (CLI_Nombre,CLI_Apellidos,CLI_Correo) VALUES ('$nombres','$apellidos','$email')  ";
        return $query;
    }

?>


