<?php
namespace common\base;

use common\data\Session;
use common\Milk\inject\Injector;

/**
 * Class AbstractAutoload
 * @package common\base
 */
abstract class AbstractAutoload {
	/* @var Injector */
	private static $injector = null;

	/**
	 * Initializes the website.
	 * Sets up auto-loading, Milk injector, and session.
	 * @param AbstractAutoload $autoload
	 */
	public static function init(AbstractAutoload $autoload) {
		// Set up auto-loading
		spl_autoload_register(function ($className) use ($autoload) {
			// Replace namespace backslashes with folder directory forward slashes
			$className = str_replace("\\", "/", $className);

			// Normal PHP path
			$path = $autoload->getPhpSourcePath() . "/" . $className . ".php";
			if (file_exists($path))
				include_once($path);

			// PHPTests path
			$path = $autoload->getPhpSourcePath() . "tests/" . $className . ".php";
			if (file_exists($path))
				include_once($path);
		});

		// Set up Milk
		self::$injector = $autoload->getMilkInjector();

		// Set up session
		/** @var AbstractSettings $settings */
		$settings = self::getInjector()->getInstance(AbstractSettings::class);
		Session::start($settings->getWebSessionName());
	}


	// Getters
	/**
	 * Gets the milk injector
	 * @return Injector
	 */
	public static function getInjector() {
		return self::$injector;
	}


	// Implementor methods
	/**
	 * Returns the php source path for the website
	 * @return string
	 */
	public abstract function getPhpSourcePath();

	/**
	 * Returns injector associated to the website
	 * @return Injector
	 */
	protected abstract function getMilkInjector();
}