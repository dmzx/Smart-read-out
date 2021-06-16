<?php
/**
*
* @package phpBB Extension - Smart read out
* @copyright (c) 2021 dmzx - https://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\smartreadout\migrations;

class smartreadout_v103 extends \phpbb\db\migration\migration
{
	public static function depends_on()
	{
		return [
			'\dmzx\smartreadout\migrations\smartreadout_v102'
		];
	}

	public function update_data()
	{
		return [
			// Update config
			['config.update', ['smartreadout_version', '1.0.3']],
		];
	}
}
