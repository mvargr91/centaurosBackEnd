<?php

require_once "models/connection.php";
require_once "controllers/get.controller.php";

$routesArray = explode("/", $_SERVER['REQUEST_URI']);
$routesArray = array_filter($routesArray);

/*=============================================
Cuando no se hace ninguna petición a la API
=============================================*/

if(count($routesArray) == 0){

	$json = array(

		'status' => 404,
		'results' => 'Not Found'

	);

	echo json_encode($json, http_response_code($json["status"]));

	return;

}

/*=============================================
Cuando si se hace una petición a la API
=============================================*/

if(count($routesArray) == 1 && isset($_SERVER['REQUEST_METHOD'])){

	
	/*=============================================
	Peticiones GET
	=============================================*/

	if($_SERVER['REQUEST_METHOD'] == "GET"){

		include "services/get.php";

	}

	/*=============================================
	Peticiones POST
	=============================================*/

	if($_SERVER['REQUEST_METHOD'] == "POST"){

		include "services/post.php";

	}



}


