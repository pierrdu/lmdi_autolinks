<?php
/**
 *
 * @package	Extension Autolink [Spanish]
 * @author	Máté Bartus <bartus.mate@root.hu>
 * @author	Pierre Duhem <pierre@duhem.com>
 * Spanish translation by Raul [ThE KuKa] <thekuka@phpbb-es.com>
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

	// Menu text and titles
	'ACP_AUTOLINKS_TITLE'			=> 'Auto Enlace',
	'AUTOLINK_ADD_A_NEW_WORD'		=> 'Añadir nuevo Auto Enlace',
	'RECURS_FEATURE'				=> 'Prevenir la sustitución recursiva',
	'RECURS_FEATURE_EXPLAIN'		=> 'Si las URL contienen los términos a ser reemplazado, hay un riesgo de sustitución recursiva y los enlaces no funcionan como deberían. Esta opción evita la sustitución recursiva, un efecto secundario es que el término es reemplazado por la forma exacta entrada en la siguiente tabla.',
	'TERM_ADDITION'					=> 'Añadir nuevo término',
	'TERM_ADDITION_EXPLAIN'			=> 'Esta opción muestra un formulario para crear un nuevo término.',
	'AL_FORUM_SELECTION'			=> 'Configuraciones de Foro',
	'AL_NOSHOW_LIST'				=> 'Habilitar Auto Enlace',
	'LEGEND_ADD_TERM'				=> 'Gestión de términos',

	// Main form's words
	'ACP_AUTOLINKS_CONFIG'			=> 'Ajustes de configuracion de Auto Enlace',

	'ACP_AUTOLINK_WORDS'			=> 'Manejar palabras',
	'ACP_AUTOLINK_WORD'				=> 'Palabra',
	'ACP_AUTOLINK_WORD_NOTE'		=> 'Aquí puede ajustar las palabras para convertir en enlace. El Auto Enlace no hace diferencias entre mayúsculas y minúsculas.',
	'ACP_AUTOLINK_URL'				=> 'URL',
	'ACP_AUTOLINK_URL_NOTE'			=> 'Aquí puede establecer una URL para la palabra anterior.',

	// Logs
	'LOG_AUTOLINK_WORD_ADDED'		=> '¡Una nueva palabra (%s) ha sido añadida correctamente a la base de datos de Auto Enlace!',
	'LOG_AUTOLINK_WORD_EDIT'		=> 'Los detalles de la palabra “%s” han sido actualizados en la base de datos de Auto Enlace!',
	'LOG_AUTOLIMK_WORD_DELETE'		=> '¡La palabra “%s” ha sido eliminada de la base de datos de Auto Enlace!',
	'LOG_AUTOLINK_CONFIG_UPDATED'	=> 'La configuracion de ajustes de Auto Enlace ha sido actualizada.',

	// ACP table heading words
	'AUTOLINK_NAME'					=> 'Palabra',
	'AUTOLINK_URL'					=> 'URL',
	'AUTOLINK_BLANK'				=> 'Usar target=\'_blank\' para los enlaces',
	'AUTOLINK_BLANK_EXPLAIN'		=> 'Marque esta opción si desea abrir el enlace automáticamente en una nueva ventana.',

	// Error messages
	'AUTOLINK_NOT_ADDED'			=> '¡La palabra no ha sido añadida a la base de datos de Auto Enlace!',
	'AUTOLINK_NOT_REMOVED'			=> '¡La palabra no ha sido eliminada de la base de datos de Auto Enlace!',
	'AUTOLINK_NOT_UPDATED'			=> '¡La palabra no ha sido actualizada en la base de datos de Auto Enlace!',
	'AUTOLINK_INVALID_ID'			=> '¡Intenta modificar o eliminar una palabra con una ID incorrecta!',
	'AUTOLINK_DIFFERENT_SIZE_ARRAY'	=> '¡La cantidad de URLs añadidas y las tasas tienen que ser igual!',
	'INVALID_FORM_KEY'				=> '¡El formulario de llave simbólica no es válido!',
	'AUTOLINK_EMPTY_WORD_FIELD'		=> '¡Tiene que completar el campo de palabra!',
	'AUTOLINK_EMPTY_URL_FIELD'		=> '¡Tiene que completar el campo de URL!',
	'AUTOLINK_WORD_ALREADY_EXIST'	=> '¡Está palabra ya existe!',
	)
);
