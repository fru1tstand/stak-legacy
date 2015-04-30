<?php
namespace stak\organizers;
require_once $_SERVER['DOCUMENT_ROOT'] . '/.site/php/stak/Autoload.php';
use stak\foundation\Tag;
use stak\foundation\Task;
use stak\foundation\Timescope;

/**
 * TagContainer contains a single Tag and a single TimescopeGroup
 * Class TagContainer
 * @package stak\organizers
 */
class TagContainer {
	/** @var TimescopeGroup */	private $timescopeGroup;
	/** @var Tag */				private $tag;

	// Constructor/Builder
	/**
	 * Creates a new TagContainer with the given tag and timescope group
	 * @param Tag            $tag
	 * @param TimescopeGroup $timescopeGroup
	 */
	public function __construct(Tag &$tag, TimescopeGroup &$timescopeGroup) {
		$this->tag = &$tag;
		$this->timescopeGroup = &$timescopeGroup;
	}

	/**
	 * Adds the given task to this container if the task contains this container's tag
	 * @param Task $task
	 */
	public function addTaskIfHasTag(Task &$task) {
		foreach ($task->getTags() as $tag) {
			if ($tag->getHash() === $this->tag->getHash()) {
				$this->timescopeGroup->addTask($task);
				break;
			}
		}
	}


	// Getters
	/**
	 * @return TimescopeGroup
	 */
	public function getTimescopeGroup() {
		return $this->timescopeGroup;
	}

	/**
	 * @return Tag
	 */
	public function getTag() {
		return $this->tag;
	}
}
