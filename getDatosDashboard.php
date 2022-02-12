<?php
// Retorna un json
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// Include database class
include 'classes/database.class.php';

$database = new Database();

$database->query("SELECT 
                    (SELECT COUNT(id) from afiliados) AS AFILIADOS,
                    (SELECT COUNT(id) from afiliados WHERE afi_estado = 'SA') AS AFI_PENDIENTES,
                    (SELECT COUNT(id) from afiliados WHERE afi_estado = 'AP') AS AFI_VIGENTES,
                    (SELECT COUNT(id) from afiliados WHERE afi_estado = 'PC') AS AFI_POR_CADUCAR,
                    (SELECT COUNT(id) from afiliados WHERE afi_estado = 'CA') AS AFI_CADUCADOS;
                ");
$rows = $database->single();
$database->closeConnection();

echo json_encode($rows);
