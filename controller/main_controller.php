<?php
/**
*
* @package phpBB Extension - Smart read out
* @copyright (c) 2021 dmzx - https://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\smartreadout\controller;

use phpbb\template\template;
use phpbb\auth\auth;
use phpbb\config\config;
use phpbb\controller\helper;
use dmzx\smartreadout\core\functions;

class main_controller
{
	/** @var template */
	protected $template;

	/** @var auth */
	protected $auth;

	/** @var config */
	protected $config;

	/** @var helper */
	protected $helper;

	/** @var functions */
	protected $functions;

	/**
	* Constructor
	*
	* @param template			$template
	* @param auth				$auth
	* @param config				$config
	* @param helper				$helper
	* @param functions			$functions
	*/
	public function __construct(
		template $template,
		auth $auth,
		config $config,
		helper $helper,
		functions $functions
	)
	{
		$this->template			= $template;
		$this->auth				= $auth;
		$this->config			= $config;
		$this->helper 			= $helper;
		$this->functions		= $functions;
	}

	public function handle_smart_read_out()
	{
		if ($this->config['smartreadout_allow_smartreadout'] && $this->config['smartreadout_ip_adress'] != '' && $this->auth->acl_get('u_smartreadout_view'))
		{
			$get_ip_array = $this->functions->get_ip_array();

			if ($this->config['smartreadout_phase_connect'] == 'L1')
			{
				$num_value = 34;
			}
			else if ($this->config['smartreadout_phase_connect'] == 'L2')
			{
				$num_value = 35;
			}
			else
			{
				$num_value = 36;
			}

			if (!empty($get_ip_array))
			{
				$this->template->assign_block_vars('smartreadout',[
					'ENERGY_RETURNED_TARIFF1'		=> number_format($get_ip_array->fields[7]->value, 2, '.', ''),
					'ENERGY_RETURNED_TARIFF2'		=> number_format($get_ip_array->fields[8]->value, 2, '.', ''),
					'POWER_DELIVERED'				=> number_format($get_ip_array->fields[10]->value, 2, '.', ''),
					'POWER_RETURNED'				=> number_format($get_ip_array->fields[11]->value, 2, '.', ''),
					'POWER_RETURNED_PHASE'			=> number_format($get_ip_array->fields[$num_value]->value, 2, '.', ''),
					'VOLTAGE_L1'					=> $get_ip_array->fields[25]->value . ' ' . $get_ip_array->fields[25]->unit,
					'VOLTAGE_L2'					=> $get_ip_array->fields[26]->value . ' ' . $get_ip_array->fields[26]->unit,
					'VOLTAGE_L3'					=> $get_ip_array->fields[27]->value . ' ' . $get_ip_array->fields[27]->unit,
					'CURRENT_L1'					=> $get_ip_array->fields[28]->value . ' ' . $get_ip_array->fields[28]->unit,
					'CURRENT_L2'					=> $get_ip_array->fields[29]->value . ' ' . $get_ip_array->fields[29]->unit,
					'CURRENT_L3'					=> $get_ip_array->fields[30]->value . ' ' . $get_ip_array->fields[30]->unit,
				]);

				$this->template->assign_var('SMARTREADOUT_ACTIVE_VIEW', true);
			}
			else
			{
				$this->template->assign_var('SMARTREADOUT_ACTIVE_VIEW', false);
			}

			// Send all data to the template file
			return $this->helper->render('smartreadout.html');
		}
	}
}
