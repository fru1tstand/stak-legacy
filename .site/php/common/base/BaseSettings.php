<?php
namespace common\base;

abstract class BaseSettings {
	/**
	 * Determines if debugging is enabled. Mainly used for debug messages, but also has some
	 * other side effects.
	 * @return bool
	 */
	public abstract function enableDebug();

	/**
	 * Gets the web session name to use
	 * @return string
	 */
	public abstract function getWebSessionName();
}