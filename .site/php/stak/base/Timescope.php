<?php
namespace stak\base;
require_once $_SERVER["DOCUMENT_ROOT"] . "/.site/php/stak/Autoload.php";
use common\base\Response;

/**
 * Defines a time categorical container for Tasks
 * @package stak\base
 */
abstract class Timescope {
	// Constants
	const NAME_MAX_LENGTH = 128;

	/** @var string */	protected $name;
	/** @var int */		protected $lowerBound;
	/** @var bool */	protected $lowerBoundIsInfinite;
	/** @var int */		protected $upperBound;
	/** @var bool */	protected $upperBoundIsInfinite;
	/** @var bool */	protected $hideIfEmpty;
	/** @var bool */	protected $hideCompleted;
	/** @var bool */	protected $isBoundNow;

	// Getters
	/**
	 * Gets the name of the timescope
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Gets the lower bound of the timescope in days
	 * @return int
	 */
	public function getLowerBound() {
		return $this->lowerBound;
	}

	/**
	 * Gets the upper bound of the timescope in days
	 * @return int
	 */
	public function getUpperBound() {
		return $this->upperBound;
	}

	/**
	 * Returns if the timescope should be hidden when empty
	 * @return boolean
	 */
	public function hideIfEmpty() {
		return $this->hideIfEmpty;
	}

	/**
	 * Returns if tasks within this timescope should be hidden when complete
	 * @return boolean
	 */
	public function hideCompleted() {
		return $this->hideCompleted;
	}

	/**
	 * Returns if one of the bounds is the current time (now). The bound that is "now" is
	 * automatically determined by which bound is set to 0. If both or neither bound is 0, this
	 * setting does nothing.
	 * @return bool
	 */
	public function isBoundNow() {
		return $this->isBoundNow;
	}

	/**
	 * Returns if there is no upper bound (infinite upper bound)
	 * @return bool
	 */
	public function isUpperBoundInfinite() {
		return $this->upperBoundIsInfinite;
	}

	/**
	 * Returns if there is no lower bound (infinite lower bound)
	 * @return bool
	 */
	public function isLowerBoundInfinite() {
		return $this->lowerBoundIsInfinite;
	}


	// Setters
	/**
	 * Sets the name of the timescope.
	 * @param          $name
	 * @param Response $response
	 * @return bool
	 */
	public function setName($name, Response &$response = null) {
		Response::getInstance($response, "Timescope::setName");

		if (!self::isValidName($name, $response))
			return false;

		if (!$this->updateName($name, $response))
			return false;

		$this->name = $name;
		return true;
	}

	/**
	 * Sets the upper bound of the timescope in days. To disable, set upperBoundIsInfinite to
	 * true. To bound it to "now", set isBoundNow to true.
	 * @param          $days
	 * @param Response $response
	 * @return bool
	 */
	public function setUpperBound($days, Response &$response = null) {
		Response::getInstance($response, "Timescope::setUpperBound");

		if (!self::isValidBound($days, $response))
			return false;

		if (!$this->updateUpperBound($days, $response))
			return false;

		$this->upperBound = $days;
		return true;
	}

	/**
	 * Sets the lower bound of the timescope in days. To disable, set lowerBoundIsInfinite to
	 * true. To bound it to "now", set isBoundNow to true.
	 * @param          $days
	 * @param Response $response
	 * @return bool
	 */
	public function setLowerBound($days, Response &$response = null) {
		Response::getInstance($response, "Timescope::setLowerBound");

		if (!self::isValidBound($days, $response))
			return false;

		if (!$this->updateLowerBound($days, $response))
			return false;

		$this->lowerBound = $days;
		return true;
	}

	/**
	 * Set to true to disable upper bound (the upper bound is infinite)
	 * @param          $isInfinite
	 * @param Response $response
	 * @return bool
	 */
	public function setUpperBoundIsInfinite($isInfinite, Response &$response = null) {
		Response::getInstance($response, "Timescope::setUpperBoundIsInfinite");

		// Boolean-ize it
		$isInfinite = !!$isInfinite;

		if (!$this->updateUpperBoundIsInfinite($isInfinite, $response))
			return false;

		$this->upperBoundIsInfinite = $isInfinite;
		return true;
	}

