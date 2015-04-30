<?php
namespace stak\organizers;
use Exception;
use stak\foundation\Task;
use stak\foundation\Timescope;

/**
 * TimescopeGroup contains a collection of TimescopeContainers.
 * @package stak\organizers
 */
class TimescopeGroup {
	/** @var TimescopeContainer[] */	private $timescopeContainers;

	// Constructor/Builders
	/**
	 * Creates a new TimescopeGroup with the given TimescopeContainers, or an empty
	 * TimescopeGroup if none are given
	 * @param array $timescopeContainers
	 * @throws Exception
	 */
	public function __construct(array $timescopeContainers = null) {
		$this->timescopeContainers = array();

		if (is_null($timescopeContainers))
			return;

		foreach ($timescopeContainers as $tc) {
			if (!($timescopeContainers instanceof TimescopeContainer))
				throw new Exception("I was passed an invalid TimescopeContainer. I blame you.");
			$this->timescopeContainers[] = &$tc;
		}
	}

	/**
	 * Simply adds a given TimescopeContainer to this group
	 * @param TimescopeContainer $tc
	 */
	public function addTimescopeContainer(TimescopeContainer &$tc) {
		$this->timescopeContainers[] = &$tc;
	}

	/**
	 * Adds the given task to this group by adding to all applicable containers in the group.
	 * @param Task $task
	 */
	public function addTask(Task $task) {
		foreach ($this->timescopeContainers as $tc)
			$tc->addTaskIfWithinRange($task);
	}


	// Sorters
	/**
	 * Sorts this group's containers by chronological order. (Does not affect the container's
	 * contents. Only this group's ordering.)
	 */
	public function sortChronological() {
		if (count($this->timescopeContainers) > 1)
			usort($this->timescopeContainers,
					function(TimescopeContainer $a, TimescopeContainer $b) {
						return $a->getTimescope()->compareChronological($b->getTimescope());
					});
	}

	/**
	 * Sorts this group's containers by alphabetical order. (Does not affect the container's
	 * contents. Only this group's ordering.)
	 */
	public function sortAlphabetical() {
		if (count($this->timescopeContainers) > 1)
			usort($this->timescopeContainers,
					function(TimescopeContainer $a, TimescopeContainer $b) {
						return $a->getTimescope()->compareAlphabetical($b->getTimescope());
					});
	}


	// Getters
	/**
	 * @return TimescopeContainer[]
	 */
	public function getTimescopeContainers() {
		return $this->timescopeContainers;
	}
}