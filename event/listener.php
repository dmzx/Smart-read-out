<?php
/**
*
* @package phpBB Extension - Smart read out
* @copyright (c) 2021 dmzx - https://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\smartreadout\event;

use phpbb\user;
use phpbb\template\template;
use phpbb\auth\auth;
use phpbb\config\config;
use phpbb\controller\helper;
use dmzx\smartreadout\core\functions;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	/** @var user */
	protected $user;

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
	* @param user				$user
	* @param template			$template
	* @param auth				$auth
	* @param config				$config
	* @param helper				$helper
	* @param functions			$functions
	*/
	public function __construct(
		user $user,
		template $template,
		auth $auth,
		config $config,
		helper $helper,
		functions $functions
	)
	{
		$this->user				= $user;
		$this->template			= $template;
		$this->auth				= $auth;
		$this->config			= $config;
		$this->helper 			= $helper;
		$this->functions		= $functions;
	}

	public static function getSubscribedEvents()
	{
		return [
			'core.permissions'					=> 'permissions',
			'core.user_setup'					=> 'load_language_on_setup',
			'core.page_header_after'			=> 'page_header_after',
			'core.page_footer_after'			=> 'page_footer_after',
		];
	}

	public function permissions($event)
	{
		$permissions = $event['permissions'];
		$permissions['u_smartreadout_view'] = ['lang' => 'ACL_U_SMARTREADOUT', 'cat' => 'misc'];
		$event['permissions'] = $permissions;
	}

	public function load_language_on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = [
			'ext_name' => 'dmzx/smartreadout',
			'lang_set' => 'common',
		];
		$event['lang_set_ext'] = $lang_set_ext;
	}

	public function page_header_after($event)
	{
		if ($this->config['smartreadout_allow_smartreadout'])
		{
			$page = '';
			$page = $this->functions->page_name();

			$this->template->assign_vars([
				'S_SMARTREADOUT_ALLOW_SMARTREADOUT'	=> $this->config['smartreadout_allow_smartreadout'],
				'U_SMARTREADOUT_SMART_READ_OUT'		=> $this->helper->route('dmzx_smartreadout_smart_read_out'),
				'SMART_READ_OUT'					=> '<div id="smart_read_out"></div>',
				'SMARTREADOUT_VIEW'					=> $this->auth->acl_get('u_smartreadout_view'),
				'SMARTREADOUT_REFRESH'				=> $this->config['smartreadout_refresh'] * 1000,
				'S_SMARTREADOUT_AVAILABLE_NET'		=> !$this->config['smartreadout_available_net'],
				'SMARTREADOUT_TOTAL_SOLAR_POWER'	=> $this->config['smartreadout_total_solar_power'],
				'SMARTREADOUT_TOTAL_POWER'			=> $this->config['smartreadout_total_power'],
				'SMARTREADOUT_VERSION'				=> $this->config['smartreadout_version'],
			]);

			if ($page == 'index')
			{
				$this->functions->assign_authors();
				$this->template->assign_var('SMARTREADOUT_FOOTER_VIEW', true);
			}
		}
	}

	public function page_footer_after($event)
	{
		// If smart read out log is enabled store the values into the database.
		if ($this->config['smartreadout_enable_log'])
		{
			$this->functions->smartreadout_log();
		}
	}
}
