<?php
namespace stak\filters;
use common\base\Preconditions;
use stak\base\Tag;
use stak\base\Task;

/**
 * This class is used to filter task requests to the implemented UserData class. Maybe in the
 * future I'll add boolean logic. But for now, simplistic linear searching should suffice.
 * @package stak\base\userdata
 */
class TaskFilter {
	// Filter fields
	/** @var  int */	private $resultLimit;
	/** @var  string */	private $titleContains;
	/** @var  string */	private $titleDoesNotContain;
	/** @var  string */	private $descriptionContains;
	/** @var  string */	private $descriptionDoesNotContain;
	/** @var  int */	private $dueDateLowerBound;
	/** @var  int */	private $dueDateUpperBound;
	/** @var  bool */	private $inclusiveDueDate;
	/** @var  int */	private $completedDateLowerBound;
	/** @var  int */	private $completedDateUpperBound;
	/** @var  bool */	private $inclusiveCompletedDate;
	/** @var  Tag[] */	private $primaryTagIs;
	/** @var  Tag[] */	private $primaryTagIsNot;
	/** @var  Tag[] */	private $tagsAre;
	/** @var  Tag[] */	private $tagsAreNot;
	/** @var  Task[] */	private $parentIs;
	/** @var  Task[] */	private $parentIsNot;
	/** @var  Task[] */	private $childrenAre;
	/** @var  Task[] */	private $childrenAreNot;
	/** @var  int */	private $creationDateLowerBound;
	/** @var  int */	private $creationDateUpperBound;
	/** @var  bool */	private $inclusiveCreationDate;

	// Setters
	/**
	 * Limits the result set to a maximum
	 * @param int $resultLimit
	 * @return TaskFilter
	 */
	public function limit($resultLimit) {
		$this->resultLimit = $resultLimit;
		return $this;
	}

	/**
	 * Only include tasks that contain the passed search query in the title.
	 * Quotes phrases "like this" are searched for in the exact order stated, whereas words not
	 * surrounded by quotes are delimited by spaces and searched for independently. Pass null or
	 * an empty string to disable filter.
	 * @param string $titleContains
	 * @return TaskFilter
	 */
	public function titleContains($titleContains) {
		$this->titleContains = $titleContains;
		if (empty($titleContains))
			$this->titleContains = null;
		return $this;
	}

	/**
	 * Exclude tasks that contain the given search query in the title. Pass null or an empty
	 * string to disable filter.
	 * @see titleContains
	 * @param string $titleDoesNotContain
	 * @return TaskFilter
	 */
	public function titleDoesNotContain($titleDoesNotContain) {
		$this->titleDoesNotContain = $titleDoesNotContain;
		if (empty($titleDoesNotContain))
			$this->titleDoesNotContain = null;
		return $this;
	}

	/**
	 * Only include tasks that contain the given search query in the description. Pass null or an
	 * empty string to disable filter.
	 * @see titleContains
	 * @param string $descriptionContains
	 * @return TaskFilter
	 */
	public function descriptionContains($descriptionContains) {
		$this->descriptionContains = $descriptionContains;
		if (empty($descriptionContains))
			$this->descriptionContains = null;
		return $this;
	}

	/**
	 * Exclude tasks that contain the given search query in the description. Pass null or empty
	 * string to disable filter.
	 * @see titleContains
	 * @param string $descriptionDoesNotContain
	 * @return TaskFilter
	 */
	public function descriptionDoesNotContain($descriptionDoesNotContain) {
		$this->descriptionDoesNotContain = $descriptionDoesNotContain;
		if (empty($descriptionDoesNotContain))
			$this->descriptionDoesNotContain = null;
		return $this;
	}

	/**
	 * Defines a lower due date bound in unix UTC+0 time. Pass < 1 to disable filter.
	 * @see inclusiveDueDate
	 * @param int $dueDateLowerBound
	 * @return TaskFilter
	 */
	public function dueDateLowerBound($dueDateLowerBound) {
		$this->dueDateLowerBound = $dueDateLowerBound;
		if ($dueDateLowerBound < 1)
			$this->dueDateLowerBound = null;
		return $this;
	}

	/**
	 * Defines an upper due date bound in unix UTC+0 time. Pass < 1 to disable filter.
	 * @see inclusiveDueDate
	 * @param int $dueDateUpperBound
	 * @return TaskFilter
	 */
	public function dueDateUpperBound($dueDateUpperBound) {
		$this->dueDateUpperBound = $dueDateUpperBound;
		if ($dueDateUpperBound < 1)
			$this->dueDateUpperBound = null;
		return $this;
	}

	/**
	 * When true, sets the range defined by the lower and upper bound to be inclusive (default).
	 * @param boolean $inclusiveDueDate
	 * @return TaskFilter
	 */
	public function inclusiveDueDate($inclusiveDueDate) {
		$this->inclusiveDueDate = $inclusiveDueDate;
		return $this;
	}

