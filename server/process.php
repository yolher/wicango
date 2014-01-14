<?php

require_once("classSelect.php");


if (isset($_GET["search"])!=0 && isset($_GET["key"])!=0) {
	

	$keyAccess = $_GET["key"];//guarda el valor de la llave, controla la accion que se va a ejecutar

	//=================== funcion que controla la peticion de los datos desde el servidor
	function getBusqueda(){

		//caebeceras que desatcivan la resticcion crossdomain y permite hacer la peticion atraves de dominios
		header("Access-Control-Allow-Origin: *"); 
		header('Access-Control-Allow-Methods: GET, POST');

		$palabra = $_GET["search"];//guarda el string introducido por el usuario en el buscador
		$urlRequest = $_GET["urlRequest"];//url del domino donde se aloja la informacion

		if ($palabra == NULL) {
			$campoVacio = array('error' => 'El campo esta vacio');// alerta del sistema, campo vacio, guarda un array para convertir en objeto json
			echo json_encode($campoVacio);//imprime los datos del array en formato json
		}else{
			$datos = new select();//instancia el objeto seleccionado (new select)		
			$search = $datos->getSearch($palabra,$urlRequest);//llama el metodo (getSearch) del objeto seleccionado (new select()) 
		}

	}


	switch ($keyAccess) {
		case 'into':
			getBusqueda();
			break;
		
		default:
			
			break;
	}
}else{
	echo "Estas ingresando ilegalmente";
}

?>