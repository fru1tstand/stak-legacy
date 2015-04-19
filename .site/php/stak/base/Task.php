<?php
namespace stak\base;
require_once $_SERVER["DOCUMENT_ROOT"] . "/.site/php/stak/Autoload.php";
use common\base\Response;

/**
 * This class provides the common definition of a Task
 * @package stak
 */
abstract class Task {
	// Constants
	const TITLE_MAX_LENGTH = 512;

	// Task fields
	/* @var string */	protected $title;
	/* @var string */	protected $description;
	/* @var int */		protected $dueDate;
	/* @var int */		protected $completedDate;
	/* @var Tag */		protected $primaryTag;
	/* @var Tag[] */	protected $tags;
	/* @var Task */		protected $parent;
	/* @var Task[] */	protected $children;


	// Getters
	/**
	 * Gets the title of the task
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Gets the description of the task
	 * @return null | string
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * Gets the due date of the task in UTC+0 unix time, or null if no due date is set. Time is also
	 * encoded in this value. A factor of 86400 (seconds in a day) means no time was set. This
	 * value never stores daylight savings time.
	 * @return null | int
	 */
	public function getDueDate() {
		return $this->dueDate;
	}

	/**
	 * Gets the completed date of the task in UTC+0 unix time, or null if no completed date is set.
	 * This value never stores daylight savings time.
	 * @return null | int
	 */
	public function getCompletedDate() {
		return $this->completedDate;
	}

	/**
	 * Gets the primary tag of the task, or null if one is not set
	 * @return null | Tag
	 */
	public function getPrimaryTag() {
		return $this->primaryTag;
	}

	/**
	 * Gets all tags of this task. Returns an empty array if there are none.
	 * @return Tag[]
	 */
	public function getTags() {
		return $this->tags;
	}

	/**
	 * Gets the parent of this task, or null if one isn't set.
	 * @return null | Task
	 */
	public function getParent() {
		return $this->parent;
	}

	/**
	 * Gets the children of this task or an empty array if none exist.
	 * @return Task[]
	 */
	public function getChildren() {
		return $this->children;
	}


	// Processed "getters"
	/**
	 * Checks if this task has the given tag.
	 * @param Tag $tag
	 * @return bool
	 */
	public function containsTag(Tag $tag) {
		return is_array($this->tags) && in_array($tag, $this->tags);
	}

	/**
	 * Checks if this task has the given task as a child.
	 * @param Task $child
	 * @return bool
	 */
	public function containsChild(Task $child) {
		return is_array($this->children) && in_array($child, $this->children);
	}


	// Setters
	/**
	 * Attempts to set the title of the task.
	 * @param          $title
	 * @param Response $response
	 * @return bool True on success; false otherwise.
	 */
	public function setTitle($title, Response &$response = null) {
		Response::getInstance($response, "Task::setTitle");

		if (!self::isValidTitle($title, $response))
			return false;

		if (!$this->updateTitle($title, $response))
			return false;

		$this->title = $title;
		return true;
	}

	/**
	 * Attempts to set the description of the task. Pass null or empty string to remove.
	 * @param string   $description
	 * @param Response $response
	 * @return bool True on success; false otherwise.
	 */
	public function setDescription($description, Response &$response = null) {
		Response::getInstance($response, "Task::setDescription");

		if ($description === "") $description = null;

		if (!$this->updateDescription($description, $response))
			return false;

		$this->description = $description;
		return true;
	}

	/**
	 * Attempts to set the due date of the task. Pass null to remove.
	 * @param          $dueDate
	 * @param Response $response
	 * @return bool True on success; false otherwise.
	 */
	public function setDueDate($dueDate, Response &$response = null) {
		Response::getInstance($response, "Task::setDueDate");

		if (!self::isValidDate($dueDate, $response))
			return false;

		if ($this->updateDueDate($dueDate, $response))
			return false;

		$this->dueDate = $dueDate;
		return true;
	}

	/**
	 * Attempts to set the completed date of the task. Pass null to remove.
	 * @param          $completedDate
	 * @param Response $response
	 * @return bool True on success; false otherwise.
	 */
	public function setCompletedDate($completedDate, Response &$response = null) {
		Response::getInstance($response, "Task::setCompletedDate");

		if (!self::isValidDate($completedDate, $response))
			return false;

		if (!$this->updateCompletedDate($completedDate, $response))
			return false;

		$this->completedDate = $completedDate;
		return true;
	}

