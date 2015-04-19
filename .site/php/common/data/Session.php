<?php
namespace common\data;

/**
 * Handles session data
 * @version 0.2
 */
class Session {
	const RESERVED_INDEX_NAME = "__fru1tme";
	const ACTIVE_SESSION_INDEX = "session-active";

	//Single static instance
	private function __construct() {}

	private static $hasSessionStarted = false;

	/**
	 * Starts a session if one doesn't already exist
	 * @param string $name The name of the session
	 */
	public static function start($name) {
		if (self::hasSessionStarted())
			return;

		session_name($name);
		session_start();

		if (!is_array($_SESSION))
			$_SESSION = [];

		if (!isset($_SESSION[self::RESERVED_INDEX_NAME])
				|| !is_array($_SESSION[self::RESERVED_INDEX_NAME]))
			$_SESSION[self::RESERVED_INDEX_NAME] = [];

		$_SESSION[self::RESERVED_INDEX_NAME][self::ACTIVE_SESSION_INDEX] = true;
		self::$hasSessionStarted = true;
	}

	/**
	 * Sets a session variable
	 * @param string $key The key to set
	 * @param mixed $value The value to store
	 * @return boolean False if the session doesn't exist; otherwise, true
	 */
	public static function set($key, $value) {
		if (!self::hasSessionStarted())
			return false;

		$_SESSION[$key] = serialize($value);
		return true;
	}

	/**
	 * Gets a session variable
	 * @param string $key The key to get
	 * @return NULL|mixed The value at key if both the key and session exist; otherwise, null
	 */
	public static function get($key) {
		if (!self::hasSessionStarted())
			return null;

		if (!isset($_SESSION[$key]))
			return null;

		return unserialize($_SESSION[$key]);
	}


	/**
	 * Deletes the given key
	 * @param string $key The key to delete
	 * @return boolean False if the session doesn't exist; otherwise, true
	 */
	public static function delete($key) {
		if (!self::hasSessionStarted())
			return false;

		$_SESSION[$key] = "";
		unset($_SESSION[$key]);

		return true;
	}

	/**
	 * Checks if a session with given name exists
	 * @return boolean True if the session is active; otherwise, false
	 */
	private static function hasSessionStarted() {
		//Quick single lookup check
		if (self::$hasSessionStarted)
			return true;

		//Session array check
		if (isset($_SESSION)
				&& is_array($_SESSION)
				&& isset($_SESSION[self::RESERVED_INDEX_NAME])
				&& is_array($_SESSION[self::RESERVED_INDEX_NAME])
				&& isset($_SESSION[self::RESERVED_INDEX_NAME][self::ACTIVE_SESSION_INDEX])
				&& $_SESSION[self::RESERVED_INDEX_NAME][self::ACTIVE_SESSION_INDEX])
			self::$hasSessionStarted = true;

		return self::$hasSessionStarted;
	}
}
?>