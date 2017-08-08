<?php
if (isset($_GET['apellido'])){
        getClienteCorreoApe($_GET['apellido']);
    }

    function getClienteCorreoApe($apellidos){

        include("conexion.php");
        $cn= Conectarse();
        $query = getQueryClienteCorreoApe($apellidos);

         $result2= sqlsrv_query($cn, $query);
           $arr_result = array(); 

            $arr_result["abiertosApe"]=   array();
        while($array1 = sqlsrv_fetch_array( $result2, SQLSRV_FETCH_ASSOC))
            { 
             //$arr_result["tabla"][] = 1;       // cambio "1" a 1 porque no coge bien la cadena.
            $arr_result["estado"]=1;
            $arr_result["abiertosApe"][] = $array1;
              
            } 

            print (json_encode($arr_result)); 

        CerrarConexion($cn);
    }

    /* QUERYS  */
    function getQueryClienteCorreoApe($apellidos){
        $query = "SELECT tc.TC_Descripcion as categoria,con.CON_TITULO as titulo,(cli.CLI_Nombre+' '+cli.CLI_Apellidos) as cliente,c.CLIC_SistemaOperativo as sistema,c.CLIC_Navegador as navegador,c.CLIC_IP as ip,CONVERT(VARCHAR(20),c.CLIC_Fecha,100) as fecha from CLICK c
            inner join CLIENTE cli
           on c.CLI_Id=cli.CLI_Id
           inner join CONTENIDO con
            on c.CON_Id=con.CON_Id
            inner join SUBCATEGORIA sub
            on con.SUBC_Id=sub.SUBC_Id
            inner join TIPO_CONTENIDO tc
            on tc.TC_Id=sub.TC_Id
         where c.TIP_Valor=1 and cli.CLI_Apellidos LIKE '%$apellidos%' 
         order by c.CLIC_Fecha desc ";
        return $query;
    }

?>
