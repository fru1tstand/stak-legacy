<?php
namespace stak\organizers;
require_once $_SERVER["DOCUMENT_ROOT"] . "/.site/php/stak/Autoload.php";
use stak\foundation\Task;
use Exception;

/**
 * TagGroup contains a collection of TagContainers. This class is currently unused directly, but
 * may in the future.
 * @package stak\organizers
 */
class TagGroup {
	/** @var  TagContainer[] */	private $tagContainers;

	/**
	 * Creates a new TagGroup, optionally instantiating it with the given containers
	 * @param array $tagContainers
	 * @throws Exception
	 */
	public function __construct(array $tagContainers = null) {
		$this->tagContainers = array();

		if (is_null($tagContainers))
			return;

		foreach ($tagContainers as $tagContainer) {
			if (!($tagContainer instanceof TagContainer))
				throw new Exception("There's something happening here, and it sure ain't a
				TagContainer");

			$this->tagContainers[] = $tagContainer;
		}
	}

	/**
	 * Simply adds a tag container to this group
	 * @param TagContainer $tc
	 */
	public function addTagContainer(TagContainer $tc) {
		$this->tagContainers[] = &$tc;
	}

	/**
	 * Adds a Task to all applicable tag containers in this group
	 * @param \stak\foundation\Task $task
	 */
	public function addTask(Task $task) {
		foreach ($this->tagContainers as $tc)
			$tc->addTaskIfHasTag($task);
	}


	// Sorters
	public function sortAlphabetical() {
		if (count($this->tagContainers) > 1) {
			usort($this->tagContainers, function(TagContainer $a, TagContainer $b) {
				return $a->getTag()->compareAlphabetical($b->getTag());
			});
		}
	}


	// Getters
	/**
	 * @return TagContainer[]
	 */
	public function getTagContainers() {
		return $this->tagContainers;
	}
}
