<?php
namespace stak;
require_once $_SERVER["DOCUMENT_ROOT"] . "/.site/php/stak/Autoload.php";
use common\Milk\inject\AbstractModule;
use stak\base\Tag;
use stak\base\MockTag;
use stak\base\Task;
use stak\base\MockTask;
use stak\base\UserData;
use stak\base\MockUserData;

class MockStakModule extends AbstractModule {
	public function configure() {
		self::bind(StakSettings::class)->asSingletonTo(MockStakSettings::class);
		self::bind(Tag::class)->to(MockTag::class);
		self::bind(Task::class)->to(MockTask::class);
		self::bind(UserData::class)->asStaticTo(MockUserData::class);
	}
}
