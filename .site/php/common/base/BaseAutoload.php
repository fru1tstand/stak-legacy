<?php
namespace common\base;

use common\data\Session;
use common\milk\inject\Injector;

/**
 * Class BaseAutoload
 * @package common\base
 */
abstract class BaseAutoload {
	/* @var Injector */
	private static $injector = null;

	/**
	 * Initializes the website.
	 * Sets up auto-loading, milk injector, and session.
	 * @param BaseAutoload $autoload
	 */
	public static function init(BaseAutoload $autoload) {
		// Set up auto-loading
		spl_autoload_register(function ($className) use ($autoload) {
			// Replace namespace backslashes with folder directory forward slashes
			$className = str_replace("\\", "/", $className);

			// Normal PHP path
			$path = $autoload->getPhpSourcePath() . "/" . $className . ".php";
			if (file_exists($path)) {
				/** @noinspection PhpIncludeInspection */
				include_once($path);
			}

			// PHPTests path
			$path = $autoload->getPhpSourcePath() . "tests/" . $className . ".php";
			if (file_exists($path)) {
				/** @noinspection PhpIncludeInspection */
				include_once($path);
			}
		});

		// Set up Milk
		self::$injector = $autoload->getMilkInjector();

		// Set up session
		/** @var BaseSettings $settings */
		$settings = self::getInjector()->getInstance(BaseSettings::class);
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