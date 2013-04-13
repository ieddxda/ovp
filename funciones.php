<?php
////------------------------------------------------------------------------------------------------->
////---------------------------OPEN VOTING PLATFORM-------------------------------------------------->
////----AUTOR: @IEDDXDA------------------------------------------------------------------------------>
////----TWITTER: @IEDDXDA---------------------------------------------------------------------------->
////------------------------------------------------------------------------------------------------->
require 'configuracion_.php';
session_start();
//-----------------------------Obtiene la ruta del tema------------------------------------------------>
function get_theme_folder()
{
	$link =  mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die('Error al conectar. Verifique sus configuraciones.');
	$db_selected = mysql_select_db(DB_NAME, $link) or die('Error al conectar. Verifique sus configuraciones.');
	$query='SELECT * FROM theme WHERE id="1"';
	$result = mysql_query($query)or die('Error al conectar. Verifique sus configuraciones.');
	$row = mysql_fetch_assoc($result);
	return 'contenido/temas/'.$row['folder'];
}

//-----------------------------Obtiene el nombre del sitio----------------------------------------------->
function get_site_name()
{
	$link =  mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die('Error al conectar. Verifique sus configuraciones.');
	$db_selected = mysql_select_db(DB_NAME, $link) or die('Error al conectar. Verifique sus configuraciones.');
	$query='SELECT titulo FROM propiedades WHERE id="1"';
	$result = mysql_query($query)or die('Error al conectar. Verifique sus configuraciones.');
	$row = mysql_fetch_assoc($result);
	return $row['titulo'];
}
//-----------------------------Verifica que un usuario haya iniciado sesión devolviendo "Ok" Si es positivo o "Error" si es negativo.------------------------------------------------>
function clogin(){
	if(isset($_SESSION["conf"]["usr"]))
	{
		if(isset($_SESSION["conf"]["pwd"]))
		{
			if(isset($_SESSION["conf"]["auth2"]))
			{
				if (get_usr_val()=="ok")
				{
					return "ok";
				}
				else
				{
					return "No puedes acceder a esta área sin haber iniciado sesión primero.";
				}
			}
			else
			{
				return "No puedes acceder a esta área sin haber iniciado sesión primero.";
			}
		}
		else{
			return "No puedes acceder a esta área sin haber iniciado sesión primero.";
		}
		
	}
	else
	{
		return "No puedes acceder a esta área sin haber iniciado sesión primero.";
	}
}
//-----------------------------Obtiene todas las propuestas que estén marcadas como "EFECTIVA" o "EMPATE"------------------------------------------------>
function get_resultados(){
	$link =  mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die('Error al conectar. Verifique sus configuraciones.');
	$db_selected = mysql_select_db(DB_NAME, $link) or die('Error al conectar. Verifique sus configuraciones.');
	$query='SELECT * FROM propuestas WHERE (propuestas.estado="EFECTIVA" OR propuestas.estado="EMPATE") ;';
	$result = mysql_query($query)or die('Error al conectar. Verifique sus configuraciones.');
	$nl=1;
	while ($fila = mysql_fetch_assoc($result)) {
	echo '<li style="padding-top:15px;">';
    echo '<em style="color:#fff; font-size:13pt;">'.decriptar_comentario($fila["titulo"],$Key_secret).'</em>';
	echo '<br /><strong class="text4"> Estado: '.$fila["estado"].'</strong>';
    echo '<p class="text4" style="font-size:10pt;">'.decriptar_comentario($fila["descripcion"],$Key_secret).'</p>';
	echo ' </span> </a></li>';
	echo '<div class="relative"><a href="details.php?id='.$fila["id"].'" class="button2"><span></span><strong>Ver Detalles</strong></a></div>';
	$nl++;
	}
}
//-----------------------------Obtiene 10 propuestas que estén marcadas como "En debate"------------------------------------------------>
function get_propuestas()
{
	$link =  mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die('Error al conectar. Verifique sus configuraciones.');
	$db_selected = mysql_select_db(DB_NAME, $link) or die('Error al conectar. Verifique sus configuraciones.');
	$query='SELECT * FROM propuestas WHERE estado="En debate" LIMIT 10;';
	$result = mysql_query($query)or die('Error al conectar. Verifique sus configuraciones.');
	$nl=1;
	while ($fila = mysql_fetch_assoc($result)) {
	echo '<li style="padding-top:15px;">';
    echo '<em style="color:#fff; font-size:13pt;">'.decriptar_comentario($fila["titulo"],$Key_secret).'</em>';
	echo '<br /><strong class="text4"> Estado: '.$fila["estado"].'</strong>';
    echo '<p class="text4" style="font-size:10pt;">'.decriptar_comentario($fila["descripcion"],$Key_secret).'</p>';
	echo ' </span> </a></li>';
	echo '<div class="relative"><a href="propuesta.php?id='.$fila["id"].'" class="button2"><span></span><strong>Debatir/Votar</strong></a></div>';
	$nl++;
	}
}
//-----------------------------Verifica si existe una propuesta------------------------------------------------>
function get_propuesta_exist($ID){
	$link =  mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die('Error al conectar. Verifique sus configuraciones.');
	$db_selected = mysql_select_db(DB_NAME, $link) or die('Error al conectar. Verifique sus configuraciones.');
	$query='SELECT id FROM propuestas WHERE id="'.$ID.'"';
	$result = mysql_query($query)or die('Error al conectar. Verifique sus configuraciones.');
	$row = mysql_fetch_assoc($result);
	return mysql_num_rows($result);
}
//-----------------------------Verifica si existe el debate en una propuesta------------------------------------------------>
function get_propuesta_comm_exist($ID){
	$link =  mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die('Error al conectar. Verifique sus configuraciones.');
	$db_selected = mysql_select_db(DB_NAME, $link) or die('Error al conectar. Verifique sus configuraciones.');
	$query='SELECT * FROM debate WHERE id_propuesta="'.$ID.'"';
	$result = mysql_query($query)or die('Error al conectar. Verifique sus configuraciones.');
	$row = mysql_fetch_assoc($result);
	return mysql_num_rows($result);
}