	/**
	 * Defines a lower completed date bound in unix UTC+0 time. Pass < 1 to disable.
	 * @see inclusiveCompletedDate
	 * @param int $completedDateLowerBound
	 * @return TaskFilter
	 */
	public function completedDateLowerBound($completedDateLowerBound) {
		$this->completedDateLowerBound = $completedDateLowerBound;
		if ($completedDateLowerBound < 1)
			$this->completedDateLowerBound = null;
		return $this;
	}

	/**
	 * Defines an upper completed date bound in unix UTC+0 time. Pass < to disable.
	 * @see inclusiveCompletedDate
	 * @param int $completedDateUpperBound
	 * @return TaskFilter
	 */
	public function completedDateUpperBound($completedDateUpperBound) {
		$this->completedDateUpperBound = $completedDateUpperBound;
		if ($completedDateUpperBound < 0)
			$this->completedDateUpperBound = null;
		return $this;
	}

	/**
	 * When true, sets the range to be inclusive (default). Eg, tasks with completed dates within
	 * the range are included in the result set.
	 * @param boolean $inclusiveCompleteDate
	 * @return TaskFilter
	 */
	public function inclusiveCompletedDate($inclusiveCompleteDate) {
		$this->inclusiveCompletedDate = $inclusiveCompleteDate;
		return $this;
	}

	/**
	 * Only include tasks that have any one of the given primary tag(s). Pass null or empty array
	 * to disable.
	 * @param Tag[] $primaryTagIs
	 * @return TaskFilter
	 */
	public function primaryTagIs($primaryTagIs) {
		$this->primaryTagIs = $primaryTagIs;
		if (Preconditions::arrayNullInvalidOrEmpty($primaryTagIs))
			$this->primaryTagIs = null;
		return $this;
	}

	/**
	 * Exclude tasks that have any one of the given primary tag(s). Pass null or empty array to
	 * disable.
	 * @param Tag[] $primaryTagIsNot
	 * @return TaskFilter
	 */
	public function primaryTagIsNot($primaryTagIsNot) {
		$this->primaryTagIsNot = $primaryTagIsNot;
		if (Preconditions::arrayNullInvalidOrEmpty($primaryTagIsNot))
			$this->primaryTagIsNot = null;
		return $this;
	}

	/**
	 * Only include tasks that have any one of the given tag(s). Pass null or empty array to
	 * disable.
	 * @param Tag[] $tagsAre
	 * @return TaskFilter
	 */
	public function tagsAre($tagsAre) {
		$this->tagsAre = $tagsAre;
		if (Preconditions::arrayNullInvalidOrEmpty($tagsAre))
			$this->tagsAre = null;
		return $this;
	}

	/**
	 * Exclude tasks that have any one of the given tag(s). Pass null or empty array to disable.
	 * @param Tag[] $tagsAreNot
	 * @return TaskFilter
	 */
	public function tagsAreNot($tagsAreNot) {
		$this->tagsAreNot = $tagsAreNot;
		if (Preconditions::arrayNullInvalidOrEmpty($tagsAreNot))
			$this->tagsAreNot = null;
		return $this;
	}

	/**
	 * Only includes tasks that have any one of the given parent(s). Pass null or empty array to
	 * disable.
	 * @param Task[] $parentIs
	 * @return TaskFilter
	 */
	public function parentIs($parentIs) {
		$this->parentIs = $parentIs;
		if (Preconditions::arrayNullInvalidOrEmpty($parentIs))
			$this->parentIs = null;
		return $this;
	}

	/**
	 * Excludes tasks that have any one of the given parent(s). Pass null or empty array to disable.
	 * @param Task[] $parentIsNot
	 * @return TaskFilter
	 */
	public function parentIsNot($parentIsNot) {
		$this->parentIsNot = $parentIsNot;
		if (Preconditions::arrayNullInvalidOrEmpty($parentIsNot))
			$this->parentIsNot = null;
		return $this;
	}

	/**
	 * Only includes tasks that have any one or more of the given child/children. Pass null or
	 * empty array to disable.
	 * @param Task[] $childrenAre
	 * @return TaskFilter
	 */
	public function childrenAre($childrenAre) {
		$this->childrenAre = $childrenAre;
		if (Preconditions::arrayNullInvalidOrEmpty($childrenAre))
			$this->childrenAre = null;
		return $this;
	}

	/**
	 * Exclude tasks that have any one or more of the given child/children. Pass null or empty
	 * array to disable.
	 * @param Task[] $childrenAreNot
	 * @return TaskFilter
	 */
	public function childrenAreNot($childrenAreNot) {
		$this->childrenAreNot = $childrenAreNot;
		if (Preconditions::arrayNullInvalidOrEmpty($childrenAreNot))
			$this->childrenAreNot = null;
		return $this;
	}

