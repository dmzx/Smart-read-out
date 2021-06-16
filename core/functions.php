<?php
/**
*
* @package phpBB Extension - Smart read out
* @copyright (c) 2021 dmzx - https://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\smartreadout\core;

use phpbb\user;
use phpbb\auth\auth;
use phpbb\db\driver\driver_interface;
use phpbb\template\template;
use phpbb\extension\manager;
use phpbb\config\config;

class functions
{
	/** @var user */
	protected $user;

	/** @var auth */
	protected $auth;

	/** @var driver_interface */
	protected $db;

	/** @var template */
	protected $template;

	/** @var manager */
	protected $extension_manager;

	/** @var config */
	protected $config;

	/** @var string */
	protected $php_ext;

	/** @var string phpBB tables */
	protected $tables;

	/**
	* Constructor
	*
	* @param user				$user
	* @param auth				$auth
	* @param driver_interface 	$db
	* @param template			$template
	* @param manager 			$extension_manager
	* @param config				$config
	* @param string				$php_ext
	* @param array				$tables
	*/
	function __construct(
		user $user,
		auth $auth,
		driver_interface $db,
		template $template,
		manager $extension_manager,
		config $config,
		$php_ext,
		$tables
	)
	{
		$this->user					= $user;
		$this->auth					= $auth;
		$this->db					= $db;
		$this->template				= $template;
		$this->extension_manager	= $extension_manager;
		$this->config				= $config;
		$this->php_ext				= $php_ext;
		$this->tables				= $tables;
	}

	// Store values to database
	public function smartreadout_log()
	{
		if ($this->config['smartreadout_enable_log'])
		{
			$get_ip_array = $this->get_ip_array();

			// Sets the values required for the log
			$sql_ary = [
				'sro_timestamp'					=> time(),
				'sro_energy_delivered_tariff1'	=> $get_ip_array->fields[4]->value,
				'sro_energy_delivered_tariff2'	=> $get_ip_array->fields[5]->value,
				'sro_energy_returned_tariff1'	=> $get_ip_array->fields[6]->value,
				'sro_energy_returned_tariff2'	=> $get_ip_array->fields[7]->value,
				'sro_power_delivered'			=> $get_ip_array->fields[9]->value,
				'sro_power_returned'			=> $get_ip_array->fields[10]->value,
				'sro_voltage_l1'				=> $get_ip_array->fields[24]->value,
				'sro_voltage_l2'				=> $get_ip_array->fields[25]->value,
				'sro_voltage_l3'				=> $get_ip_array->fields[26]->value,
				'sro_current_l1'				=> $get_ip_array->fields[27]->value,
				'sro_current_l2'				=> $get_ip_array->fields[28]->value,
				'sro_current_l3'				=> $get_ip_array->fields[29]->value,
				'sro_power_delivered_l1'		=> $get_ip_array->fields[30]->value,
				'sro_power_delivered_l2'		=> $get_ip_array->fields[31]->value,
				'sro_power_delivered_l3'		=> $get_ip_array->fields[32]->value,
				'sro_power_returned_l1'			=> $get_ip_array->fields[33]->value,
				'sro_power_returned_l2'			=> $get_ip_array->fields[34]->value,
				'sro_power_returned_l3'			=> $get_ip_array->fields[35]->value,
				'sro_gas_delivered'				=> $get_ip_array->fields[39]->value,
			];

			// Insert the data into the database
			$sql = 'INSERT INTO ' . $this->tables['smartreadout_log'] . ' ' . $this->db->sql_build_array('INSERT', $sql_ary);
			$this->db->sql_query($sql);
		}
	}

	// Get curl
	public function get_ip_array()
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

		$curl_handle = curl_init();
		curl_setopt($curl_handle, CURLOPT_URL, $url_to_api);
		curl_setopt($curl_handle, CURLOPT_HTTPHEADER,['Content-Type: application/json']);
		curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
		$ip_query = curl_exec($curl_handle);
		curl_close($curl_handle);

		$ip_array = json_decode($ip_query);

		return $ip_array;
	}

	// Get page name
	public function page_name()
	{
		$this_page = explode(".", $this->user->page['page']);
		$this_page_name = $this_page[0];

		return($this_page_name);
	}

	// Assign author
	public function assign_authors()
	{
		$md_manager = $this->extension_manager->create_extension_metadata_manager('dmzx/smartreadout', $this->template);
		$meta = $md_manager->get_metadata();
		$author_names = [];
		$author_homepages = [];

		foreach ($meta['authors'] as $author)
		{
			$author_names[] = $author['name'];
			$author_homepages[] = sprintf('<a href="%1$s" title="%2$s">%2$s</a>', $author['homepage'], $author['name']);
		}

		$this->template->assign_vars([
			'SMARTREADOUT_DISPLAY_NAME'		=> $meta['extra']['display-name'],
			'SMARTREADOUT_AUTHOR_NAMES'		=> implode(' &amp; ', $author_names),
			'SMARTREADOUT_AUTHOR_HOMEPAGES'	=> implode(' &amp; ', $author_homepages),
		]);

		return;
	}
}
