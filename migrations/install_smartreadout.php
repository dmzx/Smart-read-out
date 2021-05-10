<?php
/**
*
* @package phpBB Extension - Smart read out
* @copyright (c) 2021 dmzx - https://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\smartreadout\migrations;

class install_smartreadout extends \phpbb\db\migration\migration
{
	public function update_data()
	{
		return [
			// Add configs
			['config.add', ['smartreadout_version', '1.0.0']],
			['config.add', ['smartreadout_allow_smartreadout', 0]],
			['config.add', ['smartreadout_ip_adress', '']],
			['config.add', ['smartreadout_ip_port', '']],
			['config.add', ['smartreadout_available_net', 1]],
			['config.add', ['smartreadout_phase_connect', 'L1']],
			['config.add', ['smartreadout_total_solar_power', '']],
			['config.add', ['smartreadout_total_power', '']],
			['config.add', ['smartreadout_enable_log', 0]],
			['config.add', ['smartreadout_refresh', 10]],
			// Permission
			['permission.add', ['u_smartreadout_view', true]],
			// Set Permission
			['permission.permission_set', ['REGISTERED', 'u_smartreadout_view', 'group', true]],

			['module.add', [
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_SMARTREADOUT_TITLE'
			]],
			['module.add', [
				'acp',
				'ACP_SMARTREADOUT_TITLE',
				[
					'module_basename'	=> '\dmzx\smartreadout\acp\main_module',
				],
			]],
		];
	}

	public function update_schema()
	{
		return [
			'add_tables'	=> [
				$this->table_prefix . 'smartreadout_log'	=> [
					'COLUMNS'	=> [
						'sro_id'						=> ['UINT', null, 'auto_increment'],
						'sro_timestamp'					=> ['UINT:11', 0],
						'sro_energy_delivered_tariff1'	=> ['VCHAR', ''],
						'sro_energy_delivered_tariff2'	=> ['VCHAR', ''],
						'sro_energy_returned_tariff1'	=> ['VCHAR', ''],
						'sro_energy_returned_tariff2'	=> ['VCHAR', ''],
						'sro_power_delivered'			=> ['VCHAR', ''],
						'sro_power_returned'			=> ['VCHAR', ''],
						'sro_voltage_l1'				=> ['VCHAR', ''],
						'sro_voltage_l2'				=> ['VCHAR', ''],
						'sro_voltage_l3'				=> ['VCHAR', ''],
						'sro_current_l1'				=> ['VCHAR', ''],
						'sro_current_l2'				=> ['VCHAR', ''],
						'sro_current_l3'				=> ['VCHAR', ''],
						'sro_power_delivered_l1'		=> ['VCHAR', ''],
						'sro_power_delivered_l2'		=> ['VCHAR', ''],
						'sro_power_delivered_l3'		=> ['VCHAR', ''],
						'sro_power_returned_l1'			=> ['VCHAR', ''],
						'sro_power_returned_l2'			=> ['VCHAR', ''],
						'sro_power_returned_l3'			=> ['VCHAR', ''],
						'sro_gas_delivered'				=> ['VCHAR', ''],
					],
					'PRIMARY_KEY' => 'sro_id',
				],
			],
		];
	}

	/**
	* Drop the smartreadout_log table schema from the database
	*
	* @return array Array of table schema
	* @access public
	*/
	public function revert_schema()
	{
		return [
			'drop_tables'	=> [
				$this->table_prefix . 'smartreadout_log',
			],
		];
	}
}
