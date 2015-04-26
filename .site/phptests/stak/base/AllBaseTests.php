<?php
namespace stak\base;
require_once $_SERVER["DOCUMENT_ROOT"] . "/.site/php/stak/Autoload.php";
use common\ppunit\UnitGroup;

class AllBaseTests extends UnitGroup {
	protected function initFiles() {
		self::init(TimescopeTest::class);
		self::init(TaskTest::class);
	}
}
UnitGroup::initGroup(new AllBaseTests(), 1);