//-----------------------------Obtiene el título de una propuesta------------------------------------------------>
function get_propuesta_titulo($ID)
{
	$link =  mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die('Error al conectar. Verifique sus configuraciones.');
	$db_selected = mysql_select_db(DB_NAME, $link) or die('Error al conectar. Verifique sus configuraciones.');
	$query='SELECT titulo FROM propuestas WHERE id="'.$ID.'";';
	$result = mysql_query($query)or die('Error al conectar. Verifique sus configuraciones.');
	$row = mysql_fetch_assoc($result);
	return htmlentities($row['titulo'],ENT_QUOTES);
}
//-----------------------------Obtiene el estado de una propuesta------------------------------------------------>
function get_propuesta_estado($ID)
{
	$link =  mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die('Error al conectar. Verifique sus configuraciones.');
	$db_selected = mysql_select_db(DB_NAME, $link) or die('Error al conectar. Verifique sus configuraciones.');
	$query='SELECT estado FROM propuestas WHERE id="'.$ID.'";';
	$result = mysql_query($query)or die('Error al conectar. Verifique sus configuraciones.');
	$row = mysql_fetch_assoc($result);
	return htmlentities($row['estado'],ENT_QUOTES);
}
//-----------------------------Obtiene el ID de la propuesta------------------------------------------------>
function get_propuesta_id($UID)
{
	$link =  mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die('Error al conectar. Verifique sus configuraciones.');
	$db_selected = mysql_select_db(DB_NAME, $link) or die('Error al conectar. Verifique sus configuraciones.');
	$query='SELECT id FROM propuestas WHERE uid="'.$UID.'";';
	$result = mysql_query($query)or die('Error al conectar. Verifique sus configuraciones.');
	$row = mysql_fetch_assoc($result);
	return htmlentities($row['id'],ENT_QUOTES);
}
//-----------------------------Obtiene el nick del usuario que hizo la propuesta------------------------------------------------>
function get_propuesta_autor($ID)
{
	$link =  mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die('Error al conectar. Verifique sus configuraciones.');
	$db_selected = mysql_select_db(DB_NAME, $link) or die('Error al conectar. Verifique sus configuraciones.');
	$query='SELECT autor FROM propuestas WHERE id="'.$ID.'";';
	$result = mysql_query($query)or die('Error al conectar. Verifique sus configuraciones.');
	$row = mysql_fetch_assoc($result);
	return htmlentities($row['autor'],ENT_QUOTES);
}

