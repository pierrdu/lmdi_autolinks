<?php
/**
*
* @copyright (c) 2016 Pierre Duhem - LMDI
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
**
*/

namespace lmdi\autolinks\migrations;

class migration_3 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return $this->db_tools->sql_column_exists($this->table_prefix . 'forums', 'lmdi_autolinks');
	}

	static public function depends_on()
	{
		return array('\lmdi\autolinks\migrations\migration_2');
	}

	public function update_schema()
	{
		return array(
			'add_columns' => array(
				$this->table_prefix . 'forums' => array('lmdi_autolinks' => array('BOOL', 0),
				),
			),
		);
	}

	public function revert_schema()
	{
		return array(
			'drop_columns' => array(
				$this->table_prefix . 'forums' => array('lmdi_autolinks',
				),
			),
		);
	}
}
