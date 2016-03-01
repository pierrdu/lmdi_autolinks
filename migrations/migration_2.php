<?php
/**
*
* @package phpBB Extension - LMDI Autolinks
* @copyright (c) 2016 Pierre Duhem - LMDI
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace lmdi\autolinks\migrations;

// use \phpbb\db\migration\container_aware_migration;


class migration_2 extends \phpbb\db\migration\migration
{

	public function effectively_installed()
	{
		return $this->db_tools->sql_table_exists($this->table_prefix . 'autolinks');
	}

	static public function depends_on()
	{
		return array('\lmdi\autolinks\migrations\migration_1');
	}

	public function update_data()
	{
		return array(
			// ACP modules
			array('module.add', array(
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_AUTOLINKS_TITLE'
			)),
			array('module.add', array(
				'acp',
				'ACP_AUTOLINKS_TITLE',
				array(
					'module_basename'	=> '\lmdi\autolinks\acp\autolinks_module',
					'modes'			=> array('settings'),
				),
			)),

			// Configuration entry
			array('config.add', array('lmdi_autolinks', 1)),

			// Modify collation setting of the autolinks table
			array('custom', array(array(&$this, 'utf8_unicode_ci'))),

		);
	}


	public function utf8_unicode_ci()
	{
		global $table_prefix;
		$sql = "alter table ${table_prefix}autolinks convert to character set utf8 collate utf8_unicode_ci";
		$this->db->sql_query($sql);
	}


	public function revert_data()
	{

		return array(
			array('config.remove', array('lmdi_autolinks')),

			array('module.remove', array(
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_AUTOLINKS_TITLE'
			)),

		);
	}


}
