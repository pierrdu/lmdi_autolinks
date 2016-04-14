<?php
/**
 *
 * @package	Extension Autolink [English]
 * @author	Máté Bartus <bartus.mate@root.hu>
 * @author	Pierre Duhem <pierre@duhem.com>
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
	'ACP_AUTOLINKS_TITLE'			=> 'Autolink Administration',
	'AUTOLINK_ADD_A_NEW_WORD'		=> 'Add new Autolink',
	'RECURS_FEATURE'				=> 'Prevent recursive replacement',
	'RECURS_FEATURE_EXPLAIN'			=> 'If the URLs contain the terms to be replaced, there is a risk of recursive replacement and the links don\'t work as they should. This option prevents the recursive replacement but a side effect is that the term gets replaced by the exact form entered in the table below.',
	'TERM_ADDITION'				=> 'Adding a new term',
	'TERM_ADDITION_EXPLAIN'			=> 'This options displays a form to create a new term.',
	'PST_LEGEND3'		=> 'Forum settings',
	'PST_NOSHOW_LIST'	=> 'Enable autolinks in',
	'LEGEND_ADD_TERM'	=> 'Term Management',
	'ACP_CHECKALL'		=> 'Select/deselect',
	'ACP_CHECKALL_EXPLAIN'	=> 'Here you can check/uncheck all forums together.',
	'ACP_ALL_FORUMS'	=> 'All forums',


	// Main form's words
	'ACP_AUTOLINKS_CONFIG'				=> 'Autolink configuration',

	'ACP_AUTOLINK_WORDS'				=> 'Manage words',
	'ACP_AUTOLINK_WORD'					=> 'Word',
	'ACP_AUTOLINK_WORD_NOTE'			=> 'Here you can set the word to convert to a link. The Autolink extension is not case sensitive.',
	'ACP_AUTOLINK_URL'					=> 'URL',
	'ACP_AUTOLINK_URL_NOTE'				=> 'Here you can set one URL for the word above.',

	// Logs
	'LOG_AUTOLINK_WORD_ADDED'			=> 'A new word (%s) was successfully added to the Autolink database!',
	'LOG_AUTOLINK_WORD_EDIT'			=> 'The details of “%s” word was updated in the Autolink database!',
	'LOG_AUTOLIMK_WORD_DELETE'			=> '“%s” word was removed from the Autolink database!',
	'LOG_AUTOLINK_CONFIG_UPDATED'		=> 'The Autolink config settings were updated.',

	// ACP table heading words
	'AUTOLINK_NAME'						=> 'Word',
	'AUTOLINK_URL'						=> 'URL',

	// Error messages
	'AUTOLINK_NOT_ADDED'				=> 'The word wasn’t added to the Autolink database!',
	'AUTOLINK_NOT_REMOVED'				=> 'The word wasn’t removed from the Autolink database!',
	'AUTOLINK_NOT_UPDATED'				=> 'The word wasn’t updated in the Autolink database!',
	'AUTOLINK_INVALID_ID'				=> 'You try to edit or remove a word with a wrong ID!',
	'AUTOLINK_DIFFERENT_SIZE_ARRAY'		=> 'The amount of the added URLs and the rates have to be equall!',
	'INVALID_FORM_KEY'					=> 'The form’s token key is invalid!',
	'AUTOLINK_EMPTY_WORD_FIELD'			=> 'You have to fill the word input field!',
	'AUTOLINK_EMPTY_URL_FIELD'			=> 'You have to fill the URL input field!',
	'AUTOLINK_WORD_ALREADY_EXIST'			=> 'This word already exists!')
);
