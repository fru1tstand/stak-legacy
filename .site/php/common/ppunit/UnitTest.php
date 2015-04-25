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
	 * @param UnitTest $unitTest
	 */
	public static function init(UnitTest $unitTest) {
		// Get all tests
		$tests = array();
		$reflectionObject = new ReflectionObject($unitTest);
		foreach ($reflectionObject->getMethods() as $method) {
			if (strpos($method->getDocComment(), "@test"))
				$tests[] = $method;
		}

		// Spits out test results
		$ppunitTestPage = true;
		require str_replace("\\", "/", realpath(dirname(__FILE__))) . "/html/TestPageContent.php";
	}

	protected static function assertTrue($logic, $comment = null) {
		if (!$logic)
			throw new Exception("Assertion true failed");

		if (!is_null($comment))
			echo "<div>True assertion passed: ", $comment, "</div>";
	}

	protected static function assertFalse($logic, $comment = null) {
		if ($logic)
			throw new Exception("Assertion false failed");

		if (!is_null($comment))
			echo "<div>False assertion passed: ", $comment, "</div>";
	}

	protected static function assertEqual($obj1, $obj2, $comment = null) {
		if ($obj1 !== $obj2)
			throw new Exception("Assertion equal failed");

		if (!is_null($comment))
			echo "<div>Equality assertion passed: ", $comment, "</div>";
	}
}