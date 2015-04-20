<?php
namespace stak\base;
require_once $_SERVER["DOCUMENT_ROOT"] . "/.site/php/stak/Autoload.php";
use stak\base\userdata\TaskFilter;

/**
 * Provides an interface to access user data like stored tasks, tags, settings, account info, etc.
 * @package stak
 */
interface UserData {
	/**
	 * Gets tasks with the given filter. Pass null to get all tasks.
	 * @param TaskFilter $filter
	 * @return mixed
	 */
	public function getTasks(TaskFilter $filter = null);
}
