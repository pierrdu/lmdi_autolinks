<?php
/**
 *
 * @package	Extension Autolink [Spanish]
 * @author	Máté Bartus <bartus.mate@root.hu>
 * @version	$Id: info_acp_autolink.php 46 2010-07-20 14:14:53Z CHItA $
 *
 **/
 
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}
$lang = array_merge($lang, array(

	// Menu's text and titles
	'AUTOLINK_MOD_MENU_NAME'			=> 'Auto Enlace',
	'ACP_AUTOLINK'						=> 'Administración de Auto Enlace',
	'AUTOLINK_ADD_A_NEW_WORD'			=> 'Añadir nuevo Auto Enlace',
	
	// Main form's words
	'ACP_AUTOLINK_CONFIG'				=> 'Ajustes de configuracion de Auto Enlace',	
	
	'ACP_AUTOLINK_WORDS'				=> 'Manejar palabras',
	'ACP_AUTOLINK_WORD'					=> 'Palabra',
	'ACP_AUTOLINK_WORD_NOTE'			=> 'Aquí puede ajustar las palabras para convertir en enlace. El Auto Enlace no hace diferencias entre mayúsculas y minúsculas.',
	'ACP_AUTOLINK_URL'					=> 'URL',
	'ACP_AUTOLINK_URL_NOTE'				=> 'Aquí puede establecer una URL para la palabra anterior.',
	
	// Logs
	'LOG_AUTOLINK_WORD_ADDED'			=> '¡Una nueva palabra (%s) ha sido añadida correctamente a la base de datos de Auto Enlace!',
	'LOG_AUTOLINK_WORD_EDIT'			=> 'Los detalles de la palabra “%s” han sido actualizados en la base de datos de Auto Enlace!',
	'LOG_AUTOLIMK_WORD_DELETE'			=> '¡La palabra “%s” ha sido eliminada de la base de datos de Auto Enlace!',
	'LOG_AUTOLINK_CONFIG_UPDATED'		=> 'La configuracion de ajustes de Auto Enlace ha sido actualizada.',	
	
	// ACP table heading words
	'AUTOLINK_NAME'						=> 'Palabra',
	'AUTOLINK_URL'						=> 'URL',
	
	// Error messages
	'AUTOLINK_NOT_ADDED'				=> '¡La palabra no ha sido añadida a la base de datos de Auto Enlace!',
	'AUTOLINK_NOT_REMOVED'				=> '¡La palabra no ha sido eliminada de la base de datos de Auto Enlace!',
	'AUTOLINK_NOT_UPDATED'				=> '¡La palabra no ha sido actualizada en la base de datos de Auto Enlace!',
	'AUTOLINK_INVALID_ID'				=> '¡Intenta modificar o eliminar una palabra con una ID incorrecta!',
	'AUTOLINK_DIFFERENT_SIZE_ARRAY'		=> '¡La cantidad de URLs añadidas y las tasas tienen que ser igual!',
	'INVALID_FORM_KEY'					=> '¡El formulario de llave simbólica no es válido!',
	'AUTOLINK_EMPTY_WORD_FIELD'			=> '¡Tiene que completar el campo de palabra!',
	'AUTOLINK_EMPTY_URL_FIELD'			=> '¡Tiene que completar el campo de URL!',
	'AUTOLINK_WORD_ALREADY_EXIST'			=> '¡Está palabra ya existe!'
));