//-----------------------------Obtiene el URL completo del navegador [Opcional]------------------------------------------------>
function full_url()
{
    $s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
    $sp = strtolower($_SERVER["SERVER_PROTOCOL"]);
    $protocol = substr($sp, 0, strpos($sp, "/")) . $s;
    $port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]);
    return $protocol . "://" . $_SERVER['SERVER_NAME'] . $port . $_SERVER['REQUEST_URI'];
}
//-----------------------------Obtiene la descripción de una propuesta------------------------------------------------>
function get_propuesta_desc($ID)
{
	$link =  mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die('Error al conectar. Verifique sus configuraciones.');
	$db_selected = mysql_select_db(DB_NAME, $link) or die('Error al conectar. Verifique sus configuraciones.');
	$query='SELECT descripcion FROM propuestas WHERE id="'.$ID.'"';
	$result = mysql_query($query)or die('Error al conectar. Verifique sus configuraciones.');
	$row = mysql_fetch_assoc($result);
	return htmlentities($row['descripcion'],ENT_QUOTES);
}
//-----------------------------Obtiene el contenido de una propuesta------------------------------------------------>
function get_propuesta_cont($ID)
{
	$link =  mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die('Error al conectar. Verifique sus configuraciones.');
	$db_selected = mysql_select_db(DB_NAME, $link) or die('Error al conectar. Verifique sus configuraciones.');
	$query='SELECT contenido FROM propuestas WHERE id="'.$ID.'"';
	$result = mysql_query($query)or die('Error al conectar. Verifique sus configuraciones.');
	$row = mysql_fetch_assoc($result);
	return htmlentities($row['contenido'],ENT_QUOTES);
}
//-----------------------------Obtiene el número de votos de una propuesta------------------------------------------------>
function get_propuesta_votos($ID)
{
	$link =  mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die('Error al conectar. Verifique sus configuraciones.');
	$db_selected = mysql_select_db(DB_NAME, $link) or die('Error al conectar. Verifique sus configuraciones.');
	$query='SELECT voto FROM votos WHERE id_propuesta="'.$ID.'"';
	$result = mysql_query($query)or die('Error al conectar. Verifique sus configuraciones.');
	$row = mysql_fetch_assoc($result);
	return mysql_num_rows($result);
}
//-----------------------------Obtiene el quórum que el usuario estableció para una propuesta------------------------------------------------>

