<?php
/**
*
* @package phpBB Extension - Smart read out
* @copyright (c) 2021 dmzx - https://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\smartreadout\controller;

use phpbb\config\config;
use phpbb\template\template;
use phpbb\log\log_interface;
use phpbb\user;
use phpbb\request\request_interface;

class admin_controller
{
	/** @var config */
	protected $config;

	/** @var template */
	protected $template;

	/** @var log_interface */
	protected $log;

	/** @var user */
	protected $user;

	/** @var request_interface */
	protected $request;

	/** @var string Custom form action */
	protected $u_action;

	/**
	 * Constructor
	 *
	 * @param config				$config
	 * @param template				$template
	 * @param log_interface			$log
	 * @param user					$user
	 * @param request_interface		$request
	 */
	public function __construct(
		config $config,
		template $template,
		log_interface $log,
		user $user,
		request_interface $request
	)
	{
		$this->config 			= $config;
		$this->template 		= $template;
		$this->log 				= $log;
		$this->user 			= $user;
		$this->request 			= $request;
	}

	/**
	* Display the options a user can configure for this extension
	*
	* @return null
	* @access public
	*/
	public function display_options()
	{
		// Add form key
		add_form_key('smartreadout');

		// Create an array to collect errors that will be output to the user
		$errors = [];

		// Is the form being submitted to us?
		if ($this->request->is_set_post('submit'))
		{
			// Check form key
			if (!check_form_key('smartreadout'))
			{
				$errors[] = $this->user->lang('FORM_INVALID');
			}

			// If no errors, process the form data
			if (empty($errors))
			{
				// Set the options the user configured
				$this->set_options();

				// Add option settings change action to the admin log
				$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'SMARTREADOUT_SAVED');

				trigger_error($this->user->lang('ACP_SMARTREADOUT_OPTIONS_SAVED') . adm_back_link($this->u_action));
			}
		}

		$s_errors = !empty($errors);

		// Set output variables for display in the template
		$this->template->assign_vars([
			'S_ERROR'							=> $s_errors,
			'ERROR_MSG'							=> $s_errors ? implode('<br />', $errors) : '',
			'SMARTREADOUT_ALLOW_SMARTREADOUT'	=> $this->config['smartreadout_allow_smartreadout'],
			'SMARTREADOUT_IP_ADRESS'			=> $this->config['smartreadout_ip_adress'],
			'SMARTREADOUT_IP_PORT'				=> $this->config['smartreadout_ip_port'],
			'SMARTREADOUT_AVAILABLE_NET'		=> $this->config['smartreadout_available_net'],
			'SMARTREADOUT_PHASE_CONNECT'		=> $this->get_smartreadout_phase_connect(),
			'SMARTREADOUT_TOTAL_SOLAR_POWER'	=> $this->config['smartreadout_total_solar_power'],
			'SMARTREADOUT_TOTAL_POWER'			=> $this->config['smartreadout_total_power'],
			'SMARTREADOUT_ENABLE_LOG'			=> $this->config['smartreadout_enable_log'],
			'SMARTREADOUT_REFRESH'				=> $this->config['smartreadout_refresh'],
			'U_ACTION'							=> $this->u_action,
		]);
	}

	// Select phase where solar panels are connected.
	protected function get_smartreadout_phase_connect()
	{
		$smartreadout_phase_connect = '';

		$types = [
			'L1'		=> $this->user->lang('ACP_SMARTREADOUT_PHASE_CONNECT_L1'),
			'L2'		=> $this->user->lang('ACP_SMARTREADOUT_PHASE_CONNECT_L2'),
			'L3'		=> $this->user->lang('ACP_SMARTREADOUT_PHASE_CONNECT_L3'),
		];

		foreach ($types as $type => $lang)
		{
			$selected	= ($this->config['smartreadout_phase_connect'] == $type) ? ' selected="selected"' : '';
			$smartreadout_phase_connect .= '<option value="' . $type . '"' . $selected . '>' . $this->user->lang($lang);
			$smartreadout_phase_connect .= '</option>';
		}

		return '<select name="smartreadout_phase_connect" id="smartreadout_phase_connect">' . $smartreadout_phase_connect . '</select>';
	}

	/**
	* Set the options a user can configure
	*
	* @return null
	* @access protected
	*/
	protected function set_options()
	{
		$this->config->set('smartreadout_allow_smartreadout', $this->request->variable('smartreadout_allow_smartreadout', 1));
		$this->config->set('smartreadout_ip_adress', $this->request->variable('smartreadout_ip_adress', ''));
		$this->config->set('smartreadout_ip_port', $this->request->variable('smartreadout_ip_port', ''));
		$this->config->set('smartreadout_available_net', $this->request->variable('smartreadout_available_net', 1));
		$this->config->set('smartreadout_phase_connect', $this->request->variable('smartreadout_phase_connect', '', true));
		$this->config->set('smartreadout_total_solar_power', $this->request->variable('smartreadout_total_solar_power', ''));
		$this->config->set('smartreadout_total_power', $this->request->variable('smartreadout_total_power', ''));
		$this->config->set('smartreadout_enable_log', $this->request->variable('smartreadout_enable_log', 1));
		$this->config->set('smartreadout_refresh', $this->request->variable('smartreadout_refresh', 5));
	}

	/**
	* Set page url
	*
	* @param string $u_action Custom form action
	* @return null
	* @access public
	*/
	public function set_page_url($u_action)
	{
		$this->u_action = $u_action;
	}
}
