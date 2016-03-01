<?php
/**
* @package phpBB Extension - LMDI Autolinks
* @copyright (c) 2016 Pierre Duhem - LMDI
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace lmdi\autolinks\acp;

class autolinks_module {

	var $u_action;
	var $action;
	var $table;

	public function main ($id, $mode)
	{
		global $db, $user, $auth, $template, $cache, $request;
		global $config, $phpbb_root_path, $phpbb_admin_path, $phpEx;
		global $table_prefix, $phpbb_container;

		// $id = string(36) "\lmdi\autolinks\acp\autolinks_module"
		// $mode = string(8) "settings"

		$user->add_lang_ext ('lmdi/autolinks', 'autolinks');
		$this->tpl_name = 'acp_autolinks_body';
		$this->page_title = $user->lang('ACP_AUTOLINKS_TITLE');
		$this->table = $table_prefix . 'autolinks';
		$table = $this->table;

		$action = $request->variable ('action', '');
		// $action_config = $this->u_action . "&action=config";
		$update_action = false;

		// var_dump ($action);
		switch ($action)
		{
			case 'edit':
				// Get the ID of the item we would like to edit
				$word_id = request_var('edit_id', 0);
				if ($word_id == 0)
				{
					trigger_error($user->lang['AUTOLINK_INVALID_ID'] . adm_back_link($this->u_action), E_USER_WARNING);
				}

				// Query the data of the item
				$sql = 'SELECT * FROM ' . $table . ' WHERE al_id = ' . $word_id;
				$result = $db->sql_query($sql);
				$row = $db->sql_fetchrow($result);
				$db->sql_freeresult($result);

				$template->assign_vars(array(
					'S_WORD'	=> $row['al_word'],
					'S_URL'		=> $row['al_url'],
					'S_RATE'	=> $row['al_rate'])
					);
				$update_action = true;
			// break; don't needed
			case 'add':
				// Create the language list
				$sql = 'SELECT * FROM ' . LANG_TABLE;
				$result = $db->sql_query($sql);
				while ($row = $db->sql_fetchrow($result))
				{
					$template->assign_block_vars('al_lang_option', array(
						'S_OPTION_VALUE'	=> $row['lang_id'],
						'LANG_NAME'		=> $row['lang_local_name'])
						);
				}
				$db->sql_freeresult($result);

				$template->assign_vars(array(
					'U_W_ACTION'	=> ( ($action == 'edit') ? $this->u_action . '&amp;action=edit&amp;edit_id=' . $word_id : $this->u_action . '&amp;action=add'),
					'S_ADD_PAGE'	=> true)
					);

				add_form_key('acp_autolinkword');

				if (isset($_POST['submit']))
				{
					$sql_array = array(
						'al_word'		=> utf8_normalize_nfc(request_var('al_word', '', true)),
						'al_url'		=> request_var('al_url', '', true)
						);

					if ($action == 'edit')
					{
						$sql = 'UPDATE ' . $table . ' SET '
							. $db->sql_build_array('UPDATE', $sql_array) . " 
							WHERE al_id = $word_id";

						$log_msg = sprintf($user->lang['LOG_AUTOLINK_WORD_EDIT'], $sql_array['al_word']);
					}
					else
					{
						$sql = 'INSERT INTO ' . $table . ' ' . $db->sql_build_array('INSERT', $sql_array);

						$log_msg = sprintf($user->lang['LOG_AUTOLINK_WORD_ADDED'], $sql_array['al_word']);
					}

					$errors = $this->input_check($sql_array, check_form_key('acp_autolinkword'), $update_action);
					if ($errors === true)
					{
						$db->sql_query($sql);
						add_log('admin', $log_msg);
						$cache->destroy ('_autolinks');
						trigger_error($log_msg . adm_back_link($this->u_action));
					}
					else
					{
						for ($i = 0; $i < sizeof($errors); $i++)
						{
							$template->assign_block_vars('error', array(
								'ERROR_MSG' => $errors[$i])
								);
						}

						$template->assign_var('S_ERROR_FORM', true);
					}
				}
			break;
			case 'delete':
				$word_id = request_var('delete_id', 0);

				if ($word_id == 0)
				{
					trigger_error($user->lang['AUTOLINK_INVALID_ID'] . adm_back_link($this->u_action), E_USER_WARNING);
				}
				else
				{
					if (confirm_box(true))
					{
						$sql = 'SELECT * FROM ' . $table . ' WHERE al_id = ' . $word_id;
						$result = $db->sql_query($sql);
						$row = $db->sql_fetchrow($result);
						$db->sql_freeresult($result);

						$log_msg = sprintf($user->lang['LOG_AUTOLIMK_WORD_DELETE'], $row['al_word']);

						$sql = 'DELETE FROM ' . $table . ' WHERE al_id = ' . $word_id;
						$db->sql_query($sql);
						add_log('admin', $log_msg);
						$cache->destroy ('_autolinks');
						trigger_error($log_msg . adm_back_link($this->u_action));
					}
					else
					{
						confirm_box(false, $user->lang['CONFIRM_OPERATION'], build_hidden_fields(array(
							'i'		=> $id,
							'mode'		=> $mode,
							'delete_id'	=> $word_id,
							'action'	=> 'delete',
						)));
					}
				}
			break;
			default:
				if (isset($_POST['submit']))
				{
					trigger_error($user->lang['LOG_AUTOLINK_CONFIG_UPDATED'] . adm_back_link($this->u_action));
				}
				$sql = 'SELECT * FROM ' . $table;
				$result = $db->sql_query($sql);
				while ($row = $db->sql_fetchrow($result))
				{
					$template->assign_block_vars('al', array(
						'NAME'			=> $row['al_word'],
						'URL'			=> $row['al_url'],
						'U_EDIT'		=> $this->u_action . '&amp;action=edit&amp;edit_id=' . $row['al_id'],
						'U_DELETE'		=> $this->u_action . '&amp;action=delete&amp;delete_id=' . $row['al_id']
						)
					);
				}
				$db->sql_freeresult($result);

				$template->assign_vars(array(
					'S_CONFIG_PAGE'		=> true)
					);				
			break;
		}

		$template->assign_vars(array(
			'U_ADD'				=> $this->u_action . '&amp;action=add',
			'U_ACTION'			=> $this->u_action)
		);
	}


	function input_check($input_array, $key_error = false, $update = false)
	{
		global $db, $user;
		$table = $this->table;

		if (!$key_error)
		{
			$errors[] = $user->lang['INVALID_FORM_KEY'];
		}

		if (empty($input_array['al_word']))
		{
			$errors[] = $user->lang['AUTOLINK_EMPTY_WORD_FIELD'];
		}
		else
		{
			$sql = 'SELECT COUNT(*) AS num 
					FROM ' . $table . ' 
					WHERE lower(al_word) = "' . utf8_strtolower($db->sql_escape($input_array['al_word'])) . '"';
			$result = $db->sql_query($sql);
			$word_stored_num = (int) $db->sql_fetchfield('num');
			$db->sql_freeresult($result);
			
			if ($word_stored_num != 0 && !$update)
			{
				$errors[] = $user->lang['AUTOLINK_WORD_ALREADY_EXIST'];
			}
		}

		if (empty($input_array['al_url']))
		{
			$errors[] = $user->lang['AUTOLINK_EMPTY_URL_FIELD'];
		}

		$ret = (empty($errors)) ? true : $errors;
		return ($ret);
	}
}
