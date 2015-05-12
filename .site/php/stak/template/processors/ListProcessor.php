<?php
namespace stak\template\processors;
require_once $_SERVER["DOCUMENT_ROOT"] . "/.site/php/stak/Autoload.php";
use stak\Autoload;
use stak\foundation\Task;
use stak\foundation\Timescope;
use stak\organizers\TagGroup;
use stak\organizers\TimescopeContainer;
use stak\organizers\TimescopeGroup;
use stak\UserData;
use stak\template\utils\TemplateUtils;
use stak\foundation\Tag;
use stak\organizers\TagContainer;
use Exception;

/**
 * The processing backend for the List template
 * @package stak\template\processors
 */
class ListProcessor {
	// Fetchers
	/**
	 * Fetches the requested view
	 */
	public static function showRequestedTasklistView() {
		//TODO: Correctly get view from settings
		$view = (isset($_GET['view'])) ? $_GET['view'] : '';
		switch ($view) {
			case "singlelist":
				TemplateUtils::includeFromContentLocation("/listpage/SingleListView.php");
				break;
			default:
				TemplateUtils::includeFromContentLocation("/listpage/SingleTagView.php");
				break;
		}
	}

	/**
	 * Fetches the requested tasks
	 * @return Task[]
	 * @throws Exception
	 */
	private static function getRequestedTasks() {
		// TODO: Correctly fetch requested tasks (was a filter applied?)

		/** @var UserData $ud */
		$ud = Autoload::getInjector()->getInstance(UserData::class);
		return $ud::getTasks();
	}

	/**
	 * Fetches the requested tags
	 * @return Tag[]
	 * @throws Exception
	 */
	private static function getRequestedTags() {
		// TODO: Correctly fetch requested tags (was a filter applied?)

		/** @var UserData $ud */
		$ud = Autoload::getInjector()->getInstance(UserData::class);
		return $ud::getTags();
	}


	// Group hashing
	/**
	 * Gets the has of a timescope that's contained within a tag.
	 * @param Timescope $ts
	 * @param Tag       $tag
	 * @return string
	 */
	public static function getTimescopeTagHash(Timescope $ts, Tag $tag) {
		return md5("Timescope: {$ts->getHash()}; Tag: {$tag->getHash()}");
	}


	// Generic view methods
	public static function getTaskHtml(Task $task) {
		$taskColor = $task->getPrimaryTag()->getValidCssColor();
		$taskTitle = htmlspecialchars($task->getTitle());
		$taskHash = $task->getHash();

		// Times (x) to "uncomplete". Check to "complete".
		$quickEditSymbol = (($task->isComplete()) ? "times" : "check");
		$taskCompleteClass = (($task->isComplete()) ? "complete" : "");

		return <<<HTML
            <div class="tl-task $taskCompleteClass">
                <div class="left">
                    <div class="tl-quick-edit" style="border-color: $taskColor;">
                        <a href="#"><i class="fa fa-$quickEditSymbol"></i></a>
                        <a href="#"><i class="fa fa-pencil"></i></a>
                        <a href="#"><i class="fa fa-trash"></i></a>
                    </div>
                </div>
                <label class="title" for="task-$taskHash">$taskTitle</label>
            </div>
HTML;
	}

	// View-specific methods
	/**
	 * Builds and returns the TagGroup organizer for the single tag view. Null-safe function
	 * (returns an empty timescope on error).
	 * @return TagGroup
	 */
	public static function getSingleTagViewTagGroup() {
		/** @var UserData $ud */
		$ud = Autoload::getInjector()->getInstance(UserData::class);

		$tagGroup = new TagGroup();

		// If for some reason, no one is logged in, return an empty tag group
		if (!$ud->isLoggedIn())
			return $tagGroup;

		// Grab the timescopes, tags, and tags
		$timescopes = $ud->getTimescopes();
		$tags = self::getRequestedTags();
		$tasks = self::getRequestedTasks();

		// pre-sort so my poor server doesn't have to work as hard later
		usort($timescopes, function(Timescope $a, Timescope $b) {
			return $a->compareChronological($b);
		});
		usort($tags, function(Tag $a, Tag $b) {
			return $a->compareAlphabetical($b);
		});
		usort($tasks, function(Task $a, Task $b) {
			return $a->compareChronological($b);
		});

		// Each Tag (and corresponding TagContainer) has its own set of Timescopes. Then add
		// the TagContainer to the TagGroup. Finally, add all tasks to the group.
		foreach ($tags as $tag) {
			$timescopeGroup = new TimescopeGroup();
			foreach ($timescopes as $timescope)
				$timescopeGroup->addTimescopeContainer(new TimescopeContainer($timescope));

			$tagGroup->addTagContainer(new TagContainer($tag, $timescopeGroup));
		}

		// Now add the tasks
		foreach ($tasks as $task)
			$tagGroup->addTask($task);

		return $tagGroup;
	}

	/**
	 * Builds and returns the logged in user's tasks in the form of a single list timescope group.
	 * Returns an empty TimescopeGroup on error
	 * @return TimescopeGroup
	 */
	public static function getSingleListViewTimescopeGroup() {
		/** @var UserData $ud */
		$ud = Autoload::getInjector()->getInstance(UserData::class);

		$timescopeGroup = new TimescopeGroup();

		// Return empty timescope group if we're not logged in
		if (!$ud->isLoggedIn())
			return $timescopeGroup;

		// Grab user data
		$timescopes = $ud->getTimescopes();
		$tasks = self::getRequestedTasks();

		// Sort all chrono
		usort($timescopes, function(Timescope $a, Timescope $b) {
			return $a->compareChronological($b);
		});
		usort($tasks, function(Task $a, Task $b) {
			return $a->compareChronological($b);
		});

		// Simply add each timescope as a timescope container to the timescope group, then add
		// the tasks
		foreach ($timescopes as $timescope)
			$timescopeGroup->addTimescopeContainer(new TimescopeContainer($timescope));
		foreach ($tasks as $task)
			$timescopeGroup->addTask($task);

		return $timescopeGroup;
	}
}
