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
	 * Tests a timescope with a range of [now, 2) days
	 * @Test
	 */
	public static function testIsWithinScopeWithNow() {
		self::addMessage("Testing with timescope range: [now, 2) (Today (now) and tomorrow)");
		$timescope = new MockTimescope("TestTimescope", 0, false, 2, false, false, false, true);

		// Bounds
			// Inside
		$now = StandardTime::getTime(); // Lower bound edge
		$secondBeforeMidnightTomorrow = StandardTime::floorToDate(StandardTime::getTime())
				+ StandardTime::SECONDS_IN_DAY * 2
				- 1; // upper bound edge
			// Outside
		$aSecondAgo = StandardTime::getTime() - 1; // lower bound edge
		$midnightTomorrow = StandardTime::floorToDate(StandardTime::getTime())
				+ StandardTime::SECONDS_IN_DAY * 2; // upper bound edge

		// Random other tests
			// Pass
		$tomorrow = StandardTime::floorToDate(StandardTime::getTime())
				+ StandardTime::SECONDS_IN_DAY;
		$noonTomorrow = StandardTime::floorToDate(StandardTime::getTime())
				+ StandardTime::SECONDS_IN_DAY * 1.5;
			// Fail
		$unixTime1 = 1;
		$threeDaysFromNow = StandardTime::getTime() + StandardTime::SECONDS_IN_DAY * 3;
		$fourDaysFromNow = StandardTime::getTime() + StandardTime::SECONDS_IN_DAY * 4;

		self::assertTrue($timescope->isWithinRange($now), "Now (lower bound edge)");
		self::assertTrue($timescope->isWithinRange($secondBeforeMidnightTomorrow), "Second before midnight tomorrow (upper bound edge)");
		self::assertFalse($timescope->isWithinRange($aSecondAgo), "A second ago (lower bound edge)");
		self::assertFalse($timescope->isWithinRange($midnightTomorrow), "Midnight tomorrow (upper bound edge)");

		self::assertTrue($timescope->isWithinRange($tomorrow), "Tomorrow");
		self::assertTrue($timescope->isWithinRange($noonTomorrow), "Noon Tomorrow");
		self::assertFalse($timescope->isWithinRange($unixTime1), "Unix time 1");
		self::assertFalse($timescope->isWithinRange($threeDaysFromNow), "3 Days from now");
		self::assertFalse($timescope->isWithinRange($fourDaysFromNow), "4 Days from now");
	}

	/**
	 * Tests a timescope with a range of [0, 2) days
	 * @Test
	 */
	public static function testIsWithinScopeBasic() {
		self::addMessage("Testing with timescope range: [0, 2) (Today and Tomorrow)");
		$timescope = new MockTimescope("TestTimescope", 0, false, 2, false, false, false, false);

		// Bounds
			// Inside
		$beginningOfToday = StandardTime::floorToDate(StandardTime::getTime()); // Edge of lower bound
		$secondBeforeMidnightTomorrow = StandardTime::floorToDate(StandardTime::getTime())
				+ StandardTime::SECONDS_IN_DAY * 2
				- 1; // Edge of upper bound
			// Outside
		$secondBeforeMidnightYesterday = StandardTime::floorToDate(StandardTime::getTime())
				- 1; // Edge of lower bound
		$midnightTomorrow = StandardTime::floorToDate(StandardTime::getTime())
				+ StandardTime::SECONDS_IN_DAY * 2; // Edge of upper bound

		// Random other tests
			// Pass
		$now = StandardTime::getTime();
		$twentyFourHoursFromNow = StandardTime::getTime() + StandardTime::SECONDS_IN_DAY;
			// Fail
		$twentyFourHoursAgo = StandardTime::getTime() - StandardTime::SECONDS_IN_DAY;

		self::assertTrue($timescope->isWithinRange($beginningOfToday), "Beginning of today (lower bound edge)");
		self::assertTrue($timescope->isWithinRange($secondBeforeMidnightTomorrow), "A second before midnight tomorrow (upper bound edge)");
		self::assertFalse($timescope->isWithinRange($secondBeforeMidnightYesterday), "A second before midnight yesterday (lower bound edge)");
		self::assertFalse($timescope->isWithinRange($midnightTomorrow), "Midnight tomorrow [start of 3 days from now] (upper bound edge)");

		self::assertTrue($timescope->isWithinRange($now), "Now");
		self::assertTrue($timescope->isWithinRange($twentyFourHoursFromNow), "24 Hours from now");
		self::assertFalse($timescope->isWithinRange($twentyFourHoursAgo), "24 Hours ago");
	}

	/**
	 * Tests a timescope with range [Now, 1)
	 * @Test
	 */
	public static function testIsWithinScopeToday() {
		self::addMessage("Testing range [now, 1) (Only today)");
		$todayTs = new MockTimescope("Today", 0, false, 1, false, false, false, true);

		// Bounds
			// Inside
		$now = StandardTime::getTime(); // Edge of lower bound
		$aSecondBeforeMidnight = StandardTime::floorToDate(StandardTime::getTime())
				+ StandardTime::SECONDS_IN_DAY - 1; // Edge of upper bound
			// Outside
		$aSecondAgo = StandardTime::getTime() - 1; // Edge of lower bound
		$midnight = StandardTime::floorToDate(StandardTime::getTime())
				+ StandardTime::SECONDS_IN_DAY; // edge of upper bound

		// Random other tests
			// Fail
		$someTimeTomorrow = StandardTime::floorToDate(StandardTime::getTime())
				+ StandardTime::SECONDS_IN_DAY
				+ 40000;
		$zero = 0;
		$weekFromNow = StandardTime::getTime() + StandardTime::SECONDS_IN_DAY * 7;

		self::assertTrue($todayTs->isWithinRange($now), "Now (lower bound edge)");
		self::assertTrue($todayTs->isWithinRange($aSecondBeforeMidnight), "A second before midnight today (upper bound edge)");
		self::assertFalse($todayTs->isWithinRange($aSecondAgo), "A second ago (lower bound edge)");
		self::assertFalse($todayTs->isWithinRange($midnight), "Midnight [start of tomorrow] (upper bound edge)");

		self::assertFalse($todayTs->isWithinRange($someTimeTomorrow), "Some time tomorrow");
		self::assertFalse($todayTs->isWithinRange($zero), "0 Unix time");
		self::assertFalse($todayTs->isWithinRange($weekFromNow), "A week from now");
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

		self::assertTrue($aTs->compareAlphabetical($zTs) < 0, "A comes before Z");
		self::assertTrue($zTs->compareAlphabetical($aTs) > 0, "Z comes after A");
		self::assertTrue($numTs->compareAlphabetical($aTs) < 0, "Numbers come before letters");
		self::assertTrue($aTs->compareAlphabetical($aaTs)  < 0, "Shorter strings of identical beginning come first");
		self::assertTrue($longTs->compareAlphabetical($aTs) > 0, "Letters take precedence over length");
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
		$tsNowToThisWeek = new MockTimescope("", 0, false, 7, false, false, false, true);

		// Basic use case
		$today = new MockTimescope("Today", 0, false, 1, false, false, false, true);
		$thisWeek = new MockTimescope("This Week", 0, false, 7, false, false, true, true);
		$overdue = new MockTimescope("Overdue", 0, true, 0, false, true, true, true);
		$everythingElse =
				new MockTimescope("Everything Else", 7, false, 0, true, true, true, false);

		self::addMessage("Basic Constructs");
		self::assertTrue($ts500to1000a->compareChronological($ts500to1000b) < 0, "Same range, sorts alphabetical, A comes before B");
		self::assertTrue($ts500to1000b->compareChronological($ts500to1000a) > 0, "Same range, sorta alphabetical, B comes after A");
		self::assertTrue($ts500to1000a->compareChronological($ts500to1001) < 0, "Same lower bound, shorter range comes before longer range");
		self::assertTrue($ts500to1001->compareChronological($ts500to1000a) > 0, "Same lower bound, longer range comes after shorter range");
		self::addMessage("Torture Tests");
		self::assertTrue($tsNowToTomorrow->compareChronological($tsTodayToTomorrow) > 0, "Today starts before now");
		self::assertTrue($tsNowToTomorrow->compareChronological($tsNowToFuture) < 0, "Same lower bound (now), finite length is less than infinite");
		self::assertTrue($tsNowToFuture->compareChronological($tsTodayToTomorrow) > 0, "Lower bound takes precedence over length");
		self::assertTrue($tsNowToTomorrow->compareChronological($tsNowToThisWeek) < 0, "Today (now) comes before this week (now)");
		self::addMessage("Basic Use Case");
		self::assertTrue($overdue->compareChronological($today) < 0, "Overdue is listed first (Compared today)");
		self::assertTrue($overdue->compareChronological($thisWeek) < 0, "Overdue is listed first (Compared this week)");
		self::assertTrue($overdue->compareChronological($everythingElse) < 0, "Overdue is listed first (Compared everything else)");
		self::assertTrue($today->compareChronological($thisWeek) < 0, "Today is listed next (Compared this week)");
		self::assertTrue($today->compareChronological($everythingElse) < 0, "Today is listed next (Compared everything else)");
		self::assertTrue($thisWeek->compareChronological($everythingElse) < 0, "This week is listed next (Compared everything else)");
	}
}
TestRunner::run(new TimescopeTest());
