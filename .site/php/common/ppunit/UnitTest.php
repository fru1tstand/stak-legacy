<?php
namespace common\ppunit;
use ReflectionObject;
use Exception;

/**
 * Provides a very lightweight testing framework
 * @package common\ppunit
 */
abstract class UnitTest {

	/**
	 * Initializes the a test page with the given test class
	 * @param string $className
	 */
	public static function init($className) {
		// Spits out test results
		$ppunitTestPage = true;
		require str_replace("\\", "/", realpath(dirname(__FILE__))) . "/html/TestPageContent.php";
	}

	protected static function assertTrue($logic, $comment = null) {
		if (!$logic)
			throw new Exception("True assertion failed: " . $comment);

		if (!is_null($comment))
			echo "<div>True assertion succeeded: ", $comment, "</div>";
	}

	protected static function assertFalse($logic, $comment = null) {
		if ($logic)
			throw new Exception("False assertion failed: " . $comment);

		if (!is_null($comment))
			echo "<div>False assertion succeeded: ", $comment, "</div>";
	}

	protected static function assertEqual($obj1, $obj2, $comment = null) {
		if ($obj1 !== $obj2)
			throw new Exception("Equality assertion failed: " . $comment);

		if (!is_null($comment))
			echo "<div>Equality assertion succeeded: ", $comment, "</div>";
	}
}