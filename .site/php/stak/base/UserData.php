<?php
namespace stak\base;
require_once $_SERVER["DOCUMENT_ROOT"] . "/.site/php/stak/Autoload.php";
use stak\base\userdata\TaskFilter;
use stak\base\userdata\TagFilter;

/**
 * Provides an interface to access user data like stored tasks, tags, settings, account info, etc.
 * @package stak
 */
interface UserData {

	// Login / User Validation methods
	/**
	 * Returns if the user is logged in or not.
	 * @return bool
	 */
	public static function isLoggedIn();

	/**
	 * Returns the current logged in user's account. Returns null if no user is logged in.
	 * @return mixed
	 */
	public static function getLoggedInUser();


	// Tag methods
	/**
	 * Gets all tags the current logged in user owns. Returns an empty array if no user is logged
	 * in.
	 * @param TagFilter $filter Used to filter result tag set.
	 * @return Tag[]
	 */
	public static function getTags(TagFilter $filter = null);


	// Task methods
	/**
	 * Gets all tasks the current logged in user owns. Returns an empty array if no user is
	 * logged in.
	 * @param TaskFilter $filter Used to filter result task set.
	 * @return Task[]
	 */
	public static function getTasks(TaskFilter $filter = null);


	// Other
	/**
	 * Gets the user's UTC timezone
	 * @return int
	 */
	public static function getTimezone();

	/**
	 * Gets the user's timescopes
	 * @return Timescope[]
	 */
	public static function getTimescopes();
}
