
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



    // ENVIO DE DATOS CREDITO
    /**
     * @description 
     * @author Mauricio Vargas Romero
     * @date 
     @params n/a 
     @return 
    */

    static public function envioDatoCredito( $data){      

        $ValidarUsuario = GetModel::envioDatoCredito($data['documento'], $data['pedido']);         

        if(!empty($ValidarUsuario)){
            $return = new PostController();
            $return -> fncResponse($ValidarUsuario, null);
        }else{
            $respuesta = null;
            $return = new PostController();
            $return -> fncResponse($respuesta, "El pedido no existe");
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