function get_propuesta_quorum($ID)
{
	$link =  mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die('Error al conectar. Verifique sus configuraciones.');
	$db_selected = mysql_select_db(DB_NAME, $link) or die('Error al conectar. Verifique sus configuraciones.');
	$query='SELECT quorum FROM propuestas WHERE id="'.$ID.'"';
	$result = mysql_query($query)or die('Error al conectar. Verifique sus configuraciones.');
	$row = mysql_fetch_assoc($result);
	return $row['quorum'];
}
//-----------------------------Obtiene los resultados de la propuesta------------------------------------------------>
function get_propuesta_ganador($ID){
	$votos=array();
	$link =  mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die('Error al conectar. Verifique sus configuraciones.');
	$db_selected = mysql_select_db(DB_NAME, $link) or die('Error al conectar. Verifique sus configuraciones.');
	$query='SELECT * FROM opciones_propuesta WHERE id_propuesta="'.$ID.'";';
	$result = mysql_query($query)or die('Error al conectar. Verifique sus configuraciones.');
	$n_o=0;
	while ($fila = mysql_fetch_assoc($result)) {
		$votos[$n_o]=" ".decriptar_comentario($fila['opcion'],$Key_secret);
		$query2='SELECT * FROM votos WHERE id_propuesta="'.$ID.'" AND voto="'.$fila['id_voto'].'";';
		$result2 = mysql_query($query2)or die('Error al conectar. Verifique sus configuraciones.');
		$votos[$n_o][0]=mysql_num_rows($result2);
		$n_o++;
	}
	rsort($votos);
	if($votos[0][0]==$votos[1][0]){
		
		return "<label style='color:#F60;font-size:21pt;'>EMPATE ENTRE ".ltrim($votos[0],'0123456789')." CON ".$votos[0][0]." VOTOS</label><br /><p style='color:#F60;font-size:21pt;padding-top:10px;'> Y ".ltrim($votos[1],'0123456789')." CON ".$votos[1][0]." VOTOS IGUALMENTE</p>";
	}
	else
	{
			return "<label style='color:#FFF;font-size:30pt;'>ENHORABUENA! GANA:</label><p style='color:#FFF;font-size:35pt;padding-top:25px;'> ".ltrim($votos[0],'0123456789')."</p> <p style='padding-top:25px;'>CON ".$votos[0][0]." VOTOS. <a href='details.php?id=$ID'>DETALLES</a></p>";
	}
}
//---------------------------Valida si un usuario ha iniciado sesión y verifica los datos guardado temporalmente.------------->
function get_usr_val()
{
$usr=$_SESSION["conf"]["usr"];
$pwd=$_SESSION["conf"]["pwd"];
$auth2=$_SESSION["conf"]["auth2"];
	$link =  mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die('Error al conectar. Verifique sus configuraciones.');
	$db_selected = mysql_select_db(DB_NAME, $link) or die('Error al conectar. Verifique sus configuraciones.');
	$query='SELECT auth2 FROM auth WHERE user="'.$usr.'" AND pass="'.$pwd.'" AND auth2="'.$auth2.'"';
	$result = mysql_query($query)or die('Error al conectar. Verifique sus configuraciones.');
	if (mysql_num_rows($result) == 0)
	{
		return "No puedes acceder sin haber iniciado sesión.";
	}
	else
	{
		return "ok";
	}
}
//---------------------------Verifica si ya existe un usuario en la base de datos [CIFRADO]------------->
function get_usrnew_exist($usuario_cifrado){
	$link =  mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die('Error al conectar. Verifique sus configuraciones.');
	$db_selected = mysql_select_db(DB_NAME, $link) or die('Error al conectar. Verifique sus configuraciones.');
	$query='SELECT auth2 FROM auth WHERE user="'.$usuario_cifrado.'";';
	$result = mysql_query($query)or die('Error al conectar. Verifique sus configuraciones.');
	if (mysql_num_rows($result) == 0)
	{
		return "Error";
	}
	else
	{
		$row = mysql_fetch_assoc($result);
		return $row['auth2'];
	}
}
//---------------------------Verifica si ya existe un usuario en la base de datos con contraseña [CIFRADO]------------->
function get_usr_exist($usuario,$password){
	$link =  mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die('Error al conectar. Verifique sus configuraciones.');
	$db_selected = mysql_select_db(DB_NAME, $link) or die('Error al conectar. Verifique sus configuraciones.');
	$query='SELECT auth2 FROM auth WHERE user="'.$usuario.'" AND pass="'.$password.'";';
	$result = mysql_query($query)or die('Error al conectar. Verifique sus configuraciones.');
	if (mysql_num_rows($result) == 0)
	{
		return "Error";
	}
	else
	{
		$row = mysql_fetch_assoc($result);
		return $row['auth2'];
	}
}
//---------------------------Obtiene el ID de usuario------------->
function get_usr_id($usuario,$password){
	$link =  mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die('Error al conectar. Verifique sus configuraciones.');
	$db_selected = mysql_select_db(DB_NAME, $link) or die('Error al conectar. Verifique sus configuraciones.');
	$query='SELECT id FROM auth WHERE user="'.$usuario.'" AND pass="'.$password.'";';
	$result = mysql_query($query)or die('Error al conectar. Verifique sus configuraciones.');
	if (mysql_num_rows($result) == 0)
	{
		return "Error";
	}
	else
	{
		$row = mysql_fetch_assoc($result);
		return $row['id'];
	}
}
//---------------------------Verifica si un usuario ya ha votado alguna propuesta------------->
function get_usr_yavoto($id_usuario,$id_propuesta){
	$link =  mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die('Error al conectar. Verifique sus configuraciones.');
	$db_selected = mysql_select_db(DB_NAME, $link) or die('Error al conectar. Verifique sus configuraciones.');
	$query='SELECT * FROM votos WHERE id_usuario="'.$id_usuario.'" AND id_propuesta="'.$id_propuesta.'";';
	$result = mysql_query($query)or die('Error al conectar. Verifique sus configuraciones.');
	if (mysql_num_rows($result) == 0)
	{
		return "Not";
	}
	else
	{
		$row = mysql_fetch_assoc($result);
		return $row['id'];
	}
}
//-------------------------------------------------------Obtiene el nombre de usuario------------->
function get_usr_nombre($auth){
	$link =  mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die('Error al conectar. Verifique sus configuraciones.');
	$db_selected = mysql_select_db(DB_NAME, $link) or die('Error al conectar. Verifique sus configuraciones.');
	$query='SELECT nombre FROM auth WHERE auth2="'.$auth.'" LIMIT 1;';
	$result = mysql_query($query)or die('Error al conectar. Verifique sus configuraciones.');
	if (mysql_num_rows($result) == 0)
	{
		return "Not";
	}
	else
	{
		$row = mysql_fetch_assoc($result);
		return $row['nombre'];
	}
}
//-------------------------------------------------------Obtiene los datos de Facebook que un usuario haya registrado------------->
function get_usr_facebook($auth){
	$link =  mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die('Error al conectar. Verifique sus configuraciones.');
	$db_selected = mysql_select_db(DB_NAME, $link) or die('Error al conectar. Verifique sus configuraciones.');
	$query='SELECT fb FROM auth WHERE auth2="'.$auth.'" LIMIT 1;';
	$result = mysql_query($query)or die('Error al conectar. Verifique sus configuraciones.');
	if (mysql_num_rows($result) == 0)
	{
		return "Not";
	}
	else
	{
		$row = mysql_fetch_assoc($result);
		return $row['fb'];
	}
}
//-------------------------------------------------------Obtiene los datos de Twitter que un usuario haya registrado------------->
function get_usr_twitter($auth){
	$link =  mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die('Error al conectar. Verifique sus configuraciones.');
	$db_selected = mysql_select_db(DB_NAME, $link) or die('Error al conectar. Verifique sus configuraciones.');
	$query='SELECT tw FROM auth WHERE auth2="'.$auth.'" LIMIT 1;';
	$result = mysql_query($query)or die('Error al conectar. Verifique sus configuraciones.');
	if (mysql_num_rows($result) == 0)
	{
		return "Not";
	}
	else
	{
		$row = mysql_fetch_assoc($result);
		return $row['tw'];
	}
}
//-------------------------------------------------------Obtiene el e-mail que un usuario haya registrado------------->
function get_usr_email($auth){
	$link =  mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die('Error al conectar. Verifique sus configuraciones.');
	$db_selected = mysql_select_db(DB_NAME, $link) or die('Error al conectar. Verifique sus configuraciones.');
	$query='SELECT mail FROM auth WHERE auth2="'.$auth.'" LIMIT 1;';
	$result = mysql_query($query)or die('Error al conectar. Verifique sus configuraciones.');
	if (mysql_num_rows($result) == 0)
	{
		return "Not";
	}
	else
	{
		$row = mysql_fetch_assoc($result);
		return $row['mail'];
	}
}
//-------------------------------------------------------Obtiene el estado de un usuario [Activo por default]------------->
function get_usr_estado($auth){
	$link =  mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die('Error al conectar. Verifique sus configuraciones.');
	$db_selected = mysql_select_db(DB_NAME, $link) or die('Error al conectar. Verifique sus configuraciones.');
	$query='SELECT status FROM auth WHERE auth2="'.$auth.'" LIMIT 1;';
	$result = mysql_query($query)or die('Error al conectar. Verifique sus configuraciones.');
	if (mysql_num_rows($result) == 0)
	{
		return "Not";
	}
	else
	{
		$row = mysql_fetch_assoc($result);
		return $row['status'];
	}
}
//-------------------------------------------------------Obtiene el nick registrado por un usuario------------->
function get_usr_nick($auth){
	$link =  mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die('Error al conectar. Verifique sus configuraciones.');
	$db_selected = mysql_select_db(DB_NAME, $link) or die('Error al conectar. Verifique sus configuraciones.');
	$query='SELECT user FROM auth WHERE auth2="'.$auth.'" LIMIT 1;';
	$result = mysql_query($query)or die('Error al conectar. Verifique sus configuraciones.');
	if (mysql_num_rows($result) == 0)
	{
		return "Not";
	}
	else
	{
		$row = mysql_fetch_assoc($result);
		return $row['user'];
	}
}
//-----------------------------------------------------Obtiene la contraseña de un usuario para mostrarla en su perfil------------->
function get_usr_pass($auth){
	$link =  mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die('Error al conectar. Verifique sus configuraciones.');
	$db_selected = mysql_select_db(DB_NAME, $link) or die('Error al conectar. Verifique sus configuraciones.');
	$query='SELECT pass FROM auth WHERE auth2="'.$auth.'" LIMIT 1;';
	$result = mysql_query($query)or die('Error al conectar. Verifique sus configuraciones.');
	if (mysql_num_rows($result) == 0)
	{
		return "Not";
	}
	else
	{
		$row = mysql_fetch_assoc($result);
		return $row['pass'];
	}
}
//-------------------------------------------------------Obtiene el status de una propuesta [Efectiva o Empate]------------->
function update_estado_propuesta($ID,$Estado){
	if ($Estado=="EMPATE")
	{
	$link =  mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die('Error al conectar. Verifique sus configuraciones.');
	$db_selected = mysql_select_db(DB_NAME, $link) or die('Error al conectar. Verifique sus configuraciones.');
	$query='UPDATE propuestas SET estado="EMPATE" WHERE id="'.$ID.'";';
	$result = mysql_query($query)or die('Error al conectar. Verifique sus configuraciones.');
	}
	if ($Estado=="EFECTIVA")
	{
	$link =  mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die('Error al conectar. Verifique sus configuraciones.');
	$db_selected = mysql_select_db(DB_NAME, $link) or die('Error al conectar. Verifique sus configuraciones.');
	$query='UPDATE propuestas SET estado="EFECTIVA" WHERE id="'.$ID.'";';
	$result = mysql_query($query)or die('Error al conectar. Verifique sus configuraciones.');
	}
}