	/**
	 * Attempts to set the primary tag for the task. Automatically adds primary tag to
	 * tag list if
	 * not added already. Pass null to remove.
	 * @param Tag      $primaryTag
	 * @param Response $response
	 * @return bool True on success; false otherwise
	 */
	public function setPrimaryTag(Tag &$primaryTag = null, Response &$response = null) {
		Response::getInstance($response, "Task::setPrimaryTag");

		// Add to tag list of not already
		if (!$this->containsTag($primaryTag))
			if (!$this->addTag($primaryTag, $response))
				return false;

		if (!$this->updatePrimaryTag($primaryTag, $response))
			return false;

		$this->primaryTag = &$primaryTag;
		return !$response->hasFailed();
	}

	/**
	 * Attempts to set all tags for the task. Pass an empty array to remove all tags.
	 * @param array    $tags
	 * @param Response $response
	 * @return bool True on success; false otherwise.
	 */
	public function setTags(array $tags, Response &$response = null) {
		Response::getInstance($response, "Task::setTags");

		if (!self::isValidTags($tags, $response))
			return false;

		if (!$this->updateTags($tags, $response))
			return false;

		$this->tags = $tags;
		return true;
	}

	/**
	 * Attempts to add a tag to the task.
	 * @param Tag      $tag
	 * @param Response $response
	 * @return bool True on success; false otherwise.
	 */
	public function addTag(Tag &$tag, Response &$response = null) {
		Response::getInstance($response, "Task::addTag");

		// Task tags should never not be an array. If it isn't there's an issue. Flag it.
		if (!is_array($this->tags)) {
			$response->addError("Somehow, this task doesn't have a valid tag list");
			return false;
		}

		if ($this->containsTag($tag)) {
			$response->addError("Task already contains '{$tag->getName()}'");
			return false;
		}

		if (!$this->updateAddTag($tag, $response))
			return false;

		$this->tags[] = &$tag;
		return true;
	}

	/**
	 * Attempts to add a list of tags to the task.
	 * @param array    $tags
	 * @param Response $response
	 * @return bool True on success; false otherwise.
	 */
	public function addTags(array $tags, Response &$response = null) {
		Response::getInstance($response, "Task::addTags");

		if (!self::isValidTags($tags, $response))
			return false;

		foreach ($tags as $tag)
			if (!$this->addTag($tag, $response))
				return false;

		return true;
	}

	/**
	 * Attempts to remove a tag from the task.
	 * @param Tag      $tag
	 * @param Response $response
	 * @return bool True on success; false otherwise.
	 */
	public function removeTag(Tag $tag, Response &$response = null) {
		Response::getInstance($response, "Task::removeTag");

		// False if not found, else, tag index
		$tagKey = array_search($tag, $this->tags);

		if (!$tagKey) {
			$response->addError("404: tag not found in task");
			return false;
		}

		if (!$this->updateRemoveTag($tag, $response))
			return false;

		unset($this->tags[$tagKey]);
		return true;
	}

	/**
	 * Attempts to remove a list of tags from the task
	 * @param array    $tags
	 * @param Response $response
	 * @return bool True on success; false otherwise.
	 */
	public function removeTags(array $tags, Response &$response = null) {
		Response::getInstance($response, "Task::removeTags");

		if (!self::isValidTags($tags, $response))
			return false;

		foreach ($tags as $tag)
			if (!$this->removeTag($tag, $response))
				return false;

		return true;
	}

	/**
	 * Attempts to set the parent. Pass null to remove.
	 * @param Task     $parent
	 * @param Response $response
	 * @return bool True on success; false otherwise.
	 */
	public function setParent(Task &$parent = null, Response &$response = null) {
		Response::getInstance($response, "Task::setParent");

		if (!$this->updateParent($parent, $response))
			return false;

		$this->parent = &$parent;
		return true;
	}

	/**
	 * Attempts to set all children for this task. Pass an empty array to remove all children.
	 * @param array    $children
	 * @param Response $response
	 * @return bool True on success; false otherwise.
	 */
	public function setChildren(array $children, Response &$response = null) {
		Response::getInstance($response, "Task::setChildren");

		if (!self::isValidChildren($children, $response))
			return false;

		if (!$this->updateChildren($children, $response))
			return false;

		$this->children = $children;
		return true;
	}

