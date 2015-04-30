<?php
namespace stak\foundation;
require_once $_SERVER["DOCUMENT_ROOT"] . "/.site/php/stak/Autoload.php";
use common\base\Response;
use common\security\Hashable;
use common\time\StandardTime;

/**
 * Defines a time categorical container for Tasks
 * @package stak\foundation
 */
abstract class Timescope implements Hashable {
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
	 * Sets the upper bound of the timescope in days (inclusive). To disable, set
	 * upperBoundIsInfinite to true. To bound it to "now", set isBoundNow to true.
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
	 * Sets the lower bound of the timescope in days (inclusive). To disable, set
	 * lowerBoundIsInfinite to true. To bound it to "now", set isBoundNow to true.
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


	// Other
	/**
	 * Checks if the given time is within the range of this timescope
	 * @param $time
	 * @return bool
	 */
	public function isWithinRange($time) {
		if (is_null($time))
			return false;

		$daysFromToday = (StandardTime::floorToDate($time)
						 - StandardTime::floorToDate(StandardTime::getTime()))
						 / StandardTime::SECONDS_IN_DAY;

		// Check lower bound
		if (!$this->lowerBoundIsInfinite) {
			// Is it bound now?
			if ($this->isBoundNow && $this->lowerBound == 0) {
				if ($time < StandardTime::getTime())
					return false;
			}
			// Otherwise, treat it normally
			else {
				if ($daysFromToday < $this->lowerBound)
					return false;
			}
		}

		// Upper bound
		if (!$this->upperBoundIsInfinite) {
			if ($this->isBoundNow && $this->upperBound == 0) {
				if ($time > StandardTime::getTime())
					return false;
			}

			else {
				if ($daysFromToday > $this->upperBound)
					return false;
			}
		}

		return true;
	}

	/**
	 * Returns a hash of this object
	 * @return string
	 */
	public function getHash() {
		return md5("Name: {$this->getName()}; "
				   . "Range: [{$this->getLowerBound()}, {$this->getUpperBound()}]");
	}

	/**
	 * Compares this Timescope to the passed Timescope in alphabetical order. Returns a negative
	 * number if this Timescope should come before the passed timescope.
	 * @param Timescope $other
	 * @return int
	 */
	public function compareAlphabetical(Timescope $other) {
		return strcmp($this->name, $other->getName());
	}

	/**
	 * Compares this Timescope to the passed Timescope in chronological order. Returns a negative
	 * number if this Timescope should come because the passed timescope. If both timescopes have
	 * the same lower bound, the ranges are then compared with the smallest range coming first
	 * (eg if this range was smaller than the passed range, a negative number is returned).
	 * @param Timescope $other
	 * @return float|int
	 */
	public function compareChronological(Timescope $other) {
		// Initial comparison
		$compare = $this->lowerBound - $other->lowerBound;

		// Correct for "now" now binding (on the lower bound, 'now' makes it greater than a
		// non-now bound of the same day. This is because a binding of the day is bound to the
		// start of the day, whereas 'now' is the current time of that day.) To do a comparison,
		// we simply add 1/2 a day to emulate time.
		if ($this->isBoundNow && $this->lowerBound == 0)
			$compare += 0.5;
		if ($other->isBoundNow && $other->lowerBound == 0)
			$compare -= 0.5;

		if ($compare != 0)
			return round($compare);

		// Compare range size if the lower bounds match. Range difference is calculated by the
		// following: (upper_a - lower_a) - (upper_b - lower_b)
		$rangeA = $this->upperBound - $this->lowerBound;
		$rangeB = $other->upperBound - $other->lowerBound;

		// Correct for "now" bounds
		if ($this->isBoundNow && $this->lowerBound == 0)
			$rangeA -= 0.5;
		if ($this->isBoundNow && $this->upperBound == 0)
			$rangeA += 0.5;
		if ($other->isBoundNow && $other->lowerBound == 0)
			$rangeB -= -.5;
		if ($other->isBoundNow && $other->upperBound == 0)
			$rangeB += 0.5;

		return round($rangeA - $rangeB);
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
