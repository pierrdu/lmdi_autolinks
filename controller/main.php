<?php
/**
*
* @package phpBB Extension - LMDI Autolinks
* @copyright (c) 2016 LMDI - Pierre Duhem
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace lmdi\autolinks\controller;

class main
{
	/** @var \phpbb\template\template */
	protected $template;
	/** @var \phpbb\user */
	protected $user;
	/** @var \phpbb\request\request */
	protected $request;
	/** @var \phpbb\controller\helper */
	protected $helper;
	/** @var string phpBB root path */
	protected $phpbb_root_path;
	/** @var string phpEx */
	protected $phpEx;

	/**
	* Constructor
	*
	*/
	public function __construct(
		\phpbb\template\template $template,
		\phpbb\user $user,
		\phpbb\request\request $request,
		\phpbb\controller\helper $helper,
		$phpbb_root_path,
		$phpEx)
	{
		$this->template 			= $template;
		$this->user 				= $user;
		$this->request 			= $request;
		$this->helper 				= $helper;
		$this->phpbb_root_path 		= $phpbb_root_path;
		$this->phpEx 				= $phpEx;
	}
	public function handle_autolinks()
	{
		include($this->phpbb_root_path . 'includes/functions_user.' . $this->phpEx);
		include($this->phpbb_root_path . 'includes/functions_module.' . $this->phpEx);
		include($this->phpbb_root_path . 'includes/functions_display.' . $this->phpEx);

		// Exclude Bots
		if ($this->user->data['is_bot'])
		{
			redirect(append_sid($this->phpbb_root_path . 'index.' . $this->phpEx));
		}

		// Variables
		$mode   = $this->request->variable('mode', '');
		$action = $this->request->variable('action', '');
		$code   = $this->request->variable('code', '-1');
		// var_dump ($mode);
		// var_dump ($code);
		// var_dump ($action);

		// String loading
		$this->user->add_lang_ext('lmdi/gloss', 'edit_gloss');

		// Add the base entry into the breadcrump at top
		$this->template->assign_block_vars('navlinks', array(
			'U_VIEW_FORUM'	=> $this->helper->route('lmdi_gloss_controller'),
			'FORUM_NAME'	=> $this->user->lang['LGLOSSAIRE'],
			// 'code'		=> $code,
		));

		switch ($mode)
		{
			case 'glossclean':
				$this->glossclean->main();
			break;
			case 'glosspict':
				$this->glosspict->main();
			break;
			case 'glossedit':
				$this->glossedit->main();
			break;
			default:
				$this->glossaire->main();
			break;
		}
	}
}
