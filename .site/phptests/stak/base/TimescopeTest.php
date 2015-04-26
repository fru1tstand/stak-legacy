<?php
namespace stak\base;
require_once $_SERVER["DOCUMENT_ROOT"] . "/.site/php/stak/Autoload.php";
use common\ppunit\UnitTest;
use common\time\StandardTime;

class TimescopeTest extends UnitTest {
	/**
	 * Tests a timescope with a range of [now, +2] days
	 * @Test
	 */
	public static function testIsWithinScopeWithNow() {
		self::addMessage("Testing with timescope range: [now, +2]");
		$timescope = new MockTimescope("TestTimescope", 0, false, 2, false, false, false, true);

		// Pass
		$now = time();
		$nowPlusADay = time() + StandardTime::SECONDS_IN_DAY;
		$nowPlus10000Seconds = time() + 100000;

		// Fail
		$aSecondAgo = time() - 1;
		$unixTime1 = 1;

		$threeDaysFromNow = time() + StandardTime::SECONDS_IN_DAY * 3;
		$fourDaysFromNow = time() + StandardTime::SECONDS_IN_DAY * 4;

		self::assertTrue($timescope->isWithinScope($now), "Now");
		self::assertTrue($timescope->isWithinScope($nowPlusADay), "Tomorrow");
		self::assertTrue($timescope->isWithinScope($nowPlus10000Seconds), "+ 100,000 Seconds");

		self::assertFalse($timescope->isWithinScope($aSecondAgo), "1 second ago");
		self::assertFalse($timescope->isWithinScope($unixTime1), "Second 1 (unix time 1)");

		self::assertFalse($timescope->isWithinScope($threeDaysFromNow), "3 days from now");
		self::assertFalse($timescope->isWithinScope($fourDaysFromNow), "4 days from now");
	}

	/**
	 * Tests a timescope with a range of [0, +2] days
	 * @Test
	 */
	public static function testIsWithinScopeBasic() {
		self::addMessage("Testing with timescope range: [0, 2]");
		$timescope = new MockTimescope("TestTimescope", 0, false, 2, false, false, false, false);

		// Pass
		$now = time();
		$beginningOfToday = StandardTime::floorToDate(time()); // Edge of lower bound
		$nearMidnight2DaysFromNow =
				StandardTime::floorToDate(time() + StandardTime::SECONDS_IN_DAY * 2)
				+ StandardTime::SECONDS_IN_DAY - 1; // Edge of upper bound
		$twentyFourHoursFromNow = time() + StandardTime::SECONDS_IN_DAY;

		// Fail
		$nearMidnightYesterday = StandardTime::floorToDate(time() - StandardTime::SECONDS_IN_DAY)
								 + StandardTime::SECONDS_IN_DAY - 1; // Edge of lower bound
		$twentyFourHoursAgo = time() - StandardTime::SECONDS_IN_DAY;
		$startOf3DaysFromNow = StandardTime::floorToDate(time() + StandardTime::SECONDS_IN_DAY *
																  3); // Edge of upper bound

		self::assertTrue($timescope->isWithinScope($now), "Now");
		self::assertTrue($timescope->isWithinScope($beginningOfToday), "Beginning of today");
		self::assertTrue($timescope->isWithinScope($nearMidnight2DaysFromNow),
				"Near midnight 2 days from now");
		self::assertTrue($timescope->isWithinScope($twentyFourHoursFromNow), "24 hours from now");

		self::assertFalse($timescope->isWithinScope($nearMidnightYesterday),
				"Near midnight yesterday");
		self::assertFalse($timescope->isWithinScope($twentyFourHoursAgo), "24 hours ago");
		self::assertFalse($timescope->isWithinScope($startOf3DaysFromNow),
				"Start of 3 days from now");
	}
}
UnitTest::init(TimescopeTest::class);