<?php
require_once('classConexion.php');

class select{

	public function getSearch(){
		$array = array('nombre' => 'camilo','telefono'=>'312312323','apellido'=>'hernandez');
		header("Access-Control-Allow-Origin: *"); 
		header('Access-Control-Allow-Methods: GET, POST');
		echo json_encode($array);
	}

}



?>