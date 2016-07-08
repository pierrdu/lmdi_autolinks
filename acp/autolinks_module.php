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
		global $config, $phpbb_root_path, $phpbb_admin_path, $phpbb, $phpEx;
		global $table_prefix, $phpbb_container;

		$user->add_lang_ext ('lmdi/autolinks', 'autolinks');
		$this->tpl_name = 'acp_autolinks_body';
		$this->page_title = $user->lang('ACP_AUTOLINKS_TITLE');
		$this->table = $table_prefix . 'autolinks';
		$table = $this->table;

		$action = $request->variable ('action', '');
		// $action_config = $this->u_action . "&action=config";
		$update_action = false;

		switch ($action)
		{
			case 'forums' :
				if (!check_form_key('acp_autolinks'))
				{
					trigger_error('FORM_INVALID');
				}
				$enabled_forums = implode(',', $request->variable('mark_autolinks_forum', array(0), true));
				$sql = 'UPDATE ' . FORUMS_TABLE . '
					SET lmdi_autolinks = DEFAULT';
				$db->sql_query($sql);
				if (!empty ($enabled_forums))
				{
					$eforums = explode (',', $enabled_forums);
					$nbf = count ($eforums);
					for ($i=0; $i<$nbf; $i++)
					{
						$numf = $eforums[$i];
						$sql = 'UPDATE ' . FORUMS_TABLE . "
							SET lmdi_autolinks = 1
							WHERE forum_id = $numf";
						$db->sql_query($sql);
					}
					$cache->put('_al_enabled_forums', $eforums, 86400);		// 24 h
				}
				else
				{
					$cache->destroy ('_al_enabled_forums');
				}
			break;
			case 'recursion' :
				if (!check_form_key('acp_autolinks'))
				{
					trigger_error('FORM_INVALID');
				}
				$recurs = $request->variable ('lmdi_recursive', 0);
				$cfg_recurs = $config['lmdi_autolinks'] - 1;
				if ($recurs != $cfg_recurs)
				{
					$config->set ('lmdi_autolinks', $recurs + 1);
					$cache->destroy ('_autolinks');
					trigger_error($user->lang['LOG_AUTOLINK_CONFIG_UPDATED'] . adm_back_link($this->u_action));

				}
			break;
			case 'edit':
				$word_id = $request->variable ('edit_id', 0);
				if ($word_id == 0)
				{
					trigger_error($user->lang['AUTOLINK_INVALID_ID'] . adm_back_link($this->u_action), E_USER_WARNING);
				}

				$sql = 'SELECT * FROM ' . $table . ' WHERE al_id = ' . $word_id;
				$result = $db->sql_query($sql);
				$row = $db->sql_fetchrow($result);
				$db->sql_freeresult($result);

				$template->assign_vars(array(
					'S_WORD'	=> $row['al_word'],
					'S_URL'	=> $row['al_url']
					));
				$update_action = true;
				$template->assign_vars(array(
					'A_ACTION'	=> $this->u_action . '&amp;action=edit&amp;edit_id=' . $word_id,
					'S_ADD_TERM'	=> true)
					);
				if (isset($_POST['submit']))
				{
					$sql_array = array(
						'al_word'	=> $request->variable('al_word', '', true),
						'al_url'	=> $request->variable('al_url', '', true)
						);

					$sql = 'UPDATE ' . $table . ' SET '
						. $db->sql_build_array('UPDATE', $sql_array) . " 
						WHERE al_id = $word_id";

					$log_msg = sprintf($user->lang['LOG_AUTOLINK_WORD_EDIT'], $sql_array['al_word']);

					$errors = $this->input_check($sql_array, check_form_key('acp_autolinks'), $update_action);
					if ($errors === true)
					{
						$db->sql_query($sql);
						add_log ('admin', $log_msg);
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
			case 'add':
				$template->assign_vars(array(
					'A_ACTION'	=> $this->u_action . '&amp;action=add',
					'S_ADD_TERM'	=> true)
					);

				if (isset($_POST['submit']))
				{
					$sql_array = array(
						'al_word'	=> $request->variable('al_word', '', true),
						'al_url'	=> $request->variable('al_url', '', true)
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

					$errors = $this->input_check($sql_array, check_form_key('acp_autolinks'), $update_action);
					if ($errors === true)
					{
						$db->sql_query($sql);
						add_log ('admin', $log_msg);
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
				$word_id = $request->variable('delete_id', 0);
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
		}

		if ($request->variable('submit', 0))
		{
			trigger_error($user->lang['LOG_AUTOLINK_CONFIG_UPDATED'] . adm_back_link($this->u_action));
		}

		$form_key = 'acp_autolinks';
		add_form_key ($form_key);

		$action_config = $this->u_action . "&action=recursion";
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

		$forum_list = $this->get_forum_list();
		foreach ($forum_list as $row)
		{
			$template->assign_block_vars('forums', array(
				'FORUM_NAME'			=> $row['forum_name'],
				'FORUM_ID'			=> $row['forum_id'],
				'CHECKED_ENABLE_FORUM'	=> $row['lmdi_autolinks']? 'checked="checked"' : '',
			));
		}
		$template->assign_vars(array(
			'F_ACTION'		=> $this->u_action . '&amp;action=forums',
			'R_ACTION'		=> $this->u_action . '&amp;action=recursion',
			// 'A_ACTION'		=> $this->u_action . '&amp;action=add',
			'S_CONFIG_PAGE'	=> true,
			'ALLOW_FEATURE_NO'	=> $config['lmdi_autolinks'] == 1 ? 'checked="checked"' : '',
			'ALLOW_FEATURE_YES'	=> $config['lmdi_autolinks'] == 2 ? 'checked="checked"' : '',
			));
		$template->assign_vars(array(
			'U_ADD'			=> $this->u_action . '&amp;action=add',
			'U_ACTION'		=> $this->u_action,
			'S_SET_FORUMS'		=> true,
			));
	}	// Main

	protected function get_forum_list()
	{
		global $db;
		$sql = 'SELECT forum_id, forum_name, lmdi_autolinks
			FROM ' . FORUMS_TABLE . '
			WHERE forum_type = ' . FORUM_POST . '
			ORDER BY left_id ASC';
		$result = $db->sql_query($sql);
		$forum_list = $db->sql_fetchrowset($result);
		$db->sql_freeresult($result);

		return $forum_list;
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
	}	// input_check

}
