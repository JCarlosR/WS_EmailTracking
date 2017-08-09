<?php

include("../conexion.php");
$cn = Conectarse();

if (isset($_GET['last_name']))
    $query = getQueryOpenedEmails();
else
    $query = getQueryOpenedEmailsByLastName($_GET['last_name']);

$result2 = sqlsrv_query($cn, $query);
$data = array();

$data["emails"] = array();
while ($row = sqlsrv_fetch_array($result2, SQLSRV_FETCH_ASSOC)) {
    $data["emails"][] = $row;
}

print (json_encode($data));
CerrarConexion($cn);

function getQueryOpenedEmails() {
    $query = "SELECT tc.TC_Descripcion as category, 
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
         where c.TIP_Valor=1
         order by c.CLIC_Fecha desc";
    return $query;
}

function getQueryOpenedEmailsByLastName($lastName) {
    $query = "SELECT tc.TC_Descripcion as category, 
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
         where c.TIP_Valor=1 and cli.CLI_Apellidos LIKE '%$lastName%'
         order by c.CLIC_Fecha desc";
    return $query;
}
