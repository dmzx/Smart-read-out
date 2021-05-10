<?php
/**
*
* @package phpBB Extension - Smart read out
* @copyright (c) 2021 dmzx - https://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\smartreadout\acp;

class main_info
{
	function module()
	{
		return [
			'filename'	=> '\dmzx\smartreadout\acp\main_module',
			'title'		=> 'ACP_SMARTREADOUT_TITLE',
			'version'	=> '1.0.0',
			'modes'		=> [
				'settings'	=> ['title' => 'ACP_SMARTREADOUT_SETTINGS', 'auth' => 'ext_dmzx/smartreadout && acl_a_board', 'cat' => ['ACP_SMARTREADOUT_TITLE']],
			],
		];
	}
}
