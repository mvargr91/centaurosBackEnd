<?php

require_once "models/connection.php";
require_once "controllers/post.controller.php";

if(isset($_POST)){

	/*=============================================
	Peticion POST para registrar tarjeta de crédito
	=============================================*/	
	$respuesta = new PostController();

	// ENVIO DE CREDITO
    /**
     * @description 
     * @author Mauricio Vargas Romero
     * @date 
     @params n/a 
     @return 
    */

	if(isset($_GET["solicitudTarjeta"]) && $_GET["solicitudTarjeta"] == true){

		$respuesta->envioCredito($_POST);

	}


    // ENVIO DE SOLICITUDES
    /**
     * @description 
     * @author Mauricio Vargas Romero
     * @date 
     @params n/a 
     @return 
    */

	if(isset($_GET["solicitudEstado"]) && $_GET["solicitudEstado"] == true){

		$respuesta->envioDatoCredito($_POST);

	}

}