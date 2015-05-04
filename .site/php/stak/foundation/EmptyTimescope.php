<?php
namespace stak\foundation;
require_once $_SERVER["DOCUMENT_ROOT"] . "/.site/php/stak/Autoload.php";
use common\base\Response;

/**
 * A timescope that has the range of "ull
 * @package stak\foundation
 */
class EmptyTimescope extends Timescope {

	/**
	 * A basic constructor for EmptyTimescope. The parameters are most likely going to be set from
	 * UserData
	 * @param $name
	 * @param $hideIfEmpty
	 */
	public function __construct($name, $hideIfEmpty) {
		$this->name = $name;
		$this->hideIfEmpty = !!$hideIfEmpty;

		$this->lowerBound = 0;
		$this->lowerBoundIsInfinite = false;
		$this->upperBound = 0;
		$this->upperBoundIsInfinite = false;
		$this->hideCompleted = true;
		$this->isBoundNow = false;
	}


	// Other
	/**
	 * Override the base Timescope method of checking the range. This special case only returns
	 * true when the given time is null.
	 * @param $time
	 * @return bool
	 */
	public function isWithinRange($time) {
		return is_null($time);
	}


	// All update methods should fail
	protected function updateName($name, Response $response = null) {
		return false;
	}

	protected function updateLowerBound($day, Response $response = null) {
		return false;
	}

	protected function updateUpperBound($day, Response $response = null) {
		return false;
	}

	protected function updateHideIfEmpty($hideIfEmpty, Response $response = null) {
		return false;
	}

	protected function updateHideCompleted($hideComplete, Response $response = null) {
		return false;
	}

	protected function updateLowerBoundIsInfinite($isInfinite, Response $response = null) {
		return false;
	}

	protected function updateUpperBoundIsInfinite($isInfinite, Response $response = null) {
		return false;
	}

	protected function updateIsBoundNow($isBoundNow, Response $response = null) {
		return false;
	}

}