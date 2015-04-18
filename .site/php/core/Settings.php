<?php
namespace core;

/**
 * Contains... well... static settings.
 * @package core
 */
class Settings {
	/**
	 * Set to true to enable debug mode. Enables debug message storage.
	 *
	 * Production: false
	 */
	const DEBUG = true;

	/**
	 * Set to true to enable inclusion of testing folders. (We don't want mocks and other tests
	 * inside our production environment)
	 *
	 * Production false
	 */
	const INCLUDE_TESTS = true;
}