<?php
namespace common\ppunit;

abstract class UnitGroup extends UnitTest {

	public static function initGroup(UnitGroup $unitGroup, $groupHierarchyLevel) {
		if (self::$groupHierarchyLevel < $groupHierarchyLevel)
			self::$groupHierarchyLevel = $groupHierarchyLevel;

		$unitGroup->initFiles();

		self::showResultPage();
	}

	public static function init($className) {

		self::$testClasses[] = $className;
	}

	protected abstract function initFiles();
}