<?php
namespace stak\foundation;

use common\base\Response;

/**
 * A mock implementation of Timescope
 * @package stak\foundation
 */
class MockTimescope extends Timescope {

	public function __construct($name,
			$lowerBound = 0,
			$lowerBoundIsInfinite = false,
			$upperBound = 0,
			$upperBoundIsInfinite = false,
			$hideIfEmpty = false,
			$hideCompleted = false,
			$isBoundNow = false) {
		$this->name = $name;
		$this->lowerBound = $lowerBound;
		$this->lowerBoundIsInfinite = $lowerBoundIsInfinite;
		$this->upperBound = $upperBound;
		$this->upperBoundIsInfinite = $upperBoundIsInfinite;
		$this->hideIfEmpty = $hideIfEmpty;
		$this->hideCompleted = $hideCompleted;
		$this->isBoundNow = $isBoundNow;
	}

	protected function updateName($name, Response &$response = null) {
		return true;
	}

	protected function updateLowerBound($day, Response &$response = null) {
		return true;
	}

	protected function updateUpperBound($day, Response &$response = null) {
		return true;
	}

	protected function updateHideIfEmpty($hideIfEmpty, Response &$response = null) {
		return true;
	}

	protected function updateHideCompleted($hideComplete, Response &$response = null) {
		return true;
	}

	protected function updateLowerBoundIsInfinite($isInfinite, Response &$response = null) {
		return true;
	}

	protected function updateUpperBoundIsInfinite($isInfinite, Response &$response = null) {
		return true;
	}

	protected function updateIsBoundNow($isBoundNow, Response &$response = null) {
		return true;
	}

}