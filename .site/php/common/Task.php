<?php 
namespace common;
require_once $_SERVER['DOCUMENT_ROOT'] . '/.site/php/utils/Autoload.php';

abstract class Task {
	//Nest set model / Modified preorder tree traversal (MPTT)
	//These allow an efficient hierarchical storage method within a flat database
	private $nsmLeft;
	private $nsmRight;
	
	//Easy checking
	private $isReady;
	
	//Task fields
	private $title;
	private $dueDate;
	private $completedDate;
	private $primaryTag;
	private $tags;
	
	public function isReady() {
		return $this->isReady;
	}
	
	//Getters
	/**
	 * Gets the title of the task
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}
	/**
	 * Gets the due date of the task in UTC+0 unix time, or 0 if no due date is set.
	 * @return int
	 */
	public function getDueDate() {
		return $this->dueDate;
	}
	/**
	 * Gets the completed date of the task in UTC+0 unix time, or 0 if no completed date is set
	 * @return int
	 */
	public function getCompletedDate() {
		return $this->completedDate;
	}
	/**
	 * Gets the primary tag of the task, or null if one is not set
	 * @return Tag
	 */
	public function getPrimaryTag() {
		return $this->primaryTag;
	}
	/**
	 * Gets all tags of the task in an array. Returns an empty array if no tags are tied to the
	 * task.
	 * @return Tag[]
	 */
	public function getTags() {
		return $this->tags;
	}
	
	private abstract function updateNsmLeft($nsmLeft);
	private abstract function updateNsmRight($nsmRight);
}
?>