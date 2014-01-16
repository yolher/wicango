<?php
require_once('classConexion.php');

class select{


	public function getSearch($palabra,$urlRequest){
	
		$SearchAlert = array('error' => 'Su busqueda no produjo ningun resultado');//alerta del sistema, guarda un array para convertir en objeto json
		//$sql = "select id_entry,name_entry,direccion_entry,telefono_entry,correo_entry,celular_entry from app_entry where name_entry like '%".$palabra."%' || palabras_clave like '%".$palabra."%'";//guarda una consulta o sentencia sql

		$filtro = str_replace(" ", ",", $palabra);
		$numPalabra = str_word_count($palabra);

		$arrayPa = explode(",",$filtro);
		
		$nameFile = $arrayPa[0].rand(0,9999);

		$cabecera = "select id_entry,name_entry,direccion_entry,telefono_entry,correo_entry,celular_entry from app_entry where name_entry like '%".$palabra."%' || palabras_clave like '%".$arrayPa[0]."%' ";
		//========================================================================================

		if ($numPalabra > 1) {
			//========================================================================================
			for($i = 1; $i < $numPalabra; $i++){
				$bodyConsul = " and palabras_clave like '%".$arrayPa[$i]."%'";
				$fileW=fopen("".$nameFile.".txt","a") or die("Problemas");	  	
				fputs($fileW,$bodyConsul);
				fclose($fileW);
			}
			//========================================================================================
			

			$fileR = fopen("".$nameFile.".txt", "r") or exit("Unable to open file!");
			$sql = $cabecera.fgets($fileR);
			fclose($fileR);
			//========================================================================================
			unlink("".$nameFile.".txt");
			// ======================================================================================
		}else{
			$sql = $cabecera;
		}

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
	            				//"direccion_gmap" => $obj->direccion_google,
	            				"telefono" => $obj->telefono_entry,
	            				"correo" => utf8_encode($obj->correo_entry),
	            				"celular" => $obj->celular_entry,
	            				//"web" => utf8_encode($obj->pagina_entry),
	            				//"descripcion" => utf8_encode($obj->desc_entry),
	            				//"hits" => $obj->numHits,
	            				//"thumb" => utf8_encode($obj->thumb_entry),
	            				//"gallery" => utf8_encode($obj->gallery_entry),
	            				//"qrCode" => utf8_encode($qrCode),
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