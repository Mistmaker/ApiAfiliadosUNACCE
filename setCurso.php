<?php
include_once("classes/database.class.php");
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);

try {

    if (isset($request->cur_descripcion)) {

        if (!isset($request->id)) {

            $database = new Database();

            $database->query('INSERT INTO cursos(id, id_modalidad, cur_descripcion, cur_estado, cur_imagen) VALUES (:id, :id_modalidad, :cur_descripcion, :cur_estado, :cur_imagen)');
            
            $database->bind(':id', 0 );
            $database->bind(':id_modalidad', $request->id_modalidad );
            $database->bind(':cur_descripcion', $request->cur_descripcion );
            $database->bind(':cur_estado', $request->cur_estado );
            $database->bind(':cur_imagen', $request->cur_imagen );
            

        } else {

            $database = new Database();
            $database->query('UPDATE cursos SET 
                            id_modalidad = :id_modalidad,
                            cur_descripcion = :cur_descripcion,
                            cur_estado = :cur_estado,
                            cur_imagen = :cur_imagen
						    WHERE id = :id');
            
            $database->bind(':id_modalidad', $request->id_modalidad );
            $database->bind(':cur_descripcion', $request->cur_descripcion );
            $database->bind(':cur_estado', $request->cur_estado );
            $database->bind(':cur_imagen', $request->cur_imagen );

            $database->bind(':id', $request->id);
        }

        $database->beginTransaction();

        $Hecho = $database->execute();

        if (!isset($request->id)) {
            $id = $database->lastInsertId();
        } else {
            $id = $request->id;
        }


        // Eliminando datos adicionales
        $database->query('DELETE FROM cursos_datos_adicionales WHERE id_curso = :id');
        $database->bind(':id', $id);
        $database->execute();

        foreach ($request->datosAdicionales as $dato) {
            if (isset($dato)) {
                // $database = new Database();
                $database->query('INSERT INTO cursos_datos_adicionales(id, id_curso, descripcion, dato1, dato2) VALUES (:id, :id_curso, :descripcion, :dato1, :dato2)');
                $database->bind(':id',0);
                $database->bind(':id_curso',$id);
                $database->bind(':descripcion',$dato->descripcion);
                $database->bind(':dato1',$dato->dato1);
                $database->bind(':dato2',$dato->dato2);
                $database->execute();
            }
        }

        $database->endTransaction();

        $database->closeConnection();

        if ($Hecho == "1") {
            $respuesta = json_encode(array('err' => false, 'mensaje' => 'Curso Registrado', 'id' => $id), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        } else {
            $respuesta = json_encode(array('err' => true, 'mensaje' => $Hecho), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        }
    } else {
        $respuesta = json_encode(array('err' => true, 'mensaje' => 'No se recibió ningún dato'), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }
} catch (\Throwable $th) {
    if ($database->inTransaction()) {
        $database->cancelTransaction();
    }
    $respuesta = json_encode(array('err' => true, 'mensaje' => $th, 'extra' => $database->debugDumpParams()), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
}

echo $respuesta;