//--------------------------------------------------Actualiza los datos de un usuario por su Token 'Auth2'------------->
function update_usr_data($usuario,$pass,$nombre,$fb,$tw,$mail,$auth){
	$link =  mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die('Error al conectar. Verifique sus configuraciones.');
	$db_selected = mysql_select_db(DB_NAME, $link) or die('Error al conectar. Verifique sus configuraciones.');
	$query='UPDATE auth SET user="'.$usuario.'",pass="'.$pass.'",nombre="'.$nombre.'",fb="'.$fb.'",tw="'.$tw.'",mail="'.$mail.'" WHERE auth2="'.$auth.'";';
	$result = mysql_query($query)or die('Error al conectar. Verifique sus configuraciones.');
}
//-----------------------------Actualiza los comentarios en un 'debate'------------------------------------------------>
function update_usr_data_comm($idusr,$nick){
	$link =  mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die('Error al conectar. Verifique sus configuraciones.');
	$db_selected = mysql_select_db(DB_NAME, $link) or die('Error al conectar. Verifique sus configuraciones.');
	$query='UPDATE debate SET nick="'.$usuario.'" WHERE id_autor="'.$idusr.'";';
	$result = mysql_query($query)or die('Error al conectar. Verifique sus configuraciones.');
}
//-----------------------------Actualiza el nombre de usuario en las propuestas [Aún no implementado]------------------------------------------------>
function update_usr_data_prop($idusr,$nick){
	$link =  mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die('Error al conectar. Verifique sus configuraciones.');
	$db_selected = mysql_select_db(DB_NAME, $link) or die('Error al conectar. Verifique sus configuraciones.');
	$query='UPDATE propuestas SET autor="'.$nick.'" WHERE id_autor="'.$idusr.'";';
	$result = mysql_query($query)or die('Error al conectar. Verifique sus configuraciones.');
}
//-----------------------------Obtiene la cantidad de usuarios registrados [Para establecer una recomendación del 'Quórum']------------------------------------------------>
function numero_usuarios(){
	$link =  mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die('Error al conectar. Verifique sus configuraciones.');
	$db_selected = mysql_select_db(DB_NAME, $link) or die('Error al conectar. Verifique sus configuraciones.');
	$query='SELECT * FROM auth;';
	$result = mysql_query($query)or die('Error al conectar. Verifique sus configuraciones.');
	$row = mysql_fetch_assoc($result);
	return mysql_num_rows($result);
}
//-----------------------------Guarda el voto de un usuario en la base de datos------------------------------------------------>
function votar_propuesta($ID,$id_voto,$hora,$ip,$idusr){

	$link =  mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die('Error al conectar. Verifique sus configuraciones.');
	$db_selected = mysql_select_db(DB_NAME, $link) or die('Error al conectar. Verifique sus configuraciones.');
	$query='INSERT INTO votos (voto,id_propuesta,id_usuario,hora,ip) VALUES ("'.$id_voto.'","'.$ID.'","'.$idusr.'","'.$hora.'","'.$ip.'") ;';
	$result = mysql_query($query)or die('Error al conectar. Verifique sus configuraciones.');
	echo "<label style='color:#fff;'>Gracias por tu voto!</label>";
}
//-----------------------------Guarda el voto de un usuario en la base de datos------------------------------------------------>
function enviar_comentario_propuesta($ID,$hora,$ip,$idusr,$comentario,$nick){

	$link =  mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die('Error al conectar. Verifique sus configuraciones.');
	$db_selected = mysql_select_db(DB_NAME, $link) or die('Error al conectar. Verifique sus configuraciones.');
	$query='INSERT INTO debate (id_propuesta,id_autor,comentario,fecha,ip,nick) VALUES ("'.$ID.'","'.$idusr.'","'.$comentario.'","'.$hora.'","'.$ip.'","'.$nick.'") ;';
	$result = mysql_query($query)or die('Error al conectar. Verifique sus configuraciones.');
	echo "<label style='color:#fff;'>Tu comentario se ha enviado</label> <a onclick='parent.abc();' href='comm.php?id=".$ID."'>Comentar</a>";
}

 //-----------------------------Cifrar texto------------------------------------------------>
