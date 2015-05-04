<?php
namespace stak;
require_once $_SERVER["DOCUMENT_ROOT"] . "/.site/php/stak/Autoload.php";
use stak\filters\TagFilter;
use stak\filters\TaskFilter;
use stak\foundation\Tag;
use stak\foundation\Task;
use stak\foundation\Timescope;
use stak\foundation\MockTag;
use stak\foundation\MockTask;
use stak\foundation\MockTimescope;

/**
 * Mock implementation of UserData for testing
 * @package stak
 */
class MockUserData implements UserData {
	private static $cachedTags = null;
	private static $cachedTasks = null;
	private static $cachedTimescopes = null;

	/**
	 * Returns if the user is logged in or not.
	 * @return bool
	 */
	public static function isLoggedIn() {
		return true;
	}

	/**
	 * As a mock, we don't have a user. Also, I haven't coded in a user class so... that's a
	 * thing too.
	 * @return mixed
	 */
	public static function getLoggedInUser() {
		return true;
	}

	/**
	 * Gets a set of take tags. Currently ignores filter.
	 * @param TagFilter $filter
	 * @return Tag[]
	 */
	public static function getTags(TagFilter $filter = null) {
		// Create tags if not created already
		if (is_null(self::$cachedTags)) {
			$schoolTag = new MockTag("School tag that's very long & will run off the page. "
									 . "Consequently this tag is also the maximum length in "
									 . "character which is 128", "99F");
			$importantTag = new MockTag("Important", "F00");
			$projectsTag = new MockTag("Projects", "9F9");
			/** @noinspection HtmlUnknownTag */
			$qaTag = new MockTag("Th!s <will> <break> !@$&^*^)*()[]\{\}<><> \"everything'!!",
					"000");
			self::$cachedTags = array($schoolTag, $importantTag, $projectsTag, $qaTag);
		}

		return self::$cachedTags;
	}

	/**
	 * Gets a set of fake tasks. Currently ignores filters.
	 * @param TaskFilter $filter
	 * @return mixed
	 */
	public static function getTasks(TaskFilter $filter = null) {
		// Get tags
		$tags = self::getTags();
		$schoolTag = $tags[0];
		$importantTag = $tags[1];
		$projectsTag = $tags[2];
		$qaTag = $tags[3];

		// Create tasks
		if (is_null(self::$cachedTasks)) {
			$musicTask =
					new MockTask("Music task that is pretty much going to be an essay because 512"
								 . " characters is really long. I may consider shortening the "
								 . "maximum title length because honestly, 512 is the size of my "
								 . "IT tech paper that was due not too long ago and that was about"
								 . " the size of a single page. The rest of this will probably be "
								 . "lorem ipsum if I can't think of anything else to type. May as "
								 . "well abuse the rest of the space with some garbage text. Man "
								 . "music is really great. Well anyway, here approaches 512 "
								 . "characters, the max length.",
							"Do I really want to make a description?",
							time() - 86400,
							null,
							$schoolTag,
							array($schoolTag, $importantTag),
							Task::TYPE_NORMAL);
			$musicProjectTask = new MockTask("Music Project",
					"Giant music project overarching whatever",
					time() + 86400 * 14,
					null,
					$schoolTag,
					array($schoolTag, $importantTag, $projectsTag),
					Task::TYPE_NORMAL);
			$musicProjectReminder = new MockTask("Music Project Reminder",
					"A reminder to do the giant music project",
					time() + 86400 * 7,
					null,
					$schoolTag,
					array($schoolTag, $importantTag, $projectsTag),
					Task::TYPE_REMINDER);
			$musicProjectReminder2 = new MockTask("Music Project Reminder",
					"A reminder to do the giant music project",
					time() + 86400 * 3,
					null,
					$schoolTag,
					array($schoolTag, $importantTag, $projectsTag),
					Task::TYPE_REMINDER);
			$webassignContainer = new MockTask("Webassign",
					"",
					null,
					null,
					$schoolTag,
					array($schoolTag),
					Task::TYPE_CONTAINER);
			$webassign1 = new MockTask("Physics Webassign 4, 5, 6, 20-30",
					"",
					time(),
					time() + 300,
					$schoolTag,
					array($schoolTag),
					Task::TYPE_NORMAL);
			$webassign2 = new MockTask("Physics Webassign 2, 4, 6-30",
					"",
					time() + 86400,
					null,
					$schoolTag,
					array($schoolTag),
					Task::TYPE_NORMAL);
			$webassign3 = new MockTask("Physics Webassign 1-3, 6+",
					"",
					time() + 86400 * 2,
					null,
					$schoolTag,
					array($schoolTag),
					Task::TYPE_NORMAL);
			$shedProject = new MockTask("Build a shed",
					"I mean, you gotta build yer shed",
					time() + 86400 * 5,
					null,
					$qaTag,
					array($qaTag),
					Task::TYPE_NORMAL);

			// Build associations
			$musicProjectTask->addChild($musicTask);
			$musicTask->addChildren(array(&$musicProjectReminder, &$musicProjectReminder2));
			$webassignContainer->addChildren(array(&$webassign1, &$webassign2, &$webassign3));

			self::$cachedTasks = array($musicTask, $musicProjectTask, $musicProjectReminder,
					$musicProjectReminder2, $webassignContainer, $webassign1, $webassign2,
					$webassign3, $shedProject);
		}

		return self::$cachedTasks;
	}

	/**
	 * Gets the user's timezone
	 * @return int
	 */
	public static function getTimezone() {
		return -8;
	}

	/**
	 * Gets the user's timescopes
	 * @return Timescope[]
	 */
	public static function getTimescopes() {
		if (is_null(self::$cachedTimescopes)) {
			$today = new MockTimescope("Today", 0, false, 1, false, false, false, true);
			$thisWeek = new MockTimescope("This Week", 0, false, 7, false, false, true, true);
			$overdue = new MockTimescope("Overdue", 0, true, 0, false, true, true, true);
			$everythingElse = new MockTimescope("Everything Else", 7, false, 0, true, true, true,
					false);
			self::$cachedTimescopes = array($today, $thisWeek, $overdue, $everythingElse);
		}
		return self::$cachedTimescopes;
	}

}
