<?php
namespace common\ppunit;

/**
 * Welp. It runs the tests.
 * @package common\ppunit
 */
class TestRunner {
    const RUN_LEVEL_SINGLE_FILE = 0;
    private static $runLevel = self::RUN_LEVEL_SINGLE_FILE;
    private static $tests = array();

    public static function run(UnitTest $test) {
        if (!in_array($test, self::$tests))
            self::$tests[] = $test;

        if (self::$runLevel == self::RUN_LEVEL_SINGLE_FILE)
            self::displayTestResults();
    }

	public static function runGroup(GroupTests $gTests) {
		if (self::$runLevel < $gTests->getRunLevel())
			self::$runLevel = $gTests->getRunLevel();

		$gTests->includeTests();

		if (self::$runLevel <= $gTests->getRunLevel())
			self::displayTestResults();
	}

    private static function displayTestResults() {
        /** @noinspection PhpUnusedLocalVariableInspection */
        $testObjects = self::$tests;
        /** @noinspection PhpIncludeInspection */
        require str_replace("\\", "/", realpath(dirname(__FILE__))) . "/html/TestPageContent.php";
    }

    private function __construct() { }
}