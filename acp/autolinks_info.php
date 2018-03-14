<?php
/**
*
* @package phpBB Extension - LMDI Autolinks
* @copyright (c) 2016-2018 Pierre Duhem - LMDI
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace lmdi\autolinks\acp;

class autolinks_info
{
	public function module()
	{
		return array(
			'filename'	=> '\lmdi\autolinks\acp\autolinks_module',
			'title'		=> 'ACP_AUTOLINKS_TITLE',
			'version'		=> '1.0.0',
			'modes'		=> array (
				'settings'	=> array('title' => 'ACP_AUTOLINKS_CONFIG',
				'auth' => 'ext_lmdi/autolinks',
				'cat' => array('ACP_AUTOLINKS_TITLE')),
			),
		);
	}
}
