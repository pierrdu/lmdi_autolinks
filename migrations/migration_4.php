<?php
/**
*
* @copyright (c) 2016-2021 Pierre Duhem - LMDI
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
**
*/

namespace lmdi\autolinks\migrations;

class migration_4 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['lmdi_autolinks_sort']);
	}

	static public function depends_on()
	{
		return array('\lmdi\autolinks\migrations\migration_3');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('lmdi_autolinks_sort', 0)),
			array('config.add', array('lmdi_autolinks_blank', 0)),
		);
	}

	public function revert_data()
	{
		return array(
			array('config.remove', array('lmdi_autolinks_sort')),
			array('config.remove', array('lmdi_autolinks_blank')),
		);
	}
}
