<?php   
////------------------------------------------------------------------------------------------------->
////---------------------------OPEN VOTING PLATFORM-------------------------------------------------->
////----AUTOR: @IEDDXDA------------------------------------------------------------------------------>
////----TWITTER: @IEDDXDA---------------------------------------------------------------------------->
////------------------------------------------------------------------------------------------------->
include 'funciones.php';//Llamamos la clase de todas las funciones de la plataforma
session_start();//Iniciamos una sesión temporal
$_SESSION["conf"]["th"]=get_theme_folder();//Obtenemos la ruta del tema que usaremos
$_SESSION["conf"]["name"]=get_site_name();//Obtenemos el nombre del sitio web
$theme=$_SESSION["conf"]["th"];
$nombre_sitio=$_SESSION["conf"]["name"];
if(strstr($theme,'Error')){//Si los datos del tema no existen se muestra un error que lo indica.
	echo '<p>No se pueden cargar las configuraciones.</p>';exit;
	}
else
{
	header('Content-type: text/html; charset=utf8');
	include($theme."/index.php");// Se carga el tema
 }
////------------------------------------------------------------------------------------------------->
////---------------------------OPEN VOTING PLATFORM-------------------------------------------------->
////----AUTOR: @IEDDXDA------------------------------------------------------------------------------>
////----TWITTER: @IEDDXDA---------------------------------------------------------------------------->
////------------------------------------------------------------------------------------------------->
?>