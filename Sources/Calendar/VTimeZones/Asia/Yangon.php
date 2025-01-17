<?php

/**
 * Simple Machines Forum (SMF)
 *
 * @package SMF
 * @author Simple Machines https://www.simplemachines.org
 * @copyright 2025 Simple Machines and individual contributors
 * @license https://www.simplemachines.org/about/smf/license.php BSD
 *
 * @version 3.0 Alpha 2
 */

declare(strict_types=1);

namespace SMF\Calendar\VTimeZones\Asia;

/**
 * Asia/Yangon
 */
class Yangon extends \SMF\Calendar\VTimeZone
{
	/*******************
	 * Public properties
	 *******************/

	/**
	 * @var string
	 *
	 * Time zone identifier.
	 */
	public string $tzid = 'Asia/Yangon';

	/**
	 * @var array
	 *
	 * Data for the VTIMEZONE components.
	 *
	 * Developers: Do not update the data in this array manually. Instead,
	 * run "php -f other/update_timezones.php" on the command line.
	 */
	public array $components = [
		0 => [
			'type' => 'STANDARD',
			'DTSTART' => '19200101T000000',
			'TZNAME' => 'UTC+0630',
			'TZOFFSETFROM' => '+062447',
			'TZOFFSETTO' => '+0630',
		],
		1 => [
			'type' => 'STANDARD',
			'DTSTART' => '19420501T000000',
			'TZNAME' => 'UTC+09',
			'TZOFFSETFROM' => '+0630',
			'TZOFFSETTO' => '+0900',
		],
		2 => [
			'type' => 'STANDARD',
			'DTSTART' => '19450503T000000',
			'TZNAME' => 'UTC+0630',
			'TZOFFSETFROM' => '+0900',
			'TZOFFSETTO' => '+0630',
		],
	];
}

?>