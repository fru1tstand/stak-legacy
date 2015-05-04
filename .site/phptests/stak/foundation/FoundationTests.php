<?php
namespace stak\foundation;
require_once $_SERVER["DOCUMENT_ROOT"] . "/.site/php/stak/Autoload.php";
use common\ppunit\GroupTests;
use common\ppunit\TestRunner;

class FoundationTests extends GroupTests {
	public function includeTests() {
		new TimescopeTest();
	}

	public function getRunLevel() {
		return 1;
	}
}
TestRunner::runGroup(new FoundationTests());
