<?php
namespace stak;
require_once $_SERVER["DOCUMENT_ROOT"] . "/.site/php/stak/Autoload.php";
use common\milk\inject\AbstractModule;
use stak\foundation\Tag;
use stak\foundation\MockTag;
use stak\foundation\Task;
use stak\foundation\MockTask;

class MockStakModule extends AbstractModule {
	public function configure() {
		self::bind(StakSettings::class)->asSingletonTo(MockStakSettings::class);
		self::bind(Tag::class)->to(MockTag::class);
		self::bind(Task::class)->to(MockTask::class);
		self::bind(UserData::class)->asStaticTo(MockUserData::class);
	}
}