function encriptar_comentario($str,$ky='')
{	
if($ky=='')return $str; 
$ky=str_replace(chr(32),'',$ky); 
if(strlen($ky)<8)exit('key error'); 
$kl=strlen($ky)<32?strlen($ky):32; 
$k=array();for($i=0;$i<$kl;$i++){ 
$k[$i]=ord($ky{$i})&0x1F;} 
$j=0;for($i=0;$i<strlen($str);$i++){ 
$e=ord($str{$i}); 
$str{$i}=$e&0xE0?chr($e^$k[$j]):chr($e); 
$j++;$j=$j==$kl?0:$j;} 
return base64_encode($str); 
}
//-----------------------------Decifrar texto------------------------------------------------>
function decriptar_comentario($str,$ky='')
{	
$str=base64_decode($str);
if($ky=='')return $str; 
$ky=str_replace(chr(32),'',$ky); 
if(strlen($ky)<8)exit('key error'); 
$kl=strlen($ky)<32?strlen($ky):32; 
$k=array();for($i=0;$i<$kl;$i++){ 
$k[$i]=ord($ky{$i})&0x1F;} 
$j=0;for($i=0;$i<strlen($str);$i++){ 
$e=ord($str{$i}); 
$str{$i}=$e&0xE0?chr($e^$k[$j]):chr($e); 
$j++;$j=$j==$kl?0:$j;} 
return $str; 
}
//-----------------------------Guarda una nueva propuesta en la base de datos------------------------------------------------>
function agregar_nueva_propuesta($titulo,$descripcion,$estado,$autor,$contenido,$quorum,$idusr,$fecha,$ip,$uid){
	$link =  mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die('Error al conectar. Verifique sus configuraciones.');
	$db_selected = mysql_select_db(DB_NAME, $link) or die('Error al conectar. Verifique sus configuraciones.');
	$query='INSERT INTO propuestas (titulo,descripcion,estado,autor,contenido,quorum,id_autor,fecha,ip,uid) VALUES ("'.$titulo.'","'.$descripcion.'","'.$estado.'","'.$autor.'","'.$contenido.'","'.$quorum.'","'.$idusr.'","'.$fecha.'","'.$ip.'","'.$uid.'");';
	$result = mysql_query($query)or die('Error al conectar. Verifique sus configuraciones.');
}
//-----------------------------Agrega una opción enlazada a una nueva propuesta.[INDISPENSABLE] ------------------------------------------------>
function agregar_nueva_opcion($opcion,$id_propuesta,$id_voto){
	$link =  mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die('Error al conectar. Verifique sus configuraciones.');
	$db_selected = mysql_select_db(DB_NAME, $link) or die('Error al conectar. Verifique sus configuraciones.');
	$query='INSERT INTO opciones_propuesta (id_propuesta,opcion,id_voto) VALUES ("'.$id_propuesta.'","'.$opcion.'","'.$id_voto.'");';
	$result = mysql_query($query)or die('Error al conectar. Verifique sus configuraciones.');
}
//-----------------------------Registra un nuevo usuario------------------------------------------------>
function agregar_nuevo_usuario($user,$pass,$authx,$nombre,$fb,$tw,$mail,$fecha,$ip,$status){
	$link =  mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die('Error al conectar. Verifique sus configuraciones.');
	$db_selected = mysql_select_db(DB_NAME, $link) or die('Error al conectar. Verifique sus configuraciones.');
	$query='INSERT INTO auth (user,pass,auth2,nombre,fb,tw,mail,fecha,ip,status) VALUES ("'.$user.'","'.$pass.'","'.$authx.'","'.$nombre.'","'.$fb.'","'.$tw.'","'.$mail.'","'.$fecha.'","'.$ip.'","'.$status.'");';
	$result = mysql_query($query)or die('Error al conectar. Verifique sus configuraciones.');
}

////------------------------------------------------------------------------------------------------->
////---------------------------OPEN VOTING PLATFORM-------------------------------------------------->
////----AUTOR: @IEDDXDA------------------------------------------------------------------------------>
////----TWITTER: @IEDDXDA---------------------------------------------------------------------------->
////------------------------------------------------------------------------------------------------->
?>