	/**
	 * Attempts to add a child task to this task.
	 * @param Task     $child
	 * @param Response $response
	 * @return bool True on success; false otherwise.
	 */
	public function addChild(Task &$child, Response &$response = null) {
		Response::getInstance($response, "Task::addChild");

		// Children field should never not be an array. If it isn't, there's an issue. Flag it.
		if (!is_array($this->children)) {
			$response->addError("Somehow, this task doesn't have a valid child list");
			return false;
		}

		if ($this->containsChild($child)) {
			$response->addError("Task already contains {$child->getTitle()} as a child");
			return false;
		}

		if (!$this->updateAddChild($child, $response))
			return false;

		$this->children[] = &$child;
		return true;
	}

	/**
	 * Attempts to add a list of tasks as children to this task.
	 * @param array    $children
	 * @param Response $response
	 * @return bool True on success; false otherwise.
	 */
	public function addChildren(array $children, Response &$response = null) {
		Response::getInstance($response, "Task::addChildren");

		if (!self::isValidChildren($children, $response))
			return false;

		foreach ($children as $child)
			if (!$this->addChild($child, $response))
				return false;

		return true;
	}

	/**
	 * Attempts to remove a child from this task.
	 * @param Task     $child
	 * @param Response $response
	 * @return bool True on success; false otherwise.
	 */
	public function removeChild(Task $child, Response &$response = null) {
		Response::getInstance($response, "Task:: removeChild");

		//false if not found, else, tag index
		$childKey = array_search($child, $this->children);

		if (!$childKey) {
			$response->addError("404: Child not found in task");
			return false;
		}

		if (!$this->updateRemoveChild($child, $response))
			return false;

		unset($this->children[$childKey]);
		return true;
	}

	/**
	 * Removes a list of children from this task.
	 * @param array    $children
	 * @param Response $response
	 * @return bool True on success; false otherwise.
	 */
	public function removeChildren(array $children, Response &$response = null) {
		Response::getInstance($response, "Task::removeChildren");

		if (!self::isValidChildren($children, $response))
			return false;

		foreach ($children as $child)
			if (!$this->removeChild($child, $response))
				return false;

		return true;
	}


	//  Validators
	/**
	 * Checks if the given value is a valid title. Honestly, a title can be all spaces for all I
	 * care. To the backend, it doesn't make a difference.
	 * @param          $title
	 * @param Response $response
	 * @return bool True if valid; false otherwise
	 */
	public static function isValidTitle($title, Response &$response = null) {
		Response::getInstance($response, "Task::isValidTitle");

		// Must be longer than minimum length
		if (strlen($title) < 1)
			$response->addError("I don't think a blank name is very useful...");

		// And shorter than maximum length
		if (strlen($title) > self::TITLE_MAX_LENGTH)
			$response->addError("The title isn't the place to write essays! Shorten it to a maximum"
								. " of "
								. self::TITLE_MAX_LENGTH
								. " characters, and use the task description instead.");

		return !$response->hasFailed();
	}

	/**
	 * Checks if the given value is a valid date
	 * @param          $date
	 * @param Response $response
	 * @return bool True if valid; false otherwise
	 */
	public static function isValidDate($date, Response &$response = null) {
		Response::getInstance($response, "Task::isValidDueDate");

		// Null dates mean not set
		if (is_null($date))
			return true;

		// Non numeric characters
		if (preg_match("/[^0-9]/", $date))
			$response->addError("I can't understand that. Please give me the time as a unix"
								. " timestamp.");

		// Positive number
		if ($date < 0)
			$response->addError("Look, 1970 is far enough. Please give me a positive unix time.");

		// Not too big
		if ($date > PHP_INT_MAX)
			$response->addError("Look, 2038 is far enough. Please stick within that range.");

		return !$response->hasFailed();
	}

