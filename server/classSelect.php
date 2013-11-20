<?php
require_once('classConexion.php');

class select{


	public function getSearch($palabra,$urlRequest){
	
		$SearchAlert = array('error' => 'Su busqueda no produjo ningun resultado');//alerta del sistema, guarda un array para convertir en objeto json
		$sql = "select * from app_entry where palabras_clave like '%".$palabra."%' || name_entry like '%".$palabra."%'";//guarda una consulta o sentencia sql
		//guarda el objeto de conecion con la base de datos
		$enlace = Conectar::con(); 

		if($sentencia = mysqli_prepare($enlace,$sql)){
			mysqli_stmt_execute($sentencia); /* ejecutar la consulta */
			mysqli_stmt_store_result($sentencia); /* almacenar el resultado */
            $result = mysqli_stmt_num_rows($sentencia);
            // si el valor de $resul es > 0 siginifica que existe resultados
            if ($result > 0) {

            	if ($resultado = mysqli_query($enlace, $sql)) {
            	
	            	while($obj = mysqli_fetch_object($resultado)){
	            		// construccion de url amigable
	            		$link =  str_replace(" ","-",$obj->name_entry)."-entrada-".$obj->id_entry.".html";
	            		// generacion de codigo qr apartir del link o direccion generado
	            		$qrCode = "http://www.codigos-qr.com/qr/php/qr_img.php?d=".$urlRequest.$link."&s=14&e="; 

	            		// almacena los valotes de la base de datos en un array
	            		$arr[] = array(
	            				"name" => utf8_encode($obj->name_entry),
	            				"direccion" => $obj->direccion_entry,
	            				"direccion_gmap" => $obj->direccion_google,
	            				"telefono" => $obj->telefono_entry,
	            				"correo" => utf8_encode($obj->correo_entry),
	            				"celular" => $obj->celular_entry,
	            				"web" => utf8_encode($obj->pagina_entry),
	            				"descripcion" => utf8_encode($obj->desc_entry),
	            				"hits" => $obj->numHits,
	            				"thumb" => utf8_encode($obj->thumb_entry),
	            				"gallery" => utf8_encode($obj->gallery_entry),
	            				"qrCode" => utf8_encode($qrCode),
	            				"url" => utf8_encode($link)
	            		);
	            	}
	            	// impirme los datos del array en formato json
	            	echo '' . json_encode($arr) . '';
	            	/* liberar el conjunto de resultados */
                	mysqli_free_result($resultado);
                }

            }else{
            	// si no existen resultados de la consulta
            	echo json_encode($SearchAlert);
            }
		}

	}

}


?>