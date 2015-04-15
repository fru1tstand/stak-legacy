<?php 
namespace content\page\processors;

class MockTask {
	/**
	 * Creates and returns a set of {@link MockTask}s
	 */
	public static function getMockTasks() {
		//Create tags
		$schoolTag = (new MockTag())
				->id(0)
				->color("#99F")
				->name("School tag that's very long and stuff and doesn't quite care if it goes off the page");
		$importantTag = (new MockTag())
				->id(1)
				->color("#FF9")
				->name("Important");
		$projectsTag = (new MockTag())
				->id(2)
				->color("#0F0")
				->name("Projects");
		$workTag = (new MockTag())
				->id(3)
				->color("#F00")
				->name("Work");
		
		//Create the tasks
		$tasks = [];
		
		$tasks[] = (new MockTask())
				->id(0)
				->title("Giant music project that most definitely exceeds two lines in the main window and will be cut off when inside the list mode")
				->parentId
	}
	
	//The actual class
	public $id;
	public $title;
	public $parentId;
	public $dueDate;
	public $primaryTag;
	public $tags;
	public $completedDate;
	
	//Setup for clarity when creating.
	public function __construct() {
		return $this;
	}
	public function id($id) {
		$this->id = $id;
		return $this;
	}
	public function title($title) {
		$this->title = $title;
		return $this;
	}
	public function parentId($parentId) {
		$this->parentId = $parentId;
		return $this;
	}
	public function dueDate($dueDate) {
		$this->dueDate = $dueDate;
		return $this;
	}
	public function addTag(MockTag $tag) {
		if (!is_array($this->tags))
			$this->tags = [];
		if (!in_array($tag, $this->tags))
			$this->tags[] = $tag;
		return $this;
	}
	public function primaryTag(MockTag $tag) {
		$this->addTag($tag);		
		$this->primaryTag = $primaryTag;
		return $this;
	}
	public function completedDate($date) {
		$this->completedDate = $date;
		return $this;
	}
}

class MockTag {
	public $id;
	public $color;
	public $name;
	
	public function __construct() {
		return $this;
	}
	
	public function id($id) {
		$this->id = $id;
		return $this;
	}
	public function color($color) {
		$this->color = $color;
		return $this;
	}
	public function name($name) {
		$this->name = $name;
		return $this;
	}
}
?>