<?php 
session_start();
class Conectar
{
	public static function con()
	{
		 $conexion=mysql_connect("localhost","wicango_us","p33vpVwARncqhW7x");
	    mysql_query("SET NAMES 'utf-8'");
	    mysql_select_db("wicango_app");

		return $conexion;
	}
}
?>