	/**
	 * Set to true to disable lower bound (the lower bound is infinite)
	 * @param          $isInfinite
	 * @param Response $response
	 * @return bool
	 */
	public function setLowerBoundIsInfinite($isInfinite, Response &$response = null) {
		Response::getInstance($response, "Timescope::setLowerBoundIsInfinite");

		$isInfinite = !!$isInfinite;

		if (!$this->updateLowerBoundIsInfinite($isInfinite, $response))
			return false;

		$this->lowerBoundIsInfinite = $isInfinite;
		return true;
	}

	/**
	 * Set to true to hide the timescope if no Tasks are available to show within it
	 * @param          $hideIfEmpty
	 * @param Response $response
	 * @return bool
	 */
	public function setHideIfEmpty($hideIfEmpty, Response &$response = null) {
		Response::getInstance($response, "Timescope::setHideIfEmpty");

		$hideIfEmpty = !!$hideIfEmpty;

		if (!$this->updateHideIfEmpty($hideIfEmpty, $response))
			return false;

		$this->hideIfEmpty = $hideIfEmpty;
		return true;
	}

	/**
	 * Set to true to hide Tasks that are complete within this timescope
	 * @param          $hideCompleted
	 * @param Response $response
	 * @return bool
	 */
	public function setHideCompleted($hideCompleted, Response &$response = null) {
		Response::getInstance($response, "Timescope::setHideCompleted");

		$hideCompleted = !!$hideCompleted;

		if (!$this->updateHideCompleted($hideCompleted, $response))
			return false;

		$this->hideCompleted = $hideCompleted;
		return true;
	}

	/**
	 * Set to true to enable "now" mode where if either bound is set to 0, it will treat the
	 * bound as the current time and date, versus disabled, treating 0 just simply as "today"
	 * @param          $isBoundNow
	 * @param Response $response
	 * @return bool
	 */
	public function setIsBoundNow($isBoundNow, Response &$response = null) {
		Response::getInstance($response, "Timescope::setLowerBoundIsInfinite");

		$isBoundNow = !!$isBoundNow;

		if (!$this->updateIsBoundNow($isBoundNow, $response))
			return false;

		$this->isBoundNow = $isBoundNow;
		return true;
	}


	// Validation
	/**
	 * Checks if the given value is a valid timescope name.
	 * @param          $name
	 * @param Response $response
	 * @return bool
	 */
	public static function isValidName($name, Response &$response = null) {
		Response::getInstance($response, "Timescope::isValidName");

		// Must be longer than min length
		if (strlen($name) < 1)
			$response->addError("I don't think an empty name is very useful.");

		// Must be shorter than max length
		if (strlen($name) > self::NAME_MAX_LENGTH)
			$response->addError("Sometimes the best names are the shortest. Please keep timescope "
								. "names less than "
								. self::NAME_MAX_LENGTH
								. " characters long.");

		return !$response->hasFailed();
	}

	/**
	 * Checks if the given value is a valid bound.
	 * @param          $days
	 * @param Response $response
	 * @return bool
	 */
	public static function isValidBound($days, Response &$response = null) {
		Response::getInstance($response, "Timescope::isValidBound");

		// Must be an integer
		if (preg_match("/[^0-9]/", $days))
			$response->addError("Bound must be given in integer days");

		return !$response->hasFailed();
	}


	// Implementor methods.
	protected abstract function updateName($name, Response &$response = null);

	protected abstract function updateLowerBound($day, Response &$response = null);

	protected abstract function updateUpperBound($day, Response &$response = null);

	protected abstract function updateHideIfEmpty($hideIfEmpty, Response &$response = null);

	protected abstract function updateHideCompleted($hideComplete, Response &$response = null);

	protected abstract function updateLowerBoundIsInfinite($isInfinite, Response &$response = null);

	protected abstract function updateUpperBoundIsInfinite($isInfinite, Response &$response = null);

	protected abstract function updateIsBoundNow($isBoundNow, Response &$response = null);
}