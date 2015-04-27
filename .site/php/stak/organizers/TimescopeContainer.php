<?php
namespace stak\organizers;
require_once $_SERVER['DOCUMENT_ROOT'] . '/.site/php/stak/Autoload.php';
use stak\foundation\Timescope;
use stak\foundation\Task;
use Exception;

/**
 * TimescopeContainer contains a single Timescope and a collection of Tasks that are within that
 * timescope's range. The collection of tasks could be pre-filtered (by tag, or by search)
 * depending on the viewstyle that is displaying it.
 * @package stak\organizers
 */
class TimescopeContainer {
	/** @var Timescope */	private $timescope;
	/** @var Task[] */		private $tasks;

	/**
	 * Creates a new TimescopeContainer with the given timescope and tasks if passed any.
	 * Otherwise creates an instance with the given timescope and an empty collection of tasks.
	 * @param Timescope $timescope
	 * @param array     $tasks
	 * @throws Exception If the tasks you give aren't actually tasks.
	 */
	public function __construct(Timescope $timescope, array $tasks = null) {
		foreach ($tasks as $task)
			if (!($task instanceof Task))
				throw new Exception("That wasn't a task you passed me!");

		$this->timescope = $timescope;
		$this->tasks = $tasks;

		if (is_null($this->tasks) || !is_array($this->tasks))
			$this->tasks = array();
	}

	/**
	 * Adds the given task to this TimescopeContainer if the task falls within the timescope range.
	 * @param Task $task
	 */
	public function addIfWithinRange(Task &$task) {
		if ($this->timescope->isWithinRange($task->getDueDate()))
			$this->tasks[] = &$task;
	}


	// Getters
	/**
	 * @return Timescope
	 */
	public function getTimescope() {
		return $this->timescope;
	}

	/**
	 * @return Task[]
	 */
	public function getTasks() {
		return $this->tasks;
	}

	
	// Sorting things
	/**
	 * Sorts this timescope's task list in chronological order
	 */
	public function sortChronological() {
		usort($this->tasks, function(Task $a, Task $b) {
			return $a->compareChronological($b);
		});
	}

	/**
	 * Sorts this timescope's task list in reverse chronological order
	 */
	public function sortReverseChronological() {
		usort($this->tasks, function(Task $a, Task $b) {
			return $b->compareChronological($a);
		});
	}

	/**
	 * Sorts this timescope's task list in alphabetical order
	 */
	public function sortAlphabetical() {
		usort($this->tasks, function(Task $a, Task $b) {
			return $a->compareAlphabetical($b);
		});
	}

	/**
	 * Sorts this timescope's task list in reverse alphabetical order
	 */
	public function sortReverseAlphabetical() {
		usort($this->tasks, function(Task $a, Task $b) {
			return $b->compareAlphabetical($a);
		});
	}
}