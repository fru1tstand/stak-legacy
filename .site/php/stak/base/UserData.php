<?php
namespace stak\base;
require_once $_SERVER["DOCUMENT_ROOT"] . "/.site/php/stak/Autoload.php";

/**
 * Provides an interface to access user data like stored tasks, tags, settings, account info, etc.
 * @package stak
 */
interface UserData {

	// Authentication


	// Tag-specific commands


	// Task-specific commands
	public function getAllTasks();
}