<?php
namespace stak\template\processors;
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

require_once $_SERVER['DOCUMENT_ROOT'] . '/.site/php/stak/Autoload.php';

/**
 * The processing backend for the List template
 * @package stak\template\processors
 */
class ListProcessor {
	/**
	 * Fetches the requested view
	 */
	public static function showRequestedTasklistView() {
		//TODO: Correctly get view from settings
		$view = (isset($_GET['view'])) ? $_GET['view'] : '';
		switch ($view) {
			case "multitag":
				self::showMultiTagView();
				break;
			case "singlelist":
				self::showSingleListView();
				break;
			default:
				self::showSingleTagView();
				break;
		}
	}

	private static function getRequestedTasks() {
		// TODO: Correctly fetch requested tasks (was a filter applied?)

		/** @var UserData $ud */
		$ud = Autoload::getInjector()->getInstance(UserData::class);
		return $ud::getTasks();
	}

	private static function getRequestedTags() {
		// TODO: Correctly fetch requested tags (was a filter applied?)

		/** @var UserData $ud */
		$ud = Autoload::getInjector()->getInstance(UserData::class);
		return $ud::getTags();
	}

	/**
	 * Multi-tag mode. Each tag has its own tasklist and timescopes. All tags are displayed within
	 * the viewstyle container.
	 */
	private static function showMultiTagView() {
		TemplateUtils::includeFromContentLocation("/listpage/MultiTagView.php");
	}

	/**
	 * Single list mode. All tasks are shown in a single list
	 */
	private static function showSingleListView() {
		TemplateUtils::includeFromContentLocation("/listpage/SingleListView.php");
	}

	/**
	 * Single tag mode. Displays a list of tags in which the user can click a single tag and
	 * display only that tag's tasks.
	 */
	private static function showSingleTagView() {
		TemplateUtils::includeFromContentLocation("/listpage/SingleTagView.php");
	}

	// Single Tag View
	/**
	 * Builds and returns the TagGroup organizer for the single tag view
	 */
	public static function getTagGroup() {
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

		// Create a container for each tag, each with their own TimescopeGroup consisting of the
		// same array of timescopes
		foreach ($tags as $tag) {
			$timescopeContainers = array();
			foreach ($timescopes as $timescope)
				$timescopeContainers[] = new TimescopeContainer($timescope);

			$tagGroup->addTagContainer(
					new TagContainer($tag,
							new TimescopeGroup($timescopeContainers)));
		}

		// Now add the tasks
		foreach ($tasks as $task)
			$tagGroup->addTask($task);

		// That's it!
		return $tagGroup;
	}
}
