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
			$ip_adres = $this->config['smartreadout_ip_adress'];
			$ip_port = $this->config['smartreadout_ip_port'];

			if ($ip_port ==	'')
			{
				$url_to_api = 'http://' . $ip_adres . '/api/v1/sm/fields';
			}
			else
			{
				$url_to_api = 'http://' . $ip_adres . ':' . $ip_port . '/api/v1/sm/fields';
			}

			if ($this->config['smartreadout_phase_connect'] == 'L1')
			{
				$num_value = 33;
			}
			else if ($this->config['smartreadout_phase_connect'] == 'L2')
			{
				$num_value = 34;
			}
			else
			{
				$num_value = 35;
			}

			$curl_handle = curl_init();
			curl_setopt($curl_handle, CURLOPT_URL, $url_to_api);
			curl_setopt($curl_handle, CURLOPT_HTTPHEADER,['Content-Type: application/json']);
			curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
			$ip_query = curl_exec($curl_handle);
			curl_close($curl_handle);

			$ip_array = json_decode($ip_query);

			// If smart read out log is enabled store the values into the database.
			if ($this->config['smartreadout_enable_log'])
			{
				$this->functions->smartreadout_log($ip_array);
			}

			$this->template->assign_block_vars('smartreadout',[
				'ENERGY_RETURNED_TARIFF1'		=> number_format($ip_array->fields[6]->value, 2, '.', ''),
				'ENERGY_RETURNED_TARIFF2'		=> number_format($ip_array->fields[7]->value, 2, '.', ''),
				'POWER_DELIVERED'				=> number_format($ip_array->fields[9]->value, 2, '.', ''),
				'POWER_RETURNED'				=> number_format($ip_array->fields[10]->value, 2, '.', ''),
				'POWER_RETURNED_PHASE'			=> number_format($ip_array->fields[$num_value]->value, 2, '.', ''),
				'VOLTAGE_L1'					=> $ip_array->fields[24]->value,
				'VOLTAGE_L2'					=> $ip_array->fields[25]->value,
				'VOLTAGE_L3'					=> $ip_array->fields[26]->value,
				'CURRENT_L1'					=> $ip_array->fields[27]->value,
				'CURRENT_L2'					=> $ip_array->fields[28]->value,
				'CURRENT_L3'					=> $ip_array->fields[29]->value,
			]);

			$this->template->assign_var('SMARTREADOUT_ACTIVE_VIEW', true);

			// Send all data to the template file
			return $this->helper->render('smartreadout.html');
		}
	}
}
