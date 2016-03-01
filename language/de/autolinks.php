<?php
/**
 *
 * @package	Extension Autolinks [Deutsch]
 * @author	Máté Bartus <bartus.mate@root.hu>
 * @author	Luula
 * @version	$Id: info_acp_autolink.php 38 2010-07-20 14:08:37Z CHItA $
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
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
	'AUTOLINK_MOD_MENU_NAME'		=> 'Autolink-MOD',
	'ACP_AUTOLINKS_TITLE'			=> 'Autolink-Administration',
	'AUTOLINK_ADD_A_NEW_WORD'		=> 'Neuen Autolink hinzufügen',

	// Main form's words
	'ACP_AUTOLINK_CONFIG'			=> 'Autolink-Einstellungen',

	'ACP_AUTOLINK_WORDS'		=> 'Begriffe',
	'ACP_AUTOLINK_WORD'			=> 'Begriff',
	'ACP_AUTOLINK_WORD_NOTE'	=> 'Hier kannst Du Begriffe definieren, die in einen Link konvertiert werden. Groß- und Kleinschreibung werden nicht unterschieden.',
	'ACP_AUTOLINK_URL'			=> 'URL',
	'ACP_AUTOLINK_URL_NOTE'		=> 'Hier kannst Du eine einzige URL für den oben eingetragenen Begriff definieren.',

	// Logs
	'LOG_AUTOLINK_WORD_ADDED'		=> 'Der neue Begriff "%s" wurde in die Datenbank übernommen.',
	'LOG_AUTOLINK_WORD_EDIT'		=> 'Die Änderungen für den Begriff "%s" wurden übernommen.',
	'LOG_AUTOLIMK_WORD_DELETE'		=> 'Der Begriff "%s" wurde aus der Datenbank entfernt.',
	'LOG_AUTOLINK_CONFIG_UPDATED'	=> 'Die Autolink-Einstellungen wurden geändert.',

	// ACP table heading words
	'AUTOLINK_NAME'				=> 'Begriff',
	'AUTOLINK_URL'				=> 'URL',
	
	// Error messages
	'AUTOLINK_NOT_ADDED'			=> 'Der neue Begriff "%s" wurde NICHT in die Datenbank übernommen!',
	'AUTOLINK_NOT_REMOVED'			=> 'Der Begriff "%s" wurde NICHT aus der Datenbank entfernt!',
	'AUTOLINK_NOT_UPDATED'			=> 'Die Änderungen für den Begriff "%s" wurden NICHT übernommen!',
	'AUTOLINK_INVALID_ID'			=> 'Die ID des Begriffes/ oder der URL ist ungültig!',
	'INVALID_FORM_KEY'				=> 'Der Formularschlüssel ist ungültig!',
	'AUTOLINK_EMPTY_WORD_FIELD'		=> 'Es muß ein Begriff angegeben werden!',
	'AUTOLINK_EMPTY_URL_FIELD'		=> 'Es muß eine URL angegeben werden!',
	'AUTOLINK_WORD_ALREADY_EXIST'		=> 'Dieser Begriff existiert bereits!')
);

?>