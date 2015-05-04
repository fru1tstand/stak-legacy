<?php
namespace stak\foundation;
require_once $_SERVER["DOCUMENT_ROOT"] . "/.site/php/stak/Autoload.php";
use common\ppunit\TestRunner;
use common\ppunit\UnitTest;
use common\time\StandardTime;

/**
 * Tests for the stak\foundation\Task class
 * @package stak\foundation
 */
class TaskTest extends UnitTest {

	/**
	 * Tests #compareChronological
	 * @Test
	 */
	public static function testChronological() {
		$noDueDateTaskA = new MockTask("a");
		$noDueDateTaskB = new MockTask("b");
		$time = StandardTime::getTime() + 300;
		$taskA = new MockTask("a task", null, $time);
		$taskB = new MockTask("b task", null, $time);
		$laterTask = new MockTask("Something", null, StandardTime::getTime() + 999999);

		self::assertTrue($noDueDateTaskA->compareChronological($noDueDateTaskB) < 0, "Same due dates (null), sorting alphabetical, A comes before B");
		self::assertTrue($noDueDateTaskB->compareChronological($noDueDateTaskA) > 0, "Same due dates (null), sorting alphabetical, B comes before A");
		self::assertTrue($noDueDateTaskA->compareChronological($taskA) < 0, "Null comes before set due date");
		self::assertTrue($taskA->compareChronological($noDueDateTaskA) > 0, "Set due date comes after Null");
		self::assertTrue($taskA->compareChronological($taskB) < 0, "Same due dates (set), A comes before B");
		self::assertTrue($taskB->compareChronological($taskA) > 0, "Same due dates (set), B comes after A");
		self::assertTrue($laterTask->compareChronological($taskA) > 0, "Later due date should come after");
	}
}
TestRunner::run(new TaskTest());
