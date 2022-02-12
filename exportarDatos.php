<?php
// Retorna un json
// header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// Include database class
include 'classes/database.class.php';

$database = new Database();

$database->query("SELECT * FROM afiliados");
$rows = $database->resultset();
$database->closeConnection();


// Filter the excel data 
function filterData(&$str)
{
    $str = preg_replace("/\t/", "\\t", $str);
    $str = preg_replace("/\r?\n/", "\\n", $str);
    if (strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
}

// Excel file name for download 
$fileName = "members_export_data-" . date('Ymd') . ".xlsx";
// Column names 
$fields = array('Cedula', 'Nombres', 'Direccion', 'Telefono', 'Celular');

// Display column names as first row 
$excelData = implode("\t", array_values($fields)) . "\n";

if (count($rows) > 0) {

    foreach ($rows as $dato) {
        $rowData = array($dato['afi_cedula'], $dato['afi_nombres'], $dato['afi_direccion'], $dato['afi_telefono'], $dato['afi_celular']);
        array_walk($rowData, 'filterData');
        $excelData .= implode("\t", array_values($rowData)) . "\n";
    }

} else {
    $excelData .= 'No records found...' . "\n";
}

// Headers for download 
header("Content-Disposition: attachment; filename=\"$fileName\""); 
header("Content-Type: application/vnd.ms-excel"); 
 
// Render excel data 
echo $excelData; 

// echo json_encode($rows);
