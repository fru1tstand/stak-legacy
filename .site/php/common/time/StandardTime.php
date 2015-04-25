<?php
namespace common\time;

/**
 * Unifies timezones by providing methods of converting back and forth between UTC+0 and whatever
 * timezone you choose to be in
 * @package common\time
 */
class StandardTime {
	// Constants
	const SECONDS_IN_DAY = 86400;

	// Non-instantiable
	private function __construct() { }

	// Conversion methods
	/**
	 * Converts the passed time from whatever UTC timezone it was in, to UTC+0
	 * @param int $time
	 * @param int $from
	 * @return int
	 */
	public static function toStandard($time, $from) {
		return self::convert($time, $from, 0);
	}

	/**
	 * Converts the passed time from UTC+0 to the requested timezone
	 * @param int $time
	 * @param int $to
	 * @return int
	 */
	public static function fromStandard($time, $to) {
		return self::convert($time, 0, $to);
	}

	/**
	 * @param int $time
	 * @param int $from UTC timezone that the passed time is in
	 * @param int $to UTC timezone that you want
	 * @return int
	 */
	public static function convert($time, $from, $to) {
		// From -8 to +2 should add 10 hours, ((+2 [to]) - (-8 [from])) = 10
		return $time + (60 * 60 * ($to - $from));
	}


	// Convenience methods
	/**
	 * Gets the current UTC+0 time.
	 * @return int
	 */
	public static function getTime() {
		if (!date_default_timezone_get() == "UTC")
			date_default_timezone_set("UTC");
		return time();
	}

	/**
	 * Returns the date portion of the given time
	 * @param int $time
	 * @return int
	 */
	public static function floorToDate($time) {
		return $time - ($time % self::SECONDS_IN_DAY);
	}
}