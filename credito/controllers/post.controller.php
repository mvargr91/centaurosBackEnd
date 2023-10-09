
<?php


require_once "models/connection.php";
require_once "models/get.model.php";
require_once "models/post.model.php";
require_once "models/put.model.php";
require_once "vendor/autoload.php";


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


require_once "models/put.model.php";

class PostController{

    // ENVIO DE CREDITO
    /**
     * @description 
     * @author Mauricio Vargas Romero
     * @date 
     @params n/a 
     @return 
    */

    static public function envioCredito( $data){      

        $ValidarUsuario = GetModel::traerDocumentoUsuario($data['documento']);

        if(empty($ValidarUsuario)){
            $ingresoUsuario = PostModel::envioCredito('usuarios',$data);
        }	      

        $pedido = time() + (60*60*24);
        $fecha_hora = date('Y-m-d H:i:s');

        $ValidarEstado = GetModel::traerDocumentoListaNegra($data['documento']);

        if(!empty($ValidarEstado)){
            $estado = 4;
        }else{
            $estado = 1;
        }
       
        

        $datosSolicitud = [ 
            'fecha' => $fecha_hora,
            'documento_usuario' => $data['documento'] ,
            'tipo_producto' => 1,
            'cod_solicitud' => $pedido,
            'estado_solicitud' => $estado
        ];

        // ingresamos la solicutud de tarjeta de crédito
        $respuestaSolicitud = PostModel::envioCredito('solicitudes',$datosSolicitud);        

        if(!empty($respuestaSolicitud)){

            $mail = new PHPMailer(true);

            try {
                //Server settings
                // $mail->SMTPDebug = 2;                      //Enable verbose debug output
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'smtp.hostinger.com';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username = '';
                $mail->Password = '';                             //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                //Recipients
                $mail->setFrom('', 'Centauros Banck');
                // $mail->addAddress('centaurosbanck@centaurosbanck.devmvrom.website', 'Centauros Banck');     //Add a recipient
                $mail->addAddress($data['correo'] , $data['nombres']);               //Name is optional
                $mail->addReplyTo($data['correo'] , $data['nombres']);

                //Attachments  
                $mail->addAttachment('./img/cantauros_banck.png', 'cantauros_banck.svg.jpg');    //Optional name

                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'Bienvenido a Centauros Banck';
                $body = "<img style='width: 162px;height: 162px;margin: 0 auto; display: flex;' src='https://back-centauros.devmvrom.website/img/cantauros_banck.png'><br> ";
                $body .= "<h2 style='text-align: center;'>Hola <strong>" .$data['nombres']."</strong></h2><br>";
                $body .= "<p style='text-align: center;'>Hola tú número de pedido es </p>  <h2 style='text-align: center;'>$pedido</h2><br>";                
                $body .= "<h3 style='color: green; text-align: center;' >¡Felicitaciones!</h3>";
                $mail->Body = $body;
                $mail->AltBody = 'Hola tú número de pedido es  '.$pedido.'';

                $mail->send();
                $return = new PostController();
                $return -> fncResponse("Mensaje enviado ", null);
            } catch (Exception $e) {
                $respuesta = null;
                $return = new PostController();
                $return -> fncResponse($mail->ErrorInfo, "Error al enviar el correo de pedido");
            }            
        }else{
            $respuesta = null;
            $return = new PostController();
            $return -> fncResponse($respuesta, "Error al ingresar el pedido");
        }
        

    }




    // RESPUESTA DEL CONTROLADOR
    /**
     * @description 
     * @author Mauricio Vargas Romero
     * @date 
     @params n/a 
     @return 
    */

    public function fncResponse($response, $error){               


        if(!empty($response)){

            $json = array(
                'status' => 200,
                'data' => $response,                
                'response' => true,
                'error' => $error
            );
        }else{

            if($error != null){
                $json = array(
                    'status' => 400,
                    'data' => 'No Found',
                    'response' => false,
                    'results' => $error
                );
            }else{
                $json = array(
                    'status' => 404,
                    'data' => 'No Found',
                    'response' => false
                );
            }
            
        }        
        
        echo json_encode($json, http_response_code($json["status"]));        
        
    }


}


?>