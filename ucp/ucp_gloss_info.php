<?php
/**
*
* Glossary extension for the phpBB Forum Software package.
*
* @copyright (c) 2015 Pierre Duhem - LMDI
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

namespace lmdi\gloss\ucp;

class ucp_gloss_info
{
	function module()
	{
		return array(
			'filename'	=> '\lmdi\gloss\ucp\ucp_gloss_module',
			'title'     	=> 'UCP_GLOSS_TITLE',
			'version'   	=> '1.0.0',
			'modes'		=> array(
				'glossary' => array('title' => 'UCP_GLOSS',
							'auth' => 'ext_lmdi/gloss',
							'cat' => array('UCP_GLOSS_TITLE')),
			),
		);
	}

}
