<?php
namespace stak\foundation;
require_once $_SERVER["DOCUMENT_ROOT"] . "/.site/php/stak/Autoload.php";
use common\ppunit\TestRunner;
use common\ppunit\UnitTest;

/**
 * Tests for the stak\foundation\tag abstract class using MockTag as a placeholder
 * @package stak\foundation
 */
class TagTest extends UnitTest {
	/**
	 * Tests #compareAlphabetical
	 * @Test
	 */
	public static function testCompareAlphabetical() {
		$aTag = new MockTag("a", "FFFFFF");
		$aaTag = new MockTag("aa", "FFFFFF");
		$bTag = new MockTag("b", "FFFFFF");
		$zTag = new MockTag("z", "FFFFFF");
		$numTag = new MockTag("1", "FFFFFF");

		$longTag = new MockTag("This is a tag that has pl##@@##^%tly", "FFFFFF");
		$longTagAfter = new MockTag("Very good tag", "FFFFFF");

		self::assertTrue($aTag->compareAlphabetical($bTag) == -1, "A comes before B");
		self::assertTrue($bTag->compareAlphabetical($aTag) == 1, "B comes after A");
		self::assertTrue($aTag->compareAlphabetical($zTag) == -1, "A comes before Z");
		self::assertTrue($numTag->compareAlphabetical($aTag) == -1, "Numbers come before letters");
		self::assertTrue($aTag->compareAlphabetical($aaTag) == -1, "Shorter strings of identical prefix come first");
		self::assertTrue($longTag->compareAlphabetical($longTagAfter) == -1, "Letters take precedence over length");
	}
}
TestRunner::run(new TagTest());
