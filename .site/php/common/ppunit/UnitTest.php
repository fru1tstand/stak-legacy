<?php
namespace common\ppunit;
use ReflectionObject;
use Exception;

/**
 * Provides a very lightweight testing framework
 * @package common\ppunit
 */
abstract class UnitTest {
	const NO_GROUP = 0;

	protected static $groupHierarchyLevel = self::NO_GROUP;
	protected static $testClasses = array();

	/**
	 * Initializes the a test page with the given test class
	 * @param string $className
	 */
	public static function init($className) {
		if (self::$groupHierarchyLevel != self::NO_GROUP)
			return;

		self::$testClasses[] = $className;
		self::showResultPage();
	}

	protected static function showResultPage() {
		$testClasses = self::$testClasses;
		require str_replace("\\", "/", realpath(dirname(__FILE__))) . "/html/TestPageContent.php";
	}

	protected static function assertTrue($logic, $comment = null) {
		if (!$logic)
			throw new Exception("True assertion failed: $comment");

		if (!is_null($comment))
			echo "<div>True assertion succeeded: $comment</div>";
	}

	protected static function assertFalse($logic, $comment = null) {
		if ($logic)
			throw new Exception("False assertion failed: $comment");

		if (!is_null($comment))
			echo "<div>False assertion succeeded: $comment</div>";
	}

	protected static function assertEqual($obj1, $obj2, $comment = null) {
		if ($obj1 !== $obj2)
			throw new Exception("Equality assertion failed: $comment");

		if (!is_null($comment))
			echo "<div>Equality assertion succeeded: $comment</div>";
	}

	protected static function addMessage($message) {
		echo "<div>$message</div>";
	}
}