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
		$datos = new select();//instancia el objeto seleccionado (new select)		
		$search = $datos->getSearch($palabra);//llama el metodo (getSearch) del objeto seleccionado (new select()) 

		//Recorremos el array de respuesta del servidor
		for ($i=0; $i <count($search) ; $i++) { 
			//imprimimos los resultados como un objeto json
			echo json_encode($search[$i]);
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