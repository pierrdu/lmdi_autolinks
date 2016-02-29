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

/**
* Class name must be the same as the file name.
* @package ucp
*/

class ucp_gloss_module
{
	/** @var \phpbb\db\driver\driver_interface */
	protected $db;
	/** @var \phpbb\user */
	protected $user;
	public $u_action;
	public $tpl_name;
	public $page_title;

	function main($id, $mode)
	{
		global $db, $user, $auth, $template, $cache, $request;
		global $config, $phpbb_root_path, $phpbb_admin_path, $phpEx, $table_prefix;
		global $helper, $root_path, $php_ext, $content_visibility;

		$this->user = $user;
		$this->db = $db;
		$this->user->add_lang_ext('lmdi/gloss', 'gloss');

		$this->tpl_name = 'ucp_gloss';
		$this->page_title = $user->lang('UCP_GLOSS_TITLE');
		$uid = $this->user->data['user_id'];

		// Submission
		if ($request->is_set_post('submit'))
		{
			if (!check_form_key('ucp_gloss'))
			{
				trigger_error('FORM_INVALID');
			}
			else
			{
				$ucp = $request->variable ('gloss', '0');
				// Update the lmdi_gloss column in table users
				$uid = $this->user->data['user_id'];
				$sql  = "UPDATE " . USERS_TABLE;
				$sql .= " SET lmdi_gloss = $ucp ";
				$sql .= "WHERE user_id = $uid ";
				$this->db->sql_query($sql);
				// Information message
				$basic_link = $this->u_action . "&amp;mode=$mode";
				$message = sprintf($user->lang['UCP_CONFIG_SAVED'], '<a href="' . $basic_link . '">', '</a>');
				trigger_error($message);
			}
		}
		else
		{
			$ucp = $this->user->data['lmdi_gloss'];
		}

		// Form and page display
		$form_key = 'ucp_gloss';
		add_form_key($form_key);
		$template->assign_vars(array(
			'L_TITLE'  		=> $user->lang['UCP_GLOSS_TITLE'],
			'S_UCP_ACTION' 	=> $this->u_action,
			'ALLOW_FEATURE_YES' => $ucp == 1 ? 'checked="checked"' : '',
			'ALLOW_FEATURE_NO' 	=> $ucp == 0 ? 'checked="checked"' : '',
		));
	}
}
