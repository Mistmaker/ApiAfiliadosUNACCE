<?php
// Retorna un json
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// Include database class
include 'classes/database.class.php';

// verifica que se reciba el parametro
if (!isset($_GET['id'])) {
	echo json_encode(array('err' => true, 'mensaje' => "Falta el Id"));
	die;
}

// limpia el parametro
$Id = htmlentities($_GET['id']);

$database = new Database();

$database->query("SELECT * FROM cursos c WHERE c.id = :id ");
$database->bind('id', $Id);
$rows = $database->single();
$database->closeConnection();

if ($rows) {

    // $rows["cur_imagen"] = base64_encode( $rows["cur_imagen"] ); 

    $database = new Database();
    $database->query("SELECT * FROM cursos_datos_adicionales c WHERE c.id_curso = :id");
    $database->bind('id', $Id);
    $rows2 = $database->resultset();
    $database->closeConnection();

    if($rows2){
        $rows["datosAdicionales"]= $rows2;
    } else {
        // $rows["datosAdicionales"]= [];
    }

	echo json_encode($rows, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
} else {
	echo json_encode(array('err' => true, 'mensaje' => "Id no existe"), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
}
