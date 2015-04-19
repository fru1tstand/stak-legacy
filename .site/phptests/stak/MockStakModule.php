<?php
namespace stak;
require_once $_SERVER["DOCUMENT_ROOT"] . "/.site/php/stak/Autoload.php";
use common\Milk\inject\AbstractModule;

class MockStakModule extends AbstractModule {
	public function configure() {
		self::bind(StakSettings::class)->asSingletonTo(MockStakSettings::class);
		self::bind(AbstractTag::class)->to(MockTag::class);
		self::bind(AbstractTask::class)->to(MockTask::class);
	}

}