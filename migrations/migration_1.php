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


class migration_1 extends \phpbb\db\migration\migration
{

	public function effectively_installed()
	{
		return isset($this->config['lmdi_autolinks']);
	}

	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v310\alpha2');
	}

	public function update_schema()
	{
		return array(
			'add_tables'   => array(
				$this->table_prefix . 'autolinks'   => array(
					'COLUMNS' => array(
						'al_id' => array('UINT:12', null, 'auto_increment'),
						'al_word' => array('VCHAR', ''),
						'al_url' => array('VCHAR', ''),
						),
					'PRIMARY_KEY'	=> 'al_id',
				),
			),
		);
	}


	public function get_nbrows ($table)
	{
		$sql = "SELECT COUNT(*) as nb FROM $table WHERE 1";
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$nb = $row['nb'];
		return ((int) $nb);
	}

	public function rename_table($table)
	{
		switch ($this->db->get_sql_layer())
		{
			// SQL Server dbms support this syntax
			case 'mssql':
			case 'mssql_odbc':
			case 'mssqlnative':
				$sql = "EXEC sp_rename '$table', '{$table}_backup'";
			break;
			// All other dbms support this syntax
			default:
				$sql = "ALTER TABLE $table RENAME TO {$table}_backup";
			break;
		}
		$this->db->sql_query($sql);
	}

	public function revert_schema()
	{
		$table = $this->table_prefix . 'autolinks';
		$nbrows = $this->get_nbrows($table);
		if ($nbrows > 5)
		{
			$this->rename_table ($table);
		}
		return array(
		'drop_tables'   => array(
			$table,
		),
		);
	}

}