	/**
	 * Defines a lower creation date bound in unix UTC+0 time. Pass < 1 to disable.
	 * @see inclusiveCreationDate
	 * @param int $creationDateLowerBound
	 * @return TaskFilter
	 */
	public function creationDateLowerBound($creationDateLowerBound) {
		$this->creationDateLowerBound = $creationDateLowerBound;
		if ($creationDateLowerBound < 1)
			$this->creationDateLowerBound = null;
		return $this;
	}

	/**
	 * Defines an upper creation date bound in unix UTC+0 time. Pass < 1 to disable.
	 * @see inclusiveCreationDate
	 * @param int $creationDateUpperBound
	 * @return TaskFilter
	 */
	public function creationDateUpperBound($creationDateUpperBound) {
		$this->creationDateUpperBound = $creationDateUpperBound;
		if ($creationDateUpperBound < 1)
			$this->creationDateUpperBound = null;
		return $this;
	}

	/**
	 * When set to true (default), only tasks within the range will be included.
	 * @param boolean $inclusiveCreationDate
	 * @return TaskFilter
	 */
	public function inclusiveCreationDate($inclusiveCreationDate) {
		$this->inclusiveCreationDate = $inclusiveCreationDate;
		return $this;
	}


	// Getters
	/**
	 * @see limit
	 * @return int
	 */
	public function getResultLimit() {
		return $this->resultLimit;
	}

	/**
	 * @see titleContains
	 * @return string
	 */
	public function getTitleContains() {
		return $this->titleContains;
	}

	/**
	 * @see titleDoesNotContain
	 * @return string
	 */
	public function getTitleDoesNotContain() {
		return $this->titleDoesNotContain;
	}

	/**
	 * @see descriptionContains
	 * @return string
	 */
	public function getDescriptionContains() {
		return $this->descriptionContains;
	}

	/**
	 * @see descriptionDoesNotContain
	 * @return string
	 */
	public function getDescriptionDoesNotContain() {
		return $this->descriptionDoesNotContain;
	}

	/**
	 * @see dueDateLowerBound
	 * @return int
	 */
	public function getDueDateLowerBound() {
		return $this->dueDateLowerBound;
	}

	/**
	 * @see dueDateUpperBound
	 * @return int
	 */
	public function getDueDateUpperBound() {
		return $this->dueDateUpperBound;
	}

	/**
	 * @see inclusiveDueDate
	 * @return boolean
	 */
	public function isInclusiveDueDate() {
		return $this->inclusiveDueDate;
	}

	/**
	 * @see completedDateLowerBound
	 * @return int
	 */
	public function getCompletedDateLowerBound() {
		return $this->completedDateLowerBound;
	}

	/**
	 * @see completedDateUpperBound
	 * @return int
	 */
	public function getCompletedDateUpperBound() {
		return $this->completedDateUpperBound;
	}

	/**
	 * @see inclusiveCompletedDate
	 * @return boolean
	 */
	public function isInclusiveCompletedDate() {
		return $this->inclusiveCompletedDate;
	}

	/**
	 * @see primaryTagIs
	 * @return Tag[]
	 */
	public function getPrimaryTagIs() {
		return $this->primaryTagIs;
	}

	/**
	 * @see primaryTagIsNot
	 * @return Tag[]
	 */
	public function getPrimaryTagIsNot() {
		return $this->primaryTagIsNot;
	}

	/**
	 * @see tagsAre
	 * @return Tag[]
	 */
	public function getTagsAre() {
		return $this->tagsAre;
	}

	/**
	 * @see tagsAreNot
	 * @return Tag[]
	 */
	public function getTagsAreNot() {
		return $this->tagsAreNot;
	}

	/**
	 * @see parentIs
	 * @return Task[]
	 */
	public function getParentIs() {
		return $this->parentIs;
	}

	/**
	 * @see parentIsNot
	 * @return Task[]
	 */
	public function getParentIsNot() {
		return $this->parentIsNot;
	}

	/**
	 * @see childrenAre
	 * @return Task[]
	 */
	public function getChildrenAre() {
		return $this->childrenAre;
	}

	/**
	 * @see childrenAreNot
	 * @return Task[]
	 */
	public function getChildrenAreNot() {
		return $this->childrenAreNot;
	}

	/**
	 * @see creationDateLowerBound
	 * @return int
	 */
	public function getCreationDateLowerBound() {
		return $this->creationDateLowerBound;
	}

	/**
	 * @see creationDateUpperBound
	 * @return int
	 */
	public function getCreationDateUpperBound() {
		return $this->creationDateUpperBound;
	}

	/**
	 * @see inclusiveCreationDate
	 * @return boolean
	 */
	public function isInclusiveCreationDate() {
		return $this->inclusiveCreationDate;
	}
}
