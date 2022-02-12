<?php
include_once("classes/database.class.php");
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);

date_default_timezone_set('America/Bogota');
setlocale(LC_TIME, 'spanish');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';

try {

    if (isset($request->afi_cedula)) {

        if (!isset($request->id)) {

            $database = new Database();

            $database->query('SELECT IFNULL(MAX(afi_numero)+1, 1) AS NUMERO FROM afiliados');
            $result = $database->single();
            $numero = sprintf("%09d", $result["NUMERO"] );

            $database->query('INSERT INTO afiliados (id, id_nacionalidad, id_provincia, id_curso, afi_numero, afi_apellidos, afi_nombres, afi_cedula, afi_tiposuscripcion, afi_fecha_nacimiento, afi_direccion, afi_inteseccion, afi_barrio, afi_ciudad, afi_telefono, afi_celular, afi_email_particular, afi_email_laboral, afi_fecha_presentacion, afi_fecha_incorporacion, afi_fecha_vencimiento, afi_foto, afi_estado, afi_categoria, afi_ruc_facturacion, afi_nombre_facturacion, afi_direccion_facturacion, afi_email_facturacion, afi_telefono_facturacion, afi_observacion_facturacion, afi_ruc_contacto, afi_nombre_contacto, afi_direccion_contacto, afi_email_contacto, afi_telefono_contacto, afi_observacion_contacto, afi_afiliado_unacce, afi_colegio_afiliacion, afi_empresa, afi_pregunta_cursos_online, afi_pregunta_tema_cursos) VALUES (
                :id, :id_nacionalidad, :id_provincia, :id_curso, :afi_numero, :afi_apellidos, :afi_nombres, :afi_cedula, :afi_tiposuscripcion, :afi_fecha_nacimiento, :afi_direccion, :afi_inteseccion, :afi_barrio, :afi_ciudad, :afi_telefono, :afi_celular, :afi_email_particular, :afi_email_laboral, :afi_fecha_presentacion, :afi_fecha_incorporacion, :afi_fecha_vencimiento, :afi_foto, :afi_estado, :afi_categoria, :afi_ruc_facturacion, :afi_nombre_facturacion, :afi_direccion_facturacion, :afi_email_facturacion, :afi_telefono_facturacion, :afi_observacion_facturacion, :afi_ruc_contacto, :afi_nombre_contacto, :afi_direccion_contacto, :afi_email_contacto, :afi_telefono_contacto, :afi_observacion_contacto, :afi_afiliado_unacce, :afi_colegio_afiliacion, :afi_empresa, :afi_pregunta_cursos_online, :afi_pregunta_tema_cursos
            )');
            
            $database->bind(':id', 0 );
            $database->bind(':id_nacionalidad', $request->id_nacionalidad );
            $database->bind(':id_provincia', $request->id_provincia );
            $database->bind(':id_curso', $request->id_curso );
            $database->bind(':afi_numero', $numero );
            $database->bind(':afi_apellidos', $request->afi_apellidos );
            $database->bind(':afi_nombres', $request->afi_nombres );
            $database->bind(':afi_cedula', $request->afi_cedula );
            $database->bind(':afi_tiposuscripcion', $request->afi_tiposuscripcion );
            $database->bind(':afi_fecha_nacimiento', $request->afi_fecha_nacimiento );
            $database->bind(':afi_direccion', $request->afi_direccion );
            $database->bind(':afi_inteseccion', $request->afi_inteseccion );
            $database->bind(':afi_barrio', $request->afi_barrio );
            $database->bind(':afi_ciudad', $request->afi_ciudad );
            $database->bind(':afi_telefono', $request->afi_telefono );
            $database->bind(':afi_celular', $request->afi_celular );
            $database->bind(':afi_email_particular', $request->afi_email_particular );
            $database->bind(':afi_email_laboral', $request->afi_email_laboral );
            $database->bind(':afi_fecha_presentacion', $request->afi_fecha_presentacion );
            $database->bind(':afi_fecha_incorporacion', $request->afi_fecha_incorporacion );
            $database->bind(':afi_fecha_vencimiento', $request->afi_fecha_vencimiento );
            $database->bind(':afi_foto', $request->afi_foto );
            $database->bind(':afi_estado', $request->afi_estado );
            $database->bind(':afi_categoria', $request->afi_categoria );
            $database->bind(':afi_ruc_facturacion', $request->afi_ruc_facturacion );
            $database->bind(':afi_nombre_facturacion', $request->afi_nombre_facturacion );
            $database->bind(':afi_direccion_facturacion', $request->afi_direccion_facturacion );
            $database->bind(':afi_email_facturacion', $request->afi_email_facturacion );
            $database->bind(':afi_telefono_facturacion', $request->afi_telefono_facturacion );
            $database->bind(':afi_observacion_facturacion', $request->afi_observacion_facturacion );
            $database->bind(':afi_ruc_contacto', $request->afi_ruc_contacto );
            $database->bind(':afi_nombre_contacto', $request->afi_nombre_contacto );
            $database->bind(':afi_direccion_contacto', $request->afi_direccion_contacto );
            $database->bind(':afi_email_contacto', $request->afi_email_contacto );
            $database->bind(':afi_telefono_contacto', $request->afi_telefono_contacto );
            $database->bind(':afi_observacion_contacto', $request->afi_observacion_contacto );
            $database->bind(':afi_afiliado_unacce', $request->afi_afiliado_unacce );
            $database->bind(':afi_colegio_afiliacion', $request->afi_colegio_afiliacion );
            $database->bind(':afi_empresa', $request->afi_empresa );
            $database->bind(':afi_pregunta_cursos_online', $request->afi_pregunta_cursos_online );
            $database->bind(':afi_pregunta_tema_cursos', $request->afi_pregunta_tema_cursos );

        } else {

            $database = new Database();
            $database->query('UPDATE afiliados SET 
                        id_nacionalidad= :id_nacionalidad,
                        id_provincia= :id_provincia,
                        id_curso= :id_curso,
                        afi_numero= :afi_numero,
                        afi_apellidos= :afi_apellidos,
                        afi_nombres= :afi_nombres,
                        afi_cedula= :afi_cedula,
                        afi_tiposuscripcion= :afi_tiposuscripcion,
                        afi_fecha_nacimiento= :afi_fecha_nacimiento,
                        afi_direccion= :afi_direccion,
                        afi_inteseccion= :afi_inteseccion,
                        afi_barrio= :afi_barrio,
                        afi_ciudad= :afi_ciudad,
                        afi_telefono= :afi_telefono,
                        afi_celular= :afi_celular,
                        afi_email_particular= :afi_email_particular,
                        afi_email_laboral= :afi_email_laboral,
                        afi_fecha_presentacion= :afi_fecha_presentacion,
                        afi_fecha_incorporacion= :afi_fecha_incorporacion,
                        afi_fecha_vencimiento= :afi_fecha_vencimiento,
                        afi_foto= :afi_foto,
                        afi_estado= :afi_estado,
                        afi_categoria= :afi_categoria,
                        afi_ruc_facturacion= :afi_ruc_facturacion,
                        afi_nombre_facturacion= :afi_nombre_facturacion,
                        afi_direccion_facturacion= :afi_direccion_facturacion,
                        afi_email_facturacion= :afi_email_facturacion,
                        afi_telefono_facturacion= :afi_telefono_facturacion,
                        afi_observacion_facturacion= :afi_observacion_facturacion,
                        afi_ruc_contacto= :afi_ruc_contacto,
                        afi_nombre_contacto= :afi_nombre_contacto,
                        afi_direccion_contacto= :afi_direccion_contacto,
                        afi_email_contacto= :afi_email_contacto,
                        afi_telefono_contacto= :afi_telefono_contacto,
                        afi_observacion_contacto= :afi_observacion_contacto,
                        afi_afiliado_unacce= :afi_afiliado_unacce,
                        afi_colegio_afiliacion= :afi_colegio_afiliacion,
                        afi_empresa= :afi_empresa,
                        afi_pregunta_cursos_online= :afi_pregunta_cursos_online,
                        afi_pregunta_tema_cursos= :afi_pregunta_tema_cursos
						WHERE id = :id');
            
            $database->bind(':id_nacionalidad', $request->id_nacionalidad );
            $database->bind(':id_provincia', $request->id_provincia );
            $database->bind(':id_curso', $request->id_curso );
            $database->bind(':afi_numero', $request->afi_numero  );
            $database->bind(':afi_apellidos', $request->afi_apellidos );
            $database->bind(':afi_nombres', $request->afi_nombres );
            $database->bind(':afi_cedula', $request->afi_cedula );
            $database->bind(':afi_tiposuscripcion', $request->afi_tiposuscripcion );
            $database->bind(':afi_fecha_nacimiento', $request->afi_fecha_nacimiento );
            $database->bind(':afi_direccion', $request->afi_direccion );
            $database->bind(':afi_inteseccion', $request->afi_inteseccion );
            $database->bind(':afi_barrio', $request->afi_barrio );
            $database->bind(':afi_ciudad', $request->afi_ciudad );
            $database->bind(':afi_telefono', $request->afi_telefono );
            $database->bind(':afi_celular', $request->afi_celular );
            $database->bind(':afi_email_particular', $request->afi_email_particular );
            $database->bind(':afi_email_laboral', $request->afi_email_laboral );
            $database->bind(':afi_fecha_presentacion', $request->afi_fecha_presentacion );
            $database->bind(':afi_fecha_incorporacion', $request->afi_fecha_incorporacion );
            $database->bind(':afi_fecha_vencimiento', $request->afi_fecha_vencimiento );
            $database->bind(':afi_foto', $request->afi_foto );
            $database->bind(':afi_estado', $request->afi_estado );
            $database->bind(':afi_categoria', $request->afi_categoria );
            $database->bind(':afi_ruc_facturacion', $request->afi_ruc_facturacion );
            $database->bind(':afi_nombre_facturacion', $request->afi_nombre_facturacion );
            $database->bind(':afi_direccion_facturacion', $request->afi_direccion_facturacion );
            $database->bind(':afi_email_facturacion', $request->afi_email_facturacion );
            $database->bind(':afi_telefono_facturacion', $request->afi_telefono_facturacion );
            $database->bind(':afi_observacion_facturacion', $request->afi_observacion_facturacion );
            $database->bind(':afi_ruc_contacto', $request->afi_ruc_contacto );
            $database->bind(':afi_nombre_contacto', $request->afi_nombre_contacto );
            $database->bind(':afi_direccion_contacto', $request->afi_direccion_contacto );
            $database->bind(':afi_email_contacto', $request->afi_email_contacto );
            $database->bind(':afi_telefono_contacto', $request->afi_telefono_contacto );
            $database->bind(':afi_observacion_contacto', $request->afi_observacion_contacto );
            $database->bind(':afi_afiliado_unacce', $request->afi_afiliado_unacce );
            $database->bind(':afi_colegio_afiliacion', $request->afi_colegio_afiliacion );
            $database->bind(':afi_empresa', $request->afi_empresa );
            $database->bind(':afi_pregunta_cursos_online', $request->afi_pregunta_cursos_online );
            $database->bind(':afi_pregunta_tema_cursos', $request->afi_pregunta_tema_cursos );

            $database->bind(':id', $request->id);
        }

        // $database->beginTransaction();

        $Hecho = $database->execute();
        

        if (!isset($request->id)) {
            $id = $database->lastInsertId();

            // Obteniendo datos del curso
            $database->query("SELECT * FROM cursos c WHERE c.id = :id ");
            $database->bind(':id', $request->id_curso );
            $curso = $database->single();

            $database->query("SELECT * FROM cursos_datos_adicionales c WHERE c.id_curso = :id");
            $database->bind(':id', $request->id_curso );
            $datosAdicionales = $database->resultset();

            // Fin Obteniendo datos del curso

            // Envio correo
            
            $mail = new PHPMailer();
            $mail->IsSMTP();

            $mail->Host = 'mail.begroupec.com';
            $mail->SMTPAuth = true;
            $mail->SMTPAutoTLS = true; 
            $mail->Port = 587; 

            $mail->SMTPDebug  = 0;

            // $mail->SMTPAuth   = TRUE;
            // $mail->SMTPSecure = "tls";
            // $mail->Port       = 465;
            // $mail->Host       = "mail.begroupec.com";

            $mail->Username   = "info@begroupec.com";
            $mail->Password   = "M@rlon2020";

            $mail->IsHTML(true);
            $mail->AddAddress($request->afi_email_particular, $request->afi_email_particular);
            $mail->SetFrom("info@begroupec.com", "BeGroup");
            $mail->AddReplyTo("info@begroupec.com", "BeGroup");
            // $mail->AddCC("cc-recipient-email", "cc-recipient-name");
            $mail->Subject = utf8_decode("Registro de ingreso");
            $html = "
                <div> Estimado(a): $request->afi_apellidos $request->afi_nombres </div> <br>
                <div> Se le envía la confirmacíon de su registro de matrícula. </div> <br>
            ";

            // Datos de la cabecera
            $html .= "
                <div> Cédula: $request->afi_cedula </div> <br>
                <div> Apellidos: $request->afi_apellidos </div> <br>
                <div> Nombres: $request->afi_nombres </div> <br>
                <div> Dirección: $request->afi_direccion </div> <br>
                <div> Teléfono: $request->afi_telefono </div> <br>
                <div> Correo: $request->afi_email_particular </div> <br>
                <div> Afiliado a la UNACCE: ". ($request->afi_afiliado_unacce == 'S' ? 'Si' : 'No' ) ." </div> <br>
                <div> Colegio de afiliación: $request->afi_colegio_afiliacion </div> <br>
                <hr>
            ";
                        
            $html .= "<div> A continuación se detalla información del curso al que se inscribió:</div> <br>";

            $html .= "  <div style='text-align: center;'> 
                            <img src='data:image/png;base64,".$curso['cur_imagen']."' style='height: 300px;' alt='Curso'>
                        </div>";
            
            $html .= "
            <table style='width: 100%;'>
                <thead>
                    <tr>
                        <th colspan='3' style='height: 40px; background-color: #002060; color: white; text-align:center;' >
                            <b>". $curso['cur_descripcion'] ." </b> 
                        </th>
                    </tr>
                </thead>
            <tbody>";


            for ($i=0; $i < count($datosAdicionales) ; $i++) { 
                $html .= "
                    <tr>
                        <th style='width: 20%; word-wrap: break-word' scope='row'>".  $datosAdicionales[$i]['descripcion'] ."</th>
                        <td style='width: 40%; word-wrap: break-word'>
                            <p style='white-space: pre-wrap'>
                            ". $datosAdicionales[$i]['dato1']."
                            </p>
                        </td>
                        <td style='width: 40%; word-wrap: break-word'>
                            <p style='white-space: pre-wrap'>
                            ". $datosAdicionales[$i]['dato2']."
                            </p>
                        </td>
                    </tr>
                ";
            }

            $html .= "</tbody></table>";

            // echo $html;

            // $mail->MsgHTML($content);
            $mail->MsgHTML($html);


            $mail->Encoding = 'base64';
            $mail->CharSet = 'UTF-8';

            if (!$mail->Send()) {
                $respuesta = json_encode(array('err' => true, 'mensaje' => "Error al enviar el correo"), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
                var_dump($mail);
            } else {
                $respuesta = json_encode(array('err' => false, 'mensaje' => "Listado de obligaciones enviado a tu correo, si no aparece revisa en spam"), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            }
            
            // Fin Envio correo

        } else {
            $id = $request->id;
        }

        // $database->endTransaction();

        $database->closeConnection();

        if ($Hecho == "1") {
            $respuesta = json_encode(array('err' => false, 'mensaje' => 'Matricula Registrada', "curso" => $curso, "datos" => $html ), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
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
