<?php
/**
 *
 * @package	Extension Autolink
 * @author	Máté Bartus <bartus.mate@root.hu>
 * @version	$Id: info_acp_autolink.php 46 2010-07-20 14:14:53Z CHItA $
 * Russian translation by MaxTr
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
<?php
/**
 *
 * @package	Extension Autolink
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
	// Menu text and titles
	'ACP_AUTOLINKS_TITLE'			=> 'Управление анкорами',
	'AUTOLINK_ADD_A_NEW_WORD'		=> 'Добавить новый URL',

	// Main form's words
	'ACP_AUTOLINKS_CONFIG'			=> 'Конфигурация',
	'ACP_AUTOLINK_WORDS'			=> 'Управление анкорами',
	'ACP_AUTOLINK_WORD'				=> 'Значение',
	'ACP_AUTOLINK_WORD_NOTE'			=> 'Здесь вы можете задать анкор (расширение не чувствительно к регистру).',
	'ACP_AUTOLINK_URL'				=> 'URL',
	'ACP_AUTOLINK_URL_NOTE'			=> 'Здесь вы можете задать ссылку, для слова указанного выше.',

	// Logs
	'LOG_AUTOLINK_WORD_ADDED'		=> 'Новый анкор (%s) был успешно внесен в базу данных "Управление анкорами"!',
	'LOG_AUTOLINK_WORD_EDIT'			=> 'Подробности “%s” в слове был обновлен в базе данных "Управление анкорами"!',
	'LOG_AUTOLIMK_WORD_DELETE'		=> '“%s” слово было удалено из базы "Управление анкорами"!',
	'LOG_AUTOLINK_CONFIG_UPDATED'		=> 'Конфигурация расширения "Управление анкорами" и его настройки были обновлены.',

	// ACP table heading words
	'AUTOLINK_NAME'				=> 'Слово',
	'AUTOLINK_URL'					=> 'Ссылка',

	// Error messages
	'AUTOLINK_NOT_ADDED'			=> 'Слово не было добавлено к базе "Управление анкорами"!',
	'AUTOLINK_NOT_REMOVED'			=> 'Слово не было удалено из базы "Управление анкорами"!',
	'AUTOLINK_NOT_UPDATED'			=> 'Слово не обновляется в базе "Управление анкорами"!',
	'AUTOLINK_INVALID_ID'			=> 'Попытка редактировать или удалить слово с неправильным ID!',
	'AUTOLINK_DIFFERENT_SIZE_ARRAY'	=> 'Количество добавленных URL-адресов и анкоров должны совпадать!',
	'INVALID_FORM_KEY'				=> 'The form’s token key is invalid!',
	'AUTOLINK_EMPTY_WORD_FIELD'		=> 'Введите значение поля "Слово"!',
	'AUTOLINK_EMPTY_URL_FIELD'		=> 'Заполните URL!',
	'AUTOLINK_WORD_ALREADY_EXIST'		=> 'Это слово уже существует!')
);
