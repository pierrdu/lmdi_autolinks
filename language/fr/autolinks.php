<?php
/**
 *
 * @package	Extension Autolinks [Français]
 * @author	Máté Bartus <bartus.mate@root.hu>
 * @author	Pierre Duhem <pierre@duhem.com>
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
	'AUTOLINK_MOD_MENU_NAME'			=> 'Extension Autolinks',
	'ACP_AUTOLINKS_TITLE'			=> 'Administration des liens automatiques',
	'AUTOLINK_ADD_A_NEW_WORD'		=> 'Ajouter un nouveau terme',

	// Main form's words
	'ACP_AUTOLINKS_CONFIG'			=> 'Configuration de l\'extension',

	'ACP_AUTOLINK_WORDS'				=> 'Addition d\'un nouveau terme',
	'ACP_AUTOLINK_WORD'					=> 'Terme',
	'ACP_AUTOLINK_WORD_NOTE'			=> 'Spécifiez le terme qui sera converti en lien. L\'extension ne fait pas de différence entre les majuscules et les minuscules.',
	'ACP_AUTOLINK_URL'					=> 'URL',
	'ACP_AUTOLINK_URL_NOTE'				=> 'Spécifiez une URL à utiliser avec le terme ci-dessus.',

	// Logs
	'LOG_AUTOLINK_WORD_ADDED'			=> 'Le terme « %s » a été ajouté à la table.',
	'LOG_AUTOLINK_WORD_EDIT'			=> 'Le terme « %s » a été mis à jour dans la table.',
	'LOG_AUTOLIMK_WORD_DELETE'		=> 'Le terme  « %s » a été supprimé dans la table.',
	'LOG_AUTOLINK_CONFIG_UPDATED'		=> 'Les paramètres de l\'extension ont été mis à jour.',

	// ACP table heading words
	'AUTOLINK_NAME'						=> 'Terme',
	'AUTOLINK_URL'						=> 'URL',

	// Error messages
	'AUTOLINK_NOT_ADDED'				=> 'Le terme n\'a pas été ajouté dans la table.',
	'AUTOLINK_NOT_REMOVED'				=> 'Le terme n\'a pas été supprimé dans la table.',
	'AUTOLINK_NOT_UPDATED'				=> 'Le terme n\'a pas été mis à jour dans la table.',
	'AUTOLINK_INVALID_ID'				=> 'Le numéro du terme que vous voulez éditer ou supprimer n\'existe pas.',
	'AUTOLINK_DIFFERENT_SIZE_ARRAY'		=> 'Le nombre des valeurs de fréquence et des URL doit être identique.',
	'AUTOLINK_EMPTY_WORD_FIELD'			=> 'La zone de saisie du terme est vide.',
	'AUTOLINK_EMPTY_URL_FIELD'			=> 'La zone de saisie de l\'URL est vide.',
	'AUTOLINK_WORD_ALREADY_EXIST'		=> 'Ce terme existe déjà.')
);
