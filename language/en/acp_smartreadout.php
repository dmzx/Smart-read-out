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
	'ACP_SMARTREADOUT_ALLOW_SMARTREADOUT'						=> 'Enable Smart read out',
	'ACP_SMARTREADOUT_ALLOW_SMARTREADOUT_EXPLAIN'				=> 'Enable Smart read out Extension',
	'ACP_SMARTREADOUT_IP_ADRESS'								=> 'Set IP address',
	'ACP_SMARTREADOUT_IP_ADRESS_EXPLAIN'						=> 'Set local IP address or fixed IP.',
	'ACP_SMARTREADOUT_IP_PORT'									=> 'Set port',
	'ACP_SMARTREADOUT_IP_PORT_EXPLAIN'							=> 'If fixed IP is set set also your port here.<br>Leave blank if local IP is used.',
	'ACP_SMARTREADOUT_AVAILABLE_NET'							=> 'Select network',
	'ACP_ACP_SMARTREADOUT_AVAILABLE_NET_EXPLAIN'				=> 'Set network you have available.',
	'ACP_SMARTREADOUT_AVAILABLE_NET_SINGLE_PHASE'				=> '1 phase',
	'ACP_SMARTREADOUT_AVAILABLE_NET_THREE_PHASE'				=> '3 phase',
	'ACP_SMARTREADOUT_PHASE_CONNECT'							=> 'Select phase',
	'ACP_SMARTREADOUT_PHASE_CONNECT_EXPLAIN'					=> 'Set phase where Solar panels are connected.',
	'ACP_SMARTREADOUT_TOTAL_SOLAR_POWER'						=> 'Set total solar power',
	'ACP_SMARTREADOUT_TOTAL_SOLAR_POWER_EXPLAIN'				=> 'Set total solar power you have available in Watts.<br><em>Example: 1x 16 Amps = 3680 Watts</em>.',
	'ACP_SMARTREADOUT_TOTAL_POWER'								=> 'Set total power',
	'ACP_SMARTREADOUT_TOTAL_POWER_EXPLAIN'						=> 'Set total power you have available in Watts.<br><em>Example: 3x 25 Amps = 17000 Watts</em>.',
	'ACP_SMARTREADOUT_ENABLE_LOG'								=> 'Enable log function',
	'ACP_SMARTREADOUT_ENABLE_LOG_EXPLAIN'						=> 'If enabled all actual data will be stored in database.',
	'ACP_SMARTREADOUT_REFRESH'									=> 'Refresh interval',
	'ACP_SMARTREADOUT_REFRESH_EXPLAIN'							=> 'Number of seconds before the Smart read out refreshes.<br><em>You are limited from 5 to 60 seconds.<br>Default is 10</em>.',
	'ACP_SMARTREADOUT_PHASE_CONNECT_L1'							=> 'L1',
	'ACP_SMARTREADOUT_PHASE_CONNECT_L2'							=> 'L2',
	'ACP_SMARTREADOUT_PHASE_CONNECT_L3'							=> 'L3',
]);
