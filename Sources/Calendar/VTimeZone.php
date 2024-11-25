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

namespace SMF\Calendar;

/**
 * Represents iCalendar time zone data, which RFC 5545 labels as a VTIMEZONE.
 *
 * Primarily used for building VTIMEZONE data that must be included in exported
 * iCalendar documents in order to conform to RFC 5545.
 */
abstract class VTimeZone
{
	/*****************
	 * Class constants
	 *****************/

	/**
	 * @var array
	 *
	 * Links deprecated time zone identifiers to their canonical values.
	 *
	 * Developers: Do not update the data in this array manually. Instead,
	 * run "php -f other/update_timezones.php" on the command line.
	 */
	public const CANONICAL_LINKS = [
		'Africa/Accra' => 'Africa/Abidjan',
		'Africa/Addis_Ababa' => 'Africa/Nairobi',
		'Africa/Asmara' => 'Africa/Nairobi',
		'Africa/Asmera' => 'Africa/Nairobi',
		'Africa/Bamako' => 'Africa/Abidjan',
		'Africa/Bangui' => 'Africa/Lagos',
		'Africa/Banjul' => 'Africa/Abidjan',
		'Africa/Blantyre' => 'Africa/Maputo',
		'Africa/Brazzaville' => 'Africa/Lagos',
		'Africa/Bujumbura' => 'Africa/Maputo',
		'Africa/Conakry' => 'Africa/Abidjan',
		'Africa/Dakar' => 'Africa/Abidjan',
		'Africa/Dar_es_Salaam' => 'Africa/Nairobi',
		'Africa/Djibouti' => 'Africa/Nairobi',
		'Africa/Douala' => 'Africa/Lagos',
		'Africa/Freetown' => 'Africa/Abidjan',
		'Africa/Gaborone' => 'Africa/Maputo',
		'Africa/Harare' => 'Africa/Maputo',
		'Africa/Kampala' => 'Africa/Nairobi',
		'Africa/Kigali' => 'Africa/Maputo',
		'Africa/Kinshasa' => 'Africa/Lagos',
		'Africa/Libreville' => 'Africa/Lagos',
		'Africa/Lome' => 'Africa/Abidjan',
		'Africa/Luanda' => 'Africa/Lagos',
		'Africa/Lubumbashi' => 'Africa/Maputo',
		'Africa/Lusaka' => 'Africa/Maputo',
		'Africa/Malabo' => 'Africa/Lagos',
		'Africa/Maseru' => 'Africa/Johannesburg',
		'Africa/Mbabane' => 'Africa/Johannesburg',
		'Africa/Mogadishu' => 'Africa/Nairobi',
		'Africa/Niamey' => 'Africa/Lagos',
		'Africa/Nouakchott' => 'Africa/Abidjan',
		'Africa/Ouagadougou' => 'Africa/Abidjan',
		'Africa/Porto-Novo' => 'Africa/Lagos',
		'Africa/Timbuktu' => 'Africa/Abidjan',
		'America/Anguilla' => 'America/Puerto_Rico',
		'America/Antigua' => 'America/Puerto_Rico',
		'America/Argentina/ComodRivadavia' => 'America/Argentina/Catamarca',
		'America/Aruba' => 'America/Puerto_Rico',
		'America/Atikokan' => 'America/Panama',
		'America/Atka' => 'America/Adak',
		'America/Blanc-Sablon' => 'America/Puerto_Rico',
		'America/Buenos_Aires' => 'America/Argentina/Buenos_Aires',
		'America/Catamarca' => 'America/Argentina/Catamarca',
		'America/Cayman' => 'America/Panama',
		'America/Coral_Harbour' => 'America/Panama',
		'America/Cordoba' => 'America/Argentina/Cordoba',
		'America/Creston' => 'America/Phoenix',
		'America/Curacao' => 'America/Puerto_Rico',
		'America/Dominica' => 'America/Puerto_Rico',
		'America/Ensenada' => 'America/Tijuana',
		'America/Fort_Wayne' => 'America/Indiana/Indianapolis',
		'America/Godthab' => 'America/Nuuk',
		'America/Grenada' => 'America/Puerto_Rico',
		'America/Guadeloupe' => 'America/Puerto_Rico',
		'America/Indianapolis' => 'America/Indiana/Indianapolis',
		'America/Jujuy' => 'America/Argentina/Jujuy',
		'America/Knox_IN' => 'America/Indiana/Knox',
		'America/Kralendijk' => 'America/Puerto_Rico',
		'America/Louisville' => 'America/Kentucky/Louisville',
		'America/Lower_Princes' => 'America/Puerto_Rico',
		'America/Marigot' => 'America/Puerto_Rico',
		'America/Mendoza' => 'America/Argentina/Mendoza',
		'America/Montreal' => 'America/Toronto',
		'America/Montserrat' => 'America/Puerto_Rico',
		'America/Nassau' => 'America/Toronto',
		'America/Nipigon' => 'America/Toronto',
		'America/Pangnirtung' => 'America/Iqaluit',
		'America/Port_of_Spain' => 'America/Puerto_Rico',
		'America/Porto_Acre' => 'America/Rio_Branco',
		'America/Rainy_River' => 'America/Winnipeg',
		'America/Rosario' => 'America/Argentina/Cordoba',
		'America/Santa_Isabel' => 'America/Tijuana',
		'America/Shiprock' => 'America/Denver',
		'America/St_Barthelemy' => 'America/Puerto_Rico',
		'America/St_Kitts' => 'America/Puerto_Rico',
		'America/St_Lucia' => 'America/Puerto_Rico',
		'America/St_Thomas' => 'America/Puerto_Rico',
		'America/St_Vincent' => 'America/Puerto_Rico',
		'America/Thunder_Bay' => 'America/Toronto',
		'America/Tortola' => 'America/Puerto_Rico',
		'America/Virgin' => 'America/Puerto_Rico',
		'America/Yellowknife' => 'America/Edmonton',
		'Antarctica/DumontDUrville' => 'Pacific/Port_Moresby',
		'Antarctica/McMurdo' => 'Pacific/Auckland',
		'Antarctica/South_Pole' => 'Pacific/Auckland',
		'Antarctica/Syowa' => 'Asia/Riyadh',
		'Arctic/Longyearbyen' => 'Europe/Berlin',
		'Asia/Aden' => 'Asia/Riyadh',
		'Asia/Ashkhabad' => 'Asia/Ashgabat',
		'Asia/Bahrain' => 'Asia/Qatar',
		'Asia/Brunei' => 'Asia/Kuching',
		'Asia/Calcutta' => 'Asia/Kolkata',
		'Asia/Choibalsan' => 'Asia/Ulaanbaatar',
		'Asia/Chongqing' => 'Asia/Shanghai',
		'Asia/Chungking' => 'Asia/Shanghai',
		'Asia/Dacca' => 'Asia/Dhaka',
		'Asia/Harbin' => 'Asia/Shanghai',
		'Asia/Istanbul' => 'Europe/Istanbul',
		'Asia/Kashgar' => 'Asia/Urumqi',
		'Asia/Katmandu' => 'Asia/Kathmandu',
		'Asia/Kuala_Lumpur' => 'Asia/Singapore',
		'Asia/Kuwait' => 'Asia/Riyadh',
		'Asia/Macao' => 'Asia/Macau',
		'Asia/Muscat' => 'Asia/Dubai',
		'Asia/Phnom_Penh' => 'Asia/Bangkok',
		'Asia/Rangoon' => 'Asia/Yangon',
		'Asia/Saigon' => 'Asia/Ho_Chi_Minh',
		'Asia/Tel_Aviv' => 'Asia/Jerusalem',
		'Asia/Thimbu' => 'Asia/Thimphu',
		'Asia/Ujung_Pandang' => 'Asia/Makassar',
		'Asia/Ulan_Bator' => 'Asia/Ulaanbaatar',
		'Asia/Vientiane' => 'Asia/Bangkok',
		'Atlantic/Faeroe' => 'Atlantic/Faroe',
		'Atlantic/Jan_Mayen' => 'Europe/Berlin',
		'Atlantic/Reykjavik' => 'Africa/Abidjan',
		'Atlantic/St_Helena' => 'Africa/Abidjan',
		'Australia/ACT' => 'Australia/Sydney',
		'Australia/Canberra' => 'Australia/Sydney',
		'Australia/Currie' => 'Australia/Hobart',
		'Australia/LHI' => 'Australia/Lord_Howe',
		'Australia/NSW' => 'Australia/Sydney',
		'Australia/North' => 'Australia/Darwin',
		'Australia/Queensland' => 'Australia/Brisbane',
		'Australia/South' => 'Australia/Adelaide',
		'Australia/Tasmania' => 'Australia/Hobart',
		'Australia/Victoria' => 'Australia/Melbourne',
		'Australia/West' => 'Australia/Perth',
		'Australia/Yancowinna' => 'Australia/Broken_Hill',
		'Brazil/Acre' => 'America/Rio_Branco',
		'Brazil/DeNoronha' => 'America/Noronha',
		'Brazil/East' => 'America/Sao_Paulo',
		'Brazil/West' => 'America/Manaus',
		'CET' => 'Europe/Brussels',
		'CST6CDT' => 'America/Chicago',
		'Canada/Atlantic' => 'America/Halifax',
		'Canada/Central' => 'America/Winnipeg',
		'Canada/Eastern' => 'America/Toronto',
		'Canada/Mountain' => 'America/Edmonton',
		'Canada/Newfoundland' => 'America/St_Johns',
		'Canada/Pacific' => 'America/Vancouver',
		'Canada/Saskatchewan' => 'America/Regina',
		'Canada/Yukon' => 'America/Whitehorse',
		'Chile/Continental' => 'America/Santiago',
		'Chile/EasterIsland' => 'Pacific/Easter',
		'Cuba' => 'America/Havana',
		'EET' => 'Europe/Athens',
		'EST' => 'America/Panama',
		'EST5EDT' => 'America/New_York',
		'Egypt' => 'Africa/Cairo',
		'Eire' => 'Europe/Dublin',
		'Etc/GMT+0' => 'Etc/GMT',
		'Etc/GMT-0' => 'Etc/GMT',
		'Etc/GMT0' => 'Etc/GMT',
		'Etc/Greenwich' => 'Etc/GMT',
		'Etc/UCT' => 'Etc/UTC',
		'Etc/Universal' => 'Etc/UTC',
		'Etc/Zulu' => 'Etc/UTC',
		'Europe/Amsterdam' => 'Europe/Brussels',
		'Europe/Belfast' => 'Europe/London',
		'Europe/Bratislava' => 'Europe/Prague',
		'Europe/Busingen' => 'Europe/Zurich',
		'Europe/Copenhagen' => 'Europe/Berlin',
		'Europe/Guernsey' => 'Europe/London',
		'Europe/Isle_of_Man' => 'Europe/London',
		'Europe/Jersey' => 'Europe/London',
		'Europe/Kiev' => 'Europe/Kyiv',
		'Europe/Ljubljana' => 'Europe/Belgrade',
		'Europe/Luxembourg' => 'Europe/Brussels',
		'Europe/Mariehamn' => 'Europe/Helsinki',
		'Europe/Monaco' => 'Europe/Paris',
		'Europe/Nicosia' => 'Asia/Nicosia',
		'Europe/Oslo' => 'Europe/Berlin',
		'Europe/Podgorica' => 'Europe/Belgrade',
		'Europe/San_Marino' => 'Europe/Rome',
		'Europe/Sarajevo' => 'Europe/Belgrade',
		'Europe/Skopje' => 'Europe/Belgrade',
		'Europe/Stockholm' => 'Europe/Berlin',
		'Europe/Tiraspol' => 'Europe/Chisinau',
		'Europe/Uzhgorod' => 'Europe/Kyiv',
		'Europe/Vaduz' => 'Europe/Zurich',
		'Europe/Vatican' => 'Europe/Rome',
		'Europe/Zagreb' => 'Europe/Belgrade',
		'Europe/Zaporozhye' => 'Europe/Kyiv',
		'GB' => 'Europe/London',
		'GB-Eire' => 'Europe/London',
		'GMT' => 'Etc/GMT',
		'GMT+0' => 'Etc/GMT',
		'GMT-0' => 'Etc/GMT',
		'GMT0' => 'Etc/GMT',
		'Greenwich' => 'Etc/GMT',
		'HST' => 'Pacific/Honolulu',
		'Hongkong' => 'Asia/Hong_Kong',
		'Iceland' => 'Africa/Abidjan',
		'Indian/Antananarivo' => 'Africa/Nairobi',
		'Indian/Christmas' => 'Asia/Bangkok',
		'Indian/Cocos' => 'Asia/Yangon',
		'Indian/Comoro' => 'Africa/Nairobi',
		'Indian/Kerguelen' => 'Indian/Maldives',
		'Indian/Mahe' => 'Asia/Dubai',
		'Indian/Mayotte' => 'Africa/Nairobi',
		'Indian/Reunion' => 'Asia/Dubai',
		'Iran' => 'Asia/Tehran',
		'Israel' => 'Asia/Jerusalem',
		'Jamaica' => 'America/Jamaica',
		'Japan' => 'Asia/Tokyo',
		'Kwajalein' => 'Pacific/Kwajalein',
		'Libya' => 'Africa/Tripoli',
		'MET' => 'Europe/Brussels',
		'MST' => 'America/Phoenix',
		'MST7MDT' => 'America/Denver',
		'Mexico/BajaNorte' => 'America/Tijuana',
		'Mexico/BajaSur' => 'America/Mazatlan',
		'Mexico/General' => 'America/Mexico_City',
		'NZ' => 'Pacific/Auckland',
		'NZ-CHAT' => 'Pacific/Chatham',
		'Navajo' => 'America/Denver',
		'PRC' => 'Asia/Shanghai',
		'PST8PDT' => 'America/Los_Angeles',
		'Pacific/Chuuk' => 'Pacific/Port_Moresby',
		'Pacific/Enderbury' => 'Pacific/Kanton',
		'Pacific/Funafuti' => 'Pacific/Tarawa',
		'Pacific/Johnston' => 'Pacific/Honolulu',
		'Pacific/Majuro' => 'Pacific/Tarawa',
		'Pacific/Midway' => 'Pacific/Pago_Pago',
		'Pacific/Pohnpei' => 'Pacific/Guadalcanal',
		'Pacific/Ponape' => 'Pacific/Guadalcanal',
		'Pacific/Saipan' => 'Pacific/Guam',
		'Pacific/Samoa' => 'Pacific/Pago_Pago',
		'Pacific/Truk' => 'Pacific/Port_Moresby',
		'Pacific/Wake' => 'Pacific/Tarawa',
		'Pacific/Wallis' => 'Pacific/Tarawa',
		'Pacific/Yap' => 'Pacific/Port_Moresby',
		'Poland' => 'Europe/Warsaw',
		'Portugal' => 'Europe/Lisbon',
		'ROC' => 'Asia/Taipei',
		'ROK' => 'Asia/Seoul',
		'Singapore' => 'Asia/Singapore',
		'Turkey' => 'Europe/Istanbul',
		'UCT' => 'Etc/UTC',
		'US/Alaska' => 'America/Anchorage',
		'US/Aleutian' => 'America/Adak',
		'US/Arizona' => 'America/Phoenix',
		'US/Central' => 'America/Chicago',
		'US/East-Indiana' => 'America/Indiana/Indianapolis',
		'US/Eastern' => 'America/New_York',
		'US/Hawaii' => 'Pacific/Honolulu',
		'US/Indiana-Starke' => 'America/Indiana/Knox',
		'US/Michigan' => 'America/Detroit',
		'US/Mountain' => 'America/Denver',
		'US/Pacific' => 'America/Los_Angeles',
		'US/Samoa' => 'Pacific/Pago_Pago',
		'UTC' => 'Etc/UTC',
		'Universal' => 'Etc/UTC',
		'W-SU' => 'Europe/Moscow',
		'WET' => 'Europe/Lisbon',
		'Zulu' => 'Etc/UTC',
	];

