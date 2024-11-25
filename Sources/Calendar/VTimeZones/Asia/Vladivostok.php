<?php

/**
 * Simple Machines Forum (SMF)
 *
 * @package SMF
 * @author Simple Machines https://www.simplemachines.org
 * @copyright 2024 Simple Machines and individual contributors
 * @license https://www.simplemachines.org/about/smf/license.php BSD
 *
 * @version 3.0 Alpha 2
 */

declare(strict_types=1);

namespace SMF\Calendar\VTimeZones\Asia;

/**
 * Asia/Vladivostok
 */
class Vladivostok extends \SMF\Calendar\VTimeZone
{
	/*******************
	 * Public properties
	 *******************/

	/**
	 * @var string
	 *
	 * Time zone identifier.
	 */
	public string $tzid = 'Asia/Vladivostok';

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
			'DTSTART' => '19221115T000000',
			'TZNAME' => 'UTC+09',
			'TZOFFSETFROM' => '+084731',
			'TZOFFSETTO' => '+0900',
		],
		1 => [
			'type' => 'STANDARD',
			'DTSTART' => '19300621T000000',
			'TZNAME' => 'UTC+10',
			'TZOFFSETFROM' => '+0900',
			'TZOFFSETTO' => '+1000',
		],
		2 => [
			'type' => 'DAYLIGHT',
			'DTSTART' => '19810401T000000',
			'RRULE' => 'FREQ=YEARLY;BYMONTH=4;BYMONTHDAY=1;UNTIL=19840401T000000',
			'TZNAME' => 'UTC+11',
			'TZOFFSETFROM' => '+1000',
			'TZOFFSETTO' => '+1100',
		],
		3 => [
			'type' => 'STANDARD',
			'DTSTART' => '19811001T000000',
			'RRULE' => 'FREQ=YEARLY;BYMONTH=10;BYMONTHDAY=1;UNTIL=19831001T000000',
			'TZNAME' => 'UTC+10',
			'TZOFFSETFROM' => '+1100',
			'TZOFFSETTO' => '+1000',
		],
		4 => [
			'type' => 'STANDARD',
			'DTSTART' => '19840930T030000',
			'RRULE' => 'FREQ=YEARLY;BYMONTH=9;BYDAY=-1SU;UNTIL=19950924T020000',
			'TZNAME' => 'UTC+10',
			'TZOFFSETFROM' => '+1100',
			'TZOFFSETTO' => '+1000',
		],
		5 => [
			'type' => 'DAYLIGHT',
			'DTSTART' => '19850331T020000',
			'RRULE' => 'FREQ=YEARLY;BYMONTH=3;BYDAY=-1SU;UNTIL=20100328T020000',
			'TZNAME' => 'UTC+11',
			'TZOFFSETFROM' => '+1000',
			'TZOFFSETTO' => '+1100',
		],
		6 => [
			'type' => 'STANDARD',
			'DTSTART' => '19920119T020000',
			'TZNAME' => 'UTC+10',
			'TZOFFSETFROM' => '+0900',
			'TZOFFSETTO' => '+1000',
		],
		7 => [
			'type' => 'STANDARD',
			'DTSTART' => '19961027T030000',
			'RRULE' => 'FREQ=YEARLY;BYMONTH=10;BYDAY=-1SU;UNTIL=20101031T020000',
			'TZNAME' => 'UTC+10',
			'TZOFFSETFROM' => '+1100',
			'TZOFFSETTO' => '+1000',
		],
		8 => [
			'type' => 'STANDARD',
			'DTSTART' => '20110327T020000',
			'TZNAME' => 'UTC+11',
			'TZOFFSETFROM' => '+1000',
			'TZOFFSETTO' => '+1100',
		],
		9 => [
			'type' => 'STANDARD',
			'DTSTART' => '20141026T020000',
			'TZNAME' => 'UTC+10',
			'TZOFFSETFROM' => '+1100',
			'TZOFFSETTO' => '+1000',
		],
	];
}

?>