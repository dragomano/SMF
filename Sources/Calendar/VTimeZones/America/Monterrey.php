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

namespace SMF\Calendar\VTimeZones\America;

/**
 * America/Monterrey
 */
class Monterrey extends \SMF\Calendar\VTimeZone
{
	/*******************
	 * Public properties
	 *******************/

	/**
	 * @var string
	 *
	 * Time zone identifier.
	 */
	public string $tzid = 'America/Monterrey';

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
			'DTSTART' => '19211231T231844',
			'TZNAME' => 'MST',
			'TZOFFSETFROM' => '-064116',
			'TZOFFSETTO' => '-0700',
		],
		1 => [
			'type' => 'STANDARD',
			'DTSTART' => '19270610T000000',
			'TZNAME' => 'CST',
			'TZOFFSETFROM' => '-0700',
			'TZOFFSETTO' => '-0600',
		],
		2 => [
			'type' => 'STANDARD',
			'DTSTART' => '19301115T000000',
			'TZNAME' => 'MST',
			'TZOFFSETFROM' => '-0600',
			'TZOFFSETTO' => '-0700',
		],
		3 => [
			'type' => 'DAYLIGHT',
			'DTSTART' => '19310430T000000',
			'TZNAME' => 'MDT',
			'TZOFFSETFROM' => '-0700',
			'TZOFFSETTO' => '-0600',
		],
		4 => [
			'type' => 'STANDARD',
			'DTSTART' => '19311001T000000',
			'TZNAME' => 'MST',
			'TZOFFSETFROM' => '-0600',
			'TZOFFSETTO' => '-0700',
		],
		5 => [
			'type' => 'STANDARD',
			'DTSTART' => '19320401T000000',
			'TZNAME' => 'CST',
			'TZOFFSETFROM' => '-0700',
			'TZOFFSETTO' => '-0600',
		],
		6 => [
			'type' => 'DAYLIGHT',
			'DTSTART' => '19870405T020000',
			'RRULE' => 'FREQ=YEARLY;BYMONTH=4;BYDAY=1SU;UNTIL=20060402T020000',
			'TZNAME' => 'CDT',
			'TZOFFSETFROM' => '-0600',
			'TZOFFSETTO' => '-0500',
		],
		7 => [
			'type' => 'STANDARD',
			'DTSTART' => '19671029T020000',
			'RRULE' => 'FREQ=YEARLY;BYMONTH=10;BYDAY=-1SU;UNTIL=20061029T020000',
			'TZNAME' => 'CST',
			'TZOFFSETFROM' => '-0500',
			'TZOFFSETTO' => '-0600',
		],
		8 => [
			'type' => 'DAYLIGHT',
			'DTSTART' => '19960407T020000',
			'RRULE' => 'FREQ=YEARLY;BYMONTH=4;BYDAY=1SU;UNTIL=20000402T020000',
			'TZNAME' => 'CDT',
			'TZOFFSETFROM' => '-0600',
			'TZOFFSETTO' => '-0500',
		],
		9 => [
			'type' => 'STANDARD',
			'DTSTART' => '19961027T020000',
			'RRULE' => 'FREQ=YEARLY;BYMONTH=10;BYDAY=-1SU;UNTIL=20001029T020000',
			'TZNAME' => 'CST',
			'TZOFFSETFROM' => '-0500',
			'TZOFFSETTO' => '-0600',
		],
		10 => [
			'type' => 'DAYLIGHT',
			'DTSTART' => '20010506T020000',
			'TZNAME' => 'CDT',
			'TZOFFSETFROM' => '-0600',
			'TZOFFSETTO' => '-0500',
		],
		11 => [
			'type' => 'STANDARD',
			'DTSTART' => '20010930T020000',
			'TZNAME' => 'CST',
			'TZOFFSETFROM' => '-0500',
			'TZOFFSETTO' => '-0600',
		],
		12 => [
			'type' => 'DAYLIGHT',
			'DTSTART' => '20020407T020000',
			'RRULE' => 'FREQ=YEARLY;BYMONTH=4;BYDAY=1SU;UNTIL=20220403T020000',
			'TZNAME' => 'CDT',
			'TZOFFSETFROM' => '-0600',
			'TZOFFSETTO' => '-0500',
		],
		13 => [
			'type' => 'STANDARD',
			'DTSTART' => '20021027T020000',
			'RRULE' => 'FREQ=YEARLY;BYMONTH=10;BYDAY=-1SU;UNTIL=20221030T020000',
			'TZNAME' => 'CST',
			'TZOFFSETFROM' => '-0500',
			'TZOFFSETTO' => '-0600',
		],
	];
}

?>