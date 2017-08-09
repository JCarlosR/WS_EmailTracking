<?php

include("../conexion.php");
$cn = Conectarse();

$query =
    "SELECT l.LINK_Nombre as link,
    tc.TC_Descripcion as category,
    con.CON_TITULO as title,
    (cli.CLI_Nombre+' '+cli.CLI_Apellidos) as client,
    c.CLIC_SistemaOperativo as SO,
    c.CLIC_Navegador as browser,
    c.CLIC_IP as IP,
    CONVERT(VARCHAR(20),c.CLIC_Fecha,100) as date 
    from CLICK c
    
    inner join CLIENTE cli on c.CLI_Id=cli.CLI_Id
    inner join CONTENIDO con on c.CON_Id=con.CON_Id
    inner join SUBCATEGORIA sub on con.SUBC_Id=sub.SUBC_Id
    inner join TIPO_CONTENIDO tc on tc.TC_Id=sub.TC_Id
    inner join LINK l on l.LINK_Id=c.LINK_Id
    where c.TIP_Valor!=1
    order by c.CLIC_Fecha desc";

$results = sqlsrv_query($cn, $query);
$data = array();

$data['opened_links'] = array();
while ($row = sqlsrv_fetch_array($results, SQLSRV_FETCH_ASSOC)) {
    $data['opened_links'][] = $row;
}

print (json_encode($data));
CerrarConexion($cn);
