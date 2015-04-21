<?php
namespace stak\base;
require_once $_SERVER["DOCUMENT_ROOT"] . "/.site/php/stak/Autoload.php";
use stak\base\userdata\TaskFilter;

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

	// Task methods
	/**
	 * Retrieves an array of tasks that conform to the given filter for the logged in user.
	 * Returns an empty array if no user is logged in.
	 * @param TaskFilter $filter
	 * @return Task[]
	 */
	public static function getTasks(TaskFilter $filter = null);
}
