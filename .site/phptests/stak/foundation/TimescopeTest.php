<?php
namespace stak\foundation;
require_once $_SERVER["DOCUMENT_ROOT"] . "/.site/php/stak/Autoload.php";
use common\ppunit\TestRunner;
use common\ppunit\UnitTest;
use common\time\StandardTime;

/**
 * Tests for the Timescope abstract class
 * @package stak\foundation
 */
class TimescopeTest extends UnitTest {
	/**
	 * Tests a timescope with a range of [now, +2] days
	 * @Test
	 */
	public static function testIsWithinScopeWithNow() {
		self::addMessage("Testing with timescope range: [now, +2]");
		$timescope = new MockTimescope("TestTimescope", 0, false, 2, false, false, false, true);

		// Pass
		$now = StandardTime::getTime();
		$nowPlusADay = StandardTime::getTime() + StandardTime::SECONDS_IN_DAY;
		$nowPlus10000Seconds = StandardTime::getTime() + 100000;

		// Fail
		$aSecondAgo = StandardTime::getTime() - 1;
		$unixTime1 = 1;

		$threeDaysFromNow = StandardTime::getTime() + StandardTime::SECONDS_IN_DAY * 3;
		$fourDaysFromNow = StandardTime::getTime() + StandardTime::SECONDS_IN_DAY * 4;

		self::assertTrue($timescope->isWithinRange($now), "Now");
		self::assertTrue($timescope->isWithinRange($nowPlusADay), "Tomorrow");
		self::assertTrue($timescope->isWithinRange($nowPlus10000Seconds), "+ 100,000 Seconds");

		self::assertFalse($timescope->isWithinRange($aSecondAgo), "1 second ago");
		self::assertFalse($timescope->isWithinRange($unixTime1), "Second 1 (unix time 1)");

		self::assertFalse($timescope->isWithinRange($threeDaysFromNow), "3 days from now");
		self::assertFalse($timescope->isWithinRange($fourDaysFromNow), "4 days from now");
	}

	/**
	 * Tests a timescope with a range of [0, +2] days
	 * @Test
	 */
	public static function testIsWithinScopeBasic() {
		self::addMessage("Testing with timescope range: [0, 2]");
		$timescope = new MockTimescope("TestTimescope", 0, false, 2, false, false, false, false);

		// Pass
		$now = StandardTime::getTime();
		$beginningOfToday = StandardTime::floorToDate(StandardTime::getTime()); // Edge of lower bound
		$nearMidnight2DaysFromNow =
				StandardTime::floorToDate(StandardTime::getTime() + StandardTime::SECONDS_IN_DAY * 2)
				+ StandardTime::SECONDS_IN_DAY - 1; // Edge of upper bound
		$twentyFourHoursFromNow = StandardTime::getTime() + StandardTime::SECONDS_IN_DAY;

		// Fail
		$nearMidnightYesterday = StandardTime::floorToDate(StandardTime::getTime() - StandardTime::SECONDS_IN_DAY)
								 + StandardTime::SECONDS_IN_DAY - 1; // Edge of lower bound
		$twentyFourHoursAgo = StandardTime::getTime() - StandardTime::SECONDS_IN_DAY;
		$startOf3DaysFromNow = StandardTime::floorToDate(StandardTime::getTime() + StandardTime::SECONDS_IN_DAY *
																  3); // Edge of upper bound

		self::assertTrue($timescope->isWithinRange($now), "Now");
		self::assertTrue($timescope->isWithinRange($beginningOfToday), "Beginning of today");
		self::assertTrue($timescope->isWithinRange($nearMidnight2DaysFromNow),
				"Near midnight 2 days from now");
		self::assertTrue($timescope->isWithinRange($twentyFourHoursFromNow), "24 hours from now");

		self::assertFalse($timescope->isWithinRange($nearMidnightYesterday),
				"Near midnight yesterday");
		self::assertFalse($timescope->isWithinRange($twentyFourHoursAgo), "24 hours ago");
		self::assertFalse($timescope->isWithinRange($startOf3DaysFromNow),
				"Start of 3 days from now");
	}

	/**
	 * Tests #compareAlphabetical
	 * @Test
	 */
	public static function testCompareAlphabetical() {
		$aTs = new MockTimescope("a");
		$aaTs = new MockTimescope("aa");
		$zTs = new MockTimescope("z");
		$numTs = new MockTimescope("4");

		$longTs = new MockTimescope("iojfewjidvsijodsvjiogdajigao4a gA 643w$%$#@^#@%$7546srte");

		self::assertTrue($aTs->compareAlphabetical($zTs) == -1, "A comes before Z");
		self::assertTrue($zTs->compareAlphabetical($aTs) == 1, "Z comes after A");
		self::assertTrue($numTs->compareAlphabetical($aTs) == -1, "Numbers come before letters");
		self::assertTrue($aTs->compareAlphabetical($aaTs) == -1, "Shorter strings of identical beginning come first");
		self::assertTrue($longTs->compareAlphabetical($aTs) == 1, "Letters take precedence over length");
	}

	/**
	 * Tests #compareChronological
	 * @Test
	 */
	public static function testCompareChronological() {
		// Basic constructs
		$ts500to1000a = new MockTimescope("a", 500, false, 1000, false);
		$ts500to1000b = new MockTimescope("b", 500, false, 1000, false);
		$ts500to1001 = new MockTimescope("", 500, false, 1001, false);

		// Torture test
		$tsNowToTomorrow = new MockTimescope("", 0, false, 1, false, false, false, true);
		$tsTodayToTomorrow = new MockTimescope("", 0, false, 1, false);
		$tsNowToFuture = new MockTimescope("", 0, false, 0, true, false, false, true);

		self::assertTrue($ts500to1000a->compareChronological($ts500to1000b) == -1, "Same range, sorts alphabetical, A comes before B");
		self::assertTrue($ts500to1000b->compareChronological($ts500to1000a) == 1, "Same range, sorta alphabetical, B comes after A");
		self::assertTrue($ts500to1000a->compareChronological($ts500to1001) == -1, "Same lower bound, shorter range comes before longer range");
		self::assertTrue($ts500to1001->compareChronological($ts500to1000a) == 1, "Same lower bound, longer range comes after shorter range");
		self::assertTrue($tsNowToTomorrow->compareChronological($tsTodayToTomorrow) == 1, "Today starts before now");
		self::assertTrue($tsNowToTomorrow->compareChronological($tsNowToFuture) == -1, "Same lower bound (now), finite length is less than infinite");
		self::assertTrue($tsNowToFuture->compareChronological($tsTodayToTomorrow) == 1, "Lower bound takes precedence over length");
	}
}
TestRunner::run(new TimescopeTest());
