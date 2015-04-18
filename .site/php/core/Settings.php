<?php
namespace core;

/**
 * Defines settings for an instance of stak
 * @package core
 */
abstract class Settings {

	/* @var Settings */
	private static $settings;

	public static function setInstance(Settings $settings) {
		self::$settings = $settings;
	}


	// I provide a wrapper so that we're not passing a variable down the line. Cleaner seeing
	// Settings::* than $settings->* and having the possibility of writing over $settings.
	public static function getEnableDebug() {
		return self::$settings->enableDebug();
	}

	public static function getIncludeTests() {
		return self::$settings->includeTests();
	}


	// Implementor methods
	/**
	 * Sets up dependencies
	 */
	public abstract function setup();

	/**
	 * Enables debugging mode which allows debug messages to be stored.
	 * @return bool
	 */
	protected abstract function enableDebug();

	/**
	 * Set to true to enable inclusion of test folders. (We don't want mocks and other testing
	 * files in production)
	 * @return bool
	 */
	protected abstract function includeTests();
}