<?php
/**
*
* @package phpBB Extension - Smart read out
* @copyright (c) 2021 dmzx - https://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

/**
* DO NOT CHANGE
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters for use
// ’ » “ ” …

$lang = array_merge($lang, [
	'SMARTREADOUT_OVERVIEW'							=> 'Smart read out overview',
	'SMARTREADOUT_SOLAR_POWER_TOTAL'				=> 'Solar power total',
	'SMARTREADOUT_WON_SOLAR_ENERGY'					=> '(Won solar energy)',
	'SMARTREADOUT_POWER_RETURNED'					=> 'Power returned',
	'SMARTREADOUT_RETURNED_TO_NET'					=> '(Returned to net)',
	'SMARTREADOUT_POWER_USED'						=> 'Power used',
	'SMARTREADOUT_TOTAL_MIN_RETURNED'				=> '(Total - Solar returned)',
	'SMARTREADOUT_ENERGY_RETURNED'					=> 'Energy returned',
	'SMARTREADOUT_TARRIF_1'							=> 'tariff 1',
	'SMARTREADOUT_TARRIF_2'							=> 'tariff 2',
	'SMARTREADOUT_VOLTAGE'							=> 'Voltage',
	'SMARTREADOUT_PHASE_1'							=> 'phase 1',
	'SMARTREADOUT_PHASE_2'							=> 'phase 2',
	'SMARTREADOUT_PHASE_3'							=> 'phase 3',
	'SMARTREADOUT_CURRENT'							=> 'Current',
	'SMARTREADOUT_VERSION'							=> 'Version',
	'SMARTREADOUT_KW'								=> 'kW',
]);
