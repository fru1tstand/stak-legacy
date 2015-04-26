<?php
namespace stak\base;
require_once $_SERVER["DOCUMENT_ROOT"] . "/.site/php/stak/Autoload.php";
use common\ppunit\UnitTest;
use common\time\StandardTime;

class TimescopeTest extends UnitTest {
	/**
	 * @Test
	 */
	public static function testIsWithinScope() {
		// timescope from now until 2 days from now (inclusive)
		$timescope = new MockTimescope("TestTimescope", 0, false, 2, false, false, false, true);

		$validTime = time();
		$validTime2 = time() + StandardTime::SECONDS_IN_DAY;
		$validTime3 = time() + 100000;

		$invalidLowerTime = time() - 1;
		$invalidLowerTime2 = 1;

		$invalidUpperTime = time() + StandardTime::SECONDS_IN_DAY * 3;
		$invalidUpperTime2 = time() + StandardTime::SECONDS_IN_DAY * 4;

		self::assertTrue($timescope->isWithinScope($validTime), "Today");
		self::assertTrue($timescope->isWithinScope($validTime2), "Tomorrow");
		self::assertTrue($timescope->isWithinScope($validTime3), "+ 100,000 Seconds");

		self::assertFalse($timescope->isWithinScope($invalidLowerTime), "1 second ago");
		self::assertFalse($timescope->isWithinScope($invalidLowerTime2), "Second 1 (unix time 1)");

		self::assertFalse($timescope->isWithinScope($invalidUpperTime), "3 days from now");
		self::assertFalse($timescope->isWithinScope($invalidUpperTime2), "4 days from now");
	}
}
UnitTest::init(TimescopeTest::class);
