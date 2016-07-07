<?php
/**
*
* @package phpBB Extension - LMDI Autolinks extension
* @copyright (c) 2016 LMDI - Pierre Duhem
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace lmdi\autolinks\event;

/**
* @ignore
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	/** @var \phpbb\cache\service */
	protected $cache;
	/* @var \phpbb\user */
	protected $user;
	/* @var \phpbb\db\driver\driver_interface */
	protected $db;
	/* @var \phpbb\template\template */
	protected $template;
	/* @var \phpbb\config\config */
	protected $config;
	/* @var \phpbb\controller\helper */
	protected $helper;
	protected $autolinks_table;

	public function __construct(
		\phpbb\db\driver\driver_interface $db,
		\phpbb\config\config $config,
		\phpbb\controller\helper $helper,
		\phpbb\template\template $template,
		\phpbb\cache\service $cache,
		\phpbb\user $user,
		$autolinks_table
		)
	{
		$this->db = $db;
		$this->config = $config;
		$this->helper = $helper;
		$this->template = $template;
		$this->cache = $cache;
		$this->user = $user;
		$this->autolinks_table = $autolinks_table;
	}

	static public function getSubscribedEvents ()
	{
	return array(
		'core.user_setup'				=> 'load_language_on_setup',
		'core.viewtopic_post_rowset_data'	=> 'insertion_autolinks',
		);
	}

	public function load_language_on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'lmdi/autolinks',
			'lang_set' => 'autolinks',
			);
		$event['lang_set_ext'] = $lang_set_ext;
	}

	private function cache_production ()
	{
		$cache = array();
		$sql = 'SELECT  forum_id from ' . FORUMS_TABLE . '
			WHERE lmdi_autolinks = 1';
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
			$cache[] = $row['forum_id'];
		}
		$this->db->sql_freeresult($result);
		$this->cache->put('_al_enabled_forums', $cache, 86400 *  7);
		return ($cache);
	}

	// Event: core.viewtopic_post_rowset_data
	// Called for each post in the topic
	// event.rowset_data.post_text = text of the post
	public function insertion_autolinks ($event)
	{
		static $enabled_forums = "";
		if (empty ($enabled_forums))
		{
			$enabled_forums = $this->cache->get('_al_enabled_forums');
		}
		if (!$enabled_forums)	// No data in cache
		{
			$enabled_forums = $this->cache_production();
		}
		if (!empty ($enabled_forums))
		{
			$rowset_data = $event['rowset_data'];
			$forum_id = $rowset_data['forum_id'];
			if (in_array ($forum_id, $enabled_forums))
			{
				$post_text = $rowset_data['post_text'];
				$post_text = $this->autolinks_pass ($post_text);
				$rowset_data['post_text'] = $post_text;
				$event['rowset_data'] = $rowset_data;
			}
		}
	}	// insertion_autolinks


	function autolinks_pass ($texte)
	{
		static $autolinks;
		if (!isset ($autolinks) || !is_array ($autolinks))
		{
			$autolinks = $this->compute_autolinks();
		}
		if (!sizeof($autolinks))
		{
			return ($texte);
		}
		$terms = $autolinks['terms'];
		$urls  = $autolinks['urls'];
		if ($this->config['lmdi_autolinks'] == 2)
		{
			$fterms = $autolinks['fterms'];
			$furls = $autolinks['furls'];
		}
		// Breaking the input string on tags. PREG_PATTERN_ORDER by default
		preg_match_all ('#[][><][^][><]*|[^][><]+#', $texte, $parts);
		$parts = &$parts[0];
		// var_dump ($parts);
		// exit;
		if (empty($parts))
		{
			return '';
		}
		foreach ($parts as $index => $part)
		{
			// echo ("\nSous-passe dans foreach pour $part.\n");
			// Code
			if (strstr($part, '[code'))
			{
				$code = true;
			}
			if (!empty($code) && strstr($part, '[/code'))
			{
				$code = false;
			}
			// Images - Pictures
			if (strstr($part, '[img'))
			{
				$img = true;
			}
			if (!empty($img) && strstr($part, '[/img'))
			{
				$img = false;
			}
			// Liens <a> - <a> links
			if (strstr($part, '<a '))
			{
				$alink = true;
			}
			if (!empty($link) && strstr($part, '</a'))
			{
				$alink = false;
			}
			// Liens [url] - [url] links
			if (strstr($part, '[url'))
			{
				$ulink = true;
			}
			if (!empty($link) && strstr($part, '[/url'))
			{
				$ulink = false;
			}
			// Script
			if (strstr($part, '<script '))
			{
				$script = true;
			}
			if (!empty($script) && strstr($part, '</script'))
			{
				$script = false;
			}
			if (!($part{0} == '<' && $parts[$index + 1]{0} == '>') &&
				!($part{0} == '[' && $parts[$index + 1]{0} == ']') &&
				empty($img) && empty($code) && empty($alink) && empty($ulink) && empty($script))
			{
				if ($this->config['lmdi_autolinks'] == 2)
				{
					$part = preg_replace ($terms, $furls, $part);
					$nbt = count ($terms);
					for ($i = 0; $i < $nbt; $i++)
					{
						$part = str_replace ($furls[$i], $urls[$i] . $fterms[$i], $part);
					}
				}
				else
				{
					$part = preg_replace ($terms, $urls, $part);
				}
				$parts[$index] = $part;
			}
		}	// foreach
		$texte = implode ("", $parts);
		return ($texte);
	}	// autolinks_pass


	/*	Production of the term list and the url list, in an array named autolinks.
		*/
	function compute_autolinks()
	{
		$autolinks = $this->cache->get('_autolinks');
		if ($autolinks === false)
		{
			$sql  = "SELECT * FROM $this->autolinks_table ORDER BY char_length(al_word) DESC";
			$result = $this->db->sql_query($sql);
			$autolinks = array();
			$cpt = 0;
			while ($row = $this->db->sql_fetchrow($result))
			{
				$term = $row['al_word'];
				$url  = $row['al_url'];
				if ($this->config['lmdi_autolinks'] == 2)
				{
					$firstspace = '/\b(';
					$lastspace = ')\b/ui';	// PCRE - u = UTF-8 - i = case insensitive
					$autolinks['terms'][] = $firstspace . $term . $lastspace;
					$autolinks['urls'][]  = "<a href=\"$url\" class=\"postlink\">";
					$autolinks['furls'][] = "al_**_{$cpt}_**_al";
					$autolinks['fterms'][] = "$term</a>";
					$cpt++;
				}
				else
				{
					$firstspace = '/\b(';
					$lastspace = ')\b/ui';	// PCRE - u = UTF-8 - i = case insensitive
					$autolinks['terms'][] = $firstspace . $term . $lastspace;
					$autolinks['urls'][]  = "<a href=\"$url\" class=\"postlink\">$1</a>";
				}
			}
			$this->db->sql_freeresult($result);
			$this->cache->put('_autolinks', $autolinks, 86400);		// 24 h

		}
		return $autolinks;
	}	// compute_autolinks

}