	/**
	 * Checks if the given value is a valid tag list. Fails on first error.
	 * @param array    $tags
	 * @param Response $response
	 * @return bool True if valid; false otherwise.
	 */
	public static function isValidTags(array $tags, Response &$response = null) {
		Response::getInstance($response, "Task::isValidTags");

		// check array
		if (!is_array($tags)) {
			$response->addError("I wasn't given a list of tags");
		}
		else {
			// Check they're all tags
			foreach ($tags as $tag) {
				if (!($tag instanceof Tag)) {
					$response->addError("One of these tags just doesn't belong here");
					break;
				}
			}
		}
		return $response->hasFailed();
	}

	public static function isValidChildren(array $children, Response &$response = null) {
		Response::getInstance($response, "Task::isValidChildren");

		// check array
		if (!is_array($children)) {
			$response->addError("I wasn't given a list of children tasks");
		}
		else {
			// Check they're all tasks
			foreach ($children as $child) {
				if (!($child instanceof Task)) {
					$response->addError("One of these tasks just doesn't belong here");
					break;
				}
			}
		}
		return $response->hasFailed();
	}

	// These are called when their corresponding #set* methods are called and before any local
	// properties are set. The return boolean is used to determine whether or not the update
	// should be completed locally (eg. A database write failed,
	// returning false, so we shouldn't
	// update the value here, and instead properly handle an error response).
	/**
	 * Called when {@link setTitle} is called.
	 * @param string   $title
	 * @param Response $response
	 * @return bool True on success; false otherwise.
	 */
	protected abstract function updateTitle($title, Response &$response = null);

	/**
	 * Called when {@link setDescription} is called.
	 * @param string   $description
	 * @param Response $response
	 * @return bool True on success; false otherwise.
	 */
	protected abstract function updateDescription($description, Response &$response = null);

	/**
	 * Called when {@link setDueDate} is called. Dates are handled using UTC+0 in unix time without
	 * daylight savings.
	 * @param int      $dueDate
	 * @param Response $response
	 * @return bool True on success; false otherwise.
	 */
	protected abstract function updateDueDate($dueDate, Response &$response = null);

	/**
	 * Called when {@link setCompletedDate} is called. Dates are handled using UTC+0 in unit time
	 * without daylight saving.
	 * @param int      $completedDate
	 * @param Response $response
	 * @return bool True on success; false otherwise.
	 */
	protected abstract function updateCompletedDate($completedDate, Response &$response = null);

	/**
	 * Called when {@link setPrimaryTag} is called. Passed null when removing.
	 * @param Tag      $primaryTag
	 * @param Response $response
	 * @return bool True on success; false otherwise.
	 */
	protected abstract function updatePrimaryTag(Tag $primaryTag = null,
												 Response &$response = null);

	/**
	 * Called when {@link setTags} is called. Passed an empty array when removing all tags.
	 * @param Tag[]    $tags
	 * @param Response $response
	 * @return bool True on success; false otherwise.
	 */
	protected abstract function updateTags(array $tags, Response &$response = null);

	/**
	 * Called when {@link addTag} is called.
	 * @param Tag      $tag
	 * @param Response $response
	 * @return bool True on success; false otherwise.
	 */
	protected abstract function updateAddTag(Tag $tag, Response &$response = null);

	/**
	 * Called when {@link removeTag} is called.
	 * @param Tag      $tag
	 * @param Response $response
	 * @return bool True on success; false otherwise.
	 */
	protected abstract function updateRemoveTag(Tag $tag, Response &$response = null);

	/**
	 * Called when {@link setParent} is called. Passed null when removing.
	 * @param Task     $task
	 * @param Response $response
	 * @return bool True on success; false otherwise.
	 */
	protected abstract function updateParent(Task $task = null, Response &$response = null);

	/**
	 * Called when {@link setChildren} is called.
	 * @param array    $children
	 * @param Response $response
	 * @return bool True on success; false otherwise.
	 */
	protected abstract function updateChildren(array $children, Response &$response = null);

	/**
	 * Called when {@link addChild} is called.
	 * @param Task     $child
	 * @param Response $response
	 * @return bool True on success; false otherwise.
	 */
	protected abstract function updateAddChild(Task $child, Response &$response = null);

	/**
	 * Called when {@link removeChild} is called.
	 * @param Task     $child
	 * @param Response $response
	 * @return bool True on success; false otherwise.
	 */
	protected abstract function updateRemoveChild(Task $child, Response &$response = null);
}