	/*******************
	 * Public properties
	 *******************/

	/**
	 * @var string
	 *
	 * Time zone identifier.
	 */
	public string $tzid;

	/**
	 * @var array
	 *
	 * Data for the VTIMEZONE components.
	 */
	public array $components;

	/****************
	 * Public methods
	 ****************/

	/**
	 * Builds an iCalendar component for this time zone.
	 *
	 * @param \DateTimeInterface $range_start The earliest date for which to get
	 *    time zone data.
	 * @param \DateTimeInterface $range_end The latest date for which to get
	 *    time zone data.
	 * @return string A VTIMEZONE component for an iCalendar document.
	 */
	public function export(\DateTimeInterface $range_start, \DateTimeInterface $range_end): string
	{
		$filecontents = [
			'BEGIN:VTIMEZONE',
			'TZID:' . $this->tzid,
		];

		$included = [];

		foreach ($this->components as $component) {
			$dtstart = new \DateTimeImmutable($component['DTSTART'], new \DateTimeZone($this->tzid));

			// Stop if this component starts after the end of the requested range.
			if ($range_end < $dtstart) {
				break;
			}

			// Skip if this component ends before the start of the requested range.
			if (
				isset($component['RRULE'])
				&& str_contains($component['RRULE'], ';UNTIL=')
				&& $range_start > new \DateTimeImmutable(substr($component['RRULE'], strpos($component['RRULE'], ';UNTIL=') + 7), new \DateTimeZone($this->tzid))
			) {
				continue;
			}

			// Exclude any unnecessary one-time components from before the range start.
			if ($dtstart < $range_start) {
				foreach ($included as $key => $inc) {
					if (
						$inc['type'] === $component['type']
						&& !isset($inc['RRULE'])
						&& $dtstart > new \DateTimeImmutable($inc['DTSTART'], new \DateTimeZone($this->tzid))
					) {
						unset($included[$key]);
					}
				}
			}

			$included[] = $component;
		}

		// Build the file contents.
		foreach ($included as $component) {
			$filecontents[] = 'BEGIN:' . $component['type'];

			foreach ($component as $prop => $value) {
				if ($prop !== 'type') {
					$filecontents[] = $prop . ':' . $value;
				}
			}

			$filecontents[] = 'END:' . $component['type'];
		}

		$filecontents[] = 'END:VTIMEZONE';

		return implode("\r\n", $filecontents);
	}

	/***********************
	 * Public static methods
	 ***********************/

	/**
	 * Loads an instance of this class for the given time zone identifier.
	 *
	 * @param string $tzid A time zone identifier string.
	 * @throws \ValueError if $tzid is not a valid time zone identifier.
	 * @return array An instance of this class.
	 */
	public static function load(string $tzid): self
	{
		$tzid = self::CANONICAL_LINKS[$tzid] ?? $tzid;

		$class = __NAMESPACE__ . '\\VTimeZones\\' . strtr($tzid, ['/' => '\\', '+' => '', '-' => '_']);

		if (!class_exists($class)) {
			throw new \ValueError();
		}

		return new $class();
	}
}

?>