<?php
//incluir la clase de la Bdd
include_once("classes/database.class.php");

// Retorna un json
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
// verifica que se reciba el parametro
if (!isset($_GET['id'])) {
	echo json_encode(array('err' => true, 'mensaje' => "Falta el Id"));
	die;
}

// limpia el parametro
$Id = htmlentities($_GET['id']);

//echo 'Id :'.$Id;

//verificar que exista en la base de datos

try {

	$database = new Database();

	// $database->beginTransaction();

	$database->query('DELETE FROM cursos_datos_adicionales WHERE id_curso = :id');
	$database->bind(':id', $Id);
	$database->execute();

	$database->query('DELETE FROM cursos WHERE id = :id');
	$database->bind(':id', $Id);
	$Hecho = $database->execute();

	// $$database->endTransaction();

	$database->closeConnection();

	if ($Hecho == "1") {
		$respuesta = json_encode(array('err' => false, 'mensaje' => 'Registro Eliminado'), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
	} else {
		$respuesta = json_encode(array('err' => true, 'mensaje' => $Hecho), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
	}
} catch (\Throwable $th) {
	if ($database->inTransaction()) {
		$database->cancelTransaction();
	}
	$respuesta = json_encode(array('err' => true, 'mensaje' => $th, 'extra' => $database->debugDumpParams()), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
}

echo $respuesta;
