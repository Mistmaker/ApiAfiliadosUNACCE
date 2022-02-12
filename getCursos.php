<?php
// Retorna un json
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// Include database class
include 'classes/database.class.php';

$database = new Database();

$database->query("SELECT c.id, c.id_modalidad, c.cur_descripcion, c.cur_estado, m.mod_nombre FROM cursos c INNER JOIN modalidades m ON m.id = c.id_modalidad WHERE c.cur_estado = 1 ORDER BY c.cur_descripcion");
$rows = $database->resultset();
$database->closeConnection();

echo json_encode($rows);
