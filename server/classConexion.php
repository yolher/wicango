<?php 

session_start();
class Conectar
{
	public static function con()
	{
		$enlace = mysqli_connect("localhost","wicango_us","p33vpVwARncqhW7x","wicango_app");



		//mysql_query("SET NAMES 'utf-8'");

		/* comprobar la conexión */
		if (mysqli_connect_errno()) {
		    printf("Falló la conexión: %s\n", mysqli_connect_error());
		    exit();
		}

		return $enlace;
	}
}